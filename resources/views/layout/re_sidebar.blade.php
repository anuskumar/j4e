<div class="profile-sidebar">
    <div class="widget-profile pro-widget-content">
        <div class="profile-info-widget">
            <a href="#" class="booking-doc-img">
                <img src="{{ asset('assets/img/speakers/speaker-thumb-02.jpg') }}" alt="User Image">
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
                    <a href="{{ url('speaker-dashboard') }}">
                        <i class="fas fa-columns"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="active">
                    <a href="{{ url('events') }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Events</span>
                    </a>
                </li>
                <li class="active">
                    <a href="{{ url('reseller/manage_event') }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Manage Events</span>
                    </a>
                </li>
                <li class="active">
                    <a href="{{ url('reseller/manage_venue') }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Venue</span>
                    </a>
                </li>
                <li class="active">
                    <a href="{{ url('reseller/ticket_events') }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Tickets</span>
                    </a>
                </li>
                <li class="active">
                    <a href="{{ url('reseller/manage_artist') }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Artist</span>
                    </a>
                </li>
                <li class="active">
                    <a href="{{ url('reseller/manage_artistfield') }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Manage Artist</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('my-customers') }}">
                        <i class="fas fa-user-injured"></i>
                        <span>My customers</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('schedule-timings') }}">
                        <i class="fas fa-hourglass-start"></i>
                        <span>Schedule Timings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('invoices') }}">
                        <i class="fas fa-file-invoice"></i>
                        <span>Invoices</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('reviews') }}">
                        <i class="fas fa-star"></i>
                        <span>Reviews</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('chat-speaker') }}">
                        <i class="fas fa-comments"></i>
                        <span>Message</span>
                        <small class="unread-msg">23</small>
                    </a>
                </li>
                <li>
                    <a href="{{ url('speaker-profile-settings') }}">
                        <i class="fas fa-user-cog"></i>
                        <span>Profile Settings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('social-media') }}">
                        <i class="fas fa-share-alt"></i>
                        <span>Social Media</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('speaker-change-password') }}">
                        <i class="fas fa-lock"></i>
                        <span>Change Password</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('index') }}">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
