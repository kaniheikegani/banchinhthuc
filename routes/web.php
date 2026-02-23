<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\SettingController;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ScoreController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ClassroomController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Teacher\TeacherController as TeacherTeacherController;
use App\Http\Controllers\Teacher\ClassroomChatController;
use App\Http\Controllers\Teacher\RequestController as TeacherRequestController;
use App\Http\Controllers\Admin\RequestController as AdminRequestController;
use App\Http\Controllers\Student\StudentController as StudentStudentController;
use App\Http\Controllers\Student\StudentChatController;
use App\Http\Controllers\Student\StudentRequestController as StudentRequestController;
use App\Http\Controllers\StudentImportController;







Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'home'])->name('home');

Route::middleware(['auth', 'checkRole:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        // 📋 Trang chính của học sinh
        Route::get('/dashboard', function () {
            $student = Auth::user();
            $classroom = $student->classroom;
            return view('student.dashboard', compact('student', 'classroom'));
        })->name('dashboard');

        // 👨‍🏫 Xem danh sách giáo viên dạy lớp mình
        Route::get('/teachers', [StudentController::class, 'teachers'])->name('teachers');

        // 📅 Xem lịch học của lớp
        Route::get('/schedules', [StudentStudentController::class, 'schedules'])->name('schedules');

        // 🏫 Xem thông tin lớp học
        Route::get('/classroom', [StudentController::class, 'classroom'])->name('classroom');

        // 📰 Xem bản tin
        Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

        // 📝 Xem điểm (nếu có)
        Route::get('/scores', [StudentStudentController::class, 'scores'])->name('scores');

        // 💬 Xem chat lớp (nếu cho phép học sinh xem)
        Route::get('/classroom/{id}/chat', [StudentChatController::class, 'show'])->name('classroom.chat');
        Route::post('/classroom/{id}/chat/send', [StudentChatController::class, 'send'])->name('classroom.chat.send');

         Route::get('/profile', [StudentStudentController::class, 'profile'])->name('profile');

        // 📌 Yêu cầu của học sinh (nếu dùng)
        Route::get('/requests', [StudentRequestController::class, 'index'])->name('requests.index');
        Route::post('/requests', [StudentRequestController::class, 'store'])->name('requests.store');
        Route::delete('/requests/{id}', [StudentRequestController::class, 'destroy'])->name('requests.destroy');
    });


Route::middleware(['auth', 'checkRole:teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {

        // 📰 Xem bản tin
        Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

        // 📊 Dashboard
        Route::get('/dashboard', [TeacherTeacherController::class, 'dashboard'])->name('dashboard');

        // 👨‍🏫 GVCN xem học sinh lớp mình
        Route::get('/students', [TeacherTeacherController::class, 'students'])->name('students');

        // 📋 GVCN xem điểm lớp mình
       Route::get('/scores/view', [TeacherTeacherController::class, 'viewScoresAsHomeroom'])->name('scores.view');

        // 📝 GV bộ môn nhập điểm lớp được phân công
        Route::get('/scores/input', [TeacherTeacherController::class, 'inputScoresAsSubjectTeacher'])->name('scores.input');
        Route::post('/scores', [TeacherTeacherController::class, 'storeScore'])->name('scores.store');
        Route::get('/scores/{id}/edit', [TeacherTeacherController::class, 'editScore'])->name('scores.edit');
        Route::put('/scores/{id}', [TeacherTeacherController::class, 'updateScore'])->name('scores.update');
        Route::delete('/scores/{id}', [TeacherTeacherController::class, 'destroyScore'])->name('scores.destroy');
        Route::post('/scores/{id}/approve', [TeacherTeacherController::class, 'approveScore'])->name('scores.approve');

        // 🗓️ Lịch dạy
        Route::get('/schedules', [TeacherTeacherController::class, 'schedules'])->name('schedules');

        // 🏫 Quản lý lớp chủ nhiệm
        Route::get('/classrooms', [TeacherTeacherController::class, 'classrooms'])->name('classrooms');

        // 💬 Nhóm chat lớp
        Route::get('/classroom/{id}/chat', [ClassroomChatController::class, 'show'])->name('classroom.chat');
        Route::post('/classroom/{id}/chat/send', [ClassroomChatController::class, 'send'])->name('classroom.chat.send');

        // 📥 Yêu cầu từ học sinh
        Route::get('/requests', [TeacherRequestController::class, 'index'])->name('requests.index');
        Route::post('/requests', [TeacherRequestController::class, 'store'])->name('requests.store');
        Route::get('/requests/{id}', [TeacherRequestController::class, 'show'])->name('requests.show');
        Route::delete('/requests/{id}', [TeacherRequestController::class, 'destroy'])->name('requests.destroy');
        Route::post('/requests/{id}/cancel', [TeacherRequestController::class, 'cancel'])->name('requests.cancel');

        // ✅ Route riêng xử lý yêu cầu sửa điểm từ học sinh
        Route::get('/student-requests', [TeacherRequestController::class, 'studentRequests'])->name('requests.student');
    });



