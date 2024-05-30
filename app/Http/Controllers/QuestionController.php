<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate; // Or use Policies if you prefer
use App\Models\QuestionCategory;
use Illuminate\Support\Facades\Http; // Use Laravel's HTTP client
use App\Jobs\GenerateQuestionsJob;
class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Exam $exam)
{
    $categories = QuestionCategory::all(); // Fetch all question categories
    return view('questions.create', ['exam' => $exam, 'categories' => $categories]);
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
    public function edit(Request $request, Exam $exam, $q) 
{
    $question = Question::findOrFail($q); 
        $this->authorize('update', $question);

        $question->load('exam');
        $categories = QuestionCategory::all(); // Fetch all question categories
        
    return view('questions.edit', ['question' => $question, 'categories' => $categories]);
        
    }



    public function update(Request $request,$exam, $question)
    {
        $q = Question::findOrFail($question);
        
        $this->authorize('update', $q);

        // Check if the exam has been attempted
        if ($q->exam->attempts()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot update a question for an exam that has attempts!');
        }
        $request->validate([
            // ... validation rules for updating (similar to store) ...
        ]);
        
        $q->update($request->except('category_id')); // Update all fields except category_id

        // Update the category using the associate() method:
        $q->category()->associate($request->category_id)->save(); 
        // dd($q->exam_id);
        return redirect()->route('exams.show', $q->exam_id)
            ->with('success', 'Question updated successfully!');

        
    }
    public function createWithAI(Exam $exam)
{
    // 1. Authorization (if needed)
    // ...

    // 2. Pass any necessary data to the view 
    // (e.g., exam details, potential AI model options, etc.)
    return view('questions.create_ai', ['exam' => $exam]); 
}
public function storeAI(Request $request, Exam $exam)
{
    // 1. Authorization (if needed)
    // ...

    // 2. Validation: 
    $request->validate([
        'text_input' => 'required|string',
        'num_questions' => 'required|integer|min:1',
        'question_level' => 'required|in:easy,medium,hard',
    ]);

    $textInput = $request->input('text_input');
        $numQuestions = $request->input('num_questions');
        $questionLevel = $request->input('question_level');
        GenerateQuestionsJob::dispatch($textInput, $numQuestions, $questionLevel, $exam->id); 
    return redirect()->route('exams.show', $exam)->with('success', 'Questions generated successfully!');
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