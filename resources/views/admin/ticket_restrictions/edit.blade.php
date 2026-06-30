<?php $page = 'ticket_restrictions/edit'; ?>
@extends('admin.layout.app')

@section('page_title', 'Edit Ticket Restriction')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('tickets') }}">Tickets</a></li>
    <li class="breadcrumb-item"><a href="{{ url('ticket_restrictions/list') }}">Ticket Restrictions</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Restriction</li>
@endsection

@section('admin_content')

@include('admin.partials.user_form_styles')

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body text-center">
                <div class="preview-icon-wrap mb-3">
                    <div class="preview-icon bg-primary-transparent text-primary mx-auto">
                        <i class="fe fe-slash"></i>
                    </div>
                </div>
                <h5 class="main-profile-name mb-1" id="preview-name">{{ $data->restrictions ?? 'Restriction' }}</h5>
                <p class="main-profile-name-text text-muted mb-2">Ticket Restriction</p>
                <span class="badge {{ $data->is_active == 1 ? 'bg-success-transparent' : 'bg-warning-transparent' }}" id="preview-status-badge">
                    {{ $data->is_active == 1 ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Restriction Preview</div>
                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="fe fe-tag"></i>
                        </div>
                        <div class="media-body">
                            <span>Restriction</span>
                            <div id="preview-restriction">{{ $data->restrictions ?? 'Not set yet' }}</div>
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

                <form class="form-horizontal" action="{{ url('ticket_restrictions/update') }}" method="POST" id="restriction-edit-form">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">

                    <div class="mb-4 main-content-label">Basic Information</div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="restrictions">Restriction <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-slash"></i></span>
                            <input type="text"
                                class="form-control @error('restrictions') is-invalid @enderror"
                                name="restrictions"
                                id="restrictions"
                                placeholder="Enter restriction name"
                                value="{{ old('restrictions', $data->restrictions) }}"
                                maxlength="255"
                                required>
                        </div>
                        @error('restrictions')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-field-label d-block">Status</label>
                        <div class="d-flex align-items-center justify-content-between border rounded px-3" style="min-height: 38px;">
                            <span class="tx-13 fw-semibold">Active</span>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input"
                                    type="checkbox"
                                    role="switch"
                                    id="is_active_switch"
                                    {{ old('is_active', $data->is_active) == 1 ? 'checked' : '' }}>
                                <input type="hidden" name="is_active" id="is_active" value="{{ old('is_active', $data->is_active) }}">
                            </div>
                        </div>
                        @error('is_active')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url('ticket_restrictions/list') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="restriction-edit-form" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-save me-1"></i> Update Restriction
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
        const name = $('#restrictions').val().trim();
        const isActive = $('#is_active_switch').is(':checked');

        $('#preview-name').text(name || 'Restriction');
        $('#preview-restriction').text(name || 'Not set yet');
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

    $('#restrictions').on('input', updatePreview);
});
</script>
@endpush
