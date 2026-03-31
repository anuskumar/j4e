<?php $page="admin/artist/edit";?>
@extends('admin.layout.app')
@section('admin_content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">update Artist</div>
								<form class="form-horizontal" action="{{url('admin/artist/update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $data->id }}">
									{{-- <div class="mb-4 main-content-label">Name</div> --}}

                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label"> Artist Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" class="form-control" name="artist_name"  value="{{ $data->artist_name }}">
											</div>
										</div>
									</div>


									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">artist Field</label>
											</div>
											<div class="col-md-6">
												{{-- <input type="text" class="form-control"  name="venue_type"  value="{{ $data->venue_type }}"> --}}
                                                <select name="field" class="form-control">
                                                    <option>Select</option>
                                                    @foreach($artist_create as $type)
                                                    <option value="{{ $type->id }}" {{ ($data->artist_create ==  $type->id) ? "selected" :"" }}>{{ $type->field_name }}</option>
                                                    @endforeach
                                                </select>
											</div>
										</div>
									</div>


                                     <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Contact Number</label>
                                            </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" value="{{ $data->contact_number }}"  required name="contact_number">
                                        </div>
										</div>
									</div>


                                    <div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">About</label>
											</div>
											<div class="col-md-6">
                                                <input type="text" class="form-control" value="{{ $data->about }}"  required name="about">
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
