<?php $page = 'customer_review/view'; ?>
@extends('admin.layout.app')

@section('page_title', 'View Customer Review')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('customer_review/list') }}">Customer Reviews</a></li>
    <li class="breadcrumb-item active" aria-current="page">View Review</li>
@endsection

@section('admin_content')

<style>
    .review-photo {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 1px solid #e8ebf3;
    }
</style>

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mg-b-10">Customer Review Details</h4>
                        <p class="text-muted tx-12 mb-0">Review shown on the homepage testimonial section.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ url('customer_review/edit', $data->id) }}" class="btn btn-success btn-sm">
                            <i class="far fa-edit me-1"></i> Edit
                        </a>
                        <a href="{{ url('customer_review/list') }}" class="btn btn-outline-secondary btn-sm">Back to List</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center mb-4 mb-md-0">
                        <img alt="{{ $data->customer_name }}" class="review-photo mb-3"
                            src="{{ $data->photoUrl() }}"
                            onerror="this.src='{{ asset('assets/img/testimonial/avatar-01.jpg') }}'">
                        <h5 class="mb-1">{{ $data->customer_name }}</h5>
                        <p class="text-muted mb-2">{{ $data->subtitle ?: '—' }}</p>
                        @if ($data->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-warning">Inactive</span>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    <tr>
                                        <th style="width: 180px;">Rating</th>
                                        <td>{{ number_format($data->rating, 1) }} / 5</td>
                                    </tr>
                                    <tr>
                                        <th>Display Order</th>
                                        <td>{{ $data->sort_order }}</td>
                                    </tr>
                                    <tr>
                                        <th>Review Content</th>
                                        <td>{{ $data->review_content }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created</th>
                                        <td>{{ $data->created_at?->format('M d, Y h:i A') ?: '—' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Updated</th>
                                        <td>{{ $data->updated_at?->format('M d, Y h:i A') ?: '—' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
