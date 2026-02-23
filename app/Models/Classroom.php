<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = ['name', 'teacher_id'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students()
    {
        return $this->hasMany(User::class, 'classroom_id')
            ->where('role', 'student');
    }

    // Danh sách phân công giáo viên bộ môn (truy cập bảng trung gian)
    public function subjectTeachers()
    {
        return $this->hasMany(ClassroomSubjectTeacher::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function classroom()
    {
        return $this->belongsTo(\App\Models\Classroom::class);
    }
}