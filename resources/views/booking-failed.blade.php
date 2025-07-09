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
									<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
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
							<div class="card success-card">
								<div class="card-body">
									<div class="success-cont">
										<i class="fas fa-window-close"></i>
										<h3>Booking Failed !</h3>
										<p><strong> Your Booking was failed due to the payment issues..your tickets will be get blocked for you for 15 minutes... please complete the purchase before it ends....</strong></p>
										{{-- <a href="{{ url('view_invoice',$id) }}" class="btn btn-primary view-inv-btn">View Invoice</a> --}}
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
