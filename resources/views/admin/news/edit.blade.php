<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>{{ $contents['school_name'] ?? 'Trường THPT Kani' }}</title>
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
                📝 Chỉnh sửa tin tức
            </h2>
        </x-slot>

        <div class="container mt-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.news.update', $news->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Tiêu đề</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $news->title) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nội dung</label>
                    <textarea name="content" class="form-control" rows="6" required>{{ old('content', $news->content) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">URL ảnh minh họa</label>
                    <input type="text" name="image_url" id="image_url" class="form-control" value="{{ old('image_url', $news->image_url) }}" oninput="updateImagePreview()">
                </div>

                <div class="mb-3">
                    <label class="form-label">Xem trước ảnh</label><br>
                    <img id="image_preview" src="{{ $news->image_url }}" style="max-height: 250px;" class="border rounded">
                </div>

                <button type="submit" class="btn btn-primary">💾 Lưu thay đổi</button>
            </form>
        </div>

        <script>
            function updateImagePreview() {
                const url = document.getElementById('image_url').value;
                document.getElementById('image_preview').src = url;
            }
        </script>
    </x-app-layout>
</body>
</html>