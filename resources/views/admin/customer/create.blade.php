<?php $page = 'admin/customer/create'; ?>
@extends('admin.layout.app')

@section('page_title', 'Create Customer')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('admin/customer/list') }}">Customers</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Customer</li>
@endsection

@section('admin_content')

<link href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

<style>
    .profile-upload-wrap {
        position: relative;
        display: inline-block;
    }

    .profile-upload-wrap .profile-edit {
        cursor: pointer;
    }

    .profile-file-name {
        font-size: 12px;
        color: #6c757d;
    }

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

    .password-strength {
        height: 4px;
        border-radius: 4px;
        background: #e9ecef;
        margin-top: 0.5rem;
        overflow: hidden;
    }

    .password-strength span {
        display: block;
        height: 100%;
        width: 0;
        transition: width 0.2s ease, background 0.2s ease;
    }
</style>

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
                    <h5 class="main-profile-name mb-1" id="preview-name">New Customer</h5>
                    <p class="main-profile-name-text text-muted mb-1">Customer Account</p>
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

                <form class="form-horizontal" action="{{ url('admin/customer/store') }}" method="POST" id="customer-create-form" enctype="multipart/form-data">
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
                                placeholder="Enter customer full name"
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
                                placeholder="customer@example.com"
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
                        <label class="form-field-label" for="phone">Phone Number</label>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text"><i class="fe fe-phone"></i></span>
                            <select class="form-control select2-select @error('country_code') is-invalid @enderror" name="country_code" id="country_code" style="max-width: 220px;">
                                <option value="+1 (US/CA)" {{ old('country_code') == '+1 (US/CA)' ? 'selected' : '' }}>+1 (US/CA)</option>
                                <option value="+91 (IN)" {{ old('country_code', '+91 (IN)') == '+91 (IN)' ? 'selected' : '' }}>+91 (IN) - India</option>
                                <option value="+44 (UK)" {{ old('country_code') == '+44 (UK)' ? 'selected' : '' }}>+44 (UK)</option>
                                <option value="+86 (CN)" {{ old('country_code') == '+86 (CN)' ? 'selected' : '' }}>+86 (CN)</option>
                                <option value="+81 (JP)" {{ old('country_code') == '+81 (JP)' ? 'selected' : '' }}>+81 (JP)</option>
                                <option value="+49 (DE)" {{ old('country_code') == '+49 (DE)' ? 'selected' : '' }}>+49 (DE)</option>
                                <option value="+33 (FR)" {{ old('country_code') == '+33 (FR)' ? 'selected' : '' }}>+33 (FR)</option>
                                <option value="+39 (IT)" {{ old('country_code') == '+39 (IT)' ? 'selected' : '' }}>+39 (IT)</option>
                                <option value="+34 (ES)" {{ old('country_code') == '+34 (ES)' ? 'selected' : '' }}>+34 (ES)</option>
                                <option value="+61 (AU)" {{ old('country_code') == '+61 (AU)' ? 'selected' : '' }}>+61 (AU)</option>
                                <option value="+7 (RU)" {{ old('country_code') == '+7 (RU)' ? 'selected' : '' }}>+7 (RU)</option>
                                <option value="+82 (KR)" {{ old('country_code') == '+82 (KR)' ? 'selected' : '' }}>+82 (KR)</option>
                                <option value="+55 (BR)" {{ old('country_code') == '+55 (BR)' ? 'selected' : '' }}>+55 (BR)</option>
                                <option value="+52 (MX)" {{ old('country_code') == '+52 (MX)' ? 'selected' : '' }}>+52 (MX)</option>
                                <option value="+971 (AE)" {{ old('country_code') == '+971 (AE)' ? 'selected' : '' }}>+971 (AE)</option>
                                <option value="+966 (SA)" {{ old('country_code') == '+966 (SA)' ? 'selected' : '' }}>+966 (SA)</option>
                                <option value="+65 (SG)" {{ old('country_code') == '+65 (SG)' ? 'selected' : '' }}>+65 (SG)</option>
                                <option value="+60 (MY)" {{ old('country_code') == '+60 (MY)' ? 'selected' : '' }}>+60 (MY)</option>
                                <option value="+62 (ID)" {{ old('country_code') == '+62 (ID)' ? 'selected' : '' }}>+62 (ID)</option>
                                <option value="+66 (TH)" {{ old('country_code') == '+66 (TH)' ? 'selected' : '' }}>+66 (TH)</option>
                                <option value="+84 (VN)" {{ old('country_code') == '+84 (VN)' ? 'selected' : '' }}>+84 (VN)</option>
                                <option value="+63 (PH)" {{ old('country_code') == '+63 (PH)' ? 'selected' : '' }}>+63 (PH)</option>
                                <option value="+27 (ZA)" {{ old('country_code') == '+27 (ZA)' ? 'selected' : '' }}>+27 (ZA)</option>
                                <option value="+31 (NL)" {{ old('country_code') == '+31 (NL)' ? 'selected' : '' }}>+31 (NL)</option>
                                <option value="+32 (BE)" {{ old('country_code') == '+32 (BE)' ? 'selected' : '' }}>+32 (BE)</option>
                                <option value="+41 (CH)" {{ old('country_code') == '+41 (CH)' ? 'selected' : '' }}>+41 (CH)</option>
                                <option value="+46 (SE)" {{ old('country_code') == '+46 (SE)' ? 'selected' : '' }}>+46 (SE)</option>
                                <option value="+47 (NO)" {{ old('country_code') == '+47 (NO)' ? 'selected' : '' }}>+47 (NO)</option>
                                <option value="+45 (DK)" {{ old('country_code') == '+45 (DK)' ? 'selected' : '' }}>+45 (DK)</option>
                                <option value="+358 (FI)" {{ old('country_code') == '+358 (FI)' ? 'selected' : '' }}>+358 (FI)</option>
                                <option value="+48 (PL)" {{ old('country_code') == '+48 (PL)' ? 'selected' : '' }}>+48 (PL)</option>
                                <option value="+90 (TR)" {{ old('country_code') == '+90 (TR)' ? 'selected' : '' }}>+90 (TR)</option>
                                <option value="+20 (EG)" {{ old('country_code') == '+20 (EG)' ? 'selected' : '' }}>+20 (EG)</option>
                                <option value="+64 (NZ)" {{ old('country_code') == '+64 (NZ)' ? 'selected' : '' }}>+64 (NZ)</option>
                                <option value="+351 (PT)" {{ old('country_code') == '+351 (PT)' ? 'selected' : '' }}>+351 (PT)</option>
                                <option value="+30 (GR)" {{ old('country_code') == '+30 (GR)' ? 'selected' : '' }}>+30 (GR)</option>
                                <option value="+353 (IE)" {{ old('country_code') == '+353 (IE)' ? 'selected' : '' }}>+353 (IE)</option>
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
                                maxlength="20">
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
                <a href="{{ url('admin/customer/list') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="customer-create-form" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-save me-1"></i> Create Customer
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

        $('#preview-name').text(name || 'New Customer');
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
        const bar = $('#password-strength-bar');

        bar.css({
            width: widths[score],
            background: colors[score]
        });
    }

    function handleProfileFile(file) {
        if (!file || !file.type.startsWith('image/')) {
            return;
        }

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

    $('#profile').on('change', function () {
        handleProfileFile(this.files[0]);
    });

    function checkPasswordMatch() {
        const password = $('#password').val();
        const confirmPassword = $('#password_confirmation').val();
        const message = $('#password-match-message');

        if (!confirmPassword) {
            message.text('').removeClass('text-success text-danger');
            $('#password_confirmation').removeClass('is-invalid is-valid');
            return true;
        }

        if (password === confirmPassword) {
            message.text('Passwords match.').removeClass('text-danger').addClass('text-success');
            $('#password_confirmation').removeClass('is-invalid').addClass('is-valid');
            return true;
        }

        message.text('Passwords do not match.').removeClass('text-success').addClass('text-danger');
        $('#password_confirmation').removeClass('is-valid').addClass('is-invalid');
        return false;
    }

    $('#toggle-password').on('click', function () {
        const passwordInput = $('#password');
        const icon = $('#passwordToggleIcon');
        const isPassword = passwordInput.attr('type') === 'password';
        passwordInput.attr('type', isPassword ? 'text' : 'password');
        icon.toggleClass('fa-eye fa-eye-slash');
    });

    $('#toggle-password-confirm').on('click', function () {
        const passwordInput = $('#password_confirmation');
        const icon = $('#passwordConfirmToggleIcon');
        const isPassword = passwordInput.attr('type') === 'password';
        passwordInput.attr('type', isPassword ? 'text' : 'password');
        icon.toggleClass('fa-eye fa-eye-slash');
    });

    $('#customer-create-form').on('submit', function (e) {
        if (!checkPasswordMatch()) {
            e.preventDefault();
            $('#password_confirmation').focus();
        }
    });

    $('#is_active_switch').on('change', function () {
        $('#is_active').val(this.checked ? '1' : '0');
    });

    $('#name, #email, #phone, #address').on('input', updatePreview);
    $('#country_code').on('change', updatePreview);
    $('#password, #password_confirmation').on('input', function () {
        if ($(this).attr('id') === 'password') {
            updatePasswordStrength($(this).val());
        }
        checkPasswordMatch();
    });

    updatePreview();
    updatePasswordStrength($('#password').val());
});
</script>
@endpush
