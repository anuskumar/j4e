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
                            <i class="fas fa-unlock-alt"></i>
                        </div>
                        <h1>Forgot Password?</h1>
                        <p>Enter your email address and we will send you a 6-digit verification code to reset your password.</p>
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

                        <form method="POST" action="{{ route('password.send-code') }}" class="auth-account-form">
                            @csrf

                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input id="email" type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="you@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button class="btn auth-account-submit" type="submit">
                                <i class="fas fa-paper-plane mr-2"></i>Send Reset Code
                            </button>
                        </form>

                        <div class="auth-account-footer">
                            <p class="mb-0">Remember your password? <a href="{{ route('login') }}">Back to login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
