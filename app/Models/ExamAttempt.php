<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'student_id',
        'start_time',
        'end_time',
        'submitted'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'attempt_id');
    }
    public function fullyAssessed()
    {
        // Check if any answers for this attempt do NOT have an assessment
        return $this->answers()->whereDoesntHave('assessment')->count() === 0; 
    }
    public function degree()
    {
        return $this->hasOne(StudentDegree::class);
    }
}
