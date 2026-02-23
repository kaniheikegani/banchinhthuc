<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRequest extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'content',
        'status',
        'receiver_id',     // ✅ thêm dòng này
        'receiver_type',   // ✅ thêm dòng này
    ];
    public function student()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
