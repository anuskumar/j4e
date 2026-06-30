<?php $page = 'events/list';
$val = $data[0];
?>
@extends('layouts.reseller_app')

@push('styles')
<style>
    .listing-manage-page {
        max-width: 1280px;
        margin: 0 auto;
    }

    .listing-manage-page .page-card {
        background: #fff;
        border: 1px solid #e8ebf3;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
    }

    .listing-manage-page .page-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #eef0f4;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .listing-manage-page .listing-id {
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #7e0982;
        margin-bottom: 0.25rem;
    }

    .listing-manage-page .listing-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }

    .listing-manage-page .status-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.4rem 0.75rem;
        border-radius: 999px;
    }

    .listing-manage-page .meta-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin: 1rem 0 0;
    }

    .listing-manage-page .meta-chip {
        background: #f8f9fc;
        border: 1px solid #e8ebf3;
        border-radius: 8px;
        padding: 0.55rem 0.9rem;
        font-size: 0.875rem;
        color: #4b5563;
    }

    .listing-manage-page .meta-chip strong {
        color: #111827;
        font-weight: 600;
    }

    .listing-manage-page .section-heading {
        font-size: 1rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0 0 0.35rem;
    }

    .listing-manage-page .section-subtext {
        color: #6b7280;
        font-size: 0.875rem;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .listing-manage-page .stats-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .listing-manage-page .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 0.85rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .listing-manage-page .stat-pill--sold {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #bbf7d0;
    }

    .listing-manage-page .stat-pill--available {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #e5e7eb;
    }

    .listing-manage-page .tickets-table-wrap {
        border: 1px solid #e8ebf3;
        border-radius: 10px;
        overflow: hidden;
    }

    .listing-manage-page .tickets-table {
        margin-bottom: 0;
        font-size: 0.875rem;
    }

    .listing-manage-page .tickets-table thead th {
        background: #f8f9fc;
        color: #374151;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        border-bottom: 1px solid #e8ebf3;
        white-space: nowrap;
        padding: 0.85rem 0.75rem;
    }

    .listing-manage-page .tickets-table tbody td {
        vertical-align: middle;
        padding: 0.85rem 0.75rem;
        border-color: #eef0f4;
        color: #374151;
    }

    .listing-manage-page .tickets-table tbody tr:hover {
        background: #fafbff;
    }

    .listing-manage-page .tickets-table tbody tr.is-sold {
        background: #f6fffb;
    }

    .listing-manage-page .sold-details {
        font-size: 0.8rem;
        line-height: 1.45;
        color: #4b5563;
    }

    .listing-manage-page .sold-details strong {
        color: #111827;
    }

    .listing-manage-page .action-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.35rem;
    }

    .listing-manage-page .btn-brand {
        background: #7e0982;
        border-color: #7e0982;
        color: #fff;
    }

    .listing-manage-page .btn-brand:hover {
        background: #6a0770;
        border-color: #6a0770;
        color: #fff;
    }

    .listing-manage-page .sidebar-card {
        background: #fff;
        border: 1px solid #e8ebf3;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .listing-manage-page .sidebar-card__header {
        padding: 0.9rem 1.1rem;
        background: #f8f9fc;
        border-bottom: 1px solid #eef0f4;
        font-weight: 700;
        font-size: 0.9rem;
        color: #1a1a2e;
    }

    .listing-manage-page .sidebar-card__body {
        padding: 1rem 1.1rem;
    }

    .listing-manage-page .sidebar-item {
        margin-bottom: 0.85rem;
    }

    .listing-manage-page .sidebar-item:last-child {
        margin-bottom: 0;
    }

    .listing-manage-page .sidebar-item__label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #9ca3af;
        margin-bottom: 0.2rem;
    }

    .listing-manage-page .sidebar-item__value {
        font-size: 0.9rem;
        color: #374151;
        margin: 0;
    }

    .listing-manage-page .price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #eef0f4;
        font-size: 0.9rem;
    }

    .listing-manage-page .price-row:last-child {
        border-bottom: none;
    }

    .listing-manage-page .price-row strong {
        color: #111827;
    }

    @media (max-width: 767.98px) {
        .listing-manage-page .tickets-table-wrap {
            overflow-x: auto;
        }

        .listing-manage-page .tickets-table {
            min-width: 900px;
        }
    }
</style>
@endpush

