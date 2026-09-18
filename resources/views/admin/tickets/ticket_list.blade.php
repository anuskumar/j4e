<?php $page = 'tickets/list'; ?>
@extends('admin.layout.app')

@section('page_title', 'Manage Event Tickets')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('tickets') }}">Tickets</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $event->event_name ?? 'Manage Tickets' }}</li>
@endsection

@section('admin_content')

<link href="{{ asset('admin_assets/plugins/datatable/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin_assets/plugins/datatable/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

<style>
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 6px 12px;
        margin-left: 8px;
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 6px 12px;
        margin: 0 8px;
    }

    .ticket-filters {
        background: #f8f9fc;
        border: 1px solid #e8ebf3;
        border-radius: 8px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .ticket-filters .form-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #6c757d;
        margin-bottom: 0.35rem;
    }

    .ticket-filters .filter-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: nowrap;
    }

    .event-summary {
        background: #f8f9fc;
        border: 1px solid #e8ebf3;
        border-radius: 8px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.25rem;
    }

    .event-summary .event-summary-title {
        font-weight: 600;
        font-size: 15px;
        margin-bottom: 0.25rem;
    }

    .table-action {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .approval-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.35rem;
    }

    .ticket-header-actions {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        flex-shrink: 0;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .select2-selection__choice {
        background-color: var(--primary-bg-color, #6259ca) !important;
        border: none !important;
    }
</style>

@php
    $isSuperAdmin = Auth::user()->user_type === 'superadmin';
    $listingCount = count($data);
    $pendingCount = $data->where('is_admin_approved', 0)->count();
    $exportColumns = $isReseller ? [0, 1, 2, 3, 4, 5, 6, 7, 8] : [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
    $nonOrderableTargets = $isReseller ? [9] : [10];
    $exportTitle = ($event->event_name ?? 'Event') . ' Tickets (' . now()->format('d M Y') . ')';
    $exportButtons = [
        [
            'extend' => 'excel',
            'exportOptions' => ['columns' => $exportColumns, 'stripHtml' => true],
            'title' => $exportTitle,
        ],
        [
            'extend' => 'pdf',
            'exportOptions' => ['columns' => $exportColumns, 'stripHtml' => true],
            'title' => $exportTitle,
            'orientation' => 'landscape',
            'pageSize' => 'A4',
        ],
    ];
@endphp

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div>
                        <h4 class="card-title mg-b-10">Event Ticket Listings</h4>
                        <p class="text-muted tx-12 mb-0">Manage and review ticket listings for this event.</p>
                    </div>
                    <div class="ticket-header-actions">
                        <span class="badge bg-primary-transparent tx-13 mb-0">{{ $listingCount }} {{ Str::plural('listing', $listingCount) }}</span>
                        @if ($pendingCount > 0 && $isSuperAdmin)
                            <span class="badge bg-warning tx-13 mb-0">{{ $pendingCount }} pending</span>
                        @endif
                        <a href="{{ url('events/view/' . $id . '?from=tickets') }}" class="btn btn-sm btn-outline-secondary" title="View Event">
                            <i class="far fa-eye me-1"></i> Event
                        </a>
                        <a href="{{ url('tickets') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fe fe-arrow-left me-1"></i> Back
                        </a>
                        @if ($isSuperAdmin)
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#create-ticket-modal">
                                <i class="fe fe-plus me-1"></i> Create Ticket
                            </button>
                        @endif
                        <button type="button" class="btn btn-sm btn-success" id="export-excel">
                            <i class="fe fe-download me-1"></i> Excel
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" id="export-pdf">
                            <i class="fe fe-file-text me-1"></i> PDF
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="event-summary">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                        <div>
                            <div class="event-summary-title">{{ $event->event_name }}</div>
                            <div class="text-muted tx-12">
                                @if ($event->event_type_name)
                                    <span class="badge bg-primary-transparent me-1">{{ $event->event_type_name }}</span>
                                @endif
                                @if ($event->event_from_date)
                                    {{ \Carbon\Carbon::parse($event->event_from_date)->format('d M Y') }}
                                    @if ($event->event_to_date)
                                        — {{ \Carbon\Carbon::parse($event->event_to_date)->format('d M Y') }}
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="text-muted tx-12 text-md-end">
                            @if ($event->venue_name)
                                <div><i class="fe fe-map-pin me-1"></i>{{ $event->venue_name }}</div>
                            @endif
                            @if ($event->location_name || $event->city_name)
                                <div>{{ trim(($event->location_name ?? '') . ($event->city_name ? ', ' . $event->city_name : '')) }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <form method="GET" action="{{ url('tickets/manage_tickets/' . $id) }}" class="ticket-filters">
                    <div class="row g-3 align-items-end">
                        <div class="col-xl-3 col-md-6">
                            <label class="form-label" for="search">Search</label>
                            <input type="text" name="search" id="search" class="form-control"
                                placeholder="Ticket name, reseller name or email"
                                value="{{ $filters['search'] ?? '' }}">
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <label class="form-label" for="approval_status">Approval</label>
                            <select name="approval_status" id="approval_status" class="form-control form-select">
                                <option value="">All</option>
                                <option value="pending" @selected(($filters['approval_status'] ?? '') === 'pending')>Pending</option>
                                <option value="approved" @selected(($filters['approval_status'] ?? '') === 'approved')>Approved</option>
                                <option value="rejected" @selected(($filters['approval_status'] ?? '') === 'rejected')>Rejected</option>
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <label class="form-label" for="ticket_type">Ticket Type</label>
                            <select name="ticket_type" id="ticket_type" class="form-control form-select">
                                <option value="">All Types</option>
                                @foreach ($ticket_type as $type)
                                    <option value="{{ $type->id }}" @selected(($filters['ticket_type'] ?? '') == $type->id)>
                                        {{ $type->ticket_type_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <label class="form-label" for="ticket_status">Availability</label>
                            <select name="ticket_status" id="ticket_status" class="form-control form-select">
                                <option value="">All</option>
                                @foreach ($ticketStatuses as $status)
                                    <option value="{{ $status->id }}" @selected(($filters['ticket_status'] ?? '') == $status->id)>
                                        {{ $status->status_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <label class="form-label d-block">&nbsp;</label>
                            <div class="filter-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fe fe-filter me-1"></i> Apply
                                </button>
                                <a href="{{ url('tickets/manage_tickets/' . $id) }}" class="btn btn-outline-secondary">Clear</a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap mb-0 dataTables" id="file-datatable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Listing ID</th>
                                @if (!$isReseller)
                                    <th>Reseller</th>
                                @endif
                                <th>Type</th>
                                <th>Timing</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Seating</th>
                                <th>Expiry</th>
                                <th>Approval</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $val)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="font-weight-semibold">#{{ $val->id }}</span>
                                        @if ($val->ticket_status_name)
                                            <span class="d-block mt-1">
                                                <span class="badge {{ $val->ticket_status == 1 ? 'bg-success-transparent' : 'bg-secondary-transparent' }} tx-11">
                                                    {{ $val->ticket_status_name }}
                                                </span>
                                            </span>
                                        @endif
                                    </td>
                                    @if (!$isReseller)
                                        <td>
                                            <span class="fw-semibold">{{ $val->reseller_name ?? 'N/A' }}</span>
                                            @if ($val->reseller_email)
                                                <span class="d-block text-muted tx-12">{{ $val->reseller_email }}</span>
                                            @endif
                                        </td>
                                    @endif
                                    <td>{{ $val->ticket_type_name ?? '-' }}</td>
                                    <td>
                                        @if ($val->event_date)
                                            {{ \Carbon\Carbon::parse($val->event_date)->format('d M Y') }}
                                            @if ($val->from_time && $val->to_time)
                                                <span class="d-block text-muted tx-12">
                                                    {{ \Carbon\Carbon::parse($val->from_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($val->to_time)->format('H:i') }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-info-transparent">{{ $val->no_of_tickets }}</span></td>
                                    <td>
                                        {{ number_format((float) $val->ticket_amount, 2) }}
                                        {{ $val->currency_short_name ?? '' }}
                                        @if ($val->total_recive)
                                            <span class="d-block text-muted tx-12">Total: {{ $val->total_recive }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $val->seating_type_name ?? '-' }}</td>
                                    <td>
                                        @if ($val->booking_expiry_date_time)
                                            {{ \Carbon\Carbon::parse($val->booking_expiry_date_time)->format('d M Y') }}
                                            <span class="d-block text-muted tx-12">{{ \Carbon\Carbon::parse($val->booking_expiry_date_time)->format('H:i A') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($val->is_admin_approved == 1)
                                            <span class="badge bg-success">Approved</span>
                                        @elseif ($val->is_admin_approved == 2)
                                            <span class="badge bg-danger">Rejected</span>
                                            @if (!empty($val->rejection_reason))
                                                <div class="text-muted tx-12 mt-1" title="{{ $val->rejection_reason }}">
                                                    {{ \Illuminate\Support\Str::limit($val->rejection_reason, 60) }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="badge bg-warning mb-1">Pending</span>
                                            @if ($isSuperAdmin)
                                                <div class="approval-actions">
                                                    <button type="button" class="btn btn-xs btn-success btn-sm" id="approve-btn-{{ $val->id }}" onclick="approval_warning({{ $val->id }}, {{ $val->created_by }}, this)">Approve</button>
                                                    <button type="button" class="btn btn-xs btn-danger btn-sm" id="reject-btn-{{ $val->id }}" onclick="openRejectModal({{ $val->id }}, {{ $val->created_by }})">Reject</button>
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="table-action">
                                            <a href="{{ url('tickets/ticket_view', $val->id) }}" class="btn btn-sm btn-info-light" title="View Ticket">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            @if ($val->is_admin_approved == 1)
                                                <a href="{{ url('tickets/manage_individual_tickets', $val->id) }}" class="btn btn-sm btn-primary-light" title="Manage Seats">
                                                    <i class="fas fa-ticket-alt"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $isReseller ? 10 : 11 }}" class="text-center text-muted py-4">No ticket listings found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@if ($isSuperAdmin)
<div class="modal fade" id="create-ticket-modal" tabindex="-1" aria-labelledby="createTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="createTicketModalLabel">Create Ticket Listing</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{ url('tickets/store_ticket') }}" method="POST" enctype="multipart/form-data" id="create-ticket-form">
                    @csrf
                    <input type="hidden" name="event" id="event-id" value="{{ $id }}">
                    <input type="hidden" name="features_submitted" value="1">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Ticket Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ticket_name" required value="{{ old('ticket_name') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ticket Type <span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="ticket_type" id="create-ticket-type" required>
                                <option value="">Select</option>
                                @foreach ($ticket_type as $val)
                                    @php
                                        $isMobileType = (int) $val->id === 4
                                            || (
                                                stripos($val->ticket_type_name, 'mobile') !== false
                                                && stripos($val->ticket_type_name, 'transfer') !== false
                                            );
                                    @endphp
                                    <option value="{{ $val->id }}" data-mobile="{{ $isMobileType ? 1 : 0 }}" {{ old('ticket_type') == $val->id ? 'selected' : '' }}>
                                        {{ $val->ticket_type_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 d-none" id="mobile-app-wrapper">
                            <label class="form-label">Mobile Application <span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="mobile_app" id="mobile-app-select">
                                <option value="">Select an application</option>
                                @foreach ($mobile_applications as $app)
                                    <option value="{{ $app->id }}" {{ old('mobile_app') == $app->id ? 'selected' : '' }}>{{ $app->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Event Timing <span class="text-danger">*</span></label>
                            <select class="form-control form-select" id="event-timing" onchange="reload_value()" name="event_timing" required>
                                <option value="">Select</option>
                                @foreach ($event_timing as $val)
                                    <option value="{{ $val->id }}" {{ old('event_timing') == $val->id ? 'selected' : '' }}>
                                        {{ date('d M Y', strtotime($val->event_date)) }} [{{ date('H:i', strtotime($val->from_time)) }} – {{ date('H:i', strtotime($val->to_time)) }}]
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Seating <span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="venue_seating" id="seating-select" onchange="get_available_tickets(this.value)" required>
                                <option value="">Select</option>
                                @foreach ($venue_seatings as $val)
                                    <option value="{{ $val->id }}" {{ old('venue_seating') == $val->id ? 'selected' : '' }}>
                                        {{ $val->seating_type_name }}
                                        @if (!empty($val->number_of_seats))
                                            [{{ $val->number_of_seats }} seats]
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Number Of Tickets <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="no-of-tickets" name="no_of_tickets" min="1" required value="{{ old('no_of_tickets') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Row</label>
                            <input type="text" class="form-control" name="row" id="seat-row" placeholder="e.g. A, AA" value="{{ old('row') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Seat From</label>
                            <input type="number" class="form-control" name="seat_from" id="seat-from" value="{{ old('seat_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Seat To</label>
                            <input type="number" class="form-control" name="seat_to" id="seat-to" value="{{ old('seat_to') }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Do you want to sell all your tickets together? <span class="text-danger">*</span></label>
                            <div class="row g-2">
                                @foreach ($splittypes as $split)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sell_together"
                                                id="sell_{{ $split->id }}" value="{{ $split->id }}"
                                                {{ (string) old('sell_together') === (string) $split->id ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="sell_{{ $split->id }}">{{ $split->split_name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Currency <span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="amount_currency" id="create-currency" required>
                                <option value="">Select</option>
                                @foreach ($currency as $val)
                                    @php $isCurrencyActive = (int) $val->is_active === 1; @endphp
                                    <option value="{{ $val->id }}"
                                        data-code="{{ $val->short_name }}"
                                        data-rate="{{ $val->currency_rate }}"
                                        @disabled(! $isCurrencyActive)
                                        {{ old('amount_currency') == $val->id && $isCurrencyActive ? 'selected' : '' }}>
                                        {{ $val->name }} [{{ $val->short_name }}]{{ $isCurrencyActive ? '' : ' — Inactive' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Ticket Amount <span class="text-danger">*</span></label>
                            <input type="number" step="1" min="0" class="form-control" name="ticket_amount" id="create-amount" required value="{{ old('ticket_amount') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Cents</label>
                            <input type="number" class="form-control" name="cents" id="create-cents" min="0" max="99" step="1" placeholder="00" value="{{ old('cents', 0) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Converted (USD)</label>
                            <div class="form-control-plaintext fw-semibold" id="create-converted-value">$0.00 USD</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Face Value</label>
                            <input type="number" step="0.01" min="0" class="form-control" name="face_value" id="create-face-value" value="{{ old('face_value') }}" placeholder="Defaults to ticket amount">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Booking Expiry</label>
                            <input type="datetime-local" required class="form-control" name="booking_expiry_date_time" value="{{ old('booking_expiry_date_time') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Upload Ticket</label>
                            <input type="file" name="ticket_upload" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <label class="form-label mb-0">Restrictions</label>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="toggle-new-restriction">
                                    <i class="fe fe-plus me-1"></i> Add Restriction
                                </button>
                            </div>
                            <select class="form-control select2-select" id="ticket-restrictions-select" multiple name="ticket_restrictions[]">
                                @foreach ($restrictions as $val)
                                    <option value="{{ $val->id }}" {{ collect(old('ticket_restrictions', []))->contains($val->id) ? 'selected' : '' }}>{{ $val->restrictions }}</option>
                                @endforeach
                            </select>
                            <div class="mt-2 d-none" id="new-restriction-wrap">
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control"
                                        id="new-restriction-name"
                                        maxlength="255"
                                        placeholder="Enter new restriction name">
                                    <button type="button" class="btn btn-primary" id="add-restriction-btn">
                                        <i class="fe fe-save me-1"></i> Create
                                    </button>
                                </div>
                                <div class="invalid-feedback d-block" id="new-restriction-error"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label mb-2">Ticket Features</label>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" id="limitedView" name="limitedView" class="form-check-input" {{ old('limitedView') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="limitedView">Limited or restricted view</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" id="vipPass" name="vipPass" class="form-check-input" {{ old('vipPass') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="vipPass">Includes VIP pass</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" id="mealPackage" name="mealPackage" class="form-check-input" {{ old('mealPackage') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mealPackage">Ticket and meal package</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" id="parking" name="parking" class="form-check-input" {{ old('parking') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="parking">Includes parking</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" id="standingOnly" name="standingOnly" class="form-check-input" {{ old('standingOnly') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="standingOnly">Standing Only</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" id="aisleSeat" name="aisleSeat" class="form-check-input" {{ old('aisleSeat') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="aisleSeat">Aisle seat</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Disclaimer Notes</label>
                            <textarea class="form-control" name="disclaimer_note" rows="3">{{ old('disclaimer_note') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cancellation Policy</label>
                            <textarea class="form-control" name="cancellation_policy_notes" rows="3">{{ old('cancellation_policy_notes') }}</textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="create-ticket-form" class="btn btn-primary">
                    <i class="fe fe-save me-1"></i> Create Ticket
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@if ($isSuperAdmin)
<div class="modal fade" id="reject-ticket-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Reject Ticket Listing</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="reject-ticket-id" value="">
                <input type="hidden" id="reject-created-by" value="">
                <p class="text-muted tx-13 mb-3">Provide a clear reason. The reseller will get an email and an in-app notification.</p>
                <label class="form-label" for="reject-reason">Rejection Reason <span class="text-danger">*</span></label>
                <textarea class="form-control" id="reject-reason" rows="4" maxlength="2000" placeholder="Explain why this listing is being rejected..."></textarea>
                <div class="invalid-feedback d-block" id="reject-reason-error"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirm-reject-ticket">
                    <i class="fe fe-x-circle me-1"></i> Reject &amp; Notify
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
@php
    $datatableJqueryLoaded = true;
    $datatableOptions = [
        'language' => [
            'search' => 'Search listings:',
            'searchPlaceholder' => 'Search table...',
            'lengthMenu' => 'Show _MENU_ listings',
            'info' => 'Showing _START_ to _END_ of _TOTAL_ listings',
            'infoEmpty' => 'No listings found',
            'infoFiltered' => '(filtered from _MAX_ total listings)',
            'zeroRecords' => 'No matching listings found',
        ],
        'columnDefs' => [
            ['orderable' => false, 'targets' => $nonOrderableTargets],
            ['searchable' => false, 'targets' => array_merge([0], $nonOrderableTargets)],
        ],
    ];
@endphp
<script src="{{ asset('admin_assets/plugins/select2/js/select2.min.js') }}"></script>
@include('datatable.datatable_js')
@include('admin.partials.datatable_export_scripts')

<script>
(function () {
    if (typeof jQuery.fn.sparkline === 'undefined') {
        jQuery.fn.sparkline = function () { return this; };
    }
})();

jQuery(document).ready(function ($) {
    const $restrictionsSelect = $('#ticket-restrictions-select');
    $restrictionsSelect.select2({ width: '100%', placeholder: 'Select restrictions', dropdownParent: $('#create-ticket-modal') });

    $('#toggle-new-restriction').on('click', function () {
        const $wrap = $('#new-restriction-wrap');
        $wrap.toggleClass('d-none');
        if (!$wrap.hasClass('d-none')) {
            $('#new-restriction-name').trigger('focus');
        }
        $('#new-restriction-error').text('');
    });

    const createRestriction = () => {
        const $input = $('#new-restriction-name');
        const $error = $('#new-restriction-error');
        const $btn = $('#add-restriction-btn');
        const name = $.trim($input.val());

        $error.text('');
        if (!name) {
            $error.text('Please enter a restriction name.');
            $input.trigger('focus');
            return;
        }

        $btn.prop('disabled', true);

        $.ajax({
            url: @json(route('ticket_restrictions.quick-create')),
            method: 'POST',
            data: { restrictions: name },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        }).done(function (response) {
            if (!response || !response.success || !response.data) {
                $error.text((response && response.message) ? response.message : 'Unable to create restriction.');
                return;
            }

            const id = String(response.data.id);
            const text = response.data.text;

            if ($restrictionsSelect.find('option[value="' + id + '"]').length === 0) {
                const option = new Option(text, id, true, true);
                $restrictionsSelect.append(option);
            }

            const selected = $restrictionsSelect.val() || [];
            if (selected.indexOf(id) === -1) {
                selected.push(id);
            }
            $restrictionsSelect.val(selected).trigger('change');

            $input.val('');
            $('#new-restriction-wrap').addClass('d-none');

            if (typeof toastr !== 'undefined') {
                toastr.success(response.message || 'Restriction created successfully.');
            }
        }).fail(function (xhr) {
            let message = 'Unable to create restriction. Please try again.';
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                const firstKey = Object.keys(xhr.responseJSON.errors)[0];
                message = xhr.responseJSON.errors[firstKey][0] || message;
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            }
            $error.text(message);
        }).always(function () {
            $btn.prop('disabled', false);
        });
    };

    $('#add-restriction-btn').on('click', createRestriction);
    $('#new-restriction-name').on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            createRestriction();
        }
    });

    const toggleMobileApp = () => {
        const selected = $('#create-ticket-type option:selected');
        const isMobile = selected.data('mobile') == 1;
        const $wrapper = $('#mobile-app-wrapper');
        const $select = $('#mobile-app-select');
        if (isMobile) {
            $wrapper.removeClass('d-none');
            $select.prop('required', true);
        } else {
            $wrapper.addClass('d-none');
            $select.prop('required', false).val('');
        }
    };

    const syncSeatTo = () => {
        const count = parseInt($('#no-of-tickets').val(), 10);
        const from = parseInt($('#seat-from').val(), 10);
        if (!Number.isNaN(count) && count > 0 && !Number.isNaN(from)) {
            $('#seat-to').val(from + count - 1);
        }
    };

    const updateConvertedValue = () => {
        const selected = $('#create-currency option:selected');
        const rate = parseFloat(selected.data('rate')) || 1;
        let amount = parseFloat($('#create-amount').val());
        let cents = parseInt($('#create-cents').val(), 10);
        if (Number.isNaN(amount) || amount < 0) amount = 0;
        if (Number.isNaN(cents) || cents < 0) cents = 0;
        if (cents > 99) {
            cents = 99;
            $('#create-cents').val(99);
        }
        const localValue = Math.round((amount + (cents / 100)) * 100) / 100;
        const usdValue = rate > 0 ? (localValue / rate) : localValue;
        $('#create-converted-value').text('$' + usdValue.toFixed(2) + ' USD');
    };

    $('#create-ticket-type').on('change', toggleMobileApp);
    $('#no-of-tickets, #seat-from').on('input change', syncSeatTo);
    $('#create-currency, #create-amount, #create-cents').on('input change', updateConvertedValue);

    toggleMobileApp();
    updateConvertedValue();

    @if ($errors->any())
        var createModal = new bootstrap.Modal(document.getElementById('create-ticket-modal'));
        createModal.show();
    @endif
});

function get_available_tickets(val) {
    var seating = val;
    var timing = $('#event-timing').val();
    var event = $('#event-id').val();

    if (!timing) {
        toastr.error('Select one timing first.');
        return;
    }

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('tickets/check_availability') }}",
        data: { seating: seating, timing: timing, event: event },
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.status === true) {
                toastr.success(data.message);
                $('#no-of-tickets').val(data.seats).attr({ max: data.seats, min: 1 });
            } else {
                toastr.error(data.message);
            }
        }
    });
}

const reload_value = () => {
    $('#seating-select').val('');
};

const approval_warning = (val, created_by) => {
    const approveBtn = $('#approve-btn-' + val);
    const rejectBtn = $('#reject-btn-' + val);
    approveBtn.prop('disabled', true);
    rejectBtn.prop('disabled', true);

    swal({
        title: 'Approve this ticket listing?',
        text: 'Once approved, resellers can sell these tickets.',
        icon: 'info',
        buttons: true,
    }).then((willApprove) => {
        if (!willApprove) {
            approveBtn.prop('disabled', false);
            rejectBtn.prop('disabled', false);
            return;
        }

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{ url('tickets/approve_tickets') }}",
            data: { ticket_id: val, created_by: created_by },
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.status === true) {
                    swal({ title: 'Ticket Approved!', text: data.message, icon: 'success', button: 'OK' }).then(() => location.reload());
                } else {
                    approveBtn.prop('disabled', false);
                    rejectBtn.prop('disabled', false);
                    toastr.error(data.message);
                }
            },
            error: function (xhr) {
                approveBtn.prop('disabled', false);
                rejectBtn.prop('disabled', false);
                toastr.error((xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Unable to approve ticket.');
            }
        });
    });
};

const openRejectModal = (ticketId, createdBy) => {
    $('#reject-ticket-id').val(ticketId);
    $('#reject-created-by').val(createdBy);
    $('#reject-reason').val('');
    $('#reject-reason-error').text('');
    bootstrap.Modal.getOrCreateInstance(document.getElementById('reject-ticket-modal')).show();
};

$('#confirm-reject-ticket').on('click', function () {
    const ticketId = $('#reject-ticket-id').val();
    const createdBy = $('#reject-created-by').val();
    const reason = $.trim($('#reject-reason').val());
    const $btn = $(this);
    const approveBtn = $('#approve-btn-' + ticketId);
    const rejectBtn = $('#reject-btn-' + ticketId);

    $('#reject-reason-error').text('');
    if (reason.length < 5) {
        $('#reject-reason-error').text('Please enter a rejection reason (at least 5 characters).');
        $('#reject-reason').trigger('focus');
        return;
    }

    $btn.prop('disabled', true);
    approveBtn.prop('disabled', true);
    rejectBtn.prop('disabled', true);

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('tickets/reject_tickets') }}",
        data: {
            ticket_id: ticketId,
            created_by: createdBy,
            rejection_reason: reason
        },
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            if (data.status === true) {
                bootstrap.Modal.getInstance(document.getElementById('reject-ticket-modal')).hide();
                swal({
                    title: 'Ticket Rejected',
                    text: data.message || 'Reseller has been notified.',
                    icon: 'info',
                    button: 'OK'
                }).then(() => location.reload());
            } else {
                $btn.prop('disabled', false);
                approveBtn.prop('disabled', false);
                rejectBtn.prop('disabled', false);
                toastr.error(data.message || 'Unable to reject ticket.');
            }
        },
        error: function (xhr) {
            $btn.prop('disabled', false);
            approveBtn.prop('disabled', false);
            rejectBtn.prop('disabled', false);
            let message = 'Unable to reject ticket.';
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                const firstKey = Object.keys(xhr.responseJSON.errors)[0];
                message = xhr.responseJSON.errors[firstKey][0] || message;
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            }
            $('#reject-reason-error').text(message);
            toastr.error(message);
        }
    });
});
</script>
@endpush
