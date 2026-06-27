<?php $page = 'review-detail'; ?>
@extends('layout.mainlayout')
@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reviews') }}">Reviews</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $review->customer_name }}</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Review Details</h2>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<div class="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card review-detail-card">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-start mb-4">
                            <img class="review-detail-avatar rounded-circle me-3"
                                src="{{ $review->photoUrl() }}"
                                alt="{{ $review->customer_name }}"
                                onerror="this.src='{{ asset('assets/img/testimonial/avatar-01.jpg') }}'">
                            <div>
                                <h3 class="mb-1">{{ $review->customer_name }}</h3>
                                @if ($review->subtitle)
                                <p class="text-muted mb-2">{{ $review->subtitle }}</p>
                                @endif
                                <div class="rating mb-0">
                                    @include('partials.star_rating', ['rating' => $review->rating, 'showAverage' => true])
                                </div>
                            </div>
                        </div>

                        <div class="review-detail-content">
                            <h5 class="mb-3">Customer Review</h5>
                            <p class="mb-0">{{ $review->review_content }}</p>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <a href="{{ route('reviews') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Back to All Reviews
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.review-detail-avatar {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border: 1px solid #e8ebf3;
}
.review-detail-card {
    border: none;
    box-shadow: 0 0 70px rgba(0, 0, 0, 0.05);
    border-radius: 10px;
}
.review-detail-content p {
    font-size: 16px;
    line-height: 1.7;
    color: #202020;
}
.read-more-link {
    color: #3800B9;
    font-weight: 600;
    font-size: 14px;
}
.single-testimonial .name a,
.single-testimonial .name a:hover {
    color: #000;
    text-decoration: none;
}
.single-testimonial .name a:hover {
    color: #3800B9;
}
</style>
@endsection
