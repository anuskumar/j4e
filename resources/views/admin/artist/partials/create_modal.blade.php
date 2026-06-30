<div class="modal fade" id="quickCreateArtistModal" tabindex="-1" aria-labelledby="quickCreateArtistModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="quickCreateArtistModalLabel">Create Artist</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quick-create-artist-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-field-label" for="quick_artist_name">Artist Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="quick_artist_name" name="artist_name" maxlength="255" required placeholder="Enter artist name">
                        <div class="invalid-feedback d-block" id="quick_artist_name_error"></div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-field-label" for="quick_artist_field">Artist Field <span class="text-danger">*</span></label>
                        <select class="form-control" id="quick_artist_field" name="field" required>
                            <option value="">Select artist field</option>
                            @foreach ($artistFields as $field)
                                <option value="{{ $field->id }}">{{ $field->field_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback d-block" id="quick_artist_field_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="quick-create-artist-submit">
                        <i class="fe fe-save me-1"></i> Create Artist
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
