<?php $page="customer-profile";?>
@extends('layout.mainlayout')
@section('content')
@php
    $user = Auth::user();
    $profileImage = $user->profileImageUrl();
    $defaultAvatar = \App\Models\User::defaultProfileImageUrl();
@endphp
<style>
    .password-toggle-wrap {
        position: relative;
    }

    .password-toggle-wrap .form-control {
        padding-right: 44px;
    }

    .password-toggle-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        color: #6c757d;
        padding: 0;
        line-height: 1;
        cursor: pointer;
        z-index: 2;
    }

    .password-toggle-btn:hover {
        color: #671dcf;
    }

    .password-toggle-btn:focus {
        outline: none;
    }
</style>
<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Profile</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Profile</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->

			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<div class="row">
						<div class="col-md-4 col-lg-4 col-xl-3 theiaStickySidebar dct-dashbd-lft">

							<!-- Profile Widget -->
							<div class="card widget-profile pat-widget-profile">
								<div class="card-body">
									<div class="pro-widget-content">
										<div class="profile-info-widget">
											<a href="#" class="booking-doc-img">
                                                <img src="{{ $profileImage }}" alt="User Image"
                                                    onerror="this.onerror=null;this.src='{{ $defaultAvatar }}';">
											</a>
											<div class="profile-det-info">
												<h3>{{ ucfirst(Auth::user()->name) }}</h3>

												<div class="customer-details">
													<h5><b>customer ID :</b> {{ Auth::user()->id }}</h5>
													{{-- <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Newyork, United States</h5> --}}
												</div>
											</div>
										</div>
									</div>
									<div class="customer-info">
										<ul>
											<li>Phone <span>{{ Auth::user()->phone }}</span></li>
											<li>Email <span>{{ Auth::user()->email }}</span></li>
											{{-- <li>Gender <span>{{ Auth::user()-> }}</span></li> --}}
										</ul>
									</div>
								</div>
                                <hr>
                            @include('layout.customer_sidebar')
							</div>

							<!-- /Profile Widget -->

							<!-- Last Booking -->
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Last Booking</h4>
								</div>

							</div>
							<!-- /Last Booking -->

						</div>

						<div class="col-md-8 col-lg-8 col-xl-9">
							<div class="card">
								<div class="card-body">
                                    @if (session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif
                                    @if ($errors->any() && ! $errors->hasAny(['current_password', 'new_password', 'new_password_confirmation']))
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

									<!-- Profile Settings Form -->
									<form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                                        @csrf
										<div class="row form-row">
											<div class="col-12 col-md-12">
												<div class="form-group">
													<div class="change-avatar">

                                                        <div class="profile-img">
															<img id="profile-preview" src="{{ $profileImage }}" alt="User Image"
                                                                onerror="this.onerror=null;this.src='{{ $defaultAvatar }}';">
														</div>
														<div class="upload-img">
															<div class="change-photo-btn">
																<span><i class="fa fa-upload"></i> Upload Photo</span>
																<input type="file" class="upload" name="profile">
															</div>
															<small class="form-text text-muted">Allowed JPG, GIF or PNG. Max size of 2MB</small>
														</div>
													</div>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Full Name</label>
													<input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
												</div>
											</div>

											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Date of Birth</label>

														<input type="date" name="date_of_birth" class="form-control " value="{{ Auth::user()->date_or_birth }}">

												</div>
											</div>

											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Email ID</label>
													<input type="email" readonly class="form-control" value="{{ Auth::user()->email }}">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Mobile</label>
													<input type="text" value="{{ old('phone', $user->phone) }}" name="phone" class="form-control">
												</div>
											</div>
										</div>

                                        <hr>
                                        <h5 class="mb-3">Shipping Information</h5>
                                        <p class="text-muted mb-3">Saved shipping details are used to pre-fill checkout.</p>
                                        <div class="row form-row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label>Shipping Name</label>
                                                    <input type="text" class="form-control" name="shipping_name"
                                                        value="{{ old('shipping_name', $user->shipping_name ?: $user->name) }}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label>Address Line 1</label>
                                                    <textarea class="form-control" name="address" rows="2">{{ old('address', $user->address) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label>Address Line 2</label>
                                                    <textarea class="form-control" name="shipping_address2" rows="2">{{ old('shipping_address2', $user->shipping_address2) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <select class="form-control" name="shipping_country">
                                                        <option value="">Select Country</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}"
                                                                {{ (string) old('shipping_country', $user->shipping_country) === (string) $country->id ? 'selected' : '' }}>
                                                                {{ $country->country_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input type="text" class="form-control" name="shipping_city"
                                                        value="{{ old('shipping_city', $user->shipping_city) }}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label>Pincode</label>
                                                    <input type="text" class="form-control" name="shipping_pincode"
                                                        value="{{ old('shipping_pincode', $user->shipping_pincode) }}">
                                                </div>
                                            </div>
                                        </div>
										<div class="submit-section">
											<button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
										</div>
									</form>
									<!-- /Profile Settings Form -->

								</div>
							</div>

							<div class="card">
								<div class="card-body">
                                    @if (session('password_success'))
                                        <div class="alert alert-success">{{ session('password_success') }}</div>
                                    @endif

									<h5 class="mb-1">Change Password</h5>
									<p class="text-muted mb-4">Update your account password. Use at least 8 characters.</p>

									<form method="POST" action="{{ route('customer.password.update') }}" id="change-password-form">
                                        @csrf
										<div class="row form-row">
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Current Password</label>
													<div class="password-toggle-wrap">
														<input type="password" name="current_password"
															class="form-control @error('current_password') is-invalid @enderror"
															autocomplete="current-password" required>
														<button type="button" class="password-toggle-btn" data-password-toggle aria-label="Show password">
															<i class="far fa-eye"></i>
														</button>
													</div>
													@error('current_password')
														<div class="invalid-feedback d-block">{{ $message }}</div>
													@enderror
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>New Password</label>
													<div class="password-toggle-wrap">
														<input type="password" name="new_password"
															class="form-control @error('new_password') is-invalid @enderror"
															autocomplete="new-password" required>
														<button type="button" class="password-toggle-btn" data-password-toggle aria-label="Show password">
															<i class="far fa-eye"></i>
														</button>
													</div>
													@error('new_password')
														<div class="invalid-feedback d-block">{{ $message }}</div>
													@enderror
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Confirm New Password</label>
													<div class="password-toggle-wrap">
														<input type="password" name="new_password_confirmation"
															class="form-control @error('new_password_confirmation') is-invalid @enderror"
															autocomplete="new-password" required>
														<button type="button" class="password-toggle-btn" data-password-toggle aria-label="Show password">
															<i class="far fa-eye"></i>
														</button>
													</div>
													@error('new_password_confirmation')
														<div class="invalid-feedback d-block">{{ $message }}</div>
													@enderror
												</div>
											</div>
										</div>
										<div class="submit-section">
											<button type="submit" class="btn btn-primary submit-btn">Update Password</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>

				</div>

			</div>
			<!-- /Page Content -->

			</div>
			<!-- Add Event Records Modal -->
		<div class="modal fade custom-modal" id="add_medical_records">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Event Info</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<form>
						<div class="modal-body">
							<div class="form-group">
								<label>Date</label>
								<input type="text" class="form-control datetimepicker" value="31-10-2020">
							</div>
							<div class="form-group">
								<label>Event ( Optional )</label>
								<textarea class="form-control"></textarea>
							</div>
							<div class="submit-section text-center">
								<button type="submit" class="btn btn-primary submit-btn">Submit</button>
								<button type="button" class="btn btn-secondary submit-btn" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /Add Event Records Modal -->

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const profileInput = document.querySelector('input[name="profile"]');
                const profilePreview = document.getElementById('profile-preview');
                const defaultAvatar = @json($defaultAvatar);

                if (profileInput && profilePreview) {
                    profileInput.addEventListener('change', function () {
                        const file = this.files && this.files[0];
                        if (!file) {
                            return;
                        }

                        profilePreview.src = URL.createObjectURL(file);
                    });

                    profilePreview.addEventListener('error', function () {
                        this.src = defaultAvatar;
                    });
                }

                document.querySelectorAll('[data-password-toggle]').forEach(function (toggleBtn) {
                    toggleBtn.addEventListener('click', function () {
                        var wrap = toggleBtn.closest('.password-toggle-wrap');
                        if (!wrap) {
                            return;
                        }

                        var passwordInput = wrap.querySelector('input');
                        var toggleIcon = toggleBtn.querySelector('i');

                        if (!passwordInput || !toggleIcon) {
                            return;
                        }

                        var isHidden = passwordInput.type === 'password';
                        passwordInput.type = isHidden ? 'text' : 'password';
                        toggleIcon.classList.toggle('fa-eye', !isHidden);
                        toggleIcon.classList.toggle('fa-eye-slash', isHidden);
                        toggleBtn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
                    });
                });
            });
        </script>
	   @endsection
