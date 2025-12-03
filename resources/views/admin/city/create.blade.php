<?php $page="city/create";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">Add City</div>
								
								@if ($errors->any())
									<div class="alert alert-danger">
										<ul class="mb-0">
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
								
								<form class="form-horizontal"  action="{{ url('city/store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
									{{-- <div class="mb-4 main-content-label">Name</div> --}}


									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">City Name <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter city name" value="{{ old('name') }}" required>
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
                                                    <option value="{{ $val->id }}" {{ old('country_id') == $val->id ? 'selected' : '' }}>{{ $val->country_name }}</option>
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
												<label class="form-label"> Status</label>
											</div>
											<div class="col-md-6">
												<div class="custom-controls-stacked">
													<label class=""><input  type="radio" checked value="1" name="is_active"><span> Active</span></label>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<label class=""><input  type="radio" value="0" name="is_active"><span> Inactive</span></label>
												</div>
											</div>
										</div>
									</div>



                                    <br>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Create</button>
                                    </div>
								</form>
							</div>

						</div>
					</div>
					<!-- /Col -->
				</div>
				<!-- row closed -->


@endsection
