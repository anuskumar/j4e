<?php $page="venue/list";?>
@extends('admin.layout.app')
@section('admin_content')

	<!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manage Seatings</h3>
                    <div class="card-body" style="float:right;">

                        <a class="btn ripple btn-info" data-bs-target="#modaldemo3" data-bs-toggle="modal" href="#">Create Seating</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="file-datatable"  class="border-top-0 dataTables  table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th class="border-bottom-0">Seating Type</th>
                                    <th class="border-bottom-0">image</th>
                                    <th class="border-bottom-0">Total Seats</th>
                                    <th class="border-bottom-0">Serial Prefix</th>
                                    <th class="border-bottom-0">Seat Serial Starts</th>
                                    <th class="border-bottom-0">Seat Serial Ends</th>
                                    <th class="border-bottom-0">Desc</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data as $val)
                                <tr>
                                    <td>{{ $no++ }}</td>

                                    <td>{{ $val->seating_type_name }}</td>
                                    <td>
                                        {{-- {{ $val->image }} --}}
                                        <img alt="" src="{{ Storage::disk('image')->url('uploads/venue_seating/' . $val->seating_image) }}">
                                    </td>
                                    <td>{{ $val->number_of_seats }}</td>
                                    <td>{{ $val->seat_serial_prefix }}</td>
                                    <td>{{ $val->seat_serial_start }}</td>
                                    <td>{{ $val->seat_serial_end }}</td>
                                    <td>{{ $val->seating_type_desc }}</td>
                                    <td>

                                        {{ $val->is_active==1 ? "Active" :"Inactive" }}
                                    </td>
                                    <td>
                                        <form action="{{ url('venue/delete_venue_seating',$val->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        {{-- <a href="{{url('venue/view',$val->id)}}"><button type="button" class="btn btn-primary">view</button></a> --}}
                                        <a href="{{url('venue/edit_seating',$val->id)}}"><button type="button" class="btn btn-info">Edit</button></a>

                                            {{-- <a href=""><button type="button" class="btn btn-danger" class="btn btn-danger show_confirm">Delete</button></a> --}}
                                            <button type="submit" class="btn btn-danger show_confirm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                        {{-- {!! $data->links() !!} --}}
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal" id="modaldemo3">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">Create Seating</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
                         <div class="card-body">
                            <div class="mb-4 main-content-label"></div>
                            <form class="form-horizontal"  action="{{ url('venue/store_seating') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                {{-- <div class="mb-4 main-content-label">Name</div> --}}

                               <input type="hidden" name="venue" value="{{ $id }}">
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Name</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="seating_type_name" required   value="{{ old('seating_type_name') }}">
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
                                            <input type="number" class="form-control" name="number_of_seats" required  value="{{ old('number_of_seats') }}">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label"> Seat Number Prefix</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="seat_serial_prefix" required   value="{{ old('seat_serial_prefix') }}">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Seat Serial Starting Number</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" required class="form-control" name="seat_serial_start"  value="{{ old('seat_serial_start') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Seat Serial Ending Number</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" required class="form-control" name="seat_serial_end"  value="{{ old('seat_serial_start') }}">
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
                                                {{ old('seating_type_desc') }}
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
                                                <input type="file" name="seating_image" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn ripple btn-secondary" style="float: right; margin-left:10px;" data-bs-dismiss="modal" type="button">Close</button>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Create Seatings</button>
                                </div>
                                <br>
                            </form>
                        </div>

                        </div>
					<div class="modal-footer">

					</div>
				</div>
			</div>
		</div>




    </div>
    <script src="admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="admin_assets/js/main.js"></script>
    <!-- End Row -->


@include('datatable.datatable_js')
@endsection
