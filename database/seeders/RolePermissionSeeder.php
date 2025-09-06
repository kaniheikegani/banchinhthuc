<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo các quyền
        $permissions = [
            'view fanpage',
            'view notification',
            'view manage student',
            'post to fanpage',
            'manage grades',
            'manage leave requests',
            'manage notifications',
            'grade student',
            'send notification to admin',
            'send notification to student',
            'manage classroom',
            'edit student information'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Tạo vai trò student
        $student = Role::firstOrCreate(['name' => 'student']);
        $student->givePermissionTo([
            'view fanpage',
            'view notification',
            'view manage student',
        ]);

        // Tạo vai trò teacher
        $teacher = Role::firstOrCreate(['name' => 'teacher']);
        $teacher->givePermissionTo([
            'view fanpage',
            'grade student',
            'send notification to admin',
            'send notification to student',
            'manage classroom',
        ]);

        // Tạo vai trò admin
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo([
            'view fanpage',
            'view notification',
            'view manage student',
            'post to fanpage',
            'manage grades',
            'manage leave requests',
            'manage notifications',
            'manage classroom',
            'edit student information'
        ]);
    }
}