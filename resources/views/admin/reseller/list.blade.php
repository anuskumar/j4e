<?php $page="admin/reseller/list";?>
@extends('admin.layout.app')
@section('admin_content')

<style>
    .reseller-list-card {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border-radius: 8px;
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 8px 8px 0 0 !important;
        padding: 20px;
    }
    
    .card-header h3 {
        color: white;
        margin: 0;
        font-weight: 600;
    }
    
    .table thead {
        background-color: #f8f9fa;
    }
    
    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #dee2e6;
        padding: 15px 10px;
    }
    
    .table tbody td {
        padding: 15px 10px;
        vertical-align: middle;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s;
    }
    
    .table-action {
        display: flex;
        gap: 5px;
        align-items: center;
    }
    
    .table-action .btn {
        padding: 6px 10px;
        border-radius: 4px;
        transition: all 0.3s;
    }
    
    .table-action .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }
    
    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }
    
    .form-check-input:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 6px 12px;
    }
    
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 6px 12px;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5rem 0.75rem;
        margin: 0 2px;
        border-radius: 4px;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: white !important;
        border: none !important;
    }
    
    .reseller-name {
        font-weight: 600;
        color: #333;
    }
    
    .reseller-email {
        color: #666;
        font-size: 14px;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }
    
    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.3;
    }
    
    @media (max-width: 768px) {
        .table {
            font-size: 14px;
        }
        
        .table-action {
            flex-direction: column;
            gap: 3px;
        }
        
        .table-action .btn {
            width: 100%;
        }
        
        .card-header {
            padding: 15px;
        }
        
        .card-header h3 {
            font-size: 18px;
        }
    }
</style>

