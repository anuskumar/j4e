<?php $page = 'request-event-thankyou'; ?>
@extends('layout.mainlayout')
@section('content')

<style>
    .request-event-thankyou-page {
        padding: 60px 0 80px;
        background: #f4f6fb;
    }

    .request-event-thankyou-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 16px 40px rgba(34, 30, 105, 0.1);
        border: 1px solid rgba(103, 29, 207, 0.08);
        padding: 48px 36px;
        text-align: center;
    }

    .request-event-thankyou-icon {
        width: 88px;
        height: 88px;
        margin: 0 auto 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(34, 30, 105, 1), rgba(103, 29, 207, 1));
        color: #fff;
        font-size: 38px;
        box-shadow: 0 10px 28px rgba(103, 29, 207, 0.25);
    }

    .request-event-thankyou-card h1 {
        font-size: clamp(1.75rem, 3vw, 2.25rem);
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 14px;
    }

    .request-event-thankyou-card p {
        color: #6b7280;
        font-size: 16px;
        line-height: 1.7;
        margin-bottom: 12px;
        max-width: 520px;
        margin-left: auto;
        margin-right: auto;
    }

    .request-event-thankyou-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
        margin-top: 32px;
    }

    .request-event-thankyou-actions .btn-primary {
        background: linear-gradient(90deg, rgba(34, 30, 105, 1) 5%, rgba(103, 29, 207, 1) 100%);
        border: none;
        border-radius: 999px;
        padding: 12px 26px;
        font-weight: 600;
    }

    .request-event-thankyou-actions .btn-outline-secondary {
        border-radius: 999px;
        padding: 12px 26px;
        font-weight: 600;
    }

    @media (max-width: 767px) {
        .request-event-thankyou-card {
            padding: 36px 22px;
        }

        .request-event-thankyou-actions .btn {
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
                        <li class="breadcrumb-item"><a href="{{ route('reseller.requestevent') }}">Request Event</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Thank You</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Request Submitted</h2>
            </div>
        </div>
    </div>
</div>

<div class="content request-event-thankyou-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xl-6">
                <div class="request-event-thankyou-card">
                    <div class="request-event-thankyou-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <h1>Thank You!</h1>
                    <p>Your event request has been submitted successfully. Our team will review the details and get back to you soon.</p>
                    <p class="mb-0">If we need any additional information, we will contact you using the email or phone number you provided.</p>

                    <div class="request-event-thankyou-actions">
                        <a href="{{ url('/') }}" class="btn btn-primary">Back to Home</a>
                        <a href="{{ route('new_eventlistfrontend') }}" class="btn btn-outline-secondary">Browse Events</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
