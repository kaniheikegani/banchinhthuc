<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassroomSubjectTeacher;

class ClassroomChatController extends Controller
{
    // Hiển thị nhóm chat
    public function show($id)
    {
        $classroom = Classroom::with('students')->findOrFail($id);

        // Kiểm tra quyền truy cập
        $user = Auth::user();
        $isTeacher = $user->id === $classroom->teacher_id;
        $isStudent = $classroom->students->contains($user->id);

        if (!($isTeacher || $isStudent)) {
            abort(403, 'Bạn không thuộc lớp này');
        }

        $messages = Message::where('classroom_id', $id)->with('user')->latest()->take(50)->get();

        return view('teacher.classrooms.chat', compact('classroom', 'messages'));
    }

    // Gửi tin nhắn
    public function send(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $classroom = Classroom::findOrFail($id);
        $user = Auth::user();

        // Kiểm tra quyền gửi
        if ($user->id !== $classroom->teacher_id && !$classroom->students->contains($user->id)) {
            abort(403, 'Bạn không thuộc lớp này');
        }

        Message::create([
            'classroom_id' => $id,
            'user_id' => $user->id,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Đã gửi tin nhắn');
    }
}