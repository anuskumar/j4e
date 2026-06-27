@php
    $homepageReviews = \App\Models\CustomerReview::where('is_active', 1)
        ->orderBy('sort_order')
        ->orderBy('id', 'desc')
        ->get();
@endphp

<!-- Reviews-->
<section class="testimonial-section reviews">
    <div class="container">
        <div class="section-wraper row d-flex align-items-center">
            <div class="col-md-8 col-lg-6 section-header mb-0">
                <p>#TOP REVIEWS</p>
                <h2>REVIEWS FROM OUR CUSTOMERS.</h2>
            </div>
            <div class="col-md-4 col-lg-6 text-right">
                <a href="{{ route('reviews') }}" class="view-all">View all</a>
            </div>
        </div>
        <style>
        /* Reviews section mobile responsive */
        @media (max-width: 768px) {
            .section-wraper .col-md-8,
            .section-wraper .col-md-4 {
                text-align: center !important;
            }

            .section-wraper .text-right {
                text-align: center !important;
                margin-top: 10px;
            }

            .testimonial-section .section-header p {
                font-size: 14px;
            }

            .testimonial-section .section-header h2 {
                font-size: 22px;
            }
        }
        </style>

        <style>
        .read-more-link {
            color: #3800B9;
            font-weight: 600;
            font-size: 14px;
            display: inline-block;
            margin-top: 8px;
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

        <div id="testimonial-slider" class="owl-carousel owl-theme testimonial-slider">
            @forelse ($homepageReviews as $review)
            <div class="single-testimonial">
                <div class="client-info">
                    <div class="client-photo">
                        <a href="{{ route('reviews.show', $review->id) }}">
                            <img src="{{ $review->photoUrl() }}" alt="{{ $review->customer_name }}"
                                onerror="this.src='{{ asset('assets/img/testimonial/avatar-01.jpg') }}'">
                        </a>
                    </div>
                    <div class="client-details">
                        <h4 class="name">
                            <a href="{{ route('reviews.show', $review->id) }}">{{ $review->customer_name }}</a>
                        </h4>
                        @if ($review->subtitle)
                        <div class="sub-title">{{ $review->subtitle }}</div>
                        @endif
                        <div class="rating">
                            @include('partials.star_rating', ['rating' => $review->rating, 'showAverage' => true])
                        </div>
                    </div>
                </div>
                <div class="desc">
                    <p>{{ Str::limit($review->review_content, 160) }}</p>
                    @if (strlen($review->review_content) > 160)
                    <a href="{{ route('reviews.show', $review->id) }}" class="read-more-link">Read full review</a>
                    @endif
                </div>
            </div>
            @empty
            <div class="single-testimonial">
                <div class="desc">
                    <p class="text-center mb-0">No customer reviews available yet.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!-- /Reviews-->
