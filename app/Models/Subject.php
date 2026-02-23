<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name'];

    // Quan hệ với giáo viên bộ môn
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'classroom_subject_teacher')
                    ->withPivot('classroom_id')
                    ->withTimestamps();
    }
}