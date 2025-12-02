<?php $page = 'manage_venue'; ?>
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
                            <h4 class="mb-4">Venue</h4>
                            <div class="appointment-tab">

                                <!-- Appointment Tab -->
                                <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
                                    {{-- <li class="nav-item">
                                        <a class="nav-link active" href="#upcoming-appointments" data-toggle="tab">All</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#today-appointments" data-toggle="tab">Upcomming</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a class="btn ripple btn-info nav-item" style="float:right;"
                                            href="{{ url('reseller/venue_create') }}">Create Venue</a>
                                    </li>

                                </ul>
                                <!-- /Appointment Tab -->


                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="file-datatable"  class="border-top-0 dataTables  table table-bordered text-nowrap key-buttons border-bottom">
                                                        <thead>
                                                            <tr>
                                                                <th>Sl</th>
                                                                <th class="border-bottom-0">Venue Type</th>
                                                                <th class="border-bottom-0">Image</th>
                                                                <th class="border-bottom-0">Name</th>
                                                                <th class="border-bottom-0">Location</th>
                                                                <th class="border-bottom-0">google link</th>
                                                                {{-- <th class="border-bottom-0">Latitude</th>
                                                                <th class="border-bottom-0">Longitude</th> --}}
                                                                <th class="border-bottom-0">Total Seats</th>
                                                                <th class="border-bottom-0">Toal Seat Types</th>
                                                                <th class="border-bottom-0">Seating</th>
                                                                <th class="border-bottom-0">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            @foreach ($data as $val)
                                                            <tr>
                                                                <td>{{ $no++ }}</td>

                                                                <td>{{ $val->venue_type_name }}</td>
                                                                <td>
                                                                    {{-- {{ $val->image }} --}}
                                                                    @if($val->image)
                                                                        <img alt="venue image" style="width:50px;" src="{{ asset('storage/uploads/venue/' . $val->image) }}" onerror="this.src='{{ asset('assets/img/default-venue.jpg') }}'">
                                                                    @else
                                                                        <img alt="venue image" style="width:50px;" src="{{ asset('assets/img/default-venue.jpg') }}">
                                                                    @endif
                                                                </td>
                                                                <td>{{ $val->venue_name }}</td>
                                                                <td>{{ $val->location_name }}</td>
                                                                <td>
                                                                    <a href="{{ $val->google_map_link }}"> Link </a></td>
                                                                {{-- <td>{{ $val->latitude }}</td>
                                                                <td>{{ $val->longitude }}</td> --}}
                                                                <td>{{ $val->total_seats }}</td>
                                                                <td>{{ $val->total_seat_types }}</td>
                                                                <td>
                                                                    <a href="{{url('venue/manage_Seating',$val->id)}}"><button type="button" class="btn btn-primary">Manage</button></a>

                                                                </td>

                                                                <td>
                                                                    <form action="{{ url('reseller/destroy',$val->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    <a href="{{url('reseller/venue_view',$val->id)}}"><button type="button" class="btn btn-primary">view</button></a>
                                                                    <a href="{{url('reseller/venue_edit',$val->id)}}"><button type="button" class="btn btn-info">Edit</button></a>
                                                                        {{-- <a href=""><button type="button" class="btn btn-danger" class="btn btn-danger show_confirm">Delete</button></a> --}}
                                                                        <button type="submit" class="btn btn-danger show_confirm">Delete</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <div class="d-flex justify-content-center">
                                                    {{-- {!! $data->links() !!} --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

           </div>




        </div>


    </div>
    <!-- /Page Content -->

    </div>
@endsection
