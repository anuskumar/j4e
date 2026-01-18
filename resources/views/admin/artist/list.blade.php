<?php $page="admin/artist/list";?>
@extends('admin.layout.app')
@section('admin_content')

<style>
    .artist-list-card {
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
    
    .artist-name {
        font-weight: 600;
        color: #333;
    }
    
    .artist-field {
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
        <div class="card artist-list-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title mb-1">
                            <i class="fe fe-music me-2"></i>Artist Management
                        </h3>
                        <p class="mb-0" style="color: rgba(255,255,255,0.9); font-size: 14px;">
                            Manage and view all registered artists
                        </p>
                    </div>
                    <a href="{{ url('admin/artist/create') }}" class="btn btn-light">
                        <i class="fa fa-plus me-2"></i>Create Artist
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(isset($data) && count($data) > 0)
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-primary">
                                <i class="fe fe-music me-1"></i>Total Artists: {{ count($data) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="file-datatable" class="table table-hover table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Artist Name</th>
                                <th>Artist Field</th>
                                <th>Contact Number</th>
                                <th>About</th>
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
                                    <div class="artist-name">{{ $val->artist_name ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <div class="artist-field">
                                        <i class="fe fe-tag me-1"></i>{{ $val->field_name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    @if($val->contact_number)
                                        <i class="fe fe-phone me-1"></i>{{ $val->contact_number }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($val->about)
                                        <span title="{{ $val->about }}">
                                            {{ Str::limit($val->about, 50) }}
                                        </span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="table-action justify-content-center">
                                        <a href="{{url('admin/artist/view',$val->id)}}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Details">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a href="{{url('admin/artist/edit',$val->id)}}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Artist">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <form action="{{ url('admin/artist/destroy',$val->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this artist? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger show_confirm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Artist">
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
                    <i class="fe fe-music"></i>
                    <h4>No Artists Found</h4>
                    <p>Get started by creating your first artist.</p>
                    <a href="{{ url('admin/artist/create') }}" class="btn btn-primary mt-3">
                        <i class="fa fa-plus me-2"></i>Create Artist
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
    // Initialize DataTable with professional options
    if ($.fn.DataTable) {
        $('#file-datatable').DataTable({
            "order": [[ 0, "asc" ]],
            "pageLength": 25,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "language": {
                "search": "Search artists:",
                "lengthMenu": "Show _MENU_ artists per page",
                "info": "Showing _START_ to _END_ of _TOTAL_ artists",
                "infoEmpty": "No artists found",
                "infoFiltered": "(filtered from _MAX_ total artists)",
                "zeroRecords": "No matching artists found",
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
                { "orderable": false, "targets": [5] }, // Disable sorting on Actions column
                { "searchable": false, "targets": [0, 5] } // Disable search on # and Actions columns
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
