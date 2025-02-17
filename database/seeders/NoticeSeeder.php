<?php

namespace Database\Seeders;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Database\Seeder;

class NoticeSeeder extends Seeder
{
    public function run()
    {
        $admin = User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->first();

        $notices = [
            [
                'title' => 'School Holiday Notice',
                'message' => 'School will be closed for spring break from March 20-27',
                'audience' => 'all'
            ],
            [
                'title' => 'Parent-Teacher Meeting',
                'message' => 'Parent-teacher meetings will be held next Friday',
                'audience' => 'parents'
            ],
            [
                'title' => 'Exam Schedule',
                'message' => 'Final exams will begin on April 15th',
                'audience' => 'students'
            ]
        ];

        foreach ($notices as $notice) {
            Notice::create([
                'user_id' => $admin->id,
                'title' => $notice['title'],
                'message' => $notice['message'],
                'audience' => $notice['audience']
            ]);
        }
    }
} 