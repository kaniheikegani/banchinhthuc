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
            ✉️ Gửi yêu cầu giáo viên
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('teacher.requests.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="type" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Loại yêu cầu</label>
                        <select name="type" id="type" class="form-select mt-1 block w-full">
                            <option value="nghỉ tiết">Nghỉ tiết</option>
                            <option value="nghỉ ngày">Nghỉ nguyên ngày</option>
                            <option value="đổi lịch">Đề xuất đổi lịch</option>
                            <option value="khác">Khác</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="classroom_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Lớp học</label>
                        <select name="classroom_id" id="classroom_id" class="form-select mt-1 block w-full">
                            @foreach($classrooms as $id => $name)
                                <option value="{{ $id }}">Lớp {{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="subject_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Môn học</label>
                        <select name="subject_id" id="subject_id" class="form-select mt-1 block w-full">
                            @foreach($subjects as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="requested_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Ngày yêu cầu</label>
                        <input type="date" name="requested_date" id="requested_date" class="form-input mt-1 block w-full">
                    </div>

                    <div class="mb-4">
                        <label for="session" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Thời gian nghỉ</label>
                        <select name="session" id="session" class="form-select mt-1 block w-full">
                            <option value="">-- Không chọn --</option>

                            <optgroup label="📅 Nghỉ nguyên ngày">
                                <option value="full_day">Nghỉ cả ngày</option>
                            </optgroup>

                            <optgroup label="🌅 Nghỉ buổi sáng">
                                <option value="morning">Nghỉ cả buổi sáng</option>
                                <option value="morning_tiet_1">Tiết 1 (sáng)</option>
                                <option value="morning_tiet_2">Tiết 2 (sáng)</option>
                                <option value="morning_tiet_3">Tiết 3 (sáng)</option>
                                <option value="morning_tiet_4">Tiết 4 (sáng)</option>
                            </optgroup>

                            <optgroup label="🌇 Nghỉ buổi chiều">
                                <option value="afternoon">Nghỉ cả buổi chiều</option>
                                <option value="afternoon_tiet_1">Tiết 1 (chiều)</option>
                                <option value="afternoon_tiet_2">Tiết 2 (chiều)</option>
                                <option value="afternoon_tiet_3">Tiết 3 (chiều)</option>
                                <option value="afternoon_tiet_4">Tiết 4 (chiều)</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="reason" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Lý do</label>
                        <textarea name="reason" id="reason" rows="4" class="form-textarea mt-1 block w-full" placeholder="Ví dụ: Xin nghỉ do khám bệnh..."></textarea>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                            📤 Gửi yêu cầu
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
</body>
</html>