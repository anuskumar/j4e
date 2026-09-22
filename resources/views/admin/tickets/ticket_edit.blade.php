<?php $page = 'tickets/edit'; ?>
@extends('admin.layout.app')
@section('admin_content')

@php
    $amountWhole = (int) floor((float) ($data->ticket_amount ?? 0));
    $amountCents = (int) round((((float) ($data->ticket_amount ?? 0)) - $amountWhole) * 100);
@endphp

<div class="row row-sm">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-body">
                <div class="mb-4 main-content-label">Edit Ticket Listing</div>
                <form class="form-horizontal" action="{{ url('tickets/store_ticket') }}" method="POST" enctype="multipart/form-data" id="edit-ticket-form">
                    @csrf
                    <input type="hidden" name="event_id" id="event-id" value="{{ $data ? $data->id : '' }}">
                    <input type="hidden" name="event" value="{{ $data ? $data->event : '' }}">
                    <input type="hidden" name="features_submitted" value="1">

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Ticket Name</label></div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="ticket_name" value="{{ $data->ticket_name ?? '' }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Ticket Type</label></div>
                            <div class="col-md-6">
                                <select class="form-control" name="ticket_type" id="edit-ticket-type" required>
                                    <option value="">Select</option>
                                    @foreach ($ticket_type as $val)
                                        @php
                                            $isMobileType = (int) $val->id === 4
                                                || (
                                                    stripos($val->ticket_type_name, 'mobile') !== false
                                                    && stripos($val->ticket_type_name, 'transfer') !== false
                                                );
                                        @endphp
                                        <option value="{{ $val->id }}" data-mobile="{{ $isMobileType ? 1 : 0 }}" {{ (int) $val->id === (int) $data->ticket_type ? 'selected' : '' }}>
                                            {{ $val->ticket_type_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group d-none" id="edit-mobile-app-wrapper">
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Mobile Application</label></div>
                            <div class="col-md-6">
                                <select class="form-control" name="mobile_app" id="edit-mobile-app-select">
                                    <option value="">Select an application</option>
                                    @foreach ($mobile_applications as $app)
                                        <option value="{{ $app->id }}" {{ (int) $app->id === (int) ($data->mobile_application_id ?? 0) ? 'selected' : '' }}>{{ $app->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Event Timing</label></div>
                            <div class="col-md-6">
                                <select class="form-control" id="event-timing" onchange="reload_value()" name="event_timing" required>
                                    <option value="">Select</option>
                                    @foreach ($event_timing as $val)
                                        <option value="{{ $val->id }}" {{ (int) $val->id === (int) $data->event_timing ? 'selected' : '' }}>
                                            {{ 'Date:' . date('d-m-Y', strtotime($val->event_date)) . '  Time [' . date('H:i A', strtotime($val->from_time)) . ' To ' . date('H:i A', strtotime($val->to_time)) . ']' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Seating</label></div>
                            <div class="col-md-6">
                                <select class="form-control" name="venue_seating" id="seating-select" onchange="get_available_tickets(this.value)" required>
                                    <option value="">Select</option>
                                    @foreach ($venue_seatings as $val)
                                        <option value="{{ $val->id }}" {{ (int) $val->id === (int) $data->venue_seating ? 'selected' : '' }}>
                                            {{ $val->seating_type_name }}
                                            @if (!empty($val->number_of_seats))
                                                [{{ $val->number_of_seats }} seats]
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Number Of Tickets</label></div>
                            <div class="col-md-6">
                                <input type="number" class="form-control" id="no-of-tickets" name="no_of_tickets" min="1" value="{{ $data->no_of_tickets ?? '' }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2"><label class="form-label">Row</label></div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="row" id="seat-row" value="{{ $data->row ?? '' }}" placeholder="e.g. A">
                            </div>
                            <div class="col-md-2"><label class="form-label">Seat From</label></div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" name="seat_from" id="seat-from" value="{{ $data->seat_from ?? '' }}">
                            </div>
                            <div class="col-md-2"><label class="form-label">Seat To</label></div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" name="seat_to" id="seat-to" value="{{ $data->seat_to ?? '' }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Sell Together</label></div>
                            <div class="col-md-6">
                                @foreach ($splittypes as $split)
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio" name="sell_together" id="edit_sell_{{ $split->id }}" value="{{ $split->id }}"
                                            {{ (int) $split->id === (int) ($data->split_type ?? 0) ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="edit_sell_{{ $split->id }}">{{ $split->split_name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Currency</label></div>
                            <div class="col-md-6">
                                <select class="form-control" name="amount_currency" required>
                                    <option value="">Select</option>
                                    @foreach ($currency as $val)
                                        @php $isCurrencyActive = (int) $val->is_active === 1; @endphp
                                        <option value="{{ $val->id }}" @disabled(! $isCurrencyActive) {{ (int) $val->id === (int) $data->amount_currency ? 'selected' : '' }}>
                                            {{ $val->name }} [{{ $val->short_name }}]
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Ticket Amount</label></div>
                            <div class="col-md-3">
                                <input type="number" step="1" min="0" class="form-control" name="ticket_amount" value="{{ $amountWhole }}" required>
                            </div>
                            <div class="col-md-1"><label class="form-label">Cents</label></div>
                            <div class="col-md-2">
                                <input type="number" min="0" max="99" class="form-control" name="cents" value="{{ $amountCents }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Face Value</label></div>
                            <div class="col-md-6">
                                <input type="number" step="0.01" min="0" class="form-control" name="face_value" value="{{ $data->face_value ?? '' }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Restrictions</label></div>
                            <div class="col-md-6">
                                @php
                                    $selectedRestrictions = json_decode($data->ticket_restrictions ?? '[]', true) ?: [];
                                @endphp
                                <select class="form-control select2-select" style="width:100%;" multiple name="ticket_restrictions[]">
                                    @foreach ($restrictions as $val)
                                        <option value="{{ $val->id }}" {{ in_array($val->id, $selectedRestrictions) ? 'selected' : '' }}>{{ $val->restrictions }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Ticket Features</label></div>
                            <div class="col-md-6">
                                @foreach ([
                                    'clearView' => 'Clear view',
                                    'limitedView' => 'Limited or restricted view',
                                    'vipPass' => 'Includes VIP pass',
                                    'mealPackage' => 'Ticket and meal package',
                                    'parking' => 'Includes parking',
                                    'standingOnly' => 'Standing Only',
                                    'aisleSeat' => 'Aisle seat',
                                ] as $featureKey => $featureLabel)
                                    <div class="form-check mb-1">
                                        <input type="checkbox" class="form-check-input{{ in_array($featureKey, ['clearView', 'limitedView'], true) ? ' view-feature-checkbox' : '' }}" id="edit_{{ $featureKey }}" name="{{ $featureKey }}" {{ in_array($featureKey, $selectedFeatures) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edit_{{ $featureKey }}">{{ $featureLabel }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Booking expiry Date & time</label></div>
                            <div class="col-md-6">
                                <input type="datetime-local" required class="form-control" name="booking_expiry_date_time" value="{{ $data->booking_expiry_date_time ? date('Y-m-d\TH:i', strtotime($data->booking_expiry_date_time)) : '' }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Disclaimer Notes</label></div>
                            <div class="col-md-6">
                                <textarea class="form-control" name="disclaimer_note">{{ $data->disclaimer_note ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Cancellation Policy Notes</label></div>
                            <div class="col-md-6">
                                <textarea class="form-control" name="cancellation_policy_notes">{{ $data->cancellation_policy_notes ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <div class="row">
                            <div class="col-md-3"><label class="form-label">Upload Ticket</label></div>
                            <div class="col-md-6">
                                <input type="file" name="ticket_upload" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer mt-3">
                        <a href="{{ url('tickets/manage_tickets/' . $data->event) }}" class="btn btn-secondary" style="float: right; margin-left:10px;">Back</a>
                        <button type="submit" class="btn btn-primary" style="float:right;">Update Ticket</button>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
jQuery(document).ready(function ($) {
    if ($('.select2-select').length) {
        $('.select2-select').select2({ width: '100%', placeholder: 'Select restrictions' });
    }

    const toggleMobileApp = () => {
        const selected = $('#edit-ticket-type option:selected');
        const isMobile = selected.data('mobile') == 1;
        const $wrapper = $('#edit-mobile-app-wrapper');
        const $select = $('#edit-mobile-app-select');
        if (isMobile) {
            $wrapper.removeClass('d-none');
            $select.prop('required', true);
        } else {
            $wrapper.addClass('d-none');
            $select.prop('required', false);
        }
    };

    const syncSeatTo = () => {
        const count = parseInt($('#no-of-tickets').val(), 10);
        const from = parseInt($('#seat-from').val(), 10);
        if (!Number.isNaN(count) && count > 0 && !Number.isNaN(from)) {
            $('#seat-to').val(from + count - 1);
        }
    };

    $('#edit-ticket-type').on('change', toggleMobileApp);
    $('#no-of-tickets, #seat-from').on('input change', syncSeatTo);
    toggleMobileApp();

    $(document).on('change', '.view-feature-checkbox', function () {
        if (!this.checked) {
            return;
        }
        $('.view-feature-checkbox').not(this).prop('checked', false);
    });
});

function get_available_tickets(val) {
    var seating = val;
    var timing = $('#event-timing').val();
    var event = $('input[name="event"]').val();

    if (!timing) {
        toastr.error('Select one timing first.');
        return;
    }

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('tickets/check_availability') }}",
        data: { seating: seating, timing: timing, event: event },
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.status === true) {
                toastr.success(data.message);
                $('#no-of-tickets').val(data.seats).attr({ max: data.seats, min: 1 });
            } else {
                toastr.error(data.message);
            }
        }
    });
}

const reload_value = () => {
    $('#seating-select').val('');
};
</script>
@endpush
