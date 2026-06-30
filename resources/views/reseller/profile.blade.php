<?php $page = 'Reseller/Profile'; ?>
@extends(Auth::user()->user_type == "reseller" ? 'layouts.reseller_app' : 'admin.layout.app')

@if(Auth::user()->user_type != "reseller")
@section('page_title', 'My Profile')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">My Profile</li>
@endsection
@endif

@if(Auth::user()->user_type == "reseller")
    @section('content')
@else
    @section('admin_content')
@endif

@php
    $isReseller = Auth::user()->user_type === 'reseller';
    $phoneRequired = ! in_array(Auth::user()->user_type, ['admin', 'superadmin'], true);
    $accountLabel = match (Auth::user()->user_type) {
        'superadmin' => 'Admin Account',
        'reseller' => 'Reseller Account',
        'customer' => 'Customer Account',
        default => ucfirst(Auth::user()->user_type) . ' Account',
    };
    $profileImage = $authdata->profile
        ? asset('storage/uploads/images/' . $authdata->profile)
        : ($isReseller ? asset('assets/img/customers/customer.jpg') : asset('admin_assets/img/faces/6.jpg'));
    $bankDetailsComplete = $isReseller ? \App\Models\Bankmodel::isCompleteForReseller(Auth::id()) : true;
@endphp

@if ($isReseller)
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endpush
@endif

<style>
    .reseller-profile-page {
        max-width: 1140px;
        margin: 0 auto;
    }

    .reseller-profile-page .profile-sidebar {
        border: 1px solid #e8ebf3;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .reseller-profile-page .profile-sidebar__banner {
        background: linear-gradient(135deg, #7e0982 0%, #5c0660 100%);
        padding: 2rem 1.5rem 3.5rem;
        text-align: center;
    }

    .reseller-profile-page .profile-avatar {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        border: 4px solid #fff;
        object-fit: cover;
        margin-bottom: 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
    }

    .reseller-profile-page .profile-sidebar__body {
        margin-top: -2rem;
        padding: 0 1.5rem 1.5rem;
        text-align: center;
    }

    .reseller-profile-page .profile-sidebar__name {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: #1a1a2e;
    }

    .reseller-profile-page .profile-sidebar__meta {
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .reseller-profile-page .profile-info-list {
        text-align: left;
        border-top: 1px solid #eef0f4;
        padding-top: 1rem;
        margin-top: 0.5rem;
    }

    .reseller-profile-page .profile-info-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.65rem 0;
        font-size: 0.9rem;
        color: #374151;
    }

    .reseller-profile-page .profile-info-item i {
        color: #7e0982;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .reseller-profile-page .profile-main-card {
        border: 1px solid #e8ebf3;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    .reseller-profile-page .nav-tabs {
        border-bottom: 1px solid #e8ebf3;
        padding: 0 1rem;
        flex-wrap: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .reseller-profile-page .nav-tabs .nav-link {
        border: none;
        color: #6b7280;
        padding: 1rem 1.1rem;
        font-weight: 600;
        font-size: 0.92rem;
        white-space: nowrap;
        border-bottom: 3px solid transparent;
        margin-bottom: -1px;
        background: transparent;
    }

    .reseller-profile-page .nav-tabs .nav-link:hover {
        color: #7e0982;
    }

    .reseller-profile-page .nav-tabs .nav-link.active {
        color: #7e0982;
        border-bottom-color: #7e0982;
        background: transparent;
    }

    .reseller-profile-page .tab-content {
        padding: 1.5rem;
    }

    .reseller-profile-page .section-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #eef0f4;
    }

    .reseller-profile-page .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.4rem;
    }

    .reseller-profile-page .form-control:focus,
    .reseller-profile-page .form-select:focus {
        border-color: #7e0982;
        box-shadow: 0 0 0 0.2rem rgba(126, 9, 130, 0.15);
    }

    .reseller-profile-page .btn-primary {
        background: #7e0982;
        border-color: #7e0982;
        font-weight: 600;
        padding: 0.55rem 1.5rem;
    }

    .reseller-profile-page .btn-primary:hover,
    .reseller-profile-page .btn-primary:focus {
        background: #6a0770;
        border-color: #6a0770;
    }

    .reseller-profile-page .select2-container--default .select2-selection--single {
        height: 38px;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
    }

    .reseller-profile-page .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
        padding-left: 12px;
        color: #212529;
    }

    .reseller-profile-page .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }

    .reseller-profile-page .select2-container {
        width: 100% !important;
    }

    @media (max-width: 991.98px) {
        .reseller-profile-page .profile-sidebar {
            margin-bottom: 1.25rem;
        }
    }

    /* Admin layout fallback */
    .profile-header {
        background: linear-gradient(135deg, #7e0982 0%, #5c0660 100%);
        padding: 2rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        color: white;
    }
    .profile-header .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid white;
        object-fit: cover;
    }
    .profile-card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-radius: 10px;
        margin-bottom: 1.5rem;
    }
    .profile-card .card-header {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
        padding: 1rem 1.5rem;
        border-radius: 10px 10px 0 0;
    }
