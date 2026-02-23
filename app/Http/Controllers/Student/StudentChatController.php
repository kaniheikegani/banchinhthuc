<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Classroom;
use App\Models\Message;

class StudentChatController extends Controller
{
    public function show($id)
    {
        $student = Auth::user();
        $classroom = Classroom::findOrFail($id);

        // Chỉ cho xem nếu học sinh thuộc lớp đó
        if ($student->classroom_id !== $classroom->id) {
            abort(403, 'Bạn không có quyền truy cập nhóm lớp này.');
        }

        $messages = Message::where('classroom_id', $classroom->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('student.chat', compact('classroom', 'messages', 'student'));
    }

    public function send(Request $request, $id)
    {
        $student = Auth::user();
        $classroom = Classroom::findOrFail($id);

        if ($student->classroom_id !== $classroom->id) {
            abort(403);
        }

        Message::create([
            'classroom_id' => $classroom->id,
            'user_id' => $student->id,
            'content' => $request->input('content'),
        ]);

        return redirect()->route('student.classroom.chat', $classroom->id);
    }
}
