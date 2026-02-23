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
        ✉️ Gửi đề xuất & Danh sách đề xuất đã gửi
      </h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-4xl mx-auto space-y-6">

        <!-- Form gửi yêu cầu -->
        <div class="bg-white p-6 rounded shadow">
          <h4 class="mb-4">📨 Gửi đề xuất mới</h4>
          <form method="POST" action="{{ route('student.requests.store') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label">Loại đề xuất</label>
              <select name="type" class="form-select" id="typeSelect" required>
                <option value="info">Thay đổi thông tin cá nhân</option>
                <option value="confirmation">Xác nhận hộ nghèo / giảm học phí</option>
                <option value="score">Đề xuất sửa điểm</option>
                <option value="absence">Xin phép nghỉ học</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Người nhận</label>
              <input type="text" id="receiverDisplay" class="form-control" readonly>
              <input type="hidden" name="receiver_type" id="receiverTypeHidden">
            </div>

            <div class="mb-3">
              <label class="form-label">Tiêu đề</label>
              <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Nội dung</label>
              <textarea name="content" class="form-control" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Gửi đề xuất</button>
          </form>
        </div>

        <!-- Danh sách yêu cầu đã gửi -->
        <div class="bg-white p-6 rounded shadow">
          <h4 class="mb-4">📋 Đề xuất đã gửi</h4>

          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          @forelse($requests as $req)
            <div class="mb-4 border-bottom pb-3">
              <h5 class="mb-1">{{ $req->title }}</h5>
              <p class="mb-1 text-muted">
                Loại: <strong>{{ ucfirst($req->type) }}</strong> |
                Trạng thái:
                <span class="badge bg-{{ $req->status == 'pending' ? 'warning' : ($req->status == 'approved' ? 'success' : 'danger') }}">
                  {{ ucfirst($req->status) }}
                </span> |
                Gửi đến:
                @if($req->receiver_type === 'teacher')
                  Giáo viên chủ nhiệm
                @elseif($req->receiver_type === 'admin')
                  Ban quản trị
                @else
                  <span class="text-danger">Không xác định</span>
                @endif
              </p>
              <p>{{ $req->content }}</p>
              <small class="text-muted">Gửi lúc: {{ $req->created_at->format('H:i d/m/Y') }}</small>

              @if($req->status === 'pending')
                <form method="POST" action="{{ route('student.requests.destroy', $req->id) }}" class="mt-2" onsubmit="return confirm('Bạn có chắc muốn xóa yêu cầu này?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger">Xóa yêu cầu</button>
                </form>
              @endif
            </div>
          @empty
            <p class="text-muted">Bạn chưa gửi yêu cầu nào.</p>
          @endforelse
        </div>

      </div>
    </div>
  </x-app-layout>

  <!-- JavaScript xử lý người nhận -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const typeSelect = document.getElementById('typeSelect');
      const receiverDisplay = document.getElementById('receiverDisplay');
      const receiverTypeHidden = document.getElementById('receiverTypeHidden');

      function updateReceiver() {
        const type = typeSelect.value;
        if (type === 'score' || type === 'absence') {
          receiverDisplay.value = 'Giáo viên chủ nhiệm';
          receiverTypeHidden.value = 'teacher';
        } else {
          receiverDisplay.value = 'Ban quản trị';
          receiverTypeHidden.value = 'admin';
        }
      }

      typeSelect.addEventListener('change', updateReceiver);
      updateReceiver(); // chạy lần đầu khi trang load
    });
  </script>
</body>
</html>