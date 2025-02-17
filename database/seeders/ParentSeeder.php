<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ParentModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ParentSeeder extends Seeder
{
    public function run()
    {
        $parents = [
            [
                'name' => 'David Johnson',
                'email' => 'david@example.com',
                'address' => '123 Main St',
                'relationship' => 'Father'
            ],
            [
                'name' => 'Mary Williams',
                'email' => 'mary@example.com',
                'address' => '456 Oak Ave',
                'relationship' => 'Mother'
            ],
        ];

        foreach ($parents as $parent) {
            $user = User::create([
                'name' => $parent['name'],
                'email' => $parent['email'],
                'password' => Hash::make('password'),
                'phone' => '123456789',
            ]);

            $user->assignRole('parent');

            ParentModel::create([
                'user_id' => $user->id,
                'address' => $parent['address'],
                'relationship' => $parent['relationship']
            ]);
        }
    }
} 