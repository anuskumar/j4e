<?php $page="tickettype/create";?>
@extends('admin.layout.app')
@section('admin_content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">Create Location</div>
								
								@if ($errors->any())
									<div class="alert alert-danger">
										<ul class="mb-0">
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
								
								<form class="form-horizontal"  action="{{ url('location/store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
									{{-- <div class="mb-4 main-content-label">Name</div> --}}


									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Location Name <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control @error('location_name') is-invalid @enderror" name="location_name" placeholder="Enter location name" value="{{ old('location_name') }}" required>
												@error('location_name')
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
												<select name="country" id="country-id" class="form-control select2-select @error('country') is-invalid @enderror" required>
                                                    <option value="">Select</option>
                                                    @foreach($country as $loc)
                                                    <option value="{{ $loc->id }}" {{ old('country') == $loc->id ? 'selected' : '' }}>{{ $loc->country_name }}</option>
                                                    @endforeach
                                                </select>
												@error('country')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">City <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
												<select name="city" required class="form-control @error('city') is-invalid @enderror" id="select2-city">
                                                    <option value="">Select</option>

                                                </select>
												@error('city')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>


                                    <div class="form-group mb-0">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Status</label>
											</div>
											<div class="col-md-6">
												<div class="col-md-6">
                                                    <div class="custom-controls-stacked">
                                                        <label class=""><input  type="radio" value="1" name="is_active" checked><span> Active</span></label>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class=""><input  type="radio" value="0" name="is_active"><span> Inactive</span></label>
                                                    </div>
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
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
                {{-- <script>
                    $(document).ready(function() {
                    $('.select2-select').select2();
                });
                </script> --}}

<script type="text/javascript">
    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

      $( "#select2-city" ).select2({
         ajax: {
           url: "{{url('location/get_cities')}}",
           type: "post",
           dataType: 'json',
           delay: 250,
           data: function (params) {
             return {
                _token: CSRF_TOKEN,
                search: params.term,
                country:$('#country-id').val()
                 // search term
             };
           },
           processResults: function (response) {
             return {
               results: response
             };
           },
           cache: true
         }

      });

    });
    </script>


@endsection
