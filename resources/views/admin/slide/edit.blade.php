<?php $page="slide/update";?>
@extends('admin.layout.app')
@section('admin_content')

				<!-- row -->
				<div class="row row-sm">

					<!-- Col -->
					<div class="col-lg-10">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">update Slide</div>
                                <form class="form-horizontal" action="{{ route('slide.update', ['id' => request()->route('id')]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $data->id }}">
									{{-- <div class="mb-4 main-content-label">Name</div> --}}


                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Banner Image</label>
                                            </div>
                                            <div class="col-md-6">
                                                <img alt="" width="100" height="100" src="{{ Storage::disk('image')->url('uploads/slide/'. $data->slide_image) }}">
                                                <input type="file" class="form-control"  placeholder="banner" name="slide_image">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Meta Description</label>
                                            </div>
                                            <div class="col-md-6">
                                                {{-- <input type="textarea" class="form-control"  placeholder="About company" value="Web Designer"> --}}
                                                <textarea class="form-control"  name="meta_description" placeholder="" value="{{ $data-> meta_description }}" >
{{ $data-> meta_description }}
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
                                                <div class="col-md-6">
                                                    <div class="custom-controls-stacked">
                                                        <label class=""><input  type="radio" {{ $data->event_is_active ==1 ? "checked" :'' }} checked value="1" name="is_active"><span> Active</span></label>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class=""><input  type="radio"  {{ $data->event_is_active ==0 ? "checked" :'' }} value="0" name="is_active"><span> Inactive</span></label>
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


@endsection
