<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentRequest;
use App\Models\User; // ✅ THÊM DÒNG NÀY
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class StudentRequestController extends Controller
{
    public function index()
    {
        $requests = StudentRequest::where('user_id', Auth::id())->latest()->get();
        return view('student.requests.index', compact('requests'));
    }

    public function create()
    {
        return view('student.requests.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:info,confirmation,score,absence', // ✅ thêm absence
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);

        $student = Auth::user();

        // ✅ Gán người nhận dựa trên loại đề xuất
        if (in_array($request->type, ['score', 'absence'])) {
            // Gửi cho giáo viên chủ nhiệm
            $receiver = $student->classroom->teacher; // cần quan hệ teacher()
            $receiverType = 'teacher';
        } else {
            // Gửi cho người có role admin
            $receiver = User::role('admin')->first(); // lấy admin đầu tiên
            $receiverType = 'admin';
        }

        StudentRequest::create([
            'user_id' => $student->id,
            'type' => $request->type,
            'title' => $request->title,
            'content' => $request->content,
            'receiver_id' => $receiver?->id,
            'receiver_type' => $receiverType,
        ]);

        return redirect()->route('student.requests.index')->with('success', 'Đề xuất đã được gửi');
    }
    public function destroy($id)
    {
        $request = StudentRequest::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending') // chỉ cho xóa nếu chưa duyệt
            ->firstOrFail();

        $request->delete();

        return redirect()->route('student.requests.index')->with('success', 'Yêu cầu đã được xóa');
    }
    
}