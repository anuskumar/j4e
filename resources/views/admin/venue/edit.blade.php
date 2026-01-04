<?php $page="venue/update";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">update Venue</div>
								<form class="form-horizontal" action="{{url('venue/update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $data->id }}">
									{{-- <div class="mb-4 main-content-label">Name</div> --}}
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Venue Type <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
												{{-- <input type="text" class="form-control"  name="venue_type"  value="{{ $data->venue_type }}"> --}}
                                                <select name="venue_type" class="form-control @error('venue_type') is-invalid @enderror" required>
                                                    <option value="">Select</option>
                                                    @foreach($venue_type as $type)
                                                    <option value="{{ $type->id }}" {{ ($data->venue_type ==  $type->id) ? "selected" :"" }}>{{ $type->venue_type_name }}</option>
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
												<label class="form-label">Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="name"  value="{{ $data->name }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Location</label>
											</div>
											<div class="col-md-6">
												{{-- <input type="text" class="form-control" name="location"   value="{{ $data->location }}"> --}}
                                                <select name="location" class="form-control">
                                                    <option>Select</option>
                                                    @foreach($location as $loc)
                                                    <option value="{{ $loc->id }}" {{ ($data->location ==  $loc->id) ? "selected" :"" }}>{{ $loc->location_name }}</option>
                                                    @endforeach
                                                </select>
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Google Link</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="google_map_link"   value="{{ $data->google_map_link }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Image</label>
											</div>
											<div class="col-md-6">
                                                @if($data->image)
                                                    <img alt="" src="{{ asset('storage/uploads/venue/' . $data->image) }}" onerror="this.src='{{ asset('assets/img/default-venue.jpg') }}'">
                                                @else
                                                    <img alt="" src="{{ asset('assets/img/default-venue.jpg') }}">
                                                @endif
                                                <br>
                                                <br>
                                                <br>
												<input type="file" class="form-control" name="image">
											</div>
										</div>
									</div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Update</button></a>
                                </div>
								</form>

						</div>
					</div>
					<!-- /Col -->
				</div>
				<!-- row closed -->


@endsection
