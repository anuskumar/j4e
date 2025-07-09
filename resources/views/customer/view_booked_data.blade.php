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
									<li class="breadcrumb-item active" aria-current="page">View Booking </li>
								</ol>
							</nav>
							{{-- <h2 class="breadcrumb-title">Invoice</h2> --}}
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
												<img src="{{ Storage::disk('image')->url('uploads/images/' . $settings->company_logo) }}" alt="logo">
											</div>
										</div>
										<div class="col-md-6">
											<p class="invoice-details">
												<strong>Order:</strong> #00124 <br>
												<strong>Issued:</strong> 20/07/2020
											</p>
										</div>
                                        <div class="other-info">
                                            <h4>Booking Status</h4>
                                            <p class="text-muted mb-0"> {{ $data->status_name }}</p>
                                        <p><strong>

                                        </strong></p>
                                        </div>
									</div>
								</div>

								<!-- Invoice Item -->

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
															<th>Event</th>
															<th class="text-center">Number of Tickets</th>
															{{-- <th class="text-center">VAT</th> --}}
															<th class="text-right">Amount</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>{{ $data->event_name }}</td>
															<td class="text-center">{{ $count }}</td>
															{{-- <td class="text-center">$0</td> --}}
															<td class="text-right">{{ @$ticket->ticket_amount.' '.@$data->currency_name }}</td>
														</tr>

													</tbody>
												</table>
											</div>
										</div>
										<div class="col-md-6 col-xl-4 ml-auto">
											{{-- <div class="table-responsive">
												<table class="invoice-table-two table">
													<tbody>
													<tr>
														<th>Subtotal:</th>
														<td><span>{{ $data->payment_amount.' '.$data->currency_name }}</span></td>
													</tr><tr>
														<th>Discount:</th>
														<td><span>-10%</span></td>
													</tr>
													<tr>
														<th>Total Amount:</th>
														<td><span>$315</span></td>
													</tr>
													</tbody>
												</table>
											</div> --}}
										</div>
									</div>

								</div>
                                <br>
                                <br>
								<div class="invoice-item invoice-table-wrap">
									<div class="row">
										<div class="col-md-6">
											<div class="table-responsive">
												<table class="invoice-table table table-bordered">
													<thead>
														<tr>
															<th>Event Details</th>
															<th class="text-center"></th>
															{{-- <th class="text-center">VAT</th> --}}

														</tr>
													</thead>

                                                        @foreach ($data_list as $list )
                                                        <tbody>
                                                        <tr>
															<td>{{ "Ticket Serial" }}</td>
															<td class="text-center">{{ $list->ticket_serial_number }}</td>

														</tr>
                                                        <tr>
															<td>{{ "Seat Number" }}</td>
															<td class="text-center">{{ $list->seat_number_prefix }}</td>

														</tr>
                                                        <tr>
															<td>{{ "Event Date" }}</td>
															<td class="text-center">{{ $list->event_date }}</td>

														</tr>
                                                        <tr>
															<td>{{ "Event Timing" }}</td>
															<td class="text-center">{{ $list->from_time }} To {{ $list->to_time }}</td>

														</tr>
                                                        <tr>
															<td>{{ "Event Seating" }}</td>
															<td class="text-center">{{ $list->seating_type_name }}</td>

														</tr>
                                                        <tr>
															<td>{{ "Seat Row" }}</td>
															<td class="text-center">{{ $list->seat_row }}</td>

														</tr>
                                                        <hr>
                                                    </tbody>

                                                        @endforeach



												</table>
											</div>
										</div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="mb-4 main-content-label"> Status Log</div>
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Remark</th>
                                                            <th>File</th>
                                                            <th>Added By</th>
                                                            @if(Auth::user()->user_type == 'superadmin')
                                                            <th>Del</th>
                                                            @endif
                                                        </tr>
                                                        @foreach ($log as $lo)
                                                        <tr>
                                                            <td>{{ date('d m Y',strtotime($lo->created_at)) }}</td>
                                                            <td>{{ $lo->status_name }}</td>
                                                            <td>{{ $lo->remark }}</td>
                                                            <td>
                                                                @if($lo->document)
                                                                <a href="{{ Storage::disk('image')->url('uploads/purchase_status_document/' . $lo->document) }}" target="_blank">Click</a></td>
                                                                @endif
                                                                <td>{{ $lo->name }}</td>
                                                                @if(Auth::user()->user_type == 'superadmin')
                                                                <td><a href="{{ url('customer_order/delete_status_log',$lo->id) }}" onclick="return confirm('Are you sure you want to delete this log ?');"> Delete</a></td>
                                                                @endif
                                                            </tr>
                                                        @endforeach

                                                    </table>

                                            </div>
                                        </div>

									</div>

								</div>
								<!-- /Invoice Item -->

								<!-- Invoice Information -->
								<div class="other-info">
									<h4>Booking information</h4>
									{{-- <p class="text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed dictum ligula, cursus
										blandit risus. Maecenas eget metus non tellus dignissim aliquam ut a ex.
										 Maecenas sed vehicula dui, ac suscipit lacus. Sed finibus leo vitae lorem interdum,
										  eu scelerisque tellus fermentum. Curabitur sit amet lacinia lorem. Nullam finibus pellentesque libero.</p> --}}
								<p><strong>Payment id : {{ $data->payment_id }}</strong></p>
                                </div>
<
                                <div class="other-info">
									<h4>Booking Status</h4>
									<p class="text-muted mb-0"> {{ $data->status_name }}</p>
								<p><strong>

								</strong></p>
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
