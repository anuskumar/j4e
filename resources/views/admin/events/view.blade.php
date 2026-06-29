<?php $page = 'events/view'; ?>
@extends('admin.layout.app')

@section('page_title', 'View Event')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    @if (request('from') === 'tickets')
        <li class="breadcrumb-item"><a href="{{ url('tickets') }}">Tickets</a></li>
    @else
        <li class="breadcrumb-item"><a href="{{ url('events/list') }}">Events</a></li>
    @endif
    <li class="breadcrumb-item active" aria-current="page">View Event</li>
@endsection

@section('admin_content')

@php
    $eventImageUrl = $data->event_image
        ? asset('storage/uploads/events/' . $data->event_image)
        : asset('assets/img/default-event.jpg');
    $venueLabel = trim(($data->venue_name ?? '') . ($data->location_name ? ' — ' . $data->location_name . ', ' . ($data->city_name ?? '') : ''));
    $fromDate = $data->event_from_date ? \Carbon\Carbon::parse($data->event_from_date)->format('d M Y') : '';
    $toDate = $data->event_to_date ? \Carbon\Carbon::parse($data->event_to_date)->format('d M Y') : '';
    $startTime = $eventTiming && $eventTiming->from_time ? \Carbon\Carbon::parse($eventTiming->from_time)->format('H:i') : '';
    $endTime = $eventTiming && $eventTiming->to_time ? \Carbon\Carbon::parse($eventTiming->to_time)->format('H:i') : '';
    $datePreview = $fromDate && $toDate ? $fromDate . ' — ' . $toDate : ($fromDate ?: 'Not set');
    if ($startTime && $endTime) {
        $datePreview .= ' · ' . $startTime . ' — ' . $endTime;
    }
    $locationLabel = trim(($data->location_name ?? '') . ($data->city_name ? ' ' . $data->city_name : '') . ($data->country_name ? ', ' . $data->country_name : ''));
@endphp

