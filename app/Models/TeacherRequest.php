<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherRequest extends Model
{
    protected $fillable = ['teacher_id', 'classroom_id',   // ✅ thêm dòng này
    'subject_id',  'type', 'reason', 'requested_date', 'session', 'status'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

}