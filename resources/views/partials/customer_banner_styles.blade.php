<style>
.customer-site-banner {
    width: 100%;
}

.customer-site-banner__trust {
    background: #7e0982;
    color: #fff;
    font-size: 13px;
    padding: 8px 0;
    overflow: hidden;
}

.customer-site-banner__trust-track {
    display: inline-block;
    white-space: nowrap;
    animation: customerBannerMarquee 22s linear infinite;
}

@keyframes customerBannerMarquee {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}

.customer-site-banner__types {
    background: #7e0982;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
}

.customer-site-banner__types .container {
    padding-top: 0;
    padding-bottom: 0;
}

.customer-site-banner__hero {
    background: #7e0982;
    padding: 28px 0 36px;
    color: #fff;
}

.customer-site-banner__hero .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0 0 16px;
}

.customer-site-banner__hero .breadcrumb-item,
.customer-site-banner__hero .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.75);
    font-size: 14px;
}

.customer-site-banner__hero .breadcrumb-item.active {
    color: #fff;
}

.customer-site-banner__hero .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.5);
}

.customer-site-banner__hero-title {
    font-size: clamp(1.5rem, 3vw, 2.2rem);
    font-weight: 700;
    margin: 0 0 8px;
    text-transform: uppercase;
    letter-spacing: 0.02em;
}

.customer-site-banner__hero-meta {
    font-size: 15px;
    color: rgba(255, 255, 255, 0.85);
    margin: 0;
}

.customer-site-banner__hero-filter {
    margin-top: 20px;
}

.customer-site-banner__hero-filter label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 8px;
    color: rgba(255, 255, 255, 0.9);
}

.customer-site-banner__hero-filter select {
    border: none;
    border-radius: 999px;
    min-height: 44px;
    padding: 0 18px;
    max-width: 320px;
    width: 100%;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

.header-event-types {
    overflow: visible;
}

.header-event-types__inner {
    overflow: visible;
}

.header-event-types__list {
    display: flex;
    align-items: stretch;
    justify-content: center;
    flex-wrap: nowrap;
    gap: 2px;
    list-style: none;
    margin: 0;
    padding: 0;
    white-space: nowrap;
}

.header-event-types__list > li {
    flex-shrink: 0;
}

.header-event-types__more {
    position: relative;
}

.header-event-types__list a,
.header-event-types__more-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 14px 16px;
    color: rgba(255, 255, 255, 0.9);
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    border-bottom: 3px solid transparent;
    border-radius: 0;
    background: transparent;
    transition: all 0.2s ease;
    cursor: pointer;
    white-space: nowrap;
}

.header-event-types__more-btn.dropdown-toggle::after {
    display: none;
}

.header-event-types__list a:hover,
.header-event-types__list a.active,
.header-event-types__more-btn:hover,
.header-event-types__more-btn.active,
.header-event-types__more-btn.is-open {
    color: #fff;
    background: rgba(255, 255, 255, 0.08);
    border-bottom-color: #fff;
}

.header-event-types__more-btn i {
    font-size: 10px;
    transition: transform 0.2s ease;
}

.header-event-types__more-btn.is-open i {
    transform: rotate(180deg);
}

.header-event-types__dropdown {
    min-width: 200px;
    margin-top: 0;
    padding: 6px 0;
    border: none;
    border-radius: 0 0 10px 10px;
    box-shadow: 0 10px 28px rgba(0, 0, 0, 0.25);
    background: #6d0875;
}

.header-event-types__dropdown .dropdown-item {
    padding: 10px 16px;
    color: rgba(255, 255, 255, 0.92);
    font-size: 13px;
    font-weight: 600;
}

.header-event-types__dropdown .dropdown-item:hover,
.header-event-types__dropdown .dropdown-item.active {
    background: rgba(255, 255, 255, 0.12);
    color: #fff;
}

@media (min-width: 992px) {
    .customer-site-banner__hero-filter {
        margin-top: 0;
    }
}

@media (max-width: 991px) {
    .header-event-types__list {
        overflow-x: auto;
        scrollbar-width: none;
        padding-bottom: 2px;
    }

    .header-event-types__list::-webkit-scrollbar {
        display: none;
    }

    .customer-site-banner__hero-filter select {
        max-width: 100%;
    }
}
</style>
