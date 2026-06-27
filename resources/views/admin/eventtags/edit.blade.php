<?php
$page = 'eventtag/update';
$tagImage = $tagdata->tag_image
    ? asset('storage/uploads/event_tag_images/' . $tagdata->tag_image)
    : asset('assets/img/events/event-01.jpg');
?>
@extends('admin.layout.app')

@section('page_title', 'Edit Event Tag')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('eventtags/list') }}">Event Tags</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Event Tag</li>
@endsection

@section('admin_content')

@include('admin.partials.user_form_styles')

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body text-center">
                <div class="event-image-upload mb-3">
                    <img alt="Tag image preview"
                        id="tag-image-preview"
                        class="event-preview-img"
                        src="{{ $tagImage }}"
                        onerror="this.onerror=null;this.src='{{ asset('assets/img/default-event.jpg') }}';">
                    <label for="tag_image" class="fas fa-camera event-image-edit mb-0" title="Upload tag image"></label>
                </div>
                <h5 class="main-profile-name mb-1" id="preview-tag-name">{{ $tagdata->tag_name ?? 'Event Tag' }}</h5>
                <p class="main-profile-name-text text-muted mb-2">Event Tag</p>
                <span class="badge {{ $tagdata->is_active == 1 ? 'bg-success-transparent' : 'bg-warning-transparent' }}" id="preview-status-badge">
                    {{ $tagdata->is_active == 1 ? 'Active' : 'Inactive' }}
                </span>
                <p class="form-field-hint mb-0 mt-2" id="tag-image-file-name">JPG, PNG or WEBP — max 2MB</p>
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Tag Preview</div>
                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="fe fe-tag"></i>
                        </div>
                        <div class="media-body">
                            <span>Tag Name</span>
                            <div id="preview-name">{{ $tagdata->tag_name ?? 'Not set yet' }}</div>
                        </div>
                    </div>
                    <div class="media mb-0">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="fe fe-check-circle"></i>
                        </div>
                        <div class="media-body">
                            <span>Status</span>
                            <div id="preview-status">{{ $tagdata->is_active == 1 ? 'Active' : 'Inactive' }}</div>
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

                <form class="form-horizontal" action="{{ url('eventtags/update') }}" method="POST" id="eventtag-edit-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $tagdata->id }}">
                    <input type="file" name="tag_image" id="tag_image" class="d-none" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">

                    <div class="mb-4 main-content-label">Basic Information</div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="tag_name">Tag Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-tag"></i></span>
                            <input type="text"
                                class="form-control @error('tag_name') is-invalid @enderror"
                                name="tag_name"
                                id="tag_name"
                                placeholder="Enter tag name"
                                value="{{ old('tag_name', $tagdata->tag_name) }}"
                                maxlength="255"
                                required>
                        </div>
                        @error('tag_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-field-label d-block">Status</label>
                        <div class="d-flex align-items-center justify-content-between border rounded px-3" style="min-height: 38px;">
                            <span class="tx-13 fw-semibold">Active</span>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active_switch"
                                    {{ old('is_active', $tagdata->is_active) == 1 ? 'checked' : '' }}>
                                <input type="hidden" name="is_active" id="is_active" value="{{ old('is_active', $tagdata->is_active) }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url('eventtags/list') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="eventtag-edit-form" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-save me-1"></i> Update Event Tag
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
jQuery(document).ready(function ($) {
    const existingImage = @json($tagImage);
    const fallbackImage = @json(asset('assets/img/default-event.jpg'));

    function updatePreview() {
        const name = $('#tag_name').val().trim();
        const isActive = $('#is_active_switch').is(':checked');

        $('#preview-tag-name').text(name || 'Event Tag');
        $('#preview-name').text(name || 'Not set yet');
        $('#preview-status').text(isActive ? 'Active' : 'Inactive');
        $('#preview-status-badge')
            .text(isActive ? 'Active' : 'Inactive')
            .toggleClass('bg-success-transparent', isActive)
            .toggleClass('bg-warning-transparent', !isActive);
    }

    function handleImageFile(file) {
        if (!file || !file.type.startsWith('image/')) return;

        if (file.size > 2 * 1024 * 1024) {
            alert('Tag image must not exceed 2MB.');
            $('#tag_image').val('');
            $('#tag-image-preview').attr('src', existingImage);
            $('#tag-image-file-name').text('JPG, PNG or WEBP — max 2MB');
            return;
        }

        $('#tag-image-file-name').text(file.name);
        const reader = new FileReader();
        reader.onload = function (event) {
            $('#tag-image-preview').attr('src', event.target.result);
        };
        reader.readAsDataURL(file);
    }

    $('#is_active_switch').on('change', function () {
        $('#is_active').val(this.checked ? '1' : '0');
        updatePreview();
    });

    $('#tag_image').on('change', function () {
        handleImageFile(this.files[0]);
    });

    $('#tag-image-preview').on('error', function () {
        if (this.src !== fallbackImage) {
            this.src = fallbackImage;
        }
    });

    $('#tag_name').on('input', updatePreview);
});
</script>
@endpush
