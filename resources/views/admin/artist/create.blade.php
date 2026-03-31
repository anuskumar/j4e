<?php $page="admin/artist/create";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">Create Artist</div>
								
								@if ($errors->any())
									<div class="alert alert-danger">
										<ul class="mb-0">
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif

								<form class="form-horizontal"  action="{{ url('admin/artist/store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
									{{-- <div class="mb-4 main-content-label">Name</div> --}}


									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Artist Name <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control @error('artist_name') is-invalid @enderror" name="artist_name" placeholder="Artist Name" value="{{ old('artist_name') }}" required>
												@error('artist_name')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Artist Field <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
												<select name="field" class="form-control @error('field') is-invalid @enderror" required>
                                                    <option value="">Select Artist Field</option>
                                                    @foreach($artist_create as $type)
                                                    <option value="{{ $type->id }}" {{ old('field') == $type->id ? 'selected' : '' }}>{{ $type->field_name }}</option>
                                                    @endforeach
                                                </select>
												@error('field')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Contact Number <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
												<input type="tel" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" placeholder="Contact Number" value="{{ old('contact_number') }}" pattern="[0-9\-\s()]+" required>
												@error('contact_number')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">About</label>
											</div>
											<div class="col-md-6">
                                                <textarea class="form-control @error('about') is-invalid @enderror" name="about" rows="3" placeholder="About">{{ old('about') }}</textarea>
												@error('about')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>



                                    <br>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Create Artist</button>
                                    </div>
								</form>
							</div>

						</div>
					</div>
					<!-- /Col -->
				</div>
				<!-- row closed -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form.form-horizontal');
    const selectField = document.querySelector('select[name="field"]');
    
    if (form && selectField) {
        form.addEventListener('submit', function(e) {
            // Validate select field
            if (!selectField.value || selectField.value === '') {
                e.preventDefault();
                selectField.classList.add('is-invalid');
                if (!selectField.nextElementSibling || !selectField.nextElementSibling.classList.contains('invalid-feedback')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback d-block';
                    errorDiv.textContent = 'Please select an artist field.';
                    selectField.parentElement.appendChild(errorDiv);
                }
                selectField.focus();
                return false;
            } else {
                selectField.classList.remove('is-invalid');
                const errorDiv = selectField.parentElement.querySelector('.invalid-feedback.d-block');
                if (errorDiv) {
                    errorDiv.remove();
                }
            }
            
            // Validate artist name
            const artistName = document.querySelector('input[name="artist_name"]');
            if (!artistName.value.trim()) {
                e.preventDefault();
                artistName.classList.add('is-invalid');
                artistName.focus();
                return false;
            }
            
            // Validate contact number
            const contactNumber = document.querySelector('input[name="contact_number"]');
            if (!contactNumber.value.trim()) {
                e.preventDefault();
                contactNumber.classList.add('is-invalid');
                contactNumber.focus();
                return false;
            }
        });
        
        // Remove invalid class on change for select
        selectField.addEventListener('change', function() {
            if (this.value) {
                this.classList.remove('is-invalid');
                const errorDiv = this.parentElement.querySelector('.invalid-feedback.d-block');
                if (errorDiv) {
                    errorDiv.remove();
                }
            }
        });
    }
});
</script>

@endsection
