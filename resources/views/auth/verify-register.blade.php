@extends('layouts.app_auth')
@section('content')
<!-- /Logo -->
<h4 class="mb-1">Registration Verify 🚀</h4>

<form id="formAuthentication" class="mb-6" method="POST" action="{{ route('register.create') }}">
    @csrf

    <div class="mb-6 form-control-validation">
        <label for="phone_number" class="form-label">{{ __('Phone Number') }}</label>
        <input type="tel" id="phone_number" name="phone_number" placeholder="Enter your phone number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ session('otp_phone') }}" readonly="readonly"/>
        @error('phone_number')
            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                <div data-field="username" data-validator="notEmpty">{{ $message }}</div>
            </div>
        @enderror
    </div>

    <div class="mb-6 form-control-validation">
        <label for="otp" class="form-label">{{ __('OTP') }}</label>
        <input type="number" id="otp" class="form-control @error('otp') is-invalid @enderror" name="otp" placeholder="Enter OTP" />
        @error('otp')
            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                <div data-field="username" data-validator="notEmpty">{{ $message }}</div>
            </div>
        @enderror
    </div>


   
    <div class="my-8 form-control-validation">
      <div class="form-check mb-0 ms-2">
        <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" id="terms-conditions" name="terms" checked readonly="readonly"/>
        <label class="form-check-label" for="terms-conditions">
          I agree to
          <a href="javascript:void(0);">privacy policy & terms</a>
        </label>
        @error('terms')
        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
            <div data-field="terms" data-validator="notEmpty">Please agree to terms &amp; conditions</div>
        </div>
        @enderror
      </div>
    </div>
    <button class="btn btn-primary d-grid w-100">{{ __('Verify Account') }}</button>
</form>

<p class="text-center">
<span>Already have an account?</span>
<a href="{{ url('login') }}">
  <span>Sign in instead</span>
</a>
</p>
@endsection
