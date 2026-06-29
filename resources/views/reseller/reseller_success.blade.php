@extends('layouts.reseller_app')

@section('title', 'Thank You')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card bg-white shadow-lg border-0 p-5">
                <div class="mb-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75"
                        fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                    </svg>
                </div>
                <div class="text-center">
                    <h1 class="text-success mb-3">Thank You!</h1>
                    <p class="mt-4 text-muted">Thank you for completing your payment method. Your ticket listings are now saved
                        and will be reviewed for approval by the admin.</p>
                    <p class="text-muted">Once approved, your tickets will be live for sale.</p>
                    <a href="{{ route('reseller.mylistings') }}" class="btn btn-success mt-4 px-4 py-2">
                        <i class="bi bi-list-ul me-2"></i>View Your Listings
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