Route::get('/', [WelcomeController::class, 'index']);
//quyen admin sua hoc sinh
Route::middleware(['auth', 'checkRole:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // 📊 Dashboard
        Route::get('/dashboard', function () {
            $admin = Auth::user();
            $pendingStudents = \App\Models\User::role('student')->where('approved', false)->count();
            $pendingTeacherRequests = \App\Models\TeacherRequest::where('status', 'pending')->count();
            $pendingStudentRequests = \App\Models\StudentRequest::where('status', 'pending')
                ->where('receiver_type', 'admin')
                ->count();
            $pendingRequests = $pendingTeacherRequests + $pendingStudentRequests;

            return view('admin.dashboard', compact('admin','pendingStudents','pendingRequests'));
        })->name('dashboard');

         
        Route::get('/students', [StudentController::class, 'index'])->name('students');
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
        Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
        Route::post('/students/{id}/approve', [StudentController::class, 'approve'])->name('students.approve');
        Route::get('/students/waiting', [AdminController::class, 'wait'])->name('students.waiting');

        Route::get('/scores', [ScoreController::class, 'index'])->name('scores');
        Route::post('/scores', [ScoreController::class, 'store'])->name('scores.store');
        Route::put('/scores/{id}', [ScoreController::class, 'update'])->name('scores.update');
        Route::delete('/scores/{id}', [ScoreController::class, 'destroy'])->name('scores.destroy');

        Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');

        Route::post('/schedules/generate', [ScheduleController::class, 'generateRandom'])->name('schedules.generate');
        Route::put('/schedules/{id}', [ScheduleController::class, 'update'])->name('schedules.update');

        Route::get('/teachers/{teacher}/schedule', [AdminTeacherController::class, 'schedule'])->name('teachers.schedule');
        Route::get('/classrooms/assign/{teacher}', [ClassroomController::class, 'assign'])->name('classrooms.assign');
        // import hoc sinh
        Route::post('/students/import', [StudentImportController::class, 'import'])->name('students.import');
        

        // Trang chỉnh sửa nội dung trang chủ
        Route::get('/home/edit', [HomeController::class, 'edit'])->name('home.edit');
        Route::post('/home/update', [HomeController::class, 'update'])->name('home.update');

        // Trang hiển thị nội dung trang chủ (nếu cần riêng cho admin)
        Route::get('/home', [HomeController::class, 'home'])->name('home');

        Route::get('/news', [NewsController::class, 'index'])->name('news');
        Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
        Route::post('/news', [NewsController::class, 'store'])->name('news.store');
        Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
        Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update');
        Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');
        Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

        Route::get('/classrooms', [ClassroomController::class, 'index'])->name('classrooms');
        Route::get('/classrooms/create', [ClassroomController::class, 'create'])->name('classrooms.create');
        Route::post('/classrooms', [ClassroomController::class, 'store'])->name('classrooms.store');
        Route::get('/classrooms/{id}/edit', [ClassroomController::class, 'edit'])->name('classrooms.edit');
        Route::put('/classrooms/{id}', [ClassroomController::class, 'update'])->name('classrooms.update');
        Route::delete('/classrooms/{id}', [ClassroomController::class, 'destroy'])->name('classrooms.destroy');

        Route::get('/teachers', [AdminTeacherController::class, 'index'])->name('teachers.index');


        Route::get('/admin/teachers/{teacher}/schedule', [AdminTeacherController::class, 'schedule'])->name('admin.teachers.schedule');
        Route::get('/classrooms/assign/{teacher}', [ClassroomController::class, 'assign'])->name('classrooms.assign');
        Route::post('/classrooms/assign/{teacher}', [ClassroomController::class, 'storeAssignment'])->name('classrooms.assign.store');
        Route::get('/classrooms/{id}/assign-subject', [ClassroomController::class, 'assignSubject'])->name('classrooms.assignSubject');
      

        Route::post('/classrooms/{id}/assign-subjects', [ClassroomController::class, 'storeMultipleSubjectAssignments'])->name('classrooms.assignSubject.storeMultiple');

        Route::post('/scores/{id}/approve', [ScoreController::class, 'approve'])->name('scores.approve');

        Route::get('/requests', [AdminRequestController::class, 'index'])->name('requests.index');
        Route::post('/requests/{id}/approve', [AdminRequestController::class, 'approve'])->name('requests.approve');
        Route::post('/requests/{id}/reject', [AdminRequestController::class, 'reject'])->name('requests.reject');

        Route::post('/student-requests/{id}/approve', [AdminRequestController::class, 'approveStudent'])->name('student-requests.approve');
        Route::post('/student-requests/{id}/reject', [AdminRequestController::class, 'rejectStudent'])->name('student-requests.reject');

    });


    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');                                                                     
    });
    Route::get('/test-cloudinary', function () {
        return config('cloudinary.url');
    });


require __DIR__.'/auth.php';
