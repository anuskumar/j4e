@php
    $statusName = $booking->status_name ?? 'N/A';
    $statusClass = 'secondary';
    if (in_array($statusName, ['Completed', 'Shipped'])) {
        $statusClass = 'success';
    } elseif (in_array($statusName, ['Processing', 'New Order', 'On Hold'])) {
        $statusClass = 'warning';
    } elseif ($statusName === 'Cancelled') {
        $statusClass = 'danger';
    } elseif ($statusName !== 'N/A') {
        $statusClass = 'info';
    }

    $eventImage = $booking->event_image
        ? asset('storage/uploads/events/' . $booking->event_image)
        : asset('assets/img/events/event-01.jpg');
@endphp

<div class="booking-card">
    <div class="booking-card__top">
        <img src="{{ $eventImage }}" alt="{{ $booking->event_name }}" class="booking-card__image"
            onerror="this.onerror=null;this.src='{{ asset('assets/img/events/event-01.jpg') }}';">
        <div class="flex-grow-1">
            <div class="d-flex flex-wrap align-items-start justify-content-between gap-2">
                <div>
                    <div class="booking-card__title">
                        <a href="{{ url('show_details_show', $booking->event_id) }}" class="text-dark">{{ $booking->event_name }}</a>
                    </div>
                    <div class="booking-card__subtitle">{{ $booking->tag_name }}, {{ $booking->event_type_name }}</div>
                </div>
                <span class="status-badge status-badge--{{ $statusClass }}">{{ $statusName }}</span>
            </div>
            <div class="text-muted" style="font-size:12px;">Order #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</div>
        </div>
    </div>

    <div class="booking-card__grid">
        <div class="booking-card__field">
            <span>Event Date</span>
            <strong>
                @if(!empty($booking['event_date']->event_date))
                    {{ date('d M Y', strtotime($booking['event_date']->event_date)) }}
                    @if(!empty($booking['event_date']->from_time))
                        <br><small class="text-muted">{{ date('g:i A', strtotime($booking['event_date']->from_time)) }}</small>
                    @endif
                @else
                    —
                @endif
            </strong>
        </div>
        <div class="booking-card__field">
            <span>Amount</span>
            <strong>{{ number_format((float) ($booking->payment_amount ?? 0), 2) }} {{ $booking->short_name ?? '' }}</strong>
        </div>
        <div class="booking-card__field">
            <span>Purchased</span>
            <strong>{{ !empty($booking->created_at) ? date('d M Y', strtotime($booking->created_at)) : '—' }}</strong>
        </div>
        <div class="booking-card__field">
            <span>Payment</span>
            <strong>
                @if($booking->is_payment_completed == 1)
                    <span class="text-success">Paid</span>
                @else
                    <span class="text-warning">Pending</span>
                @endif
            </strong>
        </div>
    </div>

    <div class="booking-card__actions">
        @if(isset($booking['tickets']) && $booking['tickets']->count() > 0)
            <a href="{{ route('customer.ticket.details', $booking->id) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-ticket-alt mr-1"></i> Tickets
            </a>
        @endif
        <a href="{{ url('view_invoice', $booking->id) }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-file-invoice mr-1"></i> Invoice
        </a>
        <a href="{{ url('show_booking_details_show', $booking->id) }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-eye mr-1"></i> Details
        </a>
        <a href="{{ url('show_details_show', $booking->event_id) }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-external-link-alt mr-1"></i> Event
        </a>
    </div>
</div>
