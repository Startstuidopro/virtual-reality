<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;


class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $questions = Question::all();
    return view('questions.index', compact('questions'));
}

// Show the form for creating a new resource.
public function create()
{
    return view('questions.create');
}

// Store a newly created resource in storage.
public function store(Request $request)
{
    $validatedData = $request->validate([
        'question' => 'required|string|max:255',
        'answer' => 'required|string',
        'score' => 'required|integer|min:0|max:100'
    ]);

    Question::create($validatedData);
    return redirect()->route('questions.index')->with('success', 'Question created successfully.');
}

// Display the specified resource.
public function show(Question $question)
{
    return view('questions.show', compact('question'));
}

// Show the form for editing the specified resource.
public function edit(Question $question)
{
    return view('questions.edit', compact('question'));
}

// Update the specified resource in storage.
public function update(Request $request, Question $question)
{
    $validatedData = $request->validate([
        'question' => 'required|string|max:255',
        'answer' => 'required|string',
        'score' => 'required|integer|min:0|max:100'
    ]);

    $question->update($validatedData);
    return redirect()->route('questions.index')->with('success', 'Question updated successfully.');
}

// Remove the specified resource from storage.
public function destroy(Question $question)
{
    $question->delete();
    return redirect()->route('questions.index')->with('success', 'Question deleted successfully.');
}
}
