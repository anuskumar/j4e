<?php $page = 'events/create'; ?>
@extends('admin.layout.app')

@section('page_title', 'Create Event')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('events/list') }}">Events</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Event</li>
@endsection

@section('admin_content')

<link href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

<style>
    .form-field-label {
        font-weight: 600;
        margin-bottom: 0.35rem;
    }

    .form-field-hint {
        font-size: 12px;
        color: #6c757d;
        margin-top: 0.35rem;
    }

    .input-group-text {
        background: #f8f9fc;
        border-color: #e8ebf3;
        min-width: 42px;
        justify-content: center;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-bg-color, #6259ca);
        box-shadow: 0 0 0 0.2rem rgba(98, 89, 202, 0.15);
    }

    .event-image-upload {
        position: relative;
        display: inline-block;
        width: 100%;
        max-width: 220px;
        margin: 0 auto;
    }

    .event-image-upload .event-preview-img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e8ebf3;
        background: #f8f9fc;
        display: block;
    }

    .event-image-upload .event-image-edit {
        position: absolute;
        bottom: 8px;
        right: 8px;
        width: 32px;
        height: 32px;
        line-height: 32px;
        border-radius: 50%;
        background: #fff;
        border: 1px solid #e8ebf3;
        text-align: center;
        cursor: pointer;
        color: #6c757d;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
        margin: 0;
    }

    .event-image-upload .event-image-edit:hover {
        color: var(--primary-bg-color, #6259ca);
    }

    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--multiple {
        border-color: #e8ebf3 !important;
        min-height: 38px;
    }

    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: var(--primary-bg-color, #6259ca) !important;
    }

    .form-section-spacer {
        margin-bottom: 1.75rem;
    }

    .select2-results__option.create-new-option {
        color: var(--primary-bg-color, #6259ca);
        font-weight: 600;
        border-top: 1px solid #e8ebf3;
    }

    .select2-results__option.create-new-option:before {
        content: '+ ';
    }
</style>

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body text-center">
                <div class="event-image-upload mb-3">
                    <img alt="Event image preview"
                        id="event-image-preview"
                        class="event-preview-img"
                        src="{{ asset('assets/img/events/event-01.jpg') }}"
                        onerror="this.onerror=null;this.src='{{ asset('assets/img/default-event.jpg') }}';">
                    <label for="event_image" class="fas fa-camera event-image-edit mb-0" title="Upload event image"></label>
                </div>
                <h5 class="main-profile-name mb-1" id="preview-event-name">New Event</h5>
                <p class="main-profile-name-text text-muted mb-2">Event Details</p>
                <p class="form-field-hint mb-0" id="event-image-file-name">JPG, PNG or WEBP — recommended 1500×700px</p>
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Event Preview</div>
                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="fe fe-tag"></i>
                        </div>
                        <div class="media-body">
                            <span>Event Type</span>
                            <div id="preview-event-type">Not selected</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="fe fe-map-pin"></i>
                        </div>
                        <div class="media-body">
                            <span>Venue</span>
                            <div id="preview-venue">Not selected</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-info-transparent text-info">
                            <i class="fe fe-calendar"></i>
                        </div>
                        <div class="media-body">
                            <span>Event Dates</span>
                            <div id="preview-dates">Not set yet</div>
                        </div>
                    </div>
                    <div class="media mb-0">
                        <div class="media-icon bg-warning-transparent text-warning">
                            <i class="fe fe-percent"></i>
                        </div>
                        <div class="media-body">
                            <span>Seller Fee</span>
                            <div id="preview-fee">10%</div>
                        </div>
                    </div>
                    <div class="media mb-0 mt-3">
                        <div class="media-icon bg-danger-transparent text-danger">
                            <i class="fe fe-percent"></i>
                        </div>
                        <div class="media-body">
                            <span>Customer Fee</span>
                            <div id="preview-customer-fee">0%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="form-horizontal" action="{{ url('events/store') }}" method="POST" id="event-create-form" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="event_image" id="event_image" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp">

                    <div class="mb-4 main-content-label">Basic Information</div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="event_name">Event Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-calendar"></i></span>
                            <input type="text"
                                class="form-control @error('event_name') is-invalid @enderror"
                                name="event_name"
                                id="event_name"
                                placeholder="Enter event name"
                                value="{{ old('event_name') }}"
                                maxlength="255"
                                required>
                        </div>
                        @error('event_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 form-section-spacer">
                        <div class="col-md-4">
                            <label class="form-field-label" for="event_tag">Event Tag <span class="text-danger">*</span></label>
                            <select name="event_tag" id="event_tag" class="form-control select2-single master-data-select @error('event_tag') is-invalid @enderror" data-create-modal="#quickCreateEventTagModal" required>
                                <option value="">Select event tag</option>
                                @foreach ($eventTags as $val)
                                    <option value="{{ $val->id }}" {{ old('event_tag') == $val->id ? 'selected' : '' }}>
                                        {{ $val->tag_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('event_tag')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-field-label" for="event_type">Event Type <span class="text-danger">*</span></label>
                            <select name="event_type" id="event_type" class="form-control select2-single master-data-select @error('event_type') is-invalid @enderror" data-create-modal="#quickCreateEventTypeModal" required>
                                <option value="">Select event type</option>
                                @foreach ($event_type as $type)
                                    <option value="{{ $type->id }}" {{ old('event_type') == $type->id ? 'selected' : '' }}>
                                        {{ $type->event_type_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('event_type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-field-label" for="venue">Venue <span class="text-danger">*</span></label>
                            <select name="venue" id="venue" class="form-control select2-single master-data-select @error('venue') is-invalid @enderror" data-create-modal="#quickCreateVenueModal" required>
                                <option value="">Select venue</option>
                                @foreach ($venue as $ven)
                                    <option value="{{ $ven->id }}" {{ old('venue') == $ven->id ? 'selected' : '' }}
                                        data-label="{{ $ven->venue_name }} — {{ $ven->location_name }}, {{ $ven->city_name }}">
                                        {{ $ven->venue_name }} [{{ $ven->location_name }}, {{ $ven->city_name }}, {{ $ven->country_name }}]
                                    </option>
                                @endforeach
                            </select>
                            @error('venue')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 form-section-spacer">
                        <div class="col-md-4">
                            <label class="form-field-label" for="ticket_types">Ticket Types</label>
                            <select name="ticket_types[]" id="ticket_types" multiple class="form-control select2-multiple master-data-select" data-create-modal="#quickCreateTicketTypeModal" data-placeholder="Select ticket types">
                                @foreach ($ticketTypes as $ticketType)
                                    <option value="{{ $ticketType->id }}"
                                        {{ (is_array(old('ticket_types')) && in_array($ticketType->id, old('ticket_types'))) ? 'selected' : '' }}>
                                        {{ $ticketType->ticket_type_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-field-label" for="seller_fee_percent">Seller Fee (%) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fe fe-percent"></i></span>
                                <input type="number"
                                    step="0.01"
                                    min="0"
                                    max="100"
                                    class="form-control @error('seller_fee_percent') is-invalid @enderror"
                                    name="seller_fee_percent"
                                    id="seller_fee_percent"
                                    value="{{ old('seller_fee_percent', '10') }}"
                                    required>
                            </div>
                            @error('seller_fee_percent')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-field-label" for="artists">Artists</label>
                            <select name="artists[]" id="artists" multiple class="form-control select2-multiple master-data-select" data-create-modal="#quickCreateArtistModal" data-placeholder="Select artists">
                                @foreach ($artists as $art)
                                    <option value="{{ $art->id }}"
                                        {{ (is_array(old('artists')) && in_array($art->id, old('artists'))) ? 'selected' : '' }}>
                                        {{ $art->artist_name }} [{{ $art->field_name }}]
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-4 main-content-label">Event Schedule</div>

                    <div class="row g-3 form-section-spacer">
                        <div class="col-md-4">
                            <label class="form-field-label" for="event_from_date">Event From Date <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fe fe-calendar"></i></span>
                                <input type="date"
                                    class="form-control @error('event_from_date') is-invalid @enderror"
                                    name="event_from_date"
                                    id="event_from_date"
                                    value="{{ old('event_from_date') }}"
                                    required>
                            </div>
                            @error('event_from_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-field-label" for="event_to_date">Event To Date <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fe fe-calendar"></i></span>
                                <input type="date"
                                    class="form-control @error('event_to_date') is-invalid @enderror"
                                    name="event_to_date"
                                    id="event_to_date"
                                    value="{{ old('event_to_date') }}"
                                    required>
                            </div>
                            @error('event_to_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-field-label d-block">Event Status <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center justify-content-between border rounded px-3" style="min-height: 38px;">
                                <span class="tx-13 fw-semibold">Active</span>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="event_is_active_switch"
                                        {{ old('event_is_active', '1') == '1' ? 'checked' : '' }}>
                                    <input type="hidden" name="event_is_active" id="event_is_active" value="{{ old('event_is_active', '1') }}">
                                </div>
                            </div>
                            @error('event_is_active')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 form-section-spacer">
                        <div class="col-md-4">
                            <label class="form-field-label" for="event_start_time">Event Start Time <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fe fe-clock"></i></span>
                                <input type="time"
                                    class="form-control @error('event_start_time') is-invalid @enderror"
                                    name="event_start_time"
                                    id="event_start_time"
                                    value="{{ old('event_start_time') }}"
                                    required>
                            </div>
                            @error('event_start_time')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-field-label" for="event_end_time">Event End Time <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fe fe-clock"></i></span>
                                <input type="time"
                                    class="form-control @error('event_end_time') is-invalid @enderror"
                                    name="event_end_time"
                                    id="event_end_time"
                                    value="{{ old('event_end_time') }}"
                                    required>
                            </div>
                            @error('event_end_time')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-field-label" for="customer_fee_percent">Customer Fee (%) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fe fe-percent"></i></span>
                                <input type="number"
                                    step="0.01"
                                    min="0"
                                    max="100"
                                    class="form-control @error('customer_fee_percent') is-invalid @enderror"
                                    name="customer_fee_percent"
                                    id="customer_fee_percent"
                                    value="{{ old('customer_fee_percent', '0') }}"
                                    required>
                            </div>
                            @error('customer_fee_percent')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4 main-content-label">Additional Details</div>

                    <div class="form-group mb-0">
                        <label class="form-field-label" for="event_desc">Event Description</label>
                        <div class="input-group">
                            <span class="input-group-text align-items-start pt-2"><i class="fe fe-file-text"></i></span>
                            <textarea class="form-control @error('event_desc') is-invalid @enderror"
                                name="event_desc"
                                id="event_desc"
                                rows="4"
                                placeholder="Enter event description">{{ old('event_desc') }}</textarea>
                        </div>
                        @error('event_desc')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url('events/list') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="event-create-form" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-save me-1"></i> Create Event
                </button>
            </div>
        </div>
    </div>
</div>

@include('admin.events.partials.master_data_modals')

@endsection

@push('scripts')
<script src="{{ asset('admin_assets/plugins/select2/js/select2.min.js') }}"></script>
<script>
jQuery(document).ready(function ($) {
    const defaultImage = @json(asset('assets/img/events/event-01.jpg'));
    const fallbackImage = @json(asset('assets/img/default-event.jpg'));
    const csrfToken = @json(csrf_token());
    const CREATE_VALUE = '__create_new__';
    const quickCreateUrls = {
        event_tag: @json(url('events/quick-create/event-tag')),
        event_type: @json(url('events/quick-create/event-type')),
        venue: @json(url('events/quick-create/venue')),
        ticket_types: @json(url('events/quick-create/ticket-type')),
        artists: @json(url('events/quick-create/artist')),
    };

    function appendCreateOption($select, label) {
        if ($select.find('option[value="' + CREATE_VALUE + '"]').length) {
            return;
        }

        $select.append(new Option(label || 'Create new...', CREATE_VALUE, false, false));
    }

    appendCreateOption($('#event_tag'), 'Create new event tag...');
    appendCreateOption($('#event_type'), 'Create new event type...');
    appendCreateOption($('#venue'), 'Create new venue...');
    appendCreateOption($('#ticket_types'), 'Create new ticket type...');
    appendCreateOption($('#artists'), 'Create new artist...');

    function formatCreateOption(option) {
        if (!option.id || option.id !== CREATE_VALUE) {
            return option.text;
        }

        return $('<span class="create-new-option-text">' + option.text + '</span>');
    }

    $('.select2-single').select2({
        width: '100%',
        allowClear: true,
        placeholder: 'Select an option',
        templateResult: formatCreateOption
    });

    $('.select2-multiple').each(function () {
        $(this).select2({
            width: '100%',
            placeholder: $(this).data('placeholder') || 'Select options',
            allowClear: true,
            closeOnSelect: false,
            templateResult: formatCreateOption
        });
    });

    function openQuickCreateModal(modalSelector) {
        const modalEl = document.querySelector(modalSelector);
        if (!modalEl) {
            return;
        }

        const $modal = $(modalSelector);
        $modal.find('form')[0].reset();
        $modal.find('.invalid-feedback').text('');
        $modal.find('.is-invalid').removeClass('is-invalid');

        $('.master-data-select').select2('close');

        const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
        modalInstance.show();
    }

    function closeQuickCreateModal(modalEl) {
        const instance = bootstrap.Modal.getInstance(modalEl);
        if (instance) {
            instance.hide();
        }
    }

    $('.master-data-select').on('select2:select', function (event) {
        if (event.params.data.id !== CREATE_VALUE) {
            return;
        }

        const modalSelector = $(this).data('createModal');
        const previousValue = $(this).data('previousValue');
        const isMultiple = $(this).prop('multiple');

        if (isMultiple) {
            const currentValues = ($(this).val() || []).filter(function (value) {
                return value !== CREATE_VALUE;
            });
            $(this).val(currentValues).trigger('change');
        } else {
            $(this).val(previousValue || null).trigger('change');
        }

        if (modalSelector) {
            openQuickCreateModal(modalSelector);
        }
    }).on('select2:opening', function () {
        if (!$(this).prop('multiple')) {
            $(this).data('previousValue', $(this).val());
        }
    }).on('select2:open', function () {
        setTimeout(function () {
            $('.select2-results__option[id$="-' + CREATE_VALUE + '"]').addClass('create-new-option');
        }, 0);
    });

    function clearFormErrors($form) {
        $form.find('.invalid-feedback').text('');
        $form.find('.is-invalid').removeClass('is-invalid');
    }

    function showFormErrors($form, errors) {
        $.each(errors, function (field, messages) {
            const $input = $form.find('[name="' + field + '"]');
            const $error = $form.find('#' + $input.attr('id') + '_error');

            $input.addClass('is-invalid');
            if ($error.length) {
                $error.text(messages[0]);
            }
        });
    }

    function insertSelectOption($select, item, selectValue) {
        const isMultiple = $select.prop('multiple');
        const $option = $('<option></option>').val(item.id).text(item.text);

        if (item.label) {
            $option.attr('data-label', item.label);
        }

        $select.find('option[value="' + CREATE_VALUE + '"]').before($option);

        if (selectValue) {
            if (isMultiple) {
                const currentValues = $select.val() || [];
                if (currentValues.indexOf(String(item.id)) === -1) {
                    currentValues.push(String(item.id));
                }
                $select.val(currentValues);
            } else {
                $select.val(String(item.id));
            }

            $select.trigger('change');
        }
    }

    function submitQuickCreate($form, url, $select, options) {
        options = options || {};
        const $submit = $form.find('[type="submit"]');
        const formData = new FormData($form[0]);

        clearFormErrors($form);
        $submit.prop('disabled', true);

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        }).done(function (response) {
            if (!response.success) {
                return;
            }

            insertSelectOption($select, response.data, options.selectValue !== false);

            if (options.onSuccess) {
                options.onSuccess(response.data);
            }

            closeQuickCreateModal($form.closest('.modal')[0]);

            if (typeof toastr !== 'undefined') {
                toastr.success(response.message);
            }
        }).fail(function (xhr) {
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                showFormErrors($form, xhr.responseJSON.errors);
                return;
            }

            const message = (xhr.responseJSON && xhr.responseJSON.message)
                ? xhr.responseJSON.message
                : 'Unable to save. Please try again.';

            if (typeof toastr !== 'undefined') {
                toastr.error(message);
            } else {
                alert(message);
            }
        }).always(function () {
            $submit.prop('disabled', false);
        });
    }

    $('#quick-create-event-tag-form').on('submit', function (event) {
        event.preventDefault();
        submitQuickCreate($(this), quickCreateUrls.event_tag, $('#event_tag'));
    });

    $('#quick-create-event-type-form').on('submit', function (event) {
        event.preventDefault();
        submitQuickCreate($(this), quickCreateUrls.event_type, $('#event_type'), {
            onSuccess: function () {
                updatePreview();
            }
        });
    });

    $('#quick-create-venue-form').on('submit', function (event) {
        event.preventDefault();
        submitQuickCreate($(this), quickCreateUrls.venue, $('#venue'), {
            onSuccess: function () {
                updatePreview();
            }
        });
    });

    $('#quick-create-ticket-type-form').on('submit', function (event) {
        event.preventDefault();
        submitQuickCreate($(this), quickCreateUrls.ticket_types, $('#ticket_types'));
    });

    $('#quick-create-artist-form').on('submit', function (event) {
        event.preventDefault();
        submitQuickCreate($(this), quickCreateUrls.artists, $('#artists'));
    });

    function formatDate(value) {
        if (!value) return '';
        const date = new Date(value + 'T00:00:00');
        return date.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
    }

    function updatePreview() {
        const name = $('#event_name').val().trim();
        const eventType = $('#event_type option:selected').text().trim();
        const venueOption = $('#venue option:selected');
        const venueLabel = venueOption.data('label') || venueOption.text().trim();
        const fromDate = $('#event_from_date').val();
        const toDate = $('#event_to_date').val();
        const startTime = $('#event_start_time').val();
        const endTime = $('#event_end_time').val();
        const fee = $('#seller_fee_percent').val();
        const customerFee = $('#customer_fee_percent').val();

        $('#preview-event-name').text(name || 'New Event');
        $('#preview-event-type').text(eventType && eventType !== 'Select event type' && eventType.indexOf('Create new') !== 0 ? eventType : 'Not selected');
        $('#preview-venue').text(venueLabel && venueLabel !== 'Select venue' && venueLabel.indexOf('Create new') !== 0 ? venueLabel : 'Not selected');

        let datePreview = 'Not set yet';
        if (fromDate && toDate) {
            datePreview = formatDate(fromDate) + ' — ' + formatDate(toDate);
        } else if (fromDate) {
            datePreview = 'From ' + formatDate(fromDate);
        }
        if (startTime && endTime) {
            datePreview += (datePreview !== 'Not set yet' ? ' · ' : '') + startTime + ' — ' + endTime;
        } else if (startTime) {
            datePreview += (datePreview !== 'Not set yet' ? ' · ' : '') + 'From ' + startTime;
        }
        $('#preview-dates').text(datePreview);

        $('#preview-fee').text(fee ? fee + '%' : '10%');
        $('#preview-customer-fee').text(customerFee !== '' ? customerFee + '%' : '0%');
    }

    function handleImageFile(file) {
        if (!file || !file.type.startsWith('image/')) return;

        if (file.size > 4 * 1024 * 1024) {
            alert('Event image must not exceed 4MB.');
            $('#event_image').val('');
            $('#event-image-preview').attr('src', defaultImage);
            $('#event-image-file-name').text('JPG, PNG or WEBP — recommended 1500×700px');
            return;
        }

        $('#event-image-file-name').text(file.name);
        const reader = new FileReader();
        reader.onload = function (event) {
            $('#event-image-preview').attr('src', event.target.result);
        };
        reader.readAsDataURL(file);
    }

    $('#event_image').on('change', function () {
        handleImageFile(this.files[0]);
    });

    $('#event-image-preview').on('error', function () {
        if (this.src !== fallbackImage) {
            this.src = fallbackImage;
        }
    });

    $('#event_is_active_switch').on('change', function () {
        $('#event_is_active').val(this.checked ? '1' : '0');
    });

    $('#event-create-form').on('submit', function () {
        $('.master-data-select').each(function () {
            if ($(this).prop('multiple')) {
                const values = ($(this).val() || []).filter(function (value) {
                    return value !== CREATE_VALUE;
                });
                $(this).val(values);
            } else if ($(this).val() === CREATE_VALUE) {
                $(this).val('');
            }
        });
    });

    $('#event_name, #event_from_date, #event_to_date, #event_start_time, #event_end_time, #seller_fee_percent, #customer_fee_percent').on('input change', updatePreview);
    $('#event_type, #venue').on('change', updatePreview);
    updatePreview();
});
</script>
@endpush
