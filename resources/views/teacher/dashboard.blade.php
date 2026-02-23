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
            Bảng Điều Khiển Teacher
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-700 dark:text-gray-100">Chức năng dành cho Teacher:</h3>
                <!-- Hàng nút chức năng -->
                <div class="flex space-x-6 overflow-x-auto py-4">
                    <!-- Danh sách học sinh -->
                    <a href="{{ route('teacher.students') }}" 
                    class="flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
                        <div class="flex items-center mb-3">
                            <div class="p-3 bg-blue-100 rounded-full">
                                <i class="fas fa-user-graduate text-blue-600 text-xl"></i>
                            </div>
                            <h4 class="ml-3 text-lg font-bold text-gray-700">Danh sách học sinh</h4>
                        </div>
                        <p class="text-sm text-gray-500">Xem toàn bộ học sinh trong lớp</p>
                    </a>

                    <!-- Xem điểm lớp chủ nhiệm -->
                    <a href="{{ route('teacher.scores.view') }}" 
                    class="flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
                        <div class="flex items-center mb-3">
                            <div class="p-3 bg-green-100 rounded-full">
                                <i class="fas fa-clipboard-list text-green-600 text-xl"></i>
                            </div>
                            <h4 class="ml-3 text-lg font-bold text-gray-700">Điểm lớp chủ nhiệm</h4>
                        </div>
                        <p class="text-sm text-gray-500">Theo dõi kết quả học tập lớp chủ nhiệm</p>
                    </a>

                    <!-- Nhập điểm lớp phân công -->
                    <a href="{{ route('teacher.scores.input') }}" 
                    class="flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
                        <div class="flex items-center mb-3">
                            <div class="p-3 bg-yellow-100 rounded-full">
                                <i class="fas fa-pencil-alt text-yellow-600 text-xl"></i>
                            </div>
                            <h4 class="ml-3 text-lg font-bold text-gray-700">Nhập điểm lớp phân công</h4>
                        </div>
                        <p class="text-sm text-gray-500">Nhập điểm cho lớp được giao</p>
                    </a>

                    <!-- Quản lý nhóm lớp -->
                    <a href="{{ route('teacher.classrooms') }}" 
                    class="flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
                        <div class="flex items-center mb-3">
                            <div class="p-3 bg-purple-100 rounded-full">
                                <i class="fas fa-users text-purple-600 text-xl"></i>
                            </div>
                            <h4 class="ml-3 text-lg font-bold text-gray-700">Quản lý nhóm lớp</h4>
                        </div>
                        <p class="text-sm text-gray-500">Quản lý các nhóm lớp được phân công</p>
                    </a>

                    <!-- Lịch dạy -->
                    <a href="{{ route('teacher.schedules') }}" 
                    class="flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
                        <div class="flex items-center mb-3">
                            <div class="p-3 bg-indigo-100 rounded-full">
                                <i class="fas fa-calendar-alt text-indigo-600 text-xl"></i>
                            </div>
                            <h4 class="ml-3 text-lg font-bold text-gray-700">Lịch dạy</h4>
                        </div>
                        <p class="text-sm text-gray-500">Theo dõi lịch giảng dạy</p>
                    </a>

                    <!-- Yêu cầu -->
                    <a href="{{ route('teacher.requests.index') }}" 
                    class="flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
                        <div class="flex items-center mb-3">
                            <div class="p-3 bg-pink-100 rounded-full">
                                <i class="fas fa-paper-plane text-pink-600 text-xl"></i>
                            </div>
                            <h4 class="ml-3 text-lg font-bold text-gray-700">Yêu cầu</h4>
                        </div>
                        <p class="text-sm text-gray-500">Gửi yêu cầu tới nhà trường</p>
                    </a>

                    <!-- Nhận yêu cầu từ học sinh -->
                    <a href="{{ route('teacher.requests.student') }}" 
                    class="relative flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
                        <div class="flex items-center mb-3">
                            <div class="p-3 bg-red-100 rounded-full">
                                <i class="fas fa-inbox text-red-600 text-xl"></i>
                            </div>
                            <h4 class="ml-3 text-lg font-bold text-gray-700">Yêu cầu từ học sinh</h4>
                        </div>
                        <p class="text-sm text-gray-500">Xem và xử lý yêu cầu học sinh gửi</p>

                        @if($pendingCount > 0)
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                {{ $pendingCount }}
                            </span>
                        @endif
                    </a>

                </div>    
            </div>
        </div>
    </div>
</x-app-layout>