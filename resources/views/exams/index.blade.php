@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Exams') }}
                    @if (Auth::user()->role === 'doctor') 
                        <a href="{{ route('exams.create') }}" class="btn btn-primary">Create New Exam</a>
                    @endif
                </div>

                <div class="card-body">
                    @if (session('success'))
                         <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Doctor</th> 
                                <th>Actions</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($exams as $exam)
                                <tr>
                                    <td>{{ $exam->id }}</td>
                                    <td>{{ $exam->name }}</td>
                                    <td>{{ $exam->description }}</td>
                                    <td>{{ $exam->doctor->name }}</td>  
                                    <td>
                                        <a href="{{ route('exams.show', $exam->id) }}" class="btn btn-sm btn-info">View</a>
                                        @if (Auth::user()->role === 'doctor' && $exam->doctor_id === Auth::id())
                                            <a href="{{ route('exams.edit', $exam->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        @endif
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