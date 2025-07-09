<?php $page = 'event_view'; ?>
@extends('layout.mainlayout')
@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Dashboard</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Page Content -->
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-md-4 col-lg-4 col-xl-3 theiaStickySidebar">

                    <!-- Profile Sidebar -->

                    @include('layout.re_sidebar')

                    <!-- /Profile Sidebar -->

                </div>

              <div class="col-md-8 col-lg-8 col-xl-9">
                <div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
                                <h4 class="mb-4">View Event</h4>
								{{-- <div class="mb-4 main-content-label" >View Event</div> --}}
								<form class="form-horizontal"  action="{{ url('reseller/event_view') }}" method="POST" enctype="multipart/form-data" >

									{{-- <div class="mb-4 main-content-label">Name</div> --}}
									<div class="form-group " >
										<div class="row">
											<div class="col-md-3">
												<label class="form-label" class="form-control">Event Name</label>
											</div>
											<div class="col-md-6">
											 <input type="text" class="form-control" value="{{ $data ? $data->event_name : '' }}" readonly>
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Event Type</label>
											</div>
											<div class="col-md-6">
										    <input type="text" class="form-control" value="{{ $data ? $data->event_type_name: '' }}" readonly>
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Venue</label>
											</div>
											<div class="col-md-6">
										    <input type="text" class="form-control"
                                            value="{{ $data ? $data->venue_name: '' }}" readonly>
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Location</label>
											</div>
											<div class="col-md-6">
										    <input type="text" class="form-control"
                                            value='{{ $data->location_name." ".$data->city_name." ,".$data->country_name }}' readonly>
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Artists</label>
											</div>
											<div class="col-md-6">
                                                <select name="artists" multiple class="form-control select2-select">
                                                    {{-- <option>Select</option> --}}
                                                    @foreach($artists as $art)
                                                    <option value="{{ $art->id }}"
                                                        @if($data->artists) {{ in_array($art->id,json_decode($data->artists)) ? "selected" :"" }}
                                                        @endif>{{ $art->artist_name.' [ '.$art->field_name.' ]' }}</option>
                                                    @endforeach
                                                </select>
											</div>
										</div>
									</div>

                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Date</label>
											</div>
											<div class="col-md-6">
										    <input type="text" class="form-control"
                                            value='{{$data->event_from_date ? date('d-m-Y',strtotime($data->event_from_date)) : ''}}  to  {{ $data->event_to_date ? date('d-m-Y',strtotime($data->event_to_date)) : '' }}' readonly>
											</div>
										</div>
									</div>


                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Description</label>
											</div>
											<div class="col-md-6">
                                                <input type="text" class="form-control" value="{{ $data ? $data->event_desc : '' }}" readonly>
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Event Image</label>
											</div>
											<div class="col-md-6">
                                                 <img alt="" src="{{ Storage::disk('image')->url('uploads/events/' . @$data->event_image) }}">
                                                <br>
                                                <br>
                                                <br>

											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Status</label>
											</div>
											<div class="col-md-6">
                                                <input type="text" class="form-control" value="{{ $data->event_is_active == 1 ? "Active" :"Inactive" }}" readonly>
											</div>
										</div>
									</div>

                                    <div class="card-footer">
                                        <a href="{{ url('reseller/manage_event') }}"><button type="button" class="btn btn-primary waves-effect waves-light" style="float:right;">Back</button></a>
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


        </div>


    </div>
    <!-- /Page Content -->

@endsection
