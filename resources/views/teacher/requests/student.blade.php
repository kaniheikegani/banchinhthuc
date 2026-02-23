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
      📥 Yêu cầu sửa điểm từ học sinh
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-5xl mx-auto space-y-6">
      @forelse($requests as $req)
        <div class="bg-white p-6 rounded shadow">
          <h5 class="mb-1">{{ $req->title }}</h5>
          <p class="mb-1 text-muted">
            Học sinh: <strong>{{ $req->student->name }}</strong> |
            Email: {{ $req->student->email }} |
            Trạng thái:
            <span class="badge bg-{{ $req->status == 'pending' ? 'warning' : ($req->status == 'approved' ? 'success' : 'danger') }}">
              {{ ucfirst($req->status) }}
            </span>
          </p>
          <p>{{ $req->content }}</p>
          <small class="text-muted">Gửi lúc: {{ $req->created_at->format('H:i d/m/Y') }}</small>
          <form action="{{ route('teacher.requests.destroy', $req->id) }}" method="POST" class="mt-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa yêu cầu này?')">
                🗑️ Xóa yêu cầu
            </button>
            </form>
        </div>
      @empty
        <p class="text-muted">Không có yêu cầu nào cần xử lý.</p>
      @endforelse
    </div>
  </div>
</x-app-layout>
</body>
</html>