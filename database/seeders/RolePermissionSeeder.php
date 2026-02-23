<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
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
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        $student = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        $student->syncPermissions([
            'view fanpage',
            'view notification',
            'view manage student',
        ]);

        $teacher = Role::firstOrCreate(['name' => 'teacher', 'guard_name' => 'web']);
        $teacher->syncPermissions([
            'view fanpage',
            'grade student',
            'send notification to admin',
            'send notification to student',
            'manage classroom',
        ]);

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions([
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

        $this->command->info('Roles and permissions seeded successfully.');
    }
}