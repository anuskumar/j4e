<?php $page = 'ticket_create'; ?>
@extends('layout.mainlayout')
@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Dashboard</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Page Content -->
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-md-4 col-lg-4 col-xl-3 theiaStickySidebar">

                    <!-- Profile Sidebar -->

                    @include('layout.re_sidebar')

                    <!-- /Profile Sidebar -->

                </div>

                <div class="col-md-8 col-lg-8 col-xl-9">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tickets</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-4 main-content-label"></div>
                            <form class="form-horizontal"  action="{{ url('reseller/store_ticket') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                {{-- <div class="mb-4 main-content-label">Name</div> --}}

                               {{-- <input type="hidden" name="id" id="event-id" value="{{ $id }}"> --}}
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
                                         {{-- <select class="form-control" name="ticket_type">
                                            <option>Select</option>
                                            @foreach ($ticket_type as $val )
                                            <option value="{{ $val->id }}">{{ $val->ticket_type_name }}</option>

                                            @endforeach
                                         </select> --}}

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
                                         {{-- <select class="form-control" id="event-timing" onchange="reload_value()" name="event_timing">
                                            <option>Select</option>
                                            @foreach ($event_timing as $val )
                                            <option value="{{ $val->id }}">{{'Date:'.date('d-m-Y',strtotime($val->event_date)).'  Time ['.date('H:i A',strtotime($val->from_time)).' To '.date('H:i A',strtotime($val->to_time)).']' }}</option>
                                            @endforeach
                                         </select> --}}

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Seating</label>
                                        </div>
                                        <div class="col-md-6">
                                            {{-- <select class="form-control" name="venue_seating" id="seating-select" onchange="get_available_tickets(this.value)">
                                               <option>Select</option>
                                               @foreach ($venue_seatings as $val )
                            <option value="{{ $val->id }}">{{ $val->seating_type_name.' ['.$val->seat_serial_prefix.$val->seat_serial_start.
                            ' To '.$val->seat_serial_prefix.$val->seat_serial_start.' ]' }}</option>
                                               @endforeach
                                            </select> --}}

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
                                            <label class="form-label">Currency</label>
                                        </div>
                                        <div class="col-md-6">
                                            {{-- <select class="form-control" name="amount_currency" required>
                                               <option>Select</option>
                                               @foreach ($currency as $val )
                                      <option value="{{ $val->id }}">{{ $val->name.'['.$val->short_name.' ]' }} </option>
                                               @endforeach
                                            </select> --}}

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

                                <div class="form-group mb-0">
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
                                </div>
                                <div class="form-group mb-0">
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
                                </div>
                                <div class="form-group mb-0">
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
                                </div>
                                <div class="card-footer">
                                    {{-- <button class="btn ripple btn-secondary" style="float: right; margin-left:10px;" data-bs-dismiss="modal" type="button">Close</button> --}}
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Create Tickets</button>
                                </div>
                                <br>
                            </form>
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


        </div>


    </div>
    <!-- /Page Content -->

    </div>
@endsection
