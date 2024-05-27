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
            'doctor' => $this->doctor->name, // Assuming you want to include the doctor's name
            'questions' => QuestionResource::collection($this->whenLoaded('questions')),
            // Only include questions if loaded (e.g., in show() method)
            // ... other fields you want to include ...
        ];
    }
}