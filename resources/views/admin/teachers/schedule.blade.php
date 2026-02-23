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
    <h1>Trường THPT Kani</h1>
    <p>Nơi chắp cánh ước mơ học sinh</p>
  </header>

  <x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
        📅 Lịch dạy của giáo viên {{ $teacher->name }}
      </h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-6xl mx-auto">
        @php
          $morningSchedules = collect($teachingSchedules)->where('session', 'Morning');
          $afternoonSchedules = collect($teachingSchedules)->where('session', 'Afternoon');
        @endphp

        <div class="row g-4">
          <div class="col-md-6">
            <h4 class="text-primary mb-3">🌅 Buổi sáng</h4>
            @forelse($morningSchedules as $entry)
              <div class="bg-white p-4 rounded shadow-sm border mb-3">
                <h5 class="mb-2 text-primary">📘 Lớp: {{ $entry['classroom'] }}</h5>
                <p>
                  <strong>Thứ:</strong> {{ $entry['day'] }}<br>
                  <strong>Tiết:</strong> {{ $entry['period'] }}<br>
                  <strong>Môn:</strong> {{ $entry['subject'] }}
                </p>
              </div>
            @empty
              <div class="alert alert-warning">Không có lịch buổi sáng.</div>
            @endforelse
          </div>

          <div class="col-md-6">
            <h4 class="text-primary mb-3">🌇 Buổi chiều</h4>
            @forelse($afternoonSchedules as $entry)
              <div class="bg-white p-4 rounded shadow-sm border mb-3">
                <h5 class="mb-2 text-primary">📘 Lớp: {{ $entry['classroom'] }}</h5>
                <p>
                  <strong>Thứ:</strong> {{ $entry['day'] }}<br>
                  <strong>Tiết:</strong> {{ $entry['period'] }}<br>
                  <strong>Môn:</strong> {{ $entry['subject'] }}
                </p>
              </div>
            @empty
              <div class="alert alert-warning">Không có lịch buổi chiều.</div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </x-app-layout>
</body>
</html>