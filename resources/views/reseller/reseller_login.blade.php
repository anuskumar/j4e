
<?php $page="login";?>
@extends('layout.mainlayout')
@section('content')
<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-8 offset-md-2">

							<!-- Login Tab Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-7 col-lg-6 login-left">
										<img src="{{ asset('assets/img/login-banner.png')}}" class="img-fluid" alt="Login">
									</div>
									<div class="col-md-12 col-lg-6 login-right">
										<div class="login-header">
											<h3>{{ __('Reseller Login') }}</h3>

                                            @if(count($errors) > 0)
 @foreach( $errors->all() as $message )
  <div class="alert alert-danger display-hide">
   <button class="close" data-close="alert"></button>
   <span>{{ $message }}</span>
  </div>
 @endforeach
@endif
										</div>
										<form method="POST" action="{{ url('reseller/login') }}">
                                            @csrf
											<div class="form-group form-focus">
												<input type="email" name="email" class="form-control floating @error('email') is-invalid @enderror">
												<label class="focus-label">Email</label>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
											</div>
											<div class="form-group form-focus">
												<input type="password" name="password"  class="form-control floating @error('password') is-invalid @enderror">
												<label class="focus-label">Password</label>
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
											</div>
											<div class="text-right">
												<a class="forgot-link" href="{{ url('forgot-password') }}">Forgot Password ?</a>
											</div>
											<button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Login</button>

											<div class="text-center dont-have">Don’t have an account? <a href="{{ url('reseller_registration') }}">Register</a></div>
										</form>
									</div>
								</div>
							</div>


						</div>
					</div>

				</div>

			</div>

			</div>
	   @endsection
