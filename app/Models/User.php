<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships

    public function exams()
    {
        return $this->hasMany(Exam::class, 'doctor_id'); // Assuming 'doctor_id' is the foreign key in the exams table
    }

    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class, 'student_id'); // Assuming 'student_id' is the foreign key
    }

    public function permissions()
    {
        return $this->hasMany(ExamPermission::class, 'student_id');
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
