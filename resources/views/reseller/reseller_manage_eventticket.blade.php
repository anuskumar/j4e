<?php $page = 'events/list';
$val = $data[0];
?>
@extends('layouts.reseller_app')
@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-3">
                <h6>Listing ID: {{ $val['unique_id'] }}</h6>

            </div>
            <div class="col-md-3">
                  @if ($val['is_admin_approved'] == 1)
                                               @if($val['ticket_status'] == 1)
                                                <span class="badge text-bg-success">Active</span>
                                                @else
                                                    <span class="badge text-bg-primary">Paused</span>
                                                @endif
                                            @else
                                            <span class="badge text-bg-primary">Waiting for Approval</span>
                                            @endif
            </div>
            <div class="col-md-3">

            </div>
            <div class="col-md-3">
                <button class="btn btn-danger">Delete Listing</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex">
                <h3>{{ $val['ticket_type_name'] }}</h3>  &nbsp;<button type="button" class="btn btn-light" onclick="openTicketTypechangeModal()">
           <i class="fa fa-pencil"></i>
           </button>

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-light" role="alert">
               <h5 class="text-danger"> Important Notification </h5>
               <div class="text-muted">
                <h6>There are some corrections needed on your profile that might effect your listing. Please Update your profile </h6>
               </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
               <div class="alert alert-light" role="alert">
                <b>Numbered Seats:</b> {{ $val['no_of_tickets'].' Ticket[s]' }}
               </div>
               <span><h3>
               <b class="text-primary"> {{ ucfirst($val['event_name']) }}</b>
            </h3></span>
            <h6><b>Tickets</b></h6>
            <p>
                All Seats need to be next to each other (adjesent). For unconfirmed seats, you need to create  a new listing.Breaking this rule can lead to charge becks of total sale price
            </p>
           <b>Section: <span class="text-muted">  {{ $val['seating_type_name'] }}</span></b>
           &nbsp;
           &nbsp;
           &nbsp;
           <b>Row: <span class="text-muted"> {{ $val['row']  }}</span></b>
           &nbsp;
           &nbsp;
           <button type="button" class="btn btn-light">
           <i class="fa fa-pencil"></i>
           </button>
           <div class="card border-dark mb-3" style="max-width: 50rem;">
                <div class="card-body">
                    <h6 class="card-title">Listed Tickets</h6>
                    <table class="table table-borderd">
                        <tr>
                          <td>  <b>TYPE</b></td>
                            <td><b>SERIAL</b></td>
                            <td><b>SEAT NO.</b></td>
                            <td><b>ACTION</b></td>
                            <td><b>ON SALE</b></td></b>
                        </tr>
                        @foreach ($data['tickets'] as $tickets)
                           <tr>
                            <td><b><span class="text-muted">{{ $tickets['seating_type_name'] }}</span></b></td>
                            <td><b><span class="text-muted">{{ $tickets['ticket_serial_number'] }}</span></b></td>
                            <td><b> <span class="text-muted">{{ $tickets['seat_number'] }}</span></b></td>
                            <td><button class="btn btn-primary btn-sm"><b>Add Seat</b></button>
                            <button class="btn btn-danger btn-sm"><b>Delete</b></button></td>
                            <td>
                                  <div class="form-check form-switch">
                                        <input class="form-check-input"
                                                type="checkbox"
                                                role="switch"
                                                id="switchCheckChecked_{{ $tickets['id'] }}"
                                                data-id="{{ $tickets['id'] }}"
                                                data-status="{{ $tickets['is_active']}}"
                                                onchange="confirmToggleStatus(this)"
                                                {{ $tickets['is_active'] == 1 ? 'checked':'' }}

                                                ticketsue="{{ $tickets['is_active'] }}">

                                            </div>
                            </td>
                        </tr>
                        @endforeach

                    </table>
                </div>

                </div>

              <div class="card border-light mb-3" style="max-width: 50rem;">
                <div class="card-body">
                <div class="d-grid">
                <button class="btn btn-primary" type="button">Upload Tickets</button>

                </div>
                </div>
                </div>



                        <div class="card" style="width: 25rem;">
                        <div class="card-header">
                          <b> Price per Ticket </b>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Original Price : {{ $val['ticket_amount'].' '.$val['short_name'] }}</b>   <button type="button" class="btn btn-light">
           <i class="fa fa-pencil"></i>
           </button></li>
                            <li class="list-group-item"><b>Your Sale Price :  {{ $val['face_value'].' '.$val['short_name'] }}</b>   <button type="button" class="btn btn-light">
           <i class="fa fa-pencil"></i>
           </button></li>
                        </ul>
                        </div>

            </div>
            <div class="col-md-4">

                <div class="card border-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">Event Details</div>
                <div class="card-body">
                    <h6 class="card-title">Event Location</h6>
                    <p class="card-text"> {{ $val['venue_name'] }},{{ $val['city_name'] }},{{ $val['country_name'] }}</p>
                    @if ($val['google_map_link'])
                    <a class="text-success" href="{{ $val['google_map_link'] }}" target="_blank">View the venue Map</a>

                    @endif

                </div>
                <div class="card-body">
                    <h6 class="card-title">Event Starts at</h6>
                    <p class="card-text"> {{  date('d M Y',strtotime($val['event_from_date'])) }}  {{  $val['from_time'] }}</p>
                    <h6 class="card-title">Event Ends at</h6>
                    <p class="card-text"> {{  date('d M Y',strtotime($val['event_to_date'])) }}  {{  $val['to_time'] }}</p>

                </div>
                </div>
                    <div class="card border-dark mb-3" style="max-width: 18rem;">
                    <div class="card-header">Extra Details</div>
                    <div class="card-body">
                        <h6 class="card-title">Consessions</h6>
                        <p class="card-text">{{ $val['disclaimer_note'] }}</p>
                         <h6 class="card-title">Decription</h6>
                        <p class="card-text">{{ $val['description'] }}</p>

                        <h6 class="card-title">{{ $val['ticket_type_name'] }}</h6>
                    </div>
                    </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary">Back To Listing</button>
            </div>
        </div>

    </div>

<div class="modal fade" id="tickcet-type-change-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Ticket Type</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <select class="form-select" aria-label="Default select example">
            <option>Select Ticket Type</option>
            @foreach ($ticket_type as $type)
            <option {{ $type['id'] == $val['ticket_type'] ? 'selected':'' }} value="{{ $type['id'] }}">{{ $type['ticket_type_name'] }}</option>

            @endforeach

            </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Update</button>
      </div>
    </div>
  </div>
</div>



<script>
    function openTicketTypechangeModal(){
$('#tickcet-type-change-modal').modal('show');

    }
</script>
@endsection
