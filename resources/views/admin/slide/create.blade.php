<?php $page = "slide/create";?>

@extends('admin.layout.app')

@section('admin_content')
<!-- row -->
<div class="row row-sm">
    <!-- Col -->
    <div class="col-lg-10">
        <div class="card">
            <div class="card-body">
                <div class="mb-4 main-content-label">Create Banner Slide</div>
                <form class="form-horizontal" action="{{ url('slide/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Banner Image -->
                    <div class="form-group mb-0">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Banner Image(1500*700 px)</label>
                            </div>
                            <div class="col-md-9">
                                <div class="custom-controls-stacked">
                                    <input type="file" name="slide_image" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <!-- Meta Description -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Meta Description</label>
                            </div>
                            <div class="col-md-9">
                                <textarea class="form-control" name="meta_description" rows="2" placeholder="Address"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Events</label>
                            </div>
                            <div class="col-md-6">
                                <select name="event" class="form-control select2-select">
                                    <option>Select</option>
                                    @foreach ( $events as $event)
                                    <option value="{{ $event->id }}"> {{ $event->event_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="form-group mb-0">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                            </div>
                            <div class="col-md-9">
                                <div class="custom-controls-stacked">
                                    <label class=""><input type="radio" value="1" name="is_active" checked><span> Active</span></label>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class=""><input type="radio" value="0" name="is_active"><span> Inactive</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <!-- Submit Button -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Create Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Col -->
</div>
<!-- row closed -->
@endsection
