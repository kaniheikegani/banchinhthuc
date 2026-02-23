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
            Bảng Điều Khiển Admin
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-700 dark:text-gray-100">Chức năng dành cho Admin:</h3>
                @if ($pendingStudents > 0)
                    <div class="flex items-center gap-3 px-4 py-2 bg-blue-200 text-black font-semibold rounded-lg shadow hover:bg-blue-300 transition w-fit">
                        <img src="https://res.cloudinary.com/dsi2p18p4/image/upload/v1757546885/OIP_vda1v9.jpg"
                            alt="Học sinh chờ duyệt"
                            class="w-6 h-6 object-cover rounded-full" />
                        <span class="text-sm">{{ $pendingStudents }} tài khoản chờ duyệt</span>
                    </div><br>
                @endif
                <!-- Hàng nút chức năng -->
                <div class="flex space-x-6 overflow-x-auto py-4">

                    <!-- Quản lý học sinh -->
                    <a href="{{ route('admin.students') }}" 
                    class="flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
                        <div class="flex items-center mb-3">
                            <div class="p-3 bg-blue-100 rounded-full">
                                <i class="fas fa-user-graduate text-blue-600 text-xl"></i>
                            </div>
                            <h4 class="ml-3 text-lg font-bold text-gray-700">Quản lý học sinh</h4>
                        </div>
                        <p class="text-sm text-gray-500">Thêm, sửa, xóa thông tin học sinh</p>
                    </a>

                    <!-- Quản lý điểm -->
                    <a href="{{ route('admin.scores') }}" 
                    class="flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
                        <div class="flex items-center mb-3">
                            <div class="p-3 bg-green-100 rounded-full">
                                <i class="fas fa-chart-line text-green-600 text-xl"></i>
                            </div>
                            <h4 class="ml-3 text-lg font-bold text-gray-700">Quản lý điểm</h4>
                        </div>
                        <p class="text-sm text-gray-500">Theo dõi và cập nhật điểm số</p>
                    </a>

                    <!-- Quản lý lớp học -->
                    <a href="{{ route('admin.classrooms') }}" 
                    class="flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
                        <div class="flex items-center mb-3">
                            <div class="p-3 bg-yellow-100 rounded-full">
                                <i class="fas fa-school text-yellow-600 text-xl"></i>
                            </div>
                            <h4 class="ml-3 text-lg font-bold text-gray-700">Quản lý Lớp Học</h4>
                        </div>
                        <p class="text-sm text-gray-500">Tổ chức và quản lý các lớp học</p>
                    </a>

                    <!-- Quản lý lịch học -->
                    <a href="{{ route('admin.schedules.index') }}" 
                    class="flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
                        <div class="flex items-center mb-3">
                            <div class="p-3 bg-purple-100 rounded-full">
                                <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                            </div>
                            <h4 class="ml-3 text-lg font-bold text-gray-700">Quản lý Lịch Học</h4>
                        </div>
                        <p class="text-sm text-gray-500">Sắp xếp và điều chỉnh thời khóa biểu</p>
                    </a>

                    <!-- Quản lý trang chủ -->
                    <a href="{{ route('admin.home.edit') }}" 
                    class="flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
                        <div class="flex items-center mb-3">
                            <div class="p-3 bg-pink-100 rounded-full">
                                <i class="fas fa-home text-pink-600 text-xl"></i>
                            </div>
                            <h4 class="ml-3 text-lg font-bold text-gray-700">Quản lý Trang chủ</h4>
                        </div>
                        <p class="text-sm text-gray-500">Chỉnh sửa nội dung trang chủ</p>
                    </a>

                    <!-- Quản lý giáo viên -->
                    <a href="{{ route('admin.teachers.index') }}" 
                    class="flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
                        <div class="flex items-center mb-3">
                            <div class="p-3 bg-indigo-100 rounded-full">
                                <i class="fas fa-chalkboard-teacher text-indigo-600 text-xl"></i>
                            </div>
                            <h4 class="ml-3 text-lg font-bold text-gray-700">Quản lý Giáo viên</h4>
                        </div>
                        <p class="text-sm text-gray-500">Quản lý thông tin giáo viên</p>
                    </a>

                    <!-- Xử lý yêu cầu -->
                    <a href="{{ route('admin.requests.index') }}" 
                    class="relative flex-shrink-0 w-64 p-6 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:scale-105">
                        <div class="flex items-center mb-3">
                            <div class="p-3 bg-red-100 rounded-full">
                                <i class="fas fa-envelope-open-text text-red-600 text-xl"></i>
                            </div>
                            <h4 class="ml-3 text-lg font-bold text-gray-700">Xử lý yêu cầu</h4>
                        </div>
                        <p class="text-sm text-gray-500">Duyệt và phản hồi các đề xuất</p>

                        @if($pendingRequests > 0)
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                {{ $pendingRequests }}
                            </span>
                        @endif
                    </a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
</body>
</html>