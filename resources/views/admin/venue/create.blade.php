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
								<form class="form-horizontal"  action="{{ url('venue/store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
									{{-- <div class="mb-4 main-content-label">Name</div> --}}


									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="name" placeholder="Enter name"  value="{{ old('name') }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
                                                {{-- {{ print_r($venue_type) }} --}}
												<label class="form-label">Type</label>
											</div>
											<div class="col-md-6">
                                                <select name="venue_type" class="form-control">
                                                    <option>Select</option>
                                                    @foreach($venue_type as $type)
                                                    <option value="{{ $type->id }}">{{ $type->venue_type_name }}</option>
                                                    @endforeach
                                                </select>
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">location</label>
											</div>
											<div class="col-md-6">
                                                <select name="location" class="form-control select2-select">
                                                    <option>Select</option>
                                                    @foreach($location as $loc)
                                                    <option value="{{ $loc->id }}">{{ $loc->location_name.", ".$loc->name.", ".$loc->country_name }}</option>
                                                    @endforeach
                                                </select>
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Google map link</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="google_map_link" placeholder="Google map link" value="{{ old('google_map_link') }}">
											</div>
										</div>
									</div><div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Latitude</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="latitude" placeholder="Lattitude" value="{{ old('latitude') }}">
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Longitude</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="longitude" placeholder="Longitude" value="{{ old('longitude') }}">
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
                                                    <input type="file" name="image" class="form-control" >
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
