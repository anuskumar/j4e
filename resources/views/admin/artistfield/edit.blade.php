<?php $page="artistfield/update";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">update ArtistField</div>
								<form class="form-horizontal" action="{{url('artistfield/update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $data->id }}">
									{{-- <div class="mb-4 main-content-label">Name</div> --}}




                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">ArtistField Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="field_name"  value="{{ $data->field_name }}">
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
