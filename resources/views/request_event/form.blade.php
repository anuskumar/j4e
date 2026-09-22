<?php $page = 'request-event'; ?>
@extends('layout.mainlayout')
@section('content')
@php
    $user = Auth::user();
    $oldArtists = old('artist_names', []);
    if (! is_array($oldArtists)) {
        $oldArtists = [];
    }
    $oldArtists = array_values(array_filter(array_map('trim', $oldArtists)));
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
        min-height: 110px;
        resize: vertical;
    }

    .request-event-form .form-control:focus {
        border-color: #671dcf;
        box-shadow: 0 0 0 3px rgba(103, 29, 207, 0.12);
    }

    .request-event-form .required-mark {
        color: #dc3545;
    }

    .request-event-form .field-hint {
        display: block;
        margin-top: 6px;
        font-size: 12px;
        color: #6b7280;
    }

    .request-event-section-title {
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: #671dcf;
        margin: 8px 0 18px;
    }

    .artist-tags-box {
        border: 1px solid #d8dee9;
        border-radius: 10px;
        padding: 10px 12px;
        min-height: 52px;
        background: #fff;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
        cursor: text;
    }

    .artist-tags-box:focus-within {
        border-color: #671dcf;
        box-shadow: 0 0 0 3px rgba(103, 29, 207, 0.12);
    }

    .artist-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(103, 29, 207, 0.1);
        color: #4c1d95;
        border-radius: 999px;
        padding: 6px 10px 6px 12px;
        font-size: 13px;
        font-weight: 600;
    }

    .artist-tag button {
        border: none;
        background: transparent;
        color: #6d28d9;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        line-height: 1;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .artist-tag button:hover {
        background: rgba(109, 40, 217, 0.15);
    }

    .artist-tags-input {
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
        min-width: 160px;
        flex: 1;
        min-height: 34px !important;
        padding: 4px 2px !important;
        font-size: 14px;
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
            <div class="col-lg-9 col-xl-8">
                <div class="request-event-card">
                    <div class="request-event-card__header">
                        <h1>Can't find your event?</h1>
                        <p>Share the event website, venue, city, date, and artist names. Our team will review your request and add it if approved.</p>
                    </div>

                    <div class="request-event-card__body">
                        <div class="request-event-intro">
                            <i class="fas fa-info-circle"></i>
                            <p>Include as many details as possible so we can verify the event quickly. We typically respond within 1–2 business days.</p>
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

                        <form class="request-event-form" action="{{ route('reseller.requesteventstore') }}" method="POST" id="request-event-form">
                            @csrf

                            <div class="request-event-section-title">Your Contact Details</div>
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
                            </div>

                            <div class="request-event-section-title">Event Information</div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="website_url">Event Website Link</label>
                                        <input type="url" id="website_url" name="website_url"
                                            class="form-control @error('website_url') is-invalid @enderror"
                                            value="{{ old('website_url') }}"
                                            placeholder="https://example.com/event-page">
                                        <span class="field-hint">Website where the event details are shown.</span>
                                        @error('website_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="venue_details">Venue Details</label>
                                        <input type="text" id="venue_details" name="venue_details"
                                            class="form-control @error('venue_details') is-invalid @enderror"
                                            value="{{ old('venue_details') }}"
                                            placeholder="Venue / stadium / hall name">
                                        @error('venue_details')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" id="city" name="city"
                                            class="form-control @error('city') is-invalid @enderror"
                                            value="{{ old('city') }}"
                                            placeholder="City name">
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="event_date">Event Date <span class="required-mark">*</span></label>
                                        <input type="date" id="event_date" name="event_date"
                                            class="form-control @error('event_date') is-invalid @enderror"
                                            value="{{ old('event_date') }}" required>
                                        @error('event_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="location_details">Location Details</label>
                                        <textarea id="location_details" name="location_details"
                                            class="form-control @error('location_details') is-invalid @enderror"
                                            placeholder="Address, area, landmark, or other location notes">{{ old('location_details') }}</textarea>
                                        @error('location_details')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="artist_tag_input">Event Artists</label>
                                        <div class="artist-tags-box" id="artist-tags-box">
                                            @foreach ($oldArtists as $artist)
                                                <span class="artist-tag" data-value="{{ $artist }}">
                                                    {{ $artist }}
                                                    <button type="button" aria-label="Remove {{ $artist }}">&times;</button>
                                                    <input type="hidden" name="artist_names[]" value="{{ $artist }}">
                                                </span>
                                            @endforeach
                                            <input type="text" id="artist_tag_input" class="artist-tags-input"
                                                placeholder="Type artist name and press Enter">
                                        </div>
                                        <span class="field-hint">Add artists as tags. Press Enter or comma after each name.</span>
                                        @error('artist_names')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        @error('artist_names.*')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <label for="event_details">Additional Event Details</label>
                                        <textarea id="event_details" name="event_details"
                                            class="form-control @error('event_details') is-invalid @enderror"
                                            placeholder="Any other helpful notes about the event...">{{ old('event_details') }}</textarea>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const box = document.getElementById('artist-tags-box');
    const input = document.getElementById('artist_tag_input');
    if (!box || !input) return;

    function normalize(value) {
        return String(value || '').trim().replace(/\s+/g, ' ');
    }

    function existingValues() {
        return Array.from(box.querySelectorAll('input[name="artist_names[]"]'))
            .map(function (el) { return normalize(el.value).toLowerCase(); });
    }

    function addTag(rawValue) {
        const value = normalize(rawValue);
        if (!value) return;
        if (existingValues().indexOf(value.toLowerCase()) !== -1) {
            input.value = '';
            return;
        }

        const tag = document.createElement('span');
        tag.className = 'artist-tag';
        tag.setAttribute('data-value', value);
        tag.innerHTML =
            value.replace(/</g, '&lt;').replace(/>/g, '&gt;') +
            '<button type="button" aria-label="Remove ' + value.replace(/"/g, '&quot;') + '">&times;</button>' +
            '<input type="hidden" name="artist_names[]" value="' + value.replace(/"/g, '&quot;') + '">';
        box.insertBefore(tag, input);
        input.value = '';
    }

    box.addEventListener('click', function (e) {
        const removeBtn = e.target.closest('button');
        if (removeBtn && removeBtn.closest('.artist-tag')) {
            removeBtn.closest('.artist-tag').remove();
            return;
        }
        input.focus();
    });

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            addTag(input.value.replace(/,/g, ''));
        } else if (e.key === 'Backspace' && !input.value) {
            const tags = box.querySelectorAll('.artist-tag');
            if (tags.length) {
                tags[tags.length - 1].remove();
            }
        }
    });

    input.addEventListener('blur', function () {
        if (input.value.trim()) {
            addTag(input.value);
        }
    });

    document.getElementById('request-event-form').addEventListener('submit', function () {
        if (input.value.trim()) {
            addTag(input.value);
        }
    });
});
</script>
@endpush
