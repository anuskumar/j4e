<div class="modal fade" id="quickCreateCityModal" tabindex="-1" aria-labelledby="quickCreateCityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="quickCreateCityModalLabel">Create City</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quick-create-city-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-field-label">Country</label>
                        <input type="text" class="form-control" id="quick_city_country_name" readonly>
                        <input type="hidden" name="country_id" id="quick_city_country_id">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-field-label" for="quick_city_name">City Name <span class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control"
                            id="quick_city_name"
                            name="name"
                            maxlength="255"
                            required
                            placeholder="Enter city name"
                            autocomplete="off">
                        <div class="invalid-feedback d-block" id="quick_city_name_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="quick-create-city-submit">
                        <i class="fe fe-save me-1"></i> Create City
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
