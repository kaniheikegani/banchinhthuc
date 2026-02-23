<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'day',
        'session',
        'subjects',
        'classroom_id',
    ];

    protected $casts = [
        'subjects' => 'array',
    ];

    // ✅ Quan hệ với Classroom
    public function classroom()
    {
        return $this->belongsTo(\App\Models\Classroom::class);
    }
}