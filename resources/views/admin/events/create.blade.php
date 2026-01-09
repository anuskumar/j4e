<?php $page="events/create";?>
@extends('admin.layout.app')
@section('admin_content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* Select2 Custom Styling */
    .select2-container {
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single {
        height: 38px !important;
        border: 1px solid #ced4da !important;
        border-radius: 4px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px !important;
        padding-left: 12px !important;
    }
    .select2-container--default .select2-selection--multiple {
        min-height: 38px !important;
        border: 1px solid #ced4da !important;
        border-radius: 4px !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        padding: 2px 8px !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #007bff !important;
        color: white !important;
        border: none !important;
        padding: 4px 8px !important;
        border-radius: 3px !important;
        margin: 2px !important;
        display: inline-block !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: white !important;
        margin-right: 5px !important;
        cursor: pointer !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #ffcccc !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
        right: 8px !important;
    }
    
    /* Form Section Styling */
    .event-form-section {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-left: 4px solid #007bff;
        padding: 20px;
        border-radius: 4px;
        margin-bottom: 20px;
    }
    .event-form-section-title {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e0e0e0;
    }
    .event-form-section-title i {
        color: #007bff;
        margin-right: 8px;
    }
    
    /* Form Label */
    .event-form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 5px;
        display: block;
    }
    .event-form-label.required::after {
        content: " *";
        color: #dc3545;
    }
    
    /* Card Header */
    .card-header-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 20px;
    }
    .card-header-custom h3 {
        margin: 0;
        color: white;
        font-weight: 600;
    }
    
    /* Button Styling */
    .btn-create {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 10px 25px;
        border-radius: 4px;
        font-weight: 500;
    }
    .btn-create:hover {
        background: linear-gradient(135deg, #5568d3 0%, #653a8f 100%);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
    }
</style>

<!-- row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header card-header-custom">
                <h3 class="card-title mb-0">
                    <i class="fe fe-plus-circle"></i> Create New Event
                </h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ url('events/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="event-form-section">
                        <div class="event-form-section-title">
                            <i class="fe fe-info"></i> Basic Information
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="event-form-label required">Event Name</label>
                            <input type="text" required class="form-control" name="event_name" 
                                   placeholder="Enter event name" value="{{ old('event_name') }}">
                            @error('event_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="event-form-label required">Event Tag</label>
                                    <select name="event_tag" class="form-control select2-single" required>
                                        <option value="">Select Event Tag</option>
                                        @foreach($eventTags as $val)
                                            <option value="{{ $val->id }}" {{ old('event_tag') == $val->id ? 'selected' : '' }}>
                                                {{ $val->tag_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('event_tag')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="event-form-label required">Event Type</label>
                                    <select name="event_type" class="form-control select2-single" required>
                                        <option value="">Select Event Type</option>
                                        @foreach($event_type as $type)
                                            <option value="{{ $type->id }}" {{ old('event_type') == $type->id ? 'selected' : '' }}>
                                                {{ $type->event_type_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('event_type')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="event-form-label">Ticket Types</label>
                                    <select name="ticket_types[]" id="ticket_types" multiple class="form-control select2-multiple" 
                                            data-placeholder="Select ticket types (optional)">
                                        @foreach($ticketTypes as $ticketType)
                                            <option value="{{ $ticketType->id }}" 
                                                {{ (is_array(old('ticket_types')) && in_array($ticketType->id, old('ticket_types'))) ? 'selected' : '' }}>
                                                {{ $ticketType->ticket_type_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">You can select multiple</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Venue & Location -->
                    <div class="event-form-section">
                        <div class="event-form-section-title">
                            <i class="fe fe-map-pin"></i> Venue & Location
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="event-form-label required">Venue</label>
                            <select name="venue" class="form-control select2-single" required>
                                <option value="">Select Venue</option>
                                @foreach($venue as $ven)
                                    <option value="{{ $ven->id }}" {{ old('venue') == $ven->id ? 'selected' : '' }}>
                                        {{ $ven->venue_name }} [ {{ $ven->location_name }}, {{ $ven->city_name }}, {{ $ven->country_name }} ]
                                    </option>
                                @endforeach
                            </select>
                            @error('venue')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Event Dates -->
                    <div class="event-form-section">
                        <div class="event-form-section-title">
                            <i class="fe fe-calendar"></i> Event Dates
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="event-form-label required">Event From Date</label>
                                    <input type="date" class="form-control" required name="event_from_date" 
                                           value="{{ old('event_from_date') }}">
                                    @error('event_from_date')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="event-form-label required">Event To Date</label>
                                    <input type="date" class="form-control" required name="event_to_date" 
                                           value="{{ old('event_to_date') }}">
                                    @error('event_to_date')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="event-form-section">
                        <div class="event-form-section-title">
                            <i class="fe fe-file-text"></i> Additional Information
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="event-form-label">Artists</label>
                            <select name="artists[]" id="artists" multiple class="form-control select2-multiple" 
                                    data-placeholder="Select artists (optional)">
                                @foreach($artists as $art)
                                    <option value="{{ $art->id }}" 
                                        {{ (is_array(old('artists')) && in_array($art->id, old('artists'))) ? 'selected' : '' }}>
                                        {{ $art->artist_name }} [ {{ $art->field_name }} ]
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">You can select multiple artists</small>
                        </div>

                        <div class="form-group mb-3">
                            <label class="event-form-label">Event Description</label>
                            <textarea class="form-control" name="event_desc" rows="4" 
                                      placeholder="Enter event description">{{ old('event_desc') }}</textarea>
                            @error('event_desc')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Media & Status -->
                    <div class="event-form-section">
                        <div class="event-form-section-title">
                            <i class="fe fe-image"></i> Media & Status
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="event-form-label">Event Image</label>
                            <input type="file" name="event_image" class="form-control" accept="image/*">
                            <small class="form-text text-muted">Recommended size: 1500px × 700px</small>
                            @error('event_image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="event-form-label required">Event Status</label>
                            <div class="mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="event_is_active" 
                                           id="status_active" value="1" {{ old('event_is_active', '1') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_active">
                                        <span class="badge bg-success">Active</span>
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="event_is_active" 
                                           id="status_inactive" value="0" {{ old('event_is_active') == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_inactive">
                                        <span class="badge bg-secondary">Inactive</span>
                                    </label>
                                </div>
                            </div>
                            @error('event_is_active')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="{{ url('events/list') }}" class="btn btn-secondary">
                            <i class="fe fe-x"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-create">
                            <i class="fe fe-save"></i> Create Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script>
    (function() {
        function initSelect2() {
            // Check if jQuery and Select2 are available
            if (typeof jQuery === 'undefined' || typeof jQuery.fn.select2 === 'undefined') {
                setTimeout(initSelect2, 100);
                return;
            }

            var $ = jQuery;

            // Destroy any existing Select2 instances to avoid conflicts
            $('.select2-single, .select2-multiple').each(function() {
                if ($(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2('destroy');
                }
            });

            // Initialize single select dropdowns
            $('.select2-single').each(function() {
                $(this).select2({
                    width: '100%',
                    allowClear: true,
                    placeholder: 'Select an option'
                });
            });

            // Initialize multiple select dropdowns
            $('.select2-multiple').each(function() {
                var placeholder = $(this).data('placeholder') || 'Select options';
                $(this).select2({
                    width: '100%',
                    placeholder: placeholder,
                    allowClear: true,
                    closeOnSelect: false
                });
            });
        }

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(initSelect2, 500);
            });
        } else {
            setTimeout(initSelect2, 500);
        }

        // Fallback: also try on window load
        window.addEventListener('load', function() {
            setTimeout(initSelect2, 300);
        });
    })();
</script>

@endsection
