@extends('layout.mainlayout')

@push('customer_banner_hero')
@php
    $isSearch = !empty($search);
    $heroTitle = $isSearch
        ? 'SEARCH RESULTS'
        : (strtoupper($event_tag->tag_name ?? 'Events') . ' TICKETS');
    $heroCrumb = $isSearch
        ? 'Search Results'
        : (($event_tag->tag_name ?? 'Events') . ' Tickets');
@endphp
<div class="customer-site-banner__hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $heroCrumb }}
                </li>
            </ol>
        </nav>

        <div class="row align-items-end">
            <div class="col-lg-6">
                <h1 class="customer-site-banner__hero-title">
                    {{ $heroTitle }}
                </h1>
                <p class="customer-site-banner__hero-meta">
                    @if($isSearch)
                        {{ $listings->count() }} {{ Str::plural('result', $listings->count()) }} for "{{ $search }}"
                    @else
                        {{ $listings->count() }} {{ Str::plural('showtime', $listings->count()) }} available
                    @endif
                </p>
            </div>
            <div class="col-lg-6">
                <div class="row g-2 event-list-hero-filters">
                    <div class="col-md-4">
                        <div class="customer-site-banner__hero-filter">
                            <label for="date-select">Date</label>
                            <select class="form-control" id="date-select">
                                <option value="">All Dates</option>
                                @foreach (($dateFilters ?? collect()) as $dateFilter)
                                    <option value="{{ $dateFilter['id'] }}">{{ $dateFilter['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="customer-site-banner__hero-filter">
                            <label for="venue-select">Venue</label>
                            <select class="form-control" id="venue-select">
                                <option value="">All Venues</option>
                                @foreach (($venueFilters ?? collect()) as $venueFilter)
                                    <option value="{{ $venueFilter['id'] }}">{{ $venueFilter['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="customer-site-banner__hero-filter">
                            <label for="country-select">Country</label>
                            <select class="form-control" id="country-select">
                                <option value="">All Countries</option>
                                @foreach (($countryFilters ?? collect()) as $countryFilter)
                                    <option value="{{ $countryFilter['id'] }}">{{ $countryFilter['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
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

            @if($listings->count() > 0)
                <div class="event-list-cards" id="event-list-cards">
                    @foreach ($listings as $item)
                        @php
                            $val = $item->event;
                            $timing = $item->timing;
                            $singleDay = $val->event_from_date == $val->event_to_date;
                            $eventDate = $timing->event_date
                                ?? ($singleDay ? $val->event_to_date : $val->event_from_date);
                            $timeText = $timing && $timing->from_time
                                ? date('g:i A', strtotime($timing->from_time))
                                : '';
                            $toTimeText = $timing && $timing->to_time
                                ? date('g:i A', strtotime($timing->to_time))
                                : '';

                            $badge = null;
                            if ($eventDate) {
                                $yourDate = \Carbon\Carbon::parse($eventDate);
                                $startDate = \Carbon\Carbon::now()->startOfWeek();
                                $endDate = \Carbon\Carbon::now()->endOfWeek();
                                if ($yourDate->greaterThanOrEqualTo($startDate) && $yourDate->lessThanOrEqualTo($endDate)) {
                                    $badge = 'This Week';
                                }
                            }

                            $locationParts = array_filter([
                                $val->venue_name ?? null,
                                $val->city_name ?? null,
                                $val->country_name ?? null,
                            ]);
                            $locationLabel = implode(', ', $locationParts);
                            $ticketUrl = url('show_details_show', $val->id);
                            if (!empty($timing?->id)) {
                                $ticketUrl .= '?timing=' . $timing->id;
                            }
                        @endphp
                        <article
                            class="event-list-card"
                            data-date="{{ $eventDate ? date('Y-m-d', strtotime($eventDate)) : '' }}"
                            data-venue-id="{{ $val->venue_id ?? $val->venue ?? '' }}"
                            data-country-id="{{ $val->country_id ?? '' }}"
                            data-location-id="{{ $val->city_id ?? '' }}"
                            data-timing-id="{{ $timing->id ?? '' }}"
                        >
                            <div class="event-list-card__media">
                                <img
                                    src="{{ !empty($val->event_image) ? asset('storage/uploads/events/' . $val->event_image) : asset('assets/img/events/event-01.jpg') }}"
                                    alt="{{ $val->event_name }}"
                                    loading="lazy"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/img/default-event.jpg') }}';">
                            </div>

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
                                    @if($locationLabel !== '')
                                        <span><i class="fas fa-map-marker-alt"></i> {{ $locationLabel }}</span>
                                    @endif
                                    <span>
                                        <i class="far fa-clock"></i>
                                        @if($timing)
                                            {{ $eventDate ? date('d M Y', strtotime($eventDate)) : '' }}
                                            @if($timeText)
                                                · {{ $timeText }}@if($toTimeText) – {{ $toTimeText }}@endif
                                            @endif
                                        @elseif($singleDay)
                                            {{ $eventDate ? date('d M Y', strtotime($eventDate)) : '' }}
                                        @else
                                            {{ $val->event_from_date ? date('d M Y', strtotime($val->event_from_date)) : '' }}
                                            –
                                            {{ $val->event_to_date ? date('d M Y', strtotime($val->event_to_date)) : '' }}
                                        @endif
                                    </span>
                                </div>
                                @if($badge)
                                    <span class="event-list-card__badge">{{ $badge }}</span>
                                @endif
                            </div>

                            <div class="event-list-card__cta">
                                <a href="{{ $ticketUrl }}" class="event-list-card__btn">See Tickets</a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="event-list-empty d-none" id="event-list-empty-filter">
                    <h4>No showtimes match these filters</h4>
                    <p>Try a different date, venue, or country, or clear the filters.</p>
                    <button type="button" class="btn btn-primary" id="clear-list-filters">Show All</button>
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
    var dateSelect = document.getElementById('date-select');
    var venueSelect = document.getElementById('venue-select');
    var countrySelect = document.getElementById('country-select');
    var cards = document.querySelectorAll('.event-list-card');
    var emptyFilter = document.getElementById('event-list-empty-filter');
    var clearBtn = document.getElementById('clear-list-filters');

    function applyFilters() {
        var dateValue = dateSelect ? dateSelect.value : '';
        var venueId = venueSelect ? venueSelect.value : '';
        var countryId = countrySelect ? countrySelect.value : '';
        var visibleCount = 0;

        cards.forEach(function (card) {
            var matchesDate = !dateValue || String(card.dataset.date) === String(dateValue);
            var matchesVenue = !venueId || String(card.dataset.venueId) === String(venueId);
            var matchesCountry = !countryId || String(card.dataset.countryId) === String(countryId);
            var matches = matchesDate && matchesVenue && matchesCountry;
            card.style.display = matches ? '' : 'none';
            if (matches) {
                visibleCount++;
            }
        });

        if (emptyFilter) {
            emptyFilter.classList.toggle('d-none', visibleCount > 0);
        }
    }

    [dateSelect, venueSelect, countrySelect].forEach(function (select) {
        if (select) {
            select.addEventListener('change', applyFilters);
        }
    });

    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            if (dateSelect) dateSelect.value = '';
            if (venueSelect) venueSelect.value = '';
            if (countrySelect) countrySelect.value = '';
            applyFilters();
        });
    }
});
</script>

@endsection
