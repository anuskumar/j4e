<?php $page = 'manage_events'; ?>
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
                                        <a class="nav-link active" href="#upcoming-appointments" data-toggle="tab">All</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#today-appointments" data-toggle="tab">Upcomming</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="btn ripple btn-info nav-item" style="float:right;"
                                            href="{{ url('reseller/create_event') }}">Create Events</a>
                                    </li>

                                </ul>
                                <!-- /Appointment Tab -->

                                <div class="tab-content">

                                    <!-- Upcoming Appointment Tab -->
                                    <div class="tab-pane show active" id="upcoming-appointments">
                                        <div class="card card-table mb-0">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Name </th>
                                                                <th>Event Date</th>
                                                                <th>Type</th>
                                                                <th>Location</th>
                                                                <th class="text-center">Venue</th>
                                                                <th class="text-center">Event Timings</th>
                                                                <th>Images</th>
                                                                <th>Status</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            @foreach ($all as $val)
                                                                <tr>
                                                                    <td>
                                                                        <h2 class="table-avatar">
                                                                            <a href="customer-profile"
                                                                                class="avatar avatar-sm mr-2">
                                                                                <img class="avatar-img rounded-circle"
                                                                                    src="{{ Storage::disk('image')->url('uploads/events/' . $val->event_image) }}"
                                                                                   ></a>
                                                                            <a
                                                                                href="customer-profile">{{ $val->event_name }}<span></span></a>
                                                                        </h2>
                                                                    </td>
                                                                    <td>
                                                                        {{ $val->event_from_date ? date('d-m-Y', strtotime($val->event_from_date)) : '' }}
                                                                       <br> -
                                                                        {{ $val->event_to_date ? date('d-m-Y', strtotime($val->event_to_date)) : '' }}
                                                                        {{-- <span class="d-block text-info">6.00 PM</span> --}}
                                                                    </td>
                                                                    <td>{{ $val->event_type_name }}</td>
                                                                    <td>{{ $val->location_name}} <br> {{ $val->city_name}} <br> {{ $val->country_name }}
                                                                    </td>
                                                                    <td class="text-center">{{ $val->venue_name }}</td>
                                                                    <td class="text-center"> <a
                                                                            href="{{ url('events/event_timings', $val->id) }}"><button
                                                                                type="button"
                                                                                class="btn btn-primary">Manage</button></a>
                                                                    </td>
                                                                    <td class="text-center"> <a
                                                                            href="{{ url('reseller/multi_images', $val->id) }}"><button
                                                                                type="button"
                                                                                class="btn btn-primary">Manage</button></a>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $val->event_is_active == 1 ? 'Active' : 'Inactive' }}
                                                                    </td>

                                                                        <td>
                                                                            <form action="{{ url('reseller/destroy',$val->id) }}" method="POST">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                            <a href="{{url('reseller/event_view',$val->id)}}"><button type="button" class="btn btn-primary">view</button></a>
                                                                            <a href="{{url('reseller/event_edit',$val->id)}}"><button type="button" class="btn btn-info">Edit</button></a>
                                                                                {{-- <a href=""><button type="button" class="btn btn-danger" class="btn btn-danger show_confirm">Delete</button></a> --}}
                                                                                <button type="submit" class="btn btn-danger show_confirm">Delete</button>
                                                                            </form>
                                                                        </td>
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Upcoming Appointment Tab -->

                                    <!-- Today Appointment Tab -->
                                    <div class="tab-pane" id="today-appointments">
                                        <div class="card card-table mb-0">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Name </th>
                                                                <th>Event Date</th>
                                                                <th>Type</th>
                                                                <th>Location</th>
                                                                <th class="text-center">Venue</th>
                                                                <th class="text-center">Event Timings</th>
                                                                <th>Images</th>
                                                                <th>Status</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            @foreach ($upcomming as $val)
                                                                <tr>
                                                                    <td>
                                                                        <h2 class="table-avatar">
                                                                            <a href="customer-profile"
                                                                                class="avatar avatar-sm mr-2">
                                                                                <img class="avatar-img rounded-circle"
                                                                                    src="{{ Storage::disk('image')->url('uploads/events/' . $val->event_image) }}"
                                                                                   ></a>
                                                                            <a
                                                                                href="customer-profile">{{ $val->event_name }}<span></span></a>
                                                                        </h2>
                                                                    </td>
                                                                    <td>
                                                                        {{ $val->event_from_date ? date('d-m-Y', strtotime($val->event_from_date)) : '' }}
                                                                       <br> -
                                                                        {{ $val->event_to_date ? date('d-m-Y', strtotime($val->event_to_date)) : '' }}
                                                                        {{-- <span class="d-block text-info">6.00 PM</span> --}}
                                                                    </td>
                                                                    <td>{{ $val->event_type_name }}</td>
                                                                    <td>{{ $val->location_name}} <br> {{ $val->city_name}} <br> {{ $val->country_name }}
                                                                    </td>
                                                                    <td class="text-center">{{ $val->venue_name }}</td>
                                                                    <td class="text-center"> <a
                                                                            href="{{ url('events/event_timings', $val->id) }}"><button
                                                                                type="button"
                                                                                class="btn btn-primary">Manage</button></a>
                                                                    </td>
                                                                    <td class="text-center"> <a
                                                                            href="{{ url('events/multi_images', $val->id) }}"><button
                                                                                type="button"
                                                                                class="btn btn-primary">Manage</button></a>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $val->event_is_active == 1 ? 'Active' : 'Inactive' }}
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <div class="table-action">
                                                                            <a href="javascript:void(0);"
                                                                                class="btn btn-sm bg-info-light">
                                                                                <i class="far fa-eye"></i> View
                                                                            </a>

                                                                            <a href="javascript:void(0);"
                                                                                class="btn btn-sm bg-success-light">
                                                                                <i class="fas fa-check"></i> Edit
                                                                            </a>
                                                                            <a href="javascript:void(0);"
                                                                                class="btn btn-sm bg-danger-light">
                                                                                <i class="fas fa-times"></i> Delete
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Today Appointment Tab -->

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
