<?php $page="eventtype/list";?>
@extends('admin.layout.app')
@section('admin_content')

	<!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Generated Tickets</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="file-datatable"  class="border-top-0 dataTables  table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th class="border-bottom-0">Serial Number</th>
                                    <th class="border-bottom-0">Seat Number</th>

                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Hold/Unhold</th>
                                    <th class="border-bottom-0">Under Purchase Hold </th>
                                    {{-- <th class="border-bottom-0">Outside Sell </th> --}}

                                    <th class="border-bottom-0">Amount</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @if (isset($data))
                                @foreach ($data as $val)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $val->ticket_serial_number }}

                                    </td>

                                    <td>{{ $val->seat_number_prefix }}</td>

                                    <td>{{ $val->is_sold == 1 ? "Sold" :"UnSold" }}</td>

                                    {{-- <td>
                                        <div class="main-toggle off" data-ticket-id="{{ $val->id }}" onclick="toggleHoldStatus(this)">
                                            <span></span>
                                        </div>
                                    </td> --}}
                                    @if(!$val->outsideSell)
                                        <td>
                                            <div class="main-toggle off" data-ticket-id="{{ $val->id }}" onclick="toggleHoldStatus(this)">
                                                <span></span>
                                            </div>
                                        </td>
                                    @else
                                        <td>
                                            <!-- Display some message or alternative content when $val->outsideSell exists -->
                                            <span style="color: rgb(153, 51, 93);font-size:15px;">sold outside</span>
                                            <a  class="btn ripple view-outside" style="background-color:#e4e4d7"  data-bs-toggle="modal" data-bs-target="#modaldemo7" data-id={{ $val->outsideSell->id }} href="#" title="View"><i class="fa fa-eye"></i></a>
                                        </td>
                                    @endif

                                    <td class="hold-status" data-ticket-id="{{ $val->id }}">
                                        {{ $val->under_purchase_hold == 1 ? "Hold" : "No" }}

                                    </td>

                                    <td>{{ $val->ticket_amount }}  </td>

                                    <td>
                                        <form action="{{ url('generated_tickets/destroy',$val->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        {{-- <a href="{{url('eventtype/view',$val->id)}}"><button type="button" class="btn btn-primary">view</button></a> --}}
                                        {{-- <a href="{{url('generated_tickets/edit',$val->id)}}"><button type="button" class="btn btn-info">View</button></a> --}}
                                        {{-- <a class="btn ripple btn-info" data-bs-target="#modaldemo3" data-bs-toggle="modal" href="#">View</a> --}}
                                        <a class="btn ripple btn-success view-ticket" data-bs-toggle="modal" data-bs-target="#modaldemo3" data-id={{ $val->id }} href="#" title="View Ticket Details"><i class="fa fa-eye"></i></a>
                                        {{-- <button type="submit" class="btn btn-danger show_confirm">Delete</button> --}}

                                        </form>
                                    </td>
                                </tr>

                                <div class="modal" id="modaldemo6">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content modal-content-demo">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Sell Details</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">

                                                 <div class="row">
                                                    <form class="form-horizontal" action="{{ route('tickets.outsidesell.store') }}" method="POST">
                                                        @csrf
                                                        {{-- <div class="mb-4 main-content-label">Name</div> --}}
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label class="form-label"> Name</label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control" name="name"  placeholder="Name" value="{{ old('name') }}">
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Phone</label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control" name="phone" placeholder="phone number" value="{{ old('phone') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Address</label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <textarea class="form-control" name="address" rows="2"  placeholder="Address">{{ old('address') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Date</label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="date" class="form-control" name="date" placeholder="date" value="{{ old('date') }}">
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Payment mode</label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control" name="payment_mode"  value="{{ old('payment') }}">
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        {{-- <input type="text" name="ticket_id" class="ticket-id-input" value="{{ $val->ticket_serial_number }}"> --}}
                                                        <input type="hidden" name="event_ticket_tickets_id" class="modal-ticket-id">



                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Save</button>
                                                        </div>
                                                    </form>


                                                 </div>

                                                </div>
                                            <div class="modal-footer">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                                @endif
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

                  <div class="modal" id="modaldemo3">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">View Ticket</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">

                                 <div class="row">
                                    <div class="col-md-12">
                                       <h4 id="ticket-serial-number"></h4>

                                    </div>
                                    <hr style="width:750px">
                                    <div class="col-md-12">
                                        <h6 id="ticket-type"></h6>
                                    </div>
                                    <hr style="width:750px">
                                    <div class="col-md-12">
                                        <h6 id="ticket-name"></h6>
                                    </div>
                                    <hr style="width:750px">
                                    <div class="col-md-7">
                                        <h6 id="event-name"></h6>
                                        <hr>
                                        <div>
                                            <h6>Event Description</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table">
                                                    <p id="event-desc"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5" >
                                        <h6>Event Details :</h6>
                                        <hr>
                                        <div>Event Location :</div>

                                         <div><i class="fa fa-map-marker" aria-hidden="true"></i>
                                         <p style="display: inline;" id="venue-name"></p>
                                         </div>
                                         <hr>
                                        <div>Event Time :</div>
                                        <div>
                                            <i class="fa fa-calendar" aria-hidden="true"></i> Starts at:
                                            <p style="display: inline;" id="event-date"></p>
                                            <p style="display: inline;" id="event-from-time"></p>
                                            <p style="display: inline;" id="event-to-time"></p>
                                        </div>

                                    </div>
                                 </div>

                                </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal" id="modaldemo7">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">View Outside seller Details</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">

                                 <div class="row">
                                    <div class="col-md-12">

                                            <h5 id="outside_name">Name:</h5>

                                    </div>
                                    <hr style="width:750px">
                                    <div class="col-md-12">
                                        <h5 id="outside_phone">Phone:</h5>
                                    </div>
                                    <hr style="width:750px">
                                    <div class="col-md-12">
                                        <h5 id="outside_address">Address:</h5>
                                    </div>
                                    <hr style="width:750px">
                                    <div class="col-md-12">
                                        <h5 id="outside_date">Date:</h5>
                                    </div>
                                    <hr style="width:750px">
                                    <div class="col-md-12">
                                        <h5 id="outside_method">Payment Method:</h5>
                                    </div>

                                </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>
                {{-- outsidesell modal --}}


            </div>
        </div>
    </div>
    <script src="admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="admin_assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
    $(document).ready(function () {
        $('.view-ticket').on('click', function () {
            var ticketId = $(this).data('id');

            // Make an AJAX request to the controller
            $.ajax({
                url: '/public/tickets/get-individual-ticketdata/' + ticketId,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log('Data from server:', data);
                    $('#modaldemo3 .modal-body #outside_name').text('Name : '+data.individualticketData.ticket_serial_number);
                    $('#modaldemo3 .modal-body #ticket-type').text('Ticket Type :'+data.individualticketData.event_ticket.ticket_type.ticket_type_name);
                    $('#modaldemo3 .modal-body #ticket-name').text('Ticket Name :'+data.individualticketData.event_ticket.ticket_name);
                    $('#modaldemo3 .modal-body #event-date').text(data.individualticketData.event_timing.event_date);
                    $('#modaldemo3 .modal-body #event-from-time').text(data.individualticketData.event_timing.from_time);
                    $('#modaldemo3 .modal-body #event-to-time').text(data.individualticketData.event_timing.to_time);
                    $('#modaldemo3 .modal-body #venue-name').text(data.individualticketData.event_ticket.event.venue.name);
                    $('#modaldemo3 .modal-body #event-name').text('Event Name :'+data.individualticketData.event_ticket.event.event_name);
                    $('#modaldemo3 .modal-body #event-desc').text(data.individualticketData.event_ticket.event.event_desc);


                    $('#modaldemo3').modal('show');
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        });

        $('.view-outside').on('click', function () {
            var outsidesell_id = $(this).data('id');

            // Make an AJAX request to the controller
            $.ajax({
                url: '/public/tickets/get-outsidesell_data/' + outsidesell_id,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log('Data from server:', data);
                    $('#modaldemo7 .modal-body #outside_name').text('Name : '+data.outsidesellData.name);
                    $('#modaldemo7 .modal-body #outside_phone').text('Phone : '+data.outsidesellData.phone);
                    $('#modaldemo7 .modal-body #outside_address').text('Address : '+data.outsidesellData.address);
                    $('#modaldemo7 .modal-body #outside_date').text('Date : '+data.outsidesellData.date);
                    $('#modaldemo7 .modal-body #outside_method').text('Payment Method : '+data.outsidesellData.payment_mode);




                    $('#modaldemo7').modal('show');
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        });

//         function toggleHoldStatus(toggleButton) {
//     // Toggle the state of the main-toggle button
//     $(toggleButton).toggleClass('off on');

//     // Get the ticket ID from the data attribute
//     var ticketId = $(toggleButton).data('ticket-id');

//     // Get the corresponding hold status cell
//     var holdStatusCell = $(toggleButton).closest('tr').find('.hold-status');

//     // Update the hold status based on the toggle state
//     var newHoldStatus = $(toggleButton).hasClass('on') ? 'Hold' : 'No';

//     // Update the content of the hold status cell with both the text and a button (conditionally)
//     var newContent = $('<span>').text(newHoldStatus);
//     var newSpace = document.createTextNode(' '); // Add a space
//     var newButton = $('<button>').text('Click me').attr('class', 'your-button-class');

//     // Empty the cell and append content, space, and button only when it is 'Hold'
//     $(holdStatusCell).empty();
//     if (newHoldStatus === 'Hold') {
//         $(holdStatusCell).append(newContent, newSpace, newButton);
//     } else {
//         $(holdStatusCell).append(newContent);
//     }

//     // Save the hold status to localStorage
//     localStorage.setItem('holdStatus_' + ticketId, newHoldStatus);

//     // Send an Ajax request to update the database
//     $.ajax({
//         url: '/tickets/update-hold-status',
//         type: 'POST',
//         data: {
//             ticketId: ticketId,
//             newHoldStatus: newHoldStatus,
//             _token: '{{ csrf_token() }}'
//         },
//         success: function (response) {
//             console.log(response);
//         },
//         error: function (error) {
//             console.error('Error:', error);
//         }
//     });
// }

// // Check localStorage for hold status during page load
// $(document).ready(function () {
//     $('.main-toggle').each(function () {
//         var ticketId = $(this).data('ticket-id');
//         var savedHoldStatus = localStorage.getItem('holdStatus_' + ticketId);

//         if (savedHoldStatus === 'Hold') {
//             var holdStatusCell = $(this).closest('tr').find('.hold-status');
//             var newContent = $('<span>').text(savedHoldStatus);
//             var newSpace = document.createTextNode(' '); // Add a space
//             var newButton = $('<button>').text('Click me').attr('class', 'your-button-class');
//             $(holdStatusCell).empty().append(newContent, newSpace, newButton);
//         }
//     });
// });

function toggleHoldStatus(toggleButton) {
    // Toggle the state of the main-toggle button
    $(toggleButton).toggleClass('off on');

    // Get the ticket ID from the data attribute
    var ticketId = $(toggleButton).data('ticket-id');

    // Get the corresponding hold status cell
    var holdStatusCell = $(toggleButton).closest('tr').find('.hold-status');

    // Update the hold status based on the toggle state
    var newHoldStatus = $(toggleButton).hasClass('on') ? 'Hold' : 'No';

    // Update the content of the hold status cell with both the text and a button (conditionally)
    var newContent = $('<span>').text(newHoldStatus);
    var newSpace = document.createTextNode(' '); // Add a space
    var newButton = $('<button>').text('Outside Sell').attr({
        'class': 'btn-success',
        'data-bs-toggle': 'modal',
        'data-bs-target': '#modaldemo6' // ID of your modal
    });

    // Get the modal's input field
    var modalInput = $('#modaldemo6').find('.modal-ticket-id');

    // Set the ticketId as the value of the input field
    modalInput.val(ticketId);

    // Empty the cell and append content, space, and button only when it is 'Hold'
    $(holdStatusCell).empty();
    if (newHoldStatus === 'Hold') {
        $(holdStatusCell).append(newContent, newSpace, newButton);
    } else {
        $(holdStatusCell).append(newContent);
    }

    // Save the hold status to localStorage
    localStorage.setItem('holdStatus_' + ticketId, newHoldStatus);

    // Send an Ajax request to update the database
    $.ajax({
        url: '/public/tickets/update-hold-status',
        type: 'POST',
        data: {
            ticketId: ticketId,
            newHoldStatus: newHoldStatus,
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}


// Check localStorage for hold status during page load
$(document).ready(function () {
    $('.main-toggle').each(function () {
        var ticketId = $(this).data('ticket-id');
        var savedHoldStatus = localStorage.getItem('holdStatus_' + ticketId);

        if (savedHoldStatus === 'Hold') {
            var holdStatusCell = $(this).closest('tr').find('.hold-status');
            var newContent = $('<span>').text(savedHoldStatus);
            var newSpace = document.createTextNode(' '); // Add a space
            var newButton = $('<button>').text('Outside sell').attr({
                'class': 'btn-success',
                'data-bs-toggle': 'modal',
                'data-bs-target': '#modaldemo6' // ID of your modal

            });

            $(holdStatusCell).empty().append(newContent, newSpace, newButton);
            // $(this).trigger('click');
        }
    });
});




        // Set initial state based on localStorage
        $('.main-toggle').each(function () {
            var ticketId = $(this).data('ticket-id');
            var savedHoldStatus = localStorage.getItem('holdStatus_' + ticketId);
            if (savedHoldStatus) {
                $(this).toggleClass(savedHoldStatus === 'Hold' ? 'on' : 'off');
                var holdStatusCell = $(this).closest('tr').find('.hold-status');
                $(holdStatusCell).text(savedHoldStatus);
            }
        });

        // Attach the click event handler to the toggle button
        $(document).on('click', '.main-toggle', function () {
            toggleHoldStatus(this);
        });
    });









    </script>



@include('datatable.datatable_js')
@endsection
