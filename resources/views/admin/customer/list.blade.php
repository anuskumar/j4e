<?php $page="admin/customer/list";?>
@extends('admin.layout.app')
@section('admin_content')

<style>
    .customer-list-card {
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
    
    .customer-name {
        font-weight: 600;
        color: #333;
    }
    
    .customer-email {
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
        <div class="card customer-list-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title mb-1">
                            <i class="fe fe-users me-2"></i>Customer Management
                        </h3>
                        <p class="mb-0" style="color: rgba(255,255,255,0.9); font-size: 14px;">
                            Manage and view all registered customers
                        </p>
                    </div>
                    <a href="{{ url('admin/customer/create') }}" class="btn btn-light">
                        <i class="fa fa-plus me-2"></i>Create Customer
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(isset($data) && count($data) > 0)
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-primary">
                                <i class="fe fe-users me-1"></i>Total Customers: {{ count($data) }}
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
                                    <div class="customer-name">{{ $val->name ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <div class="customer-email">
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
                                        <a href="{{url('admin/customer/view',$val->id)}}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Details">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a href="{{url('admin/customer/edit',$val->id)}}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Customer">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <form action="{{ url('admin/customer/destroy',$val->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this customer? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger show_confirm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Customer">
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
                    <h4>No Customers Found</h4>
                    <p>Get started by creating your first customer.</p>
                    <a href="{{ url('customer/create') }}" class="btn btn-primary mt-3">
                        <i class="fa fa-plus me-2"></i>Create Customer
                    </a>
                </div>
                @endif
            </div>

                {{-- <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          ...
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                      </div>
                    </div>
                  </div> --}}






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
    // Status toggle handler with improved UX
    $(document).on('change', '.status-toggle', function() {
        const userId = $(this).data('id');
        const status = $(this).is(':checked') ? 1 : 0;
        const toggle = $(this);
        
        // Function to update status
        function updateStatus() {
            // Disable toggle during request
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
                success: function(response) {
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
                        // Revert toggle
                        toggle.prop('checked', !toggle.prop('checked'));
                        swal({
                            title: "Error!",
                            text: response.message || 'Failed to update status',
                            icon: "error",
                            button: "OK",
                        });
                    }
                },
                error: function(xhr) {
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
        
        // If changing to Active, show confirmation popup
        if (status === 1) {
            swal({
                title: "Activate Customer?",
                text: "Do you want to activate this customer account?",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Cancel",
                        value: false,
                        visible: true,
                        closeModal: true,
                    },
                    confirm: {
                        text: "Yes, Activate",
                        value: true,
                        visible: true,
                        closeModal: false
                    }
                },
                dangerMode: false,
            }).then((confirmed) => {
                if (confirmed) {
                    updateStatus();
                } else {
                    // Revert toggle if cancelled
                    toggle.prop('checked', false);
                }
            });
        } else {
            // For inactive, show confirmation
            swal({
                title: "Deactivate Customer?",
                text: "Do you want to deactivate this customer account?",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Cancel",
                        value: false,
                        visible: true,
                        closeModal: true,
                    },
                    confirm: {
                        text: "Yes, Deactivate",
                        value: true,
                        visible: true,
                        closeModal: false
                    }
                },
                dangerMode: true,
            }).then((confirmed) => {
                if (confirmed) {
                    updateStatus();
                } else {
                    // Revert toggle if cancelled
                    toggle.prop('checked', true);
                }
            });
        }
    });
    
    // Initialize DataTable with professional options
    if ($.fn.DataTable) {
        $('#file-datatable').DataTable({
            "order": [[ 0, "asc" ]],
            "pageLength": 25,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "language": {
                "search": "Search customers:",
                "lengthMenu": "Show _MENU_ customers per page",
                "info": "Showing _START_ to _END_ of _TOTAL_ customers",
                "infoEmpty": "No customers found",
                "infoFiltered": "(filtered from _MAX_ total customers)",
                "zeroRecords": "No matching customers found",
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
