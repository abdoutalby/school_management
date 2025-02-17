<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubjectController extends Controller
{
    public function index()
    {
        return Inertia::render('Subjects/Index', [
            'subjects' => Subject::with(['teacher.user', 'classRoom'])
                ->when(request('search'), function($query, $search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhereHas('teacher.user', function($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('classRoom', function($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                })
                ->latest()
                ->paginate(10)
                ->withQueryString(),
            'filters' => request()->only(['search'])
        ]);
    }

    public function create()
    {
        return Inertia::render('Subjects/Create', [
            'teachers' => Teacher::with('user')->get(),
            'classes' => ClassRoom::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subjects',
            'teacher_id' => 'nullable|exists:teachers,id',
            'class_room_id' => 'required|exists:classes,id',
        ]);

        Subject::create($validated);

        return redirect()->route('subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    public function edit(Subject $subject)
    {
        return Inertia::render('Subjects/Edit', [
            'subject' => $subject->load(['teacher.user', 'classRoom']),
            'teachers' => Teacher::with('user')->get(),
            'classes' => ClassRoom::all()
        ]);
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,'.$subject->id,
            'teacher_id' => 'nullable|exists:teachers,id',
            'class_room_id' => 'required|exists:classes,id',
        ]);

        $subject->update($validated);

        return redirect()->route('subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }
} 