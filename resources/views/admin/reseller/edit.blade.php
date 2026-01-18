<?php $page="admin/reseller/edit";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">update Reseller</div>
								<form class="form-horizontal" action="{{url('admin/reseller/update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $data->id }}">
									{{-- <div class="mb-4 main-content-label">Name</div> --}}
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control"  name="name" placeholder="User Name" value="{{ $data->name }}">
											</div>
										</div>
									</div>


									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Email</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="email"  placeholder="Email" value="{{ $data->email }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Phone</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="phone"  placeholder="phone" value="{{ $data->phone }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Address</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="address"  placeholder="Address" value="{{ $data->address }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Is Approved ?</label>
											</div>
											<div class="col-md-6">

                                                 <select name="is_admin_approved" class="form-control">
                                                    <option value="1" {{ ($data->is_admin_approved == 1) ? "Selected" :'' }}>Yes</option>
                                                    <option value="0" {{ ($data->is_admin_approved == 0) ? "Selected" :'' }}>No</option>
                                                 </select>
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Is Trusted ?</label>
											</div>
											<div class="col-md-6">
                                                <select name="is_trusted" class="form-control">
                                                    <option value="1" {{ ($data->is_trusted == 1) ? "Selected" :'' }}>Yes</option>
                                                    <option value="0" {{ ($data->is_trusted == 0) ? "Selected" :'' }}>No</option>
                                                 </select>
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Is Active ?</label>
											</div>
											<div class="col-md-6">
                                                <select name="is_active" class="form-control">
                                                    <option value="1" {{ ($data->is_active == 1) ? "Selected" :'' }}>Yes</option>
                                                    <option value="0" {{ ($data->is_active == 0) ? "Selected" :'' }}>No</option>
                                                 </select>
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
