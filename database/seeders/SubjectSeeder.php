<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $subjects = ['Toán', 'Văn', 'Anh', 'Lý', 'Hóa', 'Sinh', 'Sử', 'Địa', 'Tin', 'GDCD', 'Chào cờ', 'Sinh hoạt lớp'];

        foreach ($subjects as $name) {
            \App\Models\Subject::firstOrCreate(['name' => $name]);
        }
    }
}
