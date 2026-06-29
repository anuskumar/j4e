@extends('layout.mainlayout')
@section('content')

<style>
    .ticket-cart-page {
        padding: 30px 0 50px;
    }

    .ticket-cart-header {
        margin-bottom: 24px;
    }

    .ticket-cart-header h2 {
        font-size: 26px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 6px;
    }

    .ticket-cart-header p {
        color: #6b7280;
        margin: 0;
    }

    .ticket-cart-listings-count {
        display: inline-block;
        background: #faf5fb;
        color: #7e0982;
        font-weight: 700;
        font-size: 13px;
        border-radius: 999px;
        padding: 4px 12px;
        margin-top: 10px;
    }

    .ticket-cart-card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        margin-bottom: 16px;
        overflow: hidden;
    }

    .ticket-cart-card__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 12px 18px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }

    .ticket-cart-card__listing-label {
        font-size: 13px;
        font-weight: 700;
        color: #7e0982;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .ticket-cart-card__held-badge {
        background: #7e0982;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        border-radius: 999px;
        padding: 5px 12px;
        white-space: nowrap;
    }

    .ticket-cart-item {
        display: flex;
        gap: 16px;
        padding: 18px;
        align-items: flex-start;
    }

    .ticket-cart-item__image {
        width: 88px;
        height: 88px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
        border: 1px solid #e5e7eb;
    }

    .ticket-cart-item__body {
        flex: 1;
        min-width: 0;
    }

    .ticket-cart-item__title {
        font-size: 18px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 6px;
    }

    .ticket-cart-item__meta {
        font-size: 13px;
        color: #6b7280;
        margin: 0 0 4px;
        line-height: 1.5;
    }

    .ticket-cart-item__pricing {
        text-align: right;
        flex-shrink: 0;
        min-width: 170px;
    }

    .ticket-cart-item__qty {
        font-size: 15px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
    }

    .ticket-cart-item__unit {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 6px;
    }

    .ticket-cart-item__total {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 12px;
    }

    .btn-cart-checkout {
        background: #7e0982;
        border-color: #7e0982;
        color: #fff;
        font-weight: 600;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
    }

    .btn-cart-checkout:hover {
        background: #6a0770;
        border-color: #6a0770;
        color: #fff;
    }

    .btn-release-listing {
        display: inline-block;
        background: #fff;
        border: 1px solid #5cb8b2;
        color: #5cb8b2;
        font-weight: 600;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
        text-decoration: none;
        margin-top: 8px;
    }

    .btn-release-listing:hover {
        background: #5cb8b2;
        color: #fff;
    }

    .ticket-cart-item__actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0;
    }

    .ticket-cart-summary {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        background: #f9fafb;
    }

    .ticket-cart-summary__row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        color: #374151;
        padding: 6px 0;
    }

    .ticket-cart-breakdown {
        list-style: none;
        padding: 0;
        margin: 0 0 12px;
        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
    }

    .ticket-cart-breakdown li {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        font-size: 13px;
        color: #374151;
        padding: 10px 0;
        border-bottom: 1px solid #eef2f7;
    }

    .ticket-cart-breakdown li:last-child {
        border-bottom: none;
    }

    .ticket-cart-breakdown__name {
        flex: 1;
        min-width: 0;
        line-height: 1.4;
    }

    .ticket-cart-breakdown__qty {
        font-weight: 700;
        color: #7e0982;
        white-space: nowrap;
    }

    .ticket-cart-summary__total {
        display: flex;
        justify-content: space-between;
        font-size: 18px;
        font-weight: 700;
        color: #111827;
        padding-top: 12px;
    }

    .ticket-cart-summary__total span:last-child {
        color: #7e0982;
    }

    .btn-release-all {
        display: block;
        width: 100%;
        background: #5cb8b2;
        border: none;
        color: #fff;
        font-weight: 700;
        font-size: 14px;
        padding: 12px 16px;
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
        margin-top: 16px;
    }

    .btn-release-all:hover {
        background: #49a59f;
        color: #fff;
    }
</style>

