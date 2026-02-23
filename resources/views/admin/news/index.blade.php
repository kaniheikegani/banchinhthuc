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
      Quản lý Bản Tin Mới Nhất
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
      <a href="{{ route('admin.news.create') }}" class="btn btn-success mb-4">➕ Thêm bản tin mới</a>

      @foreach($news as $item)
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">{{ $item->title }}</h5>
            <p class="card-text">{{ Str::limit($item->content, 150) }}</p>
            <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-warning">Sửa</a>
            <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger">Xóa</button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</x-app-layout>
</body>
</html>