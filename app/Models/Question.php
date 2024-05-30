<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'question_text',
        'answer_type',
        'options',
        'correct_answer',
        'category_id'
    ];

    protected $casts = [
        'options' => 'array', // Make sure to cast the 'options' field to an array
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function category() 
    {
        return $this->belongsTo(QuestionCategory::class);
    }
}
