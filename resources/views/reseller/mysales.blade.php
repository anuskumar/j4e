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
{{-- <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin: 0 auto;">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link {{ request()->routeIs('reseller.mylistings') ? 'active' : '' }} " href="{{ route('reseller.mylistings') }}" ><b>My Listings</b></a>
      <a class="nav-item nav-link  {{ request()->routeIs('reseller.mysales') ? 'active' : '' }}" href="{{ route('reseller.mysales') }}"><b>My Sales</b></a>

    </div>
  </div>
</nav> --}}
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
            <select class="form-select" name="ticket_status" aria-label="Default select example">
            <option value=""  {{ request('ticket_status') == '' ? 'selected' : '' }}>Ticket Status</option>
            <option value="0"  {{ request('ticket_status') == '0' ? 'selected' : '' }}>Not available</option>
            <option value="1"  {{ request('ticket_status') == '1' ? 'selected' : '' }}>Available</option>
            </select>
        </td>
        <td>
            <select class="form-select" name="sales_status" aria-label="Default select example">
            <option value=""  {{ request('sales_status') == '' ? 'selected' : '' }}>Sales Status</option>
            <option value="has_sales"  {{ request('sales_status') == 'has_sales' ? 'selected' : '' }}>Has Sales</option>
            <option value="no_sales"  {{ request('sales_status') == 'no_sales' ? 'selected' : '' }}>No Sales</option>
            </select>
        </td>
        <td>Event Start Date</td>
        <td><input class="form-control" name="start_date" type="date"  value="{{ request('start_date') }}"></td>
        <td>Event End Date</td>
        <td><input class="form-control" name="end_date" type="date"  value="{{ request('end_date') }}"></td>
    </tr>
    <tr>
        <td>Min Sales Count</td>
        <td><input type="number" class="form-control" name="min_sales" min="0" value="{{ request('min_sales') }}" placeholder="Min"></td>
        <td>Max Sales Count</td>
        <td><input type="number" class="form-control" name="max_sales" min="0" value="{{ request('max_sales') }}" placeholder="Max"></td>
        <td><input type="text" class="form-control" value="{{ request('search') }}" name="search" placeholder="Search"></td>
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
                                    <th class="border-bottom-0">ID and Creation Time</th>
                                    <th class="border-bottom-0">Event </th>.
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
                                        <b>{{ strtoupper(@$val['unique_id']) }}</b>
                                        <br>
                                        {{ date('d M Y',strtotime($val['created_at'])) }}
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
                                       <div class="text-muted">
                                        {{ 'Event ends ' . date('d M Y',strtotime($val['event_to_date'])) }}
                                        {{  $val['to_time'] }}
                                       </div>
                                    </td>
                                    <td>{{ $val['ticket_type_name'] }}</td>
                                    <td>{{ $val['ticket_type_name'] }}</td>
                                    <td> {{ $val['no_of_tickets'] }}</td>
                                    <td>
                                        <span class="badge text-bg-success">{{ $val['sales_count'] ?? 0 }} Sold</span>
                                    </td>
                                    <td>
                                        Ticket Amount : {{ $val['ticket_amount'].' '.$val['short_name'] }} <br>
                                        Face Value : {{ $val['face_value'].' '.$val['short_name'] }} <br>
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

<script>
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
    fetch(`/tickets/update-ticket-status/${ticketId}`, {
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


</script>
    {{-- @include('datatable.datatable_js') --}}
@endsection
