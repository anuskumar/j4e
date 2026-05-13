<?php $page="location/update";?>
@extends('admin.layout.app')
@section('admin_content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- row -->
<div class="row row-sm">
	<!-- Col -->
	<div class="col-lg-10">
		<div class="card">
			<div class="card-body">
				<div class="mb-4 main-content-label">Update Location</div>

				@if ($errors->any())
					<div class="alert alert-danger">
						<ul class="mb-0">
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<form class="form-horizontal" action="{{ url('location/update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="id" value="{{ $data->id }}">

					<div class="form-group ">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label">Location Name <span class="text-danger">*</span></label>
							</div>
							<div class="col-md-6">
								<input type="text" class="form-control @error('location_name') is-invalid @enderror" name="location_name" value="{{ old('location_name', $data->location_name) }}" required>
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
									@foreach($countries as $country)
										<option value="{{ $country->id }}" {{ old('country', $data->country) == $country->id ? 'selected' : '' }}>{{ $country->country_name }}</option>
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
									@foreach($cities as $city)
										<option value="{{ $city->id }}" {{ old('city', $data->city) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
									@endforeach
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
								<div class="custom-controls-stacked">
									<label class="">
										<input type="radio" value="1" name="is_active" {{ (string) old('is_active', $data->is_active) === '1' ? 'checked' : '' }}>
										<span> Active</span>
									</label>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<label class="">
										<input type="radio" value="0" name="is_active" {{ (string) old('is_active', $data->is_active) === '0' ? 'checked' : '' }}>
										<span> Inactive</span>
									</label>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
<script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){
      $("#select2-city").select2({
         ajax: {
           url: "{{ url('location/get_cities') }}",
           type: "post",
           dataType: 'json',
           delay: 250,
           data: function (params) {
             return {
                _token: CSRF_TOKEN,
                search: params.term,
                country: $('#country-id').val()
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
