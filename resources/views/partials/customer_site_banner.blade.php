@include('partials.customer_banner_styles')

@php
    $marqueeText = trim((string) ($companySettings?->bannerMessage() ?? 'All tickets are 100% guaranteed and secure.'));
@endphp

<section class="customer-site-banner">
    <div class="customer-site-banner__trust">
        <div class="customer-site-banner__trust-viewport">
            <div class="customer-site-banner__trust-track" aria-label="{{ $marqueeText }}">
                <span class="customer-site-banner__trust-item">{{ $marqueeText }}</span>
            </div>
        </div>
    </div>

    <div class="customer-site-banner__types">
        <div class="container">
            @include('partials.header_event_types')
        </div>
    </div>

    @stack('customer_banner_hero')
</section>
