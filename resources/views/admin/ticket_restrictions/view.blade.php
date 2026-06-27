<?php $page = 'ticket_restrictions/view'; ?>
@extends('admin.layout.app')

@section('page_title', 'View Ticket Restriction')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('tickets') }}">Tickets</a></li>
    <li class="breadcrumb-item"><a href="{{ url('ticket_restrictions/list') }}">Ticket Restrictions</a></li>
    <li class="breadcrumb-item active" aria-current="page">View Restriction</li>
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
                <h5 class="main-profile-name mb-1">{{ $data->restrictions ?? 'Restriction' }}</h5>
                <p class="main-profile-name-text text-muted mb-2">Ticket Restriction</p>
                @if ($data->is_active == 1)
                    <span class="badge bg-success-transparent">Active</span>
                @else
                    <span class="badge bg-warning-transparent">Inactive</span>
                @endif
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Restriction Details</div>
                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="fe fe-tag"></i>
                        </div>
                        <div class="media-body">
                            <span>Restriction</span>
                            <div>{{ $data->restrictions ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="media mb-0">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="fe fe-check-circle"></i>
                        </div>
                        <div class="media-body">
                            <span>Status</span>
                            <div>{{ $data->is_active == 1 ? 'Active' : 'Inactive' }}</div>
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
                    <label class="form-field-label">Restriction</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fe fe-slash"></i></span>
                        <input type="text" class="form-control view-field" value="{{ $data->restrictions ?? '-' }}" readonly>
                    </div>
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
                <a href="{{ url('ticket_restrictions/list') }}" class="btn btn-outline-secondary">
                    <i class="fe fe-arrow-left me-1"></i> Back to List
                </a>
                <a href="{{ url('ticket_restrictions/edit', $data->id) }}" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-edit me-1"></i> Edit Restriction
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
