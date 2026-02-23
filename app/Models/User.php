<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Classroom;
use App\Models\Subject;




class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'approved',
        'classroom_id',
        'student_code',
        'role',
        'birthday',
        'cccd',
        'phone',
        'father_name',
        'mother_name',
        'parent_phone', // ✅ thêm dòng này
        'gender',
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function scores()
    {
        return $this->hasMany(\App\Models\Score::class, 'user_id');
    }
   public function classrooms()
    {
        return $this->hasMany(Classroom::class, 'teacher_id');
    }
    public function teachingAssignments()
    {
        return $this->belongsToMany(Subject::class, 'classroom_subject_teacher')
                    ->withPivot('classroom_id')
                    ->withTimestamps();
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'classroom_subject_teacher', 'teacher_id', 'subject_id')
            ->withPivot('classroom_id')
            ->withTimestamps();
    }
    // Lấy lớp mà học sinh này đang học
    public function studentClassroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
    public function teachersForClassroom($classroomId)
    {
        return $this->teachers()->wherePivot('classroom_id', $classroomId)->get();
    }
    public function requests()
    {
        return $this->hasMany(TeacherRequest::class, 'teacher_id');
    }
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'classroom_subject_teacher', 'classroom_id', 'teacher_id')
            ->withPivot('subject_id')
            ->withTimestamps();
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
}
