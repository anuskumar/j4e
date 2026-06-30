<style>
/* Homepage – customer-facing polish only */
.home-hero .carousel-item {
    position: relative;
}

.home-hero .carousel-item img.banner_caro {
    width: 100%;
    height: 420px;
    object-fit: cover;
}

.home-hero .carousel-caption.home-hero__overlay {
    position: absolute;
    inset: 0;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: stretch;
    max-width: none;
    width: 100%;
    padding: 36px 48px;
    margin: 0;
    text-align: left;
    pointer-events: none;
}

.home-hero__caption-text {
    flex: 1;
    display: flex;
    align-items: center;
    width: 100%;
    pointer-events: none;
}

.home-hero__caption-text h1 {
    width: 100%;
    max-width: 100%;
    font-size: clamp(1.6rem, 3.5vw, 2.8rem);
    font-weight: 700;
    line-height: 1.25;
    margin: 0;
}

.home-hero__caption-action {
    align-self: flex-end;
    flex-shrink: 0;
    pointer-events: auto;
}

.home-hero__caption--white h1 {
    color: #fff;
    text-shadow: 0 2px 16px rgba(0, 0, 0, 0.5);
}

.home-hero__caption--black h1 {
    color: #111;
    text-shadow: 0 2px 16px rgba(255, 255, 255, 0.5);
}

.home-hero .carousel-caption .btn {
    border-radius: 999px;
    padding: 12px 32px;
    font-weight: 600;
    font-size: 15px;
    background: linear-gradient(135deg, #671dcf, #3b0d78);
    border: none;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
}

.home-hero .carousel-control-prev,
.home-hero .carousel-control-next {
    width: 48px;
    height: 48px;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.35);
    border-radius: 50%;
    opacity: 1;
}

.home-hero .carousel-control-prev { left: 16px; }
.home-hero .carousel-control-next { right: 16px; }

.popular-events {
    padding: 56px 0;
    background: #f8f9fc;
}

.popular-events .section-header h2 {
    font-size: clamp(1.5rem, 3vw, 2rem);
    font-weight: 700;
    color: #1a1a2e;
    text-transform: capitalize;
    margin-bottom: 0;
}

.popular-events .section-wraper {
    margin-bottom: 32px;
}

.popular-events .section-header p {
    color: #671dcf;
    font-weight: 700;
    font-size: 13px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 6px;
}

.popular-events .view-all {
    color: #671dcf;
    font-weight: 600;
    text-decoration: none;
}

.popular-events .view-all:hover {
    color: #3b0d78;
    text-decoration: underline;
}

.popular-events .event-card {
    display: block;
    text-decoration: none;
    color: inherit;
    margin-bottom: 28px;
    transition: transform 0.2s ease;
}

.popular-events .event-card:hover {
    transform: translateY(-4px);
    text-decoration: none;
}

.popular-events .service-box {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
    background: #fff;
    transition: box-shadow 0.2s ease;
}

.popular-events .event-card:hover .service-box {
    box-shadow: 0 14px 32px rgba(103, 29, 207, 0.15);
}

.popular-events .service-img {
    width: 100%;
    height: 220px;
    overflow: hidden;
}

.popular-events .service-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.popular-events .event-card:hover .service-img img {
    transform: scale(1.04);
}

.popular-events .event-card__title {
    color: #022F5C;
    font-weight: 700;
    font-size: 15px;
    text-align: center;
    margin-top: 14px;
    letter-spacing: 0.02em;
}

@media (max-width: 768px) {
    .home-hero .carousel-item img.banner_caro {
        height: 240px;
    }

    .home-hero .carousel-caption {
        display: none !important;
    }

    .popular-events {
        padding: 36px 0;
    }

    .popular-events .service-img {
        height: 180px;
    }
}

/* Customer reviews carousel */
.testimonial-section.reviews {
    padding: 56px 0;
    background: #fff;
}

.testimonial-section.reviews .section-header p {
    color: #671dcf;
    font-weight: 700;
    font-size: 13px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 6px;
}

.testimonial-section.reviews .section-header h2 {
    font-size: clamp(1.4rem, 3vw, 2rem);
    font-weight: 700;
    color: #1a1a2e;
    text-transform: capitalize;
}

.testimonial-section.reviews .view-all {
    color: #671dcf;
    font-weight: 600;
    text-decoration: none;
}

.testimonial-section.reviews .view-all:hover {
    color: #3b0d78;
    text-decoration: underline;
}

.testimonial-section.reviews .single-testimonial {
    background: #f8f9fc;
    border-radius: 12px;
    padding: 24px;
    height: 100%;
    border: 1px solid rgba(103, 29, 207, 0.08);
}

.testimonial-section.reviews .read-more-link {
    color: #671dcf;
    font-weight: 600;
    font-size: 14px;
}

.testimonial-section.reviews .single-testimonial .name a,
.testimonial-section.reviews .single-testimonial .name a:hover {
    color: #1a1a2e;
    text-decoration: none;
}

.testimonial-section.reviews .single-testimonial .name a:hover {
    color: #671dcf;
}

@media (max-width: 768px) {
    .testimonial-section.reviews {
        padding: 36px 0;
    }

    .testimonial-section.reviews .section-wraper .col-md-8,
    .testimonial-section.reviews .section-wraper .col-md-4 {
        text-align: center !important;
    }

    .testimonial-section.reviews .section-wraper .text-right {
        text-align: center !important;
        margin-top: 10px;
    }
}
</style>
