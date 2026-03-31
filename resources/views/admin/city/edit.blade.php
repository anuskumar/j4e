<?php $page="city/edit";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">Edit City</div>
								
								@if ($errors->any())
									<div class="alert alert-danger">
										<ul class="mb-0">
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
								
								<form class="form-horizontal"  action="{{ url('city/update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
									<input type="hidden" name="id" value="{{ $data->id }}">
									
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">City Name <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter city name" value="{{ old('name', $data->name) }}" required>
												@error('name')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>

                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Country <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
												<select name="country_id" class="form-control @error('country_id') is-invalid @enderror" required>
                                                    <option value="">Select</option>
                                                    @foreach($country_name as $val)
                                                    <option value="{{ $val->id }}" {{ old('country_id', $data->country_id) == $val->id ? 'selected' : '' }}>{{ $val->country_name }}</option>
                                                    @endforeach
                                                </select>
												@error('country_id')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>

                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Status</label>
											</div>
											<div class="col-md-6">
												<div class="custom-controls-stacked">
													<label class=""><input  type="radio" value="1" name="is_active" {{ old('is_active', $data->is_active) == 1 ? 'checked' : '' }}><span> Active</span></label>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<label class=""><input  type="radio" value="0" name="is_active" {{ old('is_active', $data->is_active) == 0 ? 'checked' : '' }}><span> Inactive</span></label>
												</div>
											</div>
										</div>
									</div>

                                    <br>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Update</button>
                                    </div>
								</form>
							</div>

						</div>
					</div>
					<!-- /Col -->
				</div>
				<!-- row closed -->


@endsection

