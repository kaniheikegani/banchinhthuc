<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Trường THPT Kani</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!-- Header -->
  <header class="bg-primary text-white text-center py-4">
    <h1>{{ $contents['school_name'] ?? 'Trường THPT Kani' }}</h1>
    <p>{{ $contents['slogan'] ?? 'Nơi chắp cánh ước mơ học sinh' }}</p>
  </header>
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            🎓 Xin chào {{ $student->name }} — Lớp {{ $classroom->name ?? 'Chưa rõ' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="mb-4 text-lg font-bold text-gray-700 dark:text-gray-100">📅 Thời khoá biểu</h3>

            @php
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                $sessions = ['morning' => 'Sáng', 'afternoon' => 'Chiều'];
            @endphp

            <table class="table table-bordered bg-white shadow-sm rounded">
                <thead class="bg-light">
                    <tr>
                        <th>Thứ</th>
                        <th>Buổi</th>
                        <th>Giáo viên & Môn học</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($days as $day)
                        @foreach($sessions as $key => $label)
                            @php
                                $schedule = $schedules->first(function ($item) use ($day, $key) {
                                    return $item->day === $day && $item->session === $key;
                                });
                                $subjects = $schedule?->subjects ?? [];
                            @endphp
                            <tr>
                                <td>{{ $day }}</td>
                                <td>{{ $label }}</td>
                                <td>
                                    @if(empty($subjects))
                                        <span class="text-muted">Không có môn học</span>
                                    @else
                                        <ul class="mb-0">
                                            @foreach($subjects as $subject)
                                                @if(is_array($subject))
                                                    <li><strong>{{ $subject['teacher'] ?? 'Chưa rõ' }}</strong> — dạy {{ $subject['name'] ?? 'Môn chưa rõ' }}</li>
                                                @else
                                                    <li>Giáo viên chưa rõ — dạy {{ $subject }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
</body>
</html>