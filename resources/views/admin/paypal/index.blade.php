<?php $page = 'paypal-settings'; ?>
@extends('admin.layout.app')

@section('page_title', 'PayPal Integration')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">PayPal Integration</li>
@endsection

@section('admin_content')

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

    .form-section-spacer {
        margin-bottom: 1.75rem;
    }

    .paypal-status-card {
        border: 1px solid #e8ebf3;
        border-radius: 8px;
        padding: 1.25rem;
        background: #fff;
        height: 100%;
    }

    .paypal-status-card__badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 999px;
    }

    .paypal-status-card__badge.is-active {
        background: rgba(40, 167, 69, 0.12);
        color: #1e7e34;
    }

    .paypal-status-card__badge.is-inactive {
        background: rgba(108, 117, 125, 0.12);
        color: #6c757d;
    }

    .paypal-status-card__badge.is-warning {
        background: rgba(255, 193, 7, 0.15);
        color: #856404;
    }

    .paypal-info-box {
        border-radius: 8px;
        padding: 14px 16px;
        background: rgba(98, 89, 202, 0.06);
        border: 1px solid rgba(98, 89, 202, 0.12);
        font-size: 13px;
        color: #4b5563;
        line-height: 1.6;
    }

    .paypal-info-box i {
        color: var(--primary-bg-color, #6259ca);
    }
</style>

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-20">Integration Status</div>

                @if ($settings->isConfigured())
                    <span class="paypal-status-card__badge is-active mb-3">
                        <i class="fe fe-check-circle"></i> Active &amp; Configured
                    </span>
                @elseif ($settings->is_enabled)
                    <span class="paypal-status-card__badge is-warning mb-3">
                        <i class="fe fe-alert-circle"></i> Enabled — credentials incomplete
                    </span>
                @else
                    <span class="paypal-status-card__badge is-inactive mb-3">
                        <i class="fe fe-pause-circle"></i> Disabled
                    </span>
                @endif

                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="fe fe-layers"></i>
                        </div>
                        <div class="media-body">
                            <span>Environment</span>
                            <div>{{ $settings->modeLabel() }}</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-info-transparent text-info">
                            <i class="fe fe-link"></i>
                        </div>
                        <div class="media-body">
                            <span>API Base URL</span>
                            <div class="text-break" style="font-size: 12px;">{{ $settings->apiBaseUrl() }}</div>
                        </div>
                    </div>
                    <div class="media mb-0">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="fe fe-mail"></i>
                        </div>
                        <div class="media-body">
                            <span>Merchant Email</span>
                            <div>{{ $settings->merchant_email ?: 'Not set' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="paypal-info-box">
            <p class="mb-2"><i class="fe fe-info me-1"></i> <strong>Where to find credentials</strong></p>
            <p class="mb-0">Log in to the <a href="https://developer.paypal.com/dashboard/applications/live" target="_blank" rel="noopener">PayPal Developer Dashboard</a>, create or open your REST app, and copy the Client ID and Secret for sandbox or live mode.</p>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="form-horizontal" action="{{ route('admin.paypal.settings.update') }}" method="POST" id="paypal-settings-form">
                    @csrf

                    <div class="mb-4 main-content-label">PayPal REST API Credentials</div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="client_id">Client ID</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-key"></i></span>
                            <input type="text" class="form-control @error('client_id') is-invalid @enderror"
                                name="client_id" id="client_id"
                                placeholder="PayPal REST API Client ID"
                                value="{{ old('client_id', $settings->client_id) }}">
                        </div>
                        <p class="form-field-hint">From your PayPal Developer app credentials.</p>
                    </div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="client_secret">Client Secret</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-lock"></i></span>
                            <input type="password" class="form-control @error('client_secret') is-invalid @enderror"
                                name="client_secret" id="client_secret"
                                placeholder="{{ $settings->client_secret ? 'Leave blank to keep current secret' : 'PayPal REST API Client Secret' }}"
                                autocomplete="new-password">
                        </div>
                        <p class="form-field-hint">
                            @if ($settings->client_secret)
                                A secret is already saved. Leave this field empty to keep it unchanged.
                            @else
                                Enter the secret from your PayPal Developer app.
                            @endif
                        </p>
                    </div>

                    <div class="row g-3 form-section-spacer">
                        <div class="col-md-6">
                            <label class="form-field-label" for="mode">Environment</label>
                            <select class="form-select @error('mode') is-invalid @enderror" name="mode" id="mode">
                                <option value="sandbox" {{ old('mode', $settings->mode) === 'sandbox' ? 'selected' : '' }}>Sandbox (Testing)</option>
                                <option value="live" {{ old('mode', $settings->mode) === 'live' ? 'selected' : '' }}>Live (Production)</option>
                            </select>
                            <p class="form-field-hint">Use sandbox while testing; switch to live for real payments.</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-field-label" for="merchant_email">Merchant Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fe fe-mail"></i></span>
                                <input type="email" class="form-control @error('merchant_email') is-invalid @enderror"
                                    name="merchant_email" id="merchant_email"
                                    placeholder="business@example.com"
                                    value="{{ old('merchant_email', $settings->merchant_email) }}">
                            </div>
                            <p class="form-field-hint">PayPal business account email (optional, for reference).</p>
                        </div>
                    </div>

                    <div class="mb-4 main-content-label">Advanced</div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="webhook_id">Webhook ID</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-bell"></i></span>
                            <input type="text" class="form-control @error('webhook_id') is-invalid @enderror"
                                name="webhook_id" id="webhook_id"
                                placeholder="Webhook ID from PayPal Developer Dashboard"
                                value="{{ old('webhook_id', $settings->webhook_id) }}">
                        </div>
                        <p class="form-field-hint">Optional. Used to verify PayPal payment notifications.</p>
                    </div>

                    <div class="form-group form-section-spacer mb-0">
                        <label class="form-field-label d-block">Enable PayPal Payments</label>
                        <div class="custom-control custom-switch">
                            <input type="hidden" name="is_enabled" value="0">
                            <input type="checkbox" class="custom-control-input" name="is_enabled" id="is_enabled" value="1"
                                {{ old('is_enabled', $settings->is_enabled) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_enabled">
                                Accept PayPal as a payment method on checkout
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="paypal-settings-form" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-save me-1"></i> Save Settings
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
