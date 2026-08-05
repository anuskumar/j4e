<?php $page = 'mobile-applications'; ?>
@extends('admin.layout.app')

@section('page_title', 'Mobile Applications')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Mobile Applications</li>
@endsection

@section('admin_content')
<link href="{{ asset('admin_assets/plugins/datatable/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin_assets/plugins/datatable/responsive.dataTables.min.css') }}" rel="stylesheet">

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mg-b-10">Mobile Applications</h4>
                        <p class="text-muted tx-12 mb-0">Manage the applications available when resellers list mobile transfer tickets.</p>
                    </div>
                    <a href="{{ route('admin.mobile-applications.create') }}" class="btn btn-primary btn-sm">
                        <i class="fe fe-plus me-1"></i> Add Mobile Application
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap mb-0 dataTables" id="file-datatable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Application Name</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mobileApplications as $application)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-weight-semibold">{{ $application->name }}</td>
                                    <td>
                                        <span class="badge {{ $application->is_active ? 'bg-success' : 'bg-warning' }}">
                                            {{ $application->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.mobile-applications.show', $application) }}" class="btn btn-sm btn-info-light" title="View">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.mobile-applications.edit', $application) }}" class="btn btn-sm btn-success-light" title="Edit">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.mobile-applications.destroy', $application) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this mobile application?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger-light" title="Delete">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No mobile applications found</td>
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
            'searchPlaceholder' => 'Search applications...',
            'zeroRecords' => 'No matching applications found',
        ],
        'columnDefs' => [
            ['orderable' => false, 'targets' => [3]],
            ['searchable' => false, 'targets' => [0, 3]],
        ],
    ];
@endphp
@include('datatable.datatable_js')
@endpush
