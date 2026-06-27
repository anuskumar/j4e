<?php $page = 'slide/create'; ?>
@extends('admin.layout.app')

@section('page_title', 'Create Slide')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('slide/list') }}">Slides</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Slide</li>
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
                    <img alt="Slide image preview"
                        id="slide-image-preview"
                        class="event-preview-img"
                        src="{{ asset('assets/img/events/event-01.jpg') }}"
                        onerror="this.onerror=null;this.src='{{ asset('assets/img/default-event.jpg') }}';">
                    <label for="slide_image" class="fas fa-camera event-image-edit mb-0" title="Upload banner image"></label>
                </div>
                <h5 class="main-profile-name mb-1" id="preview-slide-title">New Slide</h5>
                <p class="main-profile-name-text text-muted mb-2">Banner Slide</p>
                <p class="form-field-hint mb-0" id="slide-image-file-name">JPG, PNG or WEBP — recommended 1500×700px</p>
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Slide Preview</div>
                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="fe fe-file-text"></i>
                        </div>
                        <div class="media-body">
                            <span>Meta Description</span>
                            <div id="preview-meta">Not set yet</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="fe fe-calendar"></i>
                        </div>
                        <div class="media-body">
                            <span>Linked Event</span>
                            <div id="preview-event">Not selected</div>
                        </div>
                    </div>
                    <div class="media mb-0">
                        <div class="media-icon bg-info-transparent text-info">
                            <i class="fe fe-check-circle"></i>
                        </div>
                        <div class="media-body">
                            <span>Status</span>
                            <div id="preview-status">Active</div>
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

                <form class="form-horizontal" action="{{ url('slide/store') }}" method="POST" id="slide-create-form" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="slide_image" id="slide_image" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp">

                    <div class="mb-4 main-content-label">Basic Information</div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="meta_description">Meta Description</label>
                        <div class="input-group">
                            <span class="input-group-text align-items-start pt-2"><i class="fe fe-file-text"></i></span>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                name="meta_description"
                                id="meta_description"
                                rows="4"
                                placeholder="Enter slide meta description">{{ old('meta_description') }}</textarea>
                        </div>
                        @error('meta_description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 form-section-spacer">
                        <div class="col-md-6">
                            <label class="form-field-label" for="event">Linked Event</label>
                            <select name="event" id="event" class="form-control select2-single @error('event') is-invalid @enderror">
                                <option value="">Select event</option>
                                @foreach ($events as $eventItem)
                                    <option value="{{ $eventItem->id }}" {{ old('event') == $eventItem->id ? 'selected' : '' }}>
                                        {{ $eventItem->event_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('event')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-field-label d-block">Status</label>
                            <div class="d-flex align-items-center justify-content-between border rounded px-3" style="min-height: 38px;">
                                <span class="tx-13 fw-semibold">Active</span>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="is_active_switch"
                                        {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                    <input type="hidden" name="is_active" id="is_active" value="{{ old('is_active', '1') }}">
                                </div>
                            </div>
                            @error('is_active')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url('slide/list') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="slide-create-form" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-save me-1"></i> Create Slide
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
    const defaultImage = @json(asset('assets/img/events/event-01.jpg'));
    const fallbackImage = @json(asset('assets/img/default-event.jpg'));

    $('.select2-single').select2({
        width: '100%',
        allowClear: true,
        placeholder: 'Select an option'
    });

    function truncateText(text, limit) {
        if (!text) {
            return 'Not set yet';
        }

        return text.length > limit ? text.substring(0, limit) + '...' : text;
    }

    function updatePreview() {
        const meta = $('#meta_description').val().trim();
        const eventText = $('#event option:selected').text().trim();
        const hasEvent = $('#event').val();
        const isActive = $('#is_active_switch').is(':checked');

        $('#preview-slide-title').text(meta ? truncateText(meta, 40) : 'New Slide');
        $('#preview-meta').text(truncateText(meta, 80));
        $('#preview-event').text(hasEvent ? eventText : 'Not selected');
        $('#preview-status').text(isActive ? 'Active' : 'Inactive');
    }

    function handleImageFile(file) {
        if (!file || !file.type.startsWith('image/')) {
            return;
        }

        if (file.size > 4 * 1024 * 1024) {
            alert('Slide image must not exceed 4MB.');
            $('#slide_image').val('');
            $('#slide-image-preview').attr('src', defaultImage);
            $('#slide-image-file-name').text('JPG, PNG or WEBP — recommended 1500×700px');
            return;
        }

        $('#slide-image-file-name').text(file.name);
        const reader = new FileReader();
        reader.onload = function (event) {
            $('#slide-image-preview').attr('src', event.target.result);
        };
        reader.readAsDataURL(file);
    }

    $('#is_active_switch').on('change', function () {
        $('#is_active').val(this.checked ? '1' : '0');
        updatePreview();
    });

    $('#slide_image').on('change', function () {
        handleImageFile(this.files[0]);
    });

    $('#slide-image-preview').on('error', function () {
        if (this.src !== fallbackImage) {
            this.src = fallbackImage;
        }
    });

    $('#meta_description, #event').on('input change', updatePreview);
    updatePreview();
});
</script>
@endpush
