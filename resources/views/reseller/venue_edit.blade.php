<?php $page = 'artist/create'; ?>
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

                    <div class="row">
                        <div class="col-md-12">
                        <div class="card-body">
                            <h4 class="mb-4">Update Venue</h4>
                            <form class="form-horizontal" action="{{url('reseller/venue_update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                {{-- <div class="mb-4 main-content-label">Name</div> --}}
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Venue Type</label>
                                        </div>
                                        <div class="col-md-6">
                                            {{-- <input type="text" class="form-control"  name="venue_type"  value="{{ $data->venue_type }}"> --}}
                                            <select name="venue_type" class="form-control">
                                                <option>Select</option>
                                                @foreach($venue_type as $type)
                                                <option value="{{ $type->id }}" {{ ($data->venue_type ==  $type->id) ? "selected" :"" }}>{{ $type->venue_type_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Name</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="name"  value="{{ $data->name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Location</label>
                                        </div>
                                        <div class="col-md-6">
                                            {{-- <input type="text" class="form-control" name="location"   value="{{ $data->location }}"> --}}
                                            <select name="location" class="form-control">
                                                <option>Select</option>
                                                @foreach($location as $loc)
                                                <option value="{{ $loc->id }}" {{ ($data->location ==  $loc->id) ? "selected" :"" }}>{{ $loc->location_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Google Link</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="google_map_link"   value="{{ $data->google_map_link }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Image</label>
                                        </div>
                                        <div class="col-md-6">
                                            @if($data->image)
                                                <img alt="" src="{{ asset('storage/uploads/venue/' . $data->image) }}" onerror="this.src='{{ asset('assets/img/default-venue.jpg') }}'">
                                            @else
                                                <img alt="" src="{{ asset('assets/img/default-venue.jpg') }}">
                                            @endif
                                            <br>
                                            <br>
                                            <br>
                                            <input type="file" class="form-control" name="image">
                                        </div>

                                    </div>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Update</button></a>
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
