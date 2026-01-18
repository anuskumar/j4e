@extends('layout.mainlayout')
@section('content')


<!-- Home Banner -->
<style>
.banner-logo{
    width: 50%;
    margin-bottom: 8%;
    margin-top: -12%;
}

.caption-banner{
    margin-bottom: 10%;
}

img {
  width: -webkit-fill-available;
}

@keyframes marquee {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}

/* Mobile responsive styles */
@media (max-width: 768px) {
    .main-menu-wrapper {
        padding-left: 0 !important;
        padding-right: 0 !important;
        padding-top: 10px !important;
        padding-bottom: 10px !important;
        text-align: center;
        display: flex !important;
        flex-direction: column;
        align-items: center;
        width: 100% !important;
        margin: 0 !important;
    }
    
    .main-nav {
        flex-direction: row !important;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        padding: 5px !important;
        width: 100% !important;
        display: flex !important;
        list-style: none;
    }
    
    .main-nav a {
        padding: 8px 12px !important;
        display: inline-block !important;
        text-align: center;
        font-size: 12px !important;
        width: auto !important;
        margin: 3px !important;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 5px;
        text-decoration: none;
    }
    
    .menu-header {
        text-align: center;
        width: 100%;
        display: none !important;
    }
    
    /* Hide menu close button on mobile */
    .menu-close {
        display: none !important;
    }
    
    /* Ensure parent container of menu is full width */
    div[style*="background-color: #310e80"] {
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    
    .carousel-caption {
        display: none !important;
    }
    
    .carousel-item img {
        height: 250px !important;
        object-fit: cover;
    }
    
    .service-box {
        margin-bottom: 20px;
    }
    
    .service-img {
        width: 100% !important;
        height: 200px !important;
    }
    
    .service-img img {
        height: 100% !important;
    }
    
    .section-header h2 {
        font-size: 24px;
    }
    
    .popular-events .container,
    .testimonial-section .container {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    .title {
        font-size: 16px !important;
    }
}

@media (max-width: 480px) {
    .carousel-item img {
        height: 180px !important;
    }
    
    .service-img {
        height: 180px !important;
    }
    
    .section-header h2 {
        font-size: 20px;
    }
    
    .title {
        font-size: 14px !important;
    }
}
</style>
    <div style="background-color: #7e0982; overflow: hidden; white-space: nowrap; padding: 5px;">
        <span style="display: inline-block; animation: marquee 20s linear infinite; color: white; font-size: 16px;">
            Just 4 Entertainment is a secondary market place for live events. All tickets are 100% guaranteed and secure!<br>
        </span>
    </div>
<div style="background-color: #310e80">
    {{-- <ul class="main-nav text-center"> <!-- Center-align text -->
        <li class="col-md-12">
            <h6 class="text-white">Just 4 Entertainment is a secondary market place for live events. All tickets are 100% guaranteed and secure. Prices are set by sellers and may be above or below face value.</h6>
        </li>
    </ul> --}}
    <div class="main-menu-wrapper" style="padding-left:350px;" >

        <div class="menu-header">
            <a href="index">
                <img src="{{ asset('assets/img/logoscroll.png') }}" class="img-fluid" alt="Logo">
            </a>
            <a id="menu_close" class="menu-close" href="javascript:void(0);">
                <i class="fas fa-times"></i>
            </a>
        </div>
        @php
        $eventtypes = \App\Models\EventType::where('is_active',1)->select('event_type_name','id')->get();
        @endphp

        <ul class="main-nav text-center"> <!-- Center-align text -->
            <a href="{{ url('/') }}">{{'All Tickets'}}</a>
            @foreach ($eventtypes as $eventtype)


                <a href="{{ url('/'.'?type='.$eventtype->id) }}">{{$eventtype->event_type_name.' Tickets'}}</a>



            @endforeach
        </ul>
    </div>
</div>


            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

                <ol class="carousel-indicators">
                    @foreach($slider as $index => $slide)
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
                    @endforeach
                </ol>

                <div class="carousel-inner">
                    @foreach($slider as $index => $slide)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img class="d-block w-100 banner_caro" src="{{ asset('storage/uploads/slide/'. $slide->slide_image) }}"  alt="Slide {{ $index + 1 }}">
                            <div class="carousel-caption d-none d-md-block text-left caption-banner" >
                                <h1 class="text-white">{{ $slide->meta_description }}</h1>
                                <button class="btn btn-primary" style="border-radius: 20px;">Book Now</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                    {{-- <div class="carousel-item active">
                        <div class="wrapper-content text-center"></div>
                        <img class="d-block w-100 banner_caro" src="https://media-cldnry.s-nbcnews.com/image/upload/t_nbcnews-fp-1200-630,f_auto,q_auto:best/rockcms/2023-07/230713-taylor-swift-jm-1600-daea0b.jpg"  style="width:100%" height="100px" alt="First slide">
                        <div class="carousel-caption d-none d-md-block text-left caption-banner" >
                            <h1 class="text-white"> Tylor Swift</h5>
                            <button class="btn btn-primary" style="border-radius: 20px;">Book Now</button>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100 banner_caro" src="https://media-cldnry.s-nbcnews.com/image/upload/rockcms/2023-07/230713-taylor-swift-jm-1600-daea0b.jpg" style="width:100%" height="100px" alt="Second slide">
                        <div class="carousel-caption d-none d-md-block text-left caption-banner" >
                            <h1 class="text-white"> Tylor Swift</h5>
                            <button class="btn btn-primary" style="border-radius: 20px;">Book Now</button>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100 banner_caro" src="https://content.fortune.com/wp-content/uploads/2023/07/GettyImages-1524297266-e1689352522521.jpg"  width="1000px" height="700px" alt="Third slide">
                        <div class="carousel-caption d-none d-md-block text-left caption-banner" >
                            <h1 class="text-white"> Tylor Swift</h5>
                            <button class="btn btn-primary" style="border-radius: 20px;">Book Now</button>
                        </div>
                    </div> --}}
                </div>
                <a class="" href="#carouselExampleIndicators" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="" href="#carouselExampleIndicators" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
			<!-- /Home Banner -->

<!-- Popular Events -->
            <section class="popular-events">
				<div class="container" style="margin-left: auto; margin-right: auto;">

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
                        <a href="{{ url('new_eventlistfrontend?tag='.$val->id) }}" style="text-decoration: none;">
                            <div class="service-box">
								<div class="service-img size" style="width: 100%; height: 250px; object-fit: contain; display: block;">
                                    	<img class="img-fluid" src="{{  asset('storage/uploads/event_tag_images/' . $val->tag_image) }}"
                                     style="width: 100%; height: 100%; object-fit: cover;" class="img-fluid">
								</div>


								{{-- <div class="overlay-content">
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
								</div> --}}
							</div>
                            <h3 class="title text-center font-weight-bold mt-3" style="color: #022F5C;">{{ strtoupper($val->tag_name)." TICKETS" }}</h3>
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

			<!-- Reviews-->
			<section class="testimonial-section reviews">
				<div class="container">
					<div class="section-wraper row d-flex align-items-center">
						<div class="col-md-8 col-lg-6 section-header mb-0">
							<p>#TOP REVIEWS</p>
							<h2>REVIEWS FROM OUR CUSTOMERS.</h2>
						</div>
						<div class="col-md-4 col-lg-6 text-right">
							<a href="reviews" class="view-all">View all</a>
						</div>
					</div>
<style>
/* Reviews section mobile responsive */
@media (max-width: 768px) {
    .section-wraper .col-md-8,
    .section-wraper .col-md-4 {
        text-align: center !important;
    }
    
    .section-wraper .text-right {
        text-align: center !important;
        margin-top: 10px;
    }
    
    .testimonial-section .section-header p {
        font-size: 14px;
    }
    
    .testimonial-section .section-header h2 {
        font-size: 22px;
    }
}
</style>

					<div id="testimonial-slider" class="owl-carousel owl-theme testimonial-slider ">
						<div class="single-testimonial">
							<div class="client-info">
								<div class="client-photo">
									<img src="{{ asset('assets/img/testimonial/avatar-01.jpg') }}" alt="">
								</div>
								<div class="client-details">
									<h4 class="name">Shonda Williams</h4>
									<div class="sub-title">Engineering</div>
									<div class="rating">
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star"></i>
										<span class="average-rating">3.2</span>
									</div>
								</div>
							</div>
							<div class="desc">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat orci enim, mattis nibh aliquam dui, nibh faucibus aenean.</p>
							</div>
						</div>

						<div class="single-testimonial">
							<div class="client-info">
								<div class="client-photo">
									<img src="{{ asset('assets/img/testimonial/avatar-02.jpg') }}" alt="">
								</div>
								<div class="client-details">
									<h4 class="name">Grant Mason</h4>
									<div class="sub-title">Cultural</div>
									<div class="rating">
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star"></i>
										<span class="average-rating">4.1</span>
									</div>
								</div>
							</div>
							<div class="desc">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat orci enim, mattis nibh aliquam dui, nibh faucibus aenean.</p>
							</div>
						</div>

						<div class="single-testimonial">
							<div class="client-info">
								<div class="client-photo">
									<img src="{{ asset('assets/img/testimonial/avatar-03.jpg') }}" alt="">
								</div>
								<div class="client-details">
									<h4 class="name">Marion Scott</h4>
									<div class="sub-title">Computer</div>
									<div class="rating">
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<span class="average-rating">5</span>
									</div>
								</div>
							</div>
							<div class="desc">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat orci enim, mattis nibh aliquam dui, nibh faucibus aenean.</p>
							</div>
						</div>

						<div class="single-testimonial">
							<div class="client-info">
								<div class="client-photo">
									<img src="{{ asset('assets/img/testimonial/avatar-04.jpg') }}" alt="">
								</div>
								<div class="client-details">
									<h4 class="name">Leonard Bender</h4>
									<div class="sub-title">Business</div>
									<div class="rating">
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<span class="average-rating">2</span>
									</div>
								</div>
							</div>
							<div class="desc">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat orci enim, mattis nibh aliquam dui, nibh faucibus aenean.</p>
							</div>
						</div>

						<div class="single-testimonial">
							<div class="client-info">
								<div class="client-photo">
									<img src="{{ asset('assets/img/testimonial/avatar-05.jpg') }}" alt="">
								</div>
								<div class="client-details">
									<h4 class="name">Cheryl Bostick</h4>
									<div class="sub-title">Cultural</div>
									<div class="rating">
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star"></i>
										<span class="average-rating">4</span>
									</div>
								</div>
							</div>
							<div class="desc">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat orci enim, mattis nibh aliquam dui, nibh faucibus aenean.</p>
							</div>
						</div>

						<div class="single-testimonial">
							<div class="client-info">
								<div class="client-photo">
									<img src="{{ asset('assets/img/testimonial/avatar-06.jpg') }}" alt="">
								</div>
								<div class="client-details">
									<h4 class="name">Martin Belvin</h4>
									<div class="sub-title">Conference</div>
									<div class="rating">
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star"></i>
										<span class="average-rating">4</span>
									</div>
								</div>
							</div>
							<div class="desc">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat orci enim, mattis nibh aliquam dui, nibh faucibus aenean.</p>
							</div>
						</div>

					</div>
				</div>
			</section>
			<!-- /Reviews-->

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
