<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'question_id' => $this->question_id,
            'student_answer' => $this->student_answer,
            'assessment' => $this->assessment ?
                $this->assessment->assessment_data :
                ['assessment' => 'Under Review', 'is_correct' => null],
        ];
    }
}
