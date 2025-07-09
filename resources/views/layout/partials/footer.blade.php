<!-- Footer -->
			<footer class="footer">

				<!-- Footer Top -->
				<div class="footer-top">
					<div class="container">
						<div class="row">
							<div class="col-lg-3 col-md-6">

								<!-- Footer Widget -->
                                @php
                                $settings = \App\Models\CompanySettings::first();
                                @endphp
								<div class="footer-widget footer-about">
									{{-- <h2 class="footer-title">About Us</h2> --}}
                                    <a class="navbar-brand mt-4" href="{{ url('/') }}">
                                        <img src="{{ Storage::disk('image')->url('uploads/images/' . $settings->company_logo) }}" class="" width="265px;" height="65px;" alt="Logo">
                                    </a>
									<div class="footer-about-content">
										<p>Just 4 Entertainment is a secondary market place for live events. All tickets are 100% guaranteed and secure. Prices are set by sellers and may be above or below face value.</p>
										<div class="social-icon">
											<ul>
												<li>
													<a href="#" class=" fabutton"target="_blank "><i class="fab fa-facebook-f"></i> </a>
												</li>
												<li>
													<a href="#" target="_blank" class="twibutton"><i class="fab fa-twitter"></i> </a>
												</li>
												<li>
													<a href="#" target="_blank" class="insbutton"><i class="fab fa-instagram"></i></a>
												</li>

											</ul>

										</div>
									</div>
								</div>
								<!-- /Footer Widget -->

							</div>

							<div class="col-lg-3 col-md-6">

								<!-- Footer Widget -->
								<div class="footer-widget footer-menu">
									<h2 class="footer-title">Information</h2>
									<ul>
										<li><a href="search">Search for Speakers</a></li>
										<li><a href="events">Events</a></li>
										<li><a href="customer-dashboard">Customer Dashboard</a></li>
										<li><a href="login">Login</a></li>
									</ul>
								</div>
								<!-- /Footer Widget -->

							</div>

							<div class="col-lg-3 col-md-6">

								<!-- Footer Widget -->
								<div class="footer-widget footer-menu">
									<h2 class="footer-title">Support</h2>
									<ul>
										<li><a href="speaker-dashboard">Speaker Dashboard</a></li>
										<li><a href="booking">Booking</a></li>
										<li><a href="chat">Chat</a></li>
										<li><a href="privacy-policy">Privacy & Policy</a></li>
									</ul>
								</div>
								<!-- /Footer Widget -->

							</div>

							<div class="col-lg-3 col-md-6">

								<!-- Footer Widget -->
								<div class="footer-widget footer-contact">
									<h2 class="footer-title">Contact Us</h2>
									<div class="footer-contact-info">
										<div class="footer-address">
											<span><i class="fas fa-map-marker-alt"></i></span>
											<p>251 Hickory Heights Drive,<br> Alaska, AK 99515 </p>
										</div>
										<p>
											<i class="fas fa-phone-alt"></i>
											+1 907 275 0477
										</p>
										<p class="mb-0">
											<i class="fas fa-envelope"></i>
											pathivu@example.com
										</p>
									</div>
								</div>
								<!-- /Footer Widget -->

							</div>

						</div>
					</div>
				</div>
				<!-- /Footer Top -->

				<!-- Footer Bottom -->
                <div class="footer-bottom">
					<div class="container">

						<!-- Copyright -->
						<div class="copyright">
							<div class="row">
								<div class="col-md-7 col-lg-6">
									<div class="copyright-text">
										<ul class="policy-menu text-left">
											<li><a href="term-condition">Terms and Conditions</a></li>
										</ul>
									</div>
								</div>
								<div class="col-md-5 col-lg-6">

									<!-- Copyright Menu -->
									<div class="copyright-menu">
										<ul class="policy-menu">
											<li><p class="mb-0">&copy; 2021 All Rights Reserved</p></li>
										</ul>
									</div>
									<!-- /Copyright Menu -->

								</div>
							</div>
						</div>
						<!-- /Copyright -->

					</div>
				</div>
				<!-- /Footer Bottom -->

			</footer>
			<!-- /Footer -->
            <style>
.fabutton{
    background-image: linear-gradient(to bottom, #8a3ab9, #ff2d55); /* Gradient colors */
    color: white; /* Text color */
    border:1px solid white;
    border-radius: 15px;
}
.twibutton{
    background-image: linear-gradient(to bottom, #8a3ab9, #ff2d55); /* Gradient colors */
    color: white; /* Text color */
    border:1px solid white;
    border-radius: 15px;
}
.insbutton{
    background-image: linear-gradient(to bottom, #8a3ab9, #ff2d55); /* Gradient colors */
    color: white; /* Text color */
    border:1px solid white;
    border-radius: 15px;
}

            </style>
