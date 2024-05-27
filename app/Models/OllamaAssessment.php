<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OllamaAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'answer_id',
        'assessment_data',
    ];

    protected $casts = [
        'assessment_data' => 'array', // Casting assessment data to an array
    ];

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}
