<?php $page="my-customers";?>
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
									<li class="breadcrumb-item active" aria-current="page">My customers</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">My customers</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<div class="row">
						<div class="col-md-4 col-lg-4 col-xl-3 theiaStickySidebar">
						
							<!-- Profile Sidebar -->
							<div class="profile-sidebar">
								<div class="widget-profile pro-widget-content">
									<div class="profile-info-widget">
										<a href="#" class="booking-doc-img">
											<img src="assets/img/speakers/speaker-thumb-02.jpg" alt="User Image">
										</a>
										<div class="profile-det-info">
											<h3>Wayte Barlow</h3>
											
											<div class="customer-details">
												<h5 class="mb-0">MCA, BE - 10+ Years Experience</h5>
											</div>
										</div>
									</div>
								</div>
								<div class="dashboard-widget">
									<nav class="dashboard-menu">
										<ul>
											<li>
												<a href="speaker-dashboard">
													<i class="fas fa-columns"></i>
													<span>Dashboard</span>
												</a>
											</li>
											<li>
												<a href="events">
													<i class="fas fa-calendar-check"></i>
													<span>Events</span>
												</a>
											</li>
											<li class="active">
												<a href="my-customers">
													<i class="fas fa-user-injured"></i>
													<span>My customers</span>
												</a>
											</li>
											<li>
												<a href="schedule-timings">
													<i class="fas fa-hourglass-start"></i>
													<span>Schedule Timings</span>
												</a>
											</li>
											<li>
												<a href="invoices">
													<i class="fas fa-file-invoice"></i>
													<span>Invoices</span>
												</a>
											</li>
											<li>
												<a href="reviews">
													<i class="fas fa-star"></i>
													<span>Reviews</span>
												</a>
											</li>
											<li>
												<a href="chat-speaker">
													<i class="fas fa-comments"></i>
													<span>Message</span>
													<small class="unread-msg">23</small>
												</a>
											</li>
											<li>
												<a href="speaker-profile-settings">
													<i class="fas fa-user-cog"></i>
													<span>Profile Settings</span>
												</a>
											</li>
											<li>
												<a href="social-media">
													<i class="fas fa-share-alt"></i>
													<span>Social Media</span>
												</a>
											</li>
											<li>
												<a href="speaker-change-password">
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
							<!-- /Profile Sidebar -->
							
						</div>
						<div class="col-md-8 col-lg-8 col-xl-9">
						
							<div class="row row-grid">
								<div class="col-md-6 col-lg-4">
									<div class="card widget-profile pat-widget-profile">
										<div class="card-body">
											<div class="pro-widget-content">
												<div class="profile-info-widget">
													<a href="customer-profile" class="booking-doc-img">
														<img src="assets/img/customers/customer.jpg" alt="User Image">
													</a>
													<div class="profile-det-info">
														<h3><a href="customer-profile">Thyme Frierson</a></h3>
														
														<div class="customer-details">
															<h5><b>customer ID :</b> P0016</h5>
															<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Alabama, USA</h5>
														</div>
													</div>
												</div>
											</div>
											<div class="customer-info">
												<ul>
													<li>Phone <span>+1 952 001 8563</span></li>
													<li>Age <span>38 Years, Male</span></li>
													<li>Event Name <span>Sangeet</span></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-lg-4">
									<div class="card widget-profile pat-widget-profile">
										<div class="card-body">
											<div class="pro-widget-content">
												<div class="profile-info-widget">
													<a href="customer-profile" class="booking-doc-img">
														<img src="assets/img/customers/customer1.jpg" alt="User Image">
													</a>
													<div class="profile-det-info">
														<h3><a href="customer-profile">Cedrica Large</a></h3>
														
														<div class="customer-details">
															<h5><b>customer ID :</b> P0001</h5>
															<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> North Carolina, USA</h5>
														</div>
													</div>
												</div>
											</div>
											<div class="customer-info">
												<ul>
													<li>Phone <span>+1 828 632 9170</span></li>
													<li>Age <span>29 Years, Female</span></li>
													<li>Event Name <span>Conference</span></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-lg-4">
									<div class="card widget-profile pat-widget-profile">
										<div class="card-body">
											<div class="pro-widget-content">
												<div class="profile-info-widget">
													<a href="#" class="booking-doc-img">
														<img src="assets/img/customers/customer2.jpg" alt="User Image">
													</a>
													<div class="profile-det-info">
														<h3>Warford Cowan </h3>
														<div class="customer-details">
															<h5><b>customer ID :</b> PT0002</h5>
															<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Maine, USA</h5>
														</div>
													</div>
												</div>
											</div>
											<div class="customer-info">
												<ul>
													<li>Phone <span>+1 207 729 9974</span></li>
													<li>Age <span>23 Years, Male</span></li>
													<li>Event Name <span>Award Function</span></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-lg-4">
									<div class="card widget-profile pat-widget-profile">
										<div class="card-body">
											<div class="pro-widget-content">
												<div class="profile-info-widget">
													<a href="#" class="booking-doc-img">
														<img src="assets/img/customers/customer3.jpg" alt="User Image">
													</a>
													<div class="profile-det-info">
														<h3>Axe Gibson</h3>
														<div class="customer-details">
															<h5><b>customer ID :</b> PT0003</h5>
															<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Indiana, USA</h5>
														</div>
													</div>
												</div>
											</div>
											<div class="customer-info">
												<ul>
													<li>Phone <span>+1 260 724 7769</span></li>
													<li>Age <span>32 Years, Male</span></li>
													<li>Event Name <span>Party</span></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-lg-4">
									<div class="card widget-profile pat-widget-profile">
										<div class="card-body">
											<div class="pro-widget-content">
												<div class="profile-info-widget">
													<a href="#" class="booking-doc-img">
														<img src="assets/img/customers/customer4.jpg" alt="User Image">
													</a>
													<div class="profile-det-info">
														<h3>Mia Lerner</h3>
														<div class="customer-details">
															<h5><b>customer ID :</b> PT0004</h5>
															<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Indiana, USA</h5>
														</div>
													</div>
												</div>
											</div>
											<div class="customer-info">
												<ul>
													<li>Phone <span>+1 504 368 6874</span></li>
													<li>Age <span>25 Years, Female</span></li>
													<li>Event Name <span>Award Function</span></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-lg-4">
									<div class="card widget-profile pat-widget-profile">
										<div class="card-body">
											<div class="pro-widget-content">
												<div class="profile-info-widget">
													<a href="#" class="booking-doc-img">
														<img src="assets/img/customers/customer5.jpg" alt="User Image">
													</a>
													<div class="profile-det-info">
														<h3>Secorra Dowling</h3>
														<div class="customer-details">
															<h5><b>customer ID :</b> PT0005</h5>
															<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Florida, USA</h5>
														</div>
													</div>
												</div>
											</div>
											<div class="customer-info">
												<ul>
													<li>Phone <span>+1 954 820 7887</span></li>
													<li>Age <span>25 Years, Female</span></li>
													<li>Event Name <span>Seminar</span></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-lg-4">
									<div class="card widget-profile pat-widget-profile">
										<div class="card-body">
											<div class="pro-widget-content">
												<div class="profile-info-widget">
													<a href="#" class="booking-doc-img">
														<img src="assets/img/customers/customer6.jpg" alt="User Image">
													</a>
													<div class="profile-det-info">
														<h3>Ellie Kent</h3>
														<div class="customer-details">
															<h5><b>customer ID :</b> PT0006</h5>
															<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Kentucky, USA</h5>
														</div>
													</div>
												</div>
											</div>
											<div class="customer-info">
												<ul>
													<li>Phone <span>+1 315 384 4562</span></li>
													<li>Age <span>14 Years, Female</span></li>
													<li>Event Name <span>Birthday</span></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-lg-4">
									<div class="card widget-profile pat-widget-profile">
										<div class="card-body">
											<div class="pro-widget-content">
												<div class="profile-info-widget">
													<a href="#" class="booking-doc-img">
														<img src="assets/img/customers/customer7.jpg" alt="User Image">
													</a>
													<div class="profile-det-info">
														<h3>Branice Grier</h3>
														<div class="customer-details">
															<h5><b>customer ID :</b> PT0007</h5>
															<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> California, USA</h5>
														</div>
													</div>
												</div>
											</div>
											<div class="customer-info">
												<ul>
													<li>Phone <span>+1 707 2202 603</span></li>
													<li>Age <span>25 Years, Female</span></li>
													<li>Event Name <span>Wedding</span></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-lg-4">
									<div class="card widget-profile pat-widget-profile">
										<div class="card-body">
											<div class="pro-widget-content">
												<div class="profile-info-widget">
													<a href="#" class="booking-doc-img">
														<img src="assets/img/customers/customer8.jpg" alt="User Image">
													</a>
													<div class="profile-det-info">
														<h3>Augy Naranjo</h3>
														<div class="customer-details">
															<h5><b>customer ID :</b> PT0007</h5>
															<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> New Jersey, USA</h5>
														</div>
													</div>
												</div>
											</div>
											<div class="customer-info">
												<ul>
													<li>Phone <span>+1 973 773 9497</span></li>
													<li>Age <span>28 Years, Male</span></li>
													<li>Event Name <span>Conference</span></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-lg-4">
									<div class="card widget-profile pat-widget-profile">
										<div class="card-body">
											<div class="pro-widget-content">
												<div class="profile-info-widget">
													<a href="#" class="booking-doc-img">
														<img src="assets/img/customers/customer9.jpg" alt="User Image">
													</a>
													<div class="profile-det-info">
														<h3>Speero Dobbs</h3>
														<div class="customer-details">
															<h5><b>customer ID :</b> PT0009</h5>
															<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Florida, USA</h5>
														</div>
													</div>
												</div>
											</div>
											<div class="customer-info">
												<ul>
													<li>Phone <span>+1 850 358 4445</span></li>
													<li>Age <span>28 Years, Male</span></li>
													<li>Event Name <span>Party</span></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-lg-4">
									<div class="card widget-profile pat-widget-profile">
										<div class="card-body">
											<div class="pro-widget-content">
												<div class="profile-info-widget">
													<a href="#" class="booking-doc-img">
														<img src="assets/img/customers/customer10.jpg" alt="User Image">
													</a>
													<div class="profile-det-info">
														<h3>Paulus Peebles</h3>
														<div class="customer-details">
															<h5><b>customer ID :</b> PT0010</h5>
															<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> California, USA</h5>
														</div>
													</div>
												</div>
											</div>
											<div class="customer-info">
												<ul>
													<li>Phone <span>+1 858 259 5285</span></li>
													<li>Age <span>19 Years, Male</span></li>
													<li>Event Name <span>Award Function</span></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-lg-4">
									<div class="card widget-profile pat-widget-profile">
										<div class="card-body">
											<div class="pro-widget-content">
												<div class="profile-info-widget">
													<a href="#" class="booking-doc-img">
														<img src="assets/img/customers/customer11.jpg" alt="User Image">
													</a>
													<div class="profile-det-info">
														<h3>Arvon Pappas</h3>
														<div class="customer-details">
															<h5><b>customer ID :</b> PT0011</h5>
															<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Colorado, USA</h5>
														</div>
													</div>
												</div>
											</div>
											<div class="customer-info">
												<ul>
													<li>Phone <span>+1 303 607 7075</span></li>
													<li>Age <span>9 Years, Male</span></li>
													<li>Event Name <span>Wedding</span></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								
							</div>

						</div>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->
   
			</div>
	   @endsection
	  