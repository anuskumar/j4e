<?php
$page = 'venue/view_seating';
$seatingImage = $data->seating_image
    ? asset('storage/uploads/venue_seating/' . $data->seating_image)
    : asset('assets/img/default-seating.jpg');
?>
@extends('admin.layout.app')

@section('page_title', 'View Seating')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('venue/list') }}">Venues</a></li>
    <li class="breadcrumb-item"><a href="{{ url('venue/manage_Seating', $venue->id) }}">Manage Seating</a></li>
    <li class="breadcrumb-item active" aria-current="page">View Seating</li>
@endsection

@section('admin_content')

@include('admin.partials.user_form_styles')

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body text-center">
                <div class="event-image-upload mb-3">
                    <img alt="{{ $data->seating_type_name }}"
                        class="event-preview-img"
                        src="{{ $seatingImage }}"
                        onerror="this.onerror=null;this.src='{{ asset('assets/img/default-event.jpg') }}';">
                </div>
                <h5 class="main-profile-name mb-1">{{ $data->seating_type_name }}</h5>
                <p class="main-profile-name-text text-muted mb-2">{{ $venue->name }}</p>
                @if ($data->is_active == 1)
                    <span class="badge bg-success-transparent">Active</span>
                @else
                    <span class="badge bg-warning-transparent">Inactive</span>
                @endif
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Seating Details</div>
                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="fe fe-grid"></i>
                        </div>
                        <div class="media-body">
                            <span>Seating Type</span>
                            <div>{{ $data->seating_type_name }}</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="fe fe-users"></i>
                        </div>
                        <div class="media-body">
                            <span>Total Seats</span>
                            <div>{{ $data->number_of_seats }}</div>
                        </div>
                    </div>
                    <div class="media mb-0">
                        <div class="media-icon bg-info-transparent text-info">
                            <i class="fe fe-hash"></i>
                        </div>
                        <div class="media-body">
                            <span>Serial Range</span>
                            <div>{{ $data->seat_serial_prefix }}{{ $data->seat_serial_start }} - {{ $data->seat_serial_prefix }}{{ $data->seat_serial_end }}</div>
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

                <div class="form-group form-section-spacer">
                    <label class="form-field-label">Seating Type Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fe fe-grid"></i></span>
                        <input type="text" class="form-control view-field" value="{{ $data->seating_type_name }}" readonly>
                    </div>
                </div>

                <div class="row g-3 form-section-spacer">
                    <div class="col-md-6">
                        <label class="form-field-label">Total Seats</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-users"></i></span>
                            <input type="text" class="form-control view-field" value="{{ $data->number_of_seats }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-field-label">Seat Serial Prefix</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-hash"></i></span>
                            <input type="text" class="form-control view-field" value="{{ $data->seat_serial_prefix }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row g-3 form-section-spacer">
                    <div class="col-md-6">
                        <label class="form-field-label">Serial Start</label>
                        <input type="text" class="form-control view-field" value="{{ $data->seat_serial_start }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-field-label">Serial End</label>
                        <input type="text" class="form-control view-field" value="{{ $data->seat_serial_end }}" readonly>
                    </div>
                </div>

                <div class="form-group form-section-spacer">
                    <label class="form-field-label">Description</label>
                    <textarea class="form-control view-field" rows="3" readonly>{{ $data->seating_type_desc ?: '-' }}</textarea>
                </div>

                <div class="form-group mb-0">
                    <label class="form-field-label d-block">Status</label>
                    <div class="d-flex align-items-center justify-content-between border rounded px-3" style="min-height: 38px;">
                        <span class="tx-13 fw-semibold">Active</span>
                        @if ($data->is_active == 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-warning">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url('venue/manage_Seating', $venue->id) }}" class="btn btn-outline-secondary">
                    <i class="fe fe-arrow-left me-1"></i> Back to List
                </a>
                <a href="{{ url('venue/edit_seating', $data->id) }}" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-edit me-1"></i> Edit Seating
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
