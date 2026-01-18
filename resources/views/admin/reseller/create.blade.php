<?php $page="admin/reseller/create";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">Create Reseller</div>
								
								@if ($errors->any())
									<div class="alert alert-danger">
										<ul class="mb-0">
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif

								<form class="form-horizontal" action="{{ url('admin/reseller/store') }}" method="POST">
                                    @csrf
									{{-- <div class="mb-4 main-content-label">Name</div> --}}
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label"> Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="name"  placeholder="User Name" value="{{ old('name') }}">
											</div>
										</div>
									</div>

									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Email <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
												<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required>
												@error('email')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Password <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
												<div class="position-relative">
													<input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="password" value="{{ old('password') }}" required minlength="6">
													<button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3" onclick="togglePassword()" style="border: none; background: none; z-index: 10;">
														<i class="far fa-eye" id="passwordToggleIcon"></i>
													</button>
												</div>
												@error('password')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
												<small class="form-text text-muted">Password must be at least 6 characters long.</small>
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Phone <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
												<div class="input-group">
													<select class="form-control select2-select @error('country_code') is-invalid @enderror" name="country_code" id="country_code" style="max-width: 200px;" data-placeholder="Select Country">
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
													<input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Phone Number" value="{{ old('phone') }}" pattern="[0-9\-\s()]+" required>
												</div>
												@error('phone')
													<div class="invalid-feedback d-block">{{ $message }}</div>
												@enderror
												@error('country_code')
													<div class="invalid-feedback d-block">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Address</label>
											</div>
											<div class="col-md-6">
												<textarea class="form-control" name="address" rows="2"  placeholder="Address">{{ old('address') }}</textarea>
											</div>
										</div>
									</div>

									<div class="form-group mb-0">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Status</label>
											</div>
											<div class="col-md-6">
												<div class="custom-controls-stacked">
													<label class=""><input  type="radio" value="1" name="is_active" checked><span> Active</span></label>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<label class=""><input  type="radio" value="0" name="is_active"><span> Inactive</span></label>
												</div>
											</div>
										</div>
									</div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Create Reseller</button>
                                    </div>
								</form>
							</div>

						</div>
					</div>
					<!-- /Col -->
				</div>
				<!-- row closed -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const passwordToggleIcon = document.getElementById('passwordToggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordToggleIcon.classList.remove('fa-eye');
        passwordToggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        passwordToggleIcon.classList.remove('fa-eye-slash');
        passwordToggleIcon.classList.add('fa-eye');
    }
}

$(document).ready(function() {
    $('#country_code').select2({
        placeholder: 'Select Country Code',
        allowClear: false,
        width: '200px',
        minimumResultsForSearch: 0
    });
});
</script>

@endsection
