<?php

namespace App\Http\Controllers\API;

use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExamAttemptResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// ... other imports for Ollama, degree calculation, etc. ...

class ExamAttemptController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function start(Exam $exam)
    {
        // 1. Authorization (ensure the student can take this exam)
        //    - Check exam status (open, etc.)
        //    - Check if the student has permission (if using ExamPermission)

        $attempt = $exam->attempts()->create([
            'student_id' => Auth::id(),
            'start_time' => now(),
        ]);

        return new ExamAttemptResource($attempt);
    }

    public function show(Exam $exam, ExamAttempt $attempt)
    {
        // 1. Authorization: Ensure only the attempt owner can view it
        $this->authorize('view', $attempt);

        return new ExamAttemptResource($attempt->load('answers'));
    }

    public function submit(Request $request, Exam $exam, ExamAttempt $attempt)
    {
        // 1. Authorization: Ensure only the attempt owner can submit
        $this->authorize('update', $attempt);

        // 2. Validate submitted answers (logic depends on your question types)
        $validator = Validator::make($request->all(), [
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.student_answer' => 'required', // Add more validation as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 3. Store answers
        foreach ($request->input('answers', []) as $answerData) {
            $attempt->answers()->create([
                'question_id' => $answerData['question_id'],
                'student_answer' => $answerData['student_answer'],
            ]);
        }

        // 4. (Optional) Send answers to Ollama, handle async processing

        // 5. Update attempt
        $attempt->update([
            'end_time' => now(),
            'submitted' => true,
        ]);

        // 6. Calculate and store the degree (if not using async Ollama)
        // ... your logic to calculate and store the degree ...

        return new ExamAttemptResource($attempt->load('answers'));
    }
}