<?php $page="eventtag/update";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">update EventTag</div>
								<form class="form-horizontal" action="{{url('eventtags/update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $tagdata->id }}">
									{{-- <div class="mb-4 main-content-label">Name</div> --}}
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">EventTag Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="tag_name"  value="{{ $tagdata->tag_name }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Image</label>
											</div>
											<div class="col-md-6">
                                                <img alt="" src="{{ Storage::disk('image')->url('uploads/event_tag_images/' . $tagdata->tag_image) }}" width="200">
                                                <br>
                                                <hr>
												<input type="file" class="form-control" name="tag_image" >
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
                                                    <div class="custom-controls-stacked">
                                                        <label class="">
                                                            <input type="radio" {{ $tagdata->is_active == 1 ? 'checked' : '' }} value="1" name="is_active">
                                                            <span> Active</span>
                                                        </label>
                                                        &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class="">
                                                            <input type="radio" {{ $tagdata->is_active == 0 ? 'checked' : '' }} value="0" name="is_active">
                                                            <span> Inactive</span>
                                                        </label>
                                                    </div>

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
