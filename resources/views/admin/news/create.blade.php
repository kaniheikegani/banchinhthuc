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
      ➕ Thêm Bản Tin Mới
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <form method="POST" action="{{ route('admin.news.store') }}">
        @csrf

        <div class="mb-4">
          <label class="form-label">Tiêu đề</label>
          <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-4">
          <label class="form-label">Nội dung</label>
          <textarea name="content" class="form-control" rows="6" required></textarea>
        </div>

        <div class="mb-4">
          <label class="form-label">Loại bản tin</label>
            <select name="category" class="form-select" required>
              <option value="general">Hoạt động chung</option>
              <option value="competition">Thi đua</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="form-label">Ảnh đại diện (URL)</label>
            <input type="text" name="image_url" id="image_url" class="form-control" oninput="updateImagePreview()">
        </div>

        <div class="mb-4">
            <label class="form-label">Xem trước ảnh</label>
            <img id="image_preview" src="" class="img-fluid border" style="max-height: 300px;">
        </div>

        <script>
            function updateImagePreview() {
                const url = document.getElementById('image_url').value;
                document.getElementById('image_preview').src = url;
            }
         </script>

        <button type="submit" class="btn btn-primary">Đăng bản tin</button>
      </form>
    </div>
  </div>
</x-app-layout>
</body>
</html>