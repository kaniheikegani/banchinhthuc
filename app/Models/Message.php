<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'classroom_id',
        'user_id',
        'content',
    ];

    // Quan hệ với người gửi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với lớp
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
