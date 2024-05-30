@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Exam Results: {{ $attempt->exam->name }}</div>
                <div class="card-body">

                    <p><strong>Student:</strong> {{ $attempt->student->name }}</p>
                    <p><strong>Started:</strong> {{ $attempt->start_time }}</p>
                    <p><strong>Ended:</strong> {{ $attempt->end_time }}</p>

                    <hr>

                    <h4>Answers:</h4>
                    <ul>
                        @foreach ($attempt->exam->questions as $question)
                        <li>
                            <strong>{{ $question->question_text }}</strong>
                            (Default Degree: {{ $question->default_degree }})<br>
                            @php
                            $studentAnswer = $attempt->answers
                            ->where('question_id', $question->id)
                            ->first();
                            @endphp
                            @if ($studentAnswer)
                            Your Answer: {{ $studentAnswer->student_answer }}<br>
                            <strong>Degree:</strong> {{ $studentAnswer->degree ?? 'Not yet assessed' }}
                            {{-- Add logic to display correctness, other assessment results, etc. --}}
                            @else
                            Not Answered
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection