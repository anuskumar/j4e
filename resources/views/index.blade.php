@extends('layout.mainlayout')
@section('content')


<!-- Home Banner -->
@include('partials.homepage_styles')

<section class="home-hero">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        @if($slider->count())
        <ol class="carousel-indicators">
            @foreach($slider as $index => $slide)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
            @endforeach
        </ol>
        @endif

        <div class="carousel-inner">
            @forelse($slider as $index => $slide)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img class="d-block w-100 banner_caro"
                        src="{{ asset('storage/uploads/slide/' . $slide->slide_image) }}"
                        alt="{{ $slide->meta_description ?? 'Slide ' . ($index + 1) }}"
                        onerror="this.src='{{ asset('assets/img/banner.jpg') }}'">
                    <div class="carousel-caption home-hero__overlay d-none d-md-flex {{ $slide->captionTextColorClass() }}">
                        <div class="home-hero__caption-text">
                            <h1>{{ $slide->meta_description }}</h1>
                        </div>
                        <div class="home-hero__caption-action">
                            <a href="{{ route('new_eventlistfrontend') }}" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="carousel-item active">
                    <img class="d-block w-100 banner_caro" src="{{ asset('assets/img/banner.jpg') }}" alt="Welcome">
                </div>
            @endforelse
        </div>

        @if($slider->count() > 1)
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        @endif
    </div>
</section>
<!-- /Home Banner -->

