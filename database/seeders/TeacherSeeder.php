<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $teachers = [
            [
                'name' => 'John Smith',
                'email' => 'john@school.com',
                'subject' => 'Mathematics'
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah@school.com',
                'subject' => 'English'
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael@school.com',
                'subject' => 'Science'
            ],
        ];

        foreach ($teachers as $teacher) {
            $user = User::create([
                'name' => $teacher['name'],
                'email' => $teacher['email'],
                'password' => Hash::make('password'),
                'phone' => '123456789',
            ]);

            $user->assignRole('teacher');

            Teacher::create([
                'user_id' => $user->id,
                'subject_specialization' => $teacher['subject']
            ]);
        }
    }
} 