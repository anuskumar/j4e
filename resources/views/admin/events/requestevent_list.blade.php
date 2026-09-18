<?php $page = 'events/requestlist'; ?>
@extends('admin.layout.app')

@section('page_title', 'Requested Events')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0);">Events</a></li>
    <li class="breadcrumb-item active" aria-current="page">Requested Events</li>
@endsection

@section('admin_content')

@php
    use Illuminate\Support\Str;

    $exportTitle = 'Requested Events (' . now()->format('d M Y') . ')';
    $exportButtons = [
        [
            'extend' => 'excel',
            'exportOptions' => [
                'columns' => [0, 1, 2, 3, 4],
                'stripHtml' => true,
            ],
            'title' => $exportTitle,
        ],
        [
            'extend' => 'pdf',
            'exportOptions' => [
                'columns' => [0, 1, 2, 3, 4],
                'stripHtml' => true,
            ],
            'title' => $exportTitle,
            'orientation' => 'landscape',
            'pageSize' => 'A4',
        ],
    ];
@endphp

<link href="{{ asset('admin_assets/plugins/datatable/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin_assets/plugins/datatable/responsive.dataTables.min.css') }}" rel="stylesheet">

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h4 class="card-title mg-b-10">Requested Events</h4>
                        <p class="text-muted tx-12 mb-0">Event requests submitted by users.</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary-transparent tx-13">
                            {{ count($data) }} {{ Str::plural('request', count($data)) }}
                        </span>
                        <button type="button" class="btn btn-sm btn-success" id="request-export-excel">
                            <i class="fe fe-download me-1"></i> Excel
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" id="request-export-pdf">
                            <i class="fe fe-file-text me-1"></i> PDF
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="file-datatable" class="table table-bordered text-nowrap mb-0 dataTables">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Event Details</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $val)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $val->name ?? '-' }}</td>
                                    <td>{{ $val->email ?? '-' }}</td>
                                    <td class="text-wrap" style="min-width:220px;max-width:420px;">{{ $val->event_details ?? '-' }}</td>
                                    <td>{{ $val->phone ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No requested events found</td>
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
            'search' => 'Search requests:',
            'searchPlaceholder' => 'Search...',
            'lengthMenu' => 'Show _MENU_ requests',
            'info' => 'Showing _START_ to _END_ of _TOTAL_ requests',
            'infoEmpty' => 'No requests found',
            'infoFiltered' => '(filtered from _MAX_ total requests)',
            'zeroRecords' => 'No matching requests found',
        ],
        'columnDefs' => [
            ['orderable' => false, 'targets' => []],
            ['searchable' => false, 'targets' => [0]],
        ],
    ];
@endphp
@include('datatable.datatable_js')
@include('admin.partials.datatable_export_scripts', [
    'exportButtons' => $exportButtons,
    'exportExcelId' => 'request-export-excel',
    'exportPdfId' => 'request-export-pdf',
])
@endpush
