<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;

class QuestionPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function update(User $user, Question $question)
    {
        return $user->id === $question->exam->doctor_id;
        // A doctor can only update questions belonging to their exams
    }

    // Add a delete method with the same logic as update()
    public function delete(User $user, Question $question)
    {
        return $user->id === $question->exam->doctor_id;
    }
}