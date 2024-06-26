<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'question_text' => $this->question_text,
            'answer_type' => $this->answer_type,
            'options' => $this->options,
            'category_id' => $this->category_id,
            'default_degree' => $this->default_degree,
            // ... other fields ...
        ];
    }
}
