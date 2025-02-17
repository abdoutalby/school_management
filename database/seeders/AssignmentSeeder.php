<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    public function run()
    {
        $subjects = Subject::all();
        
        $assignments = [
            [
                'title' => 'Math Homework 1',
                'description' => 'Complete exercises 1-10 from Chapter 3',
                'due_date' => now()->addDays(7)
            ],
            [
                'title' => 'English Essay',
                'description' => 'Write a 500-word essay about your favorite book',
                'due_date' => now()->addDays(14)
            ],
            [
                'title' => 'Science Project',
                'description' => 'Create a model of the solar system',
                'due_date' => now()->addDays(21)
            ]
        ];

        foreach ($assignments as $assignment) {
            Assignment::create([
                'title' => $assignment['title'],
                'description' => $assignment['description'],
                'due_date' => $assignment['due_date'],
                'subject_id' => $subjects->random()->id
            ]);
        }
    }
} 