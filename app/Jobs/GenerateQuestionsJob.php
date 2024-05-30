<?php

namespace App\Jobs;

use App\Models\Exam;
use App\Models\Question;
use App\Models\QuestionCategory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GenerateQuestionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $textInput;
    protected $numQuestions;
    protected $questionLevel;
    protected $examId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($textInput, $numQuestions, $questionLevel, $examId)
    {
        $this->textInput = $textInput;
        $this->numQuestions = $numQuestions;
        $this->questionLevel = $questionLevel;
        $this->examId = $examId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 1. Get the exam
        $exam = Exam::findOrFail($this->examId);
        $categories = QuestionCategory::pluck('name', 'id');
        $categoryList = $categories->map(function ($name, $id) {
            return "$id: $name";
        })->implode(', ');

        // 2. Interact with Ollama's API:
        try {
            $response = Http::timeout(300)->post('http://localhost:11434/api/chat', [
                'model' => 'llama3', // Or your preferred model
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "Generate {$this->numQuestions} {$this->questionLevel} questions based on this text: {$this->textInput}.
                        For each question, also suggest a category ID from the following list:
                        {$categoryList}.

                        Return ONLY in the following JSON format - no other text or explanations:

                        [
                          { \"question\": \"question text\", \"answer\": \"answer\", \"category_id\": category_id },
                          { \"question\": \"question text\", \"answer\": \"answer\", \"category_id\": category_id },
                          // ... more questions
                        ]"
                    ]
                ], "format" => "json",
                'stream' => false, "options" => [
                    "temperature" => 0.1,
                    "num_ctx" => 8000,

                ]
            ]);

            $data = $response->json();
            Log::debug('Ollama Response:', $data);

            $d = json_decode($data['message']["content"], true); // true for associative array

            // 3. (Optional) Access the questions:
            $questions = $d['questions'];
            // dd($questions);
            $generatedQuestions = $questions;
        } catch (\Exception $e) {
            // Handle exceptions (log, notify user, etc.)
            Log::error('Error generating questions: ' . $e->getMessage());
            // ... (Implement additional error handling) ...
            return; // Exit the job
        }

        // 3. Store the generated questions:
        foreach ($generatedQuestions as $generatedQuestion) {
            $question = new Question([
                'question_text' => $generatedQuestion['question'],
                'answer_type' => 'open_ended', // Or determine from Ollama's response
                'options' => isset($generatedQuestion['options']) ? json_encode($generatedQuestion['options']) : null,
                'correct_answer' => $generatedQuestion['answer'],
                'degree' => $generatedQuestion['degree'],
                'category_id' => isset($generatedQuestion['category_id']) ? $generatedQuestion['category_id'] : 0, //$request->input('category_id'), // Assuming you still have a category input
            ]);

            $exam->questions()->save($question);
        }
    }
}
