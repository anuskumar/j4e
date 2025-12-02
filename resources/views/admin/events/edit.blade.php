<?php $page="events/update";?>
@extends('admin.layout.app')
@section('admin_content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">update Event</div>
								<form class="form-horizontal" action="{{url('events/update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $data->id }}">
									{{-- <div class="mb-4 main-content-label">Name</div> --}}

                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label"> Event Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="event_name"  value="{{ $data->event_name }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label"> Event Tag</label>
											</div>

											<div class="col-md-6">
                                                <select name="event_tag" class="form-control select2-select" required>
                                                    <option>Select</option>
                                                    @foreach($eventTags as $val)
                                                    <option value="{{ $val->id }}" {{ $val->id == $data->event_tag ? "selected" : "" }}>{{ $val->tag_name }}</option>
                                                    @endforeach
                                                </select>
											</div>
										</div>
									</div>


									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Event Type</label>
											</div>
											<div class="col-md-6">
												{{-- <input type="text" class="form-control"  name="venue_type"  value="{{ $data->venue_type }}"> --}}
                                                <select name="event_type" class="form-control">
                                                    <option>Select</option>
                                                    @foreach($event_type as $type)
                                                    <option value="{{ $type->id }}" {{ ($data->event_type ==  $type->id) ? "selected" :"" }}>{{ $type->event_type_name }}</option>
                                                    @endforeach
                                                </select>
											</div>
										</div>
									</div>

                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label"> Venue</label>
											</div>

											<div class="col-md-6">
                                                <select name="venue" class="form-control select2-select" required>
                                                    <option>Select</option>
                                                    @foreach($venue as $ven)
                                                    <option value="{{ $ven->id }}" {{ $ven->id == $data->venue ? "selected" :"" }}>{{ $ven->venue_name." [ ".$ven->location_name." ,".$ven->city_name." ,".$ven->country_name." ] " }}</option>
                                                    @endforeach
                                                </select>
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label"> Artists</label>
											</div>

											<div class="col-md-6">
                                                <select name="artists[]" multiple class="form-control select2-select">
                                                    {{-- <option>Select</option> --}}
                                                    @foreach($artists as $art)
                                                    <option value="{{ $art->id }}"
                                                      {{-- @if(!$data['artists']==''||!$data['artists']==null) --}}
                                                      @if(is_null($data['artists'])==false)
                                                        {{ in_array(@$art->id,json_decode(@$data->artists)) ? "selected" :"" }}
                                                      @endif
                                                        >{{ @$art->artist_name.' [ '.@$art->field_name.' ]' }}</option>
                                                    @endforeach
                                                </select>
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Event From</label>
                                            </div>
                                                <div class="col-md-6">
                                                    <input type="date" class="form-control" value="{{ $data->event_from_date }}" required name="event_from_date">
                                        </div>
										</div>
									</div>
                                     <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Event To</label>
                                            </div>
                                                <div class="col-md-6">
                                                    <input type="date" class="form-control" value="{{ $data->event_to_date }}"  required name="event_to_date">
                                        </div>
										</div>
									</div>

                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Description</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="event_desc"   value="{{ $data->event_desc }}">
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Image</label>
											</div>
											<div class="col-md-6">
                                                @if($data->event_image)
                                                    <img alt="" src="{{ asset('storage/uploads/events/' . $data->event_image) }}" onerror="this.src='{{ asset('assets/img/default-event.jpg') }}'">
                                                @else
                                                    <img alt="" src="{{ asset('assets/img/default-event.jpg') }}">
                                                @endif
                                                <br>
                                                <br>
                                                <br>
                                                <input type="file" name="event_image" class="form-control" >
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
                                                        <label class=""><input  type="radio" {{ $data->event_is_active ==1 ? "checked" :'' }} checked value="1" name="event_is_active"><span> Active</span></label>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class=""><input  type="radio"  {{ $data->event_is_active ==0 ? "checked" :'' }} value="0" name="event_is_active"><span> Inactive</span></label>
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

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

<script>
    $(document).ready(function() {
    $('.select2-select').select2();
});
</script>

@endsection
