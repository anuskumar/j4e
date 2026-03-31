<?php $page="ticket-details";?>
@extends('layout.mainlayout')
@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('customer.home') }}">My Bookings</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ticket Details</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Ticket Details</h2>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Event: {{ $purchase_data->event_name ?? 'N/A' }}</h4>
                        <p class="mb-0">Purchase ID: #{{ str_pad($purchase_data->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6><strong>Event Information</strong></h6>
                                <p><strong>Event Name:</strong> {{ $purchase_data->event_name ?? 'N/A' }}</p>
                                <p><strong>Event Date:</strong> {{ $purchase_data->event_date->event_date ?? 'N/A' }}</p>
                                <p><strong>Event Time:</strong> {{ ($purchase_data->event_date->from_time ?? '') . ' - ' . ($purchase_data->event_date->to_time ?? '') }}</p>
                                <p><strong>Event Type:</strong> {{ $purchase_data->event_type_name ?? 'N/A' }}</p>
                                <p><strong>Tag:</strong> {{ $purchase_data->tag_name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Purchase Information</strong></h6>
                                <p><strong>Booking Date:</strong> {{ $purchase_data->event_from_date ?? 'N/A' }}</p>
                                <p><strong>Purchased Date:</strong> {{ $purchase_data->created_at ?? 'N/A' }}</p>
                                <p><strong>Amount:</strong> {{ number_format($purchase_data->payment_amount ?? 0, 2) }} {{ $purchase_data->short_name ?? '' }}</p>
                                <p><strong>Status:</strong> {{ $purchase_data->status_name ?? 'N/A' }}</p>
                                <p><strong>Payment Status:</strong> {{ $purchase_data->is_payment_completed == 1 ? "Payment Completed" : "Not Completed" }}</p>
                            </div>
                        </div>

                        <hr>

                        <h5 class="mb-3"><strong>Tickets ({{ $tickets->count() }})</strong></h5>
                        
                        <div class="ticket-details-container">
                            @foreach($tickets as $index => $ticket)
                                <div class="card mb-3" style="border: 1px solid #ddd;">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><strong>Ticket #{{ $index + 1 }}</strong></h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Ticket Serial Number:</strong><br>{{ $ticket->ticket_serial_number ?? 'N/A' }}</p>
                                                <p><strong>Ticket Name:</strong><br>{{ $ticket->ticket_name ?? 'N/A' }}</p>
                                                <p><strong>Event Name:</strong><br>{{ $ticket->event_name ?? 'N/A' }}</p>
                                                <p><strong>Event Date:</strong><br>{{ $ticket->event_date ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Event Time:</strong><br>{{ ($ticket->from_time ?? '') . ' - ' . ($ticket->to_time ?? '') }}</p>
                                                <p><strong>Seating Type:</strong><br>{{ $ticket->seating_type_name ?? 'N/A' }}</p>
                                                <p><strong>Seat Number:</strong><br>{{ $ticket->seat_number ?? 'N/A' }}</p>
                                                <p><strong>Seat Row:</strong><br>{{ $ticket->seat_row ?? 'N/A' }}</p>
                                                <p><strong>Ticket Amount:</strong><br>{{ number_format($ticket->ticket_amount ?? 0, 2) }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p><strong>Ticket File:</strong></p>
                                                @if($ticket->file && !empty($ticket->file))
                                                    @php
                                                        // File field contains full path like 'uploads/ticket_images/filename.pdf'
                                                        if (strpos($ticket->file, 'http') === 0 || strpos($ticket->file, 'https') === 0) {
                                                            // Already a full URL
                                                            $fileUrl = $ticket->file;
                                                        } elseif (strpos($ticket->file, '/') === 0) {
                                                            // Absolute path starting with /
                                                            $fileUrl = $ticket->file;
                                                        } elseif (strpos($ticket->file, 'uploads/') === 0) {
                                                            // Path starts with uploads/ - files are in storage/uploads/
                                                            // Use Storage disk which points to storage/app/public, but files are in storage/uploads/
                                                            // So use asset with storage symlink
                                                            $fileUrl = asset('storage/' . $ticket->file);
                                                        } else {
                                                            // Just filename - assume it's in ticket_images folder
                                                            $fileUrl = asset('storage/uploads/ticket_images/' . $ticket->file);
                                                        }
                                                        $fileExtension = strtolower(pathinfo($ticket->file, PATHINFO_EXTENSION));
                                                    @endphp
                                                    <a href="{{ $fileUrl }}" target="_blank" class="btn btn-success btn-sm" download>
                                                        <i class="fas fa-file-download"></i> Download Ticket File
                                                    </a>
                                                    @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'pdf']))
                                                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-info btn-sm ml-2">
                                                            <i class="fas fa-eye"></i> View File
                                                        </a>
                                                    @endif
                                                @else
                                                    <span class="text-muted"><i class="fas fa-info-circle"></i> No attachment found</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('customer.home') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to My Bookings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Page Content -->
@endsection

