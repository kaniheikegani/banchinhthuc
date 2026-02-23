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
        👤 Thông tin cá nhân
      </h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h4 class="mb-4 text-primary">Thông tin học sinh</h4>
        <ul class="list-group">
          <li class="list-group-item"><strong>Họ tên:</strong> {{ $student->name }}</li>
          <li class="list-group-item"><strong>Giới tính:</strong> 
              @if($student->gender === 'male') Nam 
              @elseif($student->gender === 'female') Nữ 
              @else {{ $student->gender ?? 'Chưa cập nhật' }} 
              @endif
            </li>
          <li class="list-group-item"><strong>Email:</strong> {{ $student->email }}</li>
          <li class="list-group-item"><strong>Lớp:</strong> {{ $student->classroom->name ?? 'Chưa phân lớp' }}</li>
          <li class="list-group-item"><strong>Mã lớp (ID):</strong> {{ $student->classroom_id }}</li>
          <li class="list-group-item"><strong>Mã học sinh:</strong> {{ $student->student_code }}</li>
          <li class="list-group-item"><strong>Vai trò:</strong> {{ $student->role }}</li>
          <li class="list-group-item"><strong>Ngày sinh:</strong> {{ $student->birthday ? \Carbon\Carbon::parse($student->birthday)->format('d/m/Y') : 'Chưa cập nhật' }}</li>
          <li class="list-group-item"><strong>Số CCCD:</strong> {{ $student->cccd }}</li>
          <li class="list-group-item"><strong>Số điện thoại:</strong> {{ $student->phone }}</li>
          <li class="list-group-item"><strong>Họ tên cha:</strong> {{ $student->father_name }}</li>
          <li class="list-group-item"><strong>Họ tên mẹ:</strong> {{ $student->mother_name }}</li>
          <li class="list-group-item"><strong>Số điện thoại phụ huynh:</strong> {{ $student->parent_phone }}</li>
          <li class="list-group-item"><strong>Ngày tạo tài khoản:</strong> {{ $student->created_at->format('d/m/Y') }}</li>
        </ul>
      </div>
    </div>
  </x-app-layout>
</body>
</html>