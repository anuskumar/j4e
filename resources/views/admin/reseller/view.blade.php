<?php
$page = 'admin/reseller/view';

$profileImage = ($data && $data->profile)
    ? asset('storage/uploads/images/' . $data->profile)
    : asset('admin_assets/img/faces/6.jpg');
?>
@extends('admin.layout.app')

@section('page_title', 'View Reseller')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('admin/reseller/list') }}">Resellers</a></li>
    <li class="breadcrumb-item active" aria-current="page">View Reseller</li>
@endsection

@section('admin_content')

@include('admin.partials.user_form_styles')

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body text-center">
                <div class="main-profile-overview">
                    <div class="mb-3">
                        <div class="main-img-user profile-user mx-auto">
                            <img alt="{{ $data->name ?? 'Reseller' }}"
                                src="{{ $profileImage }}"
                                onerror="this.src='{{ asset('admin_assets/img/faces/6.jpg') }}'">
                        </div>
                    </div>
                    <h5 class="main-profile-name mb-1">{{ $data->name ?? 'Reseller' }}</h5>
                    <p class="main-profile-name-text text-muted mb-2">Reseller Account</p>
                    @if ($data && $data->is_active == 1)
                        <span class="badge bg-success-transparent mb-2">Active</span>
                    @else
                        <span class="badge bg-warning-transparent mb-2">Inactive</span>
                    @endif
                    @if ($data)
                        @if ($data->is_admin_approved == 1)
                            <span class="badge bg-primary-transparent mb-2">Admin Approved</span>
                        @else
                            <span class="badge bg-secondary-transparent mb-2">Pending Approval</span>
                        @endif
                        @if ($data->is_trusted == 1)
                            <span class="badge bg-info-transparent mb-2">Trusted</span>
                        @endif
                    @endif
                    @if ($data && $data->profile)
                        <p class="profile-file-name mb-0">{{ basename($data->profile) }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Contact Details</div>
                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="icon ion-md-mail"></i>
                        </div>
                        <div class="media-body">
                            <span>Email</span>
                            <div>{{ $data->email ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="icon ion-md-phone-portrait"></i>
                        </div>
                        <div class="media-body">
                            <span>Phone</span>
                            <div>{{ $data->phone ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-info-transparent text-info">
                            <i class="icon ion-md-locate"></i>
                        </div>
                        <div class="media-body">
                            <span>Address</span>
                            <div>{{ $data->address ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($data)
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="main-content-label tx-13 mg-b-25">Account Info</div>
                    <div class="main-profile-contact-list">
                        <div class="media">
                            <div class="media-icon bg-warning-transparent text-warning">
                                <i class="icon ion-md-calendar"></i>
                            </div>
                            <div class="media-body">
                                <span>Registered</span>
                                <div>{{ $data->created_at ? \Carbon\Carbon::parse($data->created_at)->format('d M Y, h:i A') : '-' }}</div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-icon bg-danger-transparent text-danger">
                                <i class="icon ion-md-time"></i>
                            </div>
                            <div class="media-body">
                                <span>Last Login</span>
                                <div>
                                    @if ($data->last_login)
                                        {{ \Carbon\Carbon::parse($data->last_login)->format('d M Y, h:i A') }}
                                    @else
                                        Never
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-4 main-content-label">Personal Information</div>

                <div class="form-group">
                    <label class="form-field-label">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fe fe-user"></i></span>
                        <input type="text" class="form-control view-field" value="{{ $data->name ?? '-' }}" readonly>
                    </div>
                </div>

                <div class="mb-4 main-content-label">Contact Information</div>

                <div class="form-group">
                    <label class="form-field-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fe fe-mail"></i></span>
                        <input type="text" class="form-control view-field" value="{{ $data->email ?? '-' }}" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-field-label">Phone Number</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fe fe-phone"></i></span>
                        <input type="text" class="form-control view-field" value="{{ $data->phone ?? '-' }}" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-field-label">Address</label>
                    <div class="input-group">
                        <span class="input-group-text align-items-start pt-2"><i class="fe fe-map-pin"></i></span>
                        <textarea class="form-control view-field" rows="3" readonly>{{ $data->address ?? '-' }}</textarea>
                    </div>
                </div>

                <div class="mb-4 main-content-label">Reseller Settings</div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-field-label">Admin Approved</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fe fe-check-circle"></i></span>
                                <input type="text" class="form-control view-field" value="{{ ($data && $data->is_admin_approved == 1) ? 'Yes' : 'No' }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-field-label">Trusted Reseller</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fe fe-shield"></i></span>
                                <input type="text" class="form-control view-field" value="{{ ($data && $data->is_trusted == 1) ? 'Yes' : 'No' }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 main-content-label">Account Settings</div>

                <div class="form-group mb-0">
                    <label class="form-field-label d-block">Account Status</label>
                    <div class="d-flex align-items-center justify-content-between border rounded p-3">
                        <div>
                            <div class="fw-semibold">Active account</div>
                        </div>
                        <div>
                            @if ($data && $data->is_active == 1)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-warning">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url('admin/reseller/list') }}" class="btn btn-outline-secondary">
                    <i class="fe fe-arrow-left me-1"></i> Back to List
                </a>
                @if ($data)
                    <a href="{{ url('admin/reseller/edit', $data->id) }}" class="btn btn-primary">
                        <i class="fe fe-edit me-1"></i> Edit Reseller
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
