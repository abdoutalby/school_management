<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\ParentModel;
use App\Models\ClassRoom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $classes = ClassRoom::all();
        $parents = ParentModel::all();

        $students = [
            [
                'name' => 'Alex Johnson',
                'email' => 'alex@school.com',
                'gender' => 'Male',
                'date_of_birth' => '2010-05-15'
            ],
            [
                'name' => 'Emma Williams',
                'email' => 'emma@school.com',
                'gender' => 'Female',
                'date_of_birth' => '2011-03-22'
            ],
            [
                'name' => 'James Brown',
                'email' => 'james@school.com',
                'gender' => 'Male',
                'date_of_birth' => '2010-11-30'
            ],
        ];

        foreach ($students as $index => $student) {
            $user = User::create([
                'name' => $student['name'],
                'email' => $student['email'],
                'password' => Hash::make('password'),
                'phone' => '123456789',
            ]);

            $user->assignRole('student');

            Student::create([
                'user_id' => $user->id,
                'student_id' => 'STU' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'gender' => $student['gender'],
                'date_of_birth' => $student['date_of_birth'],
                'parent_id' => $parents[$index % count($parents)]->id,
                'class_id' => $classes[$index % count($classes)]->id,
            ]);
        }
    }
} 