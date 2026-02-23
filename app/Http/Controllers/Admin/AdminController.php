<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeacherRequest;
use App\Models\StudentRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;




class AdminController extends Controller
{
    public function index()
    {
        $pendingStudents = User::role('student')->where('approved', false)->count();

        $pendingTeacherRequests = TeacherRequest::where('status', 'pending')->count();

        $pendingStudentRequests = StudentRequest::where('status', 'pending')
            ->where('receiver_type', 'admin') // chỉ tính yêu cầu học sinh gửi đến admin
            ->count();

        $pendingRequests = $pendingTeacherRequests + $pendingStudentRequests;

        return view('admin.dashboard', compact('pendingStudents', 'pendingRequests'));
    }

    public function wait()
    {
        $students = User::role('student')->where('approved', true)->get();
        $waitingStudents = User::role('student')->where('approved', false)->get();

        return view('admin.students.index', compact('students', 'waitingStudents'));
    }
}
