@include('partials.customer_banner_styles')

<section class="customer-site-banner">
    <div class="customer-site-banner__trust">
        <div class="container text-center">
            <span class="customer-site-banner__trust-track">
                Just 4 Entertainment is a secondary marketplace for live events. All tickets are 100% guaranteed and secure!
            </span>
        </div>
    </div>

    <div class="customer-site-banner__types">
        <div class="container">
            @include('partials.header_event_types')
        </div>
    </div>

    @stack('customer_banner_hero')
</section>
