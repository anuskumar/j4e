@extends('layout.mainlayout')
@section('content')

@php
    $defaultEventImg = asset('assets/img/events/event-01.jpg');
    $defaultVenueImg = asset('assets/img/default-venue.jpg');
    $eventImageUrl = !empty($event_datas->event_image)
        ? asset('storage/uploads/events/' . $event_datas->event_image)
        : $defaultEventImg;
    $venueImageUrl = !empty($event_datas->venue_image)
        ? asset('storage/uploads/venue/' . $event_datas->venue_image)
        : $defaultVenueImg;
    $currencyLabel = $allTickets[0]['ticket']->short_name ?? '';
    $eventDateLabel = $event_datas->event_from_date
        ? \Carbon\Carbon::parse($event_datas->event_from_date)->format('d M • D • Y')
        : '';
    $eventTimeLabel = $event_timing->from_time ?? ($allTickets[0]['from_time'] ?? '');
    if ($eventTimeLabel) {
        $eventTimeLabel = \Carbon\Carbon::parse($eventTimeLabel)->format('H:i');
    }
    $locationLabel = trim(($event_datas->venue_name ?? '') . ', ' . ($event_datas->location_name ?? '') . ', ' . ($event_datas->country_name ?? ''));
@endphp

<style>
    body:has(.ticket-picker-page) {
        overflow: hidden;
    }

    body:has(.ticket-picker-page) .customer-site-banner,
    body:has(.ticket-picker-page) .site-footer {
        display: none;
    }

    .ticket-picker-page {
        width: 100%;
        max-width: none;
        height: calc(100vh - 76px);
        min-height: 480px;
        margin: 0;
        padding: 12px 20px 0;
        display: flex;
        flex-direction: column;
        overflow: visible;
        box-sizing: border-box;
    }

    .ticket-picker-page__top {
        flex-shrink: 0;
        overflow: visible;
        position: relative;
        z-index: 30;
    }

    .ticket-picker-page__body {
        flex: 1;
        min-height: 0;
        margin: 0;
        --bs-gutter-y: 0;
        overflow: hidden;
    }

    .ticket-picker-page__body > [class*="col-"] {
        height: 100%;
        display: flex;
        flex-direction: column;
        min-height: 0;
    }

    .event-header-bar {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 8px 0 12px;
        border-bottom: 1px solid #e8ebf3;
        margin-bottom: 12px;
    }

    .event-header-bar__thumb {
        width: 72px;
        height: 72px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
        border: 1px solid #e8ebf3;
    }

    .event-header-bar__title {
        font-size: 22px;
        font-weight: 700;
        margin: 0 0 4px;
        color: #1a1a2e;
    }

    .event-header-bar__meta {
        font-size: 14px;
        color: #4b5563;
        margin: 0;
        line-height: 1.5;
    }

    .event-header-bar__venue {
        font-size: 13px;
        color: #6b7280;
        margin: 2px 0 0;
    }

    .filter-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding-bottom: 12px;
        margin-bottom: 12px;
        border-bottom: 1px solid #e8ebf3;
        overflow: visible;
        position: relative;
        z-index: 30;
    }

    .filter-bar .dropdown {
        position: relative;
    }

    .filter-bar .dropdown-menu {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        min-width: 190px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.12);
        padding: 6px 0;
        z-index: 2000;
        max-height: 280px;
        overflow-y: auto;
    }

    .filter-bar .dropdown-menu.show {
        display: block;
    }

    .filter-bar .dropdown-item {
        font-size: 14px;
        padding: 8px 16px;
        color: #374151;
    }

    .filter-bar .dropdown-item:hover,
    .filter-bar .dropdown-item:focus {
        background: #faf5fb;
        color: #7e0982;
    }

    .quantity-more-wrap {
        list-style: none;
    }

    .quantity-custom-panel {
        padding: 10px 14px 12px;
        border-top: 1px solid #e5e7eb;
    }

    .quantity-custom-panel label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }

    .quantity-custom-panel__row {
        display: flex;
        gap: 6px;
        align-items: center;
    }

    .quantity-custom-panel input {
        flex: 1;
        min-width: 0;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        padding: 7px 10px;
        font-size: 14px;
    }

    .quantity-custom-panel input:focus {
        outline: none;
        border-color: #7e0982;
        box-shadow: 0 0 0 2px rgba(126, 9, 130, 0.12);
    }

    .quantity-custom-panel button {
        background: #7e0982;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 7px 12px;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
    }

    .quantity-custom-panel button:hover {
        background: #6a0770;
    }

    .quantity-custom-hint {
        display: block;
        margin-top: 6px;
        font-size: 11px;
        color: #6b7280;
    }

    .filter-bar .dropdown-divider {
        margin: 4px 0;
    }

    .filter-pill {
        border: 1px solid #d1d5db;
        background: #fff;
        color: #374151;
        border-radius: 999px;
        padding: 8px 18px;
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .filter-pill:hover,
    .filter-pill.active {
        border-color: #7e0982;
        color: #7e0982;
        background: #faf5fb;
    }

    .filter-pill.dropdown-toggle::after {
        margin-left: 4px;
    }

    .venue-map-panel {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
        height: 100%;
    }

    .image-container {
        position: relative;
        overflow: hidden;
        border: 1px solid #e8ebf3;
        border-radius: 12px;
        background: #f8f9fc;
        cursor: grab;
        flex: 1;
        min-height: 0;
        display: flex;
        flex-direction: column;
    }

    .zoomable-image {
        width: 100%;
        height: 100%;
        min-height: 0;
        flex: 1;
        object-fit: contain;
        display: block;
        transition: transform 0.2s ease;
        transform-origin: center center;
        cursor: grab;
        background: #fff;
    }

    .zoom-controls {
        position: absolute;
        top: 12px;
        right: 12px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        z-index: 2;
    }

    .zoom-btn {
        width: 36px;
        height: 36px;
        background: #fff;
        color: #4b5563;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 18px;
        line-height: 1;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .map-legend {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        padding: 10px 4px 0;
        font-size: 12px;
        color: #6b7280;
        flex-shrink: 0;
    }

    .map-legend span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .map-legend .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }

    .listings-panel {
        height: 100%;
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        padding-right: 6px;
        padding-bottom: 12px;
    }

    .listings-panel::-webkit-scrollbar {
        width: 6px;
    }

    .listings-panel::-webkit-scrollbar-thumb {
        background: #c4c4c4;
        border-radius: 4px;
    }

    .listings-insights {
        background: #f8f9fc;
        border: 1px solid #e8ebf3;
        border-radius: 10px;
        padding: 12px 14px;
        margin-bottom: 14px;
        font-size: 13px;
        color: #4b5563;
        line-height: 1.6;
    }

    .listings-insights strong {
        color: #111827;
    }

    .listings-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .listings-toolbar__count {
        font-size: 15px;
        color: #111827;
        font-weight: 700;
    }

    .listings-toolbar select {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 13px;
        min-width: 170px;
        background: #fff;
    }

    .ticket-card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 16px 18px;
        margin-bottom: 12px;
        background: #fff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
        position: relative;
    }

    .ticket-card:hover {
        border-color: #7e0982;
        box-shadow: 0 6px 18px rgba(126, 9, 130, 0.1);
    }

    .ticket-card__top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 10px;
    }

    .ticket-card__section {
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 4px;
        color: #111827;
        line-height: 1.3;
    }

    .ticket-card__qty {
        font-size: 14px;
        color: #374151;
        font-weight: 500;
        margin: 0;
    }

    .ticket-card__score {
        flex-shrink: 0;
        min-width: 58px;
        text-align: center;
        border-radius: 8px;
        padding: 6px 8px;
        background: #ecfdf5;
        border: 1px solid #bbf7d0;
    }

    .ticket-card__score-value {
        display: block;
        font-size: 18px;
        font-weight: 800;
        color: #047857;
        line-height: 1;
    }

    .ticket-card__score-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #047857;
        text-transform: uppercase;
        margin-top: 2px;
    }

    .ticket-card__tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin: 10px 0 8px;
    }

    .ticket-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: #4b5563;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 4px 8px;
    }

    .ticket-tag i {
        color: #7e0982;
        font-size: 11px;
    }

    .ticket-tag--warning {
        background: #fffbeb;
        border-color: #fde68a;
        color: #92400e;
    }

    .ticket-tag--highlight {
        background: #fdf2f8;
        border-color: #f5d0fe;
        color: #86198f;
        font-weight: 600;
    }

    .ticket-card__footer {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 16px;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #f3f4f6;
    }

    .ticket-card__notes {
        flex: 1;
        min-width: 0;
    }

    .ticket-card__note-line {
        font-size: 12px;
        color: #6b7280;
        margin: 0 0 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .ticket-card__price-block {
        text-align: right;
        flex-shrink: 0;
    }

    .ticket-card__price {
        font-size: 24px;
        font-weight: 800;
        color: #111827;
        margin: 0;
        line-height: 1.1;
    }

    .ticket-card__each {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .ticket-card__face-value {
        font-size: 11px;
        color: #9ca3af;
        text-decoration: line-through;
        margin-bottom: 4px;
    }

    .btn-book {
        background: #7e0982;
        border-color: #7e0982;
        border-radius: 8px;
        padding: 10px 22px;
        font-weight: 700;
        font-size: 14px;
        min-width: 100px;
    }

    .btn-book:hover {
        background: #6a076d;
        border-color: #6a076d;
    }

    .btn-book:disabled {
        opacity: 0.55;
        cursor: not-allowed;
    }

    .filter-pill--required {
        border-color: #7e0982;
    }

    .quantity-required-hint {
        font-size: 12px;
        color: #9d174d;
    }

    .no-results-box {
        border: 1px dashed #d1d5db;
        border-radius: 12px;
        padding: 32px 20px;
        text-align: center;
        color: #6b7280;
        background: #fafafa;
    }

    @media (max-width: 991px) {
        body:has(.ticket-picker-page) {
            overflow: auto;
        }

        .ticket-picker-page {
            height: auto;
            min-height: calc(100vh - 76px);
            overflow: visible;
            padding-bottom: 24px;
        }

        .ticket-picker-page__body > [class*="col-"] {
            height: auto;
        }

        .venue-map-panel {
            margin-bottom: 20px;
        }

        .image-container {
            min-height: 360px;
        }

        .zoomable-image {
            min-height: 360px;
        }

        .listings-panel {
            height: auto;
            max-height: none;
            overflow-y: visible;
        }
    }
</style>

<div class="ticket-picker-page">
    <input type="hidden" id="event-id" value="{{ $id }}">

    <div class="ticket-picker-page__top">
    <div class="event-header-bar">
        <img src="{{ $eventImageUrl }}" alt="{{ $event_datas->event_name }}" class="event-header-bar__thumb"
            onerror="this.onerror=null;this.src='{{ $defaultEventImg }}';">
        <div>
            <h1 class="event-header-bar__title">{{ Str::ucfirst($event_datas->event_name ?? '') }}</h1>
            <p class="event-header-bar__meta">
                @if ($eventDateLabel)
                    {{ $eventDateLabel }}
                    @if ($eventTimeLabel)
                        • {{ $eventTimeLabel }}
                    @endif
                @endif
            </p>
            <p class="event-header-bar__venue">{{ $locationLabel }}</p>
            @if (!empty($event_datas->tag_name))
                <p class="event-header-bar__venue mb-0">{{ $event_datas->tag_name }}</p>
            @endif
        </div>
    </div>

    <div class="filter-bar">
        <div class="dropdown">
            <button class="filter-pill dropdown-toggle" type="button" id="zoneDropdown" aria-haspopup="true" aria-expanded="false">
                Zone
            </button>
            <ul class="dropdown-menu" id="zoneOptions">
                <li><a class="dropdown-item zone-option" href="#" data-value="all">Show All</a></li>
                @if (!empty($available_zones))
                    @foreach ($available_zones as $zone)
                        <li><a class="dropdown-item zone-option" href="#" data-value="{{ $zone }}">{{ $zone }}</a></li>
                    @endforeach
                @else
                    @foreach ($venue_seating as $seating)
                        <li><a class="dropdown-item zone-option" href="#" data-value="{{ $seating->seating_type_name }}">{{ $seating->seating_type_name }}</a></li>
                    @endforeach
                @endif
            </ul>
        </div>

        <div class="dropdown">
            <button class="filter-pill dropdown-toggle filter-pill--required" type="button" id="quantityDropdown" aria-haspopup="true" aria-expanded="false">
                Quantity <span class="quantity-required-hint">*</span>
            </button>
            <ul class="dropdown-menu" id="quantityOptions">
                @for ($q = 1; $q <= $maxQuantityOption; $q++)
                    <li><a class="dropdown-item quantity-option" href="#" data-value="{{ $q }}">{{ $q }} Ticket{{ $q > 1 ? 's' : '' }}</a></li>
                @endfor
            </ul>
        </div>

        <div class="dropdown">
            <button class="filter-pill dropdown-toggle" type="button" id="priceDropdown" aria-haspopup="true" aria-expanded="false">
                @if ($minPrice > 0 && $maxPrice > 0)
                    Price: {{ number_format($minPrice, 0) }} – {{ number_format($maxPrice, 0) }}{{ $currencyLabel ? ' ' . $currencyLabel : '' }}
                @else
                    Price Range
                @endif
            </button>
            <ul class="dropdown-menu" id="priceOptions">
                <li><a class="dropdown-item price-option" href="#" data-min="0" data-max="999999999">Any Price</a></li>
                @if ($minPrice > 0 && $maxPrice > $minPrice)
                    @php
                        $mid = ($minPrice + $maxPrice) / 2;
                    @endphp
                    <li><a class="dropdown-item price-option" href="#" data-min="{{ floor($minPrice) }}" data-max="{{ floor($mid) }}">Up to {{ number_format($mid, 0) }}{{ $currencyLabel ? ' ' . $currencyLabel : '' }}</a></li>
                    <li><a class="dropdown-item price-option" href="#" data-min="{{ floor($mid) }}" data-max="{{ ceil($maxPrice) }}">{{ number_format($mid, 0) }} – {{ number_format($maxPrice, 0) }}{{ $currencyLabel ? ' ' . $currencyLabel : '' }}</a></li>
                    <li><a class="dropdown-item price-option" href="#" data-min="{{ ceil($maxPrice * 0.8) }}" data-max="{{ ceil($maxPrice) }}">{{ number_format($maxPrice * 0.8, 0) }}+{{ $currencyLabel ? ' ' . $currencyLabel : '' }}</a></li>
                @endif
            </ul>
        </div>
    </div>
    </div>

    <div class="row g-4 ticket-picker-page__body">
        <div class="col-lg-7">
            <div class="venue-map-panel">
                <div class="image-container">
                    <img src="{{ $venueImageUrl }}" alt="{{ $event_datas->venue_name ?? 'Venue map' }}" class="zoomable-image" id="hero-venue-image"
                        onerror="this.onerror=null;this.src='{{ $defaultVenueImg }}';">
                    <div class="zoom-controls">
                        <button type="button" id="zoom-in" class="zoom-btn" aria-label="Zoom in">+</button>
                        <button type="button" id="zoom-out" class="zoom-btn" aria-label="Zoom out">−</button>
                        <button type="button" id="reset" class="zoom-btn" aria-label="Reset zoom">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="map-legend">
                    <span><span class="dot" style="background:#22c55e;"></span> Available seating zones</span>
                    <span><span class="dot" style="background:#d1d5db;"></span> Venue layout reference</span>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="listings-panel" id="listings-panel">
                @if ($listingCount > 0)
                    <div class="listings-insights">
                        <strong>{{ $totalAvailableSeats }}+ tickets</strong> available across
                        <strong>{{ $listingCount }} listing{{ $listingCount === 1 ? '' : 's' }}</strong>
                        @if ($minPrice > 0)
                            · Prices from <strong>{{ number_format($minPrice, 0) }} {{ $currencyLabel }}</strong>
                        @endif
                    </div>
                @endif

                <div class="listings-toolbar">
                    <div class="listings-toolbar__count">
                        <span id="visible-listing-count">{{ $listingCount }}</span> listing{{ $listingCount === 1 ? '' : 's' }}
                    </div>
                    <select id="sort-listings" aria-label="Sort listings">
                        <option value="price-asc">Sort by price</option>
                        <option value="price-desc">Price: high to low</option>
                        <option value="qty-desc">Most tickets first</option>
                    </select>
                </div>

                <div id="no-results-message" class="no-results-box" style="display: none;">
                    <h5 class="mb-2">No tickets match your filters</h5>
                    <p class="mb-0">Try adjusting your zone or quantity selections to see more options.</p>
                </div>

                <div id="ticket-list">
                    @foreach ($allTickets as $item)
                        @php
                            $dat = $item['ticket'];
                            $ticketPrice = $item['price'];
                            $qtyLabel = $item['availability'] == 1 ? '1 ticket' : $item['availability'] . ' tickets';
                        @endphp
                        <div class="ticket-card ticket-container"
                            data-availability="{{ $item['availability'] }}"
                            data-zone="{{ $dat->seating_type_name }}"
                            data-price="{{ $ticketPrice }}"
                            data-split-type="{{ $dat->split_type }}">
                            <div class="ticket-card__top">
                                <div>
                                    <h3 class="ticket-card__section">{{ $item['section_label'] }}</h3>
                                    <p class="ticket-card__qty">{{ $qtyLabel }}</p>
                                </div>
                                @if ($item['is_best_value'] || $item['is_cheapest'])
                                    <div class="ticket-card__score">
                                        <span class="ticket-card__score-value">{{ number_format($item['value_score'], 1) }}</span>
                                        <span class="ticket-card__score-label">{{ $item['is_cheapest'] ? 'Best' : 'Great' }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="ticket-card__tags">
                                @if ($item['is_cheapest'])
                                    <span class="ticket-tag ticket-tag--highlight"><i class="fas fa-tag"></i> Cheapest</span>
                                @endif
                                @if ($dat->ticket_type_name)
                                    <span class="ticket-tag"><i class="fas fa-ticket-alt"></i> {{ $dat->ticket_type_name }}</span>
                                @endif
                                @if (!empty($dat->split_type_name))
                                    <span class="ticket-tag"><i class="fas fa-layer-group"></i> {{ $dat->split_type_name }}</span>
                                @endif
                                @if ($item['has_eticket'])
                                    <span class="ticket-tag"><i class="fas fa-bolt"></i> Instant download</span>
                                @endif
                                @foreach ($item['restrictions'] as $restriction)
                                    <span class="ticket-tag ticket-tag--warning"><i class="fas fa-exclamation-circle"></i> {{ $restriction }}</span>
                                @endforeach
                                @if (empty($item['restrictions']))
                                    <span class="ticket-tag"><i class="fas fa-eye"></i> Clear view</span>
                                @endif
                            </div>

                            <div class="ticket-card__footer">
                                <div class="ticket-card__notes">
                                    <p class="ticket-card__note-line">
                                        <i class="far fa-calendar-alt"></i>
                                        {{ isset($item['event_date']) ? date('D, d M Y', strtotime($item['event_date'])) : '-' }}
                                        @if (!empty($item['from_time']))
                                            · {{ date('g:i A', strtotime($item['from_time'])) }}
                                            @if (!empty($item['to_time']))
                                                – {{ date('g:i A', strtotime($item['to_time'])) }}
                                            @endif
                                        @endif
                                    </p>
                                    <p class="ticket-card__note-line">
                                        <i class="fas fa-map-marker-alt"></i> {{ $dat->seating_type_name ?? 'Venue seating' }}
                                    </p>
                                    @if ($item['availability'] <= 3)
                                        <p class="ticket-card__note-line" style="color:#9d174d;font-weight:600;">
                                            <i class="fas fa-fire"></i>
                                            Only {{ $item['availability'] }} ticket{{ $item['availability'] == 1 ? '' : 's' }} left in this listing
                                        </p>
                                    @else
                                        <p class="ticket-card__note-line">
                                            <i class="fas fa-chair"></i>
                                            {{ $item['availability'] }} tickets remaining in this listing
                                        </p>
                                    @endif
                                </div>
                                <div class="ticket-card__price-block">
                                    @if ($item['face_value'] > $ticketPrice)
                                        <div class="ticket-card__face-value">{{ number_format($item['face_value'], 0) }} {{ $dat->short_name ?? '' }}</div>
                                    @endif
                                    <p class="ticket-card__price">{{ number_format($ticketPrice, 0) }} <span style="font-size:14px;font-weight:600;">{{ $dat->short_name ?? '' }}</span></p>
                                    <div class="ticket-card__each">each incl. fees</div>
                                    <form action="{{ url('submit_ticket_selected') }}" method="POST">
                                        @csrf
                                        <input type="hidden" value="{{ $dat->id }}" name="event_ticket">
                                        <input type="hidden" name="buy_count" value="">
                                        <button class="btn btn-primary btn-book" type="submit" disabled title="Please select quantity first">Book</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentZone = 'all';
    let currentQuantity = 1;
    let quantitySelected = false;
    let customQuantityMode = false;
    let currentMinPrice = 0;
    let currentMaxPrice = Number.MAX_SAFE_INTEGER;

    const zoneButton = document.getElementById('zoneDropdown');
    const quantityButton = document.getElementById('quantityDropdown');
    const priceButton = document.getElementById('priceDropdown');
    const quantityOptionsMenu = document.getElementById('quantityOptions');
    const ticketList = document.getElementById('ticket-list');
    const visibleCountEl = document.getElementById('visible-listing-count');
    const noResultsMessage = document.getElementById('no-results-message');
    const filterBar = document.querySelector('.filter-bar');

    function closeAllFilterDropdowns() {
        if (!filterBar) return;
        filterBar.querySelectorAll('.dropdown-toggle').forEach(function (button) {
            button.classList.remove('show');
            button.setAttribute('aria-expanded', 'false');
            const menu = button.nextElementSibling;
            if (menu) {
                menu.classList.remove('show');
            }
        });
    }

    function closeDropdown(button) {
        closeAllFilterDropdowns();
    }

    if (filterBar) {
        filterBar.querySelectorAll('.dropdown-toggle').forEach(function (button) {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const menu = this.nextElementSibling;
                const willOpen = !(menu && menu.classList.contains('show'));
                closeAllFilterDropdowns();
                if (willOpen && menu) {
                    menu.classList.add('show');
                    this.classList.add('show');
                    this.setAttribute('aria-expanded', 'true');
                }
            });
        });

        document.addEventListener('click', function (e) {
            if (!e.target.closest('.filter-bar .dropdown')) {
                closeAllFilterDropdowns();
            }
        });
    }

    const maxQuantityCap = 6;

    function getMaxAvailableForZone(zone) {
        let maxQty = 0;
        document.querySelectorAll('.ticket-container').forEach(function (ticket) {
            const ticketZone = ticket.getAttribute('data-zone') || '';
            const availability = parseInt(ticket.getAttribute('data-availability'), 10) || 0;
            if (zone === 'all' || ticketZone === zone) {
                maxQty = Math.max(maxQty, availability);
            }
        });
        return maxQty;
    }

    function hideCustomQuantityPanel() {
        const panel = document.getElementById('quantityCustomPanel');
        if (panel) {
            panel.style.display = 'none';
        }
    }

    function showCustomQuantityPanel() {
        const panel = document.getElementById('quantityCustomPanel');
        const input = document.getElementById('quantityCustomInput');
        if (panel) {
            panel.style.display = 'block';
        }
        if (input) {
            input.value = currentQuantity > maxQuantityCap ? currentQuantity : maxQuantityCap + 1;
            input.focus();
            input.select();
        }
    }

    function applyCustomQuantity() {
        const input = document.getElementById('quantityCustomInput');
        if (!input) return;

        const availableMax = getMaxAvailableForZone(currentZone);
        let qty = parseInt(input.value, 10);

        if (isNaN(qty) || qty <= maxQuantityCap) {
            alert('Please enter a quantity greater than 6.');
            return;
        }

        if (availableMax > 0 && qty > availableMax) {
            alert('Only ' + availableMax + ' ticket(s) are available for the selected zone.');
            qty = availableMax;
            input.value = qty;
        }

        currentQuantity = qty;
        quantitySelected = true;
        customQuantityMode = true;
        updateQuantityLabel();
        closeDropdown(quantityButton);
        applyFilters();
    }

    function rebuildQuantityOptions() {
        if (!quantityOptionsMenu) return;

        const availableMax = getMaxAvailableForZone(currentZone);
        const standardMax = Math.max(1, Math.min(maxQuantityCap, availableMax || maxQuantityCap));

        if (availableMax > 0 && currentQuantity > availableMax) {
            currentQuantity = availableMax;
            customQuantityMode = currentQuantity > maxQuantityCap;
        }
        if (currentQuantity <= maxQuantityCap) {
            customQuantityMode = false;
        }

        quantityOptionsMenu.innerHTML = '';
        for (let q = 1; q <= standardMax; q++) {
            const li = document.createElement('li');
            const link = document.createElement('a');
            link.className = 'dropdown-item quantity-option';
            link.href = '#';
            link.setAttribute('data-value', String(q));
            link.textContent = q + ' Ticket' + (q > 1 ? 's' : '');
            li.appendChild(link);
            quantityOptionsMenu.appendChild(li);
        }

        const divider = document.createElement('li');
        divider.innerHTML = '<hr class="dropdown-divider">';
        quantityOptionsMenu.appendChild(divider);

        const moreWrap = document.createElement('li');
        moreWrap.className = 'quantity-more-wrap';

        const moreLink = document.createElement('a');
        moreLink.className = 'dropdown-item quantity-more-option';
        moreLink.href = '#';
        moreLink.textContent = 'More than 6';
        moreWrap.appendChild(moreLink);

        const panel = document.createElement('div');
        panel.className = 'quantity-custom-panel';
        panel.id = 'quantityCustomPanel';
        panel.style.display = 'none';
        panel.innerHTML =
            '<label for="quantityCustomInput">Enter ticket quantity</label>' +
            '<div class="quantity-custom-panel__row">' +
                '<input type="number" id="quantityCustomInput" min="7" step="1" value="' + (currentQuantity > maxQuantityCap ? currentQuantity : (maxQuantityCap + 1)) + '">' +
                '<button type="button" id="quantityCustomApply">Apply</button>' +
            '</div>' +
            '<small class="quantity-custom-hint">Max available: ' + (availableMax || 0) + '</small>';
        moreWrap.appendChild(panel);
        quantityOptionsMenu.appendChild(moreWrap);

        updateQuantityLabel();
    }

    function updateQuantityLabel() {
        if (!quantitySelected) {
            quantityButton.innerHTML = 'Quantity <span class="quantity-required-hint">*</span>';
            quantityButton.classList.remove('active');
            updateBookButtons();
            return;
        }

        quantityButton.textContent = currentQuantity + ' Ticket' + (currentQuantity > 1 ? 's' : '');
        quantityButton.classList.add('active');
        updateBookButtons();
    }

    function updateBookButtons() {
        document.querySelectorAll('.btn-book').forEach(function (button) {
            const card = button.closest('.ticket-container');
            const isVisible = card && card.style.display !== 'none';
            const canBook = quantitySelected && isVisible;
            button.disabled = !canBook;
            button.title = quantitySelected ? '' : 'Please select quantity first';
        });
    }

    if (filterBar) {
        filterBar.addEventListener('click', function (e) {
            const zoneOption = e.target.closest('.zone-option');
            if (zoneOption) {
                e.preventDefault();
                currentZone = zoneOption.getAttribute('data-value') || 'all';
                zoneButton.textContent = currentZone === 'all' ? 'Zone' : currentZone;
                zoneButton.classList.toggle('active', currentZone !== 'all');
                closeDropdown(zoneButton);
                rebuildQuantityOptions();
                applyFilters();
                return;
            }

            const quantityOption = e.target.closest('.quantity-option');
            if (quantityOption) {
                e.preventDefault();
                e.stopPropagation();
                customQuantityMode = false;
                hideCustomQuantityPanel();
                currentQuantity = parseInt(quantityOption.getAttribute('data-value'), 10) || 1;
                quantitySelected = true;
                updateQuantityLabel();
                closeDropdown(quantityButton);
                applyFilters();
                return;
            }

            if (e.target.closest('#quantityCustomApply')) {
                e.preventDefault();
                e.stopPropagation();
                applyCustomQuantity();
                return;
            }

            const moreOption = e.target.closest('.quantity-more-option');
            if (moreOption) {
                e.preventDefault();
                e.stopPropagation();
                showCustomQuantityPanel();
                return;
            }

            const priceOption = e.target.closest('.price-option');
            if (priceOption) {
                e.preventDefault();
                currentMinPrice = parseFloat(priceOption.getAttribute('data-min'));
                currentMaxPrice = parseFloat(priceOption.getAttribute('data-max'));
                priceButton.textContent = priceOption.textContent.trim();
                priceButton.classList.add('active');
                closeDropdown(priceButton);
                applyFilters();
            }
        });
    }

    if (filterBar) {
        filterBar.addEventListener('keydown', function (e) {
            if (e.target.id === 'quantityCustomInput' && e.key === 'Enter') {
                e.preventDefault();
                applyCustomQuantity();
            }
        });
    }

    document.getElementById('sort-listings').addEventListener('change', function () {
        const cards = Array.from(document.querySelectorAll('.ticket-container'));
        cards.sort(function (a, b) {
            const priceA = parseFloat(a.getAttribute('data-price'));
            const priceB = parseFloat(b.getAttribute('data-price'));
            const qtyA = parseInt(a.getAttribute('data-availability'), 10);
            const qtyB = parseInt(b.getAttribute('data-availability'), 10);

            if (this.value === 'price-desc') return priceB - priceA;
            if (this.value === 'qty-desc') return qtyB - qtyA;
            return priceA - priceB;
        }.bind(this));
        cards.forEach(function (card) {
            ticketList.appendChild(card);
        });
    });

    function applyFilters() {
        const tickets = document.querySelectorAll('.ticket-container');
        let visibleCount = 0;

        tickets.forEach(function (ticket) {
            const zone = ticket.getAttribute('data-zone');
            const availability = parseInt(ticket.getAttribute('data-availability'), 10);
            const price = parseFloat(ticket.getAttribute('data-price'));

            let shouldShow = true;
            if (currentZone !== 'all' && zone !== currentZone) shouldShow = false;
            if (shouldShow && quantitySelected && availability < currentQuantity) shouldShow = false;
            if (shouldShow && (price < currentMinPrice || price > currentMaxPrice)) shouldShow = false;

            ticket.style.display = shouldShow ? 'block' : 'none';

            if (shouldShow) {
                visibleCount++;
                const buyInput = ticket.querySelector('input[name="buy_count"]');
                if (buyInput && quantitySelected) {
                    buyInput.value = currentQuantity;
                }
            }
        });

        visibleCountEl.textContent = visibleCount;
        noResultsMessage.style.display = visibleCount === 0 ? 'block' : 'none';
        updateBookButtons();
    }

    if (ticketList) {
        ticketList.addEventListener('submit', function (e) {
            if (!quantitySelected) {
                e.preventDefault();
                alert('Please select a quantity before booking.');
                return;
            }

            const form = e.target;
            const card = form.closest('.ticket-container');
            if (!card) return;

            const availability = parseInt(card.getAttribute('data-availability'), 10) || 0;
            if (currentQuantity > availability) {
                e.preventDefault();
                alert('Only ' + availability + ' ticket(s) are available in this listing.');
                return;
            }

            const buyInput = form.querySelector('input[name="buy_count"]');
            if (buyInput) {
                buyInput.value = currentQuantity;
            }
        });
    }

    rebuildQuantityOptions();
    applyFilters();

    const image = document.getElementById('hero-venue-image');
    const zoomInBtn = document.getElementById('zoom-in');
    const zoomOutBtn = document.getElementById('zoom-out');
    const resetBtn = document.getElementById('reset');

    if (image && zoomInBtn && zoomOutBtn && resetBtn) {
        let scale = 1;
        const scaleStep = 0.15;
        let isDragging = false;
        let startX, startY;
        let translateX = 0;
        let translateY = 0;

        function updateTransform() {
            image.style.transform = `scale(${scale}) translate(${translateX}px, ${translateY}px)`;
        }

        zoomInBtn.addEventListener('click', function () {
            scale += scaleStep;
            updateTransform();
        });

        zoomOutBtn.addEventListener('click', function () {
            if (scale > scaleStep) {
                scale -= scaleStep;
                updateTransform();
            }
        });

        resetBtn.addEventListener('click', function () {
            scale = 1;
            translateX = 0;
            translateY = 0;
            updateTransform();
        });

        image.addEventListener('mousedown', function (e) {
            isDragging = true;
            startX = e.clientX - translateX;
            startY = e.clientY - translateY;
            image.style.cursor = 'grabbing';
        });

        document.addEventListener('mouseup', function () {
            isDragging = false;
            image.style.cursor = 'grab';
        });

        document.addEventListener('mousemove', function (e) {
            if (!isDragging) return;
            translateX = e.clientX - startX;
            translateY = e.clientY - startY;
            updateTransform();
        });
    }
});
</script>

@endsection
