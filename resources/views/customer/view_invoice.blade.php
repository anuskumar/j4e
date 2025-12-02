<?php $page="invoice-view";?>
@extends('layout.mainlayout')
@section('content')
<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Invoice </li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Invoice</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->

			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<div class="row">
						<div class="col-lg-12">
							<div class="invoice-content">
								<div class="invoice-item">
									<div class="row">
										<div class="col-md-6">
											<div class="invoice-logo">
												@if($settings && $settings->company_logo)
                                                    <img src="{{ asset('storage/uploads/images/' . $settings->company_logo) }}" alt="logo" onerror="this.src='{{ asset('assets/img/logoscroll.png') }}'">
                                                @else
                                                    <img src="{{ asset('assets/img/logoscroll.png') }}" alt="logo">
                                                @endif
											</div>
										</div>
										<div class="col-md-6">
											<p class="invoice-details">
												<strong>Order:</strong> #00124 <br>
												<strong>Issued:</strong> 20/07/2020
											</p>
										</div>
									</div>
								</div>

								<!-- Invoice Item -->
								<div class="invoice-item">
									<div class="row">
										<div class="col-md-6">
											<div class="invoice-info">
												<strong class="customer-text">Invoice From</strong>
												<p class="invoice-details invoice-details-two">
													{{ $settings->company_name }} <br>
													{{ $settings->company_website }},<br>
													{{ $settings->company_email }} <br>
												</p>
											</div>
										</div>
										<div class="col-md-6">
											<div class="invoice-info invoice-info2">
												<strong class="customer-text">Invoice To</strong>
												<p class="invoice-details">
													{{ $data->shipping_name }} <br>
													{{ $data->shipping_address1 }}, <br>
													{{ $data->shipping_address2 }}, <br>

													{{ $data->shipping_city }},{{ $data->shipping_pincode }}, {{ $data->country_name }} <br>
												</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /Invoice Item -->

								<!-- Invoice Item -->
								<div class="invoice-item">
									<div class="row">
										<div class="col-md-12">
											<div class="invoice-info">
												<strong class="customer-text">Payment Method</strong>
												<p class="invoice-details invoice-details-two">
													Credit /Debit Card <br>
													{{ 'XXXX-XXXX-XXXX-'.substr($data->payment_card_number,-4) }}<br>
													<br>
												</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /Invoice Item -->

								<!-- Invoice Item -->
								<div class="invoice-item invoice-table-wrap">
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<table class="invoice-table table table-bordered">
													<thead>
														<tr>
															<th>Description</th>
															<th class="text-center">Quantity</th>
															{{-- <th class="text-center">VAT</th> --}}
															<th class="text-right">Total</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>{{ $data->event_name }}</td>
															<td class="text-center">{{ $count }}</td>
															{{-- <td class="text-center">$0</td> --}}
															<td class="text-right">{{ $ticket->ticket_amount.' '.$data->currency_name }}</td>
														</tr>

													</tbody>
												</table>
											</div>
										</div>
										<div class="col-md-6 col-xl-4 ml-auto">
											<div class="table-responsive">
												<table class="invoice-table-two table">
													<tbody>
													<tr>
														<th>Subtotal:</th>
														<td><span>{{ $data->payment_amount.' '.$data->currency_name }}</span></td>
													</tr>
													{{-- <tr>
														<th>Discount:</th>
														<td><span>-10%</span></td>
													</tr>
													<tr>
														<th>Total Amount:</th>
														<td><span>$315</span></td>
													</tr> --}}
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<!-- /Invoice Item -->

								<!-- Invoice Information -->
								<div class="other-info">
									<h4>Other information</h4>
									{{-- <p class="text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed dictum ligula, cursus blandit risus. Maecenas eget metus non tellus dignissim aliquam ut a ex. Maecenas sed vehicula dui, ac suscipit lacus. Sed finibus leo vitae lorem interdum, eu scelerisque tellus fermentum. Curabitur sit amet lacinia lorem. Nullam finibus pellentesque libero.</p> --}}
								<p><strong>Payment id : {{ $data->payment_id }}</strong></p>
                                </div>
								<!-- /Invoice Information -->

							</div>
						</div>
					</div>

				</div>

			</div>
			<!-- /Page Content -->
			</div>
	   @endsection
