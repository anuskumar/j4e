<?php $page="booking-success";?>
@extends('layout.mainlayout')
@section('content')
<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Booking</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Booking</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->

			<!-- Page Content -->
			<div class="content success-page-cont">
				<div class="container">

					<div class="row justify-content-center">
						<div class="col-lg-6">

							<!-- Success Card -->
							<div class="card danger-card">
								<div class="card-body">
									<div class="success-cont">
										<i class="fas fa-times"></i>
										<h3>Booking Was Expired!</h3>
										<p>Your Booking Hold <strong>Exceeded 15 Minuts WIthout Completing the Payment</strong>
                                            <br> <strong>Please Go to the Home Page to Select the Shows and Tickets</strong></p>
										<a href="{{ url('/') }}" class="btn btn-primary view-inv-btn">Home</a>
									</div>
								</div>
							</div>
							<!-- /Success Card -->

						</div>
					</div>

				</div>
			</div>
			<!-- /Page Content -->
			</div>
	   @endsection
