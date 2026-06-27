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
</style>

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mg-b-10">Customers</h4>
                        <p class="text-muted tx-12 mb-0">Manage and view all registered customers.</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary-transparent tx-13">{{ count($data) }} {{ Str::plural('customer', count($data)) }}</span>
                        <a href="{{ url('admin/customer/create') }}" class="btn btn-primary btn-sm">
                            <i class="fe fe-plus me-1"></i> Create Customer
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
                                        <div class="form-check form-switch d-inline-block mb-0">
                                            <input class="form-check-input status-toggle" type="checkbox"
                                                data-id="{{ $val->id }}"
                                                id="status_{{ $val->id }}"
                                                {{ $val->is_active == 1 ? 'checked' : '' }}>
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
    $datatableOptions = [
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
            ['orderable' => false, 'targets' => [5, 7]],
            ['searchable' => false, 'targets' => [0, 5, 7]],
        ],
    ];
@endphp
@include('datatable.datatable_js')
@endpush
