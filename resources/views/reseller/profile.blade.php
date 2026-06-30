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
@endphp

<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        color: white;
    }
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid white;
        object-fit: cover;
        margin-bottom: 1rem;
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
    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
    }
    .nav-tabs .nav-link.active {
        color: #667eea;
        border-bottom: 3px solid #667eea;
        background: transparent;
    }
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 0.6rem 2rem;
        font-weight: 500;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #5568d3 0%, #653a8f 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
    .info-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e9ecef;
    }
    .info-item:last-child {
        border-bottom: none;
    }
    .info-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.2rem;
    }
    .info-icon.primary {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }
    .info-icon.success {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    .info-icon.info {
        background: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
    }
</style>

<div class="container-fluid py-4">
    <!-- Profile Header -->
    <div class="profile-header text-center">
        <div class="d-flex justify-content-center mb-3 position-relative">
            <img src="{{ $profileImage }}" alt="Profile" class="profile-avatar" id="profile-avatar-preview"
                onerror="this.src='{{ asset('admin_assets/img/faces/6.jpg') }}'">
        </div>
        <h3 class="mb-1">{{ $authdata->name }}</h3>
        <p class="mb-0 opacity-75">{{ $accountLabel }}</p>
    </div>

    <!-- Tabs Navigation -->
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
                @if ($isReseller)
                <li class="nav-item">
                    <a class="nav-link" id="bank-tab" data-bs-toggle="tab" href="#bank" role="tab">
                        <i class="fe fe-credit-card me-2"></i>Bank Details
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address" role="tab">
                        <i class="fe fe-map-pin me-2"></i>Address Details
                    </a>
                </li>
                @endif
            </ul>

            <div class="tab-content p-4">
                <!-- Profile Tab -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fe fe-user me-2"></i>Personal Information</h5>
                        </div>
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

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ url('reseller/update_profile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="authid" value="{{ $authdata->id }}">

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               name="name" placeholder="Enter your full name" 
                                               value="{{ old('name', $authdata->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="email" class="form-control @error('company_email') is-invalid @enderror" 
                                               name="company_email" placeholder="Enter your email" 
                                               value="{{ old('company_email', $authdata->email) }}" required>
                                        @error('company_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Contact Number @if($phoneRequired)<span class="text-danger">*</span>@endif</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control @error('contact_number') is-invalid @enderror" 
                                               name="contact_number" placeholder="Enter your phone number" 
                                               value="{{ old('contact_number', $authdata->phone) }}" {{ $phoneRequired ? 'required' : '' }}>
                                        @error('contact_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Profile Image</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="file" class="form-control @error('profile') is-invalid @enderror" 
                                               name="profile" id="profile" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                                        <small class="text-muted">Accepted formats: JPG, PNG, GIF, WEBP. Max size: 2MB</small>
                                        @error('profile')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fe fe-save me-2"></i>Update Profile
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Password Tab -->
                <div class="tab-pane fade" id="password" role="tabpanel">
                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fe fe-lock me-2"></i>Change Password</h5>
                        </div>
                        <div class="card-body">
                            @if(session('password_success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('password_success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if(session('password_error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('password_error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route('reseller.passwordupdate') }}" method="POST" name="passwordForm" onsubmit="return validateForm()">
                                @csrf
                                <input type="hidden" name="id" value="{{ $authdata->id }}">

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Current Password <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control @error('oldpassword') is-invalid @enderror" 
                                               name="oldpassword" placeholder="Enter your current password" required>
                                        @error('oldpassword')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">New Password <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control @error('newpassword') is-invalid @enderror" 
                                               name="newpassword" placeholder="Enter your new password" required>
                                        <small class="text-muted">Password must be at least 8 characters long</small>
                                        @error('newpassword')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" 
                                               name="confirm_password" placeholder="Confirm your new password" required>
                                        @error('confirm_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fe fe-key me-2"></i>Change Password
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Bank Details Tab -->
                @if ($isReseller)
                <div class="tab-pane fade" id="bank" role="tabpanel">
                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fe fe-credit-card me-2"></i>Bank Details</h5>
                        </div>
                        <div class="card-body">
                            @if(session('bank_success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('bank_success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route('reseller.bankdataupdate') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $authdata->id }}">

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Bank Name</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               name="name" placeholder="Enter bank name" 
                                               value="{{ old('name', $bankData->bank_name ?? '') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Bank Email</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="email" class="form-control @error('bankname') is-invalid @enderror" 
                                               name="bankname" placeholder="Enter bank email" 
                                               value="{{ old('bankname', $bankData->bank_email ?? '') }}">
                                        @error('bankname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Bank Country <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="bank_country" class="form-control select2-select @error('bank_country') is-invalid @enderror" required>
                                            <option value="">Select Country</option>
                                            @foreach($country as $loc)
                                                <option value="{{ $loc->id }}" 
                                                    {{ old('bank_country', $bankData->bank_country ?? '') == $loc->id ? 'selected' : '' }}>
                                                    {{ $loc->country_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('bank_country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Account IBAN <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control @error('bankaccno') is-invalid @enderror" 
                                               name="bankaccno" placeholder="Enter IBAN number" 
                                               value="{{ old('bankaccno', $bankData->accnt_no ?? '') }}" required>
                                        @error('bankaccno')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">BIC/SWIFT Code <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control @error('bankbic') is-invalid @enderror" 
                                               name="bankbic" placeholder="Enter BIC/SWIFT code" 
                                               value="{{ old('bankbic', $bankData->bic ?? '') }}" required>
                                        @error('bankbic')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Comments</label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="form-control @error('bankcomments') is-invalid @enderror" 
                                                  name="bankcomments" rows="3" 
                                                  placeholder="Enter any additional comments">{{ old('bankcomments', $bankData->comments ?? '') }}</textarea>
                                        @error('bankcomments')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fe fe-save me-2"></i>Update Bank Details
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Address Tab -->
                <div class="tab-pane fade" id="address" role="tabpanel">
                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fe fe-map-pin me-2"></i>Address Details</h5>
                        </div>
                        <div class="card-body">
                            @if(session('address_success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('address_success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route('reseller.addressdataupdate') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $authdata->id }}">

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Full Name</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               name="name" placeholder="Enter full name" 
                                               value="{{ old('name', $adreesdata->name ?? '') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Address Line 1</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control @error('address_line1') is-invalid @enderror" 
                                               name="address_line1" placeholder="Street address, P.O. box" 
                                               value="{{ old('address_line1', $adreesdata->address_line1 ?? '') }}">
                                        @error('address_line1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Address Line 2</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control @error('address_line2') is-invalid @enderror" 
                                               name="address_line2" placeholder="Apartment, suite, unit, building, floor, etc." 
                                               value="{{ old('address_line2', $adreesdata->address_line2 ?? '') }}">
                                        @error('address_line2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Country <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="country" id="country" class="form-control select2-select @error('country') is-invalid @enderror" required>
                                            <option value="">Select Country</option>
                                            @foreach($country as $loc)
                                                <option value="{{ $loc->id }}" 
                                                    {{ old('country', $adreesdata->country ?? '') == $loc->id ? 'selected' : '' }}>
                                                    {{ $loc->country_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">City <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="city" id="city" class="form-control select2-select @error('city') is-invalid @enderror" required>
                                            <option value="">Select City</option>
                                        </select>
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Postal Code</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control @error('postcode') is-invalid @enderror" 
                                               name="postcode" placeholder="Enter postal code" 
                                               value="{{ old('postcode', $adreesdata->postcode ?? '') }}">
                                        @error('postcode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Phone Number</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                               name="phone" placeholder="Enter phone number" 
                                               value="{{ old('phone', $adreesdata->phone ?? '') }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fe fe-save me-2"></i>Update Address
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if ($isReseller)
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const profileInput = document.getElementById('profile');
        const profilePreview = document.getElementById('profile-avatar-preview');
        const fallbackImage = @json(asset('admin_assets/img/faces/6.jpg'));

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
    });

    @if ($isReseller)
    jQuery(document).ready(function ($) {
        // Initialize Select2
        $('.select2-select').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });

        var selectedCityId = {{ $adreesdata->city ?? 0 }};

        // Load cities when country changes
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
                            // Check if data is array of objects with id and text/name properties
                            if (data[0].id !== undefined) {
                                $.each(data, function (index, city) {
                                    var cityId = city.id;
                                    var cityName = city.text || city.name || city.city_name;
                                    var selected = (cityId == selectedCityId) ? 'selected' : '';
                                    $('#city').append('<option value="' + cityId + '" ' + selected + '>' + cityName + '</option>');
                                });
                            } else {
                                // If data is object with id as key
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

        // Trigger change on page load if country is selected
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
