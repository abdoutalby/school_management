<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\ClassRoom;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        $subjects = [
            [
                'name' => 'Mathematics',
                'code' => 'MATH101'
            ],
            [
                'name' => 'English',
                'code' => 'ENG101'
            ],
            [
                'name' => 'Science',
                'code' => 'SCI101'
            ],
            [
                'name' => 'History',
                'code' => 'HIS101'
            ],
        ];

        $teachers = Teacher::all();
        $classes = ClassRoom::all();

        foreach ($subjects as $index => $subject) {
            Subject::create([
                'name' => $subject['name'],
                'class_room_id' => $classes[$index % count($classes)]->id,
                'teacher_id' => $teachers[$index % count($teachers)]->id,
            ]);
        }
    }
} 