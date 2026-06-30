<!-- Footer -->
<footer class="footer site-footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget footer-about">
                        <a class="navbar-brand d-inline-block mb-3" href="{{ url('/') }}">
                            <img src="{{ $appLogoUrl }}" width="220" height="55" alt="Logo">
                        </a>
                        <div class="footer-about-content">
                            <p>Just 4 Entertainment is a secondary marketplace for live events. All tickets are 100% guaranteed and secure. Prices are set by sellers and may be above or below face value.</p>
                            <div class="social-icon">
                                <ul>
                                    <li><a href="#" class="fabutton" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#" target="_blank" class="twibutton" aria-label="Twitter"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#" target="_blank" class="insbutton" aria-label="Instagram"><i class="fab fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget footer-menu">
                        <h2 class="footer-title">Quick Links</h2>
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('new_eventlistfrontend') }}">Browse Events</a></li>
                            <li><a href="{{ url('sell_tickets') }}">Sell Tickets</a></li>
                            <li><a href="{{ route('reviews') }}">Customer Reviews</a></li>
                            <li><a href="{{ url('login') }}">Login</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget footer-contact">
                        <h2 class="footer-title">Get In Touch</h2>
                        <div class="footer-contact-info">
                            <p><i class="fas fa-shield-alt"></i> Secure ticket marketplace</p>
                            <p><i class="fas fa-ticket-alt"></i> Verified sellers &amp; buyers</p>
                            <p class="mb-0"><i class="fas fa-headset"></i> Support available for all orders</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="copyright">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <ul class="policy-menu text-left mb-md-0">
                            <li><a href="#">Terms and Conditions</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <div class="copyright-menu text-md-right">
                            <p class="mb-0">&copy; {{ date('Y') }} Just 4 Entertainment. All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.site-footer.footer,
.site-footer .footer-top,
.site-footer .footer-bottom {
    background: rgb(34, 30, 105) !important;
    background-image: linear-gradient(90deg, rgba(34, 30, 105, 1) 5%, rgba(54, 8, 94, 1) 65%, rgba(103, 29, 207, 1) 100%) !important;
    background-size: cover !important;
    background-position: center !important;
}

.site-footer .footer-top {
    padding: 50px 0;
}

.site-footer .footer-title {
    color: #fff;
    font-size: 17px;
    font-weight: 600;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.site-footer .footer-widget.footer-menu ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.site-footer .footer-widget .footer-about-content p {
    color: rgba(255, 255, 255, 0.85);
    font-size: 14px;
}

.site-footer .footer-menu ul li {
    margin-bottom: 10px;
}

.site-footer .footer-menu ul li a {
    color: rgba(255, 255, 255, 0.85);
    font-size: 14px;
    text-decoration: none;
    transition: color 0.2s ease;
}

.site-footer .footer-menu ul li a:hover {
    color: #fff;
}

.site-footer .footer-bottom .copyright {
    border-top: 1px solid rgba(255, 255, 255, 0.15);
    padding: 25px 0;
}

.site-footer .footer-bottom .policy-menu {
    list-style: none;
    margin: 0;
    padding: 0;
}

.site-footer .footer-bottom .policy-menu a,
.site-footer .footer-bottom .copyright-menu p {
    color: rgba(255, 255, 255, 0.85);
    font-size: 14px;
    text-decoration: none;
}

.site-footer .footer-bottom .policy-menu a:hover {
    color: #fff;
}

.site-footer .social-icon ul {
    list-style: none;
    margin: 16px 0 0;
    padding: 0;
    display: flex;
    gap: 10px;
}

.site-footer .footer-contact-info p {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
    color: rgba(255, 255, 255, 0.78);
}

.site-footer .footer-contact-info i {
    width: 18px;
    color: #c4b5fd;
}

.fabutton, .twibutton, .insbutton {
    background-image: linear-gradient(to bottom, #8a3ab9, #ff2d55);
    color: white;
    border: 1px solid white;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 768px) {
    .site-footer .footer-widget {
        margin-bottom: 28px;
        text-align: center;
    }

    .site-footer .footer-contact-info p,
    .site-footer .social-icon ul {
        justify-content: center;
    }

    .site-footer .copyright-menu,
    .site-footer .policy-menu {
        text-align: center !important;
    }
}
</style>
