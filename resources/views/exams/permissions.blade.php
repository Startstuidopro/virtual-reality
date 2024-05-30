@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Manage Exam Permissions: {{ $exam->name }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('exams.permissions.store', $exam) }}">
                        @csrf

                        <div class="form-group">
                            <label for="student_id">Select Student:</label>
                            <select class="form-control" id="student_id" name="student_id" required>
                                <option value="">Select a Student</option>
                                @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="allowed" name="allowed" value="1"
                                checked>
                            <label class="form-check-label" for="allowed">Allow Student to take this Exam</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Permission</button>
                    </form>

                    <hr>
                    <h4>Existing Permissions:</h4>
                    <ul>
                        @forelse ($exam->permissions as $permission)
                        <li>
                            {{ $permission->student->name }} -
                            {{ $permission->allowed ? 'Allowed' : 'Not Allowed' }}
                            <form action="{{ route('exams.permissions.destroy', [$exam, $permission]) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">Remove</button>
                            </form>
                        </li>
                        @empty
                        <li>No permissions set yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection