<?php $page = 'admin/customer/list'; ?>
@extends('admin.layout.app')

@section('page_title', 'Customers')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0);">User Management</a></li>
    <li class="breadcrumb-item active" aria-current="page">Customers</li>
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

    .customer-filters {
        background: #f8f9fc;
        border: 1px solid #e8ebf3;
        border-radius: 8px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .customer-filters .form-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #6c757d;
        margin-bottom: 0.35rem;
    }

    .customer-filters .filter-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: nowrap;
    }

    .customer-filters .filter-actions .btn {
        white-space: nowrap;
    }

    .customer-header-actions {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        flex-shrink: 0;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
</style>

@php
    $customerExportTitle = 'Customers (' . now()->format('d M Y') . ')';
    $customerExportButtons = [
        [
            'extend' => 'excel',
            'exportOptions' => [
                'columns' => [0, 1, 2, 3, 4, 5, 6],
                'stripHtml' => true,
            ],
            'title' => $customerExportTitle,
        ],
        [
            'extend' => 'pdf',
            'exportOptions' => [
                'columns' => [0, 1, 2, 3, 4, 5, 6],
                'stripHtml' => true,
            ],
            'title' => $customerExportTitle,
            'orientation' => 'landscape',
            'pageSize' => 'A4',
        ],
    ];
    $customerDatatableOptions = [
        'language' => [
            'search' => 'Search customers:',
            'searchPlaceholder' => 'Search customers...',
            'lengthMenu' => 'Show _MENU_ customers per page',
            'info' => 'Showing _START_ to _END_ of _TOTAL_ customers',
            'infoEmpty' => 'No customers found',
            'infoFiltered' => '(filtered from _MAX_ total customers)',
            'zeroRecords' => 'No matching customers found',
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
                        <h4 class="card-title mg-b-10">Customers</h4>
                        <p class="text-muted tx-12 mb-0">Manage and view all registered customers.</p>
                    </div>
                    <div class="customer-header-actions">
                        <span class="badge bg-primary-transparent tx-13">{{ count($data) }} {{ Str::plural('customer', count($data)) }}</span>
                        <button type="button" class="btn btn-sm btn-success" id="customer-export-excel">
                            <i class="fe fe-download me-1"></i> Excel
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" id="customer-export-pdf">
                            <i class="fe fe-file-text me-1"></i> PDF
                        </button>
                        <button type="button" class="btn btn-sm btn-info" id="customer-send-email-btn"
                            @disabled(count($data) === 0)>
                            <i class="fe fe-mail me-1"></i> Send Email
                        </button>
                        <a href="{{ url('admin/customer/create') }}" class="btn btn-primary btn-sm">
                            <i class="fe fe-plus me-1"></i> Create Customer
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ url('admin/customer/list') }}" class="customer-filters">
                    <div class="row g-3 align-items-end">
                        <div class="col-xl-2 col-md-3">
                            <label class="form-label" for="status">Status</label>
                            <select name="status" id="status" class="form-control form-select">
                                <option value="all" @selected(($filters['status'] ?? 'all') === 'all')>All</option>
                                <option value="1" @selected(($filters['status'] ?? '') === '1')>Active</option>
                                <option value="0" @selected(($filters['status'] ?? '') === '0')>Inactive</option>
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <label class="form-label" for="search">Search</label>
                            <input type="text" name="search" id="search" class="form-control"
                                value="{{ $filters['search'] ?? '' }}"
                                placeholder="Name, email, phone, or address">
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
                        <div class="col-xl-3 col-md-5">
                            <label class="form-label">Last Login</label>
                            <div class="d-flex gap-2">
                                <input type="date" name="last_login_from" class="form-control"
                                    value="{{ $filters['last_login_from'] ?? '' }}" aria-label="Last login from">
                                <input type="date" name="last_login_to" class="form-control"
                                    value="{{ $filters['last_login_to'] ?? '' }}" aria-label="Last login to">
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-12">
                            <label class="form-label d-block">&nbsp;</label>
                            <div class="filter-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fe fe-filter me-1"></i> Apply
                                </button>
                                <a href="{{ url('admin/customer/list') }}" class="btn btn-outline-secondary">Clear</a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap mb-0 dataTables" id="file-datatable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Last Login</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $val)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="font-weight-semibold">{{ $val->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>{{ $val->email ?? 'N/A' }}</td>
                                    <td>{{ $val->phone ?: '-' }}</td>
                                    <td>{{ $val->address ? Str::limit($val->address, 40) : '-' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <span class="badge {{ $val->is_active == 1 ? 'bg-success-transparent' : 'bg-secondary-transparent' }}">
                                                {{ $val->is_active == 1 ? 'Active' : 'Inactive' }}
                                            </span>
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input status-toggle" type="checkbox"
                                                    data-id="{{ $val->id }}"
                                                    id="status_{{ $val->id }}"
                                                    {{ $val->is_active == 1 ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($val->last_login)
                                            {{ date('d M Y', strtotime($val->last_login)) }}
                                            <span class="d-block text-muted tx-12">{{ date('h:i A', strtotime($val->last_login)) }}</span>
                                        @else
                                            <span class="text-muted">Never</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="table-action d-flex justify-content-end gap-1">
                                            <a href="{{ url('admin/customer/view', $val->id) }}" class="btn btn-sm btn-info-light" title="View">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <a href="{{ url('admin/customer/edit', $val->id) }}" class="btn btn-sm btn-success-light" title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <form action="{{ url('admin/customer/destroy', $val->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this customer?');">
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

@include('admin.partials.bulk_email_modal', [
    'emailPrefix' => 'customer',
    'modalTitle' => 'Compose Email to Customers',
    'modalDescription' => 'Send an email to the currently filtered customer list. Review the recipients below and uncheck anyone you want to exclude.',
    'recipientLabel' => 'customer',
    'recipients' => $data,
])

@endsection

@push('scripts')
<script>
@if (session('success'))
    swal({
        title: "Success!",
        text: "{{ session('success') }}",
        icon: "success",
        button: "OK",
        timer: 3000
    });
@endif

jQuery(document).ready(function ($) {
    $(document).on('change', '.status-toggle', function () {
        const userId = $(this).data('id');
        const status = $(this).is(':checked') ? 1 : 0;
        const toggle = $(this);

        function updateStatus() {
            toggle.prop('disabled', true);

            $.ajax({
                url: '/admin/customer/update-status/' + userId,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    status: status,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    toggle.prop('disabled', false);
                    if (response.success) {
                        swal({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            button: "OK",
                            timer: 2000
                        });
                    } else {
                        toggle.prop('checked', !toggle.prop('checked'));
                        swal({
                            title: "Error!",
                            text: response.message || 'Failed to update status',
                            icon: "error",
                            button: "OK",
                        });
                    }
                },
                error: function (xhr) {
                    toggle.prop('disabled', false);
                    toggle.prop('checked', !toggle.prop('checked'));
                    let errorMsg = "Something went wrong. Please try again.";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    swal({
                        title: "Error!",
                        text: errorMsg,
                        icon: "error",
                        button: "OK",
                    });
                }
            });
        }

        if (status === 1) {
            swal({
                title: "Activate Customer?",
                text: "Do you want to activate this customer account?",
                icon: "warning",
                buttons: {
                    cancel: { text: "Cancel", value: false, visible: true, closeModal: true },
                    confirm: { text: "Yes, Activate", value: true, visible: true, closeModal: false }
                },
                dangerMode: false,
            }).then((confirmed) => {
                if (confirmed) {
                    updateStatus();
                } else {
                    toggle.prop('checked', false);
                }
            });
        } else {
            swal({
                title: "Deactivate Customer?",
                text: "Do you want to deactivate this customer account?",
                icon: "warning",
                buttons: {
                    cancel: { text: "Cancel", value: false, visible: true, closeModal: true },
                    confirm: { text: "Yes, Deactivate", value: true, visible: true, closeModal: false }
                },
                dangerMode: true,
            }).then((confirmed) => {
                if (confirmed) {
                    updateStatus();
                } else {
                    toggle.prop('checked', true);
                }
            });
        }
    });
});
</script>

@php
    $datatableJqueryLoaded = true;
    $datatableOptions = $customerDatatableOptions;
@endphp
@include('datatable.datatable_js')
@include('admin.customer.partials.export_scripts')
@include('admin.partials.bulk_email_scripts', [
    'emailPrefix' => 'customer',
    'sendRoute' => route('admin.customer.send-email'),
    'recipientIdsField' => 'customer_ids',
])
@endpush
