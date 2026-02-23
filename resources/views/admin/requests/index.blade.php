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
      📋 Danh sách yêu cầu từ giáo viên & học sinh
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

      <!-- 📋 Bảng yêu cầu giáo viên -->
      <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-bold mb-4 text-gray-700 dark:text-gray-100">📋 Yêu cầu từ giáo viên</h3>
        <table class="table table-bordered w-100">
          <thead class="bg-gray-100">
            <tr>
              <th>👤 Giáo viên</th>
              <th>🏫 Lớp</th>
              <th>📚 Môn</th>
              <th>📅 Ngày</th>
              <th>🕒 Thời gian</th>
              <th>📝 Lý do</th>
              <th>📌 Trạng thái</th>
              <th>⚙️ Hành động</th>
            </tr>
          </thead>
          <tbody>
            @forelse($requests as $req)
              <tr>
                <td>{{ $req->teacher->name ?? 'Không rõ' }}</td>
                <td>{{ $req->classroom->name ?? '-' }}</td>
                <td>{{ $req->subject->name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($req->requested_date)->format('d/m/Y') }}</td>
                <td>{{ $req->session }}</td>
                <td>{{ $req->reason }}</td>
                <td>
                  @if($req->status === 'pending')
                    <span class="badge bg-warning text-dark">Chờ duyệt</span>
                  @elseif($req->status === 'approved')
                    <span class="badge bg-success">Đã duyệt</span>
                  @else
                    <span class="badge bg-danger">Từ chối</span>
                  @endif
                </td>
                <td>
                  @if($req->status === 'pending')
                    <form method="POST" action="{{ route('admin.requests.approve', $req->id) }}" class="d-inline">
                      @csrf
                      <button class="btn btn-sm btn-success">✅ Duyệt</button>
                    </form>
                    <form method="POST" action="{{ route('admin.requests.reject', $req->id) }}" class="d-inline ms-1">
                      @csrf
                      <button class="btn btn-sm btn-danger">❌ Từ chối</button>
                    </form>
                  @else
                    <em>Đã xử lý</em>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center text-muted">Không có yêu cầu nào từ giáo viên</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- 📥 Bảng yêu cầu học sinh -->
      <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-bold mb-4 text-gray-700 dark:text-gray-100">📥 Yêu cầu từ học sinh</h3>
        <table class="table table-bordered w-100">
          <thead class="bg-gray-100">
            <tr>
              <th>👤 Học sinh</th>
              <th>📧 Email</th>
              <th>📝 Nội dung</th>
              <th>📌 Trạng thái</th>
              <th>⚙️ Hành động</th>
            </tr>
          </thead>
          <tbody>
            @forelse($studentRequests as $req)
              <tr>
                <td>{{ $req->student->name ?? 'Không rõ' }}</td>
                <td>{{ $req->student->email ?? '-' }}</td>
                <td>{{ $req->content }}</td>
                <td>
                  @if($req->status === 'pending')
                    <span class="badge bg-warning text-dark">Chờ duyệt</span>
                  @elseif($req->status === 'approved')
                    <span class="badge bg-success">Đã duyệt</span>
                  @else
                    <span class="badge bg-danger">Từ chối</span>
                  @endif
                </td>
                <td>
                  @if($req->status === 'pending')
                    <form method="POST" action="{{ route('admin.student-requests.approve', $req->id) }}" class="d-inline">
                      @csrf
                      <button class="btn btn-sm btn-success">✅ Duyệt</button>
                    </form>
                    <form method="POST" action="{{ route('admin.student-requests.reject', $req->id) }}" class="d-inline ms-1">
                      @csrf
                      <button class="btn btn-sm btn-danger">❌ Từ chối</button>
                    </form>
                  @else
                    <em>Đã xử lý</em>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted">Không có yêu cầu nào từ học sinh</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </div>
</x-app-layout>
</body>
</html>