@section('content')

@php
    $listingStatus = $val['is_admin_approved'] != 1
        ? ['label' => 'Waiting for Approval', 'class' => 'text-bg-warning']
        : ($val['ticket_status'] == 1
            ? ['label' => 'Active', 'class' => 'text-bg-success']
            : ['label' => 'Paused', 'class' => 'text-bg-secondary']);
@endphp

<div class="container listing-manage-page py-2">
    <div class="page-card mb-4">
        <div class="page-header">
            <div>
                <div class="listing-id">Listing ID: {{ strtoupper($val['unique_id'] ?? '') }}</div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h1 class="listing-title">{{ $val['ticket_type_name'] }}</h1>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="openTicketTypechangeModal()" title="Change ticket type">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <span class="status-badge badge {{ $listingStatus['class'] }}">{{ $listingStatus['label'] }}</span>
                </div>
                <div class="meta-grid">
                    <div class="meta-chip"><strong>Event:</strong> {{ ucfirst($val['event_name']) }}</div>
                    <div class="meta-chip"><strong>Seats:</strong> {{ $val['no_of_tickets'] }} tickets</div>
                    <div class="meta-chip"><strong>Section:</strong> {{ $val['seating_type_name'] }}</div>
                    <div class="meta-chip"><strong>Row:</strong> {{ $val['row'] ?: '—' }}</div>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('reseller.mylistings') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Listings
                </a>
                @if($val['is_admin_approved'] <> 1)
                    <button class="btn btn-outline-danger" onclick="confirmDelete({{ $val['id'] }})">
                        <i class="bi bi-trash me-1"></i> Delete Listing
                    </button>
                    <form id="delete-form-{{ $val['id'] }}" action="{{ route('ticket.listing.destroy', $val['id']) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
            </div>
        </div>
    </div>

    @if (!empty($bankDetailsIncomplete))
        <div class="alert alert-warning border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-start gap-2">
                <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                <div>
                    <strong>Bank details incomplete</strong>
                    <p class="mb-2 small">Your bank details are incomplete. This may affect your listing and payouts.</p>
                    <a href="{{ route('reseller.profile') }}#bank" class="btn btn-sm btn-brand">Update Bank Details</a>
                </div>
            </div>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="page-card p-3 p-md-4">
                <h2 class="section-heading">Listed Tickets</h2>
                <p class="section-subtext">
                    All seats must be next to each other (adjacent). For unconfirmed seats, create a new listing. Breaking this rule can lead to chargebacks of the total sale price.
                </p>

                <div class="stats-row">
                    <span class="stat-pill stat-pill--sold">
                        <i class="bi bi-check-circle"></i> {{ $data['sold_ticket_count'] ?? 0 }} Sold
                    </span>
                    <span class="stat-pill stat-pill--available">
                        <i class="bi bi-ticket-perforated"></i> {{ $data['available_ticket_count'] ?? 0 }} Available
                    </span>
                </div>

                <div class="tickets-table-wrap">
                    <table class="table tickets-table align-middle">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Serial</th>
                                <th>Seat</th>
                                <th>Status</th>
                                <th>Sold Details</th>
                                <th>Actions</th>
                                <th>On Sale</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($data['tickets'] as $tickets)
                            @php
                                $isSold = !empty($tickets['is_sold']);
                                $outsideSell = $tickets['outside_sell'] ?? null;
                                $isOutsideSell = !empty($outsideSell);
                            @endphp
                            <tr class="{{ $isSold ? 'is-sold' : '' }}">
                                <td>{{ $tickets['seating_type_name'] ?? '—' }}</td>
                                <td><span class="fw-semibold">{{ $tickets['ticket_serial_number'] ?? '—' }}</span></td>
                                <td>{{ $tickets['seat_number'] ?? '—' }}</td>
                                <td>
                                    @if ($isOutsideSell)
                                        <span class="badge rounded-pill text-bg-info">Sold Outside</span>
                                    @elseif ($isSold)
                                        <span class="badge rounded-pill text-bg-success">Sold</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-light text-dark border">Available</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($isOutsideSell)
                                        <div class="sold-details">
                                            <div><strong>{{ $outsideSell['name'] ?? 'N/A' }}</strong></div>
                                            @if (!empty($outsideSell['phone']))
                                                <div><i class="bi bi-telephone me-1"></i>{{ $outsideSell['phone'] }}</div>
                                            @endif
                                            @if (!empty($outsideSell['payment_mode']))
                                                <div>Payment: {{ $outsideSell['payment_mode'] }}</div>
                                            @endif
                                            @if (!empty($outsideSell['date']))
                                                <div>{{ date('d M Y', strtotime($outsideSell['date'])) }}</div>
                                            @endif
                                        </div>
                                    @elseif ($isSold)
                                        <div class="sold-details">
                                            @if (!empty($tickets['customer_name']))
                                                <div><strong>{{ $tickets['customer_name'] }}</strong></div>
                                            @endif
                                            @if (!empty($tickets['customer_email']))
                                                <div><i class="bi bi-envelope me-1"></i>{{ $tickets['customer_email'] }}</div>
                                            @endif
                                            @if (!empty($tickets['customer_phone']))
                                                <div><i class="bi bi-telephone me-1"></i>{{ $tickets['customer_phone'] }}</div>
                                            @endif
                                            @if (!empty($tickets['purchase_order_id']))
                                                <div>
                                                    <a href="{{ url('view_invoice/' . $tickets['purchase_order_id']) }}" target="_blank" class="text-decoration-none">
                                                        Invoice #{{ str_pad($tickets['purchase_order_id'], 6, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                </div>
                                            @endif
                                            @php $soldDate = $tickets['purchase_date'] ?? $tickets['payment_date'] ?? null; @endphp
                                            @if (!empty($soldDate))
                                                <div class="text-muted">Sold {{ date('d M Y', strtotime($soldDate)) }}</div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($isSold)
                                        <span class="text-muted">—</span>
                                    @else
                                        <div class="action-group">
                                            <button class="btn btn-sm btn-outline-primary" onclick="editTicketData({{ $tickets['id'] }})" title="Edit seat">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteGeneratedTickets({{ $tickets['id'] }})" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($isSold)
                                        <span class="text-muted small">N/A</span>
                                    @else
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input"
                                                type="checkbox"
                                                role="switch"
                                                id="switchCheckChecked_{{ $tickets['id'] }}"
                                                data-id="{{ $tickets['id'] }}"
                                                data-status="{{ $tickets['on_sale'] }}"
                                                onchange="confirmToggleStatus(this)"
                                                {{ $tickets['on_sale'] == 1 ? 'checked' : '' }}>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($tickets['file']))
                                        <a href="{{ asset('storage/' . $tickets['file']) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No tickets listed yet.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                @if($val['ticket_type'] == 2)
                    <div class="mt-3">
                        <button class="btn btn-brand" type="button" onclick="uploadTicketImages()">
                            <i class="bi bi-cloud-upload me-1"></i> Upload Tickets
                        </button>
                    </div>
                @endif
            </div>

            <div class="sidebar-card mt-4">
                <div class="sidebar-card__header d-flex justify-content-between align-items-center">
                    <span>Price per Ticket</span>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="ticketPriceChange({{ $val['id'] }})">
                        <i class="bi bi-pencil"></i>
                    </button>
                </div>
                <div class="sidebar-card__body">
                    <div class="price-row">
                        <span>Original Price</span>
                        <strong>{{ $val['face_value'] }} {{ $val['short_name'] }}</strong>
                    </div>
                    <div class="price-row">
                        <span>Your Sale Price</span>
                        <strong class="text-success">{{ $val['ticket_amount'] }} {{ $val['short_name'] }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="sidebar-card">
                <div class="sidebar-card__header">Event Details</div>
                <div class="sidebar-card__body">
                    <div class="sidebar-item">
                        <div class="sidebar-item__label">Location</div>
                        <p class="sidebar-item__value">{{ $val['venue_name'] }}, {{ $val['city_name'] }}, {{ $val['country_name'] }}</p>
                        @if ($val['google_map_link'])
                            <a href="{{ $val['google_map_link'] }}" target="_blank" class="small text-decoration-none">
                                <i class="bi bi-geo-alt me-1"></i> View venue map
                            </a>
                        @endif
                    </div>
                    <div class="sidebar-item">
                        <div class="sidebar-item__label">Starts</div>
                        <p class="sidebar-item__value">{{ date('d M Y', strtotime($val['event_from_date'])) }} · {{ $val['from_time'] }}</p>
                    </div>
                    <div class="sidebar-item">
                        <div class="sidebar-item__label">Ends</div>
                        <p class="sidebar-item__value">{{ date('d M Y', strtotime($val['event_to_date'])) }} · {{ $val['to_time'] }}</p>
                    </div>
                </div>
            </div>

            <div class="sidebar-card">
                <div class="sidebar-card__header">Extra Details</div>
                <div class="sidebar-card__body">
                    @if (!empty($val['disclaimer_note']))
                        <div class="sidebar-item">
                            <div class="sidebar-item__label">Concessions</div>
                            <p class="sidebar-item__value">{{ $val['disclaimer_note'] }}</p>
                        </div>
                    @endif
                    @if (!empty($val['description']))
                        <div class="sidebar-item">
                            <div class="sidebar-item__label">Description</div>
                            <p class="sidebar-item__value">{{ $val['description'] }}</p>
                        </div>
                    @endif
                    <div class="sidebar-item">
                        <div class="sidebar-item__label">Ticket Type</div>
                        <p class="sidebar-item__value mb-0">{{ $val['ticket_type_name'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tickcet-type-change-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('update.ticket.type') }}" method="POST" >
        <input type="hidden" name="ticket_id" value="{{ $val['id'] }}">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Ticket Type</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <select class="form-select" aria-label="Default select example" name="ticket_type">
            <option>Select Ticket Type</option>
            @foreach ($ticket_type as $type)
            <option {{ $type['id'] == $val['ticket_type'] ? 'selected':'' }} value="{{ $type['id'] }}">{{ $type['ticket_type_name'] }}</option>
            @endforeach
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </div>
    </form>
  </div>
</div>


<div class="modal fade" id="tickcet-data-change-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('update.ticket.seating') }}" method="POST" >
        <input type="hidden" name="generated_ticket_id" id="generated-ticket-id" >
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Ticket</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

         <span>Seat Number</span>
         <input type="number" class="form-control" name="seat_number" id="seat-number">
        <span>Serial Number</span>
         <input type="text" class="form-control" name="seat_serial_number" id="seat-serial-number">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </div>
    </form>
  </div>
</div>

<div class="modal fade" id="ticket-image-upload-type" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload Tickets</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    <div class="modal-body">
            <div class="row">
            <div class="col-sm-6">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Upload Individual Tickets</h5>
                    <p class="card-text">There you can upload individual files on each tickets</p>
                   <button type="button" onclick="uploadTicketImagesIndividual()"  class="btn btn-primary">Upload Individually</button>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Upload a Group of Tickets</h5>
                    <p class="card-text">There you can upload a single file having multiple ticket</p>
                    <button type="button" onclick="uploadTicketImagesgroup()" class="btn btn-primary">Upload Group of files</button>
                </div>
                </div>
            </div>
            </div>
</div>

    </div>

  </div>
</div>

<div class="modal fade" id="ticket-image-upload-individually" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload Tickets</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" action="{{ route('tickets.uploadIndividual') }}" method="POST">
        @csrf
            <div class="modal-body">
                    <div class="row">
                <table class="table table-bordered">
            @foreach ($data['tickets'] as $tickets)
            @if (empty($tickets['is_sold']))
            <tr>
                <td><b><span class="text-muted">{{ $tickets['seating_type_name'] }}</span></b></td>
                <td><b><span class="text-muted">{{ $tickets['ticket_serial_number'] }}</span></b></td>
                <td><input type="hidden" name="seat_id[]" value="{{ $tickets['id'] }}">
                     <input type="file" name="files[{{ $tickets['id'] }}][]"  class="form-control mb-3">
                </td>


            </tr>
            @endif
            @endforeach
            <tr>
      <td colspan="4">
        <div class="container">
          <button type="submit" style="float: right" class="btn btn-primary btn-sm mt-3">Upload Selected</button>
        </div>
      </td>
    </tr>
            <tr>

            </tr>
        </table>
            </div>
</div>
</form>
    </div>

  </div>
</div>


<div class="modal fade" id="ticket-image-upload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">

        <input type="hidden" name="ticket_id" value="{{ $val['id'] }}">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload Tickets</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    <div class="modal-body">
  <table class="table table-bordered">
    @foreach ($data['tickets'] as $tickets)
      @if (empty($tickets['is_sold']))
      <tr>
        <td><b><span class="text-muted">{{ $tickets['seating_type_name'] }}</span></b></td>
        <td><b><span class="text-muted">{{ $tickets['ticket_serial_number'] }}</span></b></td>
      </tr>
      @endif
    @endforeach
    <tr>
      <td colspan="2">
        <div class="container">
          <h4>Upload PDF & Split Pages</h4>
          <input type="file" id="pdfInput" accept="application/pdf" class="form-control mb-3">
          <div class="page-links" id="output"></div>
          <button id="uploadBtn" class="btn btn-primary btn-sm mt-3">Upload Selected</button>
        </div>
      </td>
    </tr>
  </table>
</div>

    </div>

  </div>
</div>

<div class="modal fade" id="tickcet-price-change-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('update.ticket.pricechange') }}" method="POST" >
        <input type="hidden" name="ticket_id" value="{{ $val['id'] }}" >
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Ticket Pricing</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
         <div class="col-md-4">
         <span>Original Price</span>
         </div>
         <div class="col-md-4">

         <input type="text" class="form-control" value="{{ $val['face_value']}}" name="original_price" id="original-price">
         </div>
         <div class="col-md-4">
            USD
         </div>
         </div>
        {{-- <span>Your Sale Price</span>
         <input type="text" class="form-control" value="{{ $val['face_value']}}" name="sale_price" id="sale-price"> --}}

           <div class="row">
         <div class="col-md-4">
         <span>Your Sale Price</span>
         </div>
         <div class="col-md-4">

         <input type="text" class="form-control" value="{{ $val['ticket_amount']}}" name="sale_price" id="sale_price">
         </div>
         <div class="col-md-4">
            USD
         </div>
         </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </div>
    </form>
  </div>
</div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Required for Laravel
        }
    });

    function openTicketTypechangeModal(){

        $('#tickcet-type-change-modal').modal('show');

    }

    function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}


