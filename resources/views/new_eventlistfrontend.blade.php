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

    /* Show extra info within an event card */
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
        max-width: 1140px;
        margin: 0 auto 40px auto;
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
        margin-left: 20px;
    }

    .event-name {
        font-size: 18px;
        font-weight: 600;
        margin: 0 0 4px 0;
        color: #111827;
    }

    .event-location {
        font-size: 14px;
        margin: 0 0 4px 0;
        color: #4b5563;
    }

    .event-time {
        font-size: 13px;
        color: #6b7280;
    }

    .event-cta {
        margin-left: 20px;
        white-space: nowrap;
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

    .event-hero {
        background-color: #022F5C;
        padding: 30px 0 40px;
    }

    .event-hero-title {
        font-size: 30px;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 5px;
    }

    .event-hero-subtitle {
        font-size: 18px;
        color: #ffffff;
        margin-bottom: 10px;
    }

    .event-hero .divider {
        border-top: 1px solid rgba(255, 255, 255, 0.3);
        max-width: 200px;
        margin: 10px 0 20px 0;
    }

    .event-hero-select {
        border-radius: 18px;
        max-width: 260px;
        margin-left: auto;
    }

    @media (max-width: 767px) {
        .event-hero {
            text-align: center;
        }

        .event-hero .divider {
            margin-left: auto;
            margin-right: auto;
        }

        .event-hero-select {
            margin: 15px auto 0 auto;
        }
    }
</style>

<section class="event-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="event-hero-title">
                    {{ strtoupper($event_tag->tag_name) . ' TICKETS' }}
                </h1>
                <h2 class="event-hero-subtitle">Tickets</h2>
                <hr class="divider">
            </div>
            <div class="col-md-4 text-md-end">
                <select class="form-control event-hero-select" id="location-select">
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
</section>

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
                @php
                    $singleDay = $val->event_from_date == $val->event_to_date;
                    $eventDate = $singleDay ? $val->event_to_date : $val->event_from_date;
                    $timeText = isset($val->timings[0]) ? date('H:i A', strtotime($val->timings[0]->from_time)) : '';

                    $badge = null;
                    if ($val->event_to_date) {
                        $yourDate = \Carbon\Carbon::parse($val->event_to_date);
                        $startDate = \Carbon\Carbon::now()->startOfWeek();
                        $endDate = \Carbon\Carbon::now()->endOfWeek();
                        if ($yourDate->greaterThanOrEqualTo($startDate) && $yourDate->lessThanOrEqualTo($endDate)) {
                            $badge = 'This Week';
                        }
                    }
                @endphp
                <div class="event-item">
                    <div class="event-date">
                        <span class="date">
                            {{ $eventDate ? date('d M', strtotime($eventDate)) : '' }}
                        </span>
                        <span class="day">
                            {{ $eventDate ? date('D', strtotime($eventDate)) : '' }}
                        </span>
                        @if($timeText)
                            <span class="event-time">{{ $timeText }}</span>
                        @endif
                        @if($badge)
                            <span class="badge text-bg-primary mt-1">{{ $badge }}</span>
                        @endif
                    </div>
                    <div class="event-details">
                        <h3 class="event-name">{{ $val->event_name }}</h3>
                        <p class="event-location">
                            {{ $val->location_name . ' ' . $val->city_name . ', ' . $val->country_name }}
                        </p>
                        <span class="event-time">
                            @if($singleDay)
                                {{ $eventDate ? date('d M Y', strtotime($eventDate)) : '' }}
                            @else
                                {{ $val->event_from_date ? date('d M Y', strtotime($val->event_from_date)) : '' }}
                                –
                                {{ $val->event_to_date ? date('d M Y', strtotime($val->event_to_date)) : '' }}
                            @endif
                            @if($timeText)
                                · {{ $timeText }}
                            @endif
                            @if($badge)
                                · {{ $badge }}
                            @endif
                        </span>
                    </div>
                    <div class="event-cta">
                        <a href="{{ url('show_details_show', $val->id) }}" class="ticket-button">See tickets</a>
                    </div>
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
