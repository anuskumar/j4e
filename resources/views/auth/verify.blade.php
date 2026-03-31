<?php $page = "verify"; ?>
@extends('layout.mainlayout')
@section('content')
<!-- Page Content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="account-content">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-7 col-lg-6 login-left">
                            <img src="{{ asset('assets/img/login-banner.png') }}" class="img-fluid" alt="Verify Email">
                        </div>
                        <div class="col-md-12 col-lg-6 login-right">
                            <div class="login-header">
                                <h3>{{ __('Verify Your Email Address') }}</h3>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <span>{{ $errors->first() }}</span>
                                </div>
                            @endif

                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            <p class="mb-2">
                                {{ __('Before proceeding, please check your email for a verification link.') }}
                            </p>
                            <p class="mb-3">
                                {{ __('If you did not receive the email') }},
                            </p>

                            <form method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <input type="hidden" name="email" value="{{ session('unverified_email') }}">
                                @if (!session('unverified_email'))
                                    <div class="form-group form-focus">
                                        <input type="email" name="email" class="form-control floating" required>
                                        <label class="focus-label">Email</label>
                                    </div>
                                @endif
                                <button type="submit" class="btn btn-primary btn-block btn-lg">
                                    {{ __('Request another verification email') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- /Page Content -->
@endsection
