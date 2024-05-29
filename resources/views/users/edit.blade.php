@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit User') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT') 

                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email',  $user->email) }}" required>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            <small class="form-text text-muted">Leave password blank to keep the current password.</small>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
@enderror
  <div class="form-group">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            
                        </div>
  <input type="password" class="form-control" id="password-confirm" name="password_confirmation">
                        </div>

                        <div class="form-group">
                            <label for="role">{{ __('Role') }}</label>
                            <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="doctor" {{ old('role', $user->role) === 'doctor' ? 'selected' : '' }}>Doctor</option>
                                <option value="student" {{ old('role', $user->role) === 'student' ? 'selected' : '' }}>Student</option>
                            </select>

                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection