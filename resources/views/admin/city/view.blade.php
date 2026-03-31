<?php $page="city/view";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">View City</div>
								<form class="form-horizontal">

									<div class="form-group">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">City Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" value="{{ $data ? $data->name : '' }}" readonly>
											</div>
										</div>
									</div>
                                    <div class="form-group">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Country</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" value="{{ $data && $data->country_name ? $data->country_name : '' }}" readonly>
											</div>
										</div>
									</div>
                                    <div class="form-group">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Status</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" value="{{ $data && $data->is_active == 1 ? 'Active' : 'Inactive' }}" readonly>
											</div>
										</div>
									</div>

                                    <div class="card-footer">
                                        <a href="{{ url('city/list') }}"><button type="button" class="btn btn-primary waves-effect waves-light" style="float:right;">Back</button></a>
                                    </div>

								</form>
							</div>

						</div>
					</div>
					<!-- /Col -->
				</div>
				<!-- row closed -->


@endsection

