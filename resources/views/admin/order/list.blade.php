<?php $page = 'order/list'; ?>
@extends(Auth::user()->user_type == 'reseller' ? 'layouts.reseller_app' : 'admin.layout.app')

@if (Auth::user()->user_type != 'reseller')
    @section('page_title')
        {{ $pageTitle ?? 'Orders' }}
    @endsection

    @section('breadcrumbs')
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.customer.neworder') }}">Orders</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle ?? 'Orders' }}</li>
    @endsection
@endif

@if (Auth::user()->user_type == 'reseller')
    @section('content')
@else
    @section('admin_content')
@endif

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

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5rem 0.75rem;
        margin: 0 2px;
        border-radius: 4px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary-bg-color, #6259ca) !important;
        color: #fff !important;
        border: none !important;
    }

    .dataTables_wrapper .dataTables_info {
        padding-top: 0.75rem;
    }

    .order-filters {
        background: #f8f9fc;
        border: 1px solid #e8ebf3;
        border-radius: 8px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .order-filters .form-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #6c757d;
        margin-bottom: 0.35rem;
    }

    .order-filters .filter-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: nowrap;
    }

    .order-filters .filter-actions .btn {
        white-space: nowrap;
    }
</style>

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mg-b-10">{{ $pageTitle ?? 'Orders' }}</h4>
                        <p class="text-muted tx-12 mb-0">{{ $pageDescription ?? 'Manage customer ticket orders.' }}</p>
                    </div>
                    <span class="badge bg-primary-transparent tx-13">{{ count($data) }} {{ Str::plural('order', count($data)) }}</span>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ $filterAction ?? request()->url() }}" class="order-filters">
                    <div class="row g-3 align-items-end">
                        <div class="col-xl-2 col-md-3">
                            <label class="form-label" for="event_id">Event</label>
                            <select name="event_id" id="event_id" class="form-control form-select">
                                <option value="">All Events</option>
                                @foreach ($events ?? [] as $event)
                                    <option value="{{ $event->id }}" @selected(($filters['event_id'] ?? '') == $event->id)>
                                        {{ $event->event_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-3">
                            <label class="form-label" for="payment_status">Payment Status</label>
                            <select name="payment_status" id="payment_status" class="form-control form-select">
                                <option value="all" @selected(($filters['payment_status'] ?? 'all') === 'all')>All</option>
                                <option value="1" @selected(($filters['payment_status'] ?? '') === '1')>Payment Completed</option>
                                <option value="0" @selected(($filters['payment_status'] ?? '') === '0')>Not Completed</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <label class="form-label">Event Date</label>
                            <div class="d-flex gap-2">
                                <input type="date" name="event_date_from" class="form-control" value="{{ $filters['event_date_from'] ?? '' }}" aria-label="Event date from">
                                <input type="date" name="event_date_to" class="form-control" value="{{ $filters['event_date_to'] ?? '' }}" aria-label="Event date to">
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <label class="form-label">Booking Date</label>
                            <div class="d-flex gap-2">
                                <input type="date" name="booking_date_from" class="form-control" value="{{ $filters['booking_date_from'] ?? '' }}" aria-label="Booking date from">
                                <input type="date" name="booking_date_to" class="form-control" value="{{ $filters['booking_date_to'] ?? '' }}" aria-label="Booking date to">
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-12">
                            <label class="form-label d-block">&nbsp;</label>
                            <div class="filter-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fe fe-filter me-1"></i> Apply
                                </button>
                                <a href="{{ $filterAction ?? request()->url() }}" class="btn btn-outline-secondary">Clear</a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap mb-0 dataTables" id="file-datatable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Event</th>
                                <th>Event Date</th>
                                <th>Booking Date</th>
                                <th>Amount</th>
                                <th>Purchased Date</th>
                                <th>Status</th>
                                <th>Payment Status</th>
                                <th>Customer</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $val)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ url('show_details_show', @$val->event_id) }}" class="font-weight-semibold">
                                            {{ @$val->event_name }}
                                        </a>
                                        <span class="d-block text-muted tx-12">{{ @$val->tag_name }}, {{ @$val->event_type_name }}</span>
                                    </td>
                                    <td>
                                        @if (!empty($val->event_date))
                                            {{ $val->event_date->event_date }}
                                            <span class="d-block text-info tx-12">{{ $val->event_date->event_time }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $val->event_from_date ? \Carbon\Carbon::parse($val->event_from_date)->format('d M Y') : '-' }}</td>
                                    <td>{{ @$val->payment_amount }} {{ @$val->short_name }}</td>
                                    <td>{{ date('d M Y', strtotime(@$val->created_at)) }}</td>
                                    <td>
                                        <span class="badge bg-primary-transparent">{{ @$val->status_name }}</span>
                                    </td>
                                    <td>
                                        @if ($val->is_payment_completed == 1)
                                            <span class="badge bg-success">Payment Completed</span>
                                        @else
                                            <span class="badge bg-warning">Not Completed</span>
                                        @endif
                                    </td>
                                    <td>{{ $val->user_name }}</td>
                                    <td class="text-end">
                                        <div class="table-action d-flex justify-content-end gap-1">
                                            <a href="{{ url('view_invoice', @$val->id) }}" class="btn btn-sm btn-primary-light" title="Invoice">
                                                <i class="far fa-file-alt"></i>
                                            </a>
                                            <a href="{{ url('show_booking_details_show', @$val->id) }}" class="btn btn-sm btn-info-light" title="View">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <a href="{{ url('customer_order/update_order_status', @$val->id) }}" class="btn btn-sm btn-success-light" title="Update Status">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="odd">
                                    <td class="text-center text-muted py-4">-</td>
                                    <td></td>
                                    <td></td>
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

@if (Auth::user()->user_type == 'reseller')
    @php
        $datatableJqueryLoaded = true;
        $datatableOptions = [
            'language' => [
                'search' => 'Search orders:',
                'searchPlaceholder' => 'Search orders...',
                'lengthMenu' => 'Show _MENU_ orders per page',
                'info' => 'Showing _START_ to _END_ of _TOTAL_ orders',
                'infoEmpty' => 'No orders found',
                'infoFiltered' => '(filtered from _MAX_ total orders)',
                'zeroRecords' => 'No matching orders found',
            ],
            'columnDefs' => [
                ['orderable' => false, 'targets' => [9]],
                ['searchable' => false, 'targets' => [0, 9]],
            ],
        ];
    @endphp
    @include('datatable.datatable_js')
@endif

@endsection

@if (Auth::user()->user_type != 'reseller')
@push('scripts')
@php
    $datatableJqueryLoaded = true;
    $datatableOptions = [
        'language' => [
            'search' => 'Search orders:',
            'searchPlaceholder' => 'Search orders...',
            'lengthMenu' => 'Show _MENU_ orders per page',
            'info' => 'Showing _START_ to _END_ of _TOTAL_ orders',
            'infoEmpty' => 'No orders found',
            'infoFiltered' => '(filtered from _MAX_ total orders)',
            'zeroRecords' => 'No matching orders found',
        ],
        'columnDefs' => [
            ['orderable' => false, 'targets' => [9]],
            ['searchable' => false, 'targets' => [0, 9]],
        ],
    ];
@endphp
@include('datatable.datatable_js')
@endpush
@endif
