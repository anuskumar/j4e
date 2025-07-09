<?php $page="currency/update";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
                            <div class="mb-4 main-content-label">update </div>
								<form class="form-horizontal" action="{{url('currency/update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $data->id }}">
									{{-- <div class="mb-4 main-content-label">Name</div> --}}




                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label"> Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="name"  value="{{ $data->name }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label"> Short Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="short_name"  value="{{ $data->short_name }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label"> Symbol</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="symbol"  value="{{ $data->symbol }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label"> Exchange Rate With 1 USD</label>
											</div>
											<div class="col-md-6">
												<input type="number" class="form-control" name="currency_rate" required  value="{{ $data->currency_rate }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Status</label>
											</div>
											<div class="col-md-6">
                                                <div class="col-md-6">
                                                    <div class="custom-controls-stacked">
                                                        <label class=""><input  type="radio" {{ $data->is_active ==1 ? "checked" :'' }} checked value="1" name="is_active"><span> Active</span></label>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class=""><input  type="radio"  {{ $data->is_active ==0 ? "checked" :'' }} value="0" name="is_active"><span> Inactive</span></label>
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
