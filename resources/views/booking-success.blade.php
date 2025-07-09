<?php $page="booking-success"; ?>
@extends('layout.mainlayout')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Booking</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Booking</h2>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Trigger Modal -->
<div class="content success-page-cont">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <button type="button" id="successModalButton" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#successModal">
                    Show Success Modal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                <h3 class="mt-3">Booking Done Successfully!</h3>
                <p>Event/Show booked with <strong>{{ Str::ucfirst($data->event_name) }}</strong><br>
                   on <strong>{{ date('d M Y',strtotime($data->event_date)) }} &nbsp; {{ date('H:i A',strtotime($data->event_time)) }}</strong>
                </p>
                <a href="{{ url('view_invoice', $id) }}" class="btn btn-primary view-inv-btn">View Invoice</a>
            </div>
        </div>
    </div>
</div>



<!-- Trigger the Modal Script -->
<script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    document.addEventListener('DOMContentLoaded', function() {
        // Automatically trigger the modal after page load
        document.getElementById('successModalButton').click();
    });
</script>
@endsection