</style>

<div class="{{ $isReseller ? 'container py-4 reseller-profile-page' : 'container-fluid py-4' }}">
    @if ($isReseller)
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="profile-sidebar">
                <div class="profile-sidebar__banner">
                    <img src="{{ $profileImage }}" alt="Profile" class="profile-avatar" id="profile-avatar-preview"
                        onerror="this.src='{{ asset('assets/img/customers/customer.jpg') }}'">
                </div>
                <div class="profile-sidebar__body">
                    <h3 class="profile-sidebar__name">{{ $authdata->name }}</h3>
                    <p class="profile-sidebar__meta mb-0">{{ $accountLabel }}</p>

                    @if (!$bankDetailsComplete)
                        <div class="alert alert-warning py-2 px-3 mt-3 mb-0 text-start small">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Bank details incomplete
                        </div>
                    @endif

                    <div class="profile-info-list">
                        <div class="profile-info-item">
                            <i class="bi bi-envelope"></i>
                            <span>{{ $authdata->email }}</span>
                        </div>
                        @if ($authdata->phone)
                        <div class="profile-info-item">
                            <i class="bi bi-telephone"></i>
                            <span>{{ $authdata->phone }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="profile-main-card">
                @if ($errors->any())
                    <div class="alert alert-danger m-3 mb-0">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-3 mb-0" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab">
                            <i class="bi bi-person me-1"></i>Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password" role="tab">
                            <i class="bi bi-lock me-1"></i>Password
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="bank-tab" data-bs-toggle="tab" href="#bank" role="tab">
                            <i class="bi bi-bank me-1"></i>Bank Details
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address" role="tab">
                            <i class="bi bi-geo-alt me-1"></i>Address
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
    @else
    <div class="profile-header text-center">
        <div class="d-flex justify-content-center mb-3 position-relative">
            <img src="{{ $profileImage }}" alt="Profile" class="profile-avatar" id="profile-avatar-preview"
                onerror="this.src='{{ asset('admin_assets/img/faces/6.jpg') }}'">
        </div>
        <h3 class="mb-1">{{ $authdata->name }}</h3>
        <p class="mb-0 opacity-75">{{ $accountLabel }}</p>
    </div>

    <div class="card profile-card">
        <div class="card-body p-0">
            <ul class="nav nav-tabs border-bottom" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab">
                        <i class="fe fe-user me-2"></i>Profile Information
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password" role="tab">
                        <i class="fe fe-lock me-2"></i>Change Password
                    </a>
                </li>
            </ul>

            <div class="tab-content p-4">
    @endif
                <!-- Profile Tab -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                    @if (!$isReseller)
                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fe fe-user me-2"></i>Personal Information</h5>
                        </div>
                        <div class="card-body">
                    @else
                    <h5 class="section-title"><i class="bi bi-person me-2"></i>Personal Information</h5>
                    @endif

                            @if (!$isReseller && $errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(!$isReseller && session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ url('reseller/update_profile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="authid" value="{{ $authdata->id }}">

                                <div class="mb-3">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" placeholder="Enter your full name" 
                                           value="{{ old('name', $authdata->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('company_email') is-invalid @enderror" 
                                           name="company_email" placeholder="Enter your email" 
                                           value="{{ old('company_email', $authdata->email) }}" required>
                                    @error('company_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Contact Number @if($phoneRequired)<span class="text-danger">*</span>@endif</label>
                                    <input type="text" class="form-control @error('contact_number') is-invalid @enderror" 
                                           name="contact_number" placeholder="Enter your phone number" 
                                           value="{{ old('contact_number', $authdata->phone) }}" {{ $phoneRequired ? 'required' : '' }}>
                                    @error('contact_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Profile Image</label>
                                    <input type="file" class="form-control @error('profile') is-invalid @enderror" 
                                           name="profile" id="profile" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                                    <small class="text-muted">Accepted formats: JPG, PNG, GIF, WEBP. Max size: 2MB</small>
                                    @error('profile')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i>Update Profile
                                </button>
                            </form>
                    @if (!$isReseller)
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Password Tab -->
                <div class="tab-pane fade" id="password" role="tabpanel">
                    @if (!$isReseller)
                    <div class="card profile-card">
                        <div class="card-header"><h5 class="mb-0"><i class="fe fe-lock me-2"></i>Change Password</h5></div>
                        <div class="card-body">
                    @else
                    <h5 class="section-title"><i class="bi bi-lock me-2"></i>Change Password</h5>
                    @endif
                            @include('reseller.partials.profile_password_form')
                    @if (!$isReseller)
                        </div>
                    </div>
                    @endif
                </div>

                @if ($isReseller)
                <!-- Bank Details Tab -->
                <div class="tab-pane fade" id="bank" role="tabpanel">
                    <h5 class="section-title"><i class="bi bi-bank me-2"></i>Bank Details</h5>
                    @if (!$bankDetailsComplete)
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Please complete your bank country, IBAN, and BIC/SWIFT code to receive payouts.
                        </div>
                    @endif
                            @include('reseller.partials.profile_bank_form')
                </div>

                <!-- Address Tab -->
                <div class="tab-pane fade" id="address" role="tabpanel">
                    <h5 class="section-title"><i class="bi bi-geo-alt me-2"></i>Address Details</h5>
                            @include('reseller.partials.profile_address_form')
                </div>
                @endif
            </div>
    @if ($isReseller)
            </div>
        </div>
    </div>
    @else
        </div>
    </div>
    @endif
</div>

@if ($isReseller)
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const profileInput = document.getElementById('profile');
        const profilePreview = document.getElementById('profile-avatar-preview');
        const fallbackImage = @json($isReseller ? asset('assets/img/customers/customer.jpg') : asset('admin_assets/img/faces/6.jpg'));

        if (profileInput && profilePreview) {
            profileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file || !file.type.startsWith('image/')) {
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    alert('Profile image must not exceed 2MB.');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (event) {
                    profilePreview.src = event.target.result;
                };
                reader.readAsDataURL(file);
            });
        }

        @if ($isReseller)
        const hash = window.location.hash;
        if (hash) {
            const tabTrigger = document.querySelector(`a[href="${hash}"]`);
            if (tabTrigger) {
                bootstrap.Tab.getOrCreateInstance(tabTrigger).show();
            }
        }
        @endif
    });

    @if ($isReseller)
    jQuery(document).ready(function ($) {
        $('.select2-select').select2({
            width: '100%',
            dropdownParent: $('.reseller-profile-page')
        });

        var selectedCityId = {{ $adreesdata->city ?? 0 }};

        $('#country').on('change', function () {
            var countryId = $(this).val();
            if (countryId) {
                $.ajax({
                    url: "{{ route('get.cities') }}",
                    type: 'GET',
                    data: { country_id: countryId },
                    dataType: 'json',
                    success: function (data) {
                        $('#city').empty().append('<option value="">Select City</option>');
                        if (Array.isArray(data) && data.length > 0) {
                            if (data[0].id !== undefined) {
                                $.each(data, function (index, city) {
                                    var cityId = city.id;
                                    var cityName = city.text || city.name || city.city_name;
                                    var selected = (cityId == selectedCityId) ? 'selected' : '';
                                    $('#city').append('<option value="' + cityId + '" ' + selected + '>' + cityName + '</option>');
                                });
                            } else {
                                $.each(data, function (id, name) {
                                    var selected = (id == selectedCityId) ? 'selected' : '';
                                    $('#city').append('<option value="' + id + '" ' + selected + '>' + name + '</option>');
                                });
                            }
                        }
                        $('#city').trigger('change');
                    },
                    error: function() {
                        $('#city').empty().append('<option value="">Error loading cities</option>');
                    }
                });
            } else {
                $('#city').empty().append('<option value="">Select City</option>');
            }
        });

        if ($('#country').val()) {
            $('#country').trigger('change');
        }
    });
    @endif

    function validateForm() {
        var oldPassword = document.forms["passwordForm"]["oldpassword"].value;
        var newPassword = document.forms["passwordForm"]["newpassword"].value;
        var confirmPassword = document.forms["passwordForm"]["confirm_password"].value;

        if (oldPassword == "") {
            alert("Current password is required");
            return false;
        }

        if (newPassword == "") {
            alert("New password is required");
            return false;
        }

        if (newPassword.length < 8) {
            alert("New password must be at least 8 characters long");
            return false;
        }

        if (confirmPassword == "") {
            alert("Please confirm your new password");
            return false;
        }

        if (newPassword !== confirmPassword) {
            alert("New password and confirm password do not match");
            return false;
        }

        return true;
    }
</script>

@endsection
