@extends('layouts.app_auth')
@section('content')

<h4 class="mb-1">Reset Password 🔒</h4>
<p class="mb-6"><span class="fw-medium">Your new password must be different from previously used passwords</span></p>
<form  method="POST" action="{{ route('password.update') }}" class="fv-plugins-bootstrap5 fv-plugins-framework">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="mb-6 form-control-validation fv-plugins-icon-container">
        <label for="email" class="form-label">{{ __('Email Address') }}</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus readonly>
        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
        @error('email')
            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                <div data-field="username" data-validator="notEmpty">{{ $message }}</div>
            </div>
        @enderror
    </div>
    <div class="mb-6 form-password-toggle form-control-validation fv-plugins-icon-container">
        <label class="form-label" for="password">New Password</label>
        <div class="input-group input-group-merge has-validation">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  placeholder="············" aria-describedby="password" autocomplete="new-password">
            <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
        </div>
        @error('password')
            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                <div data-field="username" data-validator="notEmpty">{{ $message }}</div>
            </div>
        @enderror
    </div>
    <div class="mb-6 form-password-toggle form-control-validation fv-plugins-icon-container">
        <label class="form-label" for="confirm-password">Confirm Password</label>
        <div class="input-group input-group-merge has-validation">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  placeholder="············" aria-describedby="password" autocomplete="new-password">
            <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
        </div>
    </div>
    <button type="submit" class="btn btn-primary d-grid w-100 mb-6 waves-effect waves-light">Set new password</button>
    <div class="text-center">
    <a href="{{ url('login') }}" class="d-flex justify-content-center">
        <i class="icon-base ti tabler-chevron-left scaleX-n1-rtl me-1_5"></i>
        Back to login
    </a>
    </div>
</form>
@endsection
