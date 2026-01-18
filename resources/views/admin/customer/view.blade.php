<?php $page="admin/customer/view";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label" >View Customer</div>
								<form class="form-horizontal">

									{{-- <div class="mb-4 main-content-label">Name</div> --}}
									<div class="form-group " >
										<div class="row">
											<div class="col-md-3">
												<label class="form-label" class="form-control">Name</label>
											</div>
											<div class="col-md-6">
											 <input type="text" class="form-control" value="{{ $data ? $data->name : '' }}" readonly>
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Email</label>
											</div>
											<div class="col-md-6">
										    <input type="text" class="form-control" value="{{ $data ? $data->email : '' }}" readonly>
											</div>
										</div>
									</div>

                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">PhoneNumber</label>
											</div>
											<div class="col-md-6">
                                                <input type="text" class="form-control" value="{{ $data ? $data->phone : '' }}" readonly>
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Address</label>
											</div>
											<div class="col-md-6">
                                                <textarea class="form-control" value="Address" readonly>{{ $data ? $data->address : '' }}
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
                                        <a href="{{ url('admin/customer/list') }}"><button type="button" class="btn btn-primary waves-effect waves-light" style="float:right;">Back</button></a>
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
