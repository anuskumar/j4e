<nav class="navbar navbar-expand-lg navbar-dark reseller-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('reseller/event_listing') }}">
            <strong class="fs-3">Just 4</strong><span class="fs-3 fw-bold"> Entertainment</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="sellDropdown" role="button"
                        data-bs-toggle="dropdown">Sell</a>
                    <ul class="dropdown-menu" aria-labelledby="sellDropdown">
                        <li><a class="dropdown-item" href="{{ route('reseller.eventlisting') }}">Sell Tickets</a></li>
                        <li><a class="dropdown-item" href="{{ route('reseller.mysales') }}">My Sales</a></li>
                        <li><a class="dropdown-item" href="{{ route('reseller.mylistings') }}">My Listings</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                        data-bs-toggle="dropdown">Profile <i class="bi bi-person"></i></a>
                    <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="{{ route('reseller.profile') }}">My Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('reseller.profile') }}">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item logout-link" href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right me-2"></i>{{ __('Logout') }}
                            </a>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
