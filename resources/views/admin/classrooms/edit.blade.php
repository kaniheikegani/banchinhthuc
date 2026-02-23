<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Sửa lớp học</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        ✏️ Sửa lớp học: {{ $classroom->name }}
      </h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('admin.classrooms.update', $classroom->id) }}">
          @csrf
          @method('PUT')

          <div class="mb-4">
            <label for="name" class="form-label">Tên lớp:</label>
            <input type="text" name="name" id="name" value="{{ $classroom->name }}" class="form-control" required>
          </div>

          <div class="mb-4">
            <label for="teacher_id" class="form-label">Giáo viên phụ trách:</label>
            <select name="teacher_id" class="form-select">
              <option value="">-- Chưa phân công --</option>
              @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ $classroom->teacher_id == $teacher->id ? 'selected' : '' }}>
                  {{ $teacher->name }}
                </option>
              @endforeach
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Cập nhật lớp</button>
        </form>
      </div>
    </div>
  </x-app-layout>
</body>
</html>