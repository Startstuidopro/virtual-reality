<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamAttemptResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'exam_id' => $this->exam_id,
            'student_id' => $this->student_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'submitted' => $this->submitted,
            'exam' => new ExamResource($this->whenLoaded('exam')),
            'answers' => AnswerResource::collection($this->whenLoaded('answers')),

        ];
    }
}
