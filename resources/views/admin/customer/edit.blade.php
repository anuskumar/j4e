<?php $page="customer/update";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">update Customer</div>
								<form class="form-horizontal" action="{{url('customer/update') }}" method="POST">
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
