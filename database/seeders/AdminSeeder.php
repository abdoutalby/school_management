<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'phone' => '123456789',
            'email_verified_at' => now(),
        ]);

        // Make sure we have the admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Assign admin role to user
        $admin->assignRole('admin');
    }
} 