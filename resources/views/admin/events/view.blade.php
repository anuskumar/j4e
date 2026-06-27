<?php $page="event/view";?>
@extends('admin.layout.app')
@section('admin_content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label" >View Event</div>
								<form class="form-horizontal" >

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
												<label class="form-label">Customer Fee (%)</label>
											</div>
											<div class="col-md-6">
                                                <input type="text" class="form-control" value="{{ $data->customer_fee_percent ?? 0 }}%" readonly>
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
                                                 @if(@$data->event_image)
                                                     <img alt="" src="{{ asset('storage/uploads/events/' . $data->event_image) }}" onerror="this.src='{{ asset('assets/img/default-event.jpg') }}'">
                                                 @else
                                                     <img alt="" src="{{ asset('assets/img/default-event.jpg') }}">
                                                 @endif
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
                                        <a href="{{ url('events/list') }}"><button type="button" class="btn btn-primary waves-effect waves-light" style="float:right;">Back</button></a>
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

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

<script>
    $(document).ready(function() {
    $('.select2-select').select2();
});
</script>
@endsection
