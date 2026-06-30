<?php $page = 'events/list'; ?>
@extends('admin.layout.app')

@section('page_title', 'Events')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0);">Events</a></li>
    <li class="breadcrumb-item active" aria-current="page">Events List</li>
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

    .event-filters {
        background: #f8f9fc;
        border: 1px solid #e8ebf3;
        border-radius: 8px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .event-filters .form-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #6c757d;
        margin-bottom: 0.35rem;
    }

    .event-filters .filter-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: nowrap;
    }

    .event-filters .filter-actions .btn {
        white-space: nowrap;
    }

    .event-thumb {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #e8ebf3;
    }

    .event-header-actions {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        flex-shrink: 0;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
</style>

@php
    $eventExportTitle = 'Events (' . now()->format('d M Y') . ')';
    $eventExportButtons = [
        [
            'extend' => 'excel',
            'exportOptions' => [
                'columns' => [0, 1, 2, 3, 4, 5, 9],
                'stripHtml' => true,
            ],
            'title' => $eventExportTitle,
        ],
        [
            'extend' => 'pdf',
            'exportOptions' => [
                'columns' => [0, 1, 2, 3, 4, 5, 9],
                'stripHtml' => true,
            ],
            'title' => $eventExportTitle,
            'orientation' => 'landscape',
            'pageSize' => 'A4',
        ],
    ];
    $eventDatatableOptions = [
        'language' => [
            'search' => 'Search events:',
            'searchPlaceholder' => 'Search events...',
            'lengthMenu' => 'Show _MENU_ events per page',
            'info' => 'Showing _START_ to _END_ of _TOTAL_ events',
            'infoEmpty' => 'No events found',
            'infoFiltered' => '(filtered from _MAX_ total events)',
            'zeroRecords' => 'No matching events found',
        ],
        'columnDefs' => [
            ['orderable' => false, 'targets' => [6, 7, 8, 10]],
            ['searchable' => false, 'targets' => [0, 6, 7, 8, 10]],
        ],
    ];
@endphp

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mg-b-10">Events</h4>
                        <p class="text-muted tx-12 mb-0">Manage events, timings, and gallery images.</p>
                    </div>
                    <div class="event-header-actions">
                        <span class="badge bg-primary-transparent tx-13">{{ count($data) }} {{ Str::plural('event', count($data)) }}</span>
                        <button type="button" class="btn btn-sm btn-success" id="event-export-excel">
                            <i class="fe fe-download me-1"></i> Excel
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" id="event-export-pdf">
                            <i class="fe fe-file-text me-1"></i> PDF
                        </button>
                        <a href="{{ url('events/create') }}" class="btn btn-primary btn-sm">
                            <i class="fe fe-plus me-1"></i> Create Event
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ url('events/list') }}" class="event-filters">
                    <div class="row g-3 align-items-end">
                        <div class="col-xl-2 col-md-4">
                            <label class="form-label" for="event_type">Event Type</label>
                            <select name="event_type" id="event_type" class="form-control form-select">
                                <option value="">All Types</option>
                                @foreach ($eventTypes as $type)
                                    <option value="{{ $type->id }}" @selected(($filters['event_type'] ?? '') == $type->id)>
                                        {{ $type->event_type_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <label class="form-label" for="location_id">Location</label>
                            <select name="location_id" id="location_id" class="form-control form-select">
                                <option value="">All Locations</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}" @selected(($filters['location_id'] ?? '') == $location->id)>
                                        {{ $location->location_name }}{{ $location->city_name ? ', ' . $location->city_name : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <label class="form-label" for="venue_id">Venue</label>
                            <select name="venue_id" id="venue_id" class="form-control form-select">
                                <option value="">All Venues</option>
                                @foreach ($venues as $venue)
                                    <option value="{{ $venue->id }}" @selected(($filters['venue_id'] ?? '') == $venue->id)>
                                        {{ $venue->venue_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <label class="form-label">Event Date</label>
                            <div class="d-flex gap-2">
                                <input type="date" name="event_date_from" class="form-control" value="{{ $filters['event_date_from'] ?? '' }}" aria-label="Event date from">
                                <input type="date" name="event_date_to" class="form-control" value="{{ $filters['event_date_to'] ?? '' }}" aria-label="Event date to">
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-6">
                            <label class="form-label d-block">&nbsp;</label>
                            <div class="filter-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fe fe-filter me-1"></i> Apply
                                </button>
                                <a href="{{ url('events/list') }}" class="btn btn-outline-secondary">Clear</a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap mb-0 dataTables" id="file-datatable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Event Name</th>
                                <th>Event Type</th>
                                <th>Event Date</th>
                                <th>Location</th>
                                <th>Venue</th>
                                <th>Image</th>
                                <th>Timings</th>
                                <th>Gallery</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $val)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="font-weight-semibold">{{ $val->event_name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-transparent">{{ $val->event_type_name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        @if ($val->event_from_date)
                                            {{ \Carbon\Carbon::parse($val->event_from_date)->format('d M Y') }}
                                            @if ($val->event_to_date)
                                                <span class="d-block text-muted tx-12">to {{ \Carbon\Carbon::parse($val->event_to_date)->format('d M Y') }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $val->location_name ?? '-' }}
                                        @if ($val->city_name || $val->country_name)
                                            <span class="d-block text-muted tx-12">{{ trim(($val->city_name ?? '') . ($val->country_name ? ', ' . $val->country_name : '')) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $val->venue_name ?? '-' }}</td>
                                    <td>
                                        @if ($val->event_image)
                                            <img src="{{ asset('storage/uploads/events/' . $val->event_image) }}"
                                                alt="{{ $val->event_name }}"
                                                class="event-thumb"
                                                onerror="this.src='{{ asset('assets/img/default-event.jpg') }}'">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('events/event_timings', $val->id) }}" class="btn btn-sm btn-primary-light" title="Manage Timings">
                                            <i class="fe fe-clock"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ url('events/multi_images', $val->id) }}" class="btn btn-sm btn-info-light" title="Manage Images">
                                            <i class="fe fe-image"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @if ($val->event_is_active == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="table-action d-flex justify-content-end gap-1">
                                            <a href="{{ url('events/view', $val->id) }}" class="btn btn-sm btn-info-light" title="View">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <a href="{{ url('events/edit', $val->id) }}" class="btn btn-sm btn-success-light" title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <form action="{{ url('events/destroy', $val->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this event?');">
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
                                <tr class="odd">
                                    <td class="text-center text-muted py-4">No events found</td>
                                    <td></td>
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

@endsection

@push('scripts')
@php
    $datatableJqueryLoaded = true;
    $datatableOptions = $eventDatatableOptions;
@endphp
@include('datatable.datatable_js')
@include('admin.events.partials.export_scripts')
@endpush
