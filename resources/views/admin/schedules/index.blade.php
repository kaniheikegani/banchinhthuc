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
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Quản Lý Lịch Học
        </h2>

        @php
            $selectedClassroomId = request('classroom_id');
            $selectedClassroom = $selectedClassroomId ? \App\Models\Classroom::find($selectedClassroomId) : null;
        @endphp

        @if($selectedClassroom)
            <h5 class="mt-2 text-success">📘 Lịch học của lớp: {{ $selectedClassroom->name }}</h5>
        @else
            <h5 class="mt-2 text-info">📊 Đang xem lịch của tất cả lớp</h5>
        @endif

        <div class="d-flex flex-wrap align-items-center gap-3 mt-3">

            {{-- Form tạo lịch học cho lớp đã chọn --}}
            <form method="POST" action="{{ route('admin.schedules.generate') }}" class="d-flex align-items-center gap-3">
                @csrf

                <label for="classroom_id" class="form-label mb-0">📘 Chọn lớp để random:</label>
                <select name="classroom_id" id="classroom_id" class="form-select w-auto">
                    @foreach(\App\Models\Classroom::all() as $classroom)
                        <option value="{{ $classroom->id }}" {{ $selectedClassroomId == $classroom->id ? 'selected' : '' }}>
                            {{ $classroom->name }}
                        </option>
                    @endforeach
                </select>

                <label for="session" class="form-label mb-0">🕒 Buổi học:</label>
                <select name="session" id="session" class="form-select w-auto">
                    <option value="morning">Sáng</option>
                    <option value="afternoon">Chiều</option>
                </select>

                <button type="submit" class="btn btn-primary">🎲 Tạo lịch học</button>
            </form>

            {{-- Form xem lịch học của từng lớp --}}
            <form method="GET" action="{{ route('admin.schedules.index') }}" class="d-flex align-items-center gap-2">
                <label for="view_classroom_id" class="form-label mb-0">📘 Xem lịch lớp:</label>
                <select name="classroom_id" id="view_classroom_id" class="form-select w-auto">
                    <option value="">-- Chọn lớp --</option>
                    @foreach(\App\Models\Classroom::all() as $classroom)
                        <option value="{{ $classroom->id }}" {{ $selectedClassroomId == $classroom->id ? 'selected' : '' }}>
                            {{ $classroom->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-outline-primary">📅 Xem lịch</button>
            </form>
        </div>
    </x-slot>
    <br>
       @foreach($days as $day)
    <h5 class="mt-4 text-primary">{{ $day }}</h5>
    <div class="row">
        @foreach($sessions as $session)
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">{{ ucfirst($session) }}</div>
                    <div class="card-body">
                        @php
                            $schedule = isset($schedules[$day][$session]) ? $schedules[$day][$session]->first() : null;
                            $subjects = $schedule?->subjects ?? [];
                        @endphp

                        @if($schedule && count($subjects))
                            <ul class="list-group mb-3">
                                @foreach($subjects as $subject)
                                    <li class="list-group-item">{{ $subject }}</li>
                                @endforeach
                            </ul>

                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editSchedule{{ $schedule->id }}">
                                Chỉnh sửa
                            </button>

                            <div class="modal fade" id="editSchedule{{ $schedule->id }}" tabindex="-1" aria-labelledby="editScheduleLabel{{ $schedule->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <form method="POST" action="{{ route('admin.schedules.update', $schedule->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="classroom_id" value="{{ $schedule->classroom_id }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editScheduleLabel{{ $schedule->id }}">
                                                    Sửa lịch: {{ $schedule->day }} - {{ ucfirst($schedule->session) }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Tiết</th>
                                                            <th>Môn học</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @for($i = 0; $i < 5; $i++)
                                                            @php
                                                                $fixed = false;
                                                                $current = $schedule->subjects[$i] ?? '';
                                                                if ($schedule->day === 'Monday' && $schedule->session === 'morning' && $i === 0) $fixed = true;
                                                                if ($schedule->day === 'Monday' && $schedule->session === 'afternoon' && $i === 4) $fixed = true;
                                                                if ($schedule->day === 'Friday' && $schedule->session === 'afternoon' && $i === 4) $fixed = true;
                                                            @endphp
                                                            <tr>
                                                                <td>Tiết {{ $i + 1 }}</td>
                                                                <td>
                                                                    @if($fixed)
                                                                        <input type="text" class="form-control" value="{{ $current }}" disabled>
                                                                        <input type="hidden" name="subjects[]" value="{{ $current }}">
                                                                    @else
                                                                        <select name="subjects[]" class="form-select">
                                                                            @foreach($subjectsPool as $subject)
                                                                                <option value="{{ $subject }}" {{ $current == $subject ? 'selected' : '' }}>
                                                                                    {{ $subject }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @else
                            <p class="text-muted">Chưa có lịch</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endforeach
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>