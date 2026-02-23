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
  <!-- Giới thiệu -->
  <!--<section class="container my-5">
    <h2 class="mb-4">🎓 Giới Thiệu Trường</h2>
    <p>{!! nl2br(e($contents['about'] ?? 'Trường THPT Kani được thành lập năm 1995...')) !!}</p>
  </section>-->
  <!-- Tin tức -->
  <!-- 🏫 Hoạt động chung -->
  <section class="bg-light py-5">
    <div class="container">
      <h2 class="mb-4">🏫 Hoạt Động Chung</h2>
      <div class="row g-4">
        @forelse($generalNews as $item)
          <div class="col-md-4">
            <div class="card h-100">
              <img src="{{ $item->image_url ?? 'https://via.placeholder.com/400x200' }}" class="card-img-top" alt="Tin tức">
              <div class="card-body">
                <h5 class="card-title">{{ $item->title }}</h5>
                <p class="card-text">{{ Str::limit($item->content, 100) }}</p>
                @role('admin')
                  <a href="{{ route('admin.news.show', $item->id) }}">Xem thêm</a>
                @endrole

                @role('teacher')
                  <a href="{{ route('teacher.news.show', $item->id) }}">Xem thêm</a>
                @endrole

                @role('student')
                  <a href="{{ route('student.news.show', $item->id) }}">Xem thêm</a>
                @endrole
              </div>
            </div>
          </div>
        @empty
          <p>Chưa có bản tin hoạt động chung nào.</p>
        @endforelse
      </div>
    </div>
  </section>

  <!-- 🏆 Hoạt động thi đua -->
  <section class="bg-light py-5">
    <div class="container">
      <h2 class="mb-4">🏆 Hoạt Động Thi Đua</h2>
      <div class="row g-4">
        @forelse($competitionNews as $item)
          <div class="col-md-4">
            <div class="card h-100">
              <img src="{{ $item->image_url ?? 'https://via.placeholder.com/400x200' }}" class="card-img-top" alt="Thi đua">
              <div class="card-body">
                <h5 class="card-title">{{ $item->title }}</h5>
                <p class="card-text">{{ Str::limit($item->content, 100) }}</p>
                @role('admin')
                  <a href="{{ route('admin.news.show', $item->id) }}">Xem thêm</a>
                @endrole

                @role('teacher')
                  <a href="{{ route('teacher.news.show', $item->id) }}">Xem thêm</a>
                @endrole

                @role('student')
                  <a href="{{ route('student.news.show', $item->id) }}">Xem thêm</a>
                @endrole
              </div>
            </div>
          </div>
        @empty
          <p>Chưa có bản tin thi đua nào.</p>
        @endforelse
      </div>
    </div>
  </section>
  <!-- Liên hệ -->
  <section class="container my-5">
    <h2 class="mb-4">📞 Liên Hệ</h2>
    <p><strong>Địa chỉ:</strong> {{ $contents['contact_address'] ?? '...' }}</p>
    <p><strong>Email:</strong> {{ $contents['contact_email'] ?? '...' }}</p>
    <p><strong>Điện thoại:</strong> {{ $contents['contact_phone'] ?? '...' }}</p>
  </section>

  <!-- Footer -->
  <footer class="bg-primary text-white text-center py-3">
    &copy; 2025 Trường THPT Kani | Thiết kế bởi Kani & Copilot
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
</x-app-layout>
</body>
</html>