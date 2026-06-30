<?php $page = 'admin/artist/create'; ?>
@extends('admin.layout.app')

@section('page_title', 'Create Artist')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('admin/artist/list') }}">Artists</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Artist</li>
@endsection

@section('admin_content')

@include('admin.partials.user_form_styles')

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body text-center">
                <div class="preview-icon-wrap mb-3">
                    <div class="preview-icon bg-primary-transparent text-primary mx-auto">
                        <i class="fe fe-music"></i>
                    </div>
                </div>
                <h5 class="main-profile-name mb-1" id="preview-artist-name">New Artist</h5>
                <p class="main-profile-name-text text-muted mb-2">Artist</p>
                <span class="badge bg-primary-transparent" id="preview-field-badge">No field selected</span>
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Artist Preview</div>
                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="fe fe-user"></i>
                        </div>
                        <div class="media-body">
                            <span>Artist Name</span>
                            <div id="preview-name">Not set yet</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="fe fe-layers"></i>
                        </div>
                        <div class="media-body">
                            <span>Artist Field</span>
                            <div id="preview-field">Not selected</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-info-transparent text-info">
                            <i class="fe fe-phone"></i>
                        </div>
                        <div class="media-body">
                            <span>Contact Number</span>
                            <div id="preview-contact">Not set yet</div>
                        </div>
                    </div>
                    <div class="media mb-0">
                        <div class="media-icon bg-warning-transparent text-warning">
                            <i class="fe fe-file-text"></i>
                        </div>
                        <div class="media-body">
                            <span>About</span>
                            <div id="preview-about">Not set yet</div>
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

                <form class="form-horizontal" action="{{ url('admin/artist/store') }}" method="POST" id="artist-create-form">
                    @csrf

                    <div class="mb-4 main-content-label">Basic Information</div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="artist_name">Artist Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-user"></i></span>
                            <input type="text"
                                class="form-control @error('artist_name') is-invalid @enderror"
                                name="artist_name"
                                id="artist_name"
                                placeholder="Enter artist name"
                                value="{{ old('artist_name') }}"
                                maxlength="255"
                                required>
                        </div>
                        @error('artist_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="field">Artist Field <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-layers"></i></span>
                            <select name="field" id="field" class="form-control form-select @error('field') is-invalid @enderror" required>
                                <option value="">Select artist field</option>
                                @foreach ($artist_create as $type)
                                    <option value="{{ $type->id }}" {{ old('field') == $type->id ? 'selected' : '' }}>
                                        {{ $type->field_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('field')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="contact_number">Contact Number</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-phone"></i></span>
                            <input type="tel"
                                class="form-control @error('contact_number') is-invalid @enderror"
                                name="contact_number"
                                id="contact_number"
                                placeholder="Enter contact number"
                                value="{{ old('contact_number') }}"
                                maxlength="20">
                        </div>
                        @error('contact_number')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-field-label" for="about">About</label>
                        <textarea class="form-control @error('about') is-invalid @enderror"
                            name="about"
                            id="about"
                            rows="4"
                            placeholder="Short description about the artist"
                            maxlength="1000">{{ old('about') }}</textarea>
                        @error('about')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url('admin/artist/list') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="artist-create-form" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-save me-1"></i> Create Artist
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
jQuery(document).ready(function ($) {
    function truncateText(text, limit) {
        if (!text) {
            return 'Not set yet';
        }

        return text.length > limit ? text.substring(0, limit) + '...' : text;
    }

    function updatePreview() {
        const name = $('#artist_name').val().trim();
        const fieldText = $('#field option:selected').text().trim();
        const hasField = $('#field').val();
        const contact = $('#contact_number').val().trim();
        const about = $('#about').val().trim();

        $('#preview-artist-name').text(name || 'New Artist');
        $('#preview-name').text(name || 'Not set yet');
        $('#preview-field').text(hasField ? fieldText : 'Not selected');
        $('#preview-contact').text(contact || 'Not set yet');
        $('#preview-about').text(truncateText(about, 80));
        $('#preview-field-badge').text(hasField ? fieldText : 'No field selected');
    }

    $('#artist_name, #contact_number, #about').on('input', updatePreview);
    $('#field').on('change', updatePreview);
    updatePreview();
});
</script>
@endpush
