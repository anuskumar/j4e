<?php $page = 'tickets/view'; ?>
@extends('admin.layout.app')

@section('page_title', 'View Ticket')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('tickets') }}">Tickets</a></li>
    <li class="breadcrumb-item"><a href="{{ url('tickets/manage_tickets/' . $data->event) }}">{{ $data->event_name ?? 'Manage Tickets' }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">View Ticket</li>
@endsection

@section('admin_content')

@php
    $ticketImageUrl = null;
    if (!empty($data->cover_image)) {
        $ticketImageUrl = asset('storage/uploads/ticket_images/' . $data->cover_image);
    } elseif (!empty($data->image)) {
        $ticketImageUrl = asset('storage/uploads/ticket_images/' . $data->image);
    } elseif (!empty($data->event_image)) {
        $ticketImageUrl = asset('storage/uploads/events/' . $data->event_image);
    } else {
        $ticketImageUrl = asset('assets/img/default-event.jpg');
    }

    $venueLabel = trim(($data->venue_name ?? '') . ($data->location_name ? ' — ' . $data->location_name . ($data->city_name ? ', ' . $data->city_name : '') : ''));
    $timingLabel = '-';
    if ($data->event_date) {
        $timingLabel = \Carbon\Carbon::parse($data->event_date)->format('d M Y');
        if ($data->from_time && $data->to_time) {
            $timingLabel .= ' · ' . \Carbon\Carbon::parse($data->from_time)->format('H:i') . ' – ' . \Carbon\Carbon::parse($data->to_time)->format('H:i');
        }
    }

    $approvalLabel = match ((int) $data->is_admin_approved) {
        1 => 'Approved',
        2 => 'Rejected',
        default => 'Pending',
    };
    $approvalBadgeClass = match ((int) $data->is_admin_approved) {
        1 => 'bg-success-transparent text-success',
        2 => 'bg-danger-transparent text-danger',
        default => 'bg-warning-transparent text-warning',
    };

    $seatLabel = '-';
    if ($data->row || $data->seat_from || $data->seat_to) {
        $seatLabel = trim('Row ' . ($data->row ?? '-') . ' · Seats ' . ($data->seat_from ?? '-') . ' – ' . ($data->seat_to ?? '-'));
    }
@endphp

@include('admin.events.partials.event_form_styles')

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body text-center">
                <div class="event-image-upload readonly mb-3">
                    <img alt="{{ $data->ticket_name }}"
                        class="event-preview-img"
                        src="{{ $ticketImageUrl }}"
                        onerror="this.onerror=null;this.src='{{ asset('assets/img/default-event.jpg') }}';">
                </div>
                <h5 class="main-profile-name mb-1">{{ $data->ticket_name ?? 'Ticket Listing' }}</h5>
                <p class="main-profile-name-text text-muted mb-2">Qty: {{ $data->no_of_tickets ?? 0 }}</p>
                <p class="form-field-hint mb-0">
                    <span class="badge {{ $approvalBadgeClass }} me-1">{{ $approvalLabel }}</span>
                    @if ($data->ticket_status_name)
                        <span class="badge bg-primary-transparent text-primary">{{ $data->ticket_status_name }}</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Ticket Preview</div>
                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="fe fe-tag"></i>
                        </div>
                        <div class="media-body">
                            <span>Ticket Type</span>
                            <div>{{ $data->ticket_type_name ?? 'Not set' }}</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="fe fe-calendar"></i>
                        </div>
                        <div class="media-body">
                            <span>Event</span>
                            <div>{{ $data->event_name ?? 'Not set' }}</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-info-transparent text-info">
                            <i class="fe fe-map-pin"></i>
                        </div>
                        <div class="media-body">
                            <span>Venue</span>
                            <div>{{ $venueLabel ?: 'Not set' }}</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-warning-transparent text-warning">
                            <i class="fe fe-clock"></i>
                        </div>
                        <div class="media-body">
                            <span>Timing</span>
                            <div>{{ $timingLabel }}</div>
                        </div>
                    </div>
                    <div class="media mb-0">
                        <div class="media-icon bg-danger-transparent text-danger">
                            <i class="fe fe-dollar-sign"></i>
                        </div>
                        <div class="media-body">
                            <span>Price / Ticket</span>
                            <div>
                                {{ number_format((float) ($data->ticket_amount ?? 0), 2) }}
                                {{ $data->currency_short_name ?? '' }}
                            </div>
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
                        <label class="form-field-label">Ticket Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-ticket-alt"></i></span>
                            <input type="text" class="form-control" value="{{ $data->ticket_name ?? '' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label">Number Of Tickets</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-layers"></i></span>
                            <input type="text" class="form-control" value="{{ $data->no_of_tickets ?? 0 }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row g-3 form-section-spacer">
                    <div class="col-md-4">
                        <label class="form-field-label">Ticket Type</label>
                        <input type="text" class="form-control" value="{{ $data->ticket_type_name ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label">Event</label>
                        <input type="text" class="form-control" value="{{ $data->event_name ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label">Seating</label>
                        <input type="text" class="form-control" value="{{ $data->seating_type_name ?? '-' }}" readonly>
                    </div>
                </div>

                <div class="row g-3 form-section-spacer">
                    <div class="col-md-4">
                        <label class="form-field-label">Row / Seats</label>
                        <input type="text" class="form-control" value="{{ $seatLabel }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label">Split Type</label>
                        <input type="text" class="form-control" value="{{ $data->split_type_name ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label">Availability</label>
                        <input type="text" class="form-control" value="{{ $data->ticket_status_name ?? '-' }}" readonly>
                    </div>
                </div>

                <div class="row g-3 form-section-spacer">
                    <div class="col-md-12">
                        <label class="form-field-label">Restrictions</label>
                        <input type="text" class="form-control" value="{{ $restrictionNames ?: 'None' }}" readonly>
                    </div>
                </div>

                <div class="mb-4 main-content-label">Pricing</div>

                <div class="row g-3 form-section-spacer">
                    <div class="col-md-4">
                        <label class="form-field-label">Ticket Amount</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-dollar-sign"></i></span>
                            <input type="text" class="form-control" value="{{ number_format((float) ($data->ticket_amount ?? 0), 2) }} {{ $data->currency_short_name ?? '' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label">Face Value</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-dollar-sign"></i></span>
                            <input type="text" class="form-control" value="{{ number_format((float) ($data->face_value ?? 0), 2) }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label">Web Price</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-dollar-sign"></i></span>
                            <input type="text" class="form-control" value="{{ number_format((float) ($data->web_price ?? 0), 2) }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row g-3 form-section-spacer">
                    <div class="col-md-4">
                        <label class="form-field-label">Seller Fee</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-percent"></i></span>
                            <input type="text" class="form-control" value="{{ $data->seller_fee ?? 0 }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label">Receive Per Ticket</label>
                        <input type="text" class="form-control" value="{{ $data->recive_perticket ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-field-label">Total Receive</label>
                        <input type="text" class="form-control" value="{{ $data->total_recive ?? '-' }}" readonly>
                    </div>
                </div>

                <div class="mb-4 main-content-label">Schedule & Approval</div>

                <div class="row g-3 form-section-spacer">
                    <div class="col-md-6">
                        <label class="form-field-label">Event Timing</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-clock"></i></span>
                            <input type="text" class="form-control" value="{{ $timingLabel }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-field-label">Booking Expiry</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-calendar"></i></span>
                            <input type="text" class="form-control"
                                value="{{ $data->booking_expiry_date_time ? \Carbon\Carbon::parse($data->booking_expiry_date_time)->format('d M Y H:i A') : '-' }}"
                                readonly>
                        </div>
                    </div>
                </div>

                <div class="row g-3 form-section-spacer">
                    <div class="col-md-4">
                        <label class="form-field-label d-block">Admin Approval</label>
                        <div class="d-flex align-items-center justify-content-between border rounded px-3 bg-light" style="min-height: 38px;">
                            <span class="tx-13 fw-semibold">{{ $approvalLabel }}</span>
                            <span class="badge {{ $approvalBadgeClass }}">{{ $approvalLabel }}</span>
                        </div>
                    </div>
                    @if (Auth::user()->user_type !== 'reseller')
                        <div class="col-md-8">
                            <label class="form-field-label">Reseller</label>
                            <input type="text" class="form-control"
                                value="{{ trim(($data->reseller_name ?? 'N/A') . ($data->reseller_email ? ' · ' . $data->reseller_email : '') . ($data->reseller_phone ? ' · ' . $data->reseller_phone : '')) }}"
                                readonly>
                        </div>
                    @endif
                </div>

                <div class="mb-4 main-content-label">Notes</div>

                <div class="row g-3 form-section-spacer">
                    <div class="col-md-6">
                        <label class="form-field-label">Disclaimer Notes</label>
                        <div class="input-group">
                            <span class="input-group-text align-items-start pt-2"><i class="fe fe-file-text"></i></span>
                            <textarea class="form-control" rows="4" readonly>{{ $data->disclaimer_note ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-field-label">Cancellation Policy</label>
                        <div class="input-group">
                            <span class="input-group-text align-items-start pt-2"><i class="fe fe-file-text"></i></span>
                            <textarea class="form-control" rows="4" readonly>{{ $data->cancellation_policy_notes ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mb-4 main-content-label">Documents & Media</div>

                <div class="row g-3 form-section-spacer mb-0">
                    @php
                        $mediaItems = [
                            ['label' => 'Cover Image', 'file' => $data->cover_image ?? null, 'path' => 'storage/uploads/ticket_images/'],
                            ['label' => 'Ticket Image', 'file' => $data->image ?? null, 'path' => 'storage/uploads/ticket_images/'],
                            ['label' => 'Map Layout', 'file' => $data->map_layout ?? null, 'path' => 'storage/uploads/ticket_images/'],
                            ['label' => 'ID Proof', 'file' => $data->proof_of_id ?? null, 'path' => 'storage/uploads/ticket_proof/proof_of_id/'],
                            ['label' => 'Proof of Purchase', 'file' => $data->proof_of_purchase ?? null, 'path' => 'storage/uploads/ticket_proof/proof_of_purchase/'],
                            ['label' => 'Ticket Upload', 'file' => $data->ticket_upload ?? null, 'path' => 'storage/uploads/ticket_images/'],
                        ];
                    @endphp
                    @foreach ($mediaItems as $media)
                        <div class="col-md-4">
                            <label class="form-field-label">{{ $media['label'] }}</label>
                            @if ($media['file'])
                                <a href="{{ asset($media['path'] . $media['file']) }}" target="_blank" class="d-block">
                                    <img src="{{ asset($media['path'] . $media['file']) }}"
                                        alt="{{ $media['label'] }}"
                                        class="event-preview-img w-100"
                                        style="max-width: 100%; height: 120px;"
                                        onerror="this.onerror=null;this.src='{{ asset('assets/img/default-event.jpg') }}';">
                                </a>
                            @else
                                <div class="border rounded bg-light text-muted tx-12 d-flex align-items-center justify-content-center" style="height: 120px;">
                                    No file uploaded
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url('tickets/manage_tickets/' . $data->event) }}" class="btn btn-outline-secondary">
                    <i class="fe fe-arrow-left me-1"></i> Back to Listings
                </a>
                @if ($data->is_admin_approved == 1)
                    <a href="{{ url('tickets/manage_individual_tickets/' . $data->id) }}" class="btn btn-primary">
                        <i class="fas fa-ticket-alt me-1"></i> Manage Seats
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
