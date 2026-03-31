<?php $page="customer-profile";?>
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
									<li class="breadcrumb-item active" aria-current="page">Profile</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Profile</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->

			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<div class="row">
						<div class="col-md-4 col-lg-4 col-xl-3 theiaStickySidebar dct-dashbd-lft">

							<!-- Profile Widget -->
							<div class="card widget-profile pat-widget-profile">
								<div class="card-body">
									<div class="pro-widget-content">
										<div class="profile-info-widget">
											<a href="#" class="booking-doc-img">
												<img src="{{ asset('assets/img/customers/customer.jpg') }}" alt="User Image">
											</a>
											<div class="profile-det-info">
												<h3>{{ ucfirst(Auth::user()->name) }}</h3>

												<div class="customer-details">
													<h5><b>customer ID :</b> {{ Auth::user()->id }}</h5>
													{{-- <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Newyork, United States</h5> --}}
												</div>
											</div>
										</div>
									</div>
									<div class="customer-info">
										<ul>
											<li>Phone <span>{{ Auth::user()->phone }}</span></li>
											<li>Email <span>{{ Auth::user()->email }}</span></li>
											{{-- <li>Gender <span>{{ Auth::user()-> }}</span></li> --}}
										</ul>
									</div>
								</div>
                                <hr>
                            @include('layout.customer_sidebar');
							</div>

							<!-- /Profile Widget -->

							<!-- Last Booking -->
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Last Booking</h4>
								</div>
								<ul class="list-group list-group-flush">

                                    @foreach ($last_booking as $val)

                                    <li class="list-group-item">
										<div class="media align-items-center">
											<div class="mr-3">
												@if($val->event_image)
                                                    <img alt="Image placeholder" src="{{ asset('storage/uploads/events/' . $val->event_image) }}" class="avatar rounded-circle" onerror="this.onerror=null;this.src='{{ asset('assets/img/events/event-01.jpg') }}';">
                                                @else
                                                    <img alt="Image placeholder" src="{{ asset('assets/img/events/event-01.jpg') }}" class="avatar rounded-circle">
                                                @endif
											</div>
											<div class="media-body">
												<h5 class="d-block mb-0">{{ $val->event_name }} </h5>
												<span class="d-block text-sm text-muted">{{ $val->tag_name }}, {{ $val->event_type_name }}</span>
												<span class="d-block text-sm text-muted">
                                                    {{ @$val['event_date']->event_date }}
                                                    {{ @$val['event_date']->from_time }}   </span>
											</div>
										</div>
									</li>

                                    @endforeach


								</ul>
							</div>
							<!-- /Last Booking -->

						</div>

						<div class="col-md-8 col-lg-8 col-xl-9 dct-appoinment">
							<div class="card">
								<div class="card-body pt-0">
									<div class="user-tabs">
										<ul class="nav nav-tabs nav-tabs-bottom nav-justified flex-wrap">
											<li class="nav-item">
												<a class="nav-link active" href="#pat_appointments" data-toggle="tab">All Bookings</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#pres" data-toggle="tab"><span>Upcomming Events</span></a>
											</li>
											{{-- <li class="nav-item">
												<a class="nav-link" href="#medical" data-toggle="tab"><span class="med-records">Event Info</span></a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#billing" data-toggle="tab"><span>Billing</span></a>
											</li> --}}
										</ul>
									</div>
									<div class="tab-content">

										<!-- Booking Tab -->
										<div id="pat_appointments" class="tab-pane fade show active">
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="table-responsive">
														<table class="table table-hover table-center mb-0">
															<thead>
																<tr>
																	<th>Event</th>
																	<th>Event Date</th>
																	<th>Booking Date</th>
																	<th>Amount</th>
																	<th>Purchased Date</th>
																	<th>Status</th>
																	<th>Payment Status</th>
																	<th>Tickets</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>
                                                                @foreach ($all_bookings as $val)


																<tr>
																	<td>
																		<h2 class="table-avatar">
																			<a href="{{ url('show_details_show',$val->event_id) }}" class="avatar avatar-sm mr-2">
																				@if($val->event_image)
                                                                                    <img class="avatar-img rounded-circle" src="{{ asset('storage/uploads/events/' . $val->event_image) }}" alt="User Image" onerror="this.onerror=null;this.src='{{ asset('assets/img/events/event-01.jpg') }}';">
                                                                                @else
                                                                                    <img class="avatar-img rounded-circle" src="{{ asset('assets/img/events/event-01.jpg') }}" alt="User Image">
                                                                                @endif
																			</a>
																			<a href="{{ url('show_details_show',$val->event_id) }}">{{ $val->event_name }} <span>{{ $val->tag_name }}, {{ $val->event_type_name }}</span></a>
																		</h2>
																	</td>
																	<td>{{ @$val['event_date']->event_date }}<span class="d-block text-info">{{ @$val['event_date']->event_time }}</span></td>
																	<td>{{ @$val->event_from_date }}</td>
																	<td>{{ @$val->payment_amount }}
                                                                        {{ @$val->short_name }}
                                                                        </td>
																	<td>{{ @$val->created_at }}</td>
																	<td>
                                                                       {{ @$val->status_name }}
                                                                    </td>
																	<td>
                                                                        {{ @$val->is_payment_completed == 1 ? "Payment Completed" :"Not Completed"}}
                                                                        {{-- <span class="badge badge-pill bg-success-light">Confirm</span> --}}
                                                                    </td>
																	<td>
																		@if(isset($val['tickets']) && $val['tickets']->count() > 0)
																			<a href="{{ route('customer.ticket.details', $val->id) }}" class="btn btn-sm btn-primary" title="View Ticket Details">
																				<i class="fas fa-ticket-alt"></i> Ticket Details
																			</a>
																		@else
																			<span class="text-muted">-</span>
																		@endif
                                                                    </td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="{{ url('view_invoice',$val->id) }}" class="btn btn-sm bg-success-light">
																				<i class="far fa-edit"></i> Invoice
																			</a>
                                                                            <a href="{{ url('show_booking_details_show',$val->id) }}" class="btn btn-sm bg-success-light">
																				<i class="far fa-edit"></i> view
																			</a>
																		</div>
																	</td>
																</tr>
                                                                @endforeach

															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<!-- /Booking Tab -->

										<!-- Programs Tab -->
										<div class="tab-pane fade" id="pres">
											<div class="text-right">
												{{-- <a href="add-programs" class="add-new-btn">Add Programs</a> --}}
											</div>
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="table-responsive">
														<table class="table table-hover table-center mb-0">
															<thead>
																<tr>
																	<th>Date </th>
																	<th>Name</th>
																	<th>Amount</th>
																	<th></th>

																</tr>
															</thead>
															<tbody>
                                                                @foreach ($upcomming_booking as $val)
                                                                <tr>
																	<td>{{ @$val->event_from_date }}</td>

																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				@if($val->event_image)
																					<img class="avatar-img rounded-circle" src="{{ Storage::disk('image')->url('uploads/events/' . $val->event_image) }}" alt="User Image" onerror="this.onerror=null;this.src='{{ asset('assets/img/events/event-01.jpg') }}';">
																				@else
																					<img class="avatar-img rounded-circle" src="{{ asset('assets/img/events/event-01.jpg') }}" alt="User Image">
																				@endif
																			</a>
																			<a href="speaker-profile">{{ $val->event_name }} <span>{{ $val->tag_name }}, {{ $val->event_type_name }} <span></span></a>
																		</h2>
																	</td>
                                                                    <td>Songs</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="{{ url('view_invoice',$val->id) }}" class="btn btn-sm bg-success-light">
																				<i class="far fa-edit"></i> Invoice
																			</a>
																			<a href="{{ url('speaker-profile') }}" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
                                                                @endforeach


															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<!-- /Programs Tab -->

										<!-- Event Details Tab -->
										<div class="tab-pane fade" id="medical">
											<div class="text-right">
												<a href="#" class="add-new-btn" data-toggle="modal" data-target="#add_medical_records">Add Event Info</a>
											</div>
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="table-responsive">
														<table class="table table-hover table-center mb-0">
															<thead>
																<tr>
																	<th>ID</th>
																	<th>Date </th>
																	<th>Event</th>
																	<th>Created</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0010</a></td>
																	<td>14 Nov 2020</td>
																	<td>Sangeet</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-01.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Blaine Skipper <span>DJ, Producer</span></a>
																		</h2>
																	</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0009</a></td>
																	<td>13 Nov 2020</td>
																	<td>Birthday</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-02.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Wayte Barlow <span>DJ, Producer</span></a>
																		</h2>
																	</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="edit-programs" class="btn btn-sm bg-success-light" data-toggle="modal" data-target="#add_medical_records">
																				<i class="fas fa-edit"></i> Edit
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
																				<i class="far fa-trash-alt"></i> Delete
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0008</a></td>
																	<td>12 Nov 2020</td>
																	<td>Wedding</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-03.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Meerta Tyson <span>DJ Reader</span></a>
																		</h2>
																	</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0007</a></td>
																	<td>11 Nov 2020</td>
																	<td>Conference</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-04.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Rhodes Glaser <span>DJ, Mix Engineer</span></a>
																		</h2>
																	</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0006</a></td>
																	<td>10 Nov 2020</td>
																	<td>Party</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-05.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Dallin Donaldson <span>Artist & DJ</span></a>
																		</h2>
																	</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0005</a></td>
																	<td>9 Nov 2020</td>
																	<td>Baby Shower</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-06.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Mykah Derr <span>DJ, Artist</span></a>
																		</h2>
																	</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0004</a></td>
																	<td>8 Nov 2020</td>
																	<td>Seminar</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-07.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Ozella Barbee <span>DJ, Mix Engineer</span></a>
																		</h2>
																	</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0003</a></td>
																	<td>7 Nov 2020</td>
																	<td>Wedding</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-08.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Mayeer Busch <span>Mix Engineer</span></a>
																		</h2>
																	</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0002</a></td>
																	<td>6 Nov 2020</td>
																	<td>Song Release</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-09.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Farren Blalock <span>DJ, Producer</span></a>
																		</h2>
																	</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0001</a></td>
																	<td>5 Nov 2020</td>
																	<td>Conference</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-10.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Sissel Browne <span>DJ, Producer</span></a>
																		</h2>
																	</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<!-- /Event Details Tab -->

										<!-- Billing Tab -->
										<div class="tab-pane" id="billing">
											<div class="text-right">
												<a class="add-new-btn" href="add-billing">Add Billing</a>
											</div>
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="table-responsive">

														<table class="table table-hover table-center mb-0">
															<thead>
																<tr>
																	<th>Invoice No</th>
																	<th>Speaker</th>
																	<th>Amount</th>
																	<th>Paid On</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>
																		<a href="invoice-view">#INV-0010</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-01.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Ruby Perrin <span>DJ, Producer</span></a>
																		</h2>
																	</td>
																	<td>$450</td>
																	<td>14 Nov 2020</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view">#INV-0009</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-02.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Wayte Barlow <span>DJ, Producer</span></a>
																		</h2>
																	</td>
																	<td>$300</td>
																	<td>13 Nov 2020</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="edit-billing" class="btn btn-sm bg-success-light">
																				<i class="fas fa-edit"></i> Edit
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
																				<i class="far fa-trash-alt"></i> Delete
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view">#INV-0008</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-03.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Meerta Tyson <span>DJ Reader</span></a>
																		</h2>
																	</td>
																	<td>$150</td>
																	<td>12 Nov 2020</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view">#INV-0007</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-04.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Rhodes Glaser <span>DJ, Mix Engineer</span></a>
																		</h2>
																	</td>
																	<td>$50</td>
																	<td>11 Nov 2020</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view">#INV-0006</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-05.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Dallin Donaldson <span>Artist & DJ</span></a>
																		</h2>
																	</td>
																	<td>$600</td>
																	<td>10 Nov 2020</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view">#INV-0005</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-06.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Mykah Derr <span>DJ, Artist</span></a>
																		</h2>
																	</td>
																	<td>$200</td>
																	<td>9 Nov 2020</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view">#INV-0004</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-07.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Ozella Barbee <span>DJ, Mix Engineer</span></a>
																		</h2>
																	</td>
																	<td>$100</td>
																	<td>8 Nov 2020</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view">#INV-0003</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-08.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Mayeer Busch <span>Mix Engineer</span></a>
																		</h2>
																	</td>
																	<td>$250</td>
																	<td>7 Nov 2020</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view">#INV-0002</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-09.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Farren Blalock <span>DJ, Producer</span></a>
																		</h2>
																	</td>
																	<td>$175</td>
																	<td>6 Nov 2020</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="invoice-view">#INV-0001</a>
																	</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-10.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Sissel Browne <span>#0010</span></a>
																		</h2>
																	</td>
																	<td>$550</td>
																	<td>5 Nov 2020</td>
																	<td class="text-right">
																		<div class="table-action">
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																		</div>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<!-- Billing Tab -->

									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

			</div>
			<!-- /Page Content -->

			</div>
			<!-- Add Event Records Modal -->
		<div class="modal fade custom-modal" id="add_medical_records">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Event Info</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<form>
						<div class="modal-body">
							<div class="form-group">
								<label>Date</label>
								<input type="text" class="form-control datetimepicker" value="31-10-2020">
							</div>
							<div class="form-group">
								<label>Event ( Optional )</label>
								<textarea class="form-control"></textarea>
							</div>
							<div class="submit-section text-center">
								<button type="submit" class="btn btn-primary submit-btn">Submit</button>
								<button type="button" class="btn btn-secondary submit-btn" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /Add Event Records Modal -->
	   @endsection
