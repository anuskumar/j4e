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

                    @include('layout.re_sidebar');

                    <!-- /Profile Sidebar -->

                </div>

                <div class="col-md-8 col-lg-8 col-xl-9">

                    <div class="row">
                        <div class="col-md-12">
                        <div class="card-body">
                            <h4 class="mb-4">Create Artist</h4>
                            <form class="form-horizontal"  action="{{ url('reseller/artist_store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                {{-- <div class="mb-4 main-content-label">Name</div> --}}


                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Artist Name <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="artist_name" value="{{ old('artist_name') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Artist Field <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="field" class="form-control" required>
                                                <option>Select</option>
                                                @foreach($artist_create as $type)
                                                <option value="{{ $type->id }}">{{ $type->field_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="contact_number" value="{{ old('contact_number') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">About</label>
                                        </div>
                                        <div class="col-md-6">
                                            <textarea class="form-control"  name="about"  value="{{ old('about') }}" >

                                            </textarea>

                                        </div>
                                    </div>
                                </div>



                                <br>

                                <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Create Artist</button>
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
