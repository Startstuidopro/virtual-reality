@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create New User') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>

                            @error('password')
                             <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>

                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
                        </div>
 
                        <div class="form-group">
                            <label for="role">{{ __('Role') }}</label>
                            <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="doctor" {{ old('role') === 'doctor' ? 'selected' : '' }}>Doctor</option>
                                <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
                            </select>

                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection