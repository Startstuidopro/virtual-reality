<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Exam;

class ExamPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function update(User $user, Exam $exam)
    {
        return $user->id === $exam->doctor_id; // Only the doctor who created it can update
    }
}