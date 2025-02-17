<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        $students = Student::all();
        $subjects = Subject::all();
        $statuses = ['present', 'absent', 'late'];
        
        // Create attendance records for the last 5 days
        for ($i = 0; $i < 5; $i++) {
            $date = now()->subDays($i)->format('Y-m-d');
            
            foreach ($students as $student) {
                foreach ($subjects as $subject) {
                    // 70% chance of present, 20% chance of late, 10% chance of absent
                    $rand = rand(1, 100);
                    $status = $rand <= 70 ? 'present' : ($rand <= 90 ? 'late' : 'absent');
                    
                    Attendance::create([
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'date' => $date,
                        'status' => $status
                    ]);
                }
            }
        }
    }
} 