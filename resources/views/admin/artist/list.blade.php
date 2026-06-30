<?php $page = 'admin/artist/list'; ?>
@extends('admin.layout.app')

@section('page_title', 'Artists')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Artists</li>
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

    .artist-filters {
        background: #f8f9fc;
        border: 1px solid #e8ebf3;
        border-radius: 8px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .artist-filters .form-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #6c757d;
        margin-bottom: 0.35rem;
    }

    .artist-filters .filter-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: nowrap;
    }

    .artist-filters .filter-actions .btn {
        white-space: nowrap;
    }

    .artist-header-actions {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        flex-shrink: 0;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
</style>

@php
    $artistExportTitle = 'Artists (' . now()->format('d M Y') . ')';
    $artistExportButtons = [
        [
            'extend' => 'excel',
            'exportOptions' => [
                'columns' => [0, 1, 2, 3, 4, 5, 6],
                'stripHtml' => true,
            ],
            'title' => $artistExportTitle,
        ],
        [
            'extend' => 'pdf',
            'exportOptions' => [
                'columns' => [0, 1, 2, 3, 4, 5, 6],
                'stripHtml' => true,
            ],
            'title' => $artistExportTitle,
            'orientation' => 'landscape',
            'pageSize' => 'A4',
        ],
    ];
    $artistDatatableOptions = [
        'language' => [
            'search' => 'Search artists:',
            'searchPlaceholder' => 'Search artists...',
            'lengthMenu' => 'Show _MENU_ artists per page',
            'info' => 'Showing _START_ to _END_ of _TOTAL_ artists',
            'infoEmpty' => 'No artists found',
            'infoFiltered' => '(filtered from _MAX_ total artists)',
            'zeroRecords' => 'No matching artists found',
        ],
        'columnDefs' => [
            ['orderable' => false, 'targets' => [7]],
            ['searchable' => false, 'targets' => [0, 7]],
        ],
    ];
@endphp

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mg-b-10">Artists</h4>
                        <p class="text-muted tx-12 mb-0">Manage registered artists and their fields.</p>
                    </div>
                    <div class="artist-header-actions">
                        <span class="badge bg-primary-transparent tx-13">{{ count($data) }} {{ Str::plural('artist', count($data)) }}</span>
                        <button type="button" class="btn btn-sm btn-success" id="artist-export-excel">
                            <i class="fe fe-download me-1"></i> Excel
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" id="artist-export-pdf">
                            <i class="fe fe-file-text me-1"></i> PDF
                        </button>
                        <a href="{{ url('admin/artist/create') }}" class="btn btn-primary btn-sm">
                            <i class="fe fe-plus me-1"></i> Create Artist
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ url('admin/artist/list') }}" class="artist-filters">
                    <div class="row g-3 align-items-end">
                        <div class="col-xl-2 col-md-3">
                            <label class="form-label" for="status">Status</label>
                            <select name="status" id="status" class="form-control form-select">
                                <option value="all" @selected(($filters['status'] ?? 'all') === 'all')>All</option>
                                <option value="1" @selected(($filters['status'] ?? '') === '1')>Active</option>
                                <option value="0" @selected(($filters['status'] ?? '') === '0')>Inactive</option>
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-3">
                            <label class="form-label" for="field">Artist Field</label>
                            <select name="field" id="field" class="form-control form-select">
                                <option value="all" @selected(($filters['field'] ?? 'all') === 'all')>All</option>
                                @foreach ($artistFields as $artistField)
                                    <option value="{{ $artistField->id }}" @selected(($filters['field'] ?? '') == $artistField->id)>
                                        {{ $artistField->field_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-3 col-md-4">
                            <label class="form-label" for="search">Search</label>
                            <input type="text" name="search" id="search" class="form-control"
                                value="{{ $filters['search'] ?? '' }}"
                                placeholder="Name, field, phone, or about">
                        </div>
                        <div class="col-xl-3 col-md-5">
                            <label class="form-label">Registered Date</label>
                            <div class="d-flex gap-2">
                                <input type="date" name="registered_from" class="form-control"
                                    value="{{ $filters['registered_from'] ?? '' }}" aria-label="Registered from">
                                <input type="date" name="registered_to" class="form-control"
                                    value="{{ $filters['registered_to'] ?? '' }}" aria-label="Registered to">
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-12">
                            <label class="form-label d-block">&nbsp;</label>
                            <div class="filter-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fe fe-filter me-1"></i> Apply
                                </button>
                                <a href="{{ url('admin/artist/list') }}" class="btn btn-outline-secondary">Clear</a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap mb-0 dataTables" id="file-datatable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Artist Name</th>
                                <th>Artist Field</th>
                                <th>Contact Number</th>
                                <th>About</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $val)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><span class="font-weight-semibold">{{ $val->artist_name ?? 'N/A' }}</span></td>
                                    <td>{{ $val->field_name ?? 'N/A' }}</td>
                                    <td>{{ $val->contact_number ?: '-' }}</td>
                                    <td>{{ $val->about ? Str::limit($val->about, 50) : '-' }}</td>
                                    <td>
                                        <span class="badge {{ $val->is_active == 1 ? 'bg-success-transparent' : 'bg-secondary-transparent' }}">
                                            {{ $val->is_active == 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($val->created_at)
                                            {{ $val->created_at->format('d M Y') }}
                                            <span class="d-block text-muted tx-12">{{ $val->created_at->format('h:i A') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="table-action d-flex justify-content-end gap-1">
                                            <a href="{{ url('admin/artist/view', $val->id) }}" class="btn btn-sm btn-info-light" title="View">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <a href="{{ url('admin/artist/edit', $val->id) }}" class="btn btn-sm btn-success-light" title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <form action="{{ url('admin/artist/destroy', $val->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this artist?');">
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
                                    <td class="text-center text-muted py-4">-</td>
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
    $datatableOptions = $artistDatatableOptions;
@endphp
@include('datatable.datatable_js')
@include('admin.artist.partials.export_scripts')
@endpush
