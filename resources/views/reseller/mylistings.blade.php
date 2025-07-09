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
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin: 0 auto;">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link " href="{{ route('reseller.mylistings') }}">My Listings</a>
      <a class="nav-item nav-link" href="#">My Sales</a>

    </div>
  </div>
</nav>
<table class="table table-striped">
    <tr>
        <td>
            <select class="form-select" aria-label="Default select example">
            <option selected>Ticket Type</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
            </select>
        </td><td>
            <select class="form-select" aria-label="Default select example">
            <option selected>Ticket Status</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
            </select>
        </td>
        <td>Event Start Date</td>
        <td><input class="form-control" type="date"></td>
        <td>Event End Date</td>
        <td><input class="form-control" type="date"></td>
        <td><input type="text" class="form-control" placeholder="Search"></td>
        <td>
            <button class="btn btn-primary" type="button">Search</button>
        </td>
    </tr>
</table>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="file-datatable"
                            class="border-top-0 dataTables  table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th class="border-bottom-0">ID and Creation Time</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Event </th>.
                                    <th class="border-bottom-0">Ticket Type</th>
                                    <th class="border-bottom-0">Available Delivery</th>
                                    <th class="border-bottom-0">Ticket</th>
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
                                        <div class="form-check form-switch">
                                        <input class="form-check-input"
                                                type="checkbox"
                                                role="switch"
                                                id="switchCheckChecked_{{ $val['id'] }}"
                                                data-id="{{ $val['id'] }}"
                                                data-status="{{ $val['ticket_status']}}"
                                                onchange="confirmToggleStatus(this)"
                                                {{ $val['ticket_status'] == 1 ? 'checked':'' }}

                                                value="{{ $val['ticket_status'] }}">

                                            @if ($val['is_admin_approved'] == 1)
                                               @if($val['ticket_status'] == 1)
                                                <span class="badge text-bg-success">Active</span>
                                                @else
                                                    <span class="badge text-bg-primary">Paused</span>
                                                @endif
                                            @else
                                            <span class="badge text-bg-primary">Waiting for Approval</span>
                                            @endif



                                            </div>
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
                                    <td> 1 &times; {{ $val['no_of_tickets'] }}</td>
                                    <td>
                                        Ticket Amount : {{ $val['ticket_amount'].' '.$val['short_name'] }} <br>
                                        Face Value : {{ $val['face_value'].' '.$val['short_name'] }} <br>
                                    </td>
                                    <td>
                                        <a href="{{ route('reseller.manage.eventticket',$val['id']) }}" class="btn btn-light btn-sm"> <b> > </b></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <div class="d-flex justify-content-center">
                            {{-- {!! $data->links() !!} --}}
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
