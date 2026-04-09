<?php $page = 'events/list'; ?>
@extends('admin.layout.app')
@section('admin_content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .select2-selection__choice{
        background-color:brown;
    }
</style>
<style></style>
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tickets</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="file-datatable"
                            class="border-top-0 dataTables  table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th class="border-bottom-0">Ticket Name</th>
                                    <th class="border-bottom-0">Reseller Details</th>
                                    <th class="border-bottom-0">Ticket Type</th>
                                    <th class="border-bottom-0">Event Timing</th>
                                    <th class="border-bottom-0">Total Tickets</th>
                                    <th class="border-bottom-0">Final Price</th>
                                    <th class="border-bottom-0">Seating</th>
                                    <th class="border-bottom-0">Expiry Date</th>
                                    <th class="border-bottom-0">Admin Approval</th>

                                    <th class="border-bottom-0">Ticket List</th>

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

                                        <td>
                                            {{ $val->ticket_name }}<br>
                                        </td>
                                        <td>
                                            <b>{{ $val->reseller_name ?? 'N/A' }}</b><br>
                                            <small>{{ $val->reseller_email ?? 'N/A' }}</small><br>
                                            <small>{{ $val->reseller_phone ?? 'N/A' }}</small>
                                        </td>
                                        <td>{{ $val->ticket_type_name }}</td>

                                        <td>{{ $val->event_from_date ? date('d-m-Y', strtotime($val->event_from_date)) : '' }}
                                          <br>  to {{ $val->event_to_date ? date('d-m-Y', strtotime($val->event_to_date)) : '' }}
                                        </td>
                                        {{-- <td>{{ $val->location_name.' '.$val->city_name.' ,'.$val->country_name }}</td> --}}
                                        <td>{{ $val->no_of_tickets }}</td>
                                        <td>{{ $val->total_recive }}</td>
                                        <td>{{ $val->seating_type_name }}</td>
                                        <td>{{ $val->booking_expiry_date_time ? date('D d-m-Y H:i A',strtotime($val->booking_expiry_date_time)):'' }}</td>
                                        <td>
                                           @if($val->is_admin_approved == 1)


                                           {{ "Approved"}}
                                           @elseif($val->is_admin_approved == 2)
                                            {{ "Rejected"}}
                                           @else

                                                    @if(Auth::user()->user_type=="superadmin")


                                                    <button type="button" class="btn btn-success approve-event-btn" id="approve-btn-{{ $val->id }}" onclick="approval_warning({{ $val->id }}, {{ $val->created_by }}, this)">Approve </button>
                                                     <button type="button" class="btn btn-danger approve-event-btn" id="reject-btn-{{ $val->id }}" onclick="rejection_warning({{ $val->id }}, {{ $val->created_by }}, this)">Reject </button>
                                                    @else
                                                    {{ 'Not Approved' }}
                                                    @endif
                                           @endif

                                        </td>
                                        <td>
                                        @if($val->is_admin_approved==1)

                                            <a href="{{ url('tickets/manage_individual_tickets', $val->id) }}">
                                                <button type="button"
                                                    class="btn btn-primary">Tickets</button>
                                                </a>
                                        @endif
                                    </td>
                                        <td>

                                            <form action="{{ url('tickets/delete_main_ticket',$val->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            <a href="{{ url('tickets/ticket_view',$val->id) }}"><button type="button" class="btn btn-primary" title="View"><i class="fas fa-eye"></i></button></a>
                                            {{-- <a href="{{url('customer/delete',$val->id)}}"><button type="button" class="btn btn-danger">Delete</button></a> --}}
                                            
                                            </form>

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

        <div class="modal" id="modaldemo3">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">Create Ticket</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
                         <div class="card-body">
                            <div class="mb-4 main-content-label"></div>
                            <form class="form-horizontal"  action="{{ url('tickets/store_ticket') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                {{-- <div class="mb-4 main-content-label">Name</div> --}}

                               <input type="hidden" name="event" id="event-id" value="{{ $id }}">
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Ticket Name</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="ticket_name" required   value="{{ old('ticket_name') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            {{-- {{ print_r($venue_type) }} --}}
                                            <label class="form-label">Ticket Type</label>
                                        </div>
                                        <div class="col-md-6">
                                         <select class="form-control" name="ticket_type">
                                            <option>Select</option>
                                            @foreach ($ticket_type as $val )
                                            <option value="{{ $val->id }}">{{ $val->ticket_type_name }}</option>

                                            @endforeach
                                         </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            {{-- {{ print_r($venue_type) }} --}}
                                            <label class="form-label">Event Timing</label>
                                        </div>
                                        <div class="col-md-6">
                                         <select class="form-control" id="event-timing" onchange="reload_value()" name="event_timing">
                                            <option>Select</option>
                                            @foreach ($event_timing as $val )
                                            <option value="{{ $val->id }}">{{'Date:'.date('d-m-Y',strtotime($val->event_date)).'  Time ['.date('H:i A',strtotime($val->from_time)).' To '.date('H:i A',strtotime($val->to_time)).']' }}</option>
                                            @endforeach
                                         </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Seating</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="venue_seating" id="seating-select"
                                             onchange="get_available_tickets(this.value)"
                                             >
                                               <option>Select</option>
                                               @foreach ($venue_seatings as $val )
                            <option value="{{ $val->id }}">{{ $val->seating_type_name.' ['.$val->seat_serial_prefix.$val->seat_serial_start.
                            ' To '.$val->seat_serial_prefix.$val->seat_serial_start.' ]' }}</option>
                                               @endforeach
                                            </select>

                                           </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Number Of Tickets</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" max="???" min="???" id="no-of-tickets" name="no_of_tickets" required   value="{{ old('no_of_tickets') }}">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="form-label">Row</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control"  name="row" required   value="{{ old('row') }}">

                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Seat From</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control"  name="seat_from" required   value="{{ old('seat_from') }}">

                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Seat To</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control"  name="seat_to" required   value="{{ old('seat_to') }}">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Ticket Amount</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" name="ticket_amount" required   value="{{ old('ticket_amount') }}">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Face Value</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" name="face_value" required   value="{{ old('face_value') }}">

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Currency</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="amount_currency" required>
                                               <option>Select</option>
                                               @foreach ($currency as $val )
                                      <option value="{{ $val->id }}">{{ $val->name.'['.$val->short_name.' ]' }} </option>
                                               @endforeach
                                            </select>

                                           </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Restrictions</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control select2-select" style="width:100%;" multiple name="ticket_restrictions" required>
                                               <option>Select</option>
                                               @foreach ($restrictions as $val )
                                      <option value="{{ $val->id }}">{{ $val->restrictions }} </option>
                                               @endforeach
                                            </select>

                                           </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Booking expiry Date & time</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="datetime-local" required class="form-control" name="booking_expiry_date_time"  value="{{ old('booking_expiry_date_time') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Disclaimer Notes</label>
                                        </div>
                                        <div class="col-md-6">

                                             <textarea class="form-control" id="summernote" name="disclaimer_note">
                                                {{ old('disclaimer_note') }}
                                             </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Cancellation Policy Notes</label>
                                        </div>
                                        <div class="col-md-6">

                                             <textarea class="form-control" id="" name="cancellation_policy_notes">
                                                {{ old('cancellation_policy_notes') }}
                                             </textarea>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Status</label>
                                        </div>
                                        <div class="col-md-6">

                                            {!! Form::radio('is_active',true,1) !!} Active
                                            {!! Form::radio('is_active',false,0) !!} Inactive

                                        </div>
                                    </div>
                                </div> --}}

                                {{-- <div class="form-group mb-0">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Cover Image</label>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="custom-controls-stacked">
                                                <input type="file" name="cover_image" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="form-group mb-0">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label"> Image</label>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="custom-controls-stacked">
                                                <input type="file" name="image" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="form-group mb-0">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label"> Map Layout</label>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="custom-controls-stacked">
                                                <input type="file" name="map_layout" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="form-group mb-0">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Upload Ticket</label>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="custom-controls-stacked">
                                                <input type="file" name="ticket_upload" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card-footer">
                                    <button class="btn ripple btn-secondary" style="float: right; margin-left:10px;" data-bs-dismiss="modal" type="button">Close</button>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Create Tickets</button>
                                </div>
                                <br>
                            </form>
                        </div>

                        </div>
					<div class="modal-footer">

					</div>
				</div>
			</div>
		</div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

<script>
// Prevent sparkline errors - add fallback if sparkline plugin is not loaded
(function() {
    // Wait for jQuery to be ready
    if (typeof jQuery !== 'undefined') {
        // Add fallback if sparkline doesn't exist
        if (typeof jQuery.fn.sparkline === 'undefined') {
            jQuery.fn.sparkline = function() { 
                return this; 
            };
        }
    }
})();

$(document).ready(function() {
$('.select2-select').select2();
});
</script>
    <!-- End Row -->


    @include('datatable.datatable_js')

    <script>

        function get_available_tickets(val){
            // console.log("hello");
            var seating = val;
            var timing = $('#event-timing').val();
            var event =$('#event-id').val();
            // console.log(timing);

            if(timing==="Select"){
                console.log('hello');
                toastr.error("Select One Timing");
            }
            $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : "{{ url('tickets/check_availability') }}",
        data : {'seating' : seating,'timing':timing, 'event':event},
        type : 'GET',
        dataType : 'json',
        success : function(data){

            if(data.status === true){

                toastr.success(data.message);
                $('#no-of-tickets').val(data.seats);

                $("#no-of-tickets").attr({
                "max" : data.seats,
                "min" : 0
                });

            }else{

                toastr.error(data.message);

            }

        }
    });


        }


        const reload_value = () => {

          $('#seating-select').val('');

        }


        const approval_warning = (val, created_by, buttonElement) => {
            // Store references to the specific buttons for this ticket
            const approveBtn = $('#approve-btn-' + val);
            const rejectBtn = $('#reject-btn-' + val);
            
            // Disable both buttons for this specific ticket
            approveBtn.prop('disabled', true);
            rejectBtn.prop('disabled', true);
            
                swal({
                title: `Are you sure you want to Approve this Ticket?`,
                text: "Once it is Approved, it cannot be revoked",
                        icon: "info",
                        buttons: true,
                        dangerMode: true,
                    })
            .then((willApprove) => {
                if (willApprove) {
                            $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : "{{ url('tickets/approve_tickets') }}",
        data : {'ticket_id' : val, 'created_by': created_by},
        type : 'GET',
        dataType : 'json',
        success : function(data){
            if(data.status === true){
                                // Show success alert
                                swal({
                                    title: "Ticket Approved!",
                                    text: data.message,
                                    icon: "success",
                                    button: "OK",
                                }).then(() => {
                                    // Reload the page after alert is closed
                location.reload();
                                });
                            } else {
                                // Re-enable buttons on error
                                approveBtn.prop('disabled', false);
                                rejectBtn.prop('disabled', false);
                toastr.error(data.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            // Re-enable buttons on error
                            approveBtn.prop('disabled', false);
                            rejectBtn.prop('disabled', false);
                            
                            // Try to get error message from response
                            let errorMessage = 'An error occurred while approving the ticket.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            } else if (xhr.responseText) {
                                try {
                                    const response = JSON.parse(xhr.responseText);
                                    if (response.message) {
                                        errorMessage = response.message;
                                    }
                                } catch (e) {
                                    // Use default message
                                }
                            }
                            
                            swal({
                                title: "Error!",
                                text: errorMessage,
                                icon: "error",
                                button: "OK",
    });
                        }
                    });
                } else {
                    // Re-enable buttons if user cancels
                    approveBtn.prop('disabled', false);
                    rejectBtn.prop('disabled', false);
                        }
            });
        }

        const rejection_warning = (val, created_by, buttonElement) => {
            // Store references to the specific buttons for this ticket
            const approveBtn = $('#approve-btn-' + val);
            const rejectBtn = $('#reject-btn-' + val);
            
            // Disable both buttons for this specific ticket
            approveBtn.prop('disabled', true);
            rejectBtn.prop('disabled', true);
            
                swal({
                title: `Are you sure you want to Reject this Ticket?`,
                text: "Once it is Rejected, it cannot be revoked",
                icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
            .then((willReject) => {
                if (willReject) {
                            $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : "{{ url('tickets/reject_tickets') }}",
        data : {'ticket_id' : val, 'created_by': created_by},
        type : 'GET',
        dataType : 'json',
        success : function(data){
            if(data.status === true){
                                // Show success alert
                                swal({
                                    title: "Ticket Rejected!",
                                    text: data.message,
                                    icon: "info",
                                    button: "OK",
                                }).then(() => {
                                    // Reload the page after alert is closed
                location.reload();
                                });
                            } else {
                                // Re-enable buttons on error
                                approveBtn.prop('disabled', false);
                                rejectBtn.prop('disabled', false);
                toastr.error(data.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            // Re-enable buttons on error
                            approveBtn.prop('disabled', false);
                            rejectBtn.prop('disabled', false);
                            toastr.error('An error occurred while rejecting the ticket.');
        }
    });
                } else {
                    // Re-enable buttons if user cancels
                    approveBtn.prop('disabled', false);
                    rejectBtn.prop('disabled', false);
                        }
            });
        }
    </script>

    {{-- <script>
        $(document).ready(function() {
  $('#summernote').summernote(
    {
        dialogsInBody: true
    }
  );
});
    </script> --}}
@endsection
