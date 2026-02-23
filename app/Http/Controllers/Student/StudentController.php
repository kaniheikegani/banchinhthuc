<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Score;
use App\Models\Classroom;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;



class StudentController extends Controller
{
    public function schedules()
    {
        $student = Auth::user();
        $classroom = $student->classroom;

        if (!$classroom) {
            $schedules = collect();
            return view('student.schedules', compact('schedules', 'classroom', 'student'))
                ->withErrors(['classroom' => 'Bạn chưa được gán vào lớp nào. Vui lòng liên hệ giáo viên hoặc quản trị viên.']);
        }

        // Lấy danh sách giáo viên dạy từng môn của lớp
        $subjectMap = \DB::table('classroom_subject_teacher')
            ->where('classroom_id', $classroom->id)
            ->get()
            ->mapWithKeys(function ($row) {
                $subject = \App\Models\Subject::find($row->subject_id)?->name;
                $teacher = \App\Models\User::find($row->teacher_id)?->name;
                return [$subject => $teacher];
            });

        // Truy vấn lịch học và gắn tên giáo viên vào từng môn
        $schedules = \App\Models\Schedule::where('classroom_id', $classroom->id)
            ->orderBy('day')
            ->orderBy('session')
            ->get()
            ->map(function ($schedule) use ($subjectMap) {
                $schedule->subjects = collect($schedule->subjects)->map(function ($subject) use ($subjectMap) {
                    return is_array($subject)
                        ? $subject // đã có giáo viên
                        : ['name' => $subject, 'teacher' => $subjectMap[$subject] ?? 'Chưa rõ'];
                })->toArray();
                return $schedule;
            });

        return view('student.schedules', compact('schedules', 'classroom', 'student'));
    }
    public function scores()
    {
        $student = Auth::user();
        $classroom = $student->classroom;

        $scores = $student->scores()->where('is_approved', true)->get();

        return view('student.scores', compact('student', 'scores', 'classroom'));
    }
    public function dashboard()
    {
        $student = Auth::user();
        $classroom = $student->classroom;

        return view('student.dashboard', compact('student', 'classroom'));
    }
    public function profile()
    {
        $student = Auth::user();
        $classroom = $student->classroom;

        return view('student.profile', compact('student', 'classroom'));
    }
}
