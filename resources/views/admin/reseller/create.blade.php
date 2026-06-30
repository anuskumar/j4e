<?php $page = 'admin/reseller/create'; ?>
@extends('admin.layout.app')

@section('page_title', 'Create Reseller')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('admin/reseller/list') }}">Resellers</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Reseller</li>
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
                            <img alt="Profile preview" id="profile-preview" src="{{ asset('admin_assets/img/faces/6.jpg') }}">
                            <label for="profile" class="fas fa-camera profile-edit mb-0" title="Upload profile photo (optional)"></label>
                        </div>
                    </div>
                    <h5 class="main-profile-name mb-1" id="preview-name">New Reseller</h5>
                    <p class="main-profile-name-text text-muted mb-1">Reseller Account</p>
                    <p class="profile-file-name mb-3" id="profile-file-name">Optional profile photo — JPG, PNG, GIF or WEBP up to 2MB</p>
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
                            <div id="preview-email">Not set yet</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="icon ion-md-phone-portrait"></i>
                        </div>
                        <div class="media-body">
                            <span>Phone</span>
                            <div id="preview-phone">Not set yet</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-info-transparent text-info">
                            <i class="icon ion-md-locate"></i>
                        </div>
                        <div class="media-body">
                            <span>Address</span>
                            <div id="preview-address">Not set yet</div>
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

                <form class="form-horizontal" action="{{ url('admin/reseller/store') }}" method="POST" id="reseller-create-form" enctype="multipart/form-data">
                    @csrf
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
                                value="{{ old('name') }}"
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
                                value="{{ old('email') }}"
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
                                @include('admin.partials.country_code_options', ['selected' => old('country_code', '+91 (IN)')])
                            </select>
                            <input type="tel"
                                class="form-control @error('phone') is-invalid @enderror"
                                name="phone"
                                id="phone"
                                placeholder="Enter phone number"
                                value="{{ old('phone') }}"
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
                                maxlength="500">{{ old('address') }}</textarea>
                        </div>
                        @error('address')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 main-content-label">Account Security</div>

                    <div class="form-group">
                        <label class="form-field-label" for="password">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-lock"></i></span>
                            <input type="password"
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                placeholder="Create a secure password"
                                autocomplete="new-password"
                                minlength="6"
                                required>
                            <button type="button" class="btn btn-outline-secondary" id="toggle-password" aria-label="Show password">
                                <i class="far fa-eye" id="passwordToggleIcon"></i>
                            </button>
                        </div>
                        <div class="password-strength"><span id="password-strength-bar"></span></div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-field-label" for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-lock"></i></span>
                            <input type="password"
                                id="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                name="password_confirmation"
                                placeholder="Re-enter password"
                                autocomplete="new-password"
                                minlength="6"
                                required>
                            <button type="button" class="btn btn-outline-secondary" id="toggle-password-confirm" aria-label="Show confirm password">
                                <i class="far fa-eye" id="passwordConfirmToggleIcon"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <div id="password-match-message" class="form-field-hint"></div>
                    </div>

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
                                    {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                <input type="hidden" name="is_active" id="is_active" value="{{ old('is_active', '1') }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url('admin/reseller/list') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="reseller-create-form" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-save me-1"></i> Create Reseller
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
    const defaultAvatar = @json(asset('admin_assets/img/faces/6.jpg'));

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

        $('#preview-name').text(name || 'New Reseller');
        $('#preview-email').text(email || 'Not set yet');
        $('#preview-phone').text(phone ? (countryCode + ' ' + phone) : 'Not set yet');
        $('#preview-address').text(address || 'Not set yet');
    }

    function updatePasswordStrength(password) {
        let score = 0;
        if (password.length >= 6) score++;
        if (password.length >= 10) score++;
        if (/[A-Z]/.test(password) && /[a-z]/.test(password)) score++;
        if (/\d/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;

        const widths = ['0%', '20%', '40%', '60%', '80%', '100%'];
        const colors = ['#e9ecef', '#ff6b6b', '#ffa94d', '#ffd43b', '#51cf66', '#2f9e44'];
        $('#password-strength-bar').css({ width: widths[score], background: colors[score] });
    }

    function handleProfileFile(file) {
        if (!file || !file.type.startsWith('image/')) return;
        if (file.size > 2 * 1024 * 1024) {
            alert('Profile photo must not exceed 2MB.');
            $('#profile').val('');
            $('#profile-file-name').text('Optional profile photo — JPG, PNG, GIF or WEBP up to 2MB');
            $('#profile-preview').attr('src', defaultAvatar);
            return;
        }
        $('#profile-file-name').text(file.name);
        const reader = new FileReader();
        reader.onload = function (event) {
            $('#profile-preview').attr('src', event.target.result);
        };
        reader.readAsDataURL(file);
    }

    function checkPasswordMatch() {
        const password = $('#password').val();
        const confirm = $('#password_confirmation').val();
        const msg = $('#password-match-message');
        if (!confirm) { msg.text(''); return; }
        msg.text(password === confirm ? 'Passwords match' : 'Passwords do not match')
            .css('color', password === confirm ? '#51cf66' : '#ff6b6b');
    }

    $('#profile').on('change', function () { handleProfileFile(this.files[0]); });
    $('#is_active_switch').on('change', function () { $('#is_active').val(this.checked ? '1' : '0'); });

    $('#toggle-password').on('click', function () {
        const input = $('#password');
        const icon = $('#passwordToggleIcon');
        const isPassword = input.attr('type') === 'password';
        input.attr('type', isPassword ? 'text' : 'password');
        icon.toggleClass('fa-eye fa-eye-slash');
    });

    $('#toggle-password-confirm').on('click', function () {
        const input = $('#password_confirmation');
        const icon = $('#passwordConfirmToggleIcon');
        const isPassword = input.attr('type') === 'password';
        input.attr('type', isPassword ? 'text' : 'password');
        icon.toggleClass('fa-eye fa-eye-slash');
    });

    $('#password').on('input', function () {
        updatePasswordStrength($(this).val());
        checkPasswordMatch();
    });
    $('#password_confirmation').on('input', checkPasswordMatch);
    $('#name, #email, #phone, #address').on('input', updatePreview);
    $('#country_code').on('change', updatePreview);
    updatePreview();
});
</script>
@endpush
