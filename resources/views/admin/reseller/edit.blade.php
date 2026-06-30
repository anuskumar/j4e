<?php
$page = 'admin/reseller/edit';

$phoneNumber = $data->phone ?? '';
$countryCode = '+91 (IN)';
$phoneOnly = '';

if (!empty($phoneNumber)) {
    if (preg_match('/^(\+\d+.*?)\s+(.+)$/', $phoneNumber, $matches)) {
        $countryCode = $matches[1];
        $phoneOnly = $matches[2];
    } else {
        $phoneOnly = preg_replace('/[^0-9]/', '', $phoneNumber);
    }
}

$profileImage = $data->profile
    ? asset('storage/uploads/images/' . $data->profile)
    : asset('admin_assets/img/faces/6.jpg');
?>
@extends('admin.layout.app')

@section('page_title', 'Edit Reseller')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('admin/reseller/list') }}">Resellers</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Reseller</li>
@endsection

@section('admin_content')

<link href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@include('admin.partials.user_form_styles')

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body text-center">
                <div class="main-profile-overview">
                    <div class="profile-upload-wrap mb-3">
                        <div class="main-img-user profile-user mx-auto">
                            <img alt="Profile preview" id="profile-preview" src="{{ $profileImage }}" onerror="this.src='{{ asset('admin_assets/img/faces/6.jpg') }}'">
                            <label for="profile" class="fas fa-camera profile-edit mb-0" title="Upload profile photo (optional)"></label>
                        </div>
                    </div>
                    <h5 class="main-profile-name mb-1" id="preview-name">{{ $data->name ?? 'Reseller' }}</h5>
                    <p class="main-profile-name-text text-muted mb-1">Reseller Account</p>
                    <p class="profile-file-name mb-3" id="profile-file-name">
                        {{ $data->profile ? basename($data->profile) : 'Optional profile photo — JPG, PNG, GIF or WEBP up to 2MB' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Contact Preview</div>
                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="icon ion-md-mail"></i>
                        </div>
                        <div class="media-body">
                            <span>Email</span>
                            <div id="preview-email">{{ $data->email ?? 'Not set yet' }}</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="icon ion-md-phone-portrait"></i>
                        </div>
                        <div class="media-body">
                            <span>Phone</span>
                            <div id="preview-phone">{{ $data->phone ?: 'Not set yet' }}</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-info-transparent text-info">
                            <i class="icon ion-md-locate"></i>
                        </div>
                        <div class="media-body">
                            <span>Address</span>
                            <div id="preview-address">{{ $data->address ?: 'Not set yet' }}</div>
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

                <form class="form-horizontal" action="{{ url('admin/reseller/update') }}" method="POST" id="reseller-edit-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <input type="file" name="profile" id="profile" class="d-none" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">

                    <div class="mb-4 main-content-label">Personal Information</div>

                    <div class="form-group">
                        <label class="form-field-label" for="name">Full Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-user"></i></span>
                            <input type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                name="name"
                                id="name"
                                placeholder="Enter reseller full name"
                                value="{{ old('name', $data->name) }}"
                                autocomplete="name"
                                maxlength="255"
                                required>
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 main-content-label">Contact Information</div>

                    <div class="form-group">
                        <label class="form-field-label" for="email">Email Address <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-mail"></i></span>
                            <input type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                id="email"
                                placeholder="reseller@example.com"
                                value="{{ old('email', $data->email) }}"
                                autocomplete="email"
                                maxlength="255"
                                required>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-field-label" for="phone">Phone Number <span class="text-danger">*</span></label>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text"><i class="fe fe-phone"></i></span>
                            <select class="form-control select2-select @error('country_code') is-invalid @enderror" name="country_code" id="country_code" style="max-width: 220px;">
                                @include('admin.partials.country_code_options', ['selected' => old('country_code', $countryCode)])
                            </select>
                            <input type="tel"
                                class="form-control @error('phone') is-invalid @enderror"
                                name="phone"
                                id="phone"
                                placeholder="Enter phone number"
                                value="{{ old('phone', $phoneOnly) }}"
                                autocomplete="tel"
                                inputmode="tel"
                                pattern="[0-9\-\s()]+"
                                maxlength="20"
                                required>
                        </div>
                        @error('phone')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('country_code')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('profile')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-field-label" for="address">Address</label>
                        <div class="input-group">
                            <span class="input-group-text align-items-start pt-2"><i class="fe fe-map-pin"></i></span>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                name="address"
                                id="address"
                                rows="3"
                                placeholder="Street, city, state, postal code"
                                maxlength="500">{{ old('address', $data->address) }}</textarea>
                        </div>
                        @error('address')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 main-content-label">Reseller Settings</div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-field-label" for="is_admin_approved">Admin Approved</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fe fe-check-circle"></i></span>
                                    <select class="form-control @error('is_admin_approved') is-invalid @enderror" name="is_admin_approved" id="is_admin_approved">
                                        <option value="1" {{ old('is_admin_approved', $data->is_admin_approved) == 1 ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('is_admin_approved', $data->is_admin_approved) == 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                @error('is_admin_approved')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-field-label" for="is_trusted">Trusted Reseller</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fe fe-shield"></i></span>
                                    <select class="form-control @error('is_trusted') is-invalid @enderror" name="is_trusted" id="is_trusted">
                                        <option value="1" {{ old('is_trusted', $data->is_trusted) == 1 ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('is_trusted', $data->is_trusted) == 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                @error('is_trusted')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 main-content-label">Account Settings</div>

                    <div class="form-group mb-0">
                        <label class="form-field-label d-block">Account Status</label>
                        <div class="d-flex align-items-center justify-content-between border rounded p-3">
                            <div>
                                <div class="fw-semibold">Active account</div>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input"
                                    type="checkbox"
                                    role="switch"
                                    id="is_active_switch"
                                    {{ old('is_active', $data->is_active) == 1 ? 'checked' : '' }}>
                                <input type="hidden" name="is_active" id="is_active" value="{{ old('is_active', $data->is_active) }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url('admin/reseller/list') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="reseller-edit-form" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-save me-1"></i> Update Reseller
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('admin_assets/plugins/select2/js/select2.min.js') }}"></script>
<script>
jQuery(document).ready(function ($) {
    const existingAvatar = @json($profileImage);

    $('#country_code').select2({
        placeholder: 'Country code',
        allowClear: false,
        width: '220px',
        minimumResultsForSearch: 0
    });

    function updatePreview() {
        const name = $('#name').val().trim();
        const email = $('#email').val().trim();
        const phone = $('#phone').val().trim();
        const countryCode = $('#country_code').val() || '';
        const address = $('#address').val().trim();

        $('#preview-name').text(name || 'Reseller');
        $('#preview-email').text(email || 'Not set yet');
        $('#preview-phone').text(phone ? (countryCode + ' ' + phone) : 'Not set yet');
        $('#preview-address').text(address || 'Not set yet');
    }

    function handleProfileFile(file) {
        if (!file || !file.type.startsWith('image/')) return;
        if (file.size > 2 * 1024 * 1024) {
            alert('Profile photo must not exceed 2MB.');
            $('#profile').val('');
            $('#profile-preview').attr('src', existingAvatar);
            return;
        }
        $('#profile-file-name').text(file.name);
        const reader = new FileReader();
        reader.onload = function (event) {
            $('#profile-preview').attr('src', event.target.result);
        };
        reader.readAsDataURL(file);
    }

    $('#profile').on('change', function () { handleProfileFile(this.files[0]); });
    $('#is_active_switch').on('change', function () { $('#is_active').val(this.checked ? '1' : '0'); });
    $('#name, #email, #phone, #address').on('input', updatePreview);
    $('#country_code').on('change', updatePreview);
    updatePreview();
});
</script>
@endpush
