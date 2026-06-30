@php
    $reviewList = $customer_reviews ?? \App\Models\CustomerReview::where('is_active', 1)
        ->orderBy('sort_order')
        ->orderBy('id', 'desc')
        ->get();
@endphp

<ul class="comments-list">
    @forelse ($reviewList as $review)
    <li>
        <div class="comment">
            <img class="avatar rounded-circle" alt="{{ $review->customer_name }}"
                src="{{ $review->photoUrl() }}"
                onerror="this.src='{{ asset('assets/img/testimonial/avatar-01.jpg') }}'">
            <div class="comment-body">
                <div class="meta-data">
                    <span class="comment-author">
                        <a href="{{ route('reviews.show', $review->id) }}">{{ $review->customer_name }}</a>
                    </span>
                    @if ($review->subtitle)
                    <span class="comment-date">{{ $review->subtitle }}</span>
                    @endif
                    <div class="review-count rating">
                        @include('partials.star_rating', ['rating' => $review->rating, 'showAverage' => true])
                    </div>
                </div>
                <p class="comment-content">
                    {{ $review->review_content }}
                </p>
                <div class="comment-reply">
                    <a class="comment-btn" href="{{ route('reviews.show', $review->id) }}">
                        <i class="far fa-eye"></i> View Details
                    </a>
                </div>
            </div>
        </div>
    </li>
    @empty
    <li>
        <div class="comment">
            <div class="comment-body">
                <p class="comment-content mb-0">No customer reviews available yet.</p>
            </div>
        </div>
    </li>
    @endforelse
</ul>

@if ($reviewList instanceof \Illuminate\Contracts\Pagination\Paginator)
<div class="d-flex justify-content-center mt-4">
    {{ $reviewList->links() }}
</div>
@endif
