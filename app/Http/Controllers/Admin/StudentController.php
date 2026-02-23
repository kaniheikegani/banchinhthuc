<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class StudentController extends Controller
{
   public function index()
    {
            $students = User::role('student')
                ->where('approved', true)
                ->with('studentClassroom')
                ->get();

        $classrooms = \App\Models\Classroom::all(); // để dùng trong form sửa

        return view('admin.students.index', compact('students', 'classrooms'));
    }

   public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'student_code' => 'required|unique:users',
            'password' => 'nullable|min:6',
            'classroom_id' => 'nullable|exists:classrooms,id',
        ]);

        // ✅ Mật khẩu mặc định theo mã học sinh
        $password = $validated['password'] ?? 'kani_' . $validated['student_code'];

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'student_code' => $validated['student_code'],
            'password' => Hash::make($password),
            'classroom_id' => $validated['classroom_id'],
            'approved' => true,
        ]);

        $user->assignRole('student');

        return redirect()->route('admin.students')->with([
            'success' => 'Đã thêm học sinh mới!',
            'new_password' => $password,
            'new_email' => $user->email,
        ]);
    }


  public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'student_code' => 'required|unique:users,student_code,' . $id,
            'classroom_id' => 'nullable|exists:classrooms,id',
            'password' => 'nullable|min:6',
            'birthday' => 'nullable|date',
            'cccd' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20', // ✅ thêm dòng này
            'gender' => 'nullable|in:male,female,other',
        ]);

        $student = User::role('student')->findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'student_code' => $request->student_code,
            'classroom_id' => $request->classroom_id,
            'birthday' => $request->birthday,
            'cccd' => $request->cccd,
            'phone' => $request->phone,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'parent_phone' => $request->parent_phone, // ✅ thêm dòng này
            'gender' => $request->gender, // ✅ thêm dòng này  
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $student->update($data);

        return redirect()->route('admin.students')->with('success', 'Cập nhật học sinh thành công!');
    }
    
    public function destroy($id)
    {
        $student = User::findOrFail($id); // ✅ dùng User thay vì Student
        $student->delete();

        return redirect()->route('admin.students')->with('success', 'Xóa học sinh thành công!');
    }
    public function approve($id)
    {
        $student = User::findOrFail($id);

        if ($student->hasRole('student') && !$student->approved) {
            $student->update(['approved' => true]);
        }

        return redirect()->route('admin.students')->with('success', 'Học sinh đã được duyệt.');
    }
}
