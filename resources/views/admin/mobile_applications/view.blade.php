<?php $page = 'mobile-applications'; ?>
@extends('admin.layout.app')

@section('page_title', 'View Mobile Application')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.mobile-applications.index') }}">Mobile Applications</a></li>
    <li class="breadcrumb-item active" aria-current="page">View</li>
@endsection

@section('admin_content')
@include('admin.partials.user_form_styles')

<div class="row row-sm justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Mobile Application Details</h4>
            </div>
            <div class="card-body">
                <div class="form-group form-section-spacer">
                    <label class="form-field-label">Application Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fe fe-smartphone"></i></span>
                        <input type="text" class="form-control view-field" value="{{ $mobileApplication->name }}" readonly>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <label class="form-field-label d-block">Status</label>
                    <div class="border rounded px-3 py-2">
                        <span class="badge {{ $mobileApplication->is_active ? 'bg-success' : 'bg-warning' }}">
                            {{ $mobileApplication->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.mobile-applications.index') }}" class="btn btn-outline-secondary">
                    <i class="fe fe-arrow-left me-1"></i> Back to List
                </a>
                <a href="{{ route('admin.mobile-applications.edit', $mobileApplication) }}" class="btn btn-primary">
                    <i class="fe fe-edit me-1"></i> Edit Application
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
