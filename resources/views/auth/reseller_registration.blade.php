<?php $page="register_reseller";?>
@extends('layout.mainlayout')
@section('content')
<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-8 offset-md-2">

							<!-- Register Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-7 col-lg-6 login-left">
										<img src="assets/img/login-banner.png" class="img-fluid" alt="Pathivu Register">
									</div>
									<div class="col-md-12 col-lg-6 login-right">
										<div class="login-header">
											<h3>Reseller Register <a href="speaker-register">Register Here</a></h3>
										</div>

										<!-- Register Form -->
										<form method="POST" action="{{ url('reseller_registration') }}">
                                            @csrf
											<div class="form-group form-focus">
												<input type="text" class="form-control floating @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
												<label class="focus-label">{{ __('Name') }}</label>
                                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
											</div>
											<div class="form-group form-focus">
												<input type="email" class="form-control floating @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
												<label class="focus-label">{{ __('Email Address') }}</label>
                                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
											</div>
											<div class="form-group form-focus">
												<input type="password" class="form-control floating @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
												<label class="focus-label">{{ __('Password') }}</label>
                                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
											</div>
                                            <div class="form-group form-focus">
												<input type="password" class="form-control floating" name="password_confirmation" required autocomplete="new-password">
												<label class="focus-label">{{ __('Confirm Password') }}</label>
											</div>

											<button class="btn btn-primary btn-block btn-lg login-btn" type="submit">{{ __('Register') }}</button>
											<div class="login-or">
												<span class="or-line"></span>
												<span class="span-or">or</span>
											</div>
											<div class="row form-row social-login">
												<div class="col-6">
													<a href="#" class="btn btn-facebook btn-block"><i class="fab fa-facebook-f mr-1"></i> Login</a>
												</div>
												<div class="col-6">
													<a href="#" class="btn btn-google btn-block"><i class="fab fa-google mr-1"></i> Login</a>
												</div>
											</div>
										</form>
										<!-- /Register Form -->

									</div>
								</div>
							</div>
							<!-- /Register Content -->

						</div>
					</div>

				</div>

			</div>
			<!-- /Page Content -->
			</div>
	   @endsection
