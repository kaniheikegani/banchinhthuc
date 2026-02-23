<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassroomSubjectTeacher extends Model
{
    protected $table = 'classroom_subject_teacher';

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

}