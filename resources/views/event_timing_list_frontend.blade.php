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

        function select_function(val){

            $('#ticket-number').val(val);


            if(val==6){
              $('#ticket_select').hide();
              $('#ticket_number').show();
            }
        }


    </script>
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel" style="height: 300px;">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block" style="height: 400px;"
                    @if($event_datas->tag_image)
                        src="{{ asset('storage/uploads/event_tag_images/' . $event_datas->tag_image) }}"
                    @else
                        src="{{ asset('assets/img/default-tag.jpg') }}"
                    @endif

                <div class="carousel-caption d-none d-md-block">
                    <div class="banner-header">

                        <div>
                            <a href="{{ url('/') }}"> <img class="banner-logo mt-5"
                                    src="{{ asset('assets/img/banner-logo.png') }}"> </a>
                        </div>
                    </div>
                    <h1 class="text-white">{{ strtoupper($event_datas->tag_name) . ' TICKETS' }}</h1>

                    {{-- <p>...</p> --}}
                </div>
            </div>
        </div>
    </div>
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
                        {{ $event_datas->location_name . ' ,' . $event_datas->city_name . ' ,' . strtoupper($event_datas->country_name) }}</h3>

                <br>
                {{ date('l, d M Y',strtotime($timing_datas->event_date)) }} || {{ date('H:i A',strtotime($timing_datas->from_time)) }}

                    </div>
                <div class="col-md-1">

                </div>
<hr>


            </div>
            <!-- /Section Header -->
            <div class="row blog-grid-row">
                <div class="col-md-1"></div>
                <div class="col-md-11">

                  @if($event_datas->venue_image)
                      <img src="{{ asset('storage/uploads/venue/' . $event_datas->venue_image) }}" style='height:500px;width:100%;' onerror="this.src='{{ asset('assets/img/default-venue.jpg') }}'">
                  @else
                      <img src="{{ asset('assets/img/default-venue.jpg') }}" style='height:500px;width:100%;'>
                  @endif

                </div>
                {{-- <div class="col-md-1"></div> --}}
                {{-- <div class="section"> --}}
                {{-- </div> --}}

            </div>
            <form enctype="multipart/form-data" action="{{ url('ticket_filter_action') }}" method="GET">
            @csrf

            <div class="row blog-grid-row ml-5">
                <div class="container ml-5 mr-5 mt-3">
                    <table class="table table-striped ml-3">

                            <tr>
                                <th>
                                    <table class="table table-striped">
                                        <tr>
                                            <td>
                                                <h3>Filter By Category</h3>
                                            </td>
                                            <td>
                                         <!-- Default switch -->
                            <div class="custom-control custom-switch float-right">
                                <input type="checkbox" class="custom-control-input" id="customSwitches" name="seated_together">
                                <label class="custom-control-label" for="customSwitches"> <h5>We Want to be Seated Together</h5></label>
                            </div>

                                            </td>
                                        </tr>

                                    </table>

                                </th>

                            </tr>
                            <tr>
                                <th scope="col">

                                        <select name="category" required class="form-control form-select-lg mb-3" style="height: 60px;">
                                            <option value="">Search By Category</option>
                                            @foreach ($event_datas->seating_categories as $seating)

                                            <option value="{{ $seating->id }}">{{ Str::ucfirst($seating->seating_type_name).'  ( '.$seating->avalable_ticket.' Tickets Available )' }}</option>

                                            @endforeach
                                        </select>


                                </th>

                            </tr>
                            <input type="hidden" name="ticket_number" id="ticket-number">
                            <input type="hidden" name="event_id" value="{{ $_GET['event'] }}">
                            <input type="hidden" name="event_timing" value="{{ $_GET['event_timing'] }}">

                            <tr>
                                <th scope="col">

                                    <select required id="ticket_select"  onchange="select_function(this.value)"
                                     class="form-control form-select-lg mb-3" style="height: 60px;">
                                        <option value="">Number Of Tickets</option>
                                        <option value="1">1 Ticket</option>
                                        <option value="2">2 Tickets </option>
                                        <option value="3">3 Tickets</option>
                                        <option value="4">4 Tickets</option>
                                        <option value="5">5 Tickets</option>
                                        <option value="6">5+ Tickets</option>
                                    </select>

                                    <input type="number"  onchange="select_function(this.value)" class="form-control" id="ticket_number" style="height: 60px;" placeholder="Please Enter the ticket Number" >

                                 </th>

                            </tr>
                            <tr>
                                <th scope="col">
                                    <div class="w-500" style="width: 30%;
                                    margin: 0 auto;">
                         <button type="submit" class="btn btn-dark btn-lg btn-block">PROCEED</button>
                                    </div>
                                </th>

                            </tr>

                    </table>

                </div>
            </form>
            </div>

        </div>


    @endsection
