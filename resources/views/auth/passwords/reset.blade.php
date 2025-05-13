@extends('layouts.login_extend')

@php
    /** @var \Illuminate\Support\ViewErrorBag $errors */
    $errors = session()->get('errors', new \Illuminate\Support\ViewErrorBag);
@endphp

@section('content')
<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-8">
      <div class="card">

        <div class="card-headerr text-center">
          {{ __('Reset Password') }}
        </div>

        <div class="card-body reset-wrapperr">
          <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            {{-- Email --}}
            <div class="form-row">
              <label for="email">{{ __('Email Address') }}</label>
              <input
                id="email"
                type="email"
                name="email"
                value="{{ $email ?? old('email') }}"
                required
                autocomplete="email"
                autofocus
                class="@error('email') is-invalid @enderror"
              >
              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            {{-- New Password --}}
            <div class="form-row">
              <label for="password">{{ __('New Password') }}</label>
              <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                class="@error('password') is-invalid @enderror"
              >
              @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="form-row">
              <label for="password-confirm">{{ __('Confirm Password') }}</label>
              <input
                id="password-confirm"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
              >
            </div>

            {{-- Submit --}}
            <div class="form-row">
              <button type="submit" class="btnnn">
                {{ __('Reset') }}
              </button>
            </div>

          </form>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
