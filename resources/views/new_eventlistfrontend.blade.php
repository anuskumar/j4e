@extends('layout.mainlayout')
@section('content')

<!-- Home Banner -->
<style>
    .banner-logo {
        width: 20%;
        margin-top: -12%;
        margin-bottom: 8%;
    }

    .caption-banner {
        margin-bottom: 10%;
    }

    img {
        width: -webkit-fill-available;
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

    .event-list {
        max-width: 900px;

        margin: auto;
        font-family: Arial, sans-serif;
    }

    .event-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #f5f5f5;
        border-radius: 10px;
        padding: 15px;
        margin: 10px 0;
        border: 1px solid #e0e0e0;
        font-family: poppins;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }

    .event-date {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #555;
        font-weight: bold;
    }

    .date {
        font-size: 20px;
        color: #333;
        font-weight: 500px;
    }

    .day {
        font-size: 16px;
        color: #000000;
        font-weight: 500px;
    }

    .event-details {
        flex-grow: 1;
        margin-left: 15px;
    }

    .event-location {
        font-size: 18px;
        font-weight: 500px;
        margin: 0;
    }

    .event-name {
        font-size: 14px;
        margin: 5px 0;
        color: #666;
    }

    .event-time {
        font-size: 12px;

        color: #999;

    }

    .ticket-button {
        background-color: #ffffff;
        color: #022F5C;
        padding: 8px 16px;
        border: 1px solid;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
    }

    .ticket-button:hover {
        background-color: #022F5C;
        color: #ffffff;
    }

    .event-item:hover {
        background-color: #F3EAFF; /* Light blue background on hover */
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }
</style>

<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel" style="padding-left: 0px 900px">
    <div class="carousel-inner">
        <div class="carousel-item active d-block" style="background-color: #022F5C">
            <div>
                <h1 class="text-white" style="font-size: 30px; padding: 20px 50px">{{ strtoupper($event_tag->tag_name) . ' TICKETS' }}</h1>
                <h1 class="text-white" style="font-size: 20px; padding: 0px 0px 0px 50px;">Tickets</h1>
                <hr class="divider">
                <div class="col-md-3 text-right" style="padding: 0px 50px 30px">
                    <select class="form-control" id="location-select" style="border-radius: 18px;">
                        <option value="">All Locations</option>
                        @foreach ($location as $loc)
                            @if($loc->id)
                                <option value="{{ $loc->id }}">{{ $loc->location_name . ' ' . $loc->city_name . ' ,' . $loc->country_name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popular Events -->
<br>
<section class="popular-events1">
    <div class="container ml-2 mr-2">
        <!-- Section Header -->
        <div class="section-wraper row d-flex align-items-center">
            {{-- <div class="col-md-6 text-right" >
                <h4>Events</h4>
            </div> --}}
        </div>
        <!-- /Section Header -->

        <!-- Events List -->
        <div class="event-list">
            @foreach ($data as $val)
            <div class="event-item">
                <div class="event-date">
                    @if ($val->event_from_date == $val->event_to_date)
                        <span class="date">{{ $val->event_to_date ? date('d M ', strtotime($val->event_to_date)) : '' }}</span>
                        <span class="day">{{ $val->event_to_date ? date('D', strtotime($val->event_to_date)) : '' }}</span>
                        <span class="event-time">{{ isset($val->timings[0]) ? date('H:i A', strtotime($val->timings[0]->from_time)) : '' }}</span> <!-- Display from_time here -->
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
                        <span class="date">{{ $val->event_from_date ? date('d M ', strtotime($val->event_from_date)) : '' }}</span>
                        <span class="day">{{ $val->event_from_date ? date('D', strtotime($val->event_from_date)) : '' }}</span>
                        <span class="event-time">{{ isset($val->timings[0]) ? date('H:i A', strtotime($val->timings[0]->from_time)) : '' }}</span> <!-- Display from_time here -->
                    @endif
                </div>
                <div class="event-details">
                    <h3 class="event-location">{{ $val->location_name . ' ' . $val->city_name . ', ' . $val->country_name }}</h3>
                    <p class="event-name">{{ $val->event_name }}</p>
                    <span class="event-time">20:00 This week</span>
                </div>
                <a href="{{url('show_details_show',$val->id)}}">
                <button class="ticket-button">See tickets</button></a>
            </div>

            @endforeach

        </div>
        <!-- /Events List -->
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    
    $(document).ready(function() {
        $('.read-more').click(function() {
            var $parent = $(this).closest('.event-details');
            $parent.find('.additional-info').slideDown();
            $(this).hide();
            $parent.find('.read-less').show();
        });

        $('.read-less').click(function() {
            var $parent = $(this).closest('.event-details');
            $parent.find('.additional-info').slideUp();
            $(this).hide();
            $parent.find('.read-more').show();
        });
    });
</script>

@endsection
