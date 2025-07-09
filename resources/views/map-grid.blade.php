<?php $page="map-grid";?>
@extends('layout.mainlayout')
@section('content')		
<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">

	            <div class="row">
					<div class="col-xl-6 col-lg-12 order-md-last order-sm-last order-last map-left">
				
						<div class="row align-items-center mb-4">
							<div class="col-md-6 col">
								<h4>2245 speakers found</h4>
							</div>

							<div class="col-md-6 col-auto">
								<div class="view-icons ">
									<a href="map-grid" class="grid-view active"><i class="fas fa-th-large"></i></a>
									<a href="map-list" class="list-view"><i class="fas fa-bars"></i></a>
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

							<div class="row">
								<div class="col-sm-6 col-md-4 col-xl-6">
									<div class="profile-widget">
										<div class="doc-img">
											<a href="speaker-profile">
												<img class="img-fluid" alt="User Image" src="assets/img/speakers/speaker-01.jpg">
											</a>
											<a href="javascript:void(0)" class="fav-btn">
												<i class="far fa-bookmark"></i>
											</a>
										</div>
										<div class="pro-content">
											<h3 class="title">
												<a href="speaker-profile">Blaine Skipper</a> 
												<i class="fas fa-check-circle verified"></i>
											</h3>
											<p class="speciality">MBA, MS - 12+ Years Experience</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<span class="d-inline-block average-rating">(17)</span>
											</div>
											<ul class="available-info">
												<li>
													<i class="fas fa-map-marker-alt"></i> Florida, USA
												</li>
												<li>
													<i class="far fa-clock"></i> Available on Fri, 22 Mar
												</li>
												<li>
													<i class="far fa-money-bill-alt"></i> $300 - $1000 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
												</li>
											</ul>
											<div class="row row-sm">
												<div class="col-6">
													<a href="speaker-profile" class="btn view-btn">View Profile</a>
												</div>
												<div class="col-6">
													<a href="booking" class="btn book-btn">Book Now</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6 col-md-4 col-xl-6">
									<div class="profile-widget">
										<div class="doc-img">
											<a href="speaker-profile">
												<img class="img-fluid" alt="User Image" src="assets/img/speakers/speaker-02.jpg">
											</a>
											<a href="javascript:void(0)" class="fav-btn">
												<i class="far fa-bookmark"></i>
											</a>
										</div>
										<div class="pro-content">
											<h3 class="title">
												<a href="speaker-profile">Wayte Barlow</a> 
												<i class="fas fa-check-circle verified"></i>
											</h3>
											<p class="speciality">MCA, BE - 10+ Years Experience</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(35)</span>
											</div>
											<ul class="available-info">
												<li>
													<i class="fas fa-map-marker-alt"></i> Newyork, USA
												</li>
												<li>
													<i class="far fa-clock"></i> Available on Fri, 22 Mar
												</li>
												<li>
													<i class="far fa-money-bill-alt"></i> $50 - $300 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
												</li>
											</ul>
											<div class="row row-sm">
												<div class="col-6">
													<a href="speaker-profile" class="btn view-btn">View Profile</a>
												</div>
												<div class="col-6">
													<a href="booking" class="btn book-btn">Book Now</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6 col-md-4 col-xl-6">
									<div class="profile-widget">
										<div class="doc-img">
											<a href="speaker-profile">
												<img class="img-fluid" alt="User Image" src="assets/img/speakers/speaker-03.jpg">
											</a>
											<a href="javascript:void(0)" class="fav-btn">
												<i class="far fa-bookmark"></i>
											</a>
										</div>
										<div class="pro-content">
											<h3 class="title">
												<a href="speaker-profile">Meerta Tyson</a> 
												<i class="fas fa-check-circle verified"></i>
											</h3>
											<p class="speciality">ME, MD - 9+ Years Experience</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(27)</span>
											</div>
											<ul class="available-info">
												<li>
													<i class="fas fa-map-marker-alt"></i> Georgia, USA
												</li>
												<li>
													<i class="far fa-clock"></i> Available on Fri, 22 Mar
												</li>
												<li>
													<i class="far fa-money-bill-alt"></i> $100 - $400 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
												</li>
											</ul>
											<div class="row row-sm">
												<div class="col-6">
													<a href="speaker-profile" class="btn view-btn">View Profile</a>
												</div>
												<div class="col-6">
													<a href="booking" class="btn book-btn">Book Now</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6 col-md-4 col-xl-6">
									<div class="profile-widget">
										<div class="doc-img">
											<a href="speaker-profile">
												<img class="img-fluid" alt="User Image" src="assets/img/speakers/speaker-04.jpg">
											</a>
											<a href="javascript:void(0)" class="fav-btn">
												<i class="far fa-bookmark"></i>
											</a>
										</div>
										<div class="pro-content">
											<h3 class="title">
												<a href="speaker-profile">Rhodes Glaser</a> 
												<i class="fas fa-check-circle verified"></i>
											</h3>
											<p class="speciality">BBA, MBA - 11+ Years Experience</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(4)</span>
											</div>
											<ul class="available-info">
												<li>
													<i class="fas fa-map-marker-alt"></i> Louisiana, USA
												</li>
												<li>
													<i class="far fa-clock"></i> Available on Fri, 22 Mar
												</li>
												<li>
													<i class="far fa-money-bill-alt"></i> $150 - $250 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
												</li>
											</ul>
											<div class="row row-sm">
												<div class="col-6">
													<a href="speaker-profile" class="btn view-btn">View Profile</a>
												</div>
												<div class="col-6">
													<a href="booking" class="btn book-btn">Book Now</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6 col-md-4 col-xl-6">
									<div class="profile-widget">
										<div class="doc-img">
											<a href="speaker-profile">
												<img class="img-fluid" alt="User Image" src="assets/img/speakers/speaker-05.jpg">
											</a>
											<a href="javascript:void(0)" class="fav-btn">
												<i class="far fa-bookmark"></i>
											</a>
										</div>
										<div class="pro-content">
											<h3 class="title">
												<a href="speaker-profile">Dallin Donaldson</a> 
												<i class="fas fa-check-circle verified"></i>
											</h3>
											<p class="speciality">MBA, MD - 7+ Years Experience</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(66)</span>
											</div>
											<ul class="available-info">
												<li>
													<i class="fas fa-map-marker-alt"></i> Michigan, USA
												</li>
												<li>
													<i class="far fa-clock"></i> Available on Fri, 22 Mar
												</li>
												<li>
													<i class="far fa-money-bill-alt"></i> $50 - $700 
													<i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
												</li>
											</ul>
											<div class="row row-sm">
												<div class="col-6">
													<a href="speaker-profile" class="btn view-btn">View Profile</a>
												</div>
												<div class="col-6">
													<a href="booking" class="btn book-btn">Book Now</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6 col-md-4 col-xl-6">
									<div class="profile-widget">
										<div class="doc-img">
											<a href="speaker-profile">
												<img class="img-fluid" alt="User Image" src="assets/img/speakers/speaker-06.jpg">
											</a>
											<a href="javascript:void(0)" class="fav-btn">
												<i class="far fa-bookmark"></i>
											</a>
										</div>
										<div class="pro-content">
											<h3 class="title">
												<a href="speaker-profile">Mykah Derr</a> 
												<i class="fas fa-check-circle verified"></i>
											</h3>
											<p class="speciality">BA, MS - 8+ Years Experience</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(52)</span>
											</div>
											<ul class="available-info">
												<li>
													<i class="fas fa-map-marker-alt"></i> Texas, USA
												</li>
												<li>
													<i class="far fa-clock"></i> Available on Fri, 22 Mar
												</li>
												<li>
													<i class="far fa-money-bill-alt"></i> $100 - $500 
													<i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
												</li>
											</ul>
											<div class="row row-sm">
												<div class="col-6">
													<a href="speaker-profile" class="btn view-btn">View Profile</a>
												</div>
												<div class="col-6">
													<a href="booking" class="btn book-btn">Book Now</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6 col-md-4 col-xl-6">
									<div class="profile-widget">
										<div class="doc-img">
											<a href="speaker-profile">
												<img class="img-fluid" alt="User Image" src="assets/img/speakers/speaker-07.jpg">
											</a>
											<a href="javascript:void(0)" class="fav-btn">
												<i class="far fa-bookmark"></i>
											</a>
										</div>
										<div class="pro-content">
											<h3 class="title">
												<a href="speaker-profile">Ozella Barbee</a> 
												<i class="fas fa-check-circle verified"></i>
											</h3>
											<p class="speciality">B.COM, MD - 11+ Years Experience</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(43)</span>
											</div>
											<ul class="available-info">
												<li>
													<i class="fas fa-map-marker-alt"></i> Kansas, USA
												</li>
												<li>
													<i class="far fa-clock"></i> Available on Fri, 22 Mar
												</li>
												<li>
													<i class="far fa-money-bill-alt"></i> $100 - $1000 
													<i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
												</li>
											</ul>
											<div class="row row-sm">
												<div class="col-6">
													<a href="speaker-profile" class="btn view-btn">View Profile</a>
												</div>
												<div class="col-6">
													<a href="booking" class="btn book-btn">Book Now</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6 col-md-4 col-xl-6">
									<div class="profile-widget">
										<div class="doc-img">
											<a href="speaker-profile">
												<img class="img-fluid" alt="User Image" src="assets/img/speakers/speaker-08.jpg">
											</a>
											<a href="javascript:void(0)" class="fav-btn">
												<i class="far fa-bookmark"></i>
											</a>
										</div>
										<div class="pro-content">
											<h3 class="title">
												<a href="speaker-profile">Mayeer Busch</a> 
												<i class="fas fa-check-circle verified"></i>
											</h3>
											<p class="speciality">BCA, ME - 4+ Years Experience</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(49)</span>
											</div>
											<ul class="available-info">
												<li>
													<i class="fas fa-map-marker-alt"></i> California, USA
												</li>
												<li>
													<i class="far fa-clock"></i> Available on Fri, 22 Mar
												</li>
												<li>
													<i class="far fa-money-bill-alt"></i> $100 - $400 
													<i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
												</li>
											</ul>
											<div class="row row-sm">
												<div class="col-6">
													<a href="speaker-profile" class="btn view-btn">View Profile</a>
												</div>
												<div class="col-6">
													<a href="booking" class="btn book-btn">Book Now</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6 col-md-4 col-xl-6">
									<div class="profile-widget">
										<div class="doc-img">
											<a href="speaker-profile">
												<img class="img-fluid" alt="User Image" src="assets/img/speakers/speaker-09.jpg">
											</a>
											<a href="javascript:void(0)" class="fav-btn">
												<i class="far fa-bookmark"></i>
											</a>
										</div>
										<div class="pro-content">
											<h3 class="title">
												<a href="speaker-profile">Farren Blalock</a> 
												<i class="fas fa-check-circle verified"></i>
											</h3>
											<p class="speciality">MBA, MS - 12+ Years Experience</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(112)</span>
											</div>
											<ul class="available-info">
												<li>
													<i class="fas fa-map-marker-alt"></i> Oklahoma, USA
												</li>
												<li>
													<i class="far fa-clock"></i> Available on Fri, 22 Mar
												</li>
												<li>
													<i class="far fa-money-bill-alt"></i> $500 - $2500 
													<i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
												</li>
											</ul>
											<div class="row row-sm">
												<div class="col-6">
													<a href="speaker-profile" class="btn view-btn">View Profile</a>
												</div>
												<div class="col-6">
													<a href="booking" class="btn book-btn">Book Now</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6 col-md-4 col-xl-6">
									<div class="profile-widget">
										<div class="doc-img">
											<a href="speaker-profile">
												<img class="img-fluid" alt="User Image" src="assets/img/speakers/speaker-10.jpg">
											</a>
											<a href="javascript:void(0)" class="fav-btn">
												<i class="far fa-bookmark"></i>
											</a>
										</div>
										<div class="pro-content">
											<h3 class="title">
												<a href="speaker-profile">Sissel Browne</a> 
												<i class="fas fa-check-circle verified"></i>
											</h3>
											<p class="speciality">MBA, MS - 12+ Years Experience</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(65)</span>
											</div>
											<ul class="available-info">
												<li>
													<i class="fas fa-map-marker-alt"></i> Montana, USA
												</li>
												<li>
													<i class="far fa-clock"></i> Available on Fri, 22 Mar
												</li>
												<li>
													<i class="far fa-money-bill-alt"></i> $75 - $250 
													<i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
												</li>
											</ul>
											<div class="row row-sm">
												<div class="col-6">
													<a href="speaker-profile" class="btn view-btn">View Profile</a>
												</div>
												<div class="col-6">
													<a href="booking" class="btn book-btn">Book Now</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6 col-md-4 col-xl-6">
									<div class="profile-widget">
										<div class="doc-img">
											<a href="speaker-profile">
												<img class="img-fluid" alt="User Image" src="assets/img/speakers/speaker-11.jpg">
											</a>
											<a href="javascript:void(0)" class="fav-btn">
												<i class="far fa-bookmark"></i>
											</a>
										</div>
										<div class="pro-content">
											<h3 class="title">
												<a href="speaker-profile">Dorothya Mcgill</a> 
												<i class="fas fa-check-circle verified"></i>
											</h3>
											<p class="speciality">MBA (HR), MD - 9+ Years Experience</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(5)</span>
											</div>
											<ul class="available-info">
												<li>
													<i class="fas fa-map-marker-alt"></i> Oklahoma, USA
												</li>
												<li>
													<i class="far fa-clock"></i> Available on Fri, 22 Mar
												</li>
												<li>
													<i class="far fa-money-bill-alt"></i> $275 - $450 
													<i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
												</li>
											</ul>
											<div class="row row-sm">
												<div class="col-6">
													<a href="speaker-profile" class="btn view-btn">View Profile</a>
												</div>
												<div class="col-6">
													<a href="booking" class="btn book-btn">Book Now</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6 col-md-4 col-xl-6">
									<div class="profile-widget">
										<div class="doc-img">
											<a href="speaker-profile">
												<img class="img-fluid" alt="User Image" src="assets/img/speakers/speaker-12.jpg">
											</a>
											<a href="javascript:void(0)" class="fav-btn">
												<i class="far fa-bookmark"></i>
											</a>
										</div>
										<div class="pro-content">
											<h3 class="title">
												<a href="speaker-profile">Yapheth Street</a> 
												<i class="fas fa-check-circle verified"></i>
											</h3>
											<p class="speciality">CA, MS - 13+ Years Experience</p>
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="d-inline-block average-rating">(5)</span>
											</div>
											<ul class="available-info">
												<li>
													<i class="fas fa-map-marker-alt"></i> Indiana, USA
												</li>
												<li>
													<i class="far fa-clock"></i> Available on Fri, 22 Mar
												</li>
												<li>
													<i class="far fa-money-bill-alt"></i> $150 - $350 
													<i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
												</li>
											</ul>
											<div class="row row-sm">
												<div class="col-6">
													<a href="speaker-profile" class="btn view-btn">View Profile</a>
												</div>
												<div class="col-6">
													<a href="booking" class="btn book-btn">Book Now</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								
							</div>
							
					<div class="load-more text-center">
						<a class="btn btn-primary btn-sm" href="javascript:void(0);">Load More</a>	
					</div>
	            </div>
	            <!-- /content-left-->
	            <div class="col-xl-6 col-lg-12 map-right">
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
	  