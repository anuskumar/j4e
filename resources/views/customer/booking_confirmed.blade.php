<?php $page = 'booking-confirmed'; ?>
@extends('layout.mainlayout')
@section('content')

<style>
    .booking-confirmed-page {
        padding: 60px 0 80px;
        background: #f4f6fb;
    }

    .booking-confirmed-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 16px 40px rgba(34, 30, 105, 0.1);
        border: 1px solid rgba(103, 29, 207, 0.08);
        overflow: hidden;
    }

    .booking-confirmed-card__header {
        background: linear-gradient(90deg, rgba(34, 30, 105, 1) 5%, rgba(54, 8, 94, 1) 65%, rgba(103, 29, 207, 1) 100%);
        color: #fff;
        padding: 36px 32px;
        text-align: center;
    }

    .booking-confirmed-icon {
        width: 88px;
        height: 88px;
        margin: 0 auto 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.16);
        font-size: 40px;
    }

    .booking-confirmed-card__header h1 {
        font-size: clamp(1.75rem, 3vw, 2.2rem);
        font-weight: 700;
        margin-bottom: 8px;
    }

    .booking-confirmed-card__header p {
        margin: 0;
        color: rgba(255, 255, 255, 0.9);
        font-size: 16px;
    }

    .booking-confirmed-card__body {
        padding: 32px;
    }

    .booking-confirmed-summary {
        background: #f8f9fc;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 24px;
    }

    .booking-confirmed-summary h3 {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 16px;
        color: #1f2937;
    }

    .booking-confirmed-summary ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .booking-confirmed-summary li {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        padding: 10px 0;
        border-bottom: 1px solid #e5e7eb;
        font-size: 14px;
    }

    .booking-confirmed-summary li:last-child {
        border-bottom: none;
    }

    .booking-confirmed-summary li span:first-child {
        color: #6b7280;
    }

    .booking-confirmed-summary li span:last-child {
        font-weight: 600;
        color: #111827;
        text-align: right;
    }

    .booking-confirmed-note {
        color: #6b7280;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 24px;
    }

    .booking-confirmed-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
    }

    .booking-confirmed-actions .btn-primary {
        background: linear-gradient(90deg, rgba(34, 30, 105, 1) 5%, rgba(103, 29, 207, 1) 100%);
        border: none;
        border-radius: 999px;
        padding: 12px 24px;
        font-weight: 600;
    }

    .booking-confirmed-actions .btn-outline-secondary {
        border-radius: 999px;
        padding: 12px 24px;
        font-weight: 600;
    }

    @media (max-width: 767px) {
        .booking-confirmed-card__body,
        .booking-confirmed-card__header {
            padding: 24px 20px;
        }

        .booking-confirmed-actions .btn {
            width: 100%;
        }
    }
</style>

<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Booking Confirmed</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Booking Confirmed</h2>
            </div>
        </div>
    </div>
</div>

<div class="content booking-confirmed-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="booking-confirmed-card">
                    <div class="booking-confirmed-card__header">
                        <div class="booking-confirmed-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <h1>Congratulations!</h1>
                        <p>Your booking is confirmed. A confirmation email with your invoice has been sent to you.</p>
                    </div>

                    <div class="booking-confirmed-card__body">
                        <div class="booking-confirmed-summary">
                            <h3>Booking Summary</h3>
                            <ul>
                                <li><span>Order ID</span><span>#{{ str_pad($purchase->id, 6, '0', STR_PAD_LEFT) }}</span></li>
                                <li><span>Event</span><span>{{ $purchase->event_name ?? 'N/A' }}</span></li>
                                @if (!empty($purchase->event_date))
                                    <li><span>Event Date</span><span>{{ date('d M Y', strtotime($purchase->event_date)) }}@if(!empty($purchase->event_time)) {{ date('h:i A', strtotime($purchase->event_time)) }}@endif</span></li>
                                @endif
                                @if (!empty($purchase->venue_name))
                                    <li><span>Venue</span><span>{{ $purchase->venue_name }}</span></li>
                                @endif
                                @if (!empty($purchase->ticket_name))
                                    <li><span>Ticket</span><span>{{ $purchase->ticket_name }}</span></li>
                                @endif
                                <li><span>Tickets</span><span>{{ $purchase->total_number }}</span></li>
                                <li><span>Total Paid</span><span>{{ number_format((float) $purchase->payment_amount, 2) }} {{ $purchase->currency_short_name ?? $purchase->currency_name ?? '' }}</span></li>
                                <li><span>Payment Reference</span><span>{{ $purchase->payment_id ?? 'N/A' }}</span></li>
                            </ul>
                        </div>

                        <p class="booking-confirmed-note text-center mb-0">
                            The reseller has also been notified about your purchase. You can view or download your invoice anytime from your account.
                        </p>

                        <div class="booking-confirmed-actions">
                            <a href="{{ url('view_invoice/' . $purchase->id) }}" class="btn btn-primary">View Invoice</a>
                            <a href="{{ route('invoice.pdf', $purchase->id) }}" class="btn btn-outline-secondary">Download Invoice PDF</a>
                            <a href="{{ url('show_booking_details_show/' . $purchase->id) }}" class="btn btn-outline-secondary">View Booking Details</a>
                            <a href="{{ url('home') }}" class="btn btn-outline-secondary">Go to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
