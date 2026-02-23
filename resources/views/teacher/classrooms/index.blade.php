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
        🏫 Thống kê & lịch học lớp bạn phụ trách
      </h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @forelse($classrooms as $index => $classroom)
          @php
            $newMessages = $classroom->messages()
              ->where('created_at', '>', now()->subDay())
              ->whereHas('user', fn($q) => $q->where('role', 'student'))
              ->count();
          @endphp

          <div class="bg-white p-4 rounded shadow-sm border">
            <h4 class="mb-3 text-primary">📘 Lớp: {{ $classroom->name }}</h4>

            <div class="row mb-3">
              <div class="col-md-4">
                👥 <strong>Số học sinh:</strong> {{ $classroom->students->count() }}
              </div>
              <div class="col-md-4">
                🔔 <strong>Tin nhắn mới (24h):</strong>
                @if($newMessages > 0)
                  <span class="badge bg-danger">{{ $newMessages }} mới</span>
                @else
                  <span class="badge bg-secondary">Không có</span>
                @endif
              </div>
              <div class="col-md-4 text-end">
                <a href="{{ route('teacher.classroom.chat', $classroom->id) }}" class="btn btn-sm btn-outline-primary">
                  💬 Truy cập nhóm lớp
                </a>
              </div>
            </div>

            @if($classroom->schedules->isEmpty())
              <p class="text-muted">📅 Chưa có lịch dạy được gán cho lớp này.</p>
            @else
              <table class="table table-bordered table-striped">
                <thead class="table-light text-center">
                  <tr>
                    <th>📅 Thứ</th>
                    <th>🕒 Buổi</th>
                    <th>⏰ Tiết</th>
                    <th>📚 Môn học</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($classroom->schedules as $schedule)
                    @foreach($schedule->subjects as $index => $subject)
                      @php
                        $teacherName = $assignments
                          ->first(fn($a) => strtolower($a->subject->name ?? '') === strtolower($subject))
                          ?->teacher->name ?? 'Chưa phân công';
                      @endphp
                      <tr>
                        <td>{{ $schedule->day }}</td>
                        <td>{{ ucfirst($schedule->session) }}</td>
                        <td class="text-center">Tiết {{ $index + 1 }}</td>
                        <td>
                          {{ $subject }}
                          <br><small class="text-muted">👨‍🏫 {{ $teacherName }}</small>
                        </td>
                      </tr>
                    @endforeach
                  @endforeach
                </tbody>
              </table>
              <div class="alert alert-info mt-3">
                Nếu bạn muốn thay đổi lịch, vui lòng liên hệ admin trước ít nhất <strong>1 tuần</strong>.
              </div>
            @endif
          </div>
        @empty
          <div class="alert alert-warning">Bạn chưa được phân công lớp nào.</div>
        @endforelse
      </div>
    </div>
  </x-app-layout>
</body>
</html>