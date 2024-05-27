<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Question;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;

class StudentAnswerController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate the incoming data
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'question_id' => 'required|integer',
            'answer' => 'required|string',
        ]);

        // 2. Attempt to authenticate the user
        $user = Student::where('username', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['Invalid username or password.'],
            ]);
        }

        // 3. Find the question
        $question = Question::find($request->question_id);
        if (!$question) {
            return response()->json(['error' => 'Question not found.'], 404);
        }

        // 4. Create the student answer
        $studentAnswer = new StudentAnswer;
        $studentAnswer->student_id = $user->id;
        $studentAnswer->question_id = $question->id;
        $studentAnswer->answer = $request->answer;
        $studentAnswer->is_correct = '0';
        $studentAnswer->save();

        // 5. Return success response
        return response()->json(['message' => 'Answer submitted successfully.'], 201);
    }
    public function getAnsweredQuestions(Request $request)
    {
        // 1. Validate the incoming data
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Attempt to authenticate the user
        $user = Student::where('username', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['Invalid username or password.'],
            ]);
        }

        // 3. Retrieve answered questions
        $answeredQuestions = $user->answers()->with('question')->get()->map(function ($answer) {
            $questionData = [
                // 'question_id' => $answer->question_id,
                'question' => $answer->question->question,
                // 'answer' => $answer->answer,
                'is_correct' => $answer->is_correct
            ];

            // Call generation if the answer is incorrect
            if ($answer->is_correct == '0') {
                // Call your generation function here, passing in the question
                $generatedText = $this->generate($answer->question->question);

                // Add generated text to the question data
                $questionData['is_correct'] = $generatedText;

                // Update the is_correct flag if the generated answer matches the correct answer

                $answer->is_correct = $generatedText; // Set is_correct to true
                $answer->save(); // Save the updated answer
            }

            return $questionData;
        });

        // 4. Return the answered questions
        return response()->json($answeredQuestions);
    }

    public function generate(String $prompt)
    {


        $url = 'http://localhost:11434/api/generate'; // Your LLM server URL

        $response = Http::post($url, [
            'model' => "meditron:latest",
            'prompt' => $prompt,
            'stream' => false
        ]);

        if ($response->successful()) {
            $response_data = $response->json();
            // Extract the generated text
            $generatedText = $response_data['response']; // Assuming the generated text is in the 'response' field
            return $generatedText;
        } else {
            return 'Error generating answer'; // Handle errors appropriately
        }
    }
}
