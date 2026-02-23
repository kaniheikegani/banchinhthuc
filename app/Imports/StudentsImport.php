<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Classroom;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Spatie\Permission\Models\Role;

class StudentsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows->skip(1) as $row) {
            $name = trim($row[0]);
            $studentCode = strtoupper(trim($row[1])); // chuẩn hóa mã học sinh
            $dob = trim($row[2]);
            $email = strtolower(trim($row[3])); // chuẩn hóa email
            $className = trim($row[4]);

            // Kiểm tra trùng mã học sinh
            if (User::where('student_code', $studentCode)->exists()) {
                continue; // bỏ qua nếu đã tồn tại
            }

            // Tìm hoặc tạo lớp
            $classroom = Classroom::firstOrCreate(['name' => $className]);

            // Tạo tài khoản học sinh
            $user = User::create([
                'name' => $name,
                'student_code' => $studentCode,
                'email' => $email ?: null,
                'password' => Hash::make('kani_' . $studentCode), // ✅ không còn khoảng trắng
                'dob' => $dob,
                'approved' => true,
            ]);

            $user->assignRole('student');

            // Gắn vào lớp
            $user->classroom_id = $classroom->id;
            $user->save();
        }
    }
}