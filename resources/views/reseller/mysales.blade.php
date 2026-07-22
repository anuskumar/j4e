<?php $page = 'events/list'; ?>
{{-- @extends('admin.layout.app')
@section('admin_content') --}}
@extends('layouts.reseller_app')
@section('content')
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Events</h3>
                </div>
@include('reseller.listing_nav')
<form method="GET" action="{{ route('reseller.mysales') }}">
<table class="table table-striped">
    <tr>
        <td>
            <select class="form-select" name="ticket_type" aria-label="Default select example">
            <option value="">Ticket Type</option>
            @foreach ($ticket_type as $type)
                <option value="{{ $type->id }}"  {{ request('ticket_type') ==  $type->id  ? 'selected' : '' }}>{{ $type->ticket_type_name }}</option>
            @endforeach

            </select>
        </td>
        <td>
            <select class="form-select" name="ticket_status" aria-label="Ticket Status">
            <option value=""  {{ request('ticket_status') == '' ? 'selected' : '' }}>Ticket Status</option>
            <option value="active"  {{ request('ticket_status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="paused"  {{ request('ticket_status') == 'paused' ? 'selected' : '' }}>Post</option>
            <option value="unapproved"  {{ request('ticket_status') == 'unapproved' ? 'selected' : '' }}>Unapproved</option>
            <option value="sold"  {{ request('ticket_status') == 'sold' ? 'selected' : '' }}>Sold</option>
            <option value="pending"  {{ request('ticket_status') == 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </td>
        <td>Event Start Date</td>
        <td><input class="form-control" name="start_date" type="date"  value="{{ request('start_date') }}"></td>
        <td>
            <label for="mysales-search" class="form-label mb-0">Event Name / Event Number</label>
            <input type="text" class="form-control" id="mysales-search" value="{{ request('search') }}" name="search" placeholder="Event name or number">
        </td>
    </tr>
    <tr>
        <td>Min Sales Count</td>
        <td><input type="number" class="form-control" name="min_sales" min="0" value="{{ request('min_sales') }}" placeholder="Min"></td>
        <td>Max Sales Count</td>
        <td><input type="number" class="form-control" name="max_sales" min="0" value="{{ request('max_sales') }}" placeholder="Max"></td>
        <td>
            <button class="btn btn-primary" type="submit">Search</button>
            <a href="{{ route('reseller.mysales') }}" class="btn btn-secondary">Reset</a>
        </td>
    </tr>
</table>
</form>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="file-datatable"
                            class="border-top-0 dataTables  table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th class="border-bottom-0">ID and Sale Date</th>
                                    <th class="border-bottom-0">Event </th>
                                    <th class="border-bottom-0">Ticket Type</th>
                                    <th class="border-bottom-0">Available Delivery</th>
                                    <th class="border-bottom-0">Ticket</th>
                                    <th class="border-bottom-0">Sales Count</th>
                                    <th class="border-bottom-0">Price</th>
                                    <th class="border-bottom-0">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sl = 1;
                                @endphp
                                @foreach ($data as $val)
                                <tr>
                                    <td>{{ $sl++ }}</td>
                                    <td>
                                        <b>{{ $val['latest_sales_id'] ?? 'N/A' }}</b>
                                        <br>
                                        {{ !empty($val['latest_sale_time']) ? date('d M Y h:i A', strtotime($val['latest_sale_time'])) : 'N/A' }}
                                    </td>
                                    <td>
                                       {{ $val['event_name'] }}
                                       <div class="text-muted">
                                        {{ $val['venue_name'] }},{{ $val['city_name'] }}
                                       </div>
                                       <div class="text-muted">
                                        {{ 'Event starts ' . date('d M Y',strtotime($val['event_from_date'])) }}
                                        {{  $val['from_time'] }}
                                       </div>
                                    </td>
                                    <td>{{ $val['ticket_type_name'] }}</td>
                                    <td>
                                        <div><strong>Section:</strong> {{ $val['seating_type_name'] ?: '—' }}</div>
                                        <div><strong>Row:</strong> {{ $val['row'] ?: '—' }}</div>
                                        <div>
                                            <strong>Seat:</strong>
                                            @if (!empty($val['seat_from']) || !empty($val['seat_to']))
                                                {{ $val['seat_from'] ?: '—' }}{{ !empty($val['seat_to']) ? ' – ' . $val['seat_to'] : '' }}
                                            @else
                                                —
                                            @endif
                                        </div>
                                    </td>
                                    <td> {{ $val['no_of_tickets'] }}</td>
                                    <td>
                                        <span class="badge text-bg-success">{{ $val['sales_count'] ?? 0 }} Sold</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span>{{ $val['ticket_amount'] }} {{ $val['short_name'] }}</span>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-secondary py-0 px-1"
                                                title="Edit ticket amount"
                                                onclick="openTicketAmountModal({{ $val['id'] }}, '{{ $val['ticket_amount'] }}', '{{ $val['face_value'] }}', '{{ $val['short_name'] ?? '' }}')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </div>
                                        <div class="text-muted small mt-1">Face Value: {{ $val['face_value'] }} {{ $val['short_name'] }}</div>
                                    </td>
                                    <td>
                                        <a href="{{ route('reseller.view.soldtickets',$val['id']) }}" class="btn btn-info btn-sm" title="View Sold Tickets">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <div class="d-flex justify-content-center">
                            {!! $data->links() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="admin_assets/js/main.js"></script>
    <!-- End Row -->

<div class="modal fade" id="ticket-amount-change-modal" tabindex="-1" aria-labelledby="ticketAmountChangeLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('update.ticket.pricechange') }}" method="POST" id="ticket-amount-change-form">
        <input type="hidden" name="ticket_id" id="ticket-amount-ticket-id">
        <input type="hidden" name="original_price" id="ticket-amount-original-price">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ticketAmountChangeLabel">Update Ticket Amount</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label for="ticket-amount-sale-price" class="form-label">Ticket Amount</label>
        <div class="input-group">
            <input type="text" class="form-control" name="sale_price" id="ticket-amount-sale-price" required>
            <span class="input-group-text" id="ticket-amount-currency">USD</span>
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

<script>
function openTicketAmountModal(ticketId, salePrice, originalPrice, currency) {
    document.getElementById('ticket-amount-ticket-id').value = ticketId;
    document.getElementById('ticket-amount-sale-price').value = salePrice;
    document.getElementById('ticket-amount-original-price').value = originalPrice;
    document.getElementById('ticket-amount-currency').textContent = currency || 'USD';
    $('#ticket-amount-change-modal').modal('show');
}

$('#ticket-amount-change-form').on('submit', function(e) {
    const salePrice = $('#ticket-amount-sale-price').val().trim();
    const numberPattern = /^[0-9]+(\.[0-9]+)?$/;

    if (!numberPattern.test(salePrice) || parseFloat(salePrice) <= 0) {
        e.preventDefault();
        alert('Please enter a valid ticket amount.');
        $('#ticket-amount-sale-price').focus();
        return false;
    }

    return true;
});
</script>
    {{-- @include('datatable.datatable_js') --}}
@endsection
