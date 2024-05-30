<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'doctor_name' => $this->doctor->name,
            'questions_count' => $this->questions->count(), // Add back questions_count
            'questions' => QuestionResource::collection($this->whenLoaded('questions')), // Include questions
            // ... other fields you need ...
        ];
    }
}
