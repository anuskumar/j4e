<?php $page="currency/view";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label" >View Currency</div>
								<form class="form-horizontal">

									{{-- <div class="mb-4 main-content-label">Name</div> --}}
									<div class="form-group " >
										<div class="row">
											<div class="col-md-3">
												<label class="form-label" class="form-control"> Name</label>
											</div>
											<div class="col-md-6">
											 <input type="text" class="form-control" value="{{ $data ? $data->name : '' }}" readonly>
											</div>
										</div>
									</div>
                                    <div class="form-group " >
										<div class="row">
											<div class="col-md-3">
												<label class="form-label" class="form-control"> Short Name</label>
											</div>
											<div class="col-md-6">
											 <input type="text" class="form-control" value="{{ $data ? $data->short_name : '' }}" readonly>
											</div>
										</div>
									</div>
                                    <div class="form-group " >
										<div class="row">
											<div class="col-md-3">
												<label class="form-label" class="form-control"> Symbol</label>
											</div>
											<div class="col-md-6">
											 <input type="text" class="form-control" value="{{ $data ? $data->symbol : '' }}" readonly>
											</div>
										</div>
									</div>
                                    <div class="form-group " >
										<div class="row">
											<div class="col-md-3">
												<label class="form-label" class="form-control"> Exchange Rate With 1 USD</label>
											</div>
											<div class="col-md-6">
											 <input type="text" class="form-control" value="{{ $data ? $data->currency_rate : '' }}" readonly>
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
                                        <a href="{{ url('currency/list') }}"><button type="button" class="btn btn-primary waves-effect waves-light" style="float:right;">Back</button></a>
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
