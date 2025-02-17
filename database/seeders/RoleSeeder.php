<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Clear existing roles
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $roles = ['admin', 'teacher', 'student', 'parent'];
        
        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
                'guard_name' => 'web'
            ]);
        }
        
        // Verify roles were created
        $createdRoles = Role::all();
        \Log::info('Roles created:', [
            'count' => $createdRoles->count(),
            'roles' => $createdRoles->toArray()
        ]);
    }
}
    