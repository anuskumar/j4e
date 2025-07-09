<?php $page="forgot-password";?>
@extends('layout.mainlayout')
@section('content')
<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-8 offset-md-2">

							<!-- Account Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-7 col-lg-6 login-left">
										<img src="assets/img/login-banner.png" class="img-fluid" alt="Login Banner">
									</div>
									<div class="col-md-12 col-lg-6 login-right">
										<div class="login-header">
											<h3>Forgot Password?</h3>
											<p class="small text-muted">Enter your email to get a password reset link</p>
										</div>

										<!-- Forgot Password Form -->
										<form method="POST" action="{{ route('password.email') }}">
                                            @csrf
											<div class="form-group form-focus">
												<input type="email" class="form-control floating" @error('email') is-invalid @enderror name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
												<label class="focus-label">{{ __('Email Address') }}</label>
                                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
											</div>
											<div class="text-right">
												<a class="forgot-link" href="login">Remember your password?</a>
											</div>
											<button class="btn btn-primary btn-block btn-lg login-btn" type="submit">{{ __('Send Password Reset Link') }}</button>
										</form>
										<!-- /Forgot Password Form -->

									</div>
								</div>
							</div>
							<!-- /Account Content -->

						</div>
					</div>

				</div>

			</div>
			<!-- /Page Content -->
			</div>
	   @endsection
