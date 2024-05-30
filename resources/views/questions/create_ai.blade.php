// resources/views/questions/create_ai.blade.php

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Questions with AI') }} (for Exam: {{ $exam->name }})</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('questions.store.ai', ['exam' => $exam->id]) }}"> 
                        @csrf 

                        <div class="form-group">
                            <label for="text_input">{{ __('Enter Text') }}</label>
                            <textarea class="form-control @error('text_input') is-invalid @enderror" id="text_input" name="text_input" rows="8" required>{{ old('text_input') }}</textarea>
                            @error('text_input')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="num_questions">{{ __('Number of Questions') }}</label>
                            <input type="number" class="form-control @error('num_questions') is-invalid @enderror" id="num_questions" name="num_questions" value="{{ old('num_questions', 3) }}" min="1" required>
                            @error('num_questions')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="question_level">{{ __('Question Level') }}</label>
                            <select class="form-control @error('question_level') is-invalid @enderror" id="question_level" name="question_level" required>
                                <option value="easy" {{ old('question_level') === 'easy' ? 'selected' : '' }}>Easy</option>
                                <option value="medium" {{ old('question_level') === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="hard" {{ old('question_level') === 'hard' ? 'selected' : '' }}>Hard</option>
                            </select>
                            @error('question_level')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Generate Questions</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection