<?php $page = 'ticket_events'; ?>
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

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Events</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="file-datatable"
                                    class="border-top-0 dataTables  table table-bordered text-nowrap key-buttons border-bottom">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th class="border-bottom-0">Event Name</th>
                                            <th class="border-bottom-0">Event Type</th>
                                            <th class="border-bottom-0">Event Date</th>
                                            <th class="border-bottom-0"> Location</th>
                                            <th class="border-bottom-0"> Venue</th>
                                            <th class="border-bottom-0"> Image</th>
                                            <th class="border-bottom-0">Event Status</th>
                                            <th class="border-bottom-0">Tickets</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($data as $val)
                                            <tr>
                                                <td>{{ $no++ }}</td>

                                                <td>{{ $val->event_name }}</td>
                                                <td>{{ $val->event_type_name }}</td>

                                                <td>{{ $val->event_from_date ? date('d-m-Y', strtotime($val->event_from_date)) : '' }}
                                                    - {{ $val->event_to_date ? date('d-m-Y', strtotime($val->event_to_date)) : '' }}
                                                </td>
                                                <td>{{ $val->location_name.' '.$val->city_name.' ,'.$val->country_name }}</td>
                                                <td>{{ $val->venue_name }}</td>
                                                {{-- <td>{{ $val->name }}</td> --}}
                                                <td>
                                                    {{-- {{ $val->image }} --}}
                                                    <img alt="event image" style="width: 50px;"
                                                        src="{{ Storage::disk('image')->url('uploads/events/' . $val->event_image) }}">
                                                </td>
                                                <td>
                                                    <a href="{{ url('reseller/manage_tickets', $val->id) }}"><button type="button"
                                                            class="btn btn-primary">Manage</button></a>
                                                </td>

                                                <td>{{ $val->event_is_active == 1 ? 'Active' : 'Inactive' }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{-- {!! $data->links() !!} --}}
                                </div>
                            </div>
                        </div>

                        {{-- <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  ...
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                              </div>
                            </div>
                          </div> --}}






                    </div>
                </div>


            </div>


        </div>


    </div>
    <!-- /Page Content -->

    </div>
@endsection
