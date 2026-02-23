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
            📝 Nhập điểm lớp {{ $classroom->name ?? 'Chưa chọn lớp' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Chọn lớp được phân công --}}
            <form method="GET" action="{{ route('teacher.scores.input') }}" class="mb-4">
                <label for="classroom_id" class="form-label">📚 Chọn lớp bạn được phân công:</label>
                <select name="classroom_id" id="classroom_id" class="form-select w-auto d-inline-block">
                    @foreach($classroomList as $cls)
                        <option value="{{ $cls->id }}" {{ $cls->id == $classroom->id ? 'selected' : '' }}>
                            Lớp {{ $cls->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary ms-2">Xem danh sách</button>
            </form>

            @if($students->isEmpty())
                <div class="alert alert-warning">Lớp này chưa có học sinh nào được duyệt.</div>
            @else
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Họ và tên</th>
                            <th>Môn học</th>
                            <th>Điểm miệng</th>
                            <th>Thái độ</th>
                            <th>Giữa kỳ</th>
                            <th>Cuối kỳ</th>
                            <th>Điểm tổng kết</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $index => $student)
                            <tr>
                                <form method="POST" action="{{ route('teacher.scores.store') }}">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $student->id }}">
                                    <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">

                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->name }}</td>

                                    {{-- Chọn môn học --}}
                                    <td>
                                        <select name="subject" class="form-select">
                                            <option value="Toán">Toán</option>
                                            <option value="Văn">Văn</option>
                                            <option value="Anh">Anh</option>
                                            <option value="Lý">Lý</option>
                                            <option value="Hóa">Hóa</option>
                                            <option value="Sinh">Sinh</option>
                                            <option value="Địa">Địa</option>
                                            <option value="GDCD">GDCD</option>
                                        </select>
                                    </td>

                                    {{-- Nhập điểm --}}
                                    <td><input type="number" step="0.1" name="oral" id="oral{{ $student->id }}" class="form-control" /></td>
                                    <td><input type="number" step="0.1" name="attitude" id="attitude{{ $student->id }}" class="form-control" /></td>
                                    <td><input type="number" step="0.1" name="midterm" id="midterm{{ $student->id }}" class="form-control" /></td>
                                    <td><input type="number" step="0.1" name="final" id="final{{ $student->id }}" class="form-control" /></td>

                                    {{-- Điểm tổng kết --}}
                                    <td>
                                        <input type="number" step="0.1" name="score" id="score{{ $student->id }}" class="form-control bg-light" readonly />
                                    </td>

                                    <td>
                                        <button type="submit" class="btn btn-sm btn-success">Lưu</button>
                                    </td>
                                </form>
                            </tr>

                            {{-- Script tính điểm tổng kết --}}
                            <script>
                                function calculateScore{{ $student->id }}() {
                                    const oral     = parseFloat(document.getElementById('oral{{ $student->id }}').value)     || 0;
                                    const attitude = parseFloat(document.getElementById('attitude{{ $student->id }}').value) || 0;
                                    const midterm  = parseFloat(document.getElementById('midterm{{ $student->id }}').value)  || 0;
                                    const final    = parseFloat(document.getElementById('final{{ $student->id }}').value)    || 0;

                                    const weightedTotal = oral + attitude + (midterm * 2) + (final * 3);
                                    const average = (weightedTotal / 7).toFixed(1);

                                    document.getElementById('score{{ $student->id }}').value = average;
                                }

                                ['oral{{ $student->id }}', 'attitude{{ $student->id }}', 'midterm{{ $student->id }}', 'final{{ $student->id }}'].forEach(id => {
                                    document.getElementById(id).addEventListener('input', calculateScore{{ $student->id }});
                                });
                            </script>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>