function confirmToggleStatus(el) {
    const ticketId = el.getAttribute('data-id');
    const currentStatus = el.getAttribute('data-status');
    const newStatus = el.checked ? 1 : 0;

    Swal.fire({
        title: 'Are you sure?',
        text: `You are about to ${newStatus ? 'activate' : 'deactivate'} this ticket.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, change it!',
        cancelButtonText: 'No, cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed to update status
            updateTicketStatus(newStatus, ticketId);
        } else {
            // Revert the toggle switch to previous state
            el.checked = !el.checked;
        }
    });
}

function updateTicketStatus(newStatus, ticketId) {
    // Example AJAX
    fetch(`/tickets/update-ticket-sale-status/${ticketId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Updated!', data.message, 'success').then(function(){
            window.location.reload();

            });
            // Optionally refresh or update the badge
        } else {
            Swal.fire('Failed!', data.message, 'error').then(function(){
            window.location.reload();

            });

        }
    })
    .catch(error => {
        Swal.fire('Error!', 'Something went wrong.', 'error');
    });
}

function editTicketData(id){

     $.ajax({
            url: '/tickets/get-ticket-data',
            type: 'GET',
            data: {
               id:id,
            },
            success: function(response) {
            console.log(response);

                 $('#seat-number').val(response.data.seat_number);
                 $('#seat-serial-number').val(response.data.ticket_serial_number);
                 $('#generated-ticket-id').val(response.data.id);

                $('#tickcet-data-change-modal').modal('show');
                // console.log('Success:', response);
                // alert(response.message);
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });


}

function uploadTicketImages(){

                $('#ticket-image-upload-type').modal('show');
}

function uploadTicketImagesgroup(){
                $('#ticket-image-upload-type').modal('hide');
                $('#ticket-image-upload').modal('show');
}

function uploadTicketImagesIndividual(){
                $('#ticket-image-upload-type').modal('hide');
                $('#ticket-image-upload-individually').modal('show');
}


</script>

<script>
  let splitPages = []; // store pages in memory

  document.getElementById("pdfInput").addEventListener("change", async function(event) {
    const file = event.target.files[0];
    if (!file) return;

    if (file.type !== "application/pdf") {
      alert("Please upload a valid PDF file.");
      return;
    }

    const arrayBuffer = await file.arrayBuffer();
    const pdfDoc = await PDFLib.PDFDocument.load(arrayBuffer);

    const outputDiv = document.getElementById("output");
    outputDiv.innerHTML = "";
    splitPages = [];

    for (let i = 0; i < pdfDoc.getPageCount(); i++) {
      const newPdf = await PDFLib.PDFDocument.create();
      const [copiedPage] = await newPdf.copyPages(pdfDoc, [i]);
      newPdf.addPage(copiedPage);

      const pdfBytes = await newPdf.save();
      const blob = new Blob([pdfBytes], { type: "application/pdf" });
      const url = URL.createObjectURL(blob);

      // Save in memory
      splitPages.push({ blob, page: i+1, ticket: null });

      // Create wrapper
      const pageItem = document.createElement("div");
      pageItem.classList.add("page-item");
      pageItem.style.display = "flex";
      pageItem.style.alignItems = "center";
      pageItem.style.marginBottom = "8px";

      // Link
      const link = document.createElement("a");
      link.href = url;
      link.target = "_blank";
      link.textContent = `Preview Page ${i+1}`;
      link.style.marginRight = "10px";

      // Ticket selector
      const select = document.createElement("select");
      select.classList.add("form-select", "form-select-sm");
      select.style.width = "200px";
      select.innerHTML = `<option value="">Assign Ticket</option>
        @foreach ($data['tickets'] as $tickets)
          @if (empty($tickets['is_sold']))
          <option value="{{ $tickets['id'] }}">{{ $tickets['ticket_serial_number'] }}</option>
          @endif
        @endforeach
      `;
      select.addEventListener("change", function() {
        splitPages[i].ticket = this.value;
      });

      // Delete button
      const deleteBtn = document.createElement("button");
      deleteBtn.classList.add("btn", "btn-danger", "btn-sm", "ms-2");
      deleteBtn.textContent = "Delete";
      deleteBtn.addEventListener("click", function() {
        pageItem.remove();
        splitPages[i] = null; // mark deleted
      });

      pageItem.appendChild(link);
      pageItem.appendChild(select);
      pageItem.appendChild(deleteBtn);
      outputDiv.appendChild(pageItem);
    }
  });

  // Upload assigned pages to backend
  document.getElementById("uploadBtn").addEventListener("click", async function() {
    const formData = new FormData();

    splitPages.forEach((page, idx) => {
      if (page && page.ticket) {
        formData.append("files[]", page.blob, `page_${page.page}.pdf`);
        formData.append("tickets[]", page.ticket);
      }
    });

    if (!formData.has("files[]")) {
      alert("Please assign at least one page to a ticket.");
      return;
    }

    // Send to Laravel route
    let response = await fetch("{{ route('tickets.uploadSplit') }}", {
      method: "POST",
      headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
      body: formData
    });

    let result = await response.json();
    // alert("Upload finished!");
    // console.log(result);

     Swal.fire('Updated Tickets!','', 'success').then(function(){
            window.location.reload();

            });
  });

  function ticketPriceChange(val){

     $('#tickcet-price-change-modal').modal('show');
  }

  function deleteGeneratedTickets(val){

    Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                  $.ajax({
            url: '{{ route("delete.generated.ticket") }}',
            type: 'GET',
            data: {
               id:val,
            },
            success: function(response) {
            console.log(response);
window.location.reload();

            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });

            }
        });

  }
</script>

<script>
$(document).ready(function() {
    // Attach validation on form submit
    $("#tickcet-price-change-modal form").on("submit", function(e) {
        let originalPrice = $("#original-price").val().trim();
        let salePrice = $("#sale_price").val().trim();

        // Regex: integers or floats
        let numberPattern = /^[0-9]+(\.[0-9]+)?$/;

        if (!numberPattern.test(originalPrice)) {
            alert("Please enter a valid number for Original Price.");
            $("#original-price").focus();
            e.preventDefault();
            return false;
        }

        if (!numberPattern.test(salePrice)) {
            alert("Please enter a valid number for Sale Price.");
            $("#sale_price").focus();
            e.preventDefault();
            return false;
        }

        return true; // allow submit
    });

    // Optional: live restriction (only numbers + dot allowed)
    $("#original-price, #sale_price").on("keypress", function(e) {
        let charCode = e.which ? e.which : e.keyCode;
        // Allow: numbers (48–57), dot (46), backspace (8), delete (0)
        if ((charCode < 48 || charCode > 57) && charCode !== 46 && charCode !== 8 && charCode !== 0) {
            e.preventDefault();
        }
    });
});
</script>

@endsection
