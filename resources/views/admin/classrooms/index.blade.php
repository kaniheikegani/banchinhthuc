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
            🏫 Danh sách lớp học
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('admin.classrooms.create') }}" class="btn btn-success mb-3">Thêm lớp mới</a>
            <table class="table table-bordered bg-white">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên lớp</th>
                        <th>Giáo viên phụ trách</th>
                        <th>Giáo viên bộ môn</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classrooms as $index => $classroom)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $classroom->name }}</td>
                            <td>{{ $classroom->teacher->name ?? 'Chưa phân công' }}</td>
                            <td>
                                @if($classroom->subjectTeachers->count())
                                    @foreach($classroom->subjectTeachers as $assignment)
                                        <div><strong>{{ $assignment->subject->name }}:</strong> {{ $assignment->teacher->name }}</div>
                                    @endforeach
                                @else
                                    <span class="text-muted">Chưa phân công</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.classrooms.assignSubject', $classroom->id) }}" class="btn btn-sm btn-info">Bộ môn</a>
                                <a href="{{ route('admin.classrooms.edit', $classroom->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                <form method="POST" action="{{ route('admin.classrooms.destroy', $classroom->id) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xóa lớp này?')">Xóa</button>
                                </form>
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