<!-- Popular Events -->
            <section class="popular-events">
				<div class="container">

					<!-- Section Header -->
					<div class="section-wraper row d-flex align-items-center">
						<div class="col-md-6 section-header mb-0">
							{{-- <p>#popular events hall</p> --}}
							<h2>find top events.</h2>
						</div>
						<div class="col-md-6 text-right">
							{{-- <a href="event-details" class="view-all">View all</a> --}}
						</div>
					</div>
					<!-- /Section Header -->

					<div class="row blog-grid-row">

                        @foreach ($event_tags as $val)

                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <a href="{{ url('new_eventlistfrontend?tag='.$val->id) }}" class="event-card">
                            <div class="service-box">
								<div class="service-img">
                                    	<img class="img-fluid"
                                        src="{{ $val->resolveHomepageImageUrl() }}"
                                        alt="{{ $val->tag_name ?? 'Event' }}"
                                        onerror="this.src='{{ asset('assets/img/default-event.jpg') }}'">
								</div>
							</div>
                            <h3 class="event-card__title">{{ strtoupper($val->tag_name) }} TICKETS</h3>
                        </a>
                        </div>

                        @endforeach


                        {{-- <div class="col-md-6 col-lg-3 col-sm-12">
                            <div class="service-box">
								<div class="service-img">
									<img src="{{ asset('assets/img/img-08.jpg') }}" alt="" class="img-fluid">
								</div>
								<div class="overlay-content">
									<div class="rating">
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star"></i>
										<span class="d-inline-block">3.5</span>
									</div>
									<ul class="available-info">
										<li>
											<a href="event-details"><h3>Mint Park Hall</h3></a>
										</li>
										<li>
											<p>New Jersey, United States</p>
										</li>
										<li>
											<h4>150 Seats</h4>
										</li>
									</ul>
									<div class="row row-sm">
										<div class="col-6">
											<a href="booking" class="btn bok-btn" tabindex="0">Book Now</a>
										</div>
										<div class="col-6 text-right">
											<a href="javascript:void(0);" class="rate cursor-auto" tabindex="0">$ 200.00/HR</a>
										</div>
									</div>
								</div>
							</div>
						</div> --}}
					</div>
				</div>
			</section>


			<!-- /Popular Events -->

			<!-- News-->
			{{-- <section class="news-events">
				<div class="container">
					<div class="section-wraper row d-flex align-items-center">
						<div class="col-md-6 section-header mb-0">
							<p>#FEATURED EVENTS</p>
							<h2>Upcoming new events.</h2>
						</div>
						<div class="col-md-6 text-right">
							<a href="events" class="view-all">View all</a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div id="event-slider" class="owl-carousel owl-theme testimonial-slider event-slider slider">

								<!-- News Widget -->
								<div class="profile-widget">
									<div class="doc-img">
										<a href="event-details">
											<img class="img-fluid" alt="User Image" src="{{ asset('assets/img/events/event-01.jpg') }}">
										</a>
									</div>
									<div class="pro-content">
										<div class="date-sec">
											<h3>MAR(image size 384*320)
												<span>2021</span>
											</h3>
										</div>
										<h3 class="title">
											<span>workshop</span>
											<a href="event-details">Marketing Analysis!</a>
										</h3>
										<p class="add-cont">308 Stoney Road, Florida</p>
										<div class="profile-info d-flex">
											<a href="speaker-profile" class="profile-img">
												<img src="{{ asset('assets/img/profile/profile-01.jpg') }}" alt="">
											</a>
											<a href="speaker-profile">
												<span class="profile-name">ms. Annie</span>
												<span class="profile-pro">ceo  -  turbofloid</span>
											</a>
										</div>
										<div class="row row-sm seat-details">
											<div class="col-6">
												<div class="d-flex align-items-center">
													<a href="javascript:void(0);"><img src="{{ asset('assets/img/icon-04.png') }}" alt=""></a>
													<a href="#">
														<span class="available-info">Available Seats</span>
														<span class="price-info">210/265</span>
													</a>
												</div>
											</div>
											<div class="col-6">
												<div class="d-flex align-items-center">
													<a href="javascript:void(0);"><img src="{{ asset('assets/img/icon-05.png') }}" alt=""></a>
													<a href="javascript:void(0);">
														<span class="available-info">Timings</span>
														<span class="price-info">12:30 - 02:00 PM</span>
													</a>
												</div>
											</div>
										</div>
										<div class="row row-sm align-items-center d-flex">
											<div class="col-6">
												<a href="booking" class="now-btn">Book now <i class="fas fa-long-arrow-alt-right"></i></a>
											</div>
											<div class="col-6 text-right">
												<a href="javascript:void(0);" class="amt-txt">$250.00</a>
											</div>
										</div>
									</div>
								</div>
								<!-- /News Widget -->

								<!-- News Widget -->
								<div class="profile-widget">
									<div class="doc-img">
										<a href="event-details">
											<img class="img-fluid" alt="User Image" src="{{ asset('assets/img/events/event-02.jpg') }}">
										</a>
									</div>
									<div class="pro-content">
										<div class="date-sec">
											<h3>FEB
												<span>2021</span>
											</h3>
										</div>
										<h3 class="title">
											<span>CULTURAL EVENTS</span>
											<a href="event-details">Training Gadgets</a>
										</h3>
										<p class="add-cont">1265 Twin Drive, Michigan</p>
										<div class="profile-info d-flex">
											<a href="speaker-profile" class="profile-img">
												<img src="{{ asset('assets/img/profile/profile-02.jpg') }}" alt="">
											</a>
											<a href="speaker-profile">
												<span class="profile-name">ms. Caia Earle</span>
												<span class="profile-pro">Chairmam</span>
											</a>
										</div>
										<div class="row row-sm seat-details">
											<div class="col-6">
												<div class="d-flex align-items-center">
													<a href="javascript:void(0);"><img src="{{ asset('assets/img/icon-04.png') }}" alt=""></a>
													<a href="#">
														<span class="available-info">Available Seats</span>
														<span class="price-info">210/265</span>
													</a>
												</div>
											</div>
											<div class="col-6">
												<div class="d-flex align-items-center">
													<a href="javascript:void(0);"><img src="{{ asset('assets/img/icon-05.png') }}" alt=""></a>
													<a href="javascript:void(0);">
														<span class="available-info">Timings</span>
														<span class="price-info">12:30 - 02:00 PM</span>
													</a>
												</div>
											</div>
										</div>
										<div class="row row-sm align-items-center d-flex">
											<div class="col-6">
												<a href="booking" class="now-btn">Book now <i class="fas fa-long-arrow-alt-right"></i></a>
											</div>
											<div class="col-6 text-right">
												<a href="javascript:void(0);" class="amt-txt">$300.00</a>
											</div>
										</div>
									</div>
								</div>
								<!-- /News Widget -->

								<!-- News Widget -->
								<div class="profile-widget">
									<div class="doc-img">
										<a href="event-details">
											<img class="img-fluid" alt="User Image" src="{{ asset('assets/img/events/event-03.jpg') }}">
										</a>
									</div>
									<div class="pro-content">
										<div class="date-sec">
											<h3>FEB
												<span>2021</span>
											</h3>
										</div>
										<h3 class="title">
											<span>TECH, Digital</span>
											<a href="event-details">Digital World</a>
										</h3>
										<p class="add-cont">4960 Pot Road, New Jersey</p>
										<div class="profile-info d-flex">
											<a href="speaker-profile" class="profile-img">
												<img src="{{ asset('assets/img/profile/profile-03.jpg') }}" alt="">
											</a>
											<a href="speaker-profile">
												<span class="profile-name">ms. Tilli Devlin</span>
												<span class="profile-pro">Chief Executive</span>
											</a>
										</div>
										<div class="row row-sm seat-details">
											<div class="col-6">
												<div class="d-flex align-items-center">
													<a href="javascript:void(0);"><img src="{{ asset('assets/img/icon-04.png') }}" alt=""></a>
													<a href="javascript:void(0);">
														<span class="available-info">Available Seats</span>
														<span class="price-info">210/265</span>
													</a>
												</div>
											</div>
											<div class="col-6">
												<div class="d-flex align-items-center">
													<a href="javascript:void(0);"><img src="{{ asset('assets/img/icon-05.png') }}" alt=""></a>
													<a href="javascript:void(0);">
														<span class="available-info">Timings</span>
														<span class="price-info">12:30 - 02:00 PM</span>
													</a>
												</div>
											</div>
										</div>
										<div class="row row-sm align-items-center d-flex">
											<div class="col-6">
												<a href="booking" class="now-btn">Book now <i class="fas fa-long-arrow-alt-right"></i></a>
											</div>
											<div class="col-6 text-right">
												<a href="javascript:void(0);" class="amt-txt">$450.00</a>
											</div>
										</div>
									</div>
								</div>
								<!-- /News Widget -->

								<!-- News Widget -->
								<div class="profile-widget">
									<div class="doc-img">
										<a href="event-details">
											<img class="img-fluid" alt="User Image" src="{{ asset('assets/img/events/event-04.jpg') }}">
										</a>
									</div>
									<div class="pro-content">
										<div class="date-sec">
											<h3>JAN
												<span>2021</span>
											</h3>
										</div>
										<h3 class="title">
											<span>DIGITAL  EVENTS</span>
											<a href="event-details">Marketing Matters!</a>
										</h3>
										<p class="add-cont">2101 Raver Drive, Tennessee</p>
										<div class="profile-info d-flex">
											<a href="speaker-profile" class="profile-img">
												<img src="{{ asset('assets/img/profile/profile-04.jpg') }}" alt="">
											</a>
											<a href="speaker-profile">
												<span class="profile-name">mr. Adar Li</span>
												<span class="profile-pro">Managing Director</span>
											</a>
										</div>
										<div class="row row-sm seat-details">
											<div class="col-6">
												<div class="d-flex align-items-center">
													<a href="javascript:void(0);"><img src="{{ asset('assets/img/icon-04.png') }}" alt=""></a>
													<a href="javascript:void(0);">
														<span class="available-info">Available Seats</span>
														<span class="price-info">210/265</span>
													</a>
												</div>
											</div>
											<div class="col-6">
												<div class="d-flex align-items-center">
													<a href="javascript:void(0);"><img src="{{ asset('assets/img/icon-05.png') }}" alt=""></a>
													<a href="javascript:void(0);">
														<span class="available-info">Timings</span>
														<span class="price-info">12:30 - 02:00 PM</span>
													</a>
												</div>
											</div>
										</div>
										<div class="row row-sm align-items-center d-flex">
											<div class="col-6">
												<a href="booking" class="now-btn">Book now <i class="fas fa-long-arrow-alt-right"></i></a>
											</div>
											<div class="col-6 text-right">
												<a href="javascript:void(0);" class="amt-txt">$270.00</a>
											</div>
										</div>
									</div>
								</div>
								<!-- /News Widget -->

								<!-- News Widget -->
								<div class="profile-widget">
									<div class="doc-img">
										<a href="event-details">
											<img class="img-fluid" alt="User Image" src="{{ asset('assets/img/events/event-05.jpg') }}">
										</a>
									</div>
									<div class="pro-content">
										<div class="date-sec">
											<h3>DEC
												<span>2020</span>
											</h3>
										</div>
										<h3 class="title">
											<span>workshop</span>
											<a href="event-details">Heaven Events</a>
										</h3>
										<p class="add-cont">4482 Alpaca Way, Alaska</p>
										<div class="profile-info d-flex">
											<a href="speaker-profile" class="profile-img">
												<img src="{{ asset('assets/img/profile/profile-05.jpg') }}" alt="">
											</a>
											<a href="speaker-profile">
												<span class="profile-name">mr. Fuad Lyles</span>
												<span class="profile-pro">Former ceo  -  BP</span>
											</a>
										</div>
										<div class="row row-sm seat-details">
											<div class="col-6">
												<div class="d-flex align-items-center">
													<a href="javascript:void(0);"><img src="{{ asset('assets/img/icon-04.png') }}" alt=""></a>
													<a href="javascript:void(0);">
														<span class="available-info">Available Seats</span>
														<span class="price-info">210/265</span>
													</a>
												</div>
											</div>
											<div class="col-6">
												<div class="d-flex align-items-center">
													<a href="javascript:void(0);"><img src="{{ asset('assets/img/icon-05.png') }}" alt=""></a>
													<a href="javascript:void(0);">
														<span class="available-info">Timings</span>
														<span class="price-info">12:30 - 02:00 PM</span>
													</a>
												</div>
											</div>
										</div>
										<div class="row row-sm align-items-center d-flex">
											<div class="col-6">
												<a href="booking" class="now-btn">Book now <i class="fas fa-long-arrow-alt-right"></i></a>
											</div>
											<div class="col-6 text-right">
												<a href="javascript:void(0);" class="amt-txt">$100.00</a>
											</div>
										</div>
									</div>
								</div>
								<!-- /News Widget -->

								<!-- News Widget -->
								<div class="profile-widget">
									<div class="doc-img">
										<a href="event-details">
											<img class="img-fluid" alt="User Image" src="{{ asset('assets/img/events/event-06.jpg') }}">
										</a>
									</div>
									<div class="pro-content">
										<div class="date-sec">
											<h3>FEB
												<span>2021</span>
											</h3>
										</div>
										<h3 class="title">
											<span>Seminar</span>
											<a href="event-details">Marketing Matters!</a>
										</h3>
										<p class="add-cont">3849 Smith Road, Georgia</p>
										<div class="profile-info d-flex">
											<a href="speaker-profile" class="profile-img">
												<img src="{{ asset('assets/img/profile/profile-06.jpg') }}" alt="">
											</a>
											<a href="speaker-profile">
												<span class="profile-name">ms. Ansleigh</span>
												<span class="profile-pro">Marketing</span>
											</a>
										</div>
										<div class="row row-sm seat-details">
											<div class="col-6">
												<div class="d-flex align-items-center">
													<a href="javascript:void(0);"><img src="{{ asset('assets/img/icon-04.png') }}" alt=""></a>
													<a href="javascript:void(0);">
														<span class="available-info">Available Seats</span>
														<span class="price-info">210/265</span>
													</a>
												</div>
											</div>
											<div class="col-6">
												<div class="d-flex align-items-center">
													<a href="javascript:void(0);"><img src="{{ asset('assets/img/icon-05.png') }}" alt=""></a>
													<a href="javascript:void(0);">
														<span class="available-info">Timings</span>
														<span class="price-info">12:30 - 02:00 PM</span>
													</a>
												</div>
											</div>
										</div>
										<div class="row row-sm align-items-center d-flex">
											<div class="col-6">
												<a href="booking" class="now-btn">Book now <i class="fas fa-long-arrow-alt-right"></i></a>
											</div>
											<div class="col-6 text-right">
												<a href="javascript:void(0);" class="amt-txt">$450.00</a>
											</div>
										</div>
									</div>
								</div>
								<!-- /News Widget -->

							</div>
						</div>
					</div>

				</div>
			</section> --}}
			<!-- /News-->

			<!-- Speakers-->
			{{-- <section class="speakers speaker-section">
				<div class="container">
					<div class="section-wraper row d-flex align-items-center">
						<div class="col-md-6 section-header mb-0">
							<p>#POPULAR SPEAKERS</p>
							<h2>Meet our first speakers.</h2>
						</div>
						<div class="col-md-6 text-right">
							<a href="map-grid" class="view-all">View all</a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div id="speaker-slider" class="owl-carousel owl-theme testimonial-slider event-slider slider">

								<!-- Speakers Widget -->
								<div class="single-team">
									<div class="team-img">
										<a href="speaker-profile">
											<img class="img-fluid" alt="User Image" src="{{ asset('assets/img/speakers/speak01.jpg') }}">
										</a>
									</div>
									<div class="team-content">
										<h3 class="title">
											<a href="speaker-profile">Ava Charlotte</a>
										</h3>
										<p class="sub-title">Cultural Head</p>
										<div class="row row-sm align-items-center d-flex">
											<div class="col-6">
												<a href="booking" class="now-btn">Book now <i class="fas fa-long-arrow-alt-right"></i></a>
											</div>
											<div class="col-6 text-right">
												<a href="javascript:void(0);" class="amt-txt">$50 / Hr</a>
											</div>
										</div>
									</div>
								</div>
								<!-- /Speakers Widget -->

								<!-- Speakers Widget -->
								<div class="single-team">
									<div class="team-img">
										<a href="speaker-profile">
											<img class="img-fluid" alt="User Image" src="{{ asset('assets/img/speakers/speak02.jpg') }}">
										</a>
									</div>
									<div class="team-content">
										<h3 class="title">
											<a href="speaker-profile">Siri Sanders</a>
										</h3>
										<p class="sub-title">Event Head</p>
										<div class="row row-sm align-items-center d-flex">
											<div class="col-6">
												<a href="booking" class="now-btn">Book now <i class="fas fa-long-arrow-alt-right"></i></a>
											</div>
											<div class="col-6 text-right">
												<a href="javascript:void(0);" class="amt-txt">$70 / Hr</a>
											</div>
										</div>
									</div>
								</div>
								<!-- /Speakers Widget -->

								<!-- Speakers Widget -->
								<div class="single-team">
									<div class="team-img">
										<a href="speaker-profile">
											<img class="img-fluid" alt="User Image" src="{{ asset('assets/img/speakers/speak03.jpg') }}">
										</a>
									</div>
									<div class="team-content">
										<h3 class="title">
											<a href="speaker-profile">Deni Yates</a>
										</h3>
										<p class="sub-title">Managing Director</p>
										<div class="row row-sm align-items-center d-flex">
											<div class="col-6">
												<a href="booking" class="now-btn">Book now <i class="fas fa-long-arrow-alt-right"></i></a>
											</div>
											<div class="col-6 text-right">
												<a href="javascript:void(0);" class="amt-txt">$50 / Hr</a>
											</div>
										</div>
									</div>
								</div>
								<!-- /Speakers Widget -->

								<!-- Speakers Widget -->
								<div class="single-team">
									<div class="team-img">
										<a href="speaker-profile">
											<img class="img-fluid" alt="User Image" src="{{ asset('assets/img/speakers/speak04.jpg') }}">
										</a>
									</div>
									<div class="team-content">
										<h3 class="title">
											<a href="speaker-profile">Brynn Fish</a>
										</h3>
										<p class="sub-title">Former CEO</p>
										<div class="row row-sm align-items-center d-flex">
											<div class="col-6">
												<a href="booking" class="now-btn">Book now <i class="fas fa-long-arrow-alt-right"></i></a>
											</div>
											<div class="col-6 text-right">
												<a href="javascript:void(0);" class="amt-txt">$50 / Hr</a>
											</div>
										</div>
									</div>
								</div>
								<!-- /Speakers Widget -->

								<!-- Speakers Widget -->
								<div class="single-team">
									<div class="team-img">
										<a href="speaker-profile">
											<img class="img-fluid" alt="User Image" src="{{ asset('assets/img/speakers/speak05.jpg') }}">
										</a>
									</div>
									<div class="team-content">
										<h3 class="title">
											<a href="speaker-profile">Salvio Pino</a>
										</h3>
										<p class="sub-title">Chairman Unilever</p>
										<div class="row row-sm align-items-center d-flex">
											<div class="col-6">
												<a href="booking" class="now-btn">Book now <i class="fas fa-long-arrow-alt-right"></i></a>
											</div>
											<div class="col-6 text-right">
												<a href="javascript:void(0);" class="amt-txt">$50 / Hr</a>
											</div>
										</div>
									</div>
								</div>
								<!-- /Speakers Widget -->

								<!-- Speakers Widget -->
								<div class="single-team">
									<div class="team-img">
										<a href="speaker-profile">
											<img class="img-fluid" alt="User Image" src="{{ asset('assets/img/speakers/speak06.jpg') }}">
										</a>
									</div>
									<div class="team-content">
										<h3 class="title">
											<a href="speaker-profile">Deni Yates</a>
										</h3>
										<p class="sub-title">Co-Founder</p>
										<div class="row row-sm align-items-center d-flex">
											<div class="col-6">
												<a href="booking" class="now-btn">Book now <i class="fas fa-long-arrow-alt-right"></i></a>
											</div>
											<div class="col-6 text-right">
												<a href="javascript:void(0);" class="amt-txt">$50 / Hr</a>
											</div>
										</div>
									</div>
								</div>
								<!-- /Speakers Widget -->

							</div>
						</div>
					</div>
				</div>
			</section> --}}
			<!-- /Speakers-->

			@include('partials.homepage_reviews')

			<!-- Blog Section -->
		   	{{-- <section class="blog-wrapper">
				<div class="container">

					<!-- Section Header -->
					<div class="section-wraper row d-flex align-items-center">
						<div class="col-md-6 section-header mb-0">
							<p>#OUR NEWS</p>
							<h2>Our LATEST NEWS</h2>
						</div>
						<div class="col-md-6 text-right">
							<a href="blog-list" class="view-all">View all</a>
						</div>
					</div>
					<!-- /Section Header -->

					<div class="row blog-grid-row">
						<div class="col-md-6 col-lg-4 col-sm-12">

							<!-- Blog Post -->
							<div class="content-wrapper">
								<div class="blog-image">
									<a href="blog-details"><img class="img-fluid" src="{{ asset('assets/img/blog/blog-01.jpg') }}" alt="Post Image"></a>
								</div>
								<div class="blog-content">
									<a href="javascript:void(0);" class="post-date"> <span> Posted on 25-01-2021 </span></a>
									<h3 class="blog-title"><a href="blog-details">Tips to Succeed in an Online Course</a></h3>
									<p class="mb-0">Lorem ipsum dolor sit amet, consectetur em adipiscing elit, sed do eiusmod tempor.</p>
								</div>
								<div class="blog-footer">
									<a href="blog-details">View More <i class="fas fa-caret-right"></i></a>
								</div>
							</div>
							<!-- /Blog Post -->

						</div>
						<div class="col-md-6 col-lg-4 col-sm-12">

							<!-- Blog Post -->
							<div class="content-wrapper">
								<div class="blog-image">
									<a href="blog-details"><img class="img-fluid" src="{{ asset('assets/img/blog/blog-02.jpg') }}" alt="Post Image"></a>
								</div>
								<div class="blog-content">
									<a href="javascript:void(0);" class="post-date"> <span> Posted on 25-01-2021 </span></a>
									<h3 class="blog-title"><a href="blog-details">Tips to Succeed in an Online Course</a></h3>
									<p class="mb-0">Lorem ipsum dolor sit amet, consectetur em adipiscing elit, sed do eiusmod tempor.</p>
								</div>
								<div class="blog-footer">
									<a href="blog-details">View More <i class="fas fa-caret-right"></i></a>
								</div>
							</div>
							<!-- /Blog Post -->

						</div>
						<div class="col-md-6 col-lg-4 col-sm-12">

							<!-- Blog Post -->
							<div class="content-wrapper">
								<div class="blog-image">
									<a href="blog-details"><img class="img-fluid" src="{{ asset('assets/img/blog/blog-03.jpg') }}" alt="Post Image"></a>
								</div>
								<div class="blog-content">
									<a href="javascript:void(0);" class="post-date"> <span> Posted on 25-01-2021 </span></a>
									<h3 class="blog-title"><a href="blog-details">Tips to Succeed in an Online Course</a></h3>
									<p class="mb-0">Lorem ipsum dolor sit amet, consectetur em adipiscing elit, sed do eiusmod tempor.</p>
								</div>
								<div class="blog-footer">
									<a href="blog-details">View More <i class="fas fa-caret-right"></i></a>
								</div>
							</div>
							<!-- /Blog Post -->

						</div>
					</div>
				</div>
			</section> --}}
			<!-- /Blog Section -->
			</div>
	   @endsection
