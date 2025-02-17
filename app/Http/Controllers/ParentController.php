<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ParentModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class ParentController extends Controller
{
    public function index()
    {
        return Inertia::render('Parents/Index', [
            'parents' => ParentModel::with(['user', 'students.user'])
                ->when(request('search'), function($query, $search) {
                    $query->whereHas('user', function($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhere('relationship', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate(10)
                ->withQueryString(),
            'filters' => request()->only(['search'])
        ]);
    }

    public function create()
    {
        return Inertia::render('Parents/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'relationship' => 'required|string|max:50',
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make('password'), // Default password
            'phone' => $validated['phone'],
        ]);

        $user->assignRole('parent');

        // Create parent
        ParentModel::create([
            'user_id' => $user->id,
            'address' => $validated['address'],
            'relationship' => $validated['relationship'],
        ]);

        return redirect()->route('parents.index')
            ->with('success', 'Parent created successfully.');
    }

    public function edit(ParentModel $parent)
    {
        return Inertia::render('Parents/Edit', [
            'parent' => $parent->load('user'),
        ]);
    }

    public function update(Request $request, ParentModel $parent)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$parent->user->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'relationship' => 'required|string|max:50',
        ]);

        // Update user
        $parent->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        // Update parent
        $parent->update([
            'address' => $validated['address'],
            'relationship' => $validated['relationship'],
        ]);

        return redirect()->route('parents.index')
            ->with('success', 'Parent updated successfully.');
    }

    public function destroy(ParentModel $parent)
    {
        $user = $parent->user;
        $parent->delete();
        $user->delete();

        return redirect()->route('parents.index')
            ->with('success', 'Parent deleted successfully.');
    }
} 