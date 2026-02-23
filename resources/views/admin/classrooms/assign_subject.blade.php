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
        Phân công giáo viên bộ môn cho lớp: {{ $classroom->name }}
      </h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('admin.classrooms.assignSubject.storeMultiple', $classroom->id) }}">
          @csrf

          <table class="table table-bordered">
            <thead class="table-light">
              <tr>
                <th>Môn học</th>
                <th>Chọn giáo viên bộ môn</th>
              </tr>
            </thead>
            <tbody>
              @foreach($subjects as $subject)
                <tr>
                  <td>
                    {{ $subject->name }}
                    <input type="hidden" name="subjects[]" value="{{ $subject->id }}">
                  </td>
                  <td>
                    <select name="teachers[]" class="form-select" required>
                      <option value="">-- Chọn giáo viên --</option>
                      @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                      @endforeach
                    </select>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          <button type="submit" class="btn btn-primary mt-3">Phân công tất cả</button>
        </form>
      </div>
    </div>
  </x-app-layout>
</body>
</html>