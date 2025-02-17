<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NoticeController extends Controller
{
    public function index()
    {
        return Inertia::render('Notices/Index', [
            'notices' => Notice::with('class')
                ->latest()
                ->paginate(10)
        ]);
    }

    public function create()
    {
        return Inertia::render('Notices/Create', [
            'classes' => ClassRoom::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'publish_date' => 'required|date',
            'expiry_date' => 'required|date|after:publish_date'
        ]);

        Notice::create($validated);

        return redirect()->route('notices.index')
            ->with('success', 'Notice created successfully.');
    }

    public function edit(Notice $notice)
    {
        return Inertia::render('Notices/Edit', [
            'notice' => $notice->load('class'),
            'classes' => ClassRoom::all()
        ]);
    }

    public function update(Request $request, Notice $notice)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'publish_date' => 'required|date',
            'expiry_date' => 'required|date|after:publish_date'
        ]);

        $notice->update($validated);

        return redirect()->route('notices.index')
            ->with('success', 'Notice updated successfully.');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();
        return redirect()->route('notices.index')
            ->with('success', 'Notice deleted successfully.');
    }
} 