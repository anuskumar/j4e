@php
    $ratingValue = isset($rating) ? (float) $rating : 0;
    $fullStars = (int) floor($ratingValue);
    $hasHalfStar = ($ratingValue - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
@endphp
@for ($i = 0; $i < $fullStars; $i++)
    <i class="fas fa-star filled"></i>
@endfor
@if ($hasHalfStar)
    <i class="fas fa-star-half-alt filled"></i>
@endif
@for ($i = 0; $i < $emptyStars; $i++)
    <i class="fas fa-star"></i>
@endfor
@if (!empty($showAverage))
    <span class="average-rating">{{ rtrim(rtrim(number_format($ratingValue, 1), '0'), '.') }}</span>
@endif
