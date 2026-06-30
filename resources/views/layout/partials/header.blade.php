<style>
    .navbar-header,
    #mobile_btn,
    .menu-header,
    .menu-close {
        display: none !important;
    }

    .site-navbar {
        background: rgb(34, 30, 105);
        background: linear-gradient(90deg, rgba(34, 30, 105, 1) 5%, rgba(54, 8, 94, 1) 65%, rgba(103, 29, 207, 1) 100%);
        padding: 8px 0;
    }

    header.header {
        background: transparent;
    }

    .site-navbar > .container {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 16px;
    }

    @media (min-width: 992px) {
        .site-navbar.navbar-expand-lg > .container {
            flex-wrap: nowrap;
            gap: 20px;
        }

        .site-navbar.navbar-expand-lg .navbar-collapse {
            flex: 1 1 auto;
            min-width: 0;
            display: flex !important;
            align-items: center;
        }

        .site-navbar__search {
            flex: 1 1 auto;
            max-width: none;
            min-width: 0;
            width: 100%;
        }

        .site-navbar__search .input-group {
            width: 100%;
        }

        .site-navbar .nav-actions {
            flex: 0 0 auto;
            margin-left: auto;
            padding-right: 4px;
        }
    }

    .site-navbar .navbar-brand {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        margin-right: 12px;
        padding: 6px 0;
        z-index: 2;
    }

    .site-navbar .navbar-brand img {
        height: 52px;
        width: auto;
        max-width: 220px;
        object-fit: contain;
        object-position: left center;
        display: block;
    }

    .site-navbar .navbar-collapse {
        flex: 1 1 0;
        min-width: 0;
    }

    .site-navbar__search {
        flex: 1 1 auto;
        min-width: 180px;
        margin: 0;
        width: 100%;
    }

    .site-navbar__search .form-control {
        min-height: 36px;
        font-size: 13px;
        border-radius: 999px 0 0 999px;
        border-right: 0;
        padding: 0 12px;
    }

    .site-navbar__search .input-group .btn {
        border-radius: 0 999px 999px 0;
        min-height: 36px;
        padding: 0 12px;
    }

    .site-navbar .nav-actions {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
        flex-wrap: nowrap;
        flex: 0 0 auto;
        margin-left: auto;
    }

    .site-navbar .nav-actions.navbar-nav {
        flex-direction: row;
    }

    .site-navbar .nav-actions .nav-item {
        display: flex;
        align-items: center;
    }

    .site-navbar .nav-actions .btn-nav {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 34px;
        padding: 0 12px !important;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.2;
        border-radius: 999px;
        border: 1px solid #fff;
        white-space: nowrap;
        color: #fff !important;
        text-decoration: none;
        transition: opacity 0.2s ease, filter 0.2s ease;
    }

    .site-navbar .nav-actions .btn-nav:hover {
        color: #fff !important;
        opacity: 0.92;
        filter: brightness(1.06);
        text-decoration: none;
    }

    .navbar-toggler {
        border-color: rgba(255,255,255,0.5);
        margin-left: auto;
        flex-shrink: 0;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .navbar-dark .navbar-nav .nav-link {
        color: #fff;
    }

    .gradient-button {
        background-image: linear-gradient(to right, #001f3f, #117eea);
    }

    .gradient-button1 {
        background-image: linear-gradient(to right, #d900d2, #35042a);
    }

    .gradient-button2 {
        background-image: linear-gradient(to right, #671dcf, #221e69);
    }

    @media (max-width: 991px) {
        .site-navbar > .container {
            flex-wrap: wrap;
        }

        .site-navbar .navbar-brand {
            order: 1;
        }

        .navbar-toggler {
            order: 2;
        }

        .site-navbar .navbar-collapse {
            order: 3;
            flex: 1 1 100%;
            background: rgba(34, 30, 105, 0.95);
            padding: 14px;
            margin-top: 0;
            border-radius: 10px;
        }

        .site-navbar__search {
            width: 100%;
        }

        .site-navbar .nav-actions {
            order: 4;
            flex: 1 1 100%;
            flex-wrap: wrap;
            justify-content: flex-end;
            margin-left: 0;
            padding-right: 0;
        }

        .site-navbar .navbar-brand img {
            height: 44px;
            max-width: 170px;
        }
    }

    @media (min-width: 992px) and (max-width: 1199px) {
        .site-navbar .navbar-brand img {
            max-width: 180px;
            height: 46px;
        }

        .site-navbar .nav-actions .btn-nav {
            padding: 0 10px !important;
            font-size: 11px;
        }
    }
</style>

<!-- Loader -->
@if(Route::is(['map-grid','map-list']))
@endif

<div class="main-wrapper">
    @if(Route::is(['page']))
    <header class="header main-header">
    @endif
    @if(!Route::is(['page']))
    @endif

    <header class="header">
    <nav class="navbar navbar-expand-lg navbar-dark site-navbar">
        <div class="container align-items-center">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ $appLogoUrl }}" width="220" height="52" alt="Logo">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="site-navbar__search" action="{{ url('/') }}" method="GET">
                    <div class="input-group">
                        <input type="search" class="form-control"
                            placeholder="Search by Event, Artist or Location..."
                            name="search"
                            value="{{ request('search') ?? '' }}"
                            required />
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <ul class="navbar-nav nav-actions">
                @php
                if (Auth::user()) {
                    $validHoldStart = \Carbon\Carbon::now()->subMinutes(15);
                    $check_cart = \App\Models\TicketsGenerated::where('user_id', Auth::user()->id)
                        ->where('is_sold', 0)
                        ->where('under_purchase_hold', 1)
                        ->where('purchase_hold_time', '>=', $validHoldStart)
                        ->exists();
                } else {
                    $check_cart = null;
                }
                @endphp

                @if($check_cart)
                <li class="nav-item">
                    <a class="nav-link btn-nav gradient-button" href="{{ route('customer_ticket_cart') }}">Cart</a>
                </li>
                @endif
                @if(!Auth::user())
                <li class="nav-item">
                    <a class="nav-link btn-nav gradient-button" href="{{ url('login') }}">Login</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link btn-nav gradient-button1" href="{{ url('sell_tickets') }}">Sell Tickets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-nav gradient-button2" href="{{ route('reseller.requestevent') }}">Request Event</a>
                </li>
                @if(Auth::check())
                    @php
                        $user = Auth::user();
                        $profileImage = $user->profileImageUrl();
                        $profileSettingsUrl = $user->user_type === 'reseller'
                            ? route('reseller.profile')
                            : url('customer_profile_settings');
                    @endphp
                    <li class="nav-item dropdown">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        <a href="#" class="nav-link dropdown-toggle p-0" data-toggle="dropdown">
                            <img class="rounded-circle" src="{{ $profileImage }}" width="34" height="34" alt="{{ $user->name }}"
                                onerror="this.onerror=null;this.src='{{ \App\Models\User::defaultProfileImageUrl() }}';">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="px-3 py-2 border-bottom">
                                <h6 class="mb-0">{{ ucfirst($user->name) }}</h6>
                                <small class="text-muted">{{ ucfirst($user->user_type) }}</small>
                            </div>
                            <a class="dropdown-item" href="{{ url('home') }}">Dashboard</a>
                            <a class="dropdown-item" href="{{ $profileSettingsUrl }}">Profile Settings</a>
                            <a class="dropdown-item logout-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </div>
                    </li>
                @endif
            </ul>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.logout-link').forEach(function(link) {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        var form = document.getElementById('logout-form');
                        if (form) form.submit();
                    });
                });
            });
        </script>

    </nav>
    </header>

</div>
