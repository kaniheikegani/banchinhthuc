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
            📊 Bảng điểm của {{ $student->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($scores->isEmpty())
                <div class="alert alert-info">Bạn chưa có điểm nào được duyệt.</div>
            @else
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Môn học</th>
                            <th>Điểm miệng</th>
                            <th>Thái độ</th>
                            <th>Giữa kỳ</th>
                            <th>Cuối kỳ</th>
                            <th>Điểm tổng kết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scores as $index => $score)
                            @php
                                $oral     = $score->oral ?? 0;
                                $attitude = $score->attitude ?? 0;
                                $midterm  = $score->midterm ?? 0;
                                $final    = $score->final ?? 0;
                                $average  = round(($oral + $attitude + ($midterm * 2) + ($final * 3)) / 7, 1);
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $score->subject }}</td>
                                <td>{{ $score->oral ?? '-' }}</td>
                                <td>{{ $score->attitude ?? '-' }}</td>
                                <td>{{ $score->midterm ?? '-' }}</td>
                                <td>{{ $score->final ?? '-' }}</td>
                                <td>{{ $average }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
</body>
</html>