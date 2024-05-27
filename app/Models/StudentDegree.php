<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDegree extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_id',
        'score'
    ];

    public function attempt()
    {
        return $this->belongsTo(ExamAttempt::class);
    }
}
