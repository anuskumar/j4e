<?php $page="eventtags/create";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">Create EventTag</div>
								<form class="form-horizontal"  action="{{ url('eventtags/store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
									{{-- <div class="mb-4 main-content-label">Name</div> --}}


									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Event Tag name</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="tag_name" placeholder="Enter name"  value="{{ old('tag_name') }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Event Tag Image</label>
											</div>
											<div class="col-md-6">
												<input type="file" class="form-control" name="tag_image">
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
													<label class=""><input  type="radio" value="1" name="is_active"><span> Active</span></label>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<label class=""><input  type="radio" value="0" name="is_active"><span> Inactive</span></label>
												</div>
											</div>
											</div>
										</div>
									</div>
                                    <br>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Create Tag</button>
                                    </div>
								</form>
							</div>

						</div>
					</div>
					<!-- /Col -->
				</div>
				<!-- row closed -->


@endsection
