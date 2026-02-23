<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::with([
            'teacher',
            'subjectTeachers.subject',
            'subjectTeachers.teacher'
        ])->get();

        return view('admin.classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        $teachers = User::role('teacher')->get();
        $subjects = Subject::all(); // ← thêm dòng này

        return view('admin.classrooms.create', compact('teachers', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:users,id',
            'subject_teachers' => 'array',
            'subject_teachers.*' => 'nullable|exists:users,id',
        ]);

        $classroom = Classroom::create($request->only('name', 'teacher_id'));

        // Phân công giáo viên bộ môn
        foreach ($request->subject_teachers ?? [] as $subjectId => $teacherId) {
            if ($teacherId) {
                $exists = DB::table('classroom_subject_teacher')->where([
                    'classroom_id' => $classroom->id,
                    'subject_id' => $subjectId,
                ])->exists();

                if (!$exists) {
                    DB::table('classroom_subject_teacher')->insert([
                        'classroom_id' => $classroom->id,
                        'subject_id' => $subjectId,
                        'teacher_id' => $teacherId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return redirect()->route('admin.classrooms')->with('success', 'Lớp học đã được tạo và phân công giáo viên bộ môn.');
    }

    public function assign(User $teacher)
    {
        // Lấy tất cả lớp chưa có giáo viên
        $availableClassrooms = Classroom::whereNull('teacher_id')->get();

        return view('admin.classrooms.assign', [
            'teacher' => $teacher,
            'classrooms' => $availableClassrooms
        ]);
    }
    public function storeAssignment(Request $request, User $teacher)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id'
        ]);

        $classroom = Classroom::find($request->classroom_id);
        $classroom->teacher_id = $teacher->id;
        $classroom->save();

        return redirect()->route('admin.teachers')->with('success', 'Đã phân lớp cho giáo viên.');
    }
    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);
        $teachers = User::role('teacher')->get();
        return view('admin.classrooms.edit', compact('classroom', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:users,id'
        ]);

        $classroom = Classroom::findOrFail($id);
        $classroom->update($request->only('name', 'teacher_id'));

        return redirect()->route('admin.classrooms')->with('success', 'Đã cập nhật lớp học.');
    }

    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();

        return redirect()->route('admin.classrooms')->with('success', 'Đã xóa lớp học.');
    }

    public function assignSubject($classroomId)
    {
        $classroom = Classroom::findOrFail($classroomId);
        $subjects = Subject::all();
        $teachers = User::role('teacher')->get();

        return view('admin.classrooms.assign_subject', compact('classroom', 'subjects', 'teachers'));
    }

    public function storeMultipleSubjectAssignments(Request $request, $classroomId)
    {
        $request->validate([
            'subjects' => 'required|array',
            'teachers' => 'required|array',
        ]);

        foreach ($request->subjects as $index => $subjectId) {
            $teacherId = $request->teachers[$index];

            if ($teacherId) {
                DB::table('classroom_subject_teacher')->updateOrInsert(
                    [
                        'classroom_id' => $classroomId,
                        'subject_id' => $subjectId,
                    ],
                    [
                        'teacher_id' => $teacherId,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }

        return redirect()->route('admin.classrooms')->with('success', 'Đã phân công giáo viên cho các môn học.');
    }

}
