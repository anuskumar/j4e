<?php $page = 'eventtype/list'; ?>
@extends('admin.layout.app')

@section('page_title', 'Event Types')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('events/list') }}">Events</a></li>
    <li class="breadcrumb-item active" aria-current="page">Event Types</li>
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
</style>

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mg-b-10">Event Types</h4>
                        <p class="text-muted tx-12 mb-0">Manage event type categories.</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary-transparent tx-13">{{ count($data) }} {{ Str::plural('type', count($data)) }}</span>
                        <a href="{{ url('eventtype/create') }}" class="btn btn-primary btn-sm">
                            <i class="fe fe-plus me-1"></i> Create Event Type
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap mb-0 dataTables" id="file-datatable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Event Type Name</th>
                                <th>Status</th>
                                <th>Header Menu</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $val)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><span class="font-weight-semibold">{{ $val->event_type_name }}</span></td>
                                    <td>
                                        @if ($val->is_active == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($val->is_header_menu == 1)
                                            <span class="badge bg-info">Visible</span>
                                        @else
                                            <span class="badge bg-secondary">Hidden</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="table-action d-flex justify-content-end gap-1">
                                            <a href="{{ url('eventtype/view', $val->id) }}" class="btn btn-sm btn-info-light" title="View">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <a href="{{ url('eventtype/edit', $val->id) }}" class="btn btn-sm btn-success-light" title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <form action="{{ url('eventtype/destroy', $val->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this event type?');">
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
                                    <td class="text-center text-muted py-4">No event types found</td>
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
            'searchPlaceholder' => 'Search event types...',
            'zeroRecords' => 'No matching event types found',
        ],
        'columnDefs' => [
            ['orderable' => false, 'targets' => [4]],
            ['searchable' => false, 'targets' => [0, 4]],
        ],
    ];
@endphp
@include('datatable.datatable_js')
@endpush
