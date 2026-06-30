<?php $page = 'customer_review/list'; ?>
@extends('admin.layout.app')

@section('page_title', 'Customer Reviews')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Customer Reviews</li>
@endsection

@section('admin_content')

<link href="{{ asset('admin_assets/plugins/datatable/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin_assets/plugins/datatable/responsive.dataTables.min.css') }}" rel="stylesheet">

<style>
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 6px 12px;
        margin-left: 8px;
    }
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 6px 12px;
        margin: 0 8px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary-bg-color, #6259ca) !important;
        color: #fff !important;
        border: none !important;
    }
    .review-thumb {
        width: 48px;
        height: 48px;
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
                        <h4 class="card-title mg-b-10">Customer Reviews</h4>
                        <p class="text-muted tx-12 mb-0">Manage homepage testimonial reviews shown on the public site.</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary-transparent tx-13">{{ count($data) }} {{ Str::plural('review', count($data)) }}</span>
                        <a href="{{ url('customer_review/create') }}" class="btn btn-primary btn-sm">
                            <i class="fe fe-plus me-1"></i> Add Review
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap mb-0 dataTables" id="file-datatable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Photo</th>
                                <th>Customer</th>
                                <th>Subtitle</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $val)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <img alt="{{ $val->customer_name }}" class="review-thumb"
                                            src="{{ $val->photoUrl() }}"
                                            onerror="this.src='{{ asset('assets/img/testimonial/avatar-01.jpg') }}'">
                                    </td>
                                    <td><span class="font-weight-semibold">{{ $val->customer_name }}</span></td>
                                    <td>{{ $val->subtitle ?: '-' }}</td>
                                    <td>{{ number_format($val->rating, 1) }} / 5</td>
                                    <td>
                                        @if ($val->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $val->sort_order }}</td>
                                    <td class="text-end">
                                        <div class="table-action d-flex justify-content-end gap-1">
                                            <a href="{{ url('customer_review/view', $val->id) }}" class="btn btn-sm btn-info-light" title="View">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <a href="{{ url('customer_review/edit', $val->id) }}" class="btn btn-sm btn-success-light" title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <form action="{{ url('customer_review/destroy', $val->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger-light" title="Delete">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted py-4">No customer reviews found</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
@php
    $datatableJqueryLoaded = true;
    $datatableOptions = [
        'language' => [
            'search' => 'Search:',
            'searchPlaceholder' => 'Search reviews...',
            'zeroRecords' => 'No matching reviews found',
        ],
        'columnDefs' => [
            ['orderable' => false, 'targets' => [1, 7]],
            ['searchable' => false, 'targets' => [0, 1, 7]],
        ],
    ];
@endphp
@include('datatable.datatable_js')
@endpush
