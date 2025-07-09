<?php $page="customer-dashboard";?>
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
									<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Dashboard</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<div class="row">
						
						<!-- Profile Sidebar -->
						<div class="col-md-4 col-lg-4 col-xl-3 theiaStickySidebar">
							<div class="profile-sidebar">
								<div class="widget-profile pro-widget-content">
									<div class="profile-info-widget">
										<a href="#" class="booking-doc-img">
											<img src="assets/img/customers/customer.jpg" alt="User Image">
										</a>
										<div class="profile-det-info">
											<h3>Thyme Frierson</h3>
											<div class="customer-details">
												<h5><i class="fas fa-birthday-cake"></i> 24 Jul 1983, 38 years</h5>
												<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Newyork, USA</h5>
											</div>
										</div>
									</div>
								</div>
								<div class="dashboard-widget">
									<nav class="dashboard-menu">
										<ul>
											<li class="active">
												<a href="customer-dashboard">
													<i class="fas fa-columns"></i>
													<span>Dashboard</span>
												</a>
											</li>
											<li>
												<a href="favourites">
													<i class="fas fa-bookmark"></i>
													<span>Favourites</span>
												</a>
											</li>
											<li>
												<a href="chat">
													<i class="fas fa-comments"></i>
													<span>Message</span>
													<small class="unread-msg">23</small>
												</a>
											</li>
											<li>
												<a href="profile-settings">
													<i class="fas fa-user-cog"></i>
													<span>Profile Settings</span>
												</a>
											</li>
											<li>
												<a href="change-password">
													<i class="fas fa-lock"></i>
													<span>Change Password</span>
												</a>
											</li>
											<li>
												<a href="index">
													<i class="fas fa-sign-out-alt"></i>
													<span>Logout</span>
												</a>
											</li>
										</ul>
									</nav>
								</div>

							</div>
						</div>
						<!-- / Profile Sidebar -->
						
						<div class="col-md-8 col-lg-8 col-xl-9">
							<div class="card">
								<div class="card-body pt-0">
								
									<!-- Tab Menu -->
									<nav class="user-tabs mb-4">
										<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
											<li class="nav-item">
												<a class="nav-link active" href="#pat_appointments" data-toggle="tab">Bookings</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#pat_Programss" data-toggle="tab">Programs</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#pat_medical_records" data-toggle="tab"><span class="med-records">Event Info</span></a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#pat_billing" data-toggle="tab">Billing</a>
											</li>
										</ul>
									</nav>
									<!-- /Tab Menu -->
									
									<!-- Tab Content -->
									<div class="tab-content pt-0">
										
										<!-- Booking Tab -->
										<div id="pat_appointments" class="tab-pane fade show active">
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="table-responsive">
														<table class="table table-hover table-center mb-0">
															<thead>
																<tr>
																	<th>Speaker</th>
																	<th>Event Date</th>
																	<th>Booking Date</th>
																	<th>Amount</th>
																	<th>Follow Up</th>
																	<th>Status</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-01.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Blaine Skipper <span>DJ, Producer</span></a>
																		</h2>
																	</td>
																	<td>14 Nov 2020 <span class="d-block text-info">10.00 AM</span></td>
																	<td>12 Nov 2020</td>
																	<td>$160</td>
																	<td>16 Nov 2020</td>
																	<td><span class="badge badge-pill bg-success-light">Confirm</span></td>
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
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-02.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Wayte Barlow <span>DJ, Producer</span></a>
																		</h2>
																	</td>
																	<td>12 Nov 2020 <span class="d-block text-info">8.00 PM</span></td>
																	<td>12 Nov 2020</td>
																	<td>$250</td>
																	<td>14 Nov 2020</td>
																	<td><span class="badge badge-pill bg-success-light">Confirm</span></td>
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
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-03.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Meerta Tyson <span>DJ Reader</span></a>
																		</h2>
																	</td>
																	<td>11 Nov 2020 <span class="d-block text-info">11.00 AM</span></td>
																	<td>10 Nov 2020</td>
																	<td>$400</td>
																	<td>13 Nov 2020</td>
																	<td><span class="badge badge-pill bg-danger-light">Cancelled</span></td>
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
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-04.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Rhodes Glaser <span>DJ, Mix Engineer</span></a>
																		</h2>
																	</td>
																	<td>10 Nov 2020 <span class="d-block text-info">3.00 PM</span></td>
																	<td>10 Nov 2020</td>
																	<td>$350</td>
																	<td>12 Nov 2020</td>
																	<td><span class="badge badge-pill bg-warning-light">Pending</span></td>
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
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-05.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Dallin Donaldson <span>Artist & DJ</span></a>
																		</h2>
																	</td>
																	<td>9 Nov 2020 <span class="d-block text-info">7.00 PM</span></td>
																	<td>8 Nov 2020</td>
																	<td>$75</td>
																	<td>11 Nov 2020</td>
																	<td><span class="badge badge-pill bg-success-light">Confirm</span></td>
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
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-06.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Mykah Derr <span>DJ, Artist</span></a>
																		</h2>
																	</td>
																	<td>8 Nov 2020 <span class="d-block text-info">9.00 AM</span></td>
																	<td>6 Nov 2020</td>
																	<td>$175</td>
																	<td>10 Nov 2020</td>
																	<td><span class="badge badge-pill bg-danger-light">Cancelled</span></td>
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
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-07.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Ozella Barbee <span>DJ, Mix Engineer</span></a>
																		</h2>
																	</td>
																	<td>8 Nov 2020 <span class="d-block text-info">6.00 PM</span></td>
																	<td>6 Nov 2020</td>
																	<td>$450</td>
																	<td>10 Nov 2020</td>
																	<td><span class="badge badge-pill bg-success-light">Confirm</span></td>
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
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-08.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Mayeer Busch <span>Mix Engineer</span></a>
																		</h2>
																	</td>
																	<td>7 Nov 2020 <span class="d-block text-info">9.00 PM</span></td>
																	<td>7 Nov 2020</td>
																	<td>$275</td>
																	<td>9 Nov 2020</td>
																	<td><span class="badge badge-pill bg-success-light">Confirm</span></td>
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
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-09.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Farren Blalock <span>DJ, Producer</span></a>
																		</h2>
																	</td>
																	<td>6 Nov 2020 <span class="d-block text-info">8.00 PM</span></td>
																	<td>4 Nov 2020</td>
																	<td>$600</td>
																	<td>8 Nov 2020</td>
																	<td><span class="badge badge-pill bg-success-light">Confirm</span></td>
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
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-10.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Sissel Browne  <span>DJ, Producer</span></a>
																		</h2>
																	</td>
																	<td>5 Nov 2020 <span class="d-block text-info">5.00 PM</span></td>
																	<td>1 Nov 2020</td>
																	<td>$100</td>
																	<td>7 Nov 2020</td>
																	<td><span class="badge badge-pill bg-success-light">Confirm</span></td>
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
										<!-- /Booking Tab -->
										
										<!-- Programs Tab -->
										<div class="tab-pane fade" id="pat_Programss">
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="table-responsive">
														<table class="table table-hover table-center mb-0">
															<thead>
																<tr>
																	<th>Date </th>
																	<th>Name</th>			
																	<th>Created by </th>
																	<th></th>
																</tr>     
															</thead>
															<tbody>
																<tr>
																	<td>14 Nov 2020</td>
																	<td>Songs</td>
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
																	<td>13 Nov 2020</td>
																	<td>Party</td>
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
																		</div>
																	</td>
																</tr>
																<tr>
																	<td>12 Nov 2020</td>
																	<td>Games</td>
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
																	<td>11 Nov 2020</td>
																	<td>story Books Dance</td>
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
																	<td>10 Nov 2020</td>
																	<td>Welcome Speech</td>
																	<td>
																		<h2 class="table-avatar">
																			<a href="speaker-profile" class="avatar avatar-sm mr-2">
																				<img class="avatar-img rounded-circle" src="assets/img/speakers/speaker-thumb-05.jpg" alt="User Image">
																			</a>
																			<a href="speaker-profile">Dallin Donaldson <span>DJ, Producer</span></a>
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
																	<td>9 Nov 2020</td>
																	<td>Songs</td>
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
																	<td>8 Nov 2020</td>
																	<td>Dinner</td>
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
																	<td>7 Nov 2020</td>
																	<td>Party</td>
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
																	<td>6 Nov 2020</td>
																	<td>Sangeet</td>
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
																	<td>5 Nov 2020</td>
																	<td>Party</td>
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
										<!-- /Programs Tab -->
											
										<!-- Event Info Tab -->
										<div id="pat_medical_records" class="tab-pane fade">
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="table-responsive">
														<table class="table table-hover table-center mb-0">
															<thead>
																<tr>
																	<th>ID</th>
																	<th>Date </th>
																	<th>Events</th>
																	<th>Created</th>
																	<th></th>
																</tr>     
															</thead>
															<tbody>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0010</a></td>
																	<td>14 Nov 2020</td>
																	<td>Workshop</td>
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
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0009</a></td>
																	<td>13 Nov 2020</td>
																	<td>Culturals</td>
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
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0008</a></td>
																	<td>12 Nov 2020</td>
																	<td>Party</td>
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
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0007</a></td>
																	<td>11 Nov 2020</td>
																	<td>Workshop</td>
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
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0006</a></td>
																	<td>10 Nov 2020</td>
																	<td>Song Recording</td>
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
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0005</a></td>
																	<td>9 Nov 2020</td>
																	<td>Meeting Hall</td>
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
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0004</a></td>
																	<td>8 Nov 2020</td>
																	<td>Party Event</td>
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
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0003</a></td>
																	<td>7 Nov 2020</td>
																	<td>Workshop</td>
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
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0002</a></td>
																	<td>6 Nov 2020</td>
																	<td>Conference</td>
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
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
																			</a>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td><a href="javascript:void(0);">#MR-0001</a></td>
																	<td>5 Nov 2020</td>
																	<td>Seminar</td>
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
																			<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
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
										<!-- /Event Info Tab -->
										
										<!-- Billing Tab -->
										<div id="pat_billing" class="tab-pane fade">
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
																			<a href="invoice-view" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
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
																			<a href="invoice-view" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
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
																			<a href="invoice-view" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
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
																			<a href="invoice-view" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
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
																			<a href="invoice-view" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
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
																			<a href="invoice-view" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
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
																			<a href="invoice-view" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
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
																			<a href="invoice-view" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
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
																			<a href="invoice-view" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
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
																			<a href="invoice-view" class="btn btn-sm bg-info-light">
																				<i class="far fa-eye"></i> View
																			</a>
																			<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																				<i class="fas fa-print"></i> Print
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
										<!-- /Billing Tab -->
										
									</div>
									<!-- Tab Content -->
									
								</div>
							</div>
						</div>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->
   
			</div>
	   @endsection
	  