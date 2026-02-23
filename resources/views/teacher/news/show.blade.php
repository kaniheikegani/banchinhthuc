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
      Chi tiết bản tin: {{ $news->title }}
    </h2>
  </x-slot>
    <br>
  <div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      @if($news->image_url)
        <img src="{{ $news->image_url }}" 
            class="rounded shadow mb-4 mx-auto d-block" 
            style="width: 100%; max-width: 700px; height: auto; object-fit: cover;" 
            alt="Ảnh đại diện">
      @endif

      <p>{!! nl2br(e($news->content)) !!}</p>

      <a href="{{ route('home') }}" class="btn btn-secondary mt-4">⬅ Quay lại danh sách</a>
    </div>
  </div>
</x-app-layout>
</body>
</html>