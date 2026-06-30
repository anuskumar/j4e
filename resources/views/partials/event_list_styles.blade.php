<style>
.event-list-page {
    background: #f8f9fc;
    padding-bottom: 56px;
}

.event-list-content {
    margin-top: -24px;
    position: relative;
    z-index: 2;
}

.event-list-panel {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 10px 32px rgba(15, 23, 42, 0.08);
    padding: 24px;
}

.event-list-search-alert {
    border: none;
    border-radius: 12px;
    background: rgba(103, 29, 207, 0.08);
    color: #1a1a2e;
    margin-bottom: 24px;
}

.event-list-search-alert .alert-heading {
    font-size: 18px;
    font-weight: 700;
    color: #671dcf;
}

.event-list-cards {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.event-list-card {
    display: grid;
    grid-template-columns: 88px 1fr auto;
    gap: 20px;
    align-items: center;
    padding: 20px 24px;
    border: 1px solid rgba(103, 29, 207, 0.1);
    border-radius: 14px;
    background: #fff;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    text-decoration: none;
    color: inherit;
}

.event-list-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(103, 29, 207, 0.12);
    border-color: rgba(103, 29, 207, 0.25);
    text-decoration: none;
    color: inherit;
}

.event-list-card__date {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-width: 88px;
    min-height: 88px;
    border-radius: 12px;
    background: linear-gradient(135deg, #671dcf, #3b0d78);
    color: #fff;
    text-align: center;
    padding: 10px;
}

.event-list-card__date-day {
    font-size: 22px;
    font-weight: 700;
    line-height: 1.1;
}

.event-list-card__date-month {
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    opacity: 0.9;
}

.event-list-card__date-weekday {
    font-size: 12px;
    margin-top: 4px;
    opacity: 0.85;
}

.event-list-card__body {
    min-width: 0;
}

.event-list-card__title {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 8px;
}

.event-list-card__meta {
    display: flex;
    flex-wrap: wrap;
    gap: 12px 18px;
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

.event-list-card__meta span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.event-list-card__meta i {
    color: #671dcf;
    width: 14px;
}

.event-list-card__badge {
    display: inline-block;
    margin-top: 10px;
    padding: 4px 10px;
    border-radius: 999px;
    background: rgba(103, 29, 207, 0.1);
    color: #671dcf;
    font-size: 12px;
    font-weight: 600;
}

.event-list-card__cta {
    flex-shrink: 0;
}

.event-list-card__btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 130px;
    padding: 12px 22px;
    border-radius: 999px;
    background: linear-gradient(135deg, #671dcf, #3b0d78);
    color: #fff !important;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    white-space: nowrap;
    transition: opacity 0.2s ease;
}

.event-list-card__btn:hover {
    opacity: 0.92;
    color: #fff;
    text-decoration: none;
}

.event-list-empty {
    text-align: center;
    padding: 48px 24px;
    border-radius: 14px;
    background: #f8f9fc;
    border: 1px dashed rgba(103, 29, 207, 0.2);
}

.event-list-empty h4 {
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 10px;
}

.event-list-empty p {
    color: #6b7280;
    margin-bottom: 20px;
}

.event-list-empty .btn {
    border-radius: 999px;
    padding: 10px 24px;
    background: linear-gradient(135deg, #671dcf, #3b0d78);
    border: none;
}

@media (max-width: 768px) {
    .event-list-page {
        padding-bottom: 36px;
    }

    .event-list-panel {
        padding: 16px;
        border-radius: 12px;
    }

    .event-list-card {
        grid-template-columns: 72px 1fr;
        grid-template-rows: auto auto;
        gap: 14px;
        padding: 16px;
    }

    .event-list-card__date {
        min-width: 72px;
        min-height: 72px;
        grid-row: span 2;
    }

    .event-list-card__date-day {
        font-size: 18px;
    }

    .event-list-card__title {
        font-size: 16px;
    }

    .event-list-card__meta {
        font-size: 13px;
        gap: 8px 12px;
    }

    .event-list-card__cta {
        grid-column: 2;
    }

    .event-list-card__btn {
        width: 100%;
        min-width: 0;
    }
}
</style>
