<?php $page="location/update";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">update Location</div>
								<form class="form-horizontal" action="{{url('location/update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $data->id }}">
									{{-- <div class="mb-4 main-content-label">Name</div> --}}




                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Location Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="location_name"  value="{{ $data->location_name }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Country</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="country"  value="{{ $data->country }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">City</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="city"  value="{{ $data->city }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Status</label>
											</div>
											<div class="col-md-6">
												{{-- <input type="text" class="form-control" name="location"   value="{{ $data->location }}"> --}}

                                                <div class="custom-controls-stacked">
                                                    <label class=""><input  type="radio" value="1" name="is_active"><span> Active</span></label>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<label class=""><input  type="radio" value="0" name="is_active"><span> Inactive</span></label>
                                                </div>

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
