<?php $page="currency/create";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">Add Currency</div>
								
								@if ($errors->any())
									<div class="alert alert-danger">
										<ul class="mb-0">
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
								
								<form class="form-horizontal"  action="{{ url('currency/store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
									{{-- <div class="mb-4 main-content-label">Name</div> --}}


									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Name <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter currency name" value="{{ old('name') }}" required>
												@error('name')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>

                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Short Name <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control @error('short_name') is-invalid @enderror" name="short_name" placeholder="Enter short name (e.g., USD, EUR)" value="{{ old('short_name') }}" required maxlength="10">
												@error('short_name')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Symbol</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control @error('symbol') is-invalid @enderror" name="symbol" placeholder="Enter currency symbol (e.g., $, €)" value="{{ old('symbol') }}" maxlength="10">
												@error('symbol')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Exchange Rate with 1 USD <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-6">
												<input type="number" step="0.0001" min="0" class="form-control @error('currency_rate') is-invalid @enderror" name="currency_rate" placeholder="Enter exchange rate" value="{{ old('currency_rate') }}" required>
												@error('currency_rate')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
												<small class="form-text text-muted">Enter the exchange rate relative to 1 USD.</small>
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label"> Status</label>
											</div>
											<div class="col-md-6">
												<div class="custom-controls-stacked">
													<label class=""><input  type="radio" checked value="1" name="is_active"><span> Active</span></label>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<label class=""><input  type="radio" value="0" name="is_active"><span> Inactive</span></label>
												</div>
											</div>
										</div>
									</div>



                                    <br>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Create</button>
                                    </div>
								</form>
							</div>

						</div>
					</div>
					<!-- /Col -->
				</div>
				<!-- row closed -->


@endsection
