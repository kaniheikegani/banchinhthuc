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
            Phân lớp cho giáo viên: {{ $teacher->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.classrooms.assign.store', $teacher->id) }}">
                @csrf
                <div class="mb-4">
                    <label for="classroom_id" class="form-label">Chọn lớp học:</label>
                    <select name="classroom_id" id="classroom_id" class="form-select">
                        @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Phân lớp</button>
            </form>
        </div>
    </div>
</x-app-layout>
</body>
</html>