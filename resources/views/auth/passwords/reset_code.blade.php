<?php $page = 'forgot-password'; ?>
@extends('layout.mainlayout')
@section('content')

@include('auth.partials.account_auth_styles')

<div class="content auth-account-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="auth-account-card">
                    <div class="auth-account-card__header">
                        <div class="auth-account-card__icon">
                            <i class="fas fa-key"></i>
                        </div>
                        <h1>Reset Password</h1>
                        <p>Enter the 6-digit code sent to <strong>{{ $email }}</strong> and choose a new password.</p>
                    </div>

                    <div class="auth-account-card__body">
                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 pl-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.reset.submit') }}" class="auth-account-form">
                            @csrf

                            <div class="form-group">
                                <label for="code">Verification Code</label>
                                <input id="code" type="text" name="code" maxlength="6" inputmode="numeric" pattern="[0-9]{6}"
                                    class="form-control text-center @error('code') is-invalid @enderror"
                                    value="{{ old('code') }}" required autocomplete="one-time-code"
                                    placeholder="000000" style="letter-spacing: 6px; font-size: 20px; font-weight: 700;">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <div class="password-toggle-wrap">
                                    <input id="password" type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        required autocomplete="new-password" placeholder="At least 8 characters">
                                    <button type="button" class="password-toggle-btn" data-password-toggle aria-label="Show password">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password</label>
                                <div class="password-toggle-wrap">
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                        class="form-control" required autocomplete="new-password"
                                        placeholder="Re-enter your new password">
                                    <button type="button" class="password-toggle-btn" data-password-toggle aria-label="Show password">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <button class="btn auth-account-submit" type="submit">
                                <i class="fas fa-check mr-2"></i>Reset Password
                            </button>
                        </form>

                        <div class="auth-account-footer">
                            <p class="mb-2">Didn't receive the code?</p>
                            <form method="POST" action="{{ route('password.resend-code') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 align-baseline">Resend code</button>
                            </form>
                            <p class="mt-3 mb-0"><a href="{{ route('password.forgot') }}">Use a different email</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('auth.partials.password_toggle_script')
@endsection
