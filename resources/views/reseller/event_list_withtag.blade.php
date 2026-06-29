@extends('layouts.reseller_app')

@section('content')
<style>
    .banner {
        background: black;
        position: relative;
        display: inline-block;
        overflow: hidden;
        width: 100%;
    }

    .banner img {
        max-height: 210px;
        object-fit: cover;
        position: relative;
        z-index: 0;
        width: 100%;
    }

    .banner::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, black 15%, rgba(0, 0, 0, 0.4) 30%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0.4) 70%, black 85%);
        pointer-events: none;
        z-index: 1;
    }

    .event-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 12px;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .event-card img {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }

    .event-card-body {
        padding: 1.25rem;
    }

    .event-date {
        background: #7e0982;
        color: white;
        padding: 0.5rem;
        border-radius: 8px;
        text-align: center;
        min-width: 60px;
    }

    .event-date-day {
        font-size: 1.5rem;
        font-weight: bold;
        line-height: 1.2;
    }

    .event-date-month {
        font-size: 0.85rem;
        text-transform: uppercase;
        opacity: 0.9;
    }

    .event-time {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .event-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .event-location {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 0.75rem;
    }

    .event-card-footer {
        background: transparent;
        border-top: 1px solid #e9ecef;
        padding: 0.75rem 1.25rem;
    }

    .btn-sell-tickets {
        background: #7e0982;
        border: none;
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-sell-tickets:hover {
        background: #6d0875;
        transform: scale(1.02);
        color: white;
    }

    .event-image-placeholder {
        height: 200px;
        background: #7e0982;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
    }
</style>

<div class="container-fluid p-0 banner">
    <img src="https://images.unsplash.com/photo-1567351344506-b2e8a94e273b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
        class="img-fluid d-block mx-auto w-100" alt="Events banner">
</div>

<div class="container mt-4">
    <div class="mt-4">
        <h1 class="fw-bold">
            {{ !empty($events->first()->artist_names) ? implode(', ', $events->first()->artist_names) : 'Unknown Artist' }}
        </h1>
        <p class="text-muted fs-4">Sell tickets | <span>{{ $events->count() }} upcoming events</span></p>
    </div>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link fw-bold active" href="#">Tickets</a>
        </li>
    </ul>

    <div class="mt-4">
        <p class="text-muted fw-bold mb-4">{{ $events->count() }} events in all locations</p>

        <div class="row g-4">
            @foreach ($events as $val)
                @php
                    $eventEnded = !empty($val->event_to_date)
                        ? \Carbon\Carbon::parse($val->event_to_date)->endOfDay()->isPast()
                        : false;
                @endphp
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card event-card h-100">
                        @if (!empty($val->event_image))
                            <img src="{{ asset('storage/uploads/event/' . $val->event_image) }}"
                                 class="card-img-top"
                                 alt="{{ $val->event_name }}"
                                 onerror="this.src='https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?q=80&w=2070&auto=format&fit=crop'">
                        @else
                            <div class="event-image-placeholder">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                        @endif

                        <div class="card-body event-card-body">
                            <div class="d-flex align-items-start mb-3">
                                <div class="event-date me-3">
                                    <div class="event-date-day">{{ date('d', strtotime($val->event_from_date)) }}</div>
                                    <div class="event-date-month">{{ date('M', strtotime($val->event_from_date)) }}</div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="event-time">
                                        <i class="bi bi-calendar3"></i> {{ date('D', strtotime($val->event_from_date)) }}
                                    </div>
                                    @if(!empty($val->event_from_time))
                                    <div class="event-time">
                                        <i class="bi bi-clock"></i> {{ date('H:i', strtotime($val->event_from_time)) }}
                                    </div>
                                    @endif
                                </div>
                                @if ($eventEnded)
                                    <span class="badge bg-secondary ms-2">Event Ended</span>
                                @endif
                            </div>

                            <h5 class="event-title">{{ $val->event_name }}</h5>

                            <p class="event-location mb-0">
                                <i class="bi bi-geo-alt"></i>
                                @if($val->venue_name)
                                    {{ $val->venue_name }},
                                @endif
                                @if($val->city_name)
                                    {{ $val->city_name }},
                                @endif
                                @if($val->country_name)
                                    {{ $val->country_name }}
                                @endif
                            </p>
                        </div>

                        <div class="card-footer event-card-footer">
                            <a href="{{ $eventEnded ? 'javascript:void(0);' : route('reseller.selltickets', ['id' => $val->id]) }}"
                               class="btn btn-sell-tickets w-100 {{ $eventEnded ? 'disabled' : '' }}"
                               aria-disabled="{{ $eventEnded ? 'true' : 'false' }}">
                                <i class="bi bi-ticket-perforated"></i> Sell Tickets
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($events->count() == 0)
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 4rem; color: #dee2e6;"></i>
                <p class="text-muted mt-3">No events found</p>
            </div>
        @endif
    </div>
</div>
@endsection
