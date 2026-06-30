<?php $page = 'currency/create'; ?>
@extends('admin.layout.app')

@section('page_title', 'Create Currency')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('currency/list') }}">Currency</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Currency</li>
@endsection

@section('admin_content')

@include('admin.partials.user_form_styles')

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body text-center">
                <div class="preview-icon-wrap mb-3">
                    <div class="preview-icon bg-primary-transparent text-primary mx-auto">
                        <i class="fe fe-dollar-sign" id="preview-symbol-icon"></i>
                    </div>
                </div>
                <h5 class="main-profile-name mb-1" id="preview-currency-name">New Currency</h5>
                <p class="main-profile-name-text text-muted mb-2" id="preview-short-name">—</p>
                <span class="badge bg-success-transparent" id="preview-status-badge">Active</span>
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Currency Preview</div>
                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="fe fe-dollar-sign"></i>
                        </div>
                        <div class="media-body">
                            <span>Name</span>
                            <div id="preview-name">Not set yet</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="fe fe-hash"></i>
                        </div>
                        <div class="media-body">
                            <span>Short Name</span>
                            <div id="preview-code">Not set yet</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-info-transparent text-info">
                            <i class="fe fe-trending-up"></i>
                        </div>
                        <div class="media-body">
                            <span>Exchange Rate (1 USD)</span>
                            <div id="preview-rate">Not set yet</div>
                        </div>
                    </div>
                    <div class="media mb-0">
                        <div class="media-icon bg-warning-transparent text-warning">
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

                <form class="form-horizontal" action="{{ url('currency/store') }}" method="POST" id="currency-create-form">
                    @csrf

                    <div class="mb-4 main-content-label">Basic Information</div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="name">Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-dollar-sign"></i></span>
                            <input type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                name="name"
                                id="name"
                                placeholder="Enter currency name"
                                value="{{ old('name') }}"
                                maxlength="255"
                                required>
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="short_name">Short Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-hash"></i></span>
                            <input type="text"
                                class="form-control @error('short_name') is-invalid @enderror"
                                name="short_name"
                                id="short_name"
                                placeholder="e.g. USD, EUR"
                                value="{{ old('short_name') }}"
                                maxlength="10"
                                required>
                        </div>
                        @error('short_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="symbol">Symbol</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-tag"></i></span>
                            <input type="text"
                                class="form-control @error('symbol') is-invalid @enderror"
                                name="symbol"
                                id="symbol"
                                placeholder="e.g. $, €"
                                value="{{ old('symbol') }}"
                                maxlength="10">
                        </div>
                        @error('symbol')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="currency_rate">Exchange Rate with 1 USD <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-trending-up"></i></span>
                            <input type="number"
                                step="0.0001"
                                min="0"
                                class="form-control @error('currency_rate') is-invalid @enderror"
                                name="currency_rate"
                                id="currency_rate"
                                placeholder="Enter exchange rate"
                                value="{{ old('currency_rate') }}"
                                required>
                        </div>
                        <p class="form-field-hint mb-0">Enter the exchange rate relative to 1 USD.</p>
                        @error('currency_rate')
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
                <a href="{{ url('currency/list') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="currency-create-form" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-save me-1"></i> Create Currency
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
        const name = $('#name').val().trim();
        const shortName = $('#short_name').val().trim();
        const symbol = $('#symbol').val().trim();
        const rate = $('#currency_rate').val();
        const isActive = $('#is_active_switch').is(':checked');

        $('#preview-currency-name').text(name || 'New Currency');
        $('#preview-short-name').text(shortName ? (symbol ? shortName + ' (' + symbol + ')' : shortName) : (symbol || '—'));
        $('#preview-name').text(name || 'Not set yet');
        $('#preview-code').text(shortName || 'Not set yet');
        $('#preview-rate').text(rate ? rate : 'Not set yet');
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

    $('#name, #short_name, #symbol, #currency_rate').on('input', updatePreview);
    updatePreview();
});
</script>
@endpush
