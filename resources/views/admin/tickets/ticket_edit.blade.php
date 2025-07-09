<?php $page="eventtype/view";?>
@extends('admin.layout.app')
@section('admin_content')

<!-- row -->
<div class="row row-sm">

    <!-- Col -->
    <div class="col-lg-10">
        <div class="card">
            <div class="card-body">
                <div class="mb-4 main-content-label"></div>
                <form class="form-horizontal"  action="{{ url('tickets/store_ticket') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- <div class="mb-4 main-content-label">Name</div> --}}

                    <input type="hidden" name="event_id" id="event-id" value="{{ $data ? $data->id : '' }}">
                    <input type="hidden" name="event"  value="{{ $data ? $data->event : '' }}">
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Ticket Name</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="ticket_name" value="{{ $data ? $data->ticket_name : '' }}" required >
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
                                <option value="{{ $val->id }}" {{($val->id ==$data->ticket_type) ? "selected" :"" }}>{{ $val->ticket_type_name }}</option>

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
                                <option value="{{ $val->id }}" {{($val->id ==$data->event_timing) ? "selected" :"" }}>{{'Date:'.date('d-m-Y',strtotime($val->event_date)).'  Time ['.date('H:i A',strtotime($val->from_time)).' To '.date('H:i A',strtotime($val->to_time)).']' }}</option>
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
                                    <option>Select {{ $data->seating_type_name }}</option>
                                    @foreach ($venue_seatings as $val )
                <option value="{{ $val->id }}" {{($val->id ==$data->venue_seating) ? "selected" :"" }}>{{ $val->seating_type_name.' ['.$val->seat_serial_prefix.$val->seat_serial_start.
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
                                <input type="number" class="form-control" max="???" min="???" id="no-of-tickets" name="no_of_tickets" value="{{ $data ? $data->no_of_tickets : '' }}" required  >

                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Row</label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control"  name="row" value="{{ $data ? $data->row : '' }}" required >

                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Seat From</label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control"  name="seat_from" value="{{ $data ? $data->seat_from : '' }}" required  >

                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Seat To</label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control"  name="seat_to" value="{{ $data ? $data->seat_to : '' }}" required  >

                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Ticket Amount</label>
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="ticket_amount" value="{{ $data ? $data->ticket_amount : '' }}" required >

                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Face Value</label>
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="face_value" value="{{ $data ? $data->face_value : '' }}" required  >

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
                            <option value="{{ $val->id }}" {{($val->id ==$data->amount_currency) ? "selected" :"" }}>{{ $val->name.'['.$val->short_name.' ]' }} </option>
                                    @endforeach
                                </select>

                                </div>
                        </div>
                    </div>
                    {{-- <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Restrictions</label>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control select2-select" style="width:100%;" multiple name="ticket_restrictions" required>
                                    <option>Select</option>
                                    foreach ($restrictions as $val )
                            <option value="{{ $val->id }}" {{ ($val->id === $data->ticket_restrictions) ? "selected" : "" }}
                            >{{ $val->restrictions }} </option>
                                    endforeach
                                </select>

                                </div>
                        </div>
                    </div> --}}
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Booking expiry Date & time</label>
                            </div>
                            <div class="col-md-6">
                                <input type="datetime-local" required class="form-control" name="booking_expiry_date_time" value="{{ $data ? $data->booking_expiry_date_time : '' }}" >
                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Disclaimer Notes</label>
                            </div>
                            <div class="col-md-6">

                                    <textarea class="form-control" id="summernote" name="disclaimer_note"> {{ $data ? $data->disclaimer_note : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Cancellation Policy Notes</label>
                            </div>
                            <div class="col-md-6">

                                    <textarea class="form-control" id="" name="cancellation_policy_notes">{{ $data ? $data->cancellation_policy_notes : '' }}</textarea>
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
                            <div class="col-md-3">
                                <div class="custom-controls-stacked">
                                    <img src="{{ config('app.storage') ."uploads/ticket_images/". $data->cover_image }}"  alt="img" width="100px">
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
                            <div class="col-md-3">
                                <div class="custom-controls-stacked">
                                    <img src="{{ config('app.storage') ."uploads/ticket_images/". $data->image }}"  alt="img" width="100px">
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
                            <div class="col-md-3">
                                <div class="custom-controls-stacked">
                                    <img src="{{ config('app.storage') ."uploads/ticket_images/". $data->map_layout }}"  alt="img" width="100px">
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
    </div>
    <!-- /Col -->
</div>
<!-- row closed -->


@endsection
