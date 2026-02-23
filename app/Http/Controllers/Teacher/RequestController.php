<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeacherRequest;
use App\Models\StudentRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;




class RequestController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $requests = $user->requests()->latest()->get();

        $classrooms = \App\Models\Classroom::all()->pluck('name', 'id');
        $subjects = \App\Models\Subject::all()->pluck('name', 'id');

        return view('teacher.requests.index', compact('requests', 'classrooms', 'subjects'));
    }

    public function store(Request $request)
    {
        // ✅ Bước 1: Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'type' => 'required|string',
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'requested_date' => 'required|date',
            'session' => 'required|string',
            'reason' => 'required|string|max:1000',
        ]);

        // ✅ Bước 2: Gắn thêm thông tin giáo viên và trạng thái
        $validated['teacher_id'] = auth()->id();
        $validated['status'] = 'pending';

        // ✅ Bước 3: Lưu vào database
        $requestCreated = \App\Models\TeacherRequest::create($validated);

        // ✅ Bước 4: Kiểm tra lại bằng log hoặc dd nếu cần
        // \Log::info('Yêu cầu mới:', $requestCreated->toArray());
        // dd($requestCreated);

        // ✅ Bước 5: Chuyển hướng sau khi lưu
        return redirect()->route('teacher.requests.index')->with('success', 'Yêu cầu đã được gửi đến admin');
    }
    public function studentRequests()
    {
        $teacher = auth()->user();

        $requests = StudentRequest::where('receiver_type', 'teacher')
            ->where('receiver_id', $teacher->id)
            ->where('type', 'score')
            ->latest()
            ->with('student') // cần quan hệ student() trong model StudentRequest
            ->get();

        return view('teacher.requests.student', compact('requests'));
    }
    public function destroy($id)
    {
        $request = \App\Models\StudentRequest::findOrFail($id);

        // Kiểm tra quyền: chỉ giáo viên nhận yêu cầu mới được xóa
        if ($request->receiver_type !== 'teacher' || $request->receiver_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền xóa yêu cầu này.');
        }

        $request->delete();

        return back()->with('success', 'Yêu cầu đã được xóa thành công.');
    }

}
