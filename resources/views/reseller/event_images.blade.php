<?php $page = 'event_images'; ?>
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

                <div class="row">
                    <div class="col-lg-12 col-xl-12">
                        <h4 class="mb-4">Image List</h4>
                        {{-- <div class="row">
                            <div class="col-10">
                                <div class="tx-20 mb-4  text-white">
                                    Images List
                                </div>
                            </div>
                            <div class="col-2 col-auto file-1">
                                <div class="input-group mb-2">
                                    {{-- <input type="text" class="form-control rounded-3  br-te-0 br-be-0" placeholder="Search folder....."> --}}
                                    {{-- <span class="input-group-text bg-transparent p-0 border-0 rounded-3 br-ts-0 br-bs-0 "> --}}

                                    {{-- </span> --}}
                                {{-- </div>
                            </div>
                        </div> --}}
                        <div class="nav-item">
                            <a class="btn ripple btn-info nav-item" style="float:right;"
                                href="{{ url('reseller/event_images') }}"  data-bs-target="#modaldemo4" data-bs-toggle="modal">Add Images</a>
                        </div>

                            <div class="row">

                                @foreach($data as $val)
                                <div class="col-xl-3 col-md-4 col-sm-6">
                                    <div class="card p-0 ">
                                        <div class="d-flex align-items-center px-3 pt-3">
                                            <div class="float-end ms-auto">
                                                <a href="javascript:void(0);" class="option-dots" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>
                                                <div class="dropdown-menu rounded-7">
                                                    {{-- <a class="dropdown-item" href="javascript:void(0);"><i class="fe fe-edit me-2"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i class="fe fe-share me-2"></i> Share</a> --}}

                                                    <a class="dropdown-item" href="{{ url('events/delete_images'.'/'.$val->id) }}"><i class="fe fe-trash me-2 "></i> Delete</a>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0 text-center">
                                            <div class="file-manger-icon">

                                                    <img src="{{ Storage::disk('image')->url('uploads/events/' . $val->image) }}" alt="img" class="rounded-7">

                                            </div>
                                            {{-- <h6 class="mb-1 font-weight-semibold">videos</h6>
                                            <span class="text-muted">4.23gb</span> --}}
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                        </div>

                    </div>
                    <div class="modal" id="modaldemo4">
                        <div class="modal-dialog modal-lg" role="document">
                            <form action="{{ url('reseller/upload_event_images') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="event" value="{{ $id }}">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">Upload Images </h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                @csrf
                                <div class="modal-body">
                                    <div>
                                        <input  type="file"  name="image[]" multiple>
                                    </div>                                   </div>
                                <div class="modal-footer">
                                    <button class="btn ripple btn-primary" type="submit" type="button">Upload</button>
                                    <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>


    </div>
    <!-- /Page Content -->

@endsection
