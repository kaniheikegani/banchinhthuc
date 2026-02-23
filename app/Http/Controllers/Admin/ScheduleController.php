<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $sessions = ['morning', 'afternoon'];
        $subjectsPool = ['Toán', 'Văn', 'Anh', 'Lý', 'Hóa', 'Sinh', 'Sử', 'Địa', 'Tin', 'GDCD', 'Chào cờ'];

        $classroomId = $request->input('classroom_id');

        if ($classroomId) {
            $schedules = Schedule::where('classroom_id', $classroomId)
                ->get()
                ->groupBy(['day', 'session']);
        } else {
            $schedules = Schedule::with('classroom')
                ->get()
                ->groupBy(['classroom_id', 'day', 'session']);
        }

        return view('admin.schedules.index', compact('days', 'sessions', 'schedules', 'subjectsPool', 'classroomId'));
    }

   public function generateRandom(Request $request)
    {
        $classroomId = $request->input('classroom_id');
        $preferredSession = $request->input('session'); // 'morning' hoặc 'afternoon'

        if (!in_array($preferredSession, ['morning', 'afternoon']) || !$classroomId) {
            return back()->with('error', 'Thiếu thông tin lớp hoặc buổi học.');
        }

        $classroom = \App\Models\Classroom::find($classroomId);
        if (!$classroom) {
            return back()->with('error', 'Lớp không tồn tại.');
        }

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $subjectsPool = ['Toán', 'Văn', 'Anh', 'Lý', 'Hóa', 'Sinh', 'Sử', 'Địa', 'Tin', 'GDCD'];

        foreach ($days as $day) {
            $subjects = collect($subjectsPool)->random(5)->values()->toArray();

            if ($day === 'Monday') {
                $subjects[0] = 'Chào cờ';
            }
            if ($day === 'Friday') {
                $subjects[4] = 'Sinh hoạt lớp';
            }

            // Tạo lịch cho buổi đã chọn
            \App\Models\Schedule::updateOrCreate(
                [
                    'day' => $day,
                    'session' => $preferredSession,
                    'classroom_id' => $classroom->id
                ],
                [
                    'subjects' => $subjects
                ]
            );

            // Xóa buổi còn lại nếu tồn tại
            $otherSession = $preferredSession === 'morning' ? 'afternoon' : 'morning';
            \App\Models\Schedule::where([
                ['day', '=', $day],
                ['session', '=', $otherSession],
                ['classroom_id', '=', $classroom->id]
            ])->delete();
        }

        // ✅ Chuyển về trang xem lịch lớp vừa random
        return redirect()->route('admin.schedules.index', ['classroom_id' => $classroom->id])
            ->with('success', 'Đã random lịch học buổi ' . ($preferredSession === 'morning' ? 'sáng' : 'chiều') . ' cho lớp ' . $classroom->name . '!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'subjects' => 'required|array|min:5|max:5',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->update([
            'subjects' => $request->subjects,
            'classroom_id' => $request->classroom_id
        ]);

        return redirect()->route('admin.schedules.index', ['classroom_id' => $request->classroom_id])
                         ->with('success', 'Lịch học đã được cập nhật!');
    }
}