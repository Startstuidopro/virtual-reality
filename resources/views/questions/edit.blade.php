@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Question') }} (for Exam: {{ $question->exam->name }})</div>

                <div class="card-body">
                    <form method="POST"
                        action="{{ route('questions.update', ['exam' => $question->exam->id, 'question' => $question->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="question_text">{{ __('Question Text') }}</label>
                            <textarea class="form-control @error('question_text') is-invalid @enderror"
                                id="question_text" name="question_text" rows="3"
                                required>{{ old('question_text', $question->question_text) }}</textarea>

                            @error('question_text')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category_id">{{ __('Category') }}</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $question->category_id ?? '')
                                    == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="answer_type">{{ __('Answer Type') }}</label>
                            <select class="form-control @error('answer_type') is-invalid @enderror" id="answer_type"
                                name="answer_type" required>
                                <option value="single_choice" {{ old('answer_type', $question->answer_type) ===
                                    'single_choice' ? 'selected' : '' }}>Single Choice</option>
                                <option value="multiple_choice" {{ old('answer_type', $question->answer_type) ===
                                    'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                <option value="open_ended" {{ old('answer_type', $question->answer_type) ===
                                    'open_ended' ? 'selected' : '' }}>Open Ended</option>
                            </select>

                            @error('answer_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="default_degree">{{ __('Default Degree') }}</label>
                            <input type="number" class="form-control @error('default_degree') is-invalid @enderror"
                                id="default_degree" name="default_degree"
                                value="{{ old('default_degree', $question->default_degree ?? '') }}" step="0.01">

                            @error('default_degree')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div id="options-container"
                            style="display: {{ in_array($question->answer_type, ['single_choice', 'multiple_choice']) ? 'block' : 'none' }};">
                            <label>{{ __('Options') }}</label>
                            @if($question->options)
                            @foreach($question->options as $option)
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="options[]" value="{{ $option }}"
                                    placeholder="Option 1">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary add-option" type="button">Add
                                        Option</button>
                                    <button class="btn btn-outline-danger remove-option" type="button">Remove</button>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="options[]" placeholder="Option 1">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary add-option" type="button">Add
                                        Option</button>
                                </div>
                            </div>
                            @endif

                            {{-- More options can be added dynamically here using JavaScript --}}
                        </div>

                        <div class="form-group">
                            <label for="correct_answer">{{ __('Correct Answer') }}</label>
                            <input type="text" class="form-control @error('correct_answer') is-invalid @enderror"
                                id="correct_answer" name="correct_answer"
                                value="{{ old('correct_answer', $question->correct_answer) }}" required>

                            @error('correct_answer')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Update Question') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript to show/hide options and handle adding/removing options (similar to create.blade.php)
    const answerTypeSelect = document.getElementById('answer_type');
    const optionsContainer = document.getElementById('options-container');
    const addOptionButton = document.querySelector('.add-option');

    answerTypeSelect.addEventListener('change', () => {
        if (answerTypeSelect.value === 'single_choice' || answerTypeSelect.value === 'multiple_choice') {
            optionsContainer.style.display = 'block';
        } else {
            optionsContainer.style.display = 'none';
        }
    });

    addOptionButton.addEventListener('click', () => {
        const newOption = document.createElement('div');
        newOption.classList.add('input-group', 'mb-2');
        newOption.innerHTML = `
            <input type="text" class="form-control" name="options[]" placeholder="New Option">
            <div class="input-group-append">
                <button class="btn btn-outline-danger remove-option" type="button">Remove</button>
            </div>
        `;
        optionsContainer.appendChild(newOption);

        // Add event listener to the new "Remove" button
        newOption.querySelector('.remove-option').addEventListener('click', () => {
            optionsContainer.removeChild(newOption);
        });
    });
</script>
@endsection