<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Subject;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AssignmentController extends Controller
{
    public function index()
    {
        return Inertia::render('Assignments/Index', [
            'assignments' => Assignment::with(['subject', 'class'])
                ->latest()
                ->paginate(10)
        ]);
    }

    public function create()
    {
        return Inertia::render('Assignments/Create', [
            'subjects' => Subject::all(),
            'classes' => ClassRoom::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'due_date' => 'required|date',
            'max_score' => 'required|numeric|min:0'
        ]);

        Assignment::create($validated);

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment created successfully.');
    }

    public function edit(Assignment $assignment)
    {
        return Inertia::render('Assignments/Edit', [
            'assignment' => $assignment->load(['subject', 'class']),
            'subjects' => Subject::all(),
            'classes' => ClassRoom::all()
        ]);
    }

    public function update(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'due_date' => 'required|date',
            'max_score' => 'required|numeric|min:0'
        ]);

        $assignment->update($validated);

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment updated successfully.');
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('assignments.index')
            ->with('success', 'Assignment deleted successfully.');
    }
} 