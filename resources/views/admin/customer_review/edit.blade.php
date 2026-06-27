<?php $page = 'customer_review/edit'; ?>
@extends('admin.layout.app')

@section('page_title', 'Edit Customer Review')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('customer_review/list') }}">Customer Reviews</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Review</li>
@endsection

@section('admin_content')

@include('admin.partials.user_form_styles')

<style>
    .review-photo-upload .review-preview-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 1px solid #e8ebf3;
        background: #f8f9fc;
    }
</style>

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body text-center">
                <div class="review-photo-upload mb-3">
                    <img alt="{{ $data->customer_name }}" id="review-photo-preview" class="review-preview-img"
                        src="{{ $data->photoUrl() }}"
                        onerror="this.src='{{ asset('assets/img/testimonial/avatar-01.jpg') }}'">
                </div>
                <h5 class="main-profile-name mb-1">{{ $data->customer_name }}</h5>
                <p class="main-profile-name-text text-muted mb-2">{{ $data->subtitle ?: '—' }}</p>
                <span class="badge {{ $data->is_active ? 'bg-success-transparent' : 'bg-warning-transparent' }}">
                    {{ $data->is_active ? 'Active' : 'Inactive' }}
                </span>
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

                <form class="form-horizontal" action="{{ url('customer_review/update') }}" method="POST" id="review-edit-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">

                    <div class="mb-4 main-content-label">Review Details</div>

                    <div class="form-group mb-3">
                        <label class="form-field-label" for="customer_name">Customer Name</label>
                        <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                            name="customer_name" id="customer_name" value="{{ old('customer_name', $data->customer_name) }}" required>
                        @error('customer_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-field-label" for="subtitle">Subtitle / Category</label>
                        <input type="text" class="form-control @error('subtitle') is-invalid @enderror"
                            name="subtitle" id="subtitle" value="{{ old('subtitle', $data->subtitle) }}">
                        @error('subtitle')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-field-label" for="rating">Rating (1–5)</label>
                            <input type="number" step="0.1" min="1" max="5" class="form-control @error('rating') is-invalid @enderror"
                                name="rating" id="rating" value="{{ old('rating', $data->rating) }}" required>
                            @error('rating')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-field-label" for="sort_order">Display Order</label>
                            <input type="number" min="0" class="form-control @error('sort_order') is-invalid @enderror"
                                name="sort_order" id="sort_order" value="{{ old('sort_order', $data->sort_order) }}">
                            @error('sort_order')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-field-label" for="review_content">Review Content</label>
                        <textarea class="form-control @error('review_content') is-invalid @enderror"
                            name="review_content" id="review_content" rows="5" required>{{ old('review_content', $data->review_content) }}</textarea>
                        @error('review_content')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-field-label" for="customer_photo">Customer Photo</label>
                        <input type="file" class="form-control @error('customer_photo') is-invalid @enderror"
                            name="customer_photo" id="customer_photo" accept="image/jpeg,image/png,image/jpg,image/webp">
                        <p class="form-field-hint mb-0">Leave empty to keep the current photo.</p>
                        @error('customer_photo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-field-label d-block">Status</label>
                        <div class="d-flex align-items-center justify-content-between border rounded px-3" style="min-height: 38px;">
                            <span class="tx-13 fw-semibold">Active</span>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active_switch"
                                    {{ old('is_active', $data->is_active ? '1' : '0') == '1' ? 'checked' : '' }}>
                                <input type="hidden" name="is_active" id="is_active" value="{{ old('is_active', $data->is_active ? '1' : '0') }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url('customer_review/list') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="review-edit-form" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-save me-1"></i> Update Review
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

    $('#customer_photo').on('change', function () {
        const file = this.files[0];
        if (!file || !file.type.startsWith('image/')) {
            return;
        }
        const reader = new FileReader();
        reader.onload = function (event) {
            $('#review-photo-preview').attr('src', event.target.result);
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush