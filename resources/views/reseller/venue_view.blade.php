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
                            <h4 class="mb-4">View Venue</h4>
                            <form class="form-horizontal">

                                {{-- <div class="mb-4 main-content-label">Name</div> --}}
                                <div class="form-group " >
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label" class="form-control">Name</label>
                                        </div>
                                        <div class="col-md-6">
                                         <input type="text" class="form-control" value="{{ $data ? $data->name : '' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Venue Type</label>
                                        </div>
                                        <div class="col-md-6">
                                        <input type="text" class="form-control" value="{{ $data ? $data->venue_type_name: '' }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">location</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" value="{{ $data ? $data->location_name : '' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Google map</label>
                                        </div>
                                        <div class="col-md-6">
                                            <textarea class="form-control" value="Address" readonly>
                                                {{ $data ? $data->google_map_link : '' }}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <a href="{{ url('reseller/manage_venue') }}"><button type="button" class="btn btn-primary waves-effect waves-light" style="float:right;">Back</button></a>
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

            </div>


        </div>


    </div>
    <!-- /Page Content -->

@endsection
