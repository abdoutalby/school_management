<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\ParentModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        return Inertia::render('Students/Index', [
            'students' => Student::with(['user', 'class', 'parent.user'])
                ->whereHas('user', function($query) {
                    $query->when(request('search'), function($query, $search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                })
                ->orWhereHas('class', function($query) {
                    $query->when(request('search'), function($query, $search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
                })
                ->orWhere('student_id', 'like', '%'.request('search').'%')
                ->latest()
                ->paginate(10)
                ->withQueryString(),
            'filters' => request()->only(['search'])
        ]);
    }

    public function create()
    {
        return Inertia::render('Students/Create', [
            'classes' => ClassRoom::all(),
            'parents' => ParentModel::with('user')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'parent_id' => 'nullable|exists:parents,id',
            'class_id' => 'nullable|exists:classes,id',
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'required|date',
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make('password'), // Default password
            'phone' => $validated['phone'],
        ]);

        $user->assignRole('student');

        // Create student
        $student = Student::create([
            'user_id' => $user->id,
            'student_id' => 'STU' . str_pad(Student::count() + 1, 4, '0', STR_PAD_LEFT),
            'parent_id' => $validated['parent_id'],
            'class_id' => $validated['class_id'],
            'gender' => $validated['gender'],
            'date_of_birth' => $validated['date_of_birth'],
        ]);

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    public function edit(Student $student)
    {
        return Inertia::render('Students/Edit', [
            'student' => $student->load(['class', 'parent']),
            'classes' => ClassRoom::all(),
            'parents' => ParentModel::all()
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,'.$student->id,
            'parent_id' => 'required|exists:parents,id',
            'class_id' => 'required|exists:classes,id',
            'admission_number' => 'required|unique:students,admission_number,'.$student->id,
            'admission_date' => 'required|date'
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
} 