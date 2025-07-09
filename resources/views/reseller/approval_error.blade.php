
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
											<h3>{{ "This Reseller Login is not Approved by Admin" }}</h3>

                                         <a class="btn btn-primary" href="{{ url('/') }}"> Back to Home</a>
										</div>

									</div>
								</div>
							</div>


						</div>
					</div>

				</div>

			</div>

			</div>
	   @endsection
