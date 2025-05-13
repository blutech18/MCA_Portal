
@extends('layouts.login_extend')

    @php
        /** @var \Illuminate\Support\ViewErrorBag $errors */
        $errors = session()->get('errors', new \Illuminate\Support\ViewErrorBag);
    @endphp
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                <div class="card-body reset-wrapper">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                
                        <div class="card-header">{{ __('Reset Password') }}</div>
                        <div class="form-row">
                            <label for="email">{{ __('Email Address') }}</label>
                            <input
                              id="email"
                              type="email"
                              name="email"
                              value="{{ old('email') }}"
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
                
                        <div class="form-row">
                            <button type="submit" class="btnn">
                              {{ __('Send Reset Link') }}
                            </button>
                        </div>
                    </form>
                </div>

                
            </div>
        </div>
    </div>
</div>
@endsection
