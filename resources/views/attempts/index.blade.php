@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Student Attempts for: {{ $exam->name }}</div>
                <div class="card-body">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Attempt ID</th>
                                <th>Student</th>
                                <th>Started At</th>
                                <th>Submitted?</th>
                                <th>Actions</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attempts as $attempt)
                                <tr>
                                    <td>{{ $attempt->id }}</td>
                                    <td>{{ $attempt->student->name }}</td>
                                    <td>{{ $attempt->start_time }}</td>
                                    <td>{{ $attempt->submitted ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <a href="{{ route('exams.attempts.show', [$exam, $attempt]) }}" class="btn btn-sm btn-info">View Results</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection