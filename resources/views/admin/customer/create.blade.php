<?php $page="customer/create";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">Create Customer</div>
								<form class="form-horizontal" action="{{ url('customer/store') }}" method="POST">
                                    @csrf
									{{-- <div class="mb-4 main-content-label">Name</div> --}}
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">User Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="name"  placeholder="User Name" value="{{ old('name') }}">
											</div>
										</div>
									</div>

									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Email</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Password</label>
											</div>
											<div class="col-md-6">
												<input type="password" class="form-control" name="password" placeholder="password" value="{{ old('password') }}">
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Phone</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="phone" placeholder="phone number" value="{{ old('phone') }}">
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Address</label>
											</div>
											<div class="col-md-6">
												<textarea class="form-control" name="address" rows="2"  placeholder="Address">{{ old('address') }}</textarea>
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
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Create Customer</button>
                                    </div>
								</form>
							</div>

						</div>
					</div>
					<!-- /Col -->
				</div>
				<!-- row closed -->


@endsection
