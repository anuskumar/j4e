<?php $page = 'event/update'; ?>
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

                    @include('layout.re_sidebar');

                    <!-- /Profile Sidebar -->

                </div>

                <div class="col-md-8 col-lg-8 col-xl-9">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-body">
                                <h4 class="mb-4">Update Event</h4>
                                <form class="form-horizontal" action="{{ url('reseller/event_update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    {{-- <div class="mb-4 main-content-label">Name</div> --}}

                                    {{-- <input type="hidden" name="venue" value="{{ $id }}"> --}}
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label"> Event Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="event_name"  value="{{ $data->event_name }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                {{-- {{ print_r($venue_type) }} --}}
                                                <label class="form-label"> Event Type</label>
                                            </div>
                                            {{-- {{ print_r($event_type) }} --}}
                                            <div class="col-md-6">
                                                <select name="event_type" class="form-control" required>
                                                        <option>Select</option>
                                                        @foreach ($event_type as $type)
                                                        <option value="{{ $type->id }}" {{ ($data->event_type ==  $type->id) ? "selected" :"" }}>{{ $type->event_type_name }}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label"> Venue</label>
                                            </div>

                                            <div class="col-md-6">
                                                <select name="venue" class="form-control select2-select" required>

                                                        @foreach ($venue as $ven)
                                                        <option value="{{ $ven->id }}" {{ $ven->id == $data->venue ? "selected" :"" }}>{{ $ven->venue_name." [ ".$ven->location_name." ,".$ven->city_name." ,".$ven->country_name." ] " }}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label"> Artists</label>
                                            </div>

                                            <div class="col-md-6">
                                                <select name="artists[]" multiple class="form-control select2-select">
                                                    {{-- <option>Select</option> --}}
                                                    @foreach($artists as $art)
                                                    <option value="{{ $art->id }}"
                                                      @if(!$data['artists']=='')
                                                        {{ in_array(@$art->id,json_decode(@$data->artists)) ? "selected" :"" }}
                                                      @endif
                                                        >{{ @$art->artist_name.' [ '.@$art->field_name.' ]' }}</option>
                                                    @endforeach
                                                </select>
											</div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Ticket Types</label>
                                            </div>

                                            <div class="col-md-6">
                                                <select name="ticket_types[]" multiple class="form-control select2-select">
                                                    <option value="">Select Ticket Types</option>
                                                    @if(isset($ticketTypes) && $ticketTypes->count() > 0)
                                                    @php
                                                        $selectedTicketTypes = [];
                                                        if (!empty($data->ticket_types)) {
                                                            $selectedTicketTypes = json_decode($data->ticket_types, true);
                                                        }
                                                    @endphp
                                                    @foreach ($ticketTypes as $ticketType)
                                                    <option value="{{ $ticketType->id }}" 
                                                        @if(is_array($selectedTicketTypes) && in_array($ticketType->id, $selectedTicketTypes))
                                                            selected
                                                        @endif
                                                    >{{ $ticketType->ticket_type_name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <small class="text-muted">Select one or more ticket types that will be available for this event</small>
											</div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Event From</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" class="form-control" value="{{ $data->event_from_date }}" required name="event_from_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Event To</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" class="form-control" value="{{ $data->event_to_date }}"  required name="event_to_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Event Description</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="event_desc"   value="{{ $data->event_desc }}">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group mb-0">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Image</label>

                                            </div>
                                            <div class="col-md-6">
                                                @if($data->event_image)
                                                    <img alt="" src="{{ asset('storage/uploads/events/' . $data->event_image) }}" onerror="this.src='{{ asset('assets/img/default-event.jpg') }}'">
                                                @else
                                                    <img alt="" src="{{ asset('assets/img/default-event.jpg') }}">
                                                @endif
                                                <br>
                                                <br>
                                                <br>
                                                <input type="file" name="event_image" class="form-control" >
                                            </div>

                                        </div>
                                    </div><br>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label"> Event Status</label>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-6">
                                                    <div class="custom-controls-stacked">
                                                        <label class=""><input  type="radio" {{ $data->event_is_active ==1 ? "checked" :'' }} checked value="1" name="event_is_active"><span> Active</span></label>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class=""><input  type="radio"  {{ $data->event_is_active ==0 ? "checked" :'' }} value="0" name="event_is_active"><span> Inactive</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Update</button></a>
                                    </div>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>


            </div>


        </div>


    </div>
    <!-- /Page Content -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    $(document).ready(function () {
        $('.select2-select').select2({
            placeholder: 'Select an option',
            allowClear: true
        });
    });
    </script>

@endsection
