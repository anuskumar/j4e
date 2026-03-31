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
					<style>
						.invoice-content {
							background: #fff;
							padding: 30px;
							border-radius: 8px;
							box-shadow: 0 0 10px rgba(0,0,0,0.1);
						}
						.invoice-header {
							border-bottom: 2px solid #e3f2fd;
							padding-bottom: 20px;
							margin-bottom: 30px;
						}
						.invoice-logo img {
							max-height: 60px;
							width: auto;
						}
						.invoice-table {
							margin-bottom: 0;
						}
						.invoice-table thead {
							background-color: #f8f9fa;
						}
						.invoice-table thead th {
							border-bottom: 2px solid #dee2e6;
							font-weight: 600;
							padding: 12px;
						}
						.invoice-table tbody td {
							padding: 12px;
							vertical-align: middle;
						}
					</style>

					<div class="row">
						<div class="col-lg-12">
							<div class="invoice-content">
								<!-- PDF Download Button -->
								<div class="text-right mb-3">
									<a href="{{ route('invoice.pdf', $data->id) }}" class="btn btn-primary">
										<i class="fas fa-file-pdf mr-2"></i>Download PDF
									</a>
								</div>

								<!-- Invoice Header -->
								<div class="invoice-item invoice-header">
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
										<div class="col-md-6 text-right">
											<div class="invoice-details">
												<h3 class="mb-2" style="color: #333; font-weight: 600;">Invoice</h3>
												<p class="mb-1"><strong>Order ID:</strong> #{{ str_pad($data->id, 6, '0', STR_PAD_LEFT) }}</p>
												<p class="mb-1"><strong>Issue Date:</strong> {{ $data->payment_date ? date('d M Y', strtotime($data->payment_date)) : date('d M Y') }}</p>
											</div>
										</div>
									</div>
								</div>

								<!-- Invoice Item - Billing Info -->
								<div class="invoice-item">
									<div class="row">
										<div class="col-md-6">
											<div class="invoice-info">
												<strong class="customer-text">Invoice To</strong>
												<p class="invoice-details invoice-details-two">
													{{ $data->shipping_name ?? 'N/A' }}<br>
													@if($data->shipping_address1){{ $data->shipping_address1 }}<br>@endif
													@if($data->shipping_address2){{ $data->shipping_address2 }}<br>@endif
													@if($data->shipping_city){{ $data->shipping_city }}{{ $data->shipping_pincode ? ', ' . $data->shipping_pincode : '' }}<br>@endif
													@if($data->country_name){{ $data->country_name }}@endif
												</p>
											</div>
										</div>
										<div class="col-md-6">
											<div class="invoice-info">
												<strong class="customer-text">Payment Method</strong>
												<p class="invoice-details">
													Credit / Debit Card <br>
													@if($data->payment_card_number)
													XXXX-XXXX-XXXX-{{ substr($data->payment_card_number, -4) }}
													@else
													N/A
													@endif
												</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /Invoice Item -->

								<!-- Invoice Item - Order Summary -->
								<div class="invoice-item invoice-table-wrap">
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<table class="invoice-table table table-bordered">
													<thead>
														<tr>
															<th>Event</th>
															<th class="text-center">Number of Tickets</th>
															<th class="text-right">Unit Price</th>
															<th class="text-right">Amount</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td><strong>{{ $data->event_name }}</strong></td>
															<td class="text-center">{{ $count }}</td>
															<td class="text-right">{{ number_format(@$ticket->ticket_amount, 2) . ' ' . @$data->currency_name }}</td>
															<td class="text-right"><strong>{{ number_format($data->payment_amount, 2) . ' ' . $data->currency_name }}</strong></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-md-6 col-xl-4 ml-auto mt-3">
											<div class="table-responsive">
												<table class="invoice-table-two table">
													<tbody>
													<tr>
														<th>Subtotal:</th>
															<td><span>{{ number_format($data->payment_amount, 2) . ' ' . $data->currency_name }}</span></td>
													</tr>
													<tr>
														<th>Total Amount:</th>
															<td><strong><span>{{ number_format($data->payment_amount, 2) . ' ' . $data->currency_name }}</span></strong></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<!-- /Invoice Item -->

								<!-- Invoice Information -->
								<div class="invoice-item mt-4" style="border-top: 2px solid #e3f2fd; padding-top: 20px;">
									<div class="row">
										<div class="col-md-12">
											<h5 class="mb-3">Booking Information</h5>
											<p class="mb-2"><strong>Payment ID:</strong> {{ $data->payment_id ?? 'N/A' }}</p>
											<p class="mb-2"><strong>Order ID:</strong> #{{ str_pad($data->id, 6, '0', STR_PAD_LEFT) }}</p>
											<p class="mb-0"><strong>Payment Date:</strong> {{ $data->payment_date ? date('d M Y, h:i A', strtotime($data->payment_date)) : 'N/A' }}</p>
										</div>
									</div>
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
