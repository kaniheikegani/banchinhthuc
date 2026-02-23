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
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Quản Lý Học Sinh
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Nhóm nút mở modal -->
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <!-- Nút mở modal: Cấp phát 1 học sinh -->
                    <button type="button" class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                        <i class="bi bi-person-plus-fill"></i>
                        <span>Cấp phát 1 học sinh</span>
                    </button>

                    <!-- Nút mở modal: Cấp phát nhiều học sinh -->
                    <button type="button" class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="bi bi-upload"></i>
                        <span>Cấp phát nhiều học sinh</span>
                    </button>
                </div>

                <!-- Bảng danh sách -->
                <table class="table table-bordered table-striped w-full text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <tr>
                            <th>STT</th>
                            <th>Họ và tên</th>
                            <th>Mã học sinh</th> <!-- ✅ Thêm dòng này -->
                            <th>Lớp</th>
                            <th>Email</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $index => $student)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->student_code }}</td>
                                <td>{{ $student->studentClassroom->name ?? 'Chưa phân công' }}</td>
                                <td>{{ $student->email }}</td>

                                <td>
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewStudentModal{{ $student->id }}">
                                        Xem
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editStudentModal{{ $student->id }}">
                                        Sửa
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStudentModal{{ $student->id }}">
                                        Xóa
                                    </button>
                                </td>
                            </tr>
                           <!-- Modal sửa học sinh -->
                            <div class="modal fade" id="editStudentModal{{ $student->id }}" tabindex="-1" aria-labelledby="editStudentModalLabel{{ $student->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('admin.students.update', $student->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editStudentModalLabel{{ $student->id }}">Sửa học sinh: {{ $student->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Họ và tên</label>
                                                    <input type="text" class="form-control" name="name" value="{{ $student->name }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Mã học sinh</label>
                                                    <input type="text" class="form-control" name="student_code" value="{{ $student->student_code }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="email" value="{{ $student->email }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Lớp</label>
                                                    <select name="classroom_id" class="form-select">
                                                        <option value="">-- Chưa phân công lớp --</option>
                                                        @foreach($classrooms as $classroom)
                                                            <option value="{{ $classroom->id }}" {{ $student->classroom_id == $classroom->id ? 'selected' : '' }}>
                                                                {{ $classroom->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Ngày sinh</label>
                                                    <input type="date" class="form-control" name="birthday" value="{{ $student->birthday }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Giới tính</label>
                                                    <select name="gender" class="form-select">
                                                        <option value="">-- Chưa chọn --</option>
                                                        <option value="male" {{ $student->gender === 'male' ? 'selected' : '' }}>Nam</option>
                                                        <option value="female" {{ $student->gender === 'female' ? 'selected' : '' }}>Nữ</option>
                                                        <option value="other" {{ $student->gender === 'other' ? 'selected' : '' }}>Khác</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">CCCD</label>
                                                    <input type="text" class="form-control" name="cccd" value="{{ $student->cccd }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Số điện thoại học sinh</label>
                                                    <input type="text" class="form-control" name="phone" value="{{ $student->phone }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Họ tên cha</label>
                                                    <input type="text" class="form-control" name="father_name" value="{{ $student->father_name }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Họ tên mẹ</label>
                                                    <input type="text" class="form-control" name="mother_name" value="{{ $student->mother_name }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Số điện thoại phụ huynh</label>
                                                    <input type="text" class="form-control" name="parent_phone" value="{{ $student->parent_phone }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Mật khẩu mới (nếu cần đổi)</label>
                                                    <input type="password" class="form-control" name="password" placeholder="Để trống nếu không đổi">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Lưu</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Modal xem thông tin học sinh -->
                            <div class="modal fade" id="viewStudentModal{{ $student->id }}" tabindex="-1" aria-labelledby="viewStudentModalLabel{{ $student->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewStudentModalLabel{{ $student->id }}">Thông tin học sinh: {{ $student->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><strong>Họ và tên:</strong> {{ $student->name }}</li>
                                                <li class="list-group-item"><strong>Mã học sinh:</strong> {{ $student->student_code }}</li>
                                                <li class="list-group-item"><strong>Lớp:</strong> {{ $student->studentClassroom->name ?? 'Chưa phân công' }}</li>
                                                <li class="list-group-item"><strong>Email:</strong> {{ $student->email }}</li>
                                                <li class="list-group-item"><strong>Giới tính:</strong> 
                                                    @if($student->gender === 'male') Nam
                                                    @elseif($student->gender === 'female') Nữ
                                                    @else {{ $student->gender ?? 'Chưa cập nhật' }}
                                                    @endif
                                                </li>

                                                <li class="list-group-item"><strong>Ngày sinh:</strong> {{ $student->birthday ?? 'Chưa cập nhật' }}</li>
                                                <li class="list-group-item"><strong>CCCD:</strong> {{ $student->cccd ?? 'Chưa cập nhật' }}</li>
                                                <li class="list-group-item"><strong>Số điện thoại học sinh:</strong> {{ $student->phone ?? 'Chưa cập nhật' }}</li>
                                                <li class="list-group-item"><strong>Họ tên cha:</strong> {{ $student->father_name ?? 'Chưa cập nhật' }}</li>
                                                <li class="list-group-item"><strong>Họ tên mẹ:</strong> {{ $student->mother_name ?? 'Chưa cập nhật' }}</li>
                                                <li class="list-group-item"><strong>Số điện thoại phụ huynh:</strong> {{ $student->parent_phone ?? 'Chưa cập nhật' }}</li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal xóa học sinh -->
                            <!-- Modal xác nhận xóa -->
                            <div class="modal fade" id="deleteStudentModal{{ $student->id }}" tabindex="-1" aria-labelledby="deleteStudentModalLabel{{ $student->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('students.destroy', $student->id) }}">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="deleteStudentModalLabel{{ $student->id }}">Xác nhận xóa</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                    </div>
                                    <div class="modal-body">
                                    Bạn có chắc muốn xóa học sinh <strong>{{ $student->name }}</strong> không? Hành động này không thể hoàn tác.
                                    </div>
                                    <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Không có học sinh nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
         <!-- Modal cấp phát tài khoản -->
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <form method="POST" action="{{ route('admin.students.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">📥 Cấp phát tài khoản học sinh bằng Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Chọn file Excel (.xlsx)</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Cấp phát</button>
                    </div>
                </form>
                </div>
            </div>
        </div>


            <!-- Modal thêm học sinh -->
        <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('admin.students.store') }}">
                @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="addStudentModalLabel">Thêm học sinh mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                                <label for="student_code" class="form-label">Mã học sinh</label>
                                <input type="text" class="form-control" id="student_code" name="student_code" required>
                        </div>

                        <div class="mb-3">
                            <label for="classroom_id" class="form-label">Lớp</label>
                            <select name="classroom_id" class="form-select">
                            <option value="">-- Chưa phân công lớp --</option>
                            @foreach($classrooms as $classroom)
                                <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Thêm</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
</body>
</x-app-layout>