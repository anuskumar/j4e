<?php $page = 'request-event'; ?>
@extends('layout.mainlayout')
@section('content')
@php
    $user = Auth::user();
@endphp

<style>
    .request-event-page {
        padding: 40px 0 60px;
        background: #f4f6fb;
    }

    .request-event-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 16px 40px rgba(34, 30, 105, 0.1);
        overflow: hidden;
        border: 1px solid rgba(103, 29, 207, 0.08);
    }

    .request-event-card__header {
        background: rgb(34, 30, 105);
        background: linear-gradient(90deg, rgba(34, 30, 105, 1) 5%, rgba(54, 8, 94, 1) 65%, rgba(103, 29, 207, 1) 100%);
        color: #fff;
        padding: 32px 36px;
    }

    .request-event-card__header h1 {
        font-size: clamp(1.5rem, 3vw, 2rem);
        font-weight: 700;
        margin: 0 0 10px;
    }

    .request-event-card__header p {
        margin: 0;
        color: rgba(255, 255, 255, 0.88);
        font-size: 15px;
        line-height: 1.6;
        max-width: 620px;
    }

    .request-event-card__body {
        padding: 32px 36px 36px;
    }

    .request-event-intro {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        padding: 16px 18px;
        border-radius: 12px;
        background: rgba(103, 29, 207, 0.06);
        border: 1px solid rgba(103, 29, 207, 0.12);
        margin-bottom: 28px;
    }

    .request-event-intro i {
        color: #671dcf;
        font-size: 20px;
        margin-top: 2px;
    }

    .request-event-intro p {
        margin: 0;
        color: #4b5563;
        font-size: 14px;
        line-height: 1.6;
    }

    .request-event-form .form-group label {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .request-event-form .form-control {
        min-height: 46px;
        border-radius: 10px;
        border: 1px solid #d8dee9;
        padding: 10px 14px;
        font-size: 14px;
    }

    .request-event-form textarea.form-control {
        min-height: 130px;
        resize: vertical;
    }

    .request-event-form .form-control:focus {
        border-color: #671dcf;
        box-shadow: 0 0 0 3px rgba(103, 29, 207, 0.12);
    }

    .request-event-form .required-mark {
        color: #dc3545;
    }

    .request-event-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid #eef1f6;
    }

    .request-event-submit {
        background: linear-gradient(90deg, rgba(34, 30, 105, 1) 5%, rgba(103, 29, 207, 1) 100%);
        border: none;
        color: #fff;
        font-weight: 600;
        padding: 12px 28px;
        border-radius: 999px;
        min-width: 180px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .request-event-submit:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(103, 29, 207, 0.28);
    }

    .request-event-cancel {
        border-radius: 999px;
        padding: 12px 24px;
        font-weight: 600;
    }

    @media (max-width: 767px) {
        .request-event-card__header,
        .request-event-card__body {
            padding: 24px 20px;
        }

        .request-event-actions {
            flex-direction: column;
        }

        .request-event-submit,
        .request-event-cancel {
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
                        <li class="breadcrumb-item active" aria-current="page">Request Event</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Request Event</h2>
            </div>
        </div>
    </div>
</div>

<div class="content request-event-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="request-event-card">
                    <div class="request-event-card__header">
                        <h1>Can't find your event?</h1>
                        <p>Tell us about the event you want to sell tickets for. Our team will review your request and add it to the platform if approved.</p>
                    </div>

                    <div class="request-event-card__body">
                        <div class="request-event-intro">
                            <i class="fas fa-info-circle"></i>
                            <p>Please include the event name, venue, date, and any other details that will help us identify it. We typically respond within 1–2 business days.</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 pl-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="request-event-form" action="{{ route('reseller.requesteventstore') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Full Name <span class="required-mark">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $user->name ?? '') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email Address <span class="required-mark">*</span></label>
                                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $user->email ?? '') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone Number <span class="required-mark">*</span></label>
                                        <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', $user->phone ?? '') }}" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <label for="event_details">Event Details <span class="required-mark">*</span></label>
                                        <textarea id="event_details" name="event_details" class="form-control @error('event_details') is-invalid @enderror"
                                            placeholder="Event name, artist, venue, city, date, and any other helpful details..." required>{{ old('event_details') }}</textarea>
                                        @error('event_details')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="request-event-actions">
                                <a href="{{ url('/') }}" class="btn btn-outline-secondary request-event-cancel">Cancel</a>
                                <button type="submit" class="btn request-event-submit">
                                    <i class="fas fa-paper-plane mr-2"></i>Submit Request
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
