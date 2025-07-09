<?php $page="reseller/requestevent";?>
@extends('layout.mainlayout')
@section('content')

{{-- <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel" style="padding-left: 0px 900px">
    <div class="carousel-inner">
        <div class="carousel-item active d-block" style="background-color: #022F5C">
            <img src="{{ Storage::disk('image')->url('uploads/events/' . @$event_datas->event_image) }}" class="d-block w-100" alt="Your Image Description">
        </div>
    </div>
</div> --}}
				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
                    <div class="col-lg-3">
                    </div>
					<div class="col-lg-6">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label"><h4>Request Event</h4></div>
								<form class="form-horizontal" action="{{ route('reseller.requesteventstore') }}" method="POST">
                                    @csrf
									{{-- <div class="mb-4 main-content-label">Name</div> --}}
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label"> Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="name" >
											</div>
										</div>
									</div>

									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Email</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="email">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label"> Event Details</label>
											</div>
											<div class="col-md-6">
												<textarea class="form-control" name="event_details" rows="2" ></textarea>
											</div>
										</div>
									</div>
									{{-- <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Password</label>
											</div>
											<div class="col-md-6">
												<input type="password" class="form-control" name="password" placeholder="password" value="{{ old('password') }}">
											</div>
										</div>
									</div> --}}
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Phone</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="phone" >
											</div>
										</div>
									</div>
									{{-- <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Address</label>
											</div>
											<div class="col-md-6">
												<textarea class="form-control" name="address" rows="2"  placeholder="Address">{{ old('address') }}</textarea>
											</div>
										</div>
									</div> --}}

									{{-- <div class="form-group mb-0">
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
									</div> --}}
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Send Request</button>
                                    </div>
								</form>
							</div>

						</div>
					</div>
                    <div class="col-lg-3">
                    </div>
					<!-- /Col -->
				</div>
				<!-- row closed -->


@endsection
