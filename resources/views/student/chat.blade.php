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
        💬 Nhóm lớp {{ $classroom->name }}
      </h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            Tin nhắn lớp học
          </div>

          <div class="card-body bg-light" style="max-height: 400px; overflow-y: auto;">
            @forelse($messages as $message)
              <div class="mb-3">
                <strong>{{ $message->user->name }}</strong>
                <small class="text-muted">({{ $message->created_at->format('H:i d/m/Y') }})</small><br>
                <div class="border rounded p-2 bg-white">{{ $message->content }}</div>
              </div>
            @empty
              <p class="text-muted">Chưa có tin nhắn nào.</p>
            @endforelse
          </div>

          <div class="card-footer">
            <form action="{{ route('student.classroom.chat.send', $classroom->id) }}" method="POST">
              @csrf
              <div class="input-group">
                <input type="text" name="content" class="form-control" placeholder="Nhập tin nhắn..." required>
                <button type="submit" class="btn btn-primary">Gửi</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </x-app-layout>

  <script>
    const chatBox = document.querySelector('.card-body');
    chatBox.scrollTop = chatBox.scrollHeight;
  </script>
</body>
</html>