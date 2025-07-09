<?php $page="artist/create";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">Create Artist</div>
								<form class="form-horizontal"  action="{{ url('artist/store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
									{{-- <div class="mb-4 main-content-label">Name</div> --}}


									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Artist Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="artist_name"   value="{{ old('artist_name') }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Artist Field</label>
											</div>
											<div class="col-md-6">
												<select name="field" class="form-control" required>
                                                    <option>Select</option>
                                                    @foreach($artist_create as $type)
                                                    <option value="{{ $type->id }}">{{ $type->field_name }}</option>
                                                    @endforeach
                                                </select>
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Contact Number</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="contact_number"   value="{{ old('contact_number') }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">About</label>
											</div>
											<div class="col-md-6">
                                                <textarea class="form-control"  name="about"  value="{{ old('about') }}" >

                                                </textarea>

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


@endsection
