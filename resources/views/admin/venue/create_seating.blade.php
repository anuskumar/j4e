<?php $page = 'venue/create_seating'; ?>
@extends('admin.layout.app')

@section('page_title', 'Create Seating')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('venue/list') }}">Venues</a></li>
    <li class="breadcrumb-item"><a href="{{ url('venue/manage_Seating', $venue->id) }}">Manage Seating</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Seating</li>
@endsection

@section('admin_content')

@include('admin.partials.user_form_styles')

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body text-center">
                <div class="event-image-upload mb-3">
                    <img alt="Seating preview"
                        id="seating-image-preview"
                        class="event-preview-img"
                        src="{{ asset('assets/img/default-seating.jpg') }}"
                        onerror="this.onerror=null;this.src='{{ asset('assets/img/default-event.jpg') }}';">
                    <label for="seating_image" class="fas fa-camera event-image-edit mb-0" title="Upload seating image"></label>
                </div>
                <h5 class="main-profile-name mb-1" id="preview-seating-name">New Seating</h5>
                <p class="main-profile-name-text text-muted mb-2">{{ $venue->name }}</p>
                <span class="badge bg-success-transparent" id="preview-status-badge">Active</span>
                <p class="form-field-hint mb-0 mt-2" id="seating-image-file-name">JPG, PNG or WEBP — max 2MB</p>
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Seating Preview</div>
                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="fe fe-grid"></i>
                        </div>
                        <div class="media-body">
                            <span>Seating Type</span>
                            <div id="preview-name">Not set yet</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="fe fe-users"></i>
                        </div>
                        <div class="media-body">
                            <span>Total Seats</span>
                            <div id="preview-seats">Not set yet</div>
                        </div>
                    </div>
                    <div class="media mb-0">
                        <div class="media-icon bg-info-transparent text-info">
                            <i class="fe fe-hash"></i>
                        </div>
                        <div class="media-body">
                            <span>Serial Range</span>
                            <div id="preview-serial">Not set yet</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="form-horizontal" action="{{ url('venue/store_seating') }}" method="POST" id="seating-create-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="venue" value="{{ $venue->id }}">
                    <input type="file" name="seating_image" id="seating_image" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp">

                    <div class="mb-4 main-content-label">Basic Information</div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="seating_type_name">Seating Type Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-grid"></i></span>
                            <input type="text"
                                class="form-control @error('seating_type_name') is-invalid @enderror"
                                name="seating_type_name"
                                id="seating_type_name"
                                placeholder="e.g. VIP, General Admission"
                                value="{{ old('seating_type_name') }}"
                                maxlength="255"
                                required>
                        </div>
                        @error('seating_type_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 form-section-spacer">
                        <div class="col-md-6">
                            <label class="form-field-label" for="number_of_seats">Total Seats <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fe fe-users"></i></span>
                                <input type="number"
                                    min="1"
                                    class="form-control @error('number_of_seats') is-invalid @enderror"
                                    name="number_of_seats"
                                    id="number_of_seats"
                                    placeholder="Enter total seats"
                                    value="{{ old('number_of_seats') }}"
                                    required>
                            </div>
                            @error('number_of_seats')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-field-label" for="seat_serial_prefix">Seat Serial Prefix <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fe fe-hash"></i></span>
                                <input type="text"
                                    class="form-control @error('seat_serial_prefix') is-invalid @enderror"
                                    name="seat_serial_prefix"
                                    id="seat_serial_prefix"
                                    placeholder="e.g. A, VIP"
                                    value="{{ old('seat_serial_prefix') }}"
                                    required>
                            </div>
                            @error('seat_serial_prefix')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 form-section-spacer">
                        <div class="col-md-6">
                            <label class="form-field-label" for="seat_serial_start">Serial Start <span class="text-danger">*</span></label>
                            <input type="number"
                                min="1"
                                class="form-control @error('seat_serial_start') is-invalid @enderror"
                                name="seat_serial_start"
                                id="seat_serial_start"
                                placeholder="Starting number"
                                value="{{ old('seat_serial_start', 1) }}"
                                required>
                            @error('seat_serial_start')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-field-label" for="seat_serial_end">Serial End <span class="text-danger">*</span></label>
                            <input type="number"
                                min="1"
                                class="form-control @error('seat_serial_end') is-invalid @enderror"
                                name="seat_serial_end"
                                id="seat_serial_end"
                                placeholder="Ending number"
                                value="{{ old('seat_serial_end') }}"
                                required>
                            @error('seat_serial_end')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="seating_type_desc">Description</label>
                        <textarea class="form-control @error('seating_type_desc') is-invalid @enderror"
                            name="seating_type_desc"
                            id="seating_type_desc"
                            rows="3"
                            placeholder="Optional description">{{ old('seating_type_desc') }}</textarea>
                        @error('seating_type_desc')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-field-label d-block">Status</label>
                        <div class="d-flex align-items-center justify-content-between border rounded px-3" style="min-height: 38px;">
                            <span class="tx-13 fw-semibold">Active</span>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active_switch"
                                    {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                <input type="hidden" name="is_active" id="is_active" value="{{ old('is_active', '1') }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url('venue/manage_Seating', $venue->id) }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="seating-create-form" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-save me-1"></i> Create Seating
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
jQuery(document).ready(function ($) {
    const defaultImage = @json(asset('assets/img/default-seating.jpg'));

    function updatePreview() {
        const name = $('#seating_type_name').val().trim();
        const seats = $('#number_of_seats').val();
        const prefix = $('#seat_serial_prefix').val().trim();
        const start = $('#seat_serial_start').val();
        const end = $('#seat_serial_end').val();
        const isActive = $('#is_active_switch').is(':checked');

        $('#preview-seating-name').text(name || 'New Seating');
        $('#preview-name').text(name || 'Not set yet');
        $('#preview-seats').text(seats || 'Not set yet');
        $('#preview-serial').text(prefix && start && end ? prefix + start + ' - ' + prefix + end : 'Not set yet');
        $('#preview-status-badge')
            .text(isActive ? 'Active' : 'Inactive')
            .toggleClass('bg-success-transparent', isActive)
            .toggleClass('bg-warning-transparent', !isActive);
    }

    function autoCalculateEnd() {
        const start = parseInt($('#seat_serial_start').val(), 10);
        const total = parseInt($('#number_of_seats').val(), 10);

        if (start > 0 && total > 0) {
            $('#seat_serial_end').val(start + total - 1);
        }
    }

    function handleImageFile(file) {
        if (!file || !file.type.startsWith('image/')) {
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('Seating image must not exceed 2MB.');
            $('#seating_image').val('');
            $('#seating-image-preview').attr('src', defaultImage);
            $('#seating-image-file-name').text('JPG, PNG or WEBP — max 2MB');
            return;
        }

        $('#seating-image-file-name').text(file.name);
        const reader = new FileReader();
        reader.onload = function (event) {
            $('#seating-image-preview').attr('src', event.target.result);
        };
        reader.readAsDataURL(file);
    }

    $('#is_active_switch').on('change', function () {
        $('#is_active').val(this.checked ? '1' : '0');
        updatePreview();
    });

    $('#seating_image').on('change', function () {
        handleImageFile(this.files[0]);
    });

    $('#number_of_seats, #seat_serial_start').on('input', function () {
        autoCalculateEnd();
        updatePreview();
    });

    $('#seating_type_name, #seat_serial_prefix, #seat_serial_end').on('input', updatePreview);
    autoCalculateEnd();
    updatePreview();
});
</script>
@endpush
