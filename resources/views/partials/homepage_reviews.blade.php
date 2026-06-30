@php
    $homepageReviews = $customer_reviews
        ?? \App\Models\CustomerReview::active()
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