<div class="content ticket-cart-page">
    <div class="container">
        <div class="ticket-cart-header">
            <h2>Your Reserved Tickets</h2>
            <p>{{ $totalTickets }} held ticket{{ $totalTickets === 1 ? '' : 's' }} · holds expire in 15 minutes</p>
            <span class="ticket-cart-listings-count">{{ count($cartItems) }} listing{{ count($cartItems) === 1 ? '' : 's' }} in cart</span>
        </div>

        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if (Session::has('info'))
            <div class="alert alert-info">{{ Session::get('info') }}</div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                @foreach ($cartItems as $index => $item)
                    @php
                        $dat = $item['data'];
                        $defaultEventImg = asset('assets/img/events/event-01.jpg');
                        $eventImageUrl = !empty($dat->event_image)
                            ? asset('storage/uploads/events/' . $dat->event_image)
                            : $defaultEventImg;
                        $listingLabel = Str::ucfirst($dat->ticket_name ?? 'Ticket');
                        if (!empty($dat->seating_type_name)) {
                            $listingLabel .= ' · ' . $dat->seating_type_name;
                        }
                    @endphp
                    <div class="ticket-cart-card">
                        <div class="ticket-cart-card__header">
                            <span class="ticket-cart-card__listing-label">Listing {{ $index + 1 }}</span>
                            <span class="ticket-cart-card__held-badge">{{ $item['quantity'] }} ticket{{ $item['quantity'] === 1 ? '' : 's' }} held</span>
                        </div>
                        <div class="ticket-cart-item">
                            <img src="{{ $eventImageUrl }}" alt="{{ $dat->event_name }}" class="ticket-cart-item__image"
                                onerror="this.onerror=null;this.src='{{ $defaultEventImg }}';">
                            <div class="ticket-cart-item__body">
                                <h3 class="ticket-cart-item__title">{{ Str::ucfirst($dat->event_name) }}</h3>
                                <p class="ticket-cart-item__meta">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ Str::ucfirst($dat->venue_name ?? '') }}{{ !empty($dat->location_name) ? ', ' . Str::ucfirst($dat->location_name) : '' }}
                                </p>
                                <p class="ticket-cart-item__meta">
                                    {{ isset($dat->event_date) ? date('d M Y', strtotime($dat->event_date)) : '-' }}
                                    @if (!empty($dat->event_time))
                                        · {{ date('g:i A', strtotime($dat->event_time)) }}
                                    @endif
                                </p>
                                <p class="ticket-cart-item__meta">
                                    {{ $listingLabel }}
                                    @if (!empty($dat->row))
                                        · Row {{ $dat->row }}
                                    @endif
                                    @if (!empty($dat->ticket_type_name))
                                        · {{ $dat->ticket_type_name }}
                                    @endif
                                </p>
                            </div>
                            <div class="ticket-cart-item__pricing">
                                <div class="ticket-cart-item__qty">Held: {{ $item['quantity'] }}</div>
                                <div class="ticket-cart-item__unit">{{ number_format($item['unit_price'], 2) }} {{ $dat->short_name }} each</div>
                                <div class="ticket-cart-item__total">{{ number_format($item['total'], 2) }} {{ $dat->short_name }}</div>
                                <div class="ticket-cart-item__actions">
                                    <a href="{{ route('customer_ticket_billing_page', $item['event_ticket_id']) }}" class="btn btn-primary btn-cart-checkout">
                                        Checkout This Listing
                                    </a>
                                    <a href="{{ route('release_ticket_listing', $item['event_ticket_id']) }}" class="btn-release-listing"
                                        onclick="return confirm('Release {{ $item['quantity'] }} held ticket{{ $item['quantity'] === 1 ? '' : 's' }} for this listing?');">
                                        Release This Listing
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-lg-4">
                <div class="ticket-cart-summary">
                    <h4 style="font-size:18px;font-weight:700;margin-bottom:14px;">Cart Summary</h4>
                    <div class="ticket-cart-summary__row">
                        <span>Total Listings</span>
                        <span>{{ count($cartItems) }}</span>
                    </div>
                    <div class="ticket-cart-summary__row">
                        <span>Total Held Tickets</span>
                        <span>{{ $totalTickets }}</span>
                    </div>

                    <ul class="ticket-cart-breakdown">
                        @foreach ($cartItems as $index => $item)
                            @php
                                $summaryDat = $item['data'];
                                $summaryName = Str::limit(Str::ucfirst($summaryDat->ticket_name ?? 'Ticket'), 28);
                                if (!empty($summaryDat->seating_type_name)) {
                                    $summaryName .= ' (' . Str::limit($summaryDat->seating_type_name, 18) . ')';
                                }
                            @endphp
                            <li>
                                <span class="ticket-cart-breakdown__name">Listing {{ $index + 1 }}: {{ $summaryName }}</span>
                                <span class="ticket-cart-breakdown__qty">{{ $item['quantity'] }} held</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="ticket-cart-summary__total">
                        <span>Grand Total</span>
                        <span>{{ number_format($cartTotal, 2) }} {{ $cartItems[0]['data']->short_name ?? '' }}</span>
                    </div>
                    @if (count($cartItems) === 1)
                        <a href="{{ route('customer_ticket_billing_page', $cartItems[0]['event_ticket_id']) }}" class="btn btn-primary btn-cart-checkout w-100 mt-3">
                            Continue Checkout
                        </a>
                    @endif
                    <a href="{{ url('release_my_tickets') }}" class="btn-release-all"
                        onclick="return confirm('Release all reserved tickets from every listing in your cart?');">
                        Release All Tickets
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
