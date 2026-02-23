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
            Quản lý Trang Chủ
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

           <form method="POST" action="{{ route('admin.home.update') }}">
                @csrf

                <div class="mb-4">
                    <label class="form-label">Tên trường</label>
                    <input type="text" name="school_name" class="form-control" value="{{ $contents['school_name'] ?? '' }}">
                </div>

                <div class="mb-4">
                    <label class="form-label">Slogan</label>
                    <input type="text" name="slogan" class="form-control" value="{{ $contents['slogan'] ?? '' }}">
                </div>

                <div class="mb-4">
                    <label class="form-label">Giới thiệu</label>
                    <textarea name="about" class="form-control" rows="5">{{ $contents['about'] ?? '' }}</textarea>
                </div>
                <a href="{{ route('admin.news') }}" class="btn btn-outline-secondary mb-4">
                📰 Quản lý Bản Tin Mới Nhất
                </a>

                <div class="mb-4">
                    <label class="form-label">Địa chỉ liên hệ</label>
                    <input type="text" name="contact_address" class="form-control" value="{{ $contents['contact_address'] ?? '' }}">
                </div>
                <div class="mb-4">
                    <label class="form-label">Email liên hệ</label>
                    <input type="email" name="contact_email" class="form-control" value="{{ $contents['contact_email'] ?? '' }}">
                </div>

                <div class="mb-4">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="contact_phone" class="form-control" value="{{ $contents['contact_phone'] ?? '' }}">
                </div>
                
                <div class="mb-4">
                    <label class="form-label">URL ảnh banner từ Cloudinary</label>
                    <input type="text" name="banner_url" id="banner_url" class="form-control" value="{{ $contents['banner_url'] ?? '' }}" oninput="updateBannerPreview()">
                </div>

                <div class="mb-4">
                    <label class="form-label">Xem trước ảnh Cổng Chào</label>
                    <img id="banner_preview" src="{{ $contents['banner_url'] ?? '' }}" class="img-fluid border" style="max-height: 300px;">
                </div>
                <script>
                    function updateBannerPreview() {
                        const url = document.getElementById('banner_url').value;
                        const img = document.getElementById('banner_preview');
                        img.src = url;
                    }
                </script>
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </form>
        </div>
    </div>
</x-app-layout>
</body>
</html>