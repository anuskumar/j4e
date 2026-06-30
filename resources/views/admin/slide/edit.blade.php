<?php $page="slide/update";?>
@extends('admin.layout.app')
@section('admin_content')

<style>
    .slide-image-guidelines {
        border: 1px solid #b6d4fe;
        background: #e7f1ff;
        color: #084298;
    }

    .slide-image-guidelines .fe {
        color: #0d6efd;
    }

    .slide-current-image {
        width: 100%;
        max-width: 480px;
        aspect-ratio: {{ \App\Models\SliderModel::RECOMMENDED_WIDTH }} / {{ \App\Models\SliderModel::RECOMMENDED_HEIGHT }};
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e8ebf3;
        display: block;
        margin-bottom: 12px;
    }
</style>

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
                                            <div class="col-md-9">
                                                @include('admin.slide.partials.image_size_guidelines')

                                                @if($data->slide_image)
                                                    <img alt="Current slide image" class="slide-current-image" src="{{ asset('storage/uploads/slide/' . $data->slide_image) }}" onerror="this.src='{{ asset('assets/img/default-slide.jpg') }}'">
                                                @endif

                                                <label class="form-label" for="slide_image">Upload new image</label>
                                                <input type="file" class="form-control" id="slide_image" name="slide_image" accept="image/jpeg,image/png,image/jpg,image/webp">
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
                                                <label class="form-label">Text Color</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="me-3">
                                                    <input type="radio" name="text_color" value="white"
                                                        {{ old('text_color', $data->text_color ?? 'white') === 'white' ? 'checked' : '' }}>
                                                    <span> White</span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="text_color" value="black"
                                                        {{ old('text_color', $data->text_color ?? 'white') === 'black' ? 'checked' : '' }}>
                                                    <span> Black</span>
                                                </label>
                                                @error('text_color')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
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
                                                        <label class=""><input  type="radio" {{ ($data->is_active ?? 1) == 1 ? "checked" : '' }} value="1" name="is_active"><span> Active</span></label>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class=""><input  type="radio"  {{ ($data->is_active ?? 1) == 0 ? "checked" : '' }} value="0" name="is_active"><span> Inactive</span></label>
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
