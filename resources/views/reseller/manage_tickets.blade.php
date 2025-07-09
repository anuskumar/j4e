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
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mb-4">Customer Events</h4>
                            <div class="appointment-tab">

                                <!-- Appointment Tab -->
                                <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">

                                    <li class="nav-item">
                                        <a class="btn ripple btn-info nav-item" style="float:right;"
                                            href="{{ url('reseller/ticket_create') }}">Create Tickets</a>
                                    </li>

                                </ul>
                                <!-- /Appointment Tab -->

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
                                                            <img alt=""
                                                                src="{{ Storage::disk('image')->url('uploads/events/' . $val->event_image) }}">
                                                        </td>
                                                        <td>
                                                            <a href="{{ url('tickets/manage_tickets', $val->id) }}"><button type="button"
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
