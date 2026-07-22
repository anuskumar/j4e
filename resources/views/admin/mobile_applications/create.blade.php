<?php $page = 'mobile-applications'; ?>
@extends('admin.layout.app')

@section('page_title', 'Add Mobile Application')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.mobile-applications.index') }}">Mobile Applications</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add</li>
@endsection

@section('admin_content')
@include('admin.partials.user_form_styles')

<div class="row row-sm justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Add Mobile Application</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.mobile-applications.store') }}" method="POST" id="mobile-application-form">
                    @csrf
                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="name">Application Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-smartphone"></i></span>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}"
                                placeholder="Enter mobile application name" maxlength="255" required>
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-field-label d-block">Status</label>
                        <div class="d-flex align-items-center justify-content-between border rounded px-3" style="min-height: 38px;">
                            <span class="tx-13 fw-semibold">Active</span>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" id="is_active_switch"
                                    {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                <input type="hidden" name="is_active" id="is_active" value="{{ old('is_active', '1') }}">
                            </div>
                        </div>
                        @error('is_active')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.mobile-applications.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="mobile-application-form" class="btn btn-primary">
                    <i class="fe fe-save me-1"></i> Add Application
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
jQuery(document).ready(function ($) {
    $('#is_active_switch').on('change', function () {
        $('#is_active').val(this.checked ? '1' : '0');
    });
});
</script>
@endpush
