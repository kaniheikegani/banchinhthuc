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
            ➕ Tạo lớp học mới
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.classrooms.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="form-label">Tên lớp:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label for="teacher_id" class="form-label">Giáo viên phụ trách (tuỳ chọn):</label>
                    <select name="teacher_id" class="form-select">
                        <option value="">-- Chưa phân công giáo viên --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                    
                </div>
                <div class="mb-4">
                    <label class="form-label">Phân công giáo viên bộ môn:</label>

                    @foreach($subjects as $subject)
                        <div class="mb-2">
                            <label for="subject_{{ $subject->id }}" class="form-label">{{ $subject->name }}:</label>
                            <select name="subject_teachers[{{ $subject->id }}]" id="subject_{{ $subject->id }}" class="form-select">
                                <option value="">-- Chưa phân công --</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Tạo lớp</button>
            </form>
        </div>
    </div>
</x-app-layout>
</body>
</html>