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
            MENU STUDENT
        </h2>
    </x-slot>

    <div class="flex space-x-6 overflow-x-auto py-4">

        <!-- Thông tin cá nhân -->
        <a href="{{ route('student.profile') }}" 
        class="flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
            <div class="flex items-center mb-3">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-user text-blue-600 text-xl"></i>
                </div>
                <h4 class="ml-3 text-lg font-bold text-gray-700">Thông tin cá nhân</h4>
            </div>
            <p class="text-sm text-gray-500">Xem và chỉnh sửa hồ sơ của bạn</p>
        </a>

        <!-- Lịch học -->
        <a href="{{ route('student.schedules') }}" 
        class="flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
            <div class="flex items-center mb-3">
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-calendar-alt text-green-600 text-xl"></i>
                </div>
                <h4 class="ml-3 text-lg font-bold text-gray-700">Lịch học</h4>
            </div>
            <p class="text-sm text-gray-500">Theo dõi thời khóa biểu</p>
        </a>

        <!-- Điểm -->
        <a href="{{ route('student.scores') }}" 
        class="flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
            <div class="flex items-center mb-3">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-graduation-cap text-yellow-600 text-xl"></i>
                </div>
                <h4 class="ml-3 text-lg font-bold text-gray-700">Điểm</h4>
            </div>
            <p class="text-sm text-gray-500">Xem kết quả học tập</p>
        </a>

        <!-- Nhóm chat -->
        <a href="{{ route('student.classroom.chat', $classroom->id) }}" 
        class="flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
            <div class="flex items-center mb-3">
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-comments text-purple-600 text-xl"></i>
                </div>
                <h4 class="ml-3 text-lg font-bold text-gray-700">Nhóm chat</h4>
            </div>
            <p class="text-sm text-gray-500">Trao đổi với lớp học</p>
        </a>

        <!-- Đề xuất -->
        <a href="{{ route('student.requests.index') }}" 
        class="flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
            <div class="flex items-center mb-3">
                <div class="p-3 bg-pink-100 rounded-full">
                    <i class="fas fa-paper-plane text-pink-600 text-xl"></i>
                </div>
                <h4 class="ml-3 text-lg font-bold text-gray-700">Đề xuất</h4>
            </div>
            <p class="text-sm text-gray-500">Gửi yêu cầu tới nhà trường</p>
        </a>

    </div>
</x-app-layout>
</body>
</html>