<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class ClassRoomSeeder extends Seeder
{
    public function run()
    {
        $classes = [
            [
                'name' => 'Class 1A',
                'grade_level' => '1',
                'capacity' => 30,
                'academic_year' => '2024-2025'
            ],
            [
                'name' => 'Class 2B',
                'grade_level' => '2',
                'capacity' => 25,
                'academic_year' => '2024-2025'
            ],
            [
                'name' => 'Class 3C',
                'grade_level' => '3',
                'capacity' => 28,
                'academic_year' => '2024-2025'
            ],
        ];

        $teachers = Teacher::all();

        foreach ($classes as $index => $class) {
            ClassRoom::create([
                'name' => $class['name'],
                'grade_level' => $class['grade_level'],
                'teacher_id' => $teachers[$index % count($teachers)]->id,
                'capacity' => $class['capacity'],
                'academic_year' => $class['academic_year']
            ]);
        }
    }
} 