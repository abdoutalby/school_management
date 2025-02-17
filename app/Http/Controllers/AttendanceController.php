<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $classes = $user->hasRole('teacher') 
            ? ClassRoom::where('teacher_id', $user->teacher->id)->with('subjects')->get()
            : ClassRoom::with('subjects')->get();

        // Get subjects for the selected class
        $subjects = [];
        if (request('class_id')) {
            $class = ClassRoom::find(request('class_id'));
            $subjects = $class ? $class->subjects : collect();
        }

        $query = Attendance::with([
            'student.user',
            'student.class_room',
            'subject'
        ]);

        // Filter by class
        if (request('class_id')) {
            $query->whereHas('student', function($q) {
                $q->where('class_id', request('class_id'));
            });
        }

        // Filter by subject
        if (request('subject_id')) {
            $query->where('subject_id', request('subject_id'))
                ->whereHas('subject.class_rooms', function($q) {
                    $q->where('class_rooms.id', request('class_id'));
                });
        }

        // Filter by date
        if (request('date')) {
            $query->whereDate('date', request('date'));
        }

        // Get the filtered attendances
        $attendances = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('Attendance/Index', [
            'classes' => $classes,
            'subjects' => $subjects,
            'attendances' => $attendances,
            'filters' => request()->only(['class_id', 'subject_id', 'date'])
        ]);
    }

    public function getStudentsByClass(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date'
        ]);

        $students = ClassRoom::find($validated['class_id'])
            ->students()
            ->with(['user', 'class_room'])
            ->get()
            ->map(function($student) use ($validated) {
                $attendance = Attendance::where([
                    'student_id' => $student->id,
                    'subject_id' => $validated['subject_id'],
                    'date' => $validated['date']
                ])->first();

                return [
                    'id' => $student->id,
                    'name' => $student->user->name,
                    'class' => $student->class_room->name,
                    'status' => $attendance ? $attendance->status : 'present'
                ];
            });

        return response()->json([
            'students' => $students
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.status' => 'required|in:present,absent,late'
        ]);

        foreach ($validated['attendances'] as $attendance) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $attendance['student_id'],
                    'subject_id' => $validated['subject_id'],
                    'date' => $validated['date']
                ],
                ['status' => $attendance['status']]
            );
        }

        return back()->with('success', 'Attendance recorded successfully.');
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'status' => 'required|in:present,absent,late',
        ]);

        $attendance->update($validated);

        return back()->with('success', 'Attendance updated successfully.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return back()->with('success', 'Attendance deleted successfully.');
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.status' => 'required|in:present,absent,late',
        ]);

        foreach ($validated['attendances'] as $attendance) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $attendance['student_id'],
                    'subject_id' => $validated['subject_id'],
                    'date' => $validated['date'],
                ],
                [
                    'status' => $attendance['status']
                ]
            );
        }

        return back()->with('success', 'Attendance recorded successfully.');
    }
} 