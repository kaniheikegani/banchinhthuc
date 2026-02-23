<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentRequest;


class RequestController extends Controller
{
    public function index()
    {
        $requests = \App\Models\TeacherRequest::with(['teacher', 'classroom', 'subject'])
            ->latest()
            ->get();

        $studentRequests = \App\Models\StudentRequest::with('student')
            ->where('receiver_type', 'admin') // chỉ lấy yêu cầu gửi đến admin
            ->latest()
            ->get();

        return view('admin.requests.index', compact('requests', 'studentRequests'));
    }
    public function approve($id)
    {
        $req = \App\Models\TeacherRequest::findOrFail($id);
        $req->update(['status' => 'approved']);

        return back()->with('success', '✅ Yêu cầu đã được duyệt');
    }

    public function reject($id)
    {
        $req = \App\Models\TeacherRequest::findOrFail($id);
        $req->update(['status' => 'rejected']);

        return back()->with('error', '❌ Yêu cầu đã bị từ chối');
    }
    public function studentRequests()
    {
        $requests = StudentRequest::with('student')->latest()->get();

        return view('admin.requests.student', compact('requests'));
    }
    public function approveStudent($id)
    {
        $req = StudentRequest::findOrFail($id);
        $req->update(['status' => 'approved']);

        return back()->with('success', '✅ Yêu cầu học sinh đã được duyệt');
    }

    public function rejectStudent($id)
    {
        $req = StudentRequest::findOrFail($id);
        $req->update(['status' => 'rejected']);

        return back()->with('error', '❌ Yêu cầu học sinh đã bị từ chối');
    }
}
