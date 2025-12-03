<?php $page="customer/list";?>
@extends('admin.layout.app')
@section('admin_content')

	<!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">File Export</h3>
                        <a href="{{ url('customer/create') }}" class="btn btn-primary">
                            <i class="fa fa-plus me-2"></i>Create Customer
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="file-datatable"  class="border-top-0 dataTables  table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th class="border-bottom-0">Name</th>
                                    <th class="border-bottom-0">Email</th>
                                    <th class="border-bottom-0">Phone Number</th>
                                    <th class="border-bottom-0">Address</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Last Login</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data as $val)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $val->name }}</td>
                                    <td>{{ $val->email }}</td>
                                    <td>{{ $val->phone }}</td>
                                    <td>{{ $val->address }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox" 
                                                   data-id="{{ $val->id }}" 
                                                   id="status_{{ $val->id }}"
                                                   {{ $val->is_active == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status_{{ $val->id }}">
                                                <span class="status-text">{{ $val->is_active == 1 ? "Active" : "Inactive" }}</span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{$val->last_login ?  date('d/m/Y h:i a',strtotime($val->last_login)) :"" }}</td>


                                    <td>
                                        <div class="table-action">
                                            <a href="{{url('customer/view',$val->id)}}" class="btn btn-sm bg-primary-light" title="View">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <a href="{{url('customer/edit',$val->id)}}" class="btn btn-sm bg-info-light" title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <form action="{{ url('customer/destroy',$val->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm bg-danger-light show_confirm" title="Delete">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                        {{-- {!! $data->links() !!} --}}
                        </div>
                    </div>
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
    <script src="admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="admin_assets/js/main.js"></script>
    <!-- End Row -->

<script>
@if(session('success'))
    swal({
        title: "Success!",
        text: "{{ session('success') }}",
        icon: "success",
        button: "OK",
    });
@endif

$(document).ready(function() {
    // Use event delegation to handle dynamically loaded content
    $(document).on('change', '.status-toggle', function() {
        const userId = $(this).data('id');
        const status = $(this).is(':checked') ? 1 : 0;
        const toggle = $(this);
        const statusText = toggle.closest('td').find('.status-text');
        
        // Function to update status
        function updateStatus() {
            // Disable toggle during request
            toggle.prop('disabled', true);
            
            $.ajax({
                url: '/customer/update-status/' + userId,
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
                        statusText.text(status === 1 ? 'Active' : 'Inactive');
                        swal({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            button: "OK",
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
                title: "Are you sure?",
                text: "Do you want to activate this customer?",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Cancel",
                        value: false,
                        visible: true,
                        closeModal: true,
                    },
                    confirm: {
                        text: "Yes, activate!",
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
            // For inactive, update directly without confirmation
            updateStatus();
        }
    });
});
</script>

@include('datatable.datatable_js')
@endsection
