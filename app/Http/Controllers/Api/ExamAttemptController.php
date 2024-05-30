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
    public function index(Request $request)
    {
        $attempts = ExamAttempt::where('student_id', Auth::id())
            ->with('exam.questions', 'answers.assessment')
            ->get();

        return ExamAttemptResource::collection($attempts);
    }
    public function show(ExamAttempt $attempt)
    {
        // Authorization (make sure the student can only see their own attempt)
        if (Auth::user()->id !== $attempt->student_id) {
            abort(403, 'Unauthorized');
        }

        $attempt->load('exam.questions', 'answers.assessment');

        return new ExamAttemptResource($attempt);
    }

    // Start an Exam Attempt
    public function start(Exam $exam)
    {
        // Authorization: Make sure the student is allowed to take this exam.
        // ... (Implement your authorization logic here) ...

        $attempt = $exam->attempts()->create([
            'student_id' => Auth::id(),
            'start_time' => now(),
        ]);

        return new ExamAttemptResource($attempt);
    }

    // Submit Answers
    public function submit(Request $request, Exam $exam, ExamAttempt $attempt)
    {
        // Authorization: Make sure the authenticated user owns this attempt
        if (Auth::user()->id !== $attempt->student_id) {
            abort(403, 'Unauthorized');
        }

        // 1. Validation:
        $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.student_answer' => 'required', // Add more validation as needed
        ]);

        // 2. Store Answers:
        foreach ($request->input('answers', []) as $answerData) {
            $attempt->answers()->create([
                'question_id' => $answerData['question_id'],
                'student_answer' => $answerData['student_answer'],
            ]);
        }

        // 3. Update end time:
        $attempt->update(['end_time' => now(), 'submitted' => true]);

        return new ExamAttemptResource($attempt->load('answers'));
    }
}
