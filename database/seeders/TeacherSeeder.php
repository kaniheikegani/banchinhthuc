<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            ['name' => 'Thầy Nguyễn Văn A', 'email' => 'nguyenvana@kani.edu.vn'],
            ['name' => 'Cô Trần Thị B', 'email' => 'tranthib@kani.edu.vn'],
            ['name' => 'Thầy Lê Văn C', 'email' => 'levanc@kani.edu.vn'],
            ['name' => 'Cô Phạm Thị D', 'email' => 'phamthid@kani.edu.vn'],
            ['name' => 'Thầy Nguyễn Văn E', 'email' => 'nguyenvane@kani.edu.vn'],
            ['name' => 'Cô Trần Thị F', 'email' => 'tranthif@kani.edu.vn'],
            ['name' => 'Thầy Lê Văn G', 'email' => 'levang@kani.edu.vn'],
            ['name' => 'Cô Phạm Thị H', 'email' => 'phamthih@kani.edu.vn'],
            ['name' => 'Thầy Nguyễn Văn I', 'email' => 'nguyenvani@kani.edu.vn'],
            ['name' => 'Cô Trần Thị K', 'email' => 'tranthik@kani.edu.vn'],
        ];

        foreach ($teachers as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('12345678'),
                    'role' => 'teacher',
                    'approved' => true,
                ]
            );

            // Gán role teacher bằng Spatie
            $user->assignRole('teacher');
        }
    }
}