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
            👨‍🏫 Danh sách giáo viên
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <table class="table table-bordered bg-white">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Lớp đang phụ trách</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $index => $teacher)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $teacher->name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>
                                @if($teacher->classrooms->isEmpty())
                                    <span class="text-muted">Chưa phân lớp</span>
                                @else
                                    {{ $teacher->classrooms->pluck('name')->join(', ') }}
                                @endif
                            </td>
                            <td>
                                <!-- Nút xem lịch dạy -->
                                <a href="{{ route('admin.teachers.schedule', $teacher->id) }}" class="btn btn-sm btn-info">
                                    Lịch dạy
                                </a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
</body>
</html>