<?php $page = 'events/list'; ?>
@extends('layouts.reseller_app')
@section('content')

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>Sold Tickets - {{ $mainTicket->unique_id ?? 'N/A' }}</h3>
                    <a href="{{ route('reseller.mysales') }}" class="btn btn-secondary">Back to My Sales</a>
                </div>
            </div>
        </div>

        <!-- Main Ticket Information -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ticket Listing Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Event:</strong> {{ $mainTicket->event_name ?? 'N/A' }}</p>
                                <p><strong>Venue:</strong> {{ $mainTicket->venue_name ?? 'N/A' }}, {{ $mainTicket->city_name ?? 'N/A' }}</p>
                                <p><strong>Ticket Type:</strong> {{ $mainTicket->ticket_type_name ?? 'N/A' }}</p>
                                <p><strong>Section:</strong> {{ $mainTicket->seating_type_name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Event Date:</strong> 
                                    @if(isset($mainTicket->event_date))
                                        {{ date('d M Y', strtotime($mainTicket->event_date)) }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                                <p><strong>Event Time:</strong> 
                                    @if(isset($mainTicket->from_time))
                                        {{ $mainTicket->from_time }}
                                        @if(isset($mainTicket->to_time))
                                            - {{ $mainTicket->to_time }}
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </p>
                                <p><strong>Total Tickets:</strong> {{ $mainTicket->no_of_tickets ?? 'N/A' }}</p>
                                <p><strong>Price:</strong> {{ $mainTicket->ticket_amount ?? '0' }} {{ $mainTicket->short_name ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sold Tickets List -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Sold Tickets ({{ $soldTickets->count() }})</h5>
                    </div>
                    <div class="card-body">
                        @if($soldTickets->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ticket Serial Number</th>
                                            <th>Seat Number</th>
                                            <th>Section/Type</th>
                                            <th>Event Date</th>
                                            <th>Event Time</th>
                                            <th>Status</th>
                                            <th>Ticket File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sl = 1;
                                        @endphp
                                        @foreach($soldTickets as $ticket)
                                            <tr>
                                                <td>{{ $sl++ }}</td>
                                                <td><strong>{{ $ticket->ticket_serial_number ?? 'N/A' }}</strong></td>
                                                <td>{{ $ticket->seat_number ?? 'N/A' }}</td>
                                                <td>{{ $ticket->seating_type_name ?? 'N/A' }}</td>
                                                <td>
                                                    @if(isset($ticket->event_date))
                                                        {{ date('d M Y', strtotime($ticket->event_date)) }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($ticket->from_time))
                                                        {{ $ticket->from_time }}
                                                        @if(isset($ticket->to_time))
                                                            - {{ $ticket->to_time }}
                                                        @endif
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($ticket->is_sold == 1)
                                                        <span class="badge text-bg-success">Sold</span>
                                                    @else
                                                        <span class="badge text-bg-secondary">Available</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($ticket->file) && $ticket->file)
                                                        <a href="{{ asset('storage/' . $ticket->file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                    @else
                                                        <span class="text-muted">No file</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <h5>No Sold Tickets</h5>
                                <p>There are no sold tickets for this listing yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <a href="{{ route('reseller.mysales') }}" class="btn btn-primary">Back to My Sales</a>
            </div>
        </div>
    </div>

@endsection

