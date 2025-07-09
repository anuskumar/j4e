<?php $page="slide/view";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label" >View slide</div>
								<form class="form-horizontal">

									{{-- <div class="mb-4 main-content-label">Name</div> --}}
									<div class="form-group " >
										<div class="row">
											<div class="col-md-3">
												<label class="form-label" class="form-control">Banner Image</label>
											</div>
											<div class="col-md-6">
                                                <img alt="" width="100" height="100" src="{{ Storage::disk('image')->url('uploads/slide/'. $data->slide_image) }}">
											</div>
										</div>
									</div>



                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Meta Description</label>
											</div>
											<div class="col-md-6">
                                                <textarea class="form-control" value="meta_description" readonly>
                                                    {{ $data ? $data->meta_description : '' }}
                                                </textarea>
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Status</label>
											</div>
											<div class="col-md-6">
                                                <input type="text" class="form-control" value="{{ $data->is_active == 1 ? "Active" :"Inactive" }}" readonly>
											</div>
										</div>
									</div>

                                    <div class="card-footer">
                                        <a href="{{ url('slide/list') }}"><button type="button" class="btn btn-primary waves-effect waves-light" style="float:right;">Back</button></a>
                                    </div>
                                    {{-- <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">email</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control"  placeholder="User Name" value="Redashna">
											</div>
										</div>
									</div> --}}


								</form>
							</div>

						</div>
					</div>
					<!-- /Col -->
				</div>
				<!-- row closed -->


@endsection
