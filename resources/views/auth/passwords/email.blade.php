@extends('layouts.app_auth')
@section('content')
    <h4 class="mb-1">Forgot Password? 🔒</h4>
    <p class="mb-6">Enter your email and we'll send you instructions to reset your password</p>
    @if (session('status'))
        <div class="alert alert-success" role="alert"> {{ session('status') }} </div>
    @endif
    <form class="mb-6 fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-6 form-control-validation fv-plugins-icon-container">
            <label for="email" class="form-label">{{ __('Email Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
            @error('email')
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    <div data-field="username" data-validator="notEmpty">{{ $message }}</div>
                </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary d-grid w-100 waves-effect waves-light">{{ __('Send Password Reset Link') }}</button>
    <input type="hidden"></form>
    <div class="text-center">
        <a href="{{ url('login') }}" class="d-flex justify-content-center">
        <i class="icon-base ti tabler-chevron-left scaleX-n1-rtl me-1_5"></i>
        Back to login
        </a>
    </div>
       
@endsection
