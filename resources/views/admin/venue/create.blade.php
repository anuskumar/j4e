<?php $page = 'venue/create'; ?>
@extends('admin.layout.app')

@section('page_title', 'Create Venue')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('venue/list') }}">Venues</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Venue</li>
@endsection

@section('admin_content')

<link href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

<style>
    .form-field-label {
        font-weight: 600;
        margin-bottom: 0.35rem;
    }

    .form-field-hint {
        font-size: 12px;
        color: #6c757d;
        margin-top: 0.35rem;
    }

    .input-group-text {
        background: #f8f9fc;
        border-color: #e8ebf3;
        min-width: 42px;
        justify-content: center;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-bg-color, #6259ca);
        box-shadow: 0 0 0 0.2rem rgba(98, 89, 202, 0.15);
    }

    .event-image-upload {
        position: relative;
        display: inline-block;
        width: 100%;
        max-width: 220px;
        margin: 0 auto;
    }

    .event-image-upload .event-preview-img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e8ebf3;
        background: #f8f9fc;
        display: block;
    }

    .event-image-upload .event-image-edit {
        position: absolute;
        bottom: 8px;
        right: 8px;
        width: 32px;
        height: 32px;
        line-height: 32px;
        border-radius: 50%;
        background: #fff;
        border: 1px solid #e8ebf3;
        text-align: center;
        cursor: pointer;
        color: #6c757d;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
        margin: 0;
    }

    .event-image-upload .event-image-edit:hover {
        color: var(--primary-bg-color, #6259ca);
    }

    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single {
        border-color: #e8ebf3 !important;
        min-height: 38px;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: var(--primary-bg-color, #6259ca) !important;
    }

    .form-section-spacer {
        margin-bottom: 1.75rem;
    }
</style>

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body text-center">
                <div class="event-image-upload mb-3">
                    <img alt="Venue image preview"
                        id="venue-image-preview"
                        class="event-preview-img"
                        src="{{ asset('assets/img/default-venue.jpg') }}"
                        onerror="this.onerror=null;this.src='{{ asset('assets/img/default-event.jpg') }}';">
                    <label for="image" class="fas fa-camera event-image-edit mb-0" title="Upload venue image"></label>
                </div>
                <h5 class="main-profile-name mb-1" id="preview-venue-name">New Venue</h5>
                <p class="main-profile-name-text text-muted mb-2">Venue Details</p>
                <p class="form-field-hint mb-0" id="venue-image-file-name">JPG, PNG or WEBP — recommended 800×600px</p>
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Venue Preview</div>
                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="fe fe-layers"></i>
                        </div>
                        <div class="media-body">
                            <span>Venue Type</span>
                            <div id="preview-venue-type">Not selected</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="fe fe-map-pin"></i>
                        </div>
                        <div class="media-body">
                            <span>Location</span>
                            <div id="preview-location">Not selected</div>
                        </div>
                    </div>
                    <div class="media mb-0">
                        <div class="media-icon bg-info-transparent text-info">
                            <i class="fe fe-map"></i>
                        </div>
                        <div class="media-body">
                            <span>Coordinates</span>
                            <div id="preview-coordinates">Not set yet</div>
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

                <form class="form-horizontal" action="{{ url('venue/store') }}" method="POST" id="venue-create-form" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="image" id="image" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp">

                    <div class="mb-4 main-content-label">Basic Information</div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="name">Venue Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-home"></i></span>
                            <input type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                name="name"
                                id="name"
                                placeholder="Enter venue name"
                                value="{{ old('name') }}"
                                maxlength="255"
                                required>
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 form-section-spacer">
                        <div class="col-md-6">
                            <label class="form-field-label" for="venue_type">Venue Type <span class="text-danger">*</span></label>
                            <select name="venue_type" id="venue_type" class="form-control select2-single @error('venue_type') is-invalid @enderror" required>
                                <option value="">Select venue type</option>
                                @foreach ($venue_type as $type)
                                    <option value="{{ $type->id }}" {{ old('venue_type') == $type->id ? 'selected' : '' }}>
                                        {{ $type->venue_type_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('venue_type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-field-label" for="location">Location <span class="text-danger">*</span></label>
                            <select name="location" id="location" class="form-control select2-single @error('location') is-invalid @enderror" required>
                                <option value="">Select location</option>
                                @foreach ($location as $loc)
                                    <option value="{{ $loc->id }}"
                                        {{ old('location') == $loc->id ? 'selected' : '' }}
                                        data-label="{{ $loc->location_name }}, {{ $loc->name }}, {{ $loc->country_name }}">
                                        {{ $loc->location_name }}, {{ $loc->name }}, {{ $loc->country_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('location')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4 main-content-label">Map Details</div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="google_map_link">Google Map Link</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-link"></i></span>
                            <input type="url"
                                class="form-control @error('google_map_link') is-invalid @enderror"
                                name="google_map_link"
                                id="google_map_link"
                                placeholder="https://maps.google.com/..."
                                value="{{ old('google_map_link') }}">
                        </div>
                        @error('google_map_link')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 form-section-spacer">
                        <div class="col-md-6">
                            <label class="form-field-label" for="latitude">Latitude</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fe fe-navigation"></i></span>
                                <input type="number"
                                    step="0.000001"
                                    class="form-control @error('latitude') is-invalid @enderror"
                                    name="latitude"
                                    id="latitude"
                                    placeholder="Enter latitude"
                                    value="{{ old('latitude') }}">
                            </div>
                            @error('latitude')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-field-label" for="longitude">Longitude</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fe fe-navigation"></i></span>
                                <input type="number"
                                    step="0.000001"
                                    class="form-control @error('longitude') is-invalid @enderror"
                                    name="longitude"
                                    id="longitude"
                                    placeholder="Enter longitude"
                                    value="{{ old('longitude') }}">
                            </div>
                            @error('longitude')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url('venue/list') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="venue-create-form" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-save me-1"></i> Create Venue
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('admin_assets/plugins/select2/js/select2.min.js') }}"></script>
<script>
jQuery(document).ready(function ($) {
    const defaultImage = @json(asset('assets/img/default-venue.jpg'));
    const fallbackImage = @json(asset('assets/img/default-event.jpg'));

    $('.select2-single').select2({
        width: '100%',
        allowClear: true,
        placeholder: 'Select an option'
    });

    function updatePreview() {
        const name = $('#name').val().trim();
        const venueType = $('#venue_type option:selected').text().trim();
        const locationOption = $('#location option:selected');
        const locationLabel = locationOption.data('label') || locationOption.text().trim();
        const latitude = $('#latitude').val();
        const longitude = $('#longitude').val();

        $('#preview-venue-name').text(name || 'New Venue');
        $('#preview-venue-type').text(venueType && venueType !== 'Select venue type' ? venueType : 'Not selected');
        $('#preview-location').text(locationLabel && locationLabel !== 'Select location' ? locationLabel : 'Not selected');

        if (latitude && longitude) {
            $('#preview-coordinates').text(latitude + ', ' + longitude);
        } else if (latitude || longitude) {
            $('#preview-coordinates').text((latitude || longitude));
        } else {
            $('#preview-coordinates').text('Not set yet');
        }
    }

    function handleImageFile(file) {
        if (!file || !file.type.startsWith('image/')) {
            return;
        }

        if (file.size > 4 * 1024 * 1024) {
            alert('Venue image must not exceed 4MB.');
            $('#image').val('');
            $('#venue-image-preview').attr('src', defaultImage);
            $('#venue-image-file-name').text('JPG, PNG or WEBP — recommended 800×600px');
            return;
        }

        $('#venue-image-file-name').text(file.name);
        const reader = new FileReader();
        reader.onload = function (event) {
            $('#venue-image-preview').attr('src', event.target.result);
        };
        reader.readAsDataURL(file);
    }

    $('#image').on('change', function () {
        handleImageFile(this.files[0]);
    });

    $('#venue-image-preview').on('error', function () {
        if (this.src !== fallbackImage) {
            this.src = fallbackImage;
        }
    });

    $('#name, #latitude, #longitude').on('input change', updatePreview);
    $('#venue_type, #location').on('change', updatePreview);
    updatePreview();
});
</script>
@endpush
