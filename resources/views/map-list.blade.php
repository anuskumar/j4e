<?php $page="map-list";?>
@extends('layout.mainlayout')
@section('content')		
<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">

	            <div class="row">
					<div class="col-xl-7 col-lg-12 order-md-last order-sm-last order-last map-left">
				
						<div class="row align-items-center mb-4">
							<div class="col-md-6 col">
								<h4>2245 speakers found</h4>
							</div>

							<div class="col-md-6 col-auto">
								<div class="view-icons">
									<a href="map-grid" class="grid-view"><i class="fas fa-th-large"></i></a>
									<a href="map-list" class="list-view active"><i class="fas fa-bars"></i></a>
								</div>
								<div class="sort-by d-sm-block d-none">
									<span class="sortby-fliter">
										<select class="select">
											<option>Sort by</option>
											<option class="sorting">Rating</option>
											<option class="sorting">Popular</option>
											<option class="sorting">Latest</option>
											<option class="sorting">Free</option>
										</select>
									</span>
								</div>
							</div>
						</div>

						<!-- speaker Widget -->
						<div class="card">
							<div class="card-body">
								<div class="speaker-widget">
									<div class="doc-info-left">
										<div class="speaker-img">
											<a href="speaker-profile">
												<img src="assets/img/speakers/speaker-thumb-01.jpg" class="img-fluid" alt="User Image">
											</a>
										</div>
										<div class="doc-info-cont">
											<h4 class="doc-name"><a href="speaker-profile">Blaine Skipper</a></h4>
											<p class="doc-speciality">MBA, MS - 12+ Years Experience</p>
											<h5 class="doc-department"><img src="assets/img/specialities/specialities-05.png" class="img-fluid" alt="Speciality">DJ, Producer</h5>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(17)</span>
											</div>
											<div class="clinic-details">
												<p class="doc-location"><i class="fas fa-map-marker-alt"></i> Florida, USA</p>
												<ul class="clinic-gallery">
													<li>
														<a href="assets/img/features/feature-01.jpg" data-fancybox="gallery">
															<img src="assets/img/features/feature-01.jpg" alt="Feature">
														</a>
													</li>
													<li>
														<a href="assets/img/features/feature-02.jpg" data-fancybox="gallery">
															<img  src="assets/img/features/feature-02.jpg" alt="Feature">
														</a>
													</li>
													<li>
														<a href="assets/img/features/feature-03.jpg" data-fancybox="gallery">
															<img src="assets/img/features/feature-03.jpg" alt="Feature">
														</a>
													</li>
													<li>
														<a href="assets/img/features/feature-04.jpg" data-fancybox="gallery">
															<img src="assets/img/features/feature-04.jpg" alt="Feature">
														</a>
													</li>
												</ul>
											</div>
											<div class="clinic-services">
												<span>Event Halls</span>
												<span> Conference</span>
											</div>
										</div>
									</div>
									<div class="doc-info-right">
										<div class="clini-infos">
											<ul>
												<li><i class="far fa-thumbs-up"></i> 98%</li>
												<li><i class="far fa-comment"></i> 17 Feedback</li>
												<li><i class="fas fa-map-marker-alt"></i> Florida, USA</li>
												<li><i class="far fa-money-bill-alt"></i> $300 - $1000 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i> </li>
											</ul>
										</div>
										<div class="clinic-booking">
											<a class="view-pro-btn" href="speaker-profile">View Profile</a>
											<a class="apt-btn" href="booking">Book Appointment</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /speaker Widget -->

						<!-- speaker Widget -->
						<div class="card">
							<div class="card-body">
								<div class="speaker-widget">
									<div class="doc-info-left">
										<div class="speaker-img">
											<a href="speaker-profile">
												<img src="assets/img/speakers/speaker-thumb-02.jpg" class="img-fluid" alt="User Image">
											</a>
										</div>
										<div class="doc-info-cont">
											<h4 class="doc-name"><a href="speaker-profile">Wayte Barlow</a></h4>
											<p class="doc-speciality">MCA, BE - 10+ Years Experience</p>
											<h5 class="doc-department"><img src="assets/img/specialities/specialities-05.png" class="img-fluid" alt="Speciality">DJ, Producer</h5>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(35)</span>
											</div>
											<div class="clinic-details">
												<p class="doc-location"><i class="fas fa-map-marker-alt"></i> Newyork, USA</p>
												<ul class="clinic-gallery">
													<li>
														<a href="assets/img/features/feature-01.jpg" data-fancybox="gallery">
															<img src="assets/img/features/feature-01.jpg" alt="Feature">
														</a>
													</li>
													<li>
														<a href="assets/img/features/feature-02.jpg" data-fancybox="gallery">
															<img  src="assets/img/features/feature-02.jpg" alt="Feature">
														</a>
													</li>
													<li>
														<a href="assets/img/features/feature-03.jpg" data-fancybox="gallery">
															<img src="assets/img/features/feature-03.jpg" alt="Feature">
														</a>
													</li>
													<li>
														<a href="assets/img/features/feature-04.jpg" data-fancybox="gallery">
															<img src="assets/img/features/feature-04.jpg" alt="Feature">
														</a>
													</li>
												</ul>
											</div>
											<div class="clinic-services">
												<span>Event Halls</span>
												<span> Conference</span>
											</div>
										</div>
									</div>
									<div class="doc-info-right">
										<div class="clini-infos">
											<ul>
												<li><i class="far fa-thumbs-up"></i> 100%</li>
												<li><i class="far fa-comment"></i> 35 Feedback</li>
												<li><i class="fas fa-map-marker-alt"></i> Newyork, USA</li>
												<li><i class="far fa-money-bill-alt"></i> $50 - $300 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i></li>
											</ul>
										</div>
										<div class="clinic-booking">
											<a class="view-pro-btn" href="speaker-profile">View Profile</a>
											<a class="apt-btn" href="booking">Book Appointment</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /speaker Widget -->

						<!-- speaker Widget -->
						<div class="card">
							<div class="card-body">
								<div class="speaker-widget">
									<div class="doc-info-left">
										<div class="speaker-img">
											<a href="speaker-profile">
												<img src="assets/img/speakers/speaker-thumb-03.jpg" class="img-fluid" alt="User Image">
											</a>
										</div>
										<div class="doc-info-cont">
											<h4 class="doc-name"><a href="speaker-profile">Meerta Tyson</a></h4>
											<p class="doc-speciality">ME, MD - 9+ Years Experience</p>
											<p class="doc-department"><img src="assets/img/specialities/specialities-04.png" class="img-fluid" alt="Speciality">DJ Reader</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(27)</span>
											</div>
											<div class="clinic-details">
												<p class="doc-location"><i class="fas fa-map-marker-alt"></i> Georgia, USA</p>
												<ul class="clinic-gallery">
													<li>
														<a href="assets/img/features/feature-01.jpg" data-fancybox="gallery">
															<img src="assets/img/features/feature-01.jpg" alt="Feature">
														</a>
													</li>
													<li>
														<a href="assets/img/features/feature-02.jpg" data-fancybox="gallery">
															<img  src="assets/img/features/feature-02.jpg" alt="Feature">
														</a>
													</li>
													<li>
														<a href="assets/img/features/feature-03.jpg" data-fancybox="gallery">
															<img src="assets/img/features/feature-03.jpg" alt="Feature">
														</a>
													</li>
													<li>
														<a href="assets/img/features/feature-04.jpg" data-fancybox="gallery">
															<img src="assets/img/features/feature-04.jpg" alt="Feature">
														</a>
													</li>
												</ul>
											</div>
											<div class="clinic-services">
												<span>Event Halls</span>
												<span> Conference</span>
											</div>
										</div>
									</div>
									<div class="doc-info-right">
										<div class="clini-infos">
											<ul>
												<li><i class="far fa-thumbs-up"></i> 99%</li>
												<li><i class="far fa-comment"></i> 35 Feedback</li>
												<li><i class="fas fa-map-marker-alt"></i> Newyork, USA</li>
												<li><i class="far fa-money-bill-alt"></i> $100 - $400 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i></li>
											</ul>
										</div>
										<div class="clinic-booking">
											<a class="view-pro-btn" href="speaker-profile">View Profile</a>
											<a class="apt-btn" href="booking">Book Appointment</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /speaker Widget -->

						<!-- speaker Widget -->
						<div class="card">
							<div class="card-body">
								<div class="speaker-widget">
									<div class="doc-info-left">
										<div class="speaker-img">
											<a href="speaker-profile">
												<img src="assets/img/speakers/speaker-thumb-04.jpg" class="img-fluid" alt="User Image">
											</a>
										</div>
										<div class="doc-info-cont">
											<h4 class="doc-name"><a href="speaker-profile">Rhodes Glaser</a></h4>
											<p class="doc-speciality">BBA, MBA - 11+ Years Experience</p>
											<p class="doc-department"><img src="assets/img/specialities/specialities-01.png" class="img-fluid" alt="Speciality">DJ, Mix Engineer</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(4)</span>
											</div>
											<div class="clinic-details">
												<p class="doc-location"><i class="fas fa-map-marker-alt"></i> Louisiana, USA</p>
												<ul class="clinic-gallery">
													<li>
														<a href="assets/img/features/feature-01.jpg" data-fancybox="gallery">
															<img src="assets/img/features/feature-01.jpg" alt="Feature">
														</a>
													</li>
													<li>
														<a href="assets/img/features/feature-02.jpg" data-fancybox="gallery">
															<img  src="assets/img/features/feature-02.jpg" alt="Feature">
														</a>
													</li>
													<li>
														<a href="assets/img/features/feature-03.jpg" data-fancybox="gallery">
															<img src="assets/img/features/feature-03.jpg" alt="Feature">
														</a>
													</li>
													<li>
														<a href="assets/img/features/feature-04.jpg" data-fancybox="gallery">
															<img src="assets/img/features/feature-04.jpg" alt="Feature">
														</a>
													</li>
												</ul>
											</div>
											<div class="clinic-services">
												<span>Event Halls</span>
												<span> Conference</span>
											</div>
										</div>
									</div>
									<div class="doc-info-right">
										<div class="clini-infos">
											<ul>
												<li><i class="far fa-thumbs-up"></i> 97%</li>
												<li><i class="far fa-comment"></i> 4 Feedback</li>
												<li><i class="fas fa-map-marker-alt"></i> Newyork, USA</li>
												<li><i class="far fa-money-bill-alt"></i> $150 - $250 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i></li>
											</ul>
										</div>
										<div class="clinic-booking">
											<a class="view-pro-btn" href="speaker-profile">View Profile</a>
											<a class="apt-btn" href="booking">Book Appointment</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /speaker Widget -->

						<!-- speaker Widget -->
						<div class="card">
							<div class="card-body">
								<div class="speaker-widget">
									<div class="doc-info-left">
										<div class="speaker-img">
											<a href="speaker-profile">
												<img src="assets/img/speakers/speaker-thumb-06.jpg" class="img-fluid" alt="User Image">
											</a>
										</div>
										<div class="doc-info-cont">
											<h4 class="doc-name"><a href="speaker-profile">Mykah Derr</a></h4>
											<p class="doc-speciality">BA, MS - 8+ Years Experience</p>
											<p class="doc-department"><img src="assets/img/specialities/specialities-03.png" class="img-fluid" alt="Speciality">DJ, Artist</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(52)</span>
											</div>
											<div class="clinic-details">
												<p class="doc-location"><i class="fas fa-map-marker-alt"></i> Texas, USA</p>
												<ul class="clinic-gallery">
													<li>
														<a href="assets/img/features/feature-01.jpg" data-fancybox="gallery">
															<img src="assets/img/features/feature-01.jpg" alt="Feature">
														</a>
													</li>
													<li>
														<a href="assets/img/features/feature-02.jpg" data-fancybox="gallery">
															<img  src="assets/img/features/feature-02.jpg" alt="Feature">
														</a>
													</li>
													<li>
														<a href="assets/img/features/feature-03.jpg" data-fancybox="gallery">
															<img src="assets/img/features/feature-03.jpg" alt="Feature">
														</a>
													</li>
													<li>
														<a href="assets/img/features/feature-04.jpg" data-fancybox="gallery">
															<img src="assets/img/features/feature-04.jpg" alt="Feature">
														</a>
													</li>
												</ul>
											</div>
											<div class="clinic-services">
												<span>Event Halls</span>
												<span> Conference</span>
											</div>
										</div>
									</div>
									<div class="doc-info-right">
										<div class="clini-infos">
											<ul>
												<li><i class="far fa-thumbs-up"></i> 100%</li>
												<li><i class="far fa-comment"></i> 52 Feedback</li>
												<li><i class="fas fa-map-marker-alt"></i> Texas, USA</li>
												<li><i class="far fa-money-bill-alt"></i> $100 - $500 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i></li>
											</ul>
										</div>
										<div class="clinic-booking">
											<a class="view-pro-btn" href="speaker-profile">View Profile</a>
											<a class="apt-btn" href="booking">Book Appointment</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /speaker Widget -->
							
					<div class="load-more text-center">
						<a class="btn btn-primary btn-sm" href="javascript:void(0);">Load More</a>	
					</div>
	            </div>
	            <!-- /content-left-->
	            <div class="col-xl-5 col-lg-12 map-right">
	                <div id="map" class="map-listing"></div>
	                <!-- map-->
	            </div>
	            <!-- /map-right-->
	        </div>
	        <!-- /row-->
	   
				</div>

			</div>		
			<!-- /Page Content -->
			</div>
	   @endsection
	  