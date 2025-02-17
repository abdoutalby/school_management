<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    public function run()
    {
        $students = Student::all();
        $subjects = Subject::all();
        
        $grades = [
            'A' => [90, 100],
            'B' => [80, 89],
            'C' => [70, 79],
            'D' => [60, 69],
        ];

        foreach ($students as $student) {
            foreach ($subjects as $subject) {
                $gradeKey = array_rand($grades);
                $score = rand($grades[$gradeKey][0], $grades[$gradeKey][1]);
                
                Grade::create([
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'score' => $score,
                    'grade' => $gradeKey
                ]);
            }
        }
    }
} 