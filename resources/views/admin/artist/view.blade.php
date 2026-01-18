<?php $page="tickettype/view";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label" >View Artist</div>
								<form class="form-horizontal">

									{{-- <div class="mb-4 main-content-label">Name</div> --}}
									<div class="form-group " >
										<div class="row">
											<div class="col-md-3">
												<label class="form-label" class="form-control">Artist Name</label>
											</div>
											<div class="col-md-6">
											 <input type="text" class="form-control" value="{{ $data ? $data->artist_name : '' }}" readonly>
											</div>
										</div>
									</div>
                                    <div class="form-group " >
										<div class="row">
											<div class="col-md-3">
												<label class="form-label" class="form-control">Artist field</label>
											</div>
											<div class="col-md-6">
											 <input type="text" class="form-control" value="{{ $data ? $data->field: '' }}" readonly>
											</div>
										</div>
									</div>
                                    <div class="form-group " >
										<div class="row">
											<div class="col-md-3">
												<label class="form-label" class="form-control">Contact Number</label>
											</div>
											<div class="col-md-6">
											 <input type="text" class="form-control" value="{{ $data ? $data->contact_number : '' }}" readonly>
											</div>
										</div>
									</div>
                                    <div class="form-group " >
										<div class="row">
											<div class="col-md-3">
												<label class="form-label" class="form-control">About</label>
											</div>
											<div class="col-md-6">
											 <input type="text" class="form-control" value="{{ $data ? $data->about : '' }}" readonly>
											</div>
										</div>
									</div>


                                    <div class="card-footer">
                                        <a href="{{ url('admin/artist/list') }}"><button type="button" class="btn btn-primary waves-effect waves-light" style="float:right;">Back</button></a>
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