@include('admin.events.partials.event_form_styles')

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body text-center">
                <div class="event-image-upload readonly mb-3">
                    <img alt="{{ $data->event_name }}"
                        class="event-preview-img"
                        src="{{ $eventImageUrl }}"
                        onerror="this.onerror=null;this.src='{{ asset('assets/img/default-event.jpg') }}';">
                </div>
                <h5 class="main-profile-name mb-1">{{ $data->event_name }}</h5>
                <p class="main-profile-name-text text-muted mb-2">Priority: {{ $data->priority ?? 0 }}</p>
                <p class="form-field-hint mb-0">
                    @if ($data->event_is_active == 1)
                        <span class="badge bg-success-transparent text-success">Active</span>
                    @else
                        <span class="badge bg-warning-transparent text-warning">Inactive</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Event Preview</div>
                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="fe fe-tag"></i>
                        </div>
                        <div class="media-body">
                            <span>Event Type</span>
                            <div>{{ $data->event_type_name ?? 'Not set' }}</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="fe fe-map-pin"></i>
                        </div>
                        <div class="media-body">
                            <span>Venue</span>
                            <div>{{ $venueLabel ?: 'Not set' }}</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-info-transparent text-info">
                            <i class="fe fe-calendar"></i>
                        </div>
                        <div class="media-body">
                            <span>Event Dates</span>
                            <div>{{ $datePreview }}</div>
                        </div>
                    </div>
                    <div class="media mb-0">
                        <div class="media-icon bg-warning-transparent text-warning">
                            <i class="fe fe-percent"></i>
                        </div>
                        <div class="media-body">
                            <span>Seller Fee</span>
                            <div>{{ $data->seller_fee_percent ?? 0 }}%</div>
                        </div>
                    </div>
                    <div class="media mb-0 mt-3">
                        <div class="media-icon bg-danger-transparent text-danger">
                            <i class="fe fe-percent"></i>
                        </div>
                        <div class="media-body">
                            <span>Customer Fee</span>
                            <div>{{ $data->customer_fee_percent ?? 0 }}%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-4 main-content-label">Basic Information</div>

                <div class="row g-3 form-section-spacer">
                    <div class="col-md-8">
                        <label class="form-field-label">Event Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-calendar"></i></span>
                            <input type="text" class="form-control" value="{{ $data->event_name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label">Display Priority</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-layers"></i></span>
                            <input type="text" class="form-control" value="{{ $data->priority ?? 0 }}" readonly>
                        </div>
                        <small class="form-field-hint">Higher number appears first on customer site.</small>
                    </div>
                </div>

                <div class="row g-3 form-section-spacer">
                    <div class="col-md-4">
                        <label class="form-field-label">Event Tag</label>
                        <input type="text" class="form-control" value="{{ $data->event_tag_name ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label">Event Type</label>
                        <input type="text" class="form-control" value="{{ $data->event_type_name ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label">Venue</label>
                        <input type="text" class="form-control" value="{{ $data->venue_name ?? '-' }}" readonly>
                    </div>
                </div>

                <div class="row g-3 form-section-spacer">
                    <div class="col-md-4">
                        <label class="form-field-label">Ticket Types</label>
                        <input type="text" class="form-control" value="{{ $ticketTypeNames ?: 'None selected' }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label">Seller Fee (%)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-percent"></i></span>
                            <input type="text" class="form-control" value="{{ $data->seller_fee_percent ?? 0 }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label">Artists</label>
                        <input type="text" class="form-control" value="{{ $artistNames ?: 'None selected' }}" readonly>
                    </div>
                </div>

                <div class="row g-3 form-section-spacer">
                    <div class="col-md-12">
                        <label class="form-field-label">Location</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-map-pin"></i></span>
                            <input type="text" class="form-control" value="{{ $locationLabel ?: '-' }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="mb-4 main-content-label">Event Schedule</div>

                <div class="row g-3 form-section-spacer">
                    <div class="col-md-4">
                        <label class="form-field-label">Event From Date</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-calendar"></i></span>
                            <input type="text" class="form-control" value="{{ $data->event_from_date ? \Carbon\Carbon::parse($data->event_from_date)->format('d M Y') : '' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label">Event To Date</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-calendar"></i></span>
                            <input type="text" class="form-control" value="{{ $data->event_to_date ? \Carbon\Carbon::parse($data->event_to_date)->format('d M Y') : '' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label d-block">Event Status</label>
                        <div class="d-flex align-items-center justify-content-between border rounded px-3 bg-light" style="min-height: 38px;">
                            <span class="tx-13 fw-semibold">{{ $data->event_is_active == 1 ? 'Active' : 'Inactive' }}</span>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" disabled {{ $data->event_is_active == 1 ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 form-section-spacer">
                    <div class="col-md-4">
                        <label class="form-field-label">Event Start Time</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-clock"></i></span>
                            <input type="text" class="form-control" value="{{ $startTime ?: '-' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label">Event End Time</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-clock"></i></span>
                            <input type="text" class="form-control" value="{{ $endTime ?: '-' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label">Customer Fee (%)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-percent"></i></span>
                            <input type="text" class="form-control" value="{{ $data->customer_fee_percent ?? 0 }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label class="form-field-label">Event Description</label>
                    <div class="input-group">
                        <span class="input-group-text align-items-start pt-2"><i class="fe fe-file-text"></i></span>
                        <textarea class="form-control" rows="4" readonly>{{ $data->event_desc }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                @if (request('from') === 'tickets')
                    <a href="{{ url('tickets') }}" class="btn btn-outline-secondary">Back to Tickets</a>
                @else
                    <a href="{{ url('events/list') }}" class="btn btn-outline-secondary">Back to Events</a>
                @endif
                <a href="{{ url('events/edit', $data->id) }}" class="btn btn-primary">
                    <i class="far fa-edit me-1"></i> Edit Event
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
