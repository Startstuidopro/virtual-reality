<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\OllamaAssessment;

class ExamAttemptController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Exam $exam, ExamAttempt $attempt)
    {
        // 1. Authorization: Only the attempt owner (student) or the exam's doctor can view the results
        if (Auth::user()->id !== $attempt->student_id && Auth::user()->id !== $exam->doctor_id) {
            abort(403, 'Unauthorized');
        }

        $attempt->load('exam.questions', 'answers');

        return view('attempts.show', [
            'attempt' => $attempt,
            'exam' => $exam,
        ]);
    }

    public function index(Exam $exam)
    {
        // 1. Authorization: Only the doctor of the exam can view all attempts
        // if (Auth::user()->id !== $exam->doctor_id) {
        //     abort(403, 'Unauthorized');
        // }

        $attempts = $exam->attempts()->with('student')->get();

        return view('attempts.index', [
            'exam' => $exam,
            'attempts' => $attempts,
        ]);
    }

    public function assess(Exam $exam, ExamAttempt $attempt)
    {
        // 1. Authorization: Ensure only the exam's doctor can assess attempts.
        if (Auth::user()->id !== $exam->doctor_id) {
            abort(403, 'Unauthorized');
        }

        // 2. Get unassessed questions for this attempt:
        $unassessedQuestions = $exam->questions()
            ->whereDoesntHave('answers.assessment', function ($query) use ($attempt) {
                $query->where('attempt_id', $attempt->id);
            })
            ->get();

        // 3. Assess each question individually:
        foreach ($unassessedQuestions as $question) {
            $studentAnswer = $attempt->answers()->where('question_id', $question->id)->first();

            if ($studentAnswer) {
                $this->assessQuestion($question, $studentAnswer);
            }
        }

        return redirect()->back()->with('success', 'Assessment initiated!');
    }

    // Helper function to assess a single question
    private function assessQuestion($question, $studentAnswer)
    {
        try {
            $response = Http::post('http://localhost:11434/api/chat', [
                'model' => 'llama2',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $this->buildOllamaPromptForQuestion($question, $studentAnswer)
                    ]
                ],
                'stream' => false
            ]);

            $data = $response->json();
            $this->processOllamaResponseForQuestion($data, $studentAnswer);
        } catch (\Exception $e) {
            Log::error('Error assessing question: ' . $e->getMessage());
            // ... (Additional error handling)
        }
    }

    // Helper function to build the prompt for a single question
    private function buildOllamaPromptForQuestion($question, $studentAnswer)
    {
        $prompt = "Assess the following student answer and provide a JSON response with feedback and a degree.
                      Use the default degree as a guide and adjust the student's degree based on the accuracy of their answer.

                      JSON format:
                      {
                          \"assessment\": \"assessment text\",
                          \"is_correct\": true/false,
                          \"degree\": student_degree
                      }

                      Data:\n";

        $prompt .= "Question: " . $question->question_text . "\n";
        $prompt .= "Correct Answer: " . $question->correct_answer . "\n";
        $prompt .= "Default Degree: " . $question->default_degree . "\n";
        $prompt .= "Student Answer: " . $studentAnswer->student_answer . "\n";

        return $prompt;
    }

    // Helper function to process Ollama's response for a single question
    private function processOllamaResponseForQuestion($ollamaResponse, $studentAnswer)
    {
        $assessment = json_decode($ollamaResponse['message']['content'], true);

        // Validate the response format...

        OllamaAssessment::create([
            'answer_id' => $studentAnswer->id,
            'assessment_data' => json_encode([
                'assessment' => $assessment['assessment'],
                'is_correct' => $assessment['is_correct'],
            ]),
        ]);

        $studentAnswer->update(['degree' => $assessment['degree']]);
    }
}
