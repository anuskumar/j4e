{{-- Quick-create modals for event master data --}}

<div class="modal fade" id="quickCreateEventTagModal" tabindex="-1" aria-labelledby="quickCreateEventTagModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="quickCreateEventTagModalLabel">Create Event Tag</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quick-create-event-tag-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-field-label" for="quick_tag_name">Tag Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="quick_tag_name" name="tag_name" maxlength="255" required placeholder="Enter tag name">
                        <div class="invalid-feedback d-block" id="quick_tag_name_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="quick-create-event-tag-submit">
                        <i class="fe fe-save me-1"></i> Create Tag
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="quickCreateEventTypeModal" tabindex="-1" aria-labelledby="quickCreateEventTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="quickCreateEventTypeModalLabel">Create Event Type</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quick-create-event-type-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-field-label" for="quick_event_type_name">Event Type Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="quick_event_type_name" name="name" maxlength="255" required placeholder="Enter event type name">
                        <div class="invalid-feedback d-block" id="quick_event_type_name_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="quick-create-event-type-submit">
                        <i class="fe fe-save me-1"></i> Create Event Type
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="quickCreateVenueModal" tabindex="-1" aria-labelledby="quickCreateVenueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="quickCreateVenueModalLabel">Create Venue</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quick-create-venue-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-field-label" for="quick_venue_name">Venue Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="quick_venue_name" name="name" maxlength="255" required placeholder="Enter venue name">
                        <div class="invalid-feedback d-block" id="quick_venue_name_error"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-field-label" for="quick_venue_type">Venue Type <span class="text-danger">*</span></label>
                        <select class="form-control" id="quick_venue_type" name="venue_type" required>
                            <option value="">Select venue type</option>
                            @foreach ($venueTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->venue_type_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback d-block" id="quick_venue_type_error"></div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-field-label" for="quick_venue_location">Location <span class="text-danger">*</span></label>
                        <select class="form-control" id="quick_venue_location" name="location" required>
                            <option value="">Select location</option>
                            @foreach ($locations as $loc)
                                <option value="{{ $loc->id }}">{{ $loc->location_name }}, {{ $loc->city_name }}, {{ $loc->country_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback d-block" id="quick_venue_location_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="quick-create-venue-submit">
                        <i class="fe fe-save me-1"></i> Create Venue
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="quickCreateTicketTypeModal" tabindex="-1" aria-labelledby="quickCreateTicketTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="quickCreateTicketTypeModalLabel">Create Ticket Type</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quick-create-ticket-type-form">
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label class="form-field-label" for="quick_ticket_type_name">Ticket Type Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="quick_ticket_type_name" name="name" maxlength="255" required placeholder="Enter ticket type name">
                        <div class="invalid-feedback d-block" id="quick_ticket_type_name_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="quick-create-ticket-type-submit">
                        <i class="fe fe-save me-1"></i> Create Ticket Type
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.artist.partials.create_modal')