<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card reseller-list-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title mb-1">
                            <i class="fe fe-users me-2"></i>Reseller Management
                        </h3>
                        <p class="mb-0" style="color: rgba(255,255,255,0.9); font-size: 14px;">
                            Manage and view all registered resellers
                        </p>
                    </div>
                    <a href="{{ url('admin/reseller/create') }}" class="btn btn-light">
                        <i class="fa fa-plus me-2"></i>Create Reseller
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(isset($data) && count($data) > 0)
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-primary">
                                <i class="fe fe-users me-1"></i>Total Resellers: {{ count($data) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="file-datatable" class="table table-hover table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th width="120">Status</th>
                                <th width="150">Last Login</th>
                                <th width="150" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($data as $val)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>
                                    <div class="reseller-name">{{ $val->name ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <div class="reseller-email">
                                        <i class="fe fe-mail me-1"></i>{{ $val->email ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    @if($val->phone)
                                        <i class="fe fe-phone me-1"></i>{{ $val->phone }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($val->address)
                                        <span title="{{ $val->address }}">
                                            {{ Str::limit($val->address, 30) }}
                                        </span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-switch d-inline-block">
                                        <input class="form-check-input status-toggle" type="checkbox" 
                                               data-id="{{ $val->id }}" 
                                               id="status_{{ $val->id }}"
                                               {{ $val->is_active == 1 ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    @if($val->last_login)
                                        <small>
                                            <i class="fe fe-clock me-1"></i>
                                            {{ date('d/m/Y', strtotime($val->last_login)) }}<br>
                                            <span class="text-muted">{{ date('h:i A', strtotime($val->last_login)) }}</span>
                                        </small>
                                    @else
                                        <span class="text-muted">Never</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="table-action justify-content-center">
                                        <a href="{{url('admin/reseller/view',$val->id)}}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Details">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a href="{{url('admin/reseller/edit',$val->id)}}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Reseller">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <form action="{{ url('admin/reseller/delete',$val->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this reseller? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger show_confirm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Reseller">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <i class="fe fe-users"></i>
                    <h4>No Resellers Found</h4>
                    <p>Get started by creating your first reseller.</p>
                    <a href="{{ url('admin/reseller/create') }}" class="btn btn-primary mt-3">
                        <i class="fa fa-plus me-2"></i>Create Reseller
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<script>
@if(session('success'))
    swal({
        title: "Success!",
        text: "{{ session('success') }}",
        icon: "success",
        button: "OK",
        timer: 3000
    });
@endif

$(document).ready(function() {
    // Status toggle handler with confirmation
    $(document).on('change', '.status-toggle', function() {
        const userId = $(this).data('id');
        const isChecked = $(this).is(':checked');
        const status = isChecked ? 1 : 0; // 1 for active, 0 for inactive
        const toggle = $(this);
        const actionText = status === 1 ? 'activate' : 'deactivate';
        const actionTitle = status === 1 ? 'Activate Reseller?' : 'Deactivate Reseller?';
        const actionMessage = status === 1 
            ? 'Do you want to activate this reseller account? This will allow them to access the system.'
            : 'Do you want to deactivate this reseller account? This will prevent them from accessing the system.';
        
        console.log('Status toggle clicked - User ID:', userId, 'Checked:', isChecked, 'Status to send:', status);
        
        // Function to update status via AJAX
        function updateStatus() {
            // Disable toggle during request
            toggle.prop('disabled', true);
            
            $.ajax({
                url: '/admin/reseller/update-status/' + userId,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    status: status, // Send 1 for active, 0 for inactive
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Success response:', response);
                    console.log('Updated is_active value:', response.is_active);
                    toggle.prop('disabled', false);
                    if (response.success) {
                        // Verify the status was updated correctly
                        if (response.is_active == status) {
                            console.log('Status updated successfully - is_active:', response.is_active);
                        } else {
                            console.warn('Status mismatch - Expected:', status, 'Got:', response.is_active);
                        }
                        // Show success message
                        if (typeof swal !== 'undefined') {
                            swal({
                                title: "Success!",
                                text: response.message + ' (Status: ' + (response.is_active == 1 ? 'Active' : 'Inactive') + ')',
                                icon: "success",
                                button: "OK",
                                timer: 2000
                            });
                        } else {
                            alert('Success: ' + response.message + ' (Status: ' + (response.is_active == 1 ? 'Active' : 'Inactive') + ')');
                        }
                    } else {
                        // Revert toggle
                        toggle.prop('checked', !toggle.prop('checked'));
                        if (typeof swal !== 'undefined') {
                            swal({
                                title: "Error!",
                                text: response.message || 'Failed to update status',
                                icon: "error",
                                button: "OK",
                            });
                        } else {
                            alert('Error: ' + (response.message || 'Failed to update status'));
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr, status, error);
                    toggle.prop('disabled', false);
                    toggle.prop('checked', !toggle.prop('checked'));
                    let errorMsg = "Something went wrong. Please try again.";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.status === 404) {
                        errorMsg = "Route not found. Please check the URL.";
                    } else if (xhr.status === 500) {
                        errorMsg = "Server error. Please try again later.";
                    }
                    if (typeof swal !== 'undefined') {
                        swal({
                            title: "Error!",
                            text: errorMsg,
                            icon: "error",
                            button: "OK",
                        });
                    } else {
                        alert('Error: ' + errorMsg);
                    }
                }
            });
        }
        
        // Show confirmation dialog
        if (typeof swal !== 'undefined') {
            swal({
                title: actionTitle,
                text: actionMessage,
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Cancel",
                        value: false,
                        visible: true,
                        closeModal: true,
                    },
                    confirm: {
                        text: "Yes, " + actionText.charAt(0).toUpperCase() + actionText.slice(1),
                        value: true,
                        visible: true,
                        closeModal: false
                    }
                },
                dangerMode: status === 0, // Show danger mode for deactivation
            }).then((confirmed) => {
                if (confirmed) {
                    updateStatus();
                } else {
                    // Revert toggle if cancelled
                    toggle.prop('checked', !toggle.prop('checked'));
                }
            });
        } else {
            // Fallback to native confirm dialog
            if (confirm(actionMessage)) {
                updateStatus();
            } else {
                // Revert toggle if cancelled
                toggle.prop('checked', !toggle.prop('checked'));
            }
        }
    });
    
    // Initialize DataTable with professional options
    if ($.fn.DataTable) {
        $('#file-datatable').DataTable({
            "order": [[ 0, "asc" ]],
            "pageLength": 25,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "language": {
                "search": "Search resellers:",
                "lengthMenu": "Show _MENU_ resellers per page",
                "info": "Showing _START_ to _END_ of _TOTAL_ resellers",
                "infoEmpty": "No resellers found",
                "infoFiltered": "(filtered from _MAX_ total resellers)",
                "zeroRecords": "No matching resellers found",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                }
            },
            "responsive": true,
            "processing": true,
            "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            "columnDefs": [
                { "orderable": false, "targets": [7] }, // Disable sorting on Actions column
                { "searchable": false, "targets": [0, 7] } // Disable search on # and Actions columns
            ],
            "drawCallback": function() {
                // Re-initialize tooltips after table redraw
                if (typeof bootstrap !== 'undefined') {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                }
            }
        });
    }
    
    // Initialize Bootstrap tooltips
    if (typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
</script>

@include('datatable.datatable_js')
@endsection
