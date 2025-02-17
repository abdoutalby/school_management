<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\ParentModel;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        $roles = Role::all();
        
        // Debug output
        \Log::info('Fetched roles for registration:', [
            'count' => $roles->count(),
            'roles' => $roles->toArray()
        ]);

        return Inertia::render('Auth/Register', [
            'roles' => $roles
        ]);
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'exists:roles,name'],
            'phone'=> 'required|string|max:13',

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone'=>$request->phone,
         ]);

        $user->assignRole($request->role);
        switch ($request['role']) {
            case 'teacher':
                Teacher::create(['user_id' => $user->id]);
                break;
            case 'student':
                Student::create(['user_id' => $user->id]);
                break;
            case 'parent':
                ParentModel::create(['user_id' => $user->id]);
                break;
        }
     
    
        event(new Registered($user));
        Auth::login($user);
        
        return redirect(RouteServiceProvider::HOME);
    }
} 