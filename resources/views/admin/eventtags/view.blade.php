<?php
$page = 'eventtagsview';
$tagImage = ($data && $data->tag_image)
    ? asset('storage/uploads/event_tag_images/' . $data->tag_image)
    : asset('assets/img/events/event-01.jpg');
?>
@extends('admin.layout.app')

@section('page_title', 'View Event Tag')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('eventtags/list') }}">Event Tags</a></li>
    <li class="breadcrumb-item active" aria-current="page">View Event Tag</li>
@endsection

@section('admin_content')

@include('admin.partials.user_form_styles')

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body text-center">
                <div class="event-image-upload mb-3">
                    <img alt="{{ $data->tag_name ?? 'Tag' }}"
                        class="event-preview-img"
                        src="{{ $tagImage }}"
                        onerror="this.onerror=null;this.src='{{ asset('assets/img/default-event.jpg') }}';">
                </div>
                <h5 class="main-profile-name mb-1">{{ $data->tag_name ?? 'Event Tag' }}</h5>
                <p class="main-profile-name-text text-muted mb-2">Event Tag</p>
                @if ($data && $data->is_active == 1)
                    <span class="badge bg-success-transparent">Active</span>
                @else
                    <span class="badge bg-warning-transparent">Inactive</span>
                @endif
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Tag Details</div>
                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="fe fe-tag"></i>
                        </div>
                        <div class="media-body">
                            <span>Tag Name</span>
                            <div>{{ $data->tag_name ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="media mb-0">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="fe fe-check-circle"></i>
                        </div>
                        <div class="media-body">
                            <span>Status</span>
                            <div>{{ ($data && $data->is_active == 1) ? 'Active' : 'Inactive' }}</div>
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
                    <label class="form-field-label">Tag Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fe fe-tag"></i></span>
                        <input type="text" class="form-control view-field" value="{{ $data->tag_name ?? '-' }}" readonly>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label class="form-field-label d-block">Status</label>
                    <div class="d-flex align-items-center justify-content-between border rounded px-3" style="min-height: 38px;">
                        <span class="tx-13 fw-semibold">Active</span>
                        @if ($data && $data->is_active == 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-warning">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url('eventtags/list') }}" class="btn btn-outline-secondary">
                    <i class="fe fe-arrow-left me-1"></i> Back to List
                </a>
                @if ($data)
                    <a href="{{ url('eventtags/edit', $data->id) }}" class="btn btn-primary waves-effect waves-light">
                        <i class="fe fe-edit me-1"></i> Edit Event Tag
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
