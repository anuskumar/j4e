{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}


<?php $page="login";?>
@extends('layout.mainlayout')
@section('content')
<style>
    .password-toggle-wrap {
        position: relative;
    }

    .password-toggle-wrap .form-control {
        padding-right: 44px;
    }

    .password-toggle-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        color: #6c757d;
        padding: 0;
        line-height: 1;
        cursor: pointer;
        z-index: 2;
    }

    .password-toggle-btn:hover {
        color: #671dcf;
    }

    .password-toggle-btn:focus {
        outline: none;
    }
</style>
<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-8 offset-md-2">

							<!-- Login Tab Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-7 col-lg-6 login-left">
										<img src="assets/img/login-banner.png" class="img-fluid" alt="Login">
									</div>
									<div class="col-md-12 col-lg-6 login-right">
										<div class="login-header">
											<h3>{{ __('Login') }} <span>Application</span></h3>
										</div>

                                        @if (session('status'))
                                            <div class="alert alert-success">{{ session('status') }}</div>
                                        @endif

										<form method="POST" action="{{ route('login') }}">
                                            @csrf
											<div class="form-group form-focus">
												<input type="email" name="email" class="form-control floating @error('email') is-invalid @enderror">
												<label class="focus-label">Email</label>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                @if ($errors->has('email'))
                                                    <div class="mt-2">
                                                        <a href="{{ route('verification.notice') }}" class="btn btn-link p-0">
                                                            Verify your email
                                                        </a>
                                                    </div>
                                                @endif
											</div>
											<div class="form-group form-focus">
												<div class="password-toggle-wrap">
													<input type="password" id="password" name="password" class="form-control floating @error('password') is-invalid @enderror" autocomplete="current-password">
													<button type="button" class="password-toggle-btn" id="password-toggle" aria-label="Show password">
														<i class="far fa-eye" id="password-toggle-icon"></i>
													</button>
												</div>
												<label class="focus-label" for="password">Password</label>
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
											</div>
											<div class="text-right">
												<a class="forgot-link" href="{{ route('password.forgot') }}">Forgot Password ?</a>
											</div>
											<button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Login</button>
											{{-- <div class="login-or">
												<span class="or-line"></span>
												<span class="span-or">or</span>
											</div> --}}
											{{-- <div class="row form-row social-login">
												<div class="col-6">
													<a href="#" class="btn btn-facebook btn-block"><i class="fab fa-facebook-f mr-1"></i> Login</a>
												</div>
												<div class="col-6">
													<a href="#" class="btn btn-google btn-block"><i class="fab fa-google mr-1"></i> Login</a>
												</div>
											</div> --}}
											<div class="text-center dont-have">Don’t have an account? <a href="register">Register</a></div>
										</form>
									</div>
								</div>
							</div>
							<!-- /Login Tab Content -->

						</div>
					</div>

				</div>

			</div>
			<!-- /Page Content -->
			</div>

			<script>
				document.addEventListener('DOMContentLoaded', function () {
					var toggleBtn = document.getElementById('password-toggle');
					var passwordInput = document.getElementById('password');
					var toggleIcon = document.getElementById('password-toggle-icon');

					if (!toggleBtn || !passwordInput || !toggleIcon) {
						return;
					}

					toggleBtn.addEventListener('click', function () {
						var isHidden = passwordInput.type === 'password';

						passwordInput.type = isHidden ? 'text' : 'password';
						toggleIcon.classList.toggle('fa-eye', !isHidden);
						toggleIcon.classList.toggle('fa-eye-slash', isHidden);
						toggleBtn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
					});
				});
			</script>
	   @endsection
