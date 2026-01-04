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
                            <h4 class="mb-4">Create Venue</h4>
                            <form class="form-horizontal"  action="{{ url('reseller/venue_store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                {{-- <div class="mb-4 main-content-label">Name</div> --}}


                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Name</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="name" placeholder="Enter name"  value="{{ old('name') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            {{-- {{ print_r($venue_type) }} --}}
                                            <label class="form-label">Type <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="venue_type" class="form-control @error('venue_type') is-invalid @enderror" required>
                                                <option value="">Select</option>
                                                @foreach($venue_type as $type)
                                                <option value="{{ $type->id }}" {{ old('venue_type') == $type->id ? 'selected' : '' }}>{{ $type->venue_type_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('venue_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">location</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="location" class="form-control select2-select">
                                                <option>Select</option>
                                                @foreach($location as $loc)
                                                <option value="{{ $loc->id }}">{{ $loc->location_name.", ".$loc->name.", ".$loc->country_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Google map link</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="google_map_link" placeholder="Google map link" value="{{ old('google_map_link') }}">
                                        </div>
                                    </div>
                                </div><div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Latitude</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="latitude" placeholder="Lattitude" value="{{ old('latitude') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Longitude</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="longitude" placeholder="Longitude" value="{{ old('longitude') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Image</label>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="custom-controls-stacked">
                                                <input type="file" name="image" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Create Venue</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>


        </div>


    </div>
    <!-- /Page Content -->

@endsection
