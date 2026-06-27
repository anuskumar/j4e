<?php $page = 'artistfield/create'; ?>
@extends('admin.layout.app')

@section('page_title', 'Create Artist Field')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('artistfield/list') }}">Artist Fields</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Artist Field</li>
@endsection

@section('admin_content')

@include('admin.partials.user_form_styles')

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body text-center">
                <div class="preview-icon-wrap mb-3">
                    <div class="preview-icon bg-primary-transparent text-primary mx-auto">
                        <i class="fe fe-layers"></i>
                    </div>
                </div>
                <h5 class="main-profile-name mb-1" id="preview-field-name">New Artist Field</h5>
                <p class="main-profile-name-text text-muted mb-2">Artist Field</p>
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Field Preview</div>
                <div class="main-profile-contact-list">
                    <div class="media mb-0">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="fe fe-tag"></i>
                        </div>
                        <div class="media-body">
                            <span>Field Name</span>
                            <div id="preview-name">Not set yet</div>
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

                <form class="form-horizontal" action="{{ url('artistfield/store') }}" method="POST" id="artistfield-create-form">
                    @csrf

                    <div class="mb-4 main-content-label">Basic Information</div>

                    <div class="form-group mb-0">
                        <label class="form-field-label" for="field_name">Field Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-layers"></i></span>
                            <input type="text"
                                class="form-control @error('field_name') is-invalid @enderror"
                                name="field_name"
                                id="field_name"
                                placeholder="Enter artist field name"
                                value="{{ old('field_name') }}"
                                maxlength="255"
                                required>
                        </div>
                        @error('field_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url('artistfield/list') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="artistfield-create-form" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-save me-1"></i> Create Artist Field
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
jQuery(document).ready(function ($) {
    function updatePreview() {
        const name = $('#field_name').val().trim();

        $('#preview-field-name').text(name || 'New Artist Field');
        $('#preview-name').text(name || 'Not set yet');
    }

    $('#field_name').on('input', updatePreview);
    updatePreview();
});
</script>
@endpush
