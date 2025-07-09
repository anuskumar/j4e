<?php $page="events";?>
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
						<div class="col-md-4 col-lg-4 col-xl-3 theiaStickySidebar">

							<!-- Profile Sidebar -->

                     @include('layout.re_sidebar');

							<!-- /Profile Sidebar -->

						</div>

						<div class="col-md-8 col-lg-8 col-xl-9">

							<div class="card event-service">
								<div class="card-body py-0">

									<!-- Tab Menu -->
									<nav class="user-tabs mb-4">
										<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
											<li class="nav-item">
												<a class="nav-link active" href="#pat_appointments" data-toggle="tab">Active Events</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#pat_Programss" data-toggle="tab">Inactive Events</a>
											</li>
										</ul>
									</nav>
									<!-- /Tab Menu -->

									<!-- Tab Content -->
									<div class="tab-content pt-0">

										<!-- Active Events -->
										<div id="pat_appointments" class="tab-pane fade show active">
											<div class="row row-grid">
												<div class="col-md-6 col-lg-4">
													<div class="profile-widget">
														<div class="doc-img">
															<a href="event-details">
																<img class="img-fluid" alt="User Image" src="assets/img/events/event-06.jpg">
															</a>
															<a href="javascript:void(0)" class="fav-btn" title="Inactive">
																<i class="far fa-eye-slash"></i>
															</a>
														</div>
														<div class="pro-content">
															<h3 class="title">
																<span>Seminar</span>
																<a href="event-details">Marketing Matters!</a>
															</h3>
															<p class="add-cont">8 Northumberland Ave, Westminster,</p>
															<div class="profile-info d-flex mb-0">
																<a href="speaker-profile" class="profile-img">
																	<img src="assets/img/profile/profile-06.jpg" alt="">
																</a>
																<a href="speaker-profile">
																	<span class="profile-name">ms. Ansleigh</span>
																	<span class="profile-pro">Marketing</span>
																</a>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6 col-lg-4">
													<div class="profile-widget">
														<div class="doc-img">
															<a href="event-details">
																<img class="img-fluid" alt="User Image" src="assets/img/events/event-05.jpg">
															</a>
															<a href="javascript:void(0)" class="fav-btn" title="Inactive">
																<i class="far fa-eye-slash"></i>
															</a>
														</div>
														<div class="pro-content">
															<h3 class="title">
																<span>workshop</span>
																<a href="event-details">Marketing Matters!</a>
															</h3>
															<p class="add-cont">8 Northumberland Ave, Westminster,</p>
															<div class="profile-info d-flex mb-0">
																<a href="#" class="profile-img">
																	<img src="assets/img/profile/profile-05.jpg" alt="">
																</a>
																<a href="speaker-profile">
																	<span class="profile-name">mr. Fuad Lyles</span>
																	<span class="profile-pro">Former ceo</span>
																</a>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6 col-lg-4">
													<div class="profile-widget">
														<div class="doc-img">
															<a href="event-details">
																<img class="img-fluid" alt="User Image" src="assets/img/events/event-01.jpg">
															</a>
															<a href="javascript:void(0)" class="fav-btn" title="Inactive">
																<i class="far fa-eye-slash"></i>
															</a>
														</div>
														<div class="pro-content">
															<h3 class="title">
																<span>workshop</span>
																<a href="event-details">Marketing Matters!</a>
															</h3>
															<p class="add-cont">8 Northumberland Ave, Westminster,</p>
															<div class="profile-info d-flex mb-0">
																<a href="speaker-profile" class="profile-img">
																	<img src="assets/img/profile/profile-01.jpg" alt="">
																</a>
																<a href="speaker-profile">
																	<span class="profile-name">ms. Annie</span>
																	<span class="profile-pro">ceo  -  turbofloid</span>
																</a>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6 col-lg-4">
													<div class="profile-widget">
														<div class="doc-img">
															<a href="event-details">
																<img class="img-fluid" alt="User Image" src="assets/img/events/event-04.jpg">
															</a>
															<a href="javascript:void(0)" class="fav-btn" title="Inactive">
																<i class="far fa-eye-slash"></i>
															</a>
														</div>
														<div class="pro-content">
															<h3 class="title">
																<span>DIGITAL  EVENTS</span>
																<a href="event-details">Marketing Matters!</a>
															</h3>
															<p class="add-cont">8 Northumberland Ave, Westminster,</p>
															<div class="profile-info d-flex mb-0">
																<a href="speaker-profile" class="profile-img">
																	<img src="assets/img/profile/profile-04.jpg" alt="">
																</a>
																<a href="speaker-profile">
																	<span class="profile-name">mr. Adar Li</span>
																	<span class="profile-pro">Managing Director</span>
																</a>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6 col-lg-4">
													<div class="profile-widget">
														<div class="doc-img">
															<a href="event-details">
																<img class="img-fluid" alt="User Image" src="assets/img/events/event-03.jpg">
															</a>
															<a href="javascript:void(0)" class="fav-btn" title="Inactive">
																<i class="far fa-eye-slash"></i>
															</a>
														</div>
														<div class="pro-content">
															<h3 class="title">
																<span>TECH, Digital</span>
																<a href="event-details">Tech Matters!</a>
															</h3>
															<p class="add-cont">8 Northumberland Ave, Westminster,</p>
															<div class="profile-info d-flex mb-0">
																<a href="speaker-profile" class="profile-img">
																	<img src="assets/img/profile/profile-03.jpg" alt="">
																</a>
																<a href="speaker-profile">
																	<span class="profile-name">ms. Tilli Devlin</span>
																	<span class="profile-pro">Chief Executive</span>
																</a>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6 col-lg-4">
													<div class="profile-widget">
														<div class="doc-img">
															<a href="event-details">
																<img class="img-fluid" alt="User Image" src="assets/img/events/event-07.jpg">
															</a>
															<a href="javascript:void(0)" class="fav-btn" title="Inactive">
																<i class="far fa-eye-slash"></i>
															</a>
														</div>
														<div class="pro-content">
															<h3 class="title">
																<span>Party</span>
																<a href="event-details">New Year Event!</a>
															</h3>
															<p class="add-cont">North Carolina, United States</p>
															<div class="profile-info d-flex mb-0">
																<a href="speaker-profile" class="profile-img">
																	<img src="assets/img/profile/profile-07.jpg" alt="">
																</a>
																<a href="speaker-profile">
																	<span class="profile-name">ms. Meirav Gatlin</span>
																	<span class="profile-pro">Chief Executive</span>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- /Active Events  -->

										<!-- Inactive Events -->
										<div class="tab-pane fade inactive-event" id="pat_Programss">
											<div class="row row-grid">
												<div class="col-md-6 col-lg-4">
													<div class="profile-widget">
														<div class="doc-img">
															<a href="event-details">
																<img class="img-fluid" alt="User Image" src="assets/img/events/event-02.jpg">
															</a>
														</div>
														<div class="pro-content">
															<h3 class="title">
																<span>CULTURAL EVENTS</span>
																<a href="event-details">Marketing Matters!</a>
															</h3>
															<p class="add-cont">8 Northumberland Ave, Westminster,</p>
															<div class="profile-info d-flex mb-0">
																<a href="speaker-profile" class="profile-img">
																	<img src="assets/img/profile/profile-02.jpg" alt="">
																</a>
																<a href="speaker-profile">
																	<span class="profile-name">ms. Caia Earle</span>
																	<span class="profile-pro">Chairmam</span>
																</a>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6 col-lg-4">
													<div class="profile-widget">
														<div class="doc-img">
															<a href="event-details">
																<img class="img-fluid" alt="User Image" src="assets/img/events/event-01.jpg">
															</a>
														</div>
														<div class="pro-content">
															<h3 class="title">
																<span>workshop</span>
																<a href="event-details">Marketing Matters!</a>
															</h3>
															<p class="add-cont">8 Northumberland Ave, Westminster,</p>
															<div class="profile-info d-flex mb-0">
																<a href="speaker-profile" class="profile-img">
																	<img src="assets/img/profile/profile-01.jpg" alt="">
																</a>
																<a href="speaker-profile">
																	<span class="profile-name">ms. Annie</span>
																	<span class="profile-pro">ceo - BP</span>
																</a>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6 col-lg-4">
													<div class="profile-widget">
														<div class="doc-img">
															<a href="event-details">
																<img class="img-fluid" alt="User Image" src="assets/img/events/event-09.jpg">
															</a>
														</div>
														<div class="pro-content">
															<h3 class="title">
																<span>CULTURAL EVENTS</span>
																<a href="event-details">Marketing Matters!</a>
															</h3>
															<p class="add-cont">Indiana, United States</p>
															<div class="profile-info d-flex mb-0">
																<a href="speaker-profile" class="profile-img">
																	<img src="assets/img/profile/profile-09.jpg" alt="">
																</a>
																<a href="speaker-profile">
																	<span class="profile-name">mr. Adnan Lam</span>
																	<span class="profile-pro">Chairmam</span>
																</a>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6 col-lg-4">
													<div class="profile-widget">
														<div class="doc-img">
															<a href="event-details">
																<img class="img-fluid" alt="User Image" src="assets/img/events/event-08.jpg">
															</a>
														</div>
														<div class="pro-content">
															<h3 class="title">
																<span>Sangeet EVENTS</span>
																<a href="event-details">Wedding Matters!</a>
															</h3>
															<p class="add-cont">Alabama, USA</p>
															<div class="profile-info d-flex mb-0">
																<a href="speaker-profile" class="profile-img">
																	<img src="assets/img/profile/profile-08.jpg" alt="">
																</a>
																<a href="speaker-profile">
																	<span class="profile-name">mr. Flann Berlin</span>
																	<span class="profile-pro">Chairmam</span>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- /Inactive Events -->

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
