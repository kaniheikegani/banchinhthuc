<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Sửa điểm - Trường THPT Kani</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <header class="bg-primary text-white text-center py-4">
    <h1>{{ $contents['school_name'] ?? 'Trường THPT Kani' }}</h1>
    <p>{{ $contents['slogan'] ?? 'Nơi chắp cánh ước mơ học sinh' }}</p>
  </header>

  <x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            ✏️ Sửa điểm môn {{ $score->subject }} của học sinh ID {{ $score->user_id }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('teacher.scores.update', $score->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Môn học</label>
                    <input type="text" class="form-control" value="{{ $score->subject }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Điểm miệng</label>
                    <input type="number" step="0.1" name="oral" value="{{ $score->oral }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Thái độ</label>
                    <input type="number" step="0.1" name="attitude" value="{{ $score->attitude }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Giữa kỳ</label>
                    <input type="number" step="0.1" name="midterm" value="{{ $score->midterm }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Cuối kỳ</label>
                    <input type="number" step="0.1" name="final" value="{{ $score->final }}" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">Cập nhật điểm</button>
                <a href="{{ route('teacher.scores') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
  </x-app-layout>
</body>
</html>