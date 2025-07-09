@extends('layout.mainlayout')
@section('content')
    <!-- Home Banner -->
    <style>
        .banner-logo {
            width: 50%;
            margin-bottom: 8%;
            margin-top: -12%;
        }

        .caption-banner {


            margin-bottom: 10%;


        }

        .banner_caro {

            height: 400px;
        }

        img {

            /* height: 48px; */
            width: -webkit-fill-available;
        }

        .banner-logo {
            width: 20%;
        }
    </style>
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $('#ticket_number').hide();

        });

        function select_function(val) {

            $('#ticket-number').val(val);


            if (val == 6) {
                $('#ticket_select').hide();
                $('#ticket_number').show();
            }
        }
    </script>

    <!-- Popular Events -->
    <br>
    <section>
        <div class="search-box">
            <form action="search">
                <div class="form-search">
                    {{-- <div class="form-inner">
                    <div class="form-group search-info">
                        <i class="fas fa-expand-arrows-alt bficon"></i>
                        <input type="text" class="form-control" placeholder="Search Event Hall">
                    </div>
                    <div class="form-group search-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <input type="text" class="form-control text-white" placeholder="Location">
                        <a class="current-loc-icon" href="javascript:void(0);"><i class="fas fa-crosshairs"></i></a>
                    </div>
                    <button type="submit" class="btn btn-search-btn search-btn mt-0 text-white"><i class="fas fa-search"></i> Search</button>
                </div> --}}
                </div>
            </form>
        </div>
    </section>
    <section class="popular-events">
        <div class="container ml-2 mr-2">

            <!-- Section Header -->
            <div class="section-wraper row d-flex align-items-center">

                {{-- <div class="col-md-6 section-header mb-0">
                    <p>#popular events hall</p>
                    <h4></h4>
                </div>
                <div class="col-md-3 text-right">
                    <a href="event-details" class="view-all">View all</a>
                    <h1>demo</h1>
                    </select>

                </div> --}}
                <div class="col-md-1">
                </div>
                <div class="col-md-10">
                    <hr>

                    <h3> <b>{{ Str::ucfirst($event_datas->event_name) }}</b></h3>
                    <h3> {{ $event_datas->venue_name }} <br>
                        {{ $event_datas->location_name . ' ,' . $event_datas->city_name . ' ,' . strtoupper($event_datas->country_name) }}
                    </h3>

                    <br>
                    {{ date('l, d M Y', strtotime($timing_datas->event_date)) }} ||
                    {{ date('H:i A', strtotime($timing_datas->from_time)) }}

                </div>
                <div class="col-md-1">

                </div>
                <hr>


            </div>
            <!-- /Section Header -->
            <div class="row blog-grid-row">
                <div class="col-md-1"></div>
                <div class="col-md-11">

                    {{-- <img src="{{ Storage::disk('image')->url('uploads/venue/' . $event_datas->venue_image) }}" style='height:500px;width:100%;'> --}}

                </div>


            </div>
            {{-- <form enctype="multipart/form-data" action="{{ url('ticket_filter_action') }}" method="GET"> --}}
            {{-- @csrf --}}

            <div class="row blog-grid-row ml-5">
                <div class="container ml-5 mr-5 mt-3">
                    <table class="table table-striped">
                        <tr>
                            <td>
                                <h3>Ticket List </h3>
                            </td>
                            <td>
                                <h3></h3>
                            </td>

                        </tr>

                    </table>
                    <table class="table table-striped ml-3">

                        <tr>
                            <th>


                            </th>

                        </tr>
                        <tr>
                            <th scope="col">
                                {{-- <h1>HEllo</h1> --}}
                            </th>
                            <th scope="col">

                                <table class="table align-middle mb-0 bg-white">
                                    <thead class="bg-light">

                                    </thead>
                                    <tbody>
                                        @foreach ($event_ticket_data as $val)
                                        <tr>
                                            <td colspan="7">
                                                <div class="card booking-schedule schedule-widget">

                                                    <!-- Schedule Header -->
                                                    <div class="schedule-header">
                                                        <div class="row">
                                                            <div class="col-md-12">

                                                                <!-- Day Slot -->
                                                                <div class="day-slot">
                                                                    <ul>

                                                                        <li>

                                                                            <span>
                                                                                {{ date('l, d M Y', strtotime($timing_datas->event_date)) }}</span>
                                                                            <span
                                                                                class="slot-date">{{ date('H:i A', strtotime($timing_datas->from_time)) }}</span>
                                                                        </li>
                                                                        <li>

                                                                            <span>{{ Str::ucfirst($val->ticket_name) }}
                                                                               </span>
                                                                            <span
                                                                                class="slot-date">
                                                                                {{ $val->short_name . '  ' . round($val->web_price) }}
                                                                            </span>
                                                                        </li>

                                                                    </ul>
                                                                </div>
                                                                <!-- /Day Slot -->

                                                            </div>
                                                        </div>
                                                    </div>

                                                    @php
                                                        $list_of_tickets = App\Models\TicketsGenerated::get_the_number_of_tickets($val->id)->chunk(3)->toArray();

                                                    @endphp

                                                    <!-- /Schedule Header -->

                                                    <!-- Schedule Content -->
                                                    <div class="schedule-cont">
                                                        <div class="row">
                                                            <div class="col-md-12">

                                                                <!-- Time Slot -->
                                                                <div class="time-slot">
                                                                    <ul class="clearfix">
                                                                        @foreach ($list_of_tickets as $value)
                                                                        <li>
                                                                            @foreach ($value as $va)
                                                                            @php
                                                                            // echo '<pre>';
                                                                            // print_r($va);
                                                                            @endphp
                                                                            <a class="timing">
                                                                                 <span>{{ $va['seat_number_prefix'] }}</span>&nbsp; &nbsp;<span>Seat No :{{ $va['seat_number'] }}</span>
                                                                             </a>
                                                                            {{-- @foreach ($va as $number) --}}
                                                                                {{-- {{ $number }} --}}
                                                                                 {{-- <a class="timing">
                                                                                 <span>{{ $number->seat_number_prefix }}</span> <span>Seat No :{{ $number->seat_number }}</span>
                                                                             </a> --}}
                                                                            {{-- @endforeach --}}

                                                                            @endforeach

                                                                        </li>
                                                                        @endforeach


                                                                    </ul>
                                                                </div>
                                                                <!-- /Time Slot -->

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /Schedule Content -->

                                                </div>
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>Ticket</th>

                                            <th>Seller</th>
                                            <th>Type</th>
                                            <th>Seating</th>
                                            <th>Availability</th>
                                            <th>Price</th>
                                            <th>Buy</th>
                                        </tr>
                                            <tr>
                                                <form action="{{ url('submit_ticket_selected') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <td>
                                                        <p class="fw-normal mb-1">{{ Str::ucfirst($val->ticket_name) }}</p>
                                                        <p class="text-muted mb-0">
                                                            @foreach ($val->ticket_restrictions_data as $dat)
                                                                <span class="badge badge-info rounded-pill d-inline">
                                                                    {{ $dat->restrictions }}
                                                                </span>
                                                            @endforeach
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ Storage::disk('image')->url('uploads/images/' . $val->profile) }}"
                                                                alt="" style="width: 45px; height: 45px"
                                                                class="rounded-circle" />
                                                            <div class="ms-3">
                                                                <p class="fw-bold mb-1">{{ Str::ucfirst($val->user_name) }}
                                                                </p>
                                                                <p class="text-muted mb-0">
                                                                    {{ $val->is_trusted == 1 ? 'Truested Seller' : '' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <span
                                                            class="badge badge-success rounded-pill d-inline">{{ $val->ticket_type_name }}</span>
                                                    </td>

                                                    <td>{{ Str::ucfirst($val->seating_type_name) }}</td>
                                                    <td>
                                                        <span class="badge badge-info rounded-pill d-inline">
                                                            {{ $val->availablity . ' Tickets Available' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ $val->short_name . '  ' . round($val->web_price) }}
                                                    </td>
                                                    <td>
                                                        <input type="hidden" value="{{ $val->id }}"
                                                            name="event_ticket">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="number" class="form-control"
                                                                    max="{{ $val->availablity }}" min="1"
                                                                    name="buy_count" required />

                                                            </div>
                                                            <div class="col-md-6">
                                                                <button type="submit" class="btn btn-success">BUY</button>

                                                            </div>
                                                        </div>
                                                    </td>
                                                </form>
                                            </tr>

                                        @endforeach

                                    </tbody>
                                </table>

                            </th>

                        </tr>



                    </table>



                </div>
            </div>

        </div>
    @endsection
