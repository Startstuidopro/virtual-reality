@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Exam Details: ') }} {{ $exam->name }}
                    <a href="{{ route('exams.index') }}" class="btn btn-secondary">Back to Exams</a>
                </div>

                <div class="card-body">
                    <p><strong>Description:</strong> {{ $exam->description }}</p>
                    <p><strong>Doctor:</strong> {{ $exam->doctor->name }}</p> 

                    <hr> 

                    <h3>Questions</h3> 

                    @if ($exam->questions->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Question Text</th>
                                    <th>Answer Type</th> 
                                    <th>Actions</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($exam->questions as $question)
                                   
                                    <tr>
                                        <td>{{ $question->id }}</td>
                                        <td>{{ $question->question_text }}</td>
                                        <td>{{ $question->answer_type }}</td> 
                                        <td> 
                                        <a href="{{ route('questions.edit', ['exam' => $exam->id, 'question' => $question->id]) }}" class="btn btn-sm btn-primary">Edit</a>

                                            <form action="{{ route('questions.destroy', ['exam' => $exam->id, 'question' => $question->id]) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else 
                        <p>No questions added to this exam yet.</p>
                    @endif 

                    @if (Auth::user()->role === 'doctor' && $exam->doctor_id === Auth::id())
                    <div>
                                <a href="{{ route('questions.create', ['exam' => $exam->id]) }}" class="btn btn-primary">Add Question</a>
                                <a href="{{ route('questions.create.ai', ['exam' => $exam->id]) }}" class="btn btn-success">Add Questions with AI</a>
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection