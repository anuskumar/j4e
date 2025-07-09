<?php $page="events/create";?>
@extends('admin.layout.app')
@section('admin_content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .select2-selection__choice{
        background-color:brown;
    }
</style>
				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">Create Event</div>
								<form class="form-horizontal"  action="{{ url('events/store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
									{{-- <div class="mb-4 main-content-label">Name</div> --}}


									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label"> Event Name</label>
											</div>
											{{-- <div class="col-md-9"> --}}
												{{-- <input type="text" class="form-control" name="event_name" placeholder="Enter name"  value="{{ old('name') }}"> --}}
											<div class="col-md-6">
												<input type="text" required class="form-control" name="event_name" placeholder="Enter name"  value="{{ old('name') }}">
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
                                                    <option value="{{ $val->id }}">{{ $val->tag_name }}</option>
                                                    @endforeach
                                                </select>
											</div>
										</div>
									</div>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
                                                {{-- {{ print_r($venue_type) }} --}}
												<label class="form-label"> Event Type</label>
											</div>
                                            {{-- {{ print_r($event_type) }} --}}
											<div class="col-md-6">
                                                <select name="event_type" class="form-control" required>
                                                    <option>Select</option>
                                                    @foreach($event_type as $type)
                                                    <option value="{{ $type->id }}">{{ $type->event_type_name }}</option>
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
                                                    <option value="{{ $ven->id }}">{{ $ven->venue_name." [ ".$ven->location_name." ,".$ven->city_name." ,".$ven->country_name." ] " }}</option>
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
                                                    <option value="{{ $art->id }}">{{ $art->artist_name.' [ '.$art->field_name.' ]' }}</option>
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
                                                    <input type="date" class="form-control" required name="event_from_date">
                                        </div>
										</div>
									</div>
                                  <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Event To</label>
                                            </div>
                                                <div class="col-md-6">
                                                    <input type="date" class="form-control" required name="event_to_date">
                                        </div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Event Description</label>
                                            </div>
                                                <div class="col-md-6">
                                                <textarea class="form-control" name="event_desc" rows="2" >{{ old('event_desc') }}</textarea>

                                        </div>
										</div>
									</div>

									<div class="form-group mb-0">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Image(1500px*700px)</label>

											</div>
											<div class="col-md-6">
												<div class="custom-controls-stacked">
                                                    <input type="file" name="event_image" class="form-control" >
												</div>
											</div>

										</div>
									</div><br>
                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label"> Event Status</label>
											</div>
											<div class="col-md-6">
												<div class="custom-controls-stacked">
													<label class=""><input  type="radio" checked value="1" name="event_is_active"><span> Active</span></label>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<label class=""><input  type="radio" value="0" name="event_is_active"><span> Inactive</span></label>
												</div>
											</div>
										</div>
									</div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Create Events</button>
                                    </div>
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
