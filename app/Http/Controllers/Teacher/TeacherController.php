<?php


namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classroom;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\ClassroomSubjectTeacher;
use App\Models\StudentRequest;
use App\Models\Schedule;






class TeacherController extends Controller
{
    public function dashboard()
    {
        if (auth()->user()->role !== 'teacher') {
            abort(403, 'Bạn không có quyền truy cập');
        }

        $teacher = auth()->user();

        $pendingCount = StudentRequest::where('receiver_type', 'teacher')
            ->where('receiver_id', $teacher->id)
            ->where('type', 'score')
            ->where('status', 'pending')
            ->count();

        return view('teacher.dashboard', compact('pendingCount'));
    }


    public function students()
    {
        $teacherId = Auth::id();

        // Lấy lớp mà giáo viên đang phụ trách
        $classroom = Classroom::where('teacher_id', $teacherId)->first();

        if (!$classroom) {
            return view('teacher.students', [
                'students' => collect(), // ✅ dùng Collection để tránh lỗi isEmpty()
                'classroom' => null
            ]);
        }

        // Lấy học sinh đã được duyệt thuộc lớp đó
        $students = User::role('student')
            ->where('approved', true)
            ->where('classroom_id', $classroom->id)
            ->get();

        return view('teacher.students', compact('students', 'classroom'));
    }



    public function viewScoresAsHomeroom()
    {
        $teacherId = Auth::id();
        $classroom = Classroom::where('teacher_id', $teacherId)->first();

        if (!$classroom) {
            return view('teacher.scores.index', [
                'students' => collect(),
                'classroom' => null
            ]);
        }

        $students = User::role('student')
            ->where('approved', true)
            ->where('classroom_id', $classroom->id)
            ->with(['scores' => function ($query) {
                $query->where('is_approved', true); // ✅ chỉ lấy điểm đã duyệt
            }])
            ->get();

        return view('teacher.scores.index', compact('students', 'classroom'));
    }

    public function inputScoresAsSubjectTeacher(Request $request)
    {
        $teacherId = Auth::id();

        // Lấy danh sách ID các lớp mà giáo viên được phân công
        $classroomIds = ClassroomSubjectTeacher::where('teacher_id', $teacherId)
            ->pluck('classroom_id');

        // Lấy ID lớp được chọn từ request hoặc mặc định là lớp đầu tiên
        $classroomId = $request->get('classroom_id') ?? $classroomIds->first();

        // Kiểm tra quyền truy cập lớp
        if (!$classroomId || !$classroomIds->contains($classroomId)) {
            abort(403, 'Bạn không được phân công dạy lớp này.');
        }

        // Lấy thông tin lớp
        $classroom = Classroom::findOrFail($classroomId);

        // Lấy danh sách học sinh đã được duyệt trong lớp
        $students = User::role('student')
            ->where('approved', true)
            ->where('classroom_id', $classroomId)
            ->get();

        // Lấy danh sách lớp để hiển thị tên lớp trong dropdown
        $classroomList = Classroom::whereIn('id', $classroomIds)->get();

        return view('teacher.scores.input', compact('students', 'classroom', 'classroomList'));
    }
    public function schedules()
    {
        $teacherId = Auth::id();
        $teacher = \App\Models\User::find($teacherId);

        // Lấy danh sách phân công môn học của giáo viên (kể cả lớp chủ nhiệm)
        $assignments = ClassroomSubjectTeacher::where('teacher_id', $teacherId)
            ->with(['classroom', 'subject'])
            ->get();

        $teachingSchedules = [];

        foreach ($assignments as $assignment) {
            $classroom = $assignment->classroom;
            $subjectName = $assignment->subject->name;

            // Lấy lịch học của lớp đó
            $schedules = Schedule::where('classroom_id', $classroom->id)->get();

            foreach ($schedules as $schedule) {
                foreach ($schedule->subjects as $i => $subj) {
                    if ($subj === $subjectName) {
                        $teachingSchedules[] = [
                            'classroom' => $classroom->name,
                            'day' => $schedule->day,
                            'session' => ucfirst($schedule->session),
                            'period' => $i + 1,
                            'subject' => $subjectName,
                        ];
                    }
                }
            }
        }

        return view('teacher.schedules.index', compact('teacher', 'teachingSchedules'));
    }


    public function classrooms()
    {
        $teacherId = Auth::id();

        $classrooms = Classroom::where('teacher_id', $teacherId)
            ->with([
                'students',
                'messages.user',
                'schedules'
            ])
            ->get();

        // ✅ Thêm phân công giáo viên theo môn
        $assignments = ClassroomSubjectTeacher::with(['subject', 'teacher'])
            ->whereIn('classroom_id', $classrooms->pluck('id'))
            ->get();

        return view('teacher.classrooms.index', compact('classrooms', 'assignments'));
    }
    public function storeScore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:50',
            'oral' => 'nullable|numeric|min:0|max:10',
            'attitude' => 'nullable|numeric|min:0|max:10',
            'midterm' => 'nullable|numeric|min:0|max:10',
            'final' => 'nullable|numeric|min:0|max:10',
        ]);

        \App\Models\Score::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'subject' => $request->subject,
                'term' => 'HK1', // nếu bạn dùng học kỳ
            ],
            [
                'oral' => $request->oral,
                'attitude' => $request->attitude,
                'midterm' => $request->midterm,
                'final' => $request->final,
                'score' => null, // ✅ tránh lỗi nếu chưa sửa migration
                'is_approved' => false,
                'teacher_id' => Auth::id(),
            ]
        );

        return back()->with('success', 'Đã cập nhật điểm môn ' . $request->subject);
    }
    public function destroyScore($id)
    {
        $score = \App\Models\Score::findOrFail($id);
        $score->delete();

        return back()->with('success', 'Đã xóa điểm môn ' . $score->subject);
    }
    public function editScore($id)
    {
        $score = \App\Models\Score::findOrFail($id);
        return view('teacher.scores.edit', compact('score'));
    }

    public function updateScore(Request $request, $id)
    {
        $request->validate([
            'oral' => 'nullable|numeric|min:0|max:10',
            'attitude' => 'nullable|numeric|min:0|max:10',
            'midterm' => 'nullable|numeric|min:0|max:10',
            'final' => 'nullable|numeric|min:0|max:10',
        ]);

        $score = \App\Models\Score::findOrFail($id);
        $score->update([
            'oral' => $request->oral,
            'attitude' => $request->attitude,
            'midterm' => $request->midterm,
            'final' => $request->final,
        ]);

        return redirect()->route('teacher.scores')->with('success', 'Đã cập nhật điểm môn ' . $score->subject);
    }
    public function approveScore($id)
    {
        $score = \App\Models\Score::findOrFail($id);

        // Chỉ giáo viên phụ trách mới được duyệt
        if ($score->teacher_id !== Auth::id()) {
            return back()->with('error', 'Bạn không có quyền duyệt điểm này.');
        }

        $score->update(['is_approved' => true]);

        return back()->with('success', 'Đã gửi điểm lên admin.');
    }

}
