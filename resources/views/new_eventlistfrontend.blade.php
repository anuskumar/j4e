@extends('layout.mainlayout')

@push('customer_banner_hero')
<div class="customer-site-banner__hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $event_tag->tag_name ?? 'Events' }} Tickets
                </li>
            </ol>
        </nav>

        <div class="row align-items-end">
            <div class="col-lg-8">
                <h1 class="customer-site-banner__hero-title">
                    {{ strtoupper($event_tag->tag_name ?? 'Events') }} TICKETS
                </h1>
                <p class="customer-site-banner__hero-meta">
                    @if(!empty($search))
                        {{ count($data) }} {{ Str::plural('result', count($data)) }} for "{{ $search }}"
                    @else
                        {{ count($data) }} {{ Str::plural('event', count($data)) }} available
                    @endif
                </p>
            </div>
            @if($location->count())
            <div class="col-lg-4">
                <div class="customer-site-banner__hero-filter">
                    <label for="location-select">Filter by location</label>
                    <select class="form-control" id="location-select">
                        <option value="">All Locations</option>
                        @foreach ($location as $loc)
                            @if($loc->id)
                                <option value="{{ $loc->id }}">
                                    {{ trim($loc->location_name . ' ' . $loc->city_name . ', ' . $loc->country_name) }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endpush

@section('content')

@include('partials.event_list_styles')

<section class="event-list-page">
    <div class="container event-list-content">
        <div class="event-list-panel">
            @if(!empty($search))
                <div class="alert event-list-search-alert" role="alert">
                    <h4 class="alert-heading">Search Results</h4>
                    <p class="mb-0">Showing events matching "{{ $search }}".</p>
                </div>
            @endif

            @if(count($data) > 0)
                <div class="event-list-cards" id="event-list-cards">
                    @foreach ($data as $val)
                        @php
                            $singleDay = $val->event_from_date == $val->event_to_date;
                            $eventDate = $singleDay ? $val->event_to_date : $val->event_from_date;
                            $timeText = isset($val->timings[0]) ? date('g:i A', strtotime($val->timings[0]->from_time)) : '';

                            $badge = null;
                            if ($val->event_to_date) {
                                $yourDate = \Carbon\Carbon::parse($val->event_to_date);
                                $startDate = \Carbon\Carbon::now()->startOfWeek();
                                $endDate = \Carbon\Carbon::now()->endOfWeek();
                                if ($yourDate->greaterThanOrEqualTo($startDate) && $yourDate->lessThanOrEqualTo($endDate)) {
                                    $badge = 'This Week';
                                }
                            }

                            $locationLabel = trim($val->location_name . ' ' . $val->city_name . ', ' . $val->country_name);
                        @endphp
                        <article class="event-list-card" data-location-id="{{ $val->location_id ?? '' }}">
                            <div class="event-list-card__date">
                                <span class="event-list-card__date-day">{{ $eventDate ? date('d', strtotime($eventDate)) : '--' }}</span>
                                <span class="event-list-card__date-month">{{ $eventDate ? date('M', strtotime($eventDate)) : '' }}</span>
                                <span class="event-list-card__date-weekday">{{ $eventDate ? date('D', strtotime($eventDate)) : '' }}</span>
                            </div>

                            <div class="event-list-card__body">
                                <h2 class="event-list-card__title">{{ $val->event_name }}</h2>
                                <div class="event-list-card__meta">
                                    @if(!empty($val->artist_names) && count($val->artist_names) > 0)
                                        <span><i class="fas fa-user"></i> {{ implode(', ', $val->artist_names) }}</span>
                                    @endif
                                    <span><i class="fas fa-map-marker-alt"></i> {{ $locationLabel }}</span>
                                    @if($val->venue_name)
                                        <span><i class="fas fa-building"></i> {{ $val->venue_name }}</span>
                                    @endif
                                    <span>
                                        <i class="far fa-clock"></i>
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
                                    </span>
                                </div>
                                @if($badge)
                                    <span class="event-list-card__badge">{{ $badge }}</span>
                                @endif
                            </div>

                            <div class="event-list-card__cta">
                                <a href="{{ url('show_details_show', $val->id) }}" class="event-list-card__btn">See Tickets</a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="event-list-empty d-none" id="event-list-empty-filter">
                    <h4>No events in this location</h4>
                    <p>Try selecting a different location or view all events.</p>
                    <button type="button" class="btn btn-primary" id="clear-location-filter">Show All Locations</button>
                </div>
            @else
                <div class="event-list-empty">
                    <h4>No Events Found</h4>
                    <p>We couldn't find any events matching your criteria. Please try a different search or browse all events.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary">Back to Home</a>
                </div>
            @endif
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var locationSelect = document.getElementById('location-select');
    var cards = document.querySelectorAll('.event-list-card');
    var emptyFilter = document.getElementById('event-list-empty-filter');
    var clearBtn = document.getElementById('clear-location-filter');

    function filterByLocation(locationId) {
        var visibleCount = 0;

        cards.forEach(function (card) {
            var matches = !locationId || String(card.dataset.locationId) === String(locationId);
            card.style.display = matches ? '' : 'none';
            if (matches) {
                visibleCount++;
            }
        });

        if (emptyFilter) {
            emptyFilter.classList.toggle('d-none', visibleCount > 0);
        }
    }

    if (locationSelect) {
        locationSelect.addEventListener('change', function () {
            filterByLocation(this.value);
        });
    }

    if (clearBtn && locationSelect) {
        clearBtn.addEventListener('click', function () {
            locationSelect.value = '';
            filterByLocation('');
        });
    }
});
</script>

@endsection
