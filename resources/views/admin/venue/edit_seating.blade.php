<?php $page="venue/update";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">Edit</div>

                                <form class="form-horizontal"  action="{{ url('venue/update_Seating') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- <div class="mb-4 main-content-label">Name</div> --}}

                                   <input type="hidden" name="id" value="{{ $data->id }}">
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="seating_type_name" required   value="{{ $data->seating_type_name }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                {{-- {{ print_r($venue_type) }} --}}
                                                <label class="form-label">Total Number</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="number" class="form-control" name="number_of_seats" required  value="{{$data->number_of_seats }}">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label"> Seat Number Prefix</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="seat_serial_prefix" required   value="{{ $data->seat_serial_prefix}}">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Seat Serial Starting Number</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="number" required class="form-control" name="seat_serial_start"  value="{{$data->seat_serial_start}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Seat Serial Ending Number</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="number" required class="form-control" name="seat_serial_end"  value="{{$data->seat_serial_end}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Description</label>
                                            </div>
                                            <div class="col-md-6">

                                                 <textarea class="form-control" name="seating_type_desc">
                                                    {{ $data->seating_type_desc }}
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

                                                {!! Form::radio('is_active',true,1) !!} Active
                                                {!! Form::radio('is_active',false,0) !!} Inactive

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Image</label>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="custom-controls-stacked">
                                                    @if($data->seating_image)
                                                        <img alt="" src="{{ asset('storage/uploads/venue_seating/' . $data->seating_image) }}" onerror="this.src='{{ asset('assets/img/default-seating.jpg') }}'">
                                                    @else
                                                        <img alt="" src="{{ asset('assets/img/default-seating.jpg') }}">
                                                    @endif
                                                    <br><br>
                                                    <input type="file" name="seating_image" class="form-control" ><br><br>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn ripple btn-secondary" style="float: right; margin-left:10px;" data-bs-dismiss="modal" type="button">Close</button>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Update</button>
                                    </div>
                                    <br>
                                </form>
						</div>
					</div>
					<!-- /Col -->
				</div>
				<!-- row closed -->


@endsection
