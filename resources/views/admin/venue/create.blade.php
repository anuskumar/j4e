<?php $page="venue/create";?>
@extends('admin.layout.app')
@section('admin_content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">Create Venue</div>
								
								@if ($errors->any())
									<div class="alert alert-danger">
										<ul class="mb-0">
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
								
								<form class="form-horizontal"  action="{{ url('venue/store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
									{{-- <div class="mb-4 main-content-label">Name</div> --}}


									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Name <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter venue name" value="{{ old('name') }}" required>
												@error('name')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
                                                {{-- {{ print_r($venue_type) }} --}}
                                                <label class="form-label">Type <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
                                                <select name="venue_type" class="form-control @error('venue_type') is-invalid @enderror" required>
                                                    <option value="">Select</option>
                                                    @foreach($venue_type as $type)
                                                    <option value="{{ $type->id }}" {{ old('venue_type') == $type->id ? 'selected' : '' }}>{{ $type->venue_type_name }}</option>
                                                    @endforeach
                                                </select>
												@error('venue_type')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Location <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
                                                <select name="location" class="form-control select2-select @error('location') is-invalid @enderror" required>
                                                    <option value="">Select</option>
                                                    @foreach($location as $loc)
                                                    <option value="{{ $loc->id }}" {{ old('location') == $loc->id ? 'selected' : '' }}>{{ $loc->location_name.", ".$loc->name.", ".$loc->country_name }}</option>
                                                    @endforeach
                                                </select>
												@error('location')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Google Map Link</label>
											</div>
											<div class="col-md-6">
												<input type="url" class="form-control @error('google_map_link') is-invalid @enderror" name="google_map_link" placeholder="https://maps.google.com/..." value="{{ old('google_map_link') }}">
												@error('google_map_link')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Latitude</label>
											</div>
											<div class="col-md-6">
												<input type="number" step="0.000001" class="form-control @error('latitude') is-invalid @enderror" name="latitude" placeholder="Enter latitude" value="{{ old('latitude') }}">
												@error('latitude')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Longitude</label>
											</div>
											<div class="col-md-6">
												<input type="number" step="0.000001" class="form-control @error('longitude') is-invalid @enderror" name="longitude" placeholder="Enter longitude" value="{{ old('longitude') }}">
												@error('longitude')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>

									<div class="form-group mb-0">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Image</label>
											</div>
											<div class="col-md-6">
												<div class="custom-controls-stacked">
                                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
													@error('image')
														<div class="invalid-feedback">{{ $message }}</div>
													@enderror
													<small class="form-text text-muted">Upload venue image (JPG, PNG, etc.)</small>
												</div>
											</div>
										</div>
									</div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Create Venue</button>
                                    </div>
								</form>
							</div>

						</div>
					</div>
					<!-- /Col -->
				</div>
				<!-- row closed -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
                <script>
                    $(document).ready(function() {
                    $('.select2-select').select2();
                });
                </script>
@endsection
