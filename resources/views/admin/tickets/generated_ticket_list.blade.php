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
                                placeholder="Serial number or seat"
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
                                <th>Serial Number</th>
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
                                    <td><span class="font-weight-semibold">{{ $val->ticket_serial_number ?? '-' }}</span></td>
                                    <td>{{ $val->seat_number_prefix ?? ($val->seat_id ?? '-') }}</td>
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
                                                    data-ticket-id="{{ $val->id }}">
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
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">No seats found</td>
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
                        <label class="form-label tx-12 text-muted text-uppercase">Serial Number</label>
                        <p class="fw-semibold mb-0" id="modal-serial">—</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label tx-12 text-muted text-uppercase">Ticket Type</label>
                        <p class="mb-0" id="modal-ticket-type">—</p>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label tx-12 text-muted text-uppercase">Ticket Name</label>
                        <p class="mb-0" id="modal-ticket-name">—</p>
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
                    <div class="col-md-12"><label class="form-label tx-12 text-muted text-uppercase">Phone</label><p class="mb-0" id="outside_phone">—</p></div>
                    <div class="col-md-12"><label class="form-label tx-12 text-muted text-uppercase">Address</label><p class="mb-0" id="outside_address">—</p></div>
                    <div class="col-md-6"><label class="form-label tx-12 text-muted text-uppercase">Date</label><p class="mb-0" id="outside_date">—</p></div>
                    <div class="col-md-6"><label class="form-label tx-12 text-muted text-uppercase">Payment Method</label><p class="mb-0" id="outside_method">—</p></div>
                </div>
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
            <form action="{{ route('tickets.outsidesell.store') }}" method="POST">
                @csrf
                <input type="hidden" name="event_ticket_tickets_id" class="modal-ticket-id" value="">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="2">{{ old('address') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="date" value="{{ old('date') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Payment Mode</label>
                            <input type="text" class="form-control" name="payment_mode" value="{{ old('payment_mode') }}">
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

            $('#modal-serial').text(ticket.ticket_serial_number || '—');
            $('#modal-ticket-type').text((eventTicket.ticket_type && eventTicket.ticket_type.ticket_type_name) || '—');
            $('#modal-ticket-name').text(eventTicket.ticket_name || '—');
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
            $('#outside_phone').text(data.phone || '—');
            $('#outside_address').text(data.address || '—');
            $('#outside_date').text(data.date || '—');
            $('#outside_method').text(data.payment_mode || '—');
        });
    });

    function toggleHoldStatus(toggleButton) {
        const $toggle = $(toggleButton);
        $toggle.toggleClass('off on');

        const ticketId = $toggle.data('ticket-id');
        const holdStatusCell = $toggle.closest('tr').find('.hold-status');
        const isHold = $toggle.hasClass('on');
        const newHoldStatus = isHold ? 'Hold' : 'No';

        if (isHold) {
            holdStatusCell.html('<span class="badge bg-warning">On Hold</span> <button type="button" class="btn btn-xs btn-success btn-sm ms-1 outside-sell-trigger" data-ticket-id="' + ticketId + '">Outside Sell</button>');
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
        $('#outside-sell-modal .modal-ticket-id').val($(this).data('ticket-id'));
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
