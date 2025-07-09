<?php $page="speaker-profile";?>
@extends('layout.mainlayout')
@section('content')
<link href="https://just4entertainment.com/public/assets/css/toastr.min.css" rel="stylesheet">

<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Event</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Event Details</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->

			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<!-- speaker Widget -->
					<div class="card">
						<div class="card-body">
							<div class="speaker-widget">
								<div class="doc-info-left">
									<div class="speaker-img">
										<img src="{{ Storage::disk('image')->url('uploads/events/' . @$event_datas->event_image) }}" class="img-fluid" alt="User Image">
									</div>
									<div class="doc-info-cont">
										<h4 class="doc-name">{{ Str::ucfirst(@$event_datas->event_name) }}</h4>

										<p class="doc-speciality">{{ @$event_datas->event_desc }}</p>
										<p class="doc-department">
                                            <img src="{{ Storage::disk('image')->url('uploads/event_tag_images/' . @$event_datas->tag_image) }}"
                                             class="img-fluid" alt="Speciality">{{ @$event_datas->tag_name }}</p>
										<div class="rating">
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star filled"></i>
											<i class="fas fa-star"></i>
											<span class="d-inline-block average-rating">({{ count($event_reviews) }})</span>
										</div>
										<div class="clinic-details">
											<p class="doc-location"><i class="fas fa-map-marker-alt"></i>{{ @$event_datas->venue_name }},{{ @$event_datas->location_name }} - {{ @$event_datas->country_name }}
                                                <a href="{{ @$event_datas->google_map_link }}" target="blank">Get Directions</a></p>
											<ul class="clinic-gallery">
                                                @foreach ($event_images as $img)

                                                <li>
													<a href="{{ Storage::disk('image')->url('uploads/events/' . $img->image) }}" data-fancybox="gallery">
														<img src="{{ Storage::disk('image')->url('uploads/events/' . $img->image) }}" alt="Feature">
													</a>
												</li>

                                                @endforeach


											</ul>
										</div>
										<div class="clinic-services">
                                            @foreach ($artist_data as $art)
                                            <span>{{ $art->artist_name }}</span>

                                            @endforeach

										</div>
									</div>
								</div>
								<div class="doc-info-right">
									<div class="clini-infos">
										<ul>
											{{-- <li><i class="far fa-thumbs-up"></i> 99%</li> --}}
											<li><i class="far fa-comment"></i>({{ count($event_reviews) }}) Feedback</li>
											<li><i class="fas fa-map-marker-alt"></i> {{ @$event_datas->location_name }}, {{ @$event_datas->country_name }}</li>
											{{-- <li><i class="far fa-money-bill-alt"></i>  {{ @$event_datas->country_name }} </li> --}}
										</ul>
									</div>
									{{-- <div class="speaker-action">
										<a href="javascript:void(0)" class="btn btn-white fav-btn">
											<i class="far fa-bookmark"></i>
										</a>
										<a href="chat" class="btn btn-white msg-btn">
											<i class="far fa-comment-alt"></i>
										</a>
										<a href="javascript:void(0)" class="btn btn-white call-btn" data-toggle="modal" data-target="#voice_call">
											<i class="fas fa-phone"></i>
										</a>
										<a href="javascript:void(0)" class="btn btn-white call-btn" data-toggle="modal" data-target="#video_call">
											<i class="fas fa-video"></i>
										</a>
									</div> --}}
									<div class="clinic-booking">
										{{-- <a class="apt-btn" href="booking">Book Appointment</a> --}}
										<a class="apt-btn" href="booking">Date : {{ @$event_datas->event_from_date }} To {{ @$event_datas->event_to_date }}</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /speaker Widget -->

					<!-- speaker Details Tab -->
					<div class="card">
						<div class="card-body pt-0">

							<!-- Tab Menu -->
							<nav class="user-tabs mb-4">
								<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
									<li class="nav-item">
										<a class="nav-link " href="#doc_overview" data-toggle="tab">Overview</a>
									</li>
									<li class="nav-item">
										<a class="nav-link active" href="#doc_locations" data-toggle="tab">Tickets Listing</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#doc_reviews" data-toggle="tab">Reviews</a>
									</li>
									{{-- <li class="nav-item">
										<a class="nav-link" href="#doc_business_hours" data-toggle="tab">Business Hours</a>
									</li> --}}
								</ul>
							</nav>
							<!-- /Tab Menu -->

							<!-- Tab Content -->
							<div class="tab-content pt-0">

								<!-- Overview Content -->
								<div role="tabpanel" id="doc_overview" class="tab-pane fade ">
									<div class="row">
										<div class="col-md-12 col-lg-9">

											<!-- About Details -->
											<div class="widget about-widget">
												<h4 class="widget-title">About</h4>
												<p>{{ @$event_datas->event_desc }}</p>
											</div>
											<!-- /About Details -->



											<!-- Services List -->
											<div class="service-list">
												<h4>Artist</h4>
												<ul class="clearfix">

                                                    @foreach ($artist_data as $art)

                                                    <li>{{ $art->artist_name }} </li>

                                                    @endforeach


												</ul>
											</div>
											<!-- /Services List -->

											<!-- Specializations List -->
											{{-- <div class="service-list">
												<h4>Specializations</h4>
												<ul class="clearfix">
													<li>Digital Events</li>
													<li>Tech Events</li>
													<li>Tech Workshop </li>
													<li>Event Workshop</li>
													<li>Cultural Events</li>
													<li>DJ Events</li>
												</ul>
											</div> --}}
											<!-- /Specializations List -->

										</div>
									</div>
								</div>
								<!-- /Overview Content -->

								<!-- Locations Content -->
								<div role="tabpanel" id="doc_locations" class="tab-pane fade show active">

									<!-- Location List -->
									<div class="location-list">
										<div class="row">

											<!-- Clinic Content -->
											<div class="col-md-12">
											    <div class="row">
											        <div class="col-md-4">
    												<div class="clinic-content">
    													<h4 class="clinic-name"><a href="#">{{ @$event_datas->venue_name }}</a></h4>
    													<p class="doc-speciality">{{ @$event_datas->location_name }} , {{ @$event_datas->country_name }}</p>

                                                        @php
                                                            if ($event_reviews_stars) {
                                                               $avg_stars = $event_reviews_stars/count($event_reviews);
                                                            }else {
                                                                # code...
                                                                $avg_stars = 0;
                                                            }
                                                        @endphp

    													<div class="rating">
                                                            {{-- filled --}}

    														<i class="fas fa-star {{ $avg_stars > 1  ? 'filled' : '' }} "></i>
    														<i class="fas fa-star {{ $avg_stars > 2 ? 'filled' : '' }}"></i>
    														<i class="fas fa-star {{ $avg_stars > 3 ? 'filled' : '' }}"></i>
    														<i class="fas fa-star {{ $avg_stars > 4 ? 'filled' : '' }}"></i>
    														<i class="fas fa-star {{ $avg_stars > 5 ? 'filled' : '' }}"></i>
    														<span class="d-inline-block average-rating">({{ count($event_reviews) }})</span>
    													</div>
    													<div class="clinic-details mb-0">
    														<h5 class="clinic-direction"> <i class="fas fa-map-marker-alt"></i>
                                                                {{ @$event_datas->venue_name }},{{ @$event_datas->location_name }} - {{ @$event_datas->country_name }}
                                                                <br>
                                                                <a href="{{ @$event_datas->google_map_link }}" target="blank">Get Directions</a></p>
                                                            </h5>


    													</div>
    												</div>
    											</div>
    									<!--		<div class="col-md-8">-->


													<!--<a href="{{ Storage::disk('image')->url('uploads/venue/' . @$event_datas->venue_image) }}" data-fancybox="gallery2">-->
													<!--	<img src="{{ Storage::disk('image')->url('uploads/venue/' . @$event_datas->venue_image) }}" alt="Feature Image">-->
													<!--</a>-->


    									<!--		    </div>-->
    									<!--		</div>-->
    									<div class="row">
                                      <div class=" col-sm-8 col-md-8 col-lg-12 col-xl-12">
                                            <a href="{{ Storage::disk('image')->url('uploads/venue/' . @$event_datas->venue_image) }}" data-fancybox="gallery2">
                                                <img src="{{ Storage::disk('image')->url('uploads/venue/' . @$event_datas->venue_image) }}" alt="Feature Image" class="img-fluid">
                                            </a>
                                        </div>
                                        </div>
                                  </div>
											</div>
											<!-- /Clinic Content -->

											<!-- Clinic Timing -->
											<div class="col-md-12">
												<div class="clinic-timing"  style="overflow-x: scroll;">
													<div>



                                                        @foreach ($event_timings as $timing_date)

                                                        @php
                                                           $event_timing = App\Models\EventTiming::get_events_with_date($timing_date->event,$timing_date->event_date);
                                                        @endphp

                                                        <p class="timings-days">
															<span> {{ date('d D M Y',strtotime($timing_date->event_date)) }} </span>
														</p>


													    <div class="row">
                                                            <div class="col-12 col-md-6 offset-md-6 text-md-right">
                                                                <div class="form-group">
                                                                    <label for="ticketFilter">No. of Tickets:</label>
                                                                    <input type="number" id="ticketFilter" class="form-control" style="margin-bottom: 10px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if ($event_timing)

                                                        <table class="table table-striped">
                                                            <tr>
                                                                <th>Timing</th>
                                                                <th>Ticket Section</th>
                                                                {{-- <th>Booking</th> --}}
                                                            </tr>
                                                        @foreach ($event_timing as $event_time )

                                                            <tr>
                                                                <td>
															<span>{{ date('H:i A',strtotime($event_time->from_time)) }} - {{ date('H:i A',strtotime($event_time->to_time)) }}</span>

                                                                </td>
                                                                <td>

                                                                    <table class="table table-striped" id="esther" style="width: 100%;" >
                                                                        <tr>

                                                                            <th style="width: 10%">Ticket Section</th>
                                                                            <!--<th style="width: 10%">Type</th>-->
                                                                            <th style="width: 10%">Row</th>
                                                                            <th style="width: 15%">Ticket Type</th>
                                                                            <th style="width: 15%">Ticket Upload</th>
                                                                            <th style="width: 10%">Availability</th>
                                                                            <th style="width: 10%">Amount</th>
                                                                            <th style="width: 20%">Choose your quantity</th>
                                                                            {{-- <th>Proofs</th> --}}
                                                                        </tr>
                                                                        @php
                                                                        $event_ticket_list = App\Models\EventTiming::get_ticket_list($timing_date->event,$timing_date->id);
                                                                     @endphp
                                                                    @foreach ($event_ticket_list as $dat)
                                                                    @php
                                                                       $ticket_availability = App\Models\EventTiming::get_available_tickets($dat->id);

                                                                    @endphp
                                                                     <tr class="ticket-row" data-availability="{{ $ticket_availability }}">
                                                                        <td>{{ $dat->seating_type_name}}<i class='fas fa-marker'></i></td>
                                                                        <!--<td>{{ $dat->ticket_type_name }}</td>-->
                                                                        <td>{{ $dat->row }}</td>
                                                                        <td>
                                                                            {{ $dat->ticket_type_name }}<br>

                                                                        </td>
                                                                        <td>

                                                                           @if($dat->ticket_upload)
                                                                             @if(auth()->id() == $dat->created_by)

                                                                                <form id="editForm" action="{{ route('upload.ticket', ['id' => $dat->id]) }}" method="POST" enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    <a href="{{ Storage::disk('image')->url('uploads/ticket_images/' . $dat->ticket_upload) }}" target="_blank">
                                                                                        <i class="fas fa-ticket-alt"> View Ticket Here</i>
                                                                                    </a>
                                                                                    <span id="editArea">
                                                                                        <i class="fas fa-pencil-alt edit-icon" onclick="showFileUpload(this)"></i>
                                                                                    </span>
                                                                                    <input type="file" name="ticket_file" id="ticket_file" accept=".pdf, .doc, .docx" style="display: none;">
                                                                                    <button type="submit">Submit</button>
                                                                                </form>
                                                                            @endif



                                                                            @else
                                                                                <span style="color:red"><i class="fas fa-ticket-alt">Ticket not uploaded </i></span>

                                                                                <!-- File input for uploading ticket -->
                                                                                @if(auth()->id() == $dat->created_by)
                                                                                <form action="{{ route('upload.ticket', ['id' => $dat->id]) }}" method="post" enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    <input type="file" name="ticket_file" accept=".pdf, .doc, .docx">
                                                                                    <button type="submit">Upload</button>
                                                                                </form>
                                                                                @endif
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $ticket_availability.' Tickets Available' }}</td>

                                                                        @if(auth()->id() == $dat->created_by)
                                                                            <td class="editable">
                                                                                {{ $dat->web_price}}
                                                                                {{ $dat->short_name }} <i class="fas fa-pencil-alt edit-icon"></i>
                                                                                <input type="hidden" class="event-ticket-id" value="{{ $dat->id }}">
                                                                            </td>
                                                                        @else
                                                                            <td>{{ $dat->web_price.' '.$dat->short_name }}</td>
                                                                        @endif
                                                                        <td>
                                                                            @if($ticket_availability>0)
                                                                <form action="{{ url('submit_ticket_selected') }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf

                                                                    <input type="hidden" value="{{ $dat->id }}" name="event_ticket">
                                                                    <div class="row">
                                                                        <div class="col-md-5">
                                                                            <input type="number" style="width: 60px;" class="form-control"
                                                                                max="{{ $ticket_availability }}" min="1" name="buy_count"
                                                                                required />

                                                                        </div>
                                                                        <button class="apt-btn btn btn-primary" type="submit">Book</button>
                                                                        <div class="col-md-3">
                                                                         <a class="btn ripple btn-success view-ticket" data-bs-toggle="modal" data-bs-target="#modaldemo8"  href="#" title="Edit"><i class="fa fa-edit"></i></a>

                                                                        </div>
                                                                        </form>

                                                                        <div class="modal" id="modaldemo8">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content modal-content-demo">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Sell Details</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">

                                                 <div class="row">
                                                    <form class="form-horizontal" action="{{ route('tickets.outsidesell.store') }}" method="POST">
                                                        @csrf
                                                        {{-- <div class="mb-4 main-content-label">Name</div> --}}
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label class="form-label"> Name</label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control" name="name"  placeholder="Name" value="{{ old('name') }}">
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Phone</label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control" name="phone" placeholder="phone number" value="{{ old('phone') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Address</label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <textarea class="form-control" name="address" rows="2"  placeholder="Address">{{ old('address') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Date</label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="date" class="form-control" name="date" placeholder="date" value="{{ old('date') }}">
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Payment mode</label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control" name="payment_mode"  value="{{ old('payment') }}">
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        {{-- <input type="text" name="ticket_id" class="ticket-id-input" value="{{ $val->ticket_serial_number }}"> --}}
                                                        <input type="hidden" name="event_ticket_tickets_id" class="modal-ticket-id">



                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Save</button>
                                                        </div>
                                                    </form>


                                                 </div>

                                                </div>
                                            <div class="modal-footer">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                        @else

                                                                        <h6>Not Available</h6>
                                                                        @endif
                                                                        </td>
                                                                        {{-- <th>
                                                                           @if(!$dat->proof_of_id==null) <a href="{{ Storage::disk('image')->url('uploads/ticket_proof/proof_of_id/'.$dat->proof_of_id) }}" target="_blank" >
                                                                                ID Proof

                                                                            </a><br>
                                                                            @endif
                                                                            @if ($dat->proof_of_purchase)


                                                                            <a href="{{ Storage::disk('image')->url('uploads/ticket_proof/proof_of_purchase/'.$dat->proof_of_purchase) }}" target="_blank" >
                                                                                Purchase Proof
                                                                            </a>
                                                                            @endif
                                                                        </th> --}}
                                                                    </tr>

                                                                    @endforeach

                                                                    </table>
                                                                </td>

                                                            </tr>

                                                        @endforeach

                                                        </table>





                                                        @endif


                                                        @endforeach

													</div>

												</div>
											</div>
											<!-- /Clinic Timing -->

											{{-- <div class="col-md-2">
												<div class="consult-price">
													$250
												</div>
											</div> --}}
										</div>
									</div>
									<!-- /Location List -->

									<!-- Location List -->

									<!-- /Location List -->

								</div>
								<!-- /Locations Content -->

								<!-- Reviews Content -->
								<div role="tabpanel" id="doc_reviews" class="tab-pane fade">

									<!-- Review Listing -->
									<div class="widget review-listing">
										<ul class="comments-list">

											<!-- Comment List -->
                                            @foreach ($event_reviews as $val )
                                            <li>
												<div class="comment">
													{{-- <img class="avatar avatar-sm rounded-circle" alt="User Image" src="assets/img/customers/customer.jpg"> --}}
													<div class="comment-body">
														<div class="meta-data">
															<span class="comment-author">{{ $val->customer_name }}</span>
															<span class="comment-date">Reviewed 2 Days ago</span>
															<div class="review-count rating">
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star"></i>
															</div>
														</div>
														{{-- <p class="recommended"><i class="far fa-thumbs-up"></i> I recommend the Event</p> --}}
														<p class="comment-content">
															{{ $val->review_content }}
														</p>
														<div class="comment-reply">
															<a class="comment-btn" href="#">
																<i class="fas fa-reply"></i> Reply
															</a>
														   <p class="recommend-btn">
															<span>Recommend?</span>
															<a href="#" class="like-btn">
																<i class="far fa-thumbs-up"></i> Yes
															</a>
															<a href="#" class="dislike-btn">
																<i class="far fa-thumbs-down"></i> No
															</a>
														</p>
														</div>
													</div>
												</div>

											</li>
                                            @endforeach

											<!-- /Comment List -->

											<!-- Comment List -->

											<!-- /Comment List -->

										</ul>

										<!-- Show All -->
										<div class="all-feedback text-center">
											<a href="#" class="btn btn-primary btn-sm">
												Show all feedback <strong>({{ count($event_reviews) }})</strong>
											</a>
										</div>
										<!-- /Show All -->

									</div>
									<!-- /Review Listing -->

									<!-- Write Review -->

									<!-- /Write Review -->

								</div>
								<!-- /Reviews Content -->

								<!-- Business Hours Content -->
								<div role="tabpanel" id="doc_business_hours" class="tab-pane fade">
									<div class="row">
										<div class="col-md-6 offset-md-3">

											<!-- Business Hours Widget -->
											<div class="widget business-widget">
												<div class="widget-content">
													<div class="listing-hours">
														<div class="listing-day current">
															<div class="day">Today <span>5 Nov 2020</span></div>
															<div class="time-items">
																<span class="open-status"><span class="badge bg-success-light">Open Now</span></span>
																<span class="time">07:00 AM - 09:00 PM</span>
															</div>
														</div>
														<div class="listing-day">
															<div class="day">Monday</div>
															<div class="time-items">
																<span class="time">07:00 AM - 09:00 PM</span>
															</div>
														</div>
														<div class="listing-day">
															<div class="day">Tuesday</div>
															<div class="time-items">
																<span class="time">07:00 AM - 09:00 PM</span>
															</div>
														</div>
														<div class="listing-day">
															<div class="day">Wednesday</div>
															<div class="time-items">
																<span class="time">07:00 AM - 09:00 PM</span>
															</div>
														</div>
														<div class="listing-day">
															<div class="day">Thursday</div>
															<div class="time-items">
																<span class="time">07:00 AM - 09:00 PM</span>
															</div>
														</div>
														<div class="listing-day">
															<div class="day">Friday</div>
															<div class="time-items">
																<span class="time">07:00 AM - 09:00 PM</span>
															</div>
														</div>
														<div class="listing-day">
															<div class="day">Saturday</div>
															<div class="time-items">
																<span class="time">07:00 AM - 09:00 PM</span>
															</div>
														</div>
														<div class="listing-day closed">
															<div class="day">Sunday</div>
															<div class="time-items">
																<span class="time"><span class="badge bg-danger-light">Closed</span></span>
															</div>
														</div>
													</div>
												</div>
											</div>
											<!-- /Business Hours Widget -->

										</div>
									</div>
								</div>
								<!-- /Business Hours Content -->

							</div>
						</div>
					</div>
					<!-- /speaker Details Tab -->

				</div>
			</div>
			<!-- /Page Content -->

			</div>
			<!-- Voice Call Modal -->
		<div class="modal fade call-modal" id="voice_call">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<!-- Outgoing Call -->
						<div class="call-box incoming-box">
							<div class="call-wrapper">
								<div class="call-inner">
									<div class="call-user">
										<img alt="User Image" src="assets/img/speakers/speaker-thumb-02.jpg" class="call-avatar">
										<h4>Wayte Barlow</h4>
										<span>Connecting...</span>
									</div>
									<div class="call-items">
										<a href="javascript:void(0);" class="btn call-item call-end" data-dismiss="modal" aria-label="Close"><i class="material-icons">call_end</i></a>
										<a href="voice-call" class="btn call-item call-start"><i class="material-icons">call</i></a>
									</div>
								</div>
							</div>
						</div>
						<!-- Outgoing Call -->

					</div>
				</div>
			</div>
		</div>
		<!-- /Voice Call Modal -->

		<!-- Video Call Modal -->
		<div class="modal fade call-modal" id="video_call">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-body">

						<!-- Incoming Call -->
						<div class="call-box incoming-box">
							<div class="call-wrapper">
								<div class="call-inner">
									<div class="call-user">
										<img class="call-avatar" src="assets/img/speakers/speaker-thumb-02.jpg" alt="User Image">
										<h4>Wayte Barlow</h4>
										<span>Calling ...</span>
									</div>
									<div class="call-items">
										<a href="javascript:void(0);" class="btn call-item call-end" data-dismiss="modal" aria-label="Close"><i class="material-icons">call_end</i></a>
										<a href="video-call" class="btn call-item call-start"><i class="material-icons">videocam</i></a>
									</div>
								</div>
							</div>
						</div>
						<!-- /Incoming Call -->

					</div>
				</div>
			</div>
		</div>
		<!-- Video Call Modal -->

<!-- Include jQuery if not already included -->
<!-- Include jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://just4entertainment.com/public/assets/js/toastr.min.js"></script>



{{-- <script>
    $(document).ready(function () {
        $(document).on('click', '.editable .edit-icon', function () {
            var td = $(this).closest('td');
            var originalContent = td.clone().children().remove().end().text().trim().replace(/[^0-9.]/g, '');

            // Extract event ticket ID from the hidden input
            var eventTicketId = td.find('.event-ticket-id').val();

            var inputField = $('<input type="text" class="form-control" value="' + originalContent + '">');
            td.html(inputField);
            inputField.focus();
            inputField.on('blur', function () {
                var newContent = inputField.val();

                var dataId = td.closest('tr').data('id');
                $.ajax({
                    url: '/public/update-facevalue-ticket',
                    type: 'POST',
                    data: {
                        web_price: newContent,
                        event_ticket_id: eventTicketId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log(response);

                        // Check if the response indicates success
                        if (response.success) {
                            // Show a success message using Toastr
                            toastr.success('Web price updated successfully');
                        } else {
                            // Show an error message
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function (error) {
                        console.error('Error:', error);
                    }
                });

                td.html(newContent + ' <i class="fas fa-pencil-alt edit-icon"></i>' +
                    '<input type="hidden" class="event-ticket-id" value="' + eventTicketId + '">');
            });
        });
    });
</script> --}}

<script>
    $(document).ready(function () {
        $(document).on('click', '.editable .edit-icon', function () {
            var td = $(this).closest('td');
            var originalContent = td.clone().children().remove().end().text().trim().replace(/[^0-9.]/g, '');

            var eventTicketId = td.find('.event-ticket-id').val();

            var inputField = $('<input type="text" class="form-control" value="' + originalContent + '">');
            td.html(inputField);
            inputField.focus();
            inputField.on('blur', function () {
                var newContent = inputField.val();

                var dataId = td.closest('tr').data('id');
                $.ajax({
                    url: '/public/update-facevalue-ticket',
                    type: 'POST',
                    data: {
                        web_price: newContent,

                        event_ticket_id: eventTicketId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log(response);

                        if (response.success) {
                            td.html(newContent + ' USD <i class="fas fa-pencil-alt edit-icon"></i>' +
                                '<input type="hidden" class="event-ticket-id" value="' + eventTicketId + '">');

                            toastr.success('Web price updated successfully');
                            window.location.reload();

                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function (error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    });
</script>



<script>
    document.getElementById('ticketFilter').addEventListener('input', function() {

        var filterValue = parseInt(this.value, 10);
        var rows = document.querySelectorAll('.ticket-row');

        rows.forEach(function(row) {
            var availability = parseInt(row.getAttribute('data-availability'), 10);

            if (isNaN(filterValue) || availability >= filterValue) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<script>
    function showFileUpload(icon) {
        // Hide the pencil icon
        icon.style.display = 'none';

        // Show the file input element
        var fileInput = document.getElementById('ticket_file');
        fileInput.style.display = 'inline-block'; // Display the file input inline

        // Optionally, you can focus on the file input after showing it
        fileInput.focus();
    }
</script>














@endsection
