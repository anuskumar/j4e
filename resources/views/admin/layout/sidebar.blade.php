@php
    $system = \App\Models\CompanySettings::first();
@endphp
<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
<div class="sticky">
    <aside class="app-sidebar sidebar-scroll">
        <div class="main-sidebar-header active">
            <a class="desktop-logo logo-light active" href="{{ route('admin.home') }}">
                <img src="{{ $appLogoUrl }}" class="main-logo" alt="logo">
            </a>
            <a class="desktop-logo logo-dark active" href="{{ route('admin.home') }}">
                <img src="{{ $appLogoUrl }}" class="main-logo" alt="logo">
            </a>
            <a class="logo-icon mobile-logo icon-light active" href="{{ route('admin.home') }}">
                <img src="{{ $appLogoUrl }}" alt="logo">
            </a>
            <a class="logo-icon mobile-logo icon-dark active" href="{{ route('admin.home') }}">
                <img src="{{ $appLogoUrl }}" alt="logo">
            </a>
        </div>
        <div class="main-sidemenu">
            <div class="main-sidebar-loggedin">
                <div class="app-sidebar__user">
                    <div class="dropdown user-pro-body text-center">
                        <div class="user-pic">
                            <img src="{{ asset('admin_assets/img/faces/6.jpg') }}" alt="user-img" class="rounded-circle mCS_img_loaded">
                        </div>
                        <div class="user-info">
                            <h6 class="mb-0 text-dark">{{ ucfirst(Auth::user()->name) }}</h6>
                            <span class="text-muted app-sidebar__user-name text-sm">{{ ucfirst(Auth::user()->user_type) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slide-left disabled" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg>
            </div>
            <ul class="side-menu">
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('admin.home') }}">
                        <i class="side-menu__icon fe fe-airplay"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <i class="side-menu__icon fe fe-shopping-cart"></i>
                        <span class="side-menu__label">Orders</span>
                        <i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="side-menu__label1"><a href="javascript:void(0);">Orders</a></li>
                        <li><a class="slide-item" href="{{ route('admin.customer.neworder') }}">New Orders</a></li>
                        <li><a class="slide-item" href="{{ url('customer_order/old_list') }}">Older Orders</a></li>
                    </ul>
                </li>
                @if (Auth::user()->user_type == 'superadmin')
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                            <i class="side-menu__icon fe fe-users"></i>
                            <span class="side-menu__label">User Management</span>
                            <i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            <li class="side-menu__label1"><a href="javascript:void(0);">Users</a></li>
                            <li><a class="slide-item" href="{{ url('admin/customer/list') }}">Customers</a></li>
                            <li><a class="slide-item" href="{{ url('admin/reseller/list') }}">Resellers</a></li>
                        </ul>
                    </li>
                @endif
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <i class="side-menu__icon fe fe-calendar"></i>
                        <span class="side-menu__label">Events</span>
                        <i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="side-menu__label1"><a href="javascript:void(0);">Events</a></li>
                        <li><a class="slide-item" href="{{ url('events/list') }}">Events</a></li>
                        <li><a class="slide-item" href="{{ route('events.requestlist') }}">Requested Events</a></li>
                        <li><a class="slide-item" href="{{ url('eventtype/list') }}">Event Type</a></li>
                        <li><a class="slide-item" href="{{ url('eventtags/list') }}">Event Tags</a></li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <i class="side-menu__icon fe fe-tag"></i>
                        <span class="side-menu__label">Tickets</span>
                        <i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="side-menu__label1"><a href="javascript:void(0);">Tickets</a></li>
                        <li><a class="slide-item" href="{{ url('tickets') }}">Manage</a></li>
                        <li><a class="slide-item" href="{{ url('ticket_restrictions/list') }}">Ticket Restrictions</a></li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('admin/artist/list') }}">
                        <i class="side-menu__icon fe fe-music"></i>
                        <span class="side-menu__label">Artists</span>
                    </a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('slide/list') }}">
                        <i class="side-menu__icon fe fe-image"></i>
                        <span class="side-menu__label">Slides</span>
                    </a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('artistfield/list') }}">
                        <i class="side-menu__icon fe fe-layers"></i>
                        <span class="side-menu__label">Artist Field</span>
                    </a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('currency/list') }}">
                        <i class="side-menu__icon fe fe-dollar-sign"></i>
                        <span class="side-menu__label">Currency</span>
                    </a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <i class="side-menu__icon fe fe-map-pin"></i>
                        <span class="side-menu__label">Venue</span>
                        <i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="side-menu__label1"><a href="javascript:void(0);">Venue</a></li>
                        <li><a class="slide-item" href="{{ url('venue/list') }}">Venues</a></li>
                        <li><a class="slide-item" href="{{ url('venuetype/list') }}">Venue Type</a></li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <i class="side-menu__icon fe fe-globe"></i>
                        <span class="side-menu__label">Masters</span>
                        <i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="side-menu__label1"><a href="javascript:void(0);">Masters</a></li>
                        <li><a class="slide-item" href="{{ url('location/list') }}">Location</a></li>
                        <li><a class="slide-item" href="{{ url('city/list') }}">City</a></li>
                    </ul>
                </li>
                @if (Auth::user()->user_type == 'superadmin')
                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('admin/company_settings') }}">
                            <i class="side-menu__icon fe fe-settings"></i>
                            <span class="side-menu__label">Company Settings</span>
                        </a>
                    </li>
                @endif
            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg>
            </div>
        </div>
    </aside>
</div>
