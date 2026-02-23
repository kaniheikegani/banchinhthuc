<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classroom;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassroomSubjectTeacher;
use App\Models\Schedule;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = \App\Models\User::role('teacher')->with('classrooms')->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function scores()
    {
        $teacherId = Auth::id();
        $classroom = Classroom::where('teacher_id', $teacherId)->first();

        if (!$classroom) {
            return view('teacher.scores', ['students' => [], 'classroom' => null]);
        }

        $students = User::role('student')
            ->where('approved', true)
            ->where('classroom_id', $classroom->id)
            ->with('score') // Eager load điểm
            ->get();

        return view('teacher.scores', compact('students', 'classroom'));
    }
    public function schedules()
    {
        $user = Auth::user();

        // Lấy các lớp mà giáo viên phụ trách
        $classrooms = Classroom::where('teacher_id', $user->id)->with('schedules')->get();

        return view('teacher.classrooms.index', compact('classrooms'));
    }
    public function schedule(User $teacher)
    {
        // Lấy danh sách phân công môn học của giáo viên (bao gồm cả lớp chủ nhiệm)
        $assignments = ClassroomSubjectTeacher::where('teacher_id', $teacher->id)
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

        return view('admin.teachers.schedule', compact('teacher', 'teachingSchedules'));
    }
}

