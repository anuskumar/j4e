<?php $page="reseller/event_timings";?>
@extends('admin.layout.app')
@section('admin_content')

	<!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manage Timings</h3>
                    <div class="card-body" style="float:right;">

                        <a class="btn ripple btn-info" data-bs-target="#modaldemo3" data-bs-toggle="modal" href="#">Create Timing</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="file-datatable"  class="border-top-0 dataTables  table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th>Sl</th>

                                    <th class="border-bottom-0">Date</th>
                                    <th class="border-bottom-0">From time</th>
                                    <th class="border-bottom-0">To Time</th>
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
                                    <td>{{ date('D d M Y',strtotime($val->event_date)) }}</td>
                                    <td>{{ date('H:i',strtotime($val->from_time)) }}</td>
                                    <td>{{ date('H:i',strtotime($val->to_time)) }}</td>
                                    <td>

                                        {{ $val->is_active==1 ? "Active" :"Inactive" }}
                                    </td>
                                    <td>
                                        <form action="{{ url('events/delete_timings',$val->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        {{-- <a href="{{url('venue/view',$val->id)}}"><button type="button" class="btn btn-primary">view</button></a> --}}
                                        <a href="{{url('events/edit_timings',$val->id)}}"><button type="button" class="btn btn-info">Edit</button></a>

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
						<h6 class="modal-title">Create Timing</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
                         <div class="card-body">
                            <div class="mb-4 main-content-label"></div>
                            <form class="form-horizontal"  action="{{ url('events/store_timings') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                {{-- <div class="mb-4 main-content-label">Name</div> --}}

                               <input type="hidden" name="event" value="{{ $id }}">
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Event Date</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="date" class="form-control" name="event_date" required   value="{{ old('event_date') }}">
                                        </div>
                                    </div>
                                    <br>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label"> Event Time From</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="time" class="form-control" name="from_time" required   value="{{ old('from_time') }}">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Event Time To</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="time" required class="form-control" name="to_time" required  value="{{ old('to_time') }}">
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
                                    <button class="btn ripple btn-secondary" style="float: right; margin-left:10px;" data-bs-dismiss="modal" type="button">Close</button>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Create Timing</button>
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
