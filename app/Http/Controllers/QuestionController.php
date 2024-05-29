<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate; // Or use Policies if you prefer

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Exam $exam)
    {
        // Show the form to create a new question for the given exam.
        return view('questions.create', ['exam' => $exam]);
    }

    public function store(Request $request, Exam $exam)
    {
        $request->validate([
            'question_text' => 'required|string',
            'answer_type' => 'required|in:single_choice,multiple_choice,open_ended',
            'options' => 'sometimes|array', // For multiple-choice, validate as array
            'correct_answer' => 'required', // Logic might depend on answer_type
            // ... other validation rules ...
        ]);

        $exam->questions()->create($request->all());

        return redirect()->route('exams.show', $exam)->with('success', 'Question created successfully!');
    }
    public function edit(Request $request, Exam $exam, $question) 
{
    $question = Question::findOrFail($question); 
        $this->authorize('update', $question);

        $question->load('exam');
        return view('questions.edit', ['question' => $question]);
    }



    public function update(Request $request, Question $question)
    {
        $this->authorize('update', $question);

        // Check if the exam has been attempted
        if ($question->exam->attempts()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot update a question for an exam that has attempts!');
        }
        $request->validate([
            // ... validation rules for updating (similar to store) ...
        ]);

        $question->update($request->all());

        return redirect()->route('exams.show', $question->exam)
            ->with('success', 'Question updated successfully!');

        return redirect()->route('exams.show', $question->exam)->with('success', 'Question updated successfully!');
    }

    public function destroy(Request $request, Exam $exam, $question) 
    {
        $question = Question::findOrFail($question); 
        $this->authorize('delete', $question);

        $exam = $question->exam;
        $question->delete();

        return redirect()->route('exams.show', $exam)->with('success', 'Question deleted successfully!');
    }
}