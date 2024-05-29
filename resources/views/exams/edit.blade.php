@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Exam: ') }} {{ $exam->name }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('exams.update', $exam->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">{{ __('Exam Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $exam->name) }}" required>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $exam->description) }}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="doctor_id">{{ __('Doctor') }}</label>
                            <select class="form-control @error('doctor_id') is-invalid @enderror" id="doctor_id" name="doctor_id" required>
                                <option value="">Select Doctor</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id', $exam->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('doctor_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Update Exam') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection