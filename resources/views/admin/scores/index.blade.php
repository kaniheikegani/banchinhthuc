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
            Quản Lý Điểm
        </h2>
    </x-slot>
    <br>
        
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- 📝 Danh sách điểm chưa duyệt --}}
                <h4 class="mb-4 text-secondary">📝 Danh sách điểm chưa duyệt</h4>
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Học sinh</th>
                            <th>Môn</th>
                            <th>Miệng</th>
                            <th>Thái độ</th>
                            <th>Giữa kỳ</th>
                            <th>Cuối kỳ</th>
                            <th>Điểm tổng kết</th>
                            <th>Học kỳ</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingScores as $score)
                            @php
                                $oral     = $score->oral ?? 0;
                                $attitude = $score->attitude ?? 0;
                                $midterm  = $score->midterm ?? 0;
                                $final    = $score->final ?? 0;
                                $weightedTotal = $oral + $attitude + ($midterm * 2) + ($final * 3);
                                $average = round($weightedTotal / 7, 1);
                            @endphp
                            <tr>
                                <td>{{ $score->student->name }}</td>
                                <td>{{ $score->subject }}</td>
                                <td>{{ $score->oral }}</td>
                                <td>{{ $score->attitude }}</td>
                                <td>{{ $score->midterm }}</td>
                                <td>{{ $score->final }}</td>
                                <td>{{ $average }}</td>
                                <td>{{ $score->term }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.scores.approve', $score->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Duyệt</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- 📋 Danh sách điểm đã duyệt --}}
                <h4 class="mb-4 text-secondary">📋 Danh sách điểm đã duyệt</h4>
                @foreach($students as $student)
                    <div class="mb-4 border rounded p-3 bg-light">
                        <h5 class="mb-3 text-primary">{{ $student->name }} ({{ $student->class }})</h5>

                        <table class="table table-bordered table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Môn</th>
                                    <th>Miệng</th>
                                    <th>Thái độ</th>
                                    <th>Giữa kỳ</th>
                                    <th>Cuối kỳ</th>
                                    <th>Điểm tổng kết</th>
                                    <th>Học kỳ</th>
                                    <th>Xếp loại</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($student->scores as $score)
                                    <tr>
                                        <td>{{ $score->subject }}</td>
                                        <td>{{ $score->oral ?? '-' }}</td>
                                        <td>{{ $score->attitude ?? '-' }}</td>
                                        <td>{{ $score->midterm ?? '-' }}</td>
                                        <td>{{ $score->final ?? '-' }}</td>
                                        <td>{{ $score->score }}</td>
                                        <td>{{ $score->term }}</td>
                                        <td>
                                            <span class="badge
                                                @if($score->grade == 'Giỏi') bg-success
                                                @elseif($score->grade == 'Khá') bg-primary
                                                @elseif($score->grade == 'Trung bình') bg-warning
                                                @else bg-danger
                                                @endif">
                                                {{ $score->grade }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScoreModal{{ $score->id }}">
                                                Sửa
                                            </button>
                                            <form method="POST" action="{{ route('admin.scores.destroy', $score->id) }}" onsubmit="return confirm('Bạn có chắc muốn xóa điểm này không?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-muted">Chưa có điểm</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endforeach
                {{-- ✅ Modal sửa điểm + Script tính toán --}}
                @foreach($students as $student)
                    @foreach($student->scores as $score)
                        <div class="modal fade" id="editScoreModal{{ $score->id }}" tabindex="-1" aria-labelledby="editScoreLabel{{ $score->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('admin.scores.update', $score->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editScoreLabel{{ $score->id }}">Sửa điểm: {{ $score->subject }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Môn học</label>
                                                <input type="text" name="subject" class="form-control" value="{{ $score->subject }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">🗣️ Miệng</label>
                                                <input type="number" step="0.1" name="oral" id="oral{{ $score->id }}" class="form-control" value="{{ $score->oral }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">🤝 Thái độ</label>
                                                <input type="number" step="0.1" name="attitude" id="attitude{{ $score->id }}" class="form-control" value="{{ $score->attitude }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">📝 Giữa kỳ</label>
                                                <input type="number" step="0.1" name="midterm" id="midterm{{ $score->id }}" class="form-control" value="{{ $score->midterm }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">📘 Cuối kỳ</label>
                                                <input type="number" step="0.1" name="final" id="final{{ $score->id }}" class="form-control" value="{{ $score->final }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">🎯 Điểm tổng kết</label>
                                                <input type="number" step="0.1" name="score" id="score{{ $score->id }}" class="form-control bg-light" value="{{ $score->score }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Học kỳ</label>
                                                <select name="term" class="form-select">
                                                    <option value="HK1" {{ $score->term == 'HK1' ? 'selected' : '' }}>HK1</option>
                                                    <option value="HK2" {{ $score->term == 'HK2' ? 'selected' : '' }}>HK2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Script tính toán điểm tổng kết --}}
                        <script>
                            function calculateScore{{ $score->id }}() {
                                let oral = parseFloat(document.getElementById('oral{{ $score->id }}').value) || 0;
                                let attitude = parseFloat(document.getElementById('attitude{{ $score->id }}').value) || 0;
                                let midterm = parseFloat(document.getElementById('midterm{{ $score->id }}').value) || 0;
                                let final = parseFloat(document.getElementById('final{{ $score->id }}').value) || 0;

                                let weightedTotal = oral + attitude + (midterm * 2) + (final * 3);
                                let average = (weightedTotal / 7).toFixed(1);

                                document.getElementById('score{{ $score->id }}').value = average;
                            }

                            ['oral{{ $score->id }}', 'attitude{{ $score->id }}', 'midterm{{ $score->id }}', 'final{{ $score->id }}'].forEach(id => {
                                document.getElementById(id).addEventListener('input', calculateScore{{ $score->id }});
                            });
                        </script>
                    @endforeach
                @endforeach

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
                </x-app-layout>
