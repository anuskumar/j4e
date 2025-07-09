<?php $page="events/edit_eventtimings";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">Edit Event Timings</div>
								<form class="form-horizontal" action="{{url('events/update_timings') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $data->id }}">
									{{-- <div class="mb-4 main-content-label">Name</div> --}}
									<div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Event Date</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" class="form-control" name="event_date" required   value="{{ $data->event_date }}">
                                            </div>
                                        </div>
                                        <br>

                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label"> Event Time From</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="time" class="form-control" name="from_time" required   value="{{ $data->from_time }}">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Event Time To</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="time" required class="form-control" name="to_time" required  value="{{ $data->to_time }}">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Status</label>
                                            </div>
                                            <div class="col-md-6">

                                                {!! Form::radio('is_active',true,1) !!} Active
                                                {!! Form::radio('is_active',false,0) !!} Inactive

                                            </div>
                                        </div>
                                    </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Update</button>
                                </div>
								</form>

						</div>
					</div>
					<!-- /Col -->
				</div>
				<!-- row closed -->


@endsection
