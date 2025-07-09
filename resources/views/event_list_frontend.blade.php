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

        /*.banner_caro {*/

        /*    height: 300px;*/
        /*}*/

        img {

            /* height: 48px; */
            width: -webkit-fill-available;
        }

        .banner-logo {
            width: 20%;
        }
        .additional-info {
    display: none; /* Hide additional information by default */
         }
@media (max-width: 767px) {
    .list-item {
        display: block;
        border-bottom: 1px solid #ccc;
        padding: 15px;
    }

}
.event-details {
    padding: 0px 0 0 0px!important;
}
    </style>

    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active d-block" style="background-color: #091057">

                {{-- <h1>Find the best event hall</h1>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consequat mauris </p> --}}
                        <div>
                            {{-- <a href="{{ url('/') }}"> <img class="banner-logo mt-5"
                                    src="{{ asset('assets/img/banner-logo.png') }}"> </a> --}}
                                    <h1 style="font-size:30px; padding:50px 50px 30px" class="text-white">{{ strtoupper($event_tag->tag_name) . ' TICKETS' }} </h1>
                                    <h1 style="color:#ffff; font-size:20px; padding:50px 50px 30px;">Tickets</h1>
                                    <hr class="divider">

                {{-- <img class="d-block w-100 banner_caro"
                    src="{{ Storage::disk('image')->url('uploads/events/' . $data1->event_image) }}"> --}}

                {{-- <div class="carousel-caption d-none d-md-block">
                    <div class="banner-header">
                        <h1>Find the best event hall</h1>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consequat mauris </p>
                        <div>
                            <a href="{{ url('/') }}"> <img class="banner-logo mt-5"
                                    src="{{ asset('assets/img/banner-logo.png') }}"> </a>
                        </div>
                    </div>
                    <h1 class="text-white">{{ strtoupper($event_tag->tag_name) . ' TICKETS' }}</h1>

                </div> --}}
                <div class="col-md-3 text-right" style="padding:0px 50px 30px">
                    {{-- <a href="event-details" class="view-all">View all</a> --}}
                    <select class="form-control" style="border-radius: 18px;">
                        <option value="">All Locations</option>
                        @foreach ($location as $loc)
                        @if($loc->id)
                        <option value="{{ $loc->id }}">  {{ $loc->location_name . ' ' . $loc->city_name . ' ,' . $loc->country_name }}</option>
                        @endif
                        @endforeach
                    </select>

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

                <div class="col-md-6 section-header mb-0">
                    {{-- <p>#popular events hall</p> --}}
                    <h4>Tickets</h4>
                </div>

                <div class="col-md-3 text-right">
                    {{-- <a href="event-details" class="view-all">View all</a> --}}
                    <select class="form-control" style="border-radius: 18px;">
                        <option value="">All Dates</option>
                    </select>

                </div>


            </div>
            <!-- /Section Header -->

<div class="row blog-grid-row">
    <div class="container bg-light">
        <div class="table-responsive">
            @foreach ($data as $val)
            <div class="list-item">
                @if ($val->event_from_date == $val->event_to_date)
                <h3><b>{{ $val->event_to_date ? date('d M ', strtotime($val->event_to_date)) : '' }}</b></h3>
                <h3>{{ $val->event_to_date ? date('D', strtotime($val->event_to_date)) : '' }}</h3>
                <h5>
                    @php
                    $yourDate = \Carbon\Carbon::parse($val->event_to_date);
                    $startDate = \Carbon\Carbon::now()->startOfWeek();
                    $endDate = \Carbon\Carbon::now()->endOfWeek();
                    @endphp
                    @if ($yourDate->greaterThanOrEqualTo($startDate) && $yourDate->lessThanOrEqualTo($endDate))
                    <span class="badge text-bg-primary">This Week</span>
                    @endif
                </h5>
                @else
                <h3>{{ $val->event_from_date ? date('d M D', strtotime($val->event_from_date)) : '' }}</h3>
                <h5 class="text-center">To</h5>
                <h3>{{ $val->event_to_date ? date('d M D', strtotime($val->event_to_date)) : '' }}</h3>
                @endif

                <div class="event-details">

                    <h3><a href="{{ url('show_details_show',$val->id) }}">{{ $val->event_name }}</a></h3>
                    <p class="additional-info" style="display: none;">
                        {{ $val->event_type_name }}<br>
                        {{ $val->venue_name }} <br>
                        {{ $val->location_name . ' ' . $val->city_name . ' ,' . $val->country_name }}
                    </p>
                    <button class="btn btn-link read-more">Read More</button>
                    <button class="btn btn-link read-less" style="display: none;">Read Less</button>

                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Day</th>
                            <th scope="col">Timing</th>
                            <th scope="col">Tickets</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($val->timings as $timing)
                        <tr>
                            <td>{{ date('d-m-Y D',strtotime($timing->event_date)) }}</td>
                            <td>{{ date('H:i A',strtotime($timing->from_time)) }} To {{ date('H:i A',strtotime($timing->to_time)) }}</td>
                            <td>{{ $val->tickets_available.' Tickets Available' }}</td>
                            <td><a href="{{url('show_details_show',$val->id)}}">
                                    <button type="button" class="btn btn-primary r-5">Event Details</button></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>
    </div>
</div>






        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
   $(document).ready(function() {

    $('.read-more').click(function() {
        var $parent = $(this).closest('.event-details');
        $parent.find('.additional-info').slideDown();
        $parent.find('.read-more').hide();
        $parent.find('.read-less').show();
    });

    $('.read-less').click(function() {
        var $parent = $(this).closest('.event-details');
        $parent.find('.additional-info').slideUp();
        $parent.find('.read-more').show();
        $parent.find('.read-less').hide();
    });
});


</script>
    @endsection
