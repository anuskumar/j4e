<div class="dashboard-widget">
    <nav class="dashboard-menu">
        <ul>
            <li class="{{ request()->routeIs('customer.home') ? 'active' : '' }}">
                <a href="{{ route('customer.home') }}">
                    <i class="fas fa-columns"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            {{-- <li>
                <a href="favourites">
                    <i class="fas fa-bookmark"></i>
                    <span>Favourites</span>
                </a>
            </li> --}}
            {{-- <li>
                <a href="chat">
                    <i class="fas fa-comments"></i>
                    <span>Message</span>
                    <small class="unread-msg">23</small>
                </a>
            </li> --}}
            <li>
                <a href="{{ url('customer_profile_settings') }}">
                    <i class="fas fa-user-cog"></i>
                    <span>Profile Settings</span>
                </a>
            </li>
            {{-- <li>
                <a href="change-password">
                    <i class="fas fa-lock"></i>
                    <span>Change Password</span>
                </a>
            </li> --}}
            <li>

             <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                 @csrf
             </form>
                <a  href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span> {{ __('Logout') }}</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
