<?php $page = 'customer-dashboard'; ?>
@extends('layout.mainlayout')
@section('content')

@php
    $user = Auth::user();
    $profileImage = $user->profileImageUrl();
    $defaultAvatar = \App\Models\User::defaultProfileImageUrl();
    $totalBookings = $all_bookings->count();
    $upcomingCount = $upcomming_booking->count();
    $totalSpent = $all_bookings->where('is_payment_completed', 1)->sum('payment_amount');
    $completedCount = $all_bookings->where('purchase_status', 6)->count();
@endphp

<style>
    .customer-dashboard {
        background: #f4f6fb;
        padding: 0 0 60px;
    }

    .customer-dashboard__hero {
        background: linear-gradient(90deg, rgba(34, 30, 105, 1) 5%, rgba(54, 8, 94, 1) 65%, rgba(103, 29, 207, 1) 100%);
        color: #fff;
        padding: 32px 0 48px;
        margin-bottom: -28px;
    }

    .customer-dashboard__hero h1 {
        font-size: clamp(1.5rem, 3vw, 2rem);
        font-weight: 700;
        margin-bottom: 6px;
    }

    .customer-dashboard__hero p {
        margin: 0;
        color: rgba(255, 255, 255, 0.88);
        font-size: 15px;
    }

    .customer-dashboard__hero-actions .btn {
        border-radius: 999px;
        font-weight: 600;
        padding: 10px 20px;
    }

    .customer-dashboard__hero-actions .btn-light {
        color: #221e69;
    }

    .customer-stat-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(103, 29, 207, 0.08);
        box-shadow: 0 8px 24px rgba(34, 30, 105, 0.06);
        padding: 22px 20px;
        height: 100%;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .customer-stat-card__icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .customer-stat-card__icon--primary { background: rgba(98, 89, 202, 0.12); color: #6259ca; }
    .customer-stat-card__icon--success { background: rgba(34, 197, 94, 0.12); color: #16a34a; }
    .customer-stat-card__icon--warning { background: rgba(245, 158, 11, 0.12); color: #d97706; }
    .customer-stat-card__icon--info { background: rgba(14, 165, 233, 0.12); color: #0284c7; }

    .customer-stat-card__label {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 2px;
    }

    .customer-stat-card__value {
        font-size: 1.35rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.2;
    }

    .customer-panel {
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(103, 29, 207, 0.08);
        box-shadow: 0 8px 24px rgba(34, 30, 105, 0.06);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .customer-panel__header {
        padding: 20px 24px;
        border-bottom: 1px solid #eef0f6;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .customer-panel__header h4 {
        margin: 0;
        font-size: 17px;
        font-weight: 700;
        color: #111827;
    }

    .customer-profile-card {
        text-align: center;
        padding: 28px 20px 20px;
    }

    .customer-profile-card__avatar {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #f3f4f6;
        margin-bottom: 14px;
    }

    .customer-profile-card h3 {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .customer-profile-card__meta {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 16px;
    }

    .customer-profile-card__details {
        list-style: none;
        margin: 0;
        padding: 0 16px 16px;
        text-align: left;
    }

    .customer-profile-card__details li {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f3f4f6;
        font-size: 13px;
    }

    .customer-profile-card__details li:last-child { border-bottom: none; }
    .customer-profile-card__details li span:first-child { color: #6b7280; }
    .customer-profile-card__details li span:last-child { font-weight: 600; color: #111827; text-align: right; word-break: break-word; }

    .customer-sidebar-nav .dashboard-menu ul { padding: 0 12px 16px; }
    .customer-sidebar-nav .dashboard-menu ul li a {
        border-radius: 10px;
        padding: 12px 14px;
    }
    .customer-sidebar-nav .dashboard-menu ul li.active a {
        background: linear-gradient(90deg, rgba(34, 30, 105, 0.08), rgba(103, 29, 207, 0.1));
        color: #6259ca;
        font-weight: 600;
    }

    .customer-recent-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 20px;
        border-bottom: 1px solid #f3f4f6;
    }

    .customer-recent-item:last-child { border-bottom: none; }

    .customer-recent-item__img {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .customer-recent-item__title {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 2px;
        line-height: 1.3;
    }

    .customer-recent-item__meta {
        font-size: 12px;
        color: #6b7280;
    }

    .customer-tabs .nav-link {
        border: none;
        border-radius: 999px;
        padding: 10px 18px;
        font-weight: 600;
        font-size: 14px;
        color: #6b7280;
        margin-right: 8px;
        margin-bottom: 8px;
    }

    .customer-tabs .nav-link.active {
        background: linear-gradient(90deg, rgba(34, 30, 105, 1) 5%, rgba(103, 29, 207, 1) 100%);
        color: #fff;
    }

    .booking-card {
        border: 1px solid #eef0f6;
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 16px;
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .booking-card:hover {
        border-color: rgba(103, 29, 207, 0.2);
        box-shadow: 0 8px 20px rgba(34, 30, 105, 0.08);
    }

    .booking-card__top {
        display: flex;
        gap: 16px;
        align-items: flex-start;
        margin-bottom: 14px;
    }

    .booking-card__image {
        width: 72px;
        height: 72px;
        border-radius: 12px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .booking-card__title {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
    }

    .booking-card__subtitle {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .booking-card__grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px 16px;
        margin-bottom: 16px;
    }

    @media (min-width: 768px) {
        .booking-card__grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    .booking-card__field span {
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #9ca3af;
        margin-bottom: 2px;
    }

    .booking-card__field strong {
        font-size: 13px;
        color: #111827;
        font-weight: 600;
    }

    .booking-card__actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        padding-top: 14px;
        border-top: 1px solid #f3f4f6;
    }

    .booking-card__actions .btn {
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        padding: 8px 16px;
    }

    .booking-card__actions .btn-primary {
        background: linear-gradient(90deg, rgba(34, 30, 105, 1) 5%, rgba(103, 29, 207, 1) 100%);
        border: none;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-badge--success { background: #dcfce7; color: #166534; }
    .status-badge--warning { background: #fef3c7; color: #92400e; }
    .status-badge--danger { background: #fee2e2; color: #991b1b; }
    .status-badge--info { background: #dbeafe; color: #1e40af; }
    .status-badge--secondary { background: #f3f4f6; color: #4b5563; }

    .customer-empty {
        text-align: center;
        padding: 48px 24px;
        color: #6b7280;
    }

    .customer-empty__icon {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 28px;
        color: #9ca3af;
    }

    .customer-empty h5 {
        color: #111827;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .alert-dashboard {
        border-radius: 12px;
        border: none;
        margin-bottom: 20px;
    }
</style>

<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Dashboard</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">My Dashboard</h2>
            </div>
        </div>
    </div>
</div>

<div class="customer-dashboard__hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1>Welcome back, {{ ucfirst($user->name) }}!</h1>
                <p>Manage your bookings, download invoices, and view upcoming events in one place.</p>
            </div>
            <div class="col-lg-4 text-lg-right mt-3 mt-lg-0 customer-dashboard__hero-actions">
                <a href="{{ url('/') }}" class="btn btn-light mr-2 mb-2">
                    <i class="fas fa-search mr-1"></i> Browse Events
                </a>
                <a href="{{ url('customer_profile_settings') }}" class="btn btn-outline-light mb-2">
                    <i class="fas fa-user-cog mr-1"></i> Profile
                </a>
            </div>
        </div>
    </div>
</div>

<div class="content customer-dashboard">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dashboard">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dashboard">{{ session('error') }}</div>
        @endif

        <div class="row mb-4">
            <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
                <div class="customer-stat-card">
                    <div class="customer-stat-card__icon customer-stat-card__icon--primary">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div>
                        <div class="customer-stat-card__label">Total Bookings</div>
                        <div class="customer-stat-card__value">{{ $totalBookings }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
                <div class="customer-stat-card">
                    <div class="customer-stat-card__icon customer-stat-card__icon--info">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <div class="customer-stat-card__label">Upcoming Events</div>
                        <div class="customer-stat-card__value">{{ $upcomingCount }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
                <div class="customer-stat-card">
                    <div class="customer-stat-card__icon customer-stat-card__icon--success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <div class="customer-stat-card__label">Completed Orders</div>
                        <div class="customer-stat-card__value">{{ $completedCount }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="customer-stat-card">
                    <div class="customer-stat-card__icon customer-stat-card__icon--warning">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div>
                        <div class="customer-stat-card__label">Total Spent</div>
                        <div class="customer-stat-card__value">{{ number_format((float) $totalSpent, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-xl-3 mb-4">
                <div class="customer-panel">
                    <div class="customer-profile-card">
                        <img src="{{ $profileImage }}" alt="{{ $user->name }}"
                            class="customer-profile-card__avatar"
                            onerror="this.onerror=null;this.src='{{ $defaultAvatar }}';">
                        <h3>{{ ucfirst($user->name) }}</h3>
                        <div class="customer-profile-card__meta">Customer ID #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <ul class="customer-profile-card__details">
                        <li><span>Email</span><span>{{ $user->email }}</span></li>
                        <li><span>Phone</span><span>{{ $user->phone ?: '—' }}</span></li>
                    </ul>
                    <div class="customer-sidebar-nav">
                        @include('layout.customer_sidebar')
                    </div>
                </div>

                @if($last_booking->count())
                <div class="customer-panel">
                    <div class="customer-panel__header">
                        <h4>Recent Bookings</h4>
                    </div>
                    @foreach($last_booking as $val)
                        <div class="customer-recent-item">
                            @if($val->event_image)
                                <img src="{{ asset('storage/uploads/events/' . $val->event_image) }}" alt="" class="customer-recent-item__img"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/img/events/event-01.jpg') }}';">
                            @else
                                <img src="{{ asset('assets/img/events/event-01.jpg') }}" alt="" class="customer-recent-item__img">
                            @endif
                            <div>
                                <div class="customer-recent-item__title">{{ $val->event_name }}</div>
                                <div class="customer-recent-item__meta">
                                    {{ $val->tag_name }}, {{ $val->event_type_name }}
                                    @if(!empty($val['event_date']->event_date))
                                        · {{ date('d M Y', strtotime($val['event_date']->event_date)) }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="col-lg-8 col-xl-9">
                <div class="customer-panel">
                    <div class="customer-panel__header">
                        <h4>My Bookings</h4>
                        <ul class="nav customer-tabs mb-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#all-bookings" role="tab">All Bookings ({{ $totalBookings }})</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#upcoming-bookings" role="tab">Upcoming ({{ $upcomingCount }})</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content p-3 p-md-4">
                        <div class="tab-pane fade show active" id="all-bookings" role="tabpanel">
                            @forelse($all_bookings as $val)
                                @include('partials.customer_booking_card', ['booking' => $val])
                            @empty
                                <div class="customer-empty">
                                    <div class="customer-empty__icon"><i class="fas fa-ticket-alt"></i></div>
                                    <h5>No bookings yet</h5>
                                    <p class="mb-3">You haven't purchased any tickets. Explore events and book your first experience.</p>
                                    <a href="{{ url('/') }}" class="btn btn-primary" style="border-radius:999px;">Browse Events</a>
                                </div>
                            @endforelse
                        </div>

                        <div class="tab-pane fade" id="upcoming-bookings" role="tabpanel">
                            @forelse($upcomming_booking as $val)
                                @include('partials.customer_booking_card', ['booking' => $val, 'compact' => true])
                            @empty
                                <div class="customer-empty">
                                    <div class="customer-empty__icon"><i class="fas fa-calendar-alt"></i></div>
                                    <h5>No upcoming events</h5>
                                    <p class="mb-0">Your upcoming event bookings will appear here.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
