<?php $page = 'eventtype/update'; ?>
@extends('admin.layout.app')

@section('page_title', 'Edit Event Type')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('eventtype/list') }}">Event Types</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Event Type</li>
@endsection

@section('admin_content')

@include('admin.partials.user_form_styles')

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body text-center">
                <div class="preview-icon-wrap mb-3">
                    <div class="preview-icon bg-primary-transparent text-primary mx-auto">
                        <i class="fe fe-layers"></i>
                    </div>
                </div>
                <h5 class="main-profile-name mb-1" id="preview-name">{{ $data->event_type_name ?? 'Event Type' }}</h5>
                <p class="main-profile-name-text text-muted mb-2">Event Type</p>
                <span class="badge {{ $data->is_active == 1 ? 'bg-success-transparent' : 'bg-warning-transparent' }}" id="preview-status-badge">
                    {{ $data->is_active == 1 ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Type Preview</div>
                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="fe fe-tag"></i>
                        </div>
                        <div class="media-body">
                            <span>Type Name</span>
                            <div id="preview-type-name">{{ $data->event_type_name ?? 'Not set yet' }}</div>
                        </div>
                    </div>
                    <div class="media mb-0">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="fe fe-check-circle"></i>
                        </div>
                        <div class="media-body">
                            <span>Status</span>
                            <div id="preview-status">{{ $data->is_active == 1 ? 'Active' : 'Inactive' }}</div>
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

                <form class="form-horizontal" action="{{ url('eventtype/update') }}" method="POST" id="eventtype-edit-form">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">

                    <div class="mb-4 main-content-label">Basic Information</div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="event_type_name">Event Type Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-tag"></i></span>
                            <input type="text"
                                class="form-control @error('event_type_name') is-invalid @enderror"
                                name="event_type_name"
                                id="event_type_name"
                                placeholder="Enter event type name"
                                value="{{ old('event_type_name', $data->event_type_name) }}"
                                maxlength="255"
                                required>
                        </div>
                        @error('event_type_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label d-block">Status</label>
                        <div class="d-flex align-items-center justify-content-between border rounded px-3" style="min-height: 38px;">
                            <span class="tx-13 fw-semibold">Active</span>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active_switch"
                                    {{ old('is_active', $data->is_active) == 1 ? 'checked' : '' }}>
                                <input type="hidden" name="is_active" id="is_active" value="{{ old('is_active', $data->is_active) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-field-label d-block">Show in Header Menu</label>
                        <div class="d-flex align-items-center justify-content-between border rounded px-3" style="min-height: 38px;">
                            <span class="tx-13 text-muted">Display this event type in the website header navigation</span>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_header_menu_switch"
                                    {{ old('is_header_menu', $data->is_header_menu ?? 0) == 1 ? 'checked' : '' }}>
                                <input type="hidden" name="is_header_menu" id="is_header_menu" value="{{ old('is_header_menu', $data->is_header_menu ?? 0) }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url('eventtype/list') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="eventtype-edit-form" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-save me-1"></i> Update Event Type
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
jQuery(document).ready(function ($) {
    function updatePreview() {
        const name = $('#event_type_name').val().trim();
        const isActive = $('#is_active_switch').is(':checked');

        $('#preview-name').text(name || 'Event Type');
        $('#preview-type-name').text(name || 'Not set yet');
        $('#preview-status').text(isActive ? 'Active' : 'Inactive');
        $('#preview-status-badge')
            .text(isActive ? 'Active' : 'Inactive')
            .toggleClass('bg-success-transparent', isActive)
            .toggleClass('bg-warning-transparent', !isActive);
    }

    $('#is_active_switch').on('change', function () {
        $('#is_active').val(this.checked ? '1' : '0');
        updatePreview();
    });

    $('#is_header_menu_switch').on('change', function () {
        $('#is_header_menu').val(this.checked ? '1' : '0');
    });

    $('#event_type_name').on('input', updatePreview);
});
</script>
@endpush
