<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'user_id',
        'subject',
        'term',
        'oral',
        'attitude',
        'midterm',
        'final',
        'score',       // ✅ thêm
        'grade',       // ✅ thêm
        'teacher_id',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    // Quan hệ với học sinh
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với giáo viên
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Accessor xếp loại tổng điểm (nếu cần)
    public function getGradeAttribute(): string
    {
        $average = $this->average_score;

        if ($average >= 8.5) {
            return 'Giỏi';
        } elseif ($average >= 7) {
            return 'Khá';
        } elseif ($average >= 5) {
            return 'Trung bình';
        } else {
            return 'Yếu';
        }
    }

    // Accessor tính điểm trung bình
    public function getAverageScoreAttribute(): ?float
    {
        $oral     = $this->oral ?? 0;
        $attitude = $this->attitude ?? 0;
        $midterm  = $this->midterm ?? 0;
        $final    = $this->final ?? 0;

        $totalWeight = 7;
        $weightedTotal = $oral + $attitude + ($midterm * 2) + ($final * 3);

        return round($weightedTotal / $totalWeight, 1);
    }
}