<?php $page = 'tickets/list'; ?>
@extends('admin.layout.app')

@section('page_title', 'Manage Seats')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('tickets') }}">Tickets</a></li>
    <li class="breadcrumb-item"><a href="{{ url('tickets/manage_tickets/' . ($eventTicket->event ?? '')) }}">{{ $eventTicket->event_name ?? 'Event Listings' }}</a></li>
    <li class="breadcrumb-item"><a href="{{ url('tickets/ticket_view/' . $eventTicket->id) }}">{{ $eventTicket->ticket_name ?? 'Listing' }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Manage Seats</li>
@endsection

@section('admin_content')

<link href="{{ asset('admin_assets/plugins/datatable/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin_assets/plugins/datatable/responsive.dataTables.min.css') }}" rel="stylesheet">

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

    .listing-summary {
        background: #f8f9fc;
        border: 1px solid #e8ebf3;
        border-radius: 8px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.25rem;
    }

    .listing-summary .listing-title {
        font-weight: 600;
        font-size: 15px;
        margin-bottom: 0.25rem;
    }

    .ticket-header-actions {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        flex-shrink: 0;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .table-action {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        justify-content: flex-end;
    }

    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.65rem;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        background: #fff;
        border: 1px solid #e8ebf3;
    }
</style>

@php
    $isSuperAdmin = Auth::user()->user_type === 'superadmin';
    $seatCount = count($data);
    $soldCount = $data->where('is_sold', 1)->count();
    $holdCount = $data->where('under_purchase_hold', 1)->count();
    $availableCount = $data->where('is_sold', 0)->where('under_purchase_hold', 0)->count();
    $exportTitle = ($eventTicket->ticket_name ?? 'Seats') . ' (' . now()->format('d M Y') . ')';
    $exportColumns = [0, 1, 2, 3, 4, 5, 6];
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
                        <h4 class="card-title mg-b-10">Manage Seats</h4>
                        <p class="text-muted tx-12 mb-0">View and manage individual seats for this ticket listing.</p>
                    </div>
                    <div class="ticket-header-actions">
                        <span class="badge bg-primary-transparent tx-13 mb-0">{{ $seatCount }} {{ Str::plural('seat', $seatCount) }}</span>
                        <a href="{{ url('tickets/ticket_view/' . $eventTicket->id) }}" class="btn btn-sm btn-outline-secondary" title="View Listing">
                            <i class="far fa-eye me-1"></i> Listing
                        </a>
                        <a href="{{ url('tickets/manage_tickets/' . $eventTicket->event) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fe fe-arrow-left me-1"></i> Back
                        </a>
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
                <div class="listing-summary">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                        <div>
                            <div class="listing-title">{{ $eventTicket->ticket_name ?? 'Ticket Listing' }}</div>
                            <div class="text-muted tx-12">
                                <span class="badge bg-primary-transparent me-1">{{ $eventTicket->event_name ?? '-' }}</span>
                                <span>{{ number_format((float) ($eventTicket->ticket_amount ?? 0), 2) }} {{ $eventTicket->currency_short_name ?? '' }} per seat</span>
                                <span class="ms-2">Face value: {{ number_format((float) ($eventTicket->face_value ?? 0), 2) }}</span>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="stat-pill"><span class="text-success">Available</span> {{ $availableCount }}</span>
                            <span class="stat-pill"><span class="text-primary">Sold</span> {{ $soldCount }}</span>
                            <span class="stat-pill"><span class="text-warning">On Hold</span> {{ $holdCount }}</span>
                        </div>
                    </div>

                    @if ($isSuperAdmin)
                        <div class="d-flex align-items-center flex-wrap gap-2 mt-3 pt-3 border-top">
                            <label class="form-label mb-0 tx-12 fw-semibold text-uppercase">Update Listing Price</label>
                            <input type="number"
                                step="0.01"
                                min="0"
                                class="form-control form-control-sm"
                                id="ticket-price-input"
                                style="width: 150px;"
                                value="{{ number_format($eventTicket->ticket_amount ?? 0, 2, '.', '') }}"
                                placeholder="0.00">
                            <button type="button"
                                class="btn btn-sm btn-primary"
                                id="update-ticket-price-btn"
                                data-ticket-id="{{ $eventTicket->id }}">
                                <i class="fe fe-save me-1"></i> Update Price
                            </button>
                        </div>
                    @endif
                </div>

                <form method="GET" action="{{ url('tickets/manage_individual_tickets/' . $eventTicket->id) }}" class="ticket-filters">
                    <div class="row g-3 align-items-end">
                        <div class="col-xl-3 col-md-6">
                            <label class="form-label" for="search">Search</label>
                            <input type="text" name="search" id="search" class="form-control"
                                placeholder="Seat number or row"
                                value="{{ $filters['search'] ?? '' }}">
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <label class="form-label" for="sold_status">Sale Status</label>
                            <select name="sold_status" id="sold_status" class="form-control form-select">
                                <option value="">All</option>
                                <option value="unsold" @selected(($filters['sold_status'] ?? '') === 'unsold')>Available</option>
                                <option value="sold" @selected(($filters['sold_status'] ?? '') === 'sold')>Sold</option>
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <label class="form-label" for="hold_status">Purchase Hold</label>
                            <select name="hold_status" id="hold_status" class="form-control form-select">
                                <option value="">All</option>
                                <option value="hold" @selected(($filters['hold_status'] ?? '') === 'hold')>On Hold</option>
                                <option value="no_hold" @selected(($filters['hold_status'] ?? '') === 'no_hold')>Not on Hold</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <label class="form-label d-block">&nbsp;</label>
                            <div class="filter-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fe fe-filter me-1"></i> Apply
                                </button>
                                <a href="{{ url('tickets/manage_individual_tickets/' . $eventTicket->id) }}" class="btn btn-outline-secondary">Clear</a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap mb-0 dataTables" id="file-datatable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Ticket Name</th>
                                <th>Seating Name</th>
                                <th>Seat</th>
                                <th>Status</th>
                                <th>Hold Toggle</th>
                                <th>Purchase Hold</th>
                                <th>Amount</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $val)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><span class="font-weight-semibold">{{ $eventTicket->ticket_name ?? '-' }}</span></td>
                                    <td>{{ $eventTicket->seating_type_name ?? '-' }}</td>
                                    <td>
                                        @php
                                            $seatParts = array_filter([
                                                $val->seat_row ? 'Row ' . $val->seat_row : null,
                                                $val->seat_number !== null && $val->seat_number !== '' ? 'Seat ' . $val->seat_number : null,
                                            ]);
                                        @endphp
                                        {{ $seatParts ? implode(' · ', $seatParts) : '-' }}
                                    </td>
                                    <td>
                                        @if ($val->outsideSell)
                                            <span class="badge bg-info-transparent">Sold Outside</span>
                                        @elseif ($val->is_sold == 1)
                                            <span class="badge bg-primary">Sold</span>
                                        @else
                                            <span class="badge bg-success-transparent text-success">Available</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$val->outsideSell && $val->is_sold != 1)
                                            <div class="main-toggle {{ $val->under_purchase_hold == 1 ? 'on' : 'off' }}" data-ticket-id="{{ $val->id }}">
                                                <span></span>
                                            </div>
                                        @else
                                            <span class="text-muted tx-12">—</span>
                                        @endif
                                    </td>
                                    <td class="hold-status" data-ticket-id="{{ $val->id }}">
                                        @if ($val->under_purchase_hold == 1)
                                            <span class="badge bg-warning">On Hold</span>
                                            @if (!$val->outsideSell && $val->is_sold != 1)
                                                <button type="button"
                                                    class="btn btn-xs btn-success btn-sm ms-1 outside-sell-trigger"
                                                    data-ticket-id="{{ $val->id }}"
                                                    data-cost-price="{{ number_format((float) $val->ticket_amount, 2, '.', '') }}">
                                                    Outside Sell
                                                </button>
                                            @endif
                                        @else
                                            <span class="text-muted">No</span>
                                        @endif
                                    </td>
                                    <td class="ticket-amount-cell" data-ticket-id="{{ $val->id }}">
                                        {{ number_format((float) $val->ticket_amount, 2) }}
                                    </td>
                                    <td class="text-end">
                                        <div class="table-action">
                                            <button type="button"
                                                class="btn btn-sm btn-info-light view-ticket"
                                                data-bs-toggle="modal"
                                                data-bs-target="#view-ticket-modal"
                                                data-id="{{ $val->id }}"
                                                title="View Details">
                                                <i class="far fa-eye"></i>
                                            </button>
                                            @if ($val->outsideSell)
                                                <button type="button"
                                                    class="btn btn-sm btn-warning-light view-outside"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#view-outside-modal"
                                                    data-id="{{ $val->outsideSell->id }}"
                                                    title="Outside Sell Details">
                                                    <i class="fe fe-external-link"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-sm btn-primary-light upload-outside-proof"
                                                    data-id="{{ $val->outsideSell->id }}"
                                                    data-proofs='@json($val->outsideSell->proof_urls)'
                                                    title="{{ count($val->outsideSell->proof_files_list) ? 'Upload / View Proofs' : 'Upload Proof' }}">
                                                    <i class="fe fe-upload"></i>
                                                </button>
                                                @if (count($val->outsideSell->proof_files_list))
                                                    <button type="button"
                                                        class="btn btn-sm btn-success-light view-outside-proofs"
                                                        data-proofs='@json($val->outsideSell->proof_urls)'
                                                        title="View Proofs ({{ count($val->outsideSell->proof_files_list) }})">
                                                        <i class="fe fe-eye"></i>
                                                        <span class="ms-1">{{ count($val->outsideSell->proof_files_list) }}</span>
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">No seats found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="view-ticket-modal" tabindex="-1" aria-labelledby="viewTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="viewTicketModalLabel">Seat Details</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label tx-12 text-muted text-uppercase">Ticket Name</label>
                        <p class="fw-semibold mb-0" id="modal-ticket-name">—</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label tx-12 text-muted text-uppercase">Seating Name</label>
                        <p class="mb-0" id="modal-seating-name">—</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label tx-12 text-muted text-uppercase">Ticket Type</label>
                        <p class="mb-0" id="modal-ticket-type">—</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label tx-12 text-muted text-uppercase">Seat</label>
                        <p class="mb-0" id="modal-seat">—</p>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label tx-12 text-muted text-uppercase">Event</label>
                        <p class="fw-semibold mb-0" id="modal-event-name">—</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label tx-12 text-muted text-uppercase">Venue</label>
                        <p class="mb-0" id="modal-venue-name">—</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label tx-12 text-muted text-uppercase">Event Timing</label>
                        <p class="mb-0" id="modal-event-timing">—</p>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label tx-12 text-muted text-uppercase">Event Description</label>
                        <p class="mb-0 text-muted" id="modal-event-desc">—</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="view-outside-modal" tabindex="-1" aria-labelledby="viewOutsideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="viewOutsideModalLabel">Outside Sell Details</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-12"><label class="form-label tx-12 text-muted text-uppercase">Name</label><p class="mb-0" id="outside_name">—</p></div>
                    <div class="col-md-6"><label class="form-label tx-12 text-muted text-uppercase">Ticket Type</label><p class="mb-0" id="outside_ticket_type">—</p></div>
                    <div class="col-md-6"><label class="form-label tx-12 text-muted text-uppercase">Phone</label><p class="mb-0" id="outside_phone">—</p></div>
                    <div class="col-md-6"><label class="form-label tx-12 text-muted text-uppercase">Email</label><p class="mb-0" id="outside_email">—</p></div>
                    <div class="col-md-12"><label class="form-label tx-12 text-muted text-uppercase">Address</label><p class="mb-0" id="outside_address">—</p></div>
                    <div class="col-md-6"><label class="form-label tx-12 text-muted text-uppercase">Cost Price</label><p class="mb-0" id="outside_cost_price">—</p></div>
                    <div class="col-md-6"><label class="form-label tx-12 text-muted text-uppercase">Sale Price</label><p class="mb-0" id="outside_sale_price">—</p></div>
                    <div class="col-md-6"><label class="form-label tx-12 text-muted text-uppercase">Date</label><p class="mb-0" id="outside_date">—</p></div>
                    <div class="col-md-6"><label class="form-label tx-12 text-muted text-uppercase">Payment Method</label><p class="mb-0" id="outside_method">—</p></div>
                    <div class="col-md-12"><label class="form-label tx-12 text-muted text-uppercase">Remark</label><p class="mb-0" id="outside_remark">—</p></div>
                    <div class="col-md-12">
                        <label class="form-label tx-12 text-muted text-uppercase">Proofs</label>
                        <div id="outside_proof_list" class="d-flex flex-wrap gap-2"></div>
                        <span id="outside_proof_empty" class="text-muted">No proof uploaded</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="upload-outside-proof-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Upload Outside Sell Proofs</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="upload-outside-proof-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="outsidesell_id" id="upload-outsidesell-id" value="">
                <div class="modal-body">
                    <div class="mb-3" id="current-proof-wrap" style="display:none;">
                        <label class="form-label">Existing Proofs</label>
                        <div id="current-proof-list" class="d-flex flex-column gap-2"></div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Proof Files <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="proof_files[]" id="outside-proof-file" accept=".jpg,.jpeg,.png,.pdf,.webp" multiple required>
                        <div class="form-text">You can select multiple files. Allowed: JPG, PNG, PDF, WEBP (max 5MB each)</div>
                        <div class="invalid-feedback d-block" id="outside-proof-error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="upload-outside-proof-submit">
                        <i class="fe fe-upload me-1"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="view-outside-proofs-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Outside Sell Proofs</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="view-outside-proofs-list" class="d-flex flex-column gap-2"></div>
                <p id="view-outside-proofs-empty" class="text-muted mb-0 d-none">No proofs uploaded.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="outside-sell-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Outside Sell</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tickets.outsidesell.store') }}" method="POST" id="outside-sell-form">
                @csrf
                <input type="hidden" name="event_ticket_tickets_id" class="modal-ticket-id" value="">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Ticket Type <span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="ticket_type_id" id="outside-ticket-type" required>
                                <option value="">Select ticket type</option>
                                @foreach ($ticketTypes ?? [] as $type)
                                    <option value="{{ $type->id }}" @selected((string) old('ticket_type_id', $eventTicket->ticket_type ?? '') === (string) $type->id)>
                                        {{ $type->ticket_type_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="customer@example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="date" value="{{ old('date', date('Y-m-d')) }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="2">{{ old('address') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cost Price</label>
                            <input type="number" step="0.01" min="0" class="form-control" name="cost_price" id="outside-cost-price" value="{{ old('cost_price') }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sale Price <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control" name="sale_price" id="outside-sale-price" value="{{ old('sale_price') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Payment Mode <span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="payment_mode" required>
                                <option value="">Select payment method</option>
                                @foreach ([
                                    'Cash' => 'Cash',
                                    'Card' => 'Card',
                                    'UPI' => 'UPI',
                                    'Bank Transfer' => 'Bank Transfer',
                                    'PayPal' => 'PayPal',
                                    'Cheque' => 'Cheque',
                                    'Other' => 'Other',
                                ] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('payment_mode') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Remark</label>
                            <textarea class="form-control" name="remark" rows="3" placeholder="Add any notes about this outside sale">{{ old('remark') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
@php
    $datatableJqueryLoaded = true;
    $datatableOptions = [
        'language' => [
            'search' => 'Search seats:',
            'searchPlaceholder' => 'Search table...',
            'lengthMenu' => 'Show _MENU_ seats',
            'info' => 'Showing _START_ to _END_ of _TOTAL_ seats',
            'infoEmpty' => 'No seats found',
            'infoFiltered' => '(filtered from _MAX_ total seats)',
            'zeroRecords' => 'No matching seats found',
        ],
        'columnDefs' => [
            ['orderable' => false, 'targets' => [4, 7]],
            ['searchable' => false, 'targets' => [0, 4, 7]],
        ],
    ];
@endphp
@include('datatable.datatable_js')
@include('admin.partials.datatable_export_scripts')

<script>
jQuery(function ($) {
    const ticketDataUrl = @json(url('tickets/get-individual-ticketdata'));
    const outsideSellUrl = @json(url('tickets/get-outsidesell_data'));
    const holdStatusUrl = @json(url('tickets/update-hold-status'));
    const updatePriceUrl = @json(url('tickets/update-ticket-price'));
    const csrfToken = @json(csrf_token());

    $('.view-ticket').on('click', function () {
        const ticketId = $(this).data('id');

        $.getJSON(ticketDataUrl + '/' + ticketId, function (response) {
            const ticket = response.individualticketData;
            const eventTicket = ticket.event_ticket || {};
            const event = eventTicket.event || {};
            const venue = event.venue || {};
            const timing = ticket.event_timing || {};

            $('#modal-ticket-name').text(eventTicket.ticket_name || '—');
            $('#modal-seating-name').text((eventTicket.seating && eventTicket.seating.seating_type_name) || '—');
            $('#modal-ticket-type').text((eventTicket.ticket_type && eventTicket.ticket_type.ticket_type_name) || '—');
            const seatParts = [];
            if (ticket.seat_row) {
                seatParts.push('Row ' + ticket.seat_row);
            }
            if (ticket.seat_number !== null && ticket.seat_number !== undefined && ticket.seat_number !== '') {
                seatParts.push('Seat ' + ticket.seat_number);
            }
            $('#modal-seat').text(seatParts.length ? seatParts.join(' · ') : '—');
            $('#modal-event-name').text(event.event_name || '—');
            $('#modal-venue-name').text(venue.name || '—');
            $('#modal-event-timing').text(
                [timing.event_date, timing.from_time, timing.to_time].filter(Boolean).join(' · ') || '—'
            );
            $('#modal-event-desc').text(event.event_desc || '—');
        });
    });

    $('.view-outside').on('click', function () {
        const outsidesellId = $(this).data('id');

        $.getJSON(outsideSellUrl + '/' + outsidesellId, function (response) {
            const data = response.outsidesellData;
            $('#outside_name').text(data.name || '—');
            $('#outside_ticket_type').text(response.ticket_type_name || '—');
            $('#outside_phone').text(data.phone || '—');
            $('#outside_email').text(data.email || '—');
            $('#outside_address').text(data.address || '—');
            $('#outside_cost_price').text(data.cost_price != null ? Number(data.cost_price).toFixed(2) : '—');
            $('#outside_sale_price').text(data.sale_price != null ? Number(data.sale_price).toFixed(2) : '—');
            $('#outside_date').text(data.date || '—');
            $('#outside_method').text(data.payment_mode || '—');
            $('#outside_remark').text(data.remark || '—');
            const proofUrls = response.proof_urls || [];
            const $proofList = $('#outside_proof_list').empty();
            if (proofUrls.length) {
                proofUrls.forEach(function (url, index) {
                    $proofList.append(
                        '<a href="' + url + '" target="_blank" class="btn btn-sm btn-outline-success">Proof ' + (index + 1) + '</a>'
                    );
                });
                $('#outside_proof_empty').addClass('d-none');
            } else {
                $('#outside_proof_empty').removeClass('d-none');
            }
        });
    });

    function renderProofLinks($container, proofUrls) {
        $container.empty();
        (proofUrls || []).forEach(function (url, index) {
            $container.append(
                '<a href="' + url + '" target="_blank" class="btn btn-sm btn-outline-success">' +
                '<i class="fe fe-eye me-1"></i> Proof ' + (index + 1) +
                '</a>'
            );
        });
    }

    function parseProofsData(raw) {
        if (!raw) return [];
        if (Array.isArray(raw)) return raw;
        try {
            const parsed = typeof raw === 'string' ? JSON.parse(raw) : raw;
            return Array.isArray(parsed) ? parsed : [];
        } catch (e) {
            return [];
        }
    }

    $(document).on('click', '.upload-outside-proof', function () {
        const id = $(this).data('id');
        const proofUrls = parseProofsData($(this).attr('data-proofs'));
        $('#upload-outsidesell-id').val(id);
        $('#outside-proof-file').val('');
        $('#outside-proof-error').text('');
        if (proofUrls.length) {
            $('#current-proof-wrap').show();
            renderProofLinks($('#current-proof-list'), proofUrls);
        } else {
            $('#current-proof-wrap').hide();
            $('#current-proof-list').empty();
        }
        bootstrap.Modal.getOrCreateInstance(document.getElementById('upload-outside-proof-modal')).show();
    });

    $(document).on('click', '.view-outside-proofs', function () {
        const proofUrls = parseProofsData($(this).attr('data-proofs'));
        const $list = $('#view-outside-proofs-list');
        const $empty = $('#view-outside-proofs-empty');
        if (proofUrls.length) {
            renderProofLinks($list, proofUrls);
            $empty.addClass('d-none');
        } else {
            $list.empty();
            $empty.removeClass('d-none');
        }
        bootstrap.Modal.getOrCreateInstance(document.getElementById('view-outside-proofs-modal')).show();
    });

    $('#upload-outside-proof-form').on('submit', function (e) {
        e.preventDefault();
        const $form = $(this);
        const $submit = $('#upload-outside-proof-submit');
        const formData = new FormData(this);
        $('#outside-proof-error').text('');
        $submit.prop('disabled', true);

        $.ajax({
            url: @json(route('tickets.outsidesell.upload-proof')),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        }).done(function (response) {
            if (typeof toastr !== 'undefined') {
                toastr.success(response.message || 'Proof uploaded successfully.');
            }
            bootstrap.Modal.getInstance(document.getElementById('upload-outside-proof-modal')).hide();
            location.reload();
        }).fail(function (xhr) {
            let message = 'Unable to upload proof. Please try again.';
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                const firstKey = Object.keys(xhr.responseJSON.errors)[0];
                message = xhr.responseJSON.errors[firstKey][0] || message;
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            }
            $('#outside-proof-error').text(message);
        }).always(function () {
            $submit.prop('disabled', false);
        });
    });

    function toggleHoldStatus(toggleButton) {
        const $toggle = $(toggleButton);
        $toggle.toggleClass('off on');

        const ticketId = $toggle.data('ticket-id');
        const holdStatusCell = $toggle.closest('tr').find('.hold-status');
        const amountText = $.trim($toggle.closest('tr').find('.ticket-amount-cell').text()).replace(/,/g, '');
        const costPrice = amountText || '0';
        const isHold = $toggle.hasClass('on');
        const newHoldStatus = isHold ? 'Hold' : 'No';

        if (isHold) {
            holdStatusCell.html('<span class="badge bg-warning">On Hold</span> <button type="button" class="btn btn-xs btn-success btn-sm ms-1 outside-sell-trigger" data-ticket-id="' + ticketId + '" data-cost-price="' + costPrice + '">Outside Sell</button>');
        } else {
            holdStatusCell.html('<span class="text-muted">No</span>');
        }

        $.post(holdStatusUrl, {
            ticketId: ticketId,
            newHoldStatus: newHoldStatus,
            _token: csrfToken
        });
    }

    $(document).on('click', '.outside-sell-trigger', function () {
        const $btn = $(this);
        const costPrice = $btn.data('cost-price');
        const parsedCost = (costPrice !== undefined && costPrice !== null && costPrice !== '')
            ? Number(costPrice)
            : 0;
        const defaultTicketType = @json((string) ($eventTicket->ticket_type ?? ''));

        $('#outside-sell-modal .modal-ticket-id').val($btn.data('ticket-id'));
        $('#outside-cost-price').val(Number.isFinite(parsedCost) ? parsedCost.toFixed(2) : '0.00');
        $('#outside-sale-price').val(Number.isFinite(parsedCost) ? parsedCost.toFixed(2) : '');
        if (defaultTicketType) {
            $('#outside-ticket-type').val(defaultTicketType);
        }
        bootstrap.Modal.getOrCreateInstance(document.getElementById('outside-sell-modal')).show();
    });

    $(document).on('click', '.main-toggle', function () {
        toggleHoldStatus(this);
    });

    $('#update-ticket-price-btn').on('click', function () {
        const ticketId = $(this).data('ticket-id');
        const amount = $('#ticket-price-input').val();
        const button = $(this);

        if (!amount || amount < 0) {
            toastr.error('Please enter a valid price.');
            return;
        }

        const originalHtml = button.html();
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');

        $.ajax({
            url: updatePriceUrl + '/' + ticketId,
            type: 'POST',
            data: { ticket_amount: amount, _token: csrfToken },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('.ticket-amount-cell').text(parseFloat(response.data.new_amount).toFixed(2));
                    $('#ticket-price-input').val(parseFloat(response.data.new_amount).toFixed(2));
                    toastr.success('Price updated to ' + response.data.new_amount);
                } else {
                    toastr.error(response.message || 'Update failed.');
                }
                button.prop('disabled', false).html(originalHtml);
            },
            error: function (xhr) {
                toastr.error((xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Unable to update price.');
                button.prop('disabled', false).html(originalHtml);
            }
        });
    });

    $('#ticket-price-input').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#update-ticket-price-btn').click();
        }
    });
});
</script>
@endpush
