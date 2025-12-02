<?php $page = 'events/list'; ?>
@extends('admin.layout.app')
@section('admin_content')
{{-- @extends('layouts.reseller_app') --}}
{{-- @section('content') --}}
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Events</h3>
                </div>
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin: 0 auto;">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link " href="{{ route('reseller.mylistings') }}">My Listings</a>
      <a class="nav-item nav-link" href="#">My Sales</a>

    </div>
  </div>
</nav>
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
                                    {{-- <th class="border-bottom-0">Tickets</th> --}}

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data as $val)
                                @if($val)
                                    @if(Auth::user()->user_type == 'reseller')
                                        @if($val->my_tickets>0)
                                        <tr>
                                            <td>{{ $no++ }}</td>

                                            <td>
                                                {{ $val->event_name }}
                                                @if($val->waiting_for_approval>0)
                                                ( {{ $val->waiting_for_approval.' Waiting ' }})
                                                @endif
                                            </td>
                                            <td>{{ $val->event_type_name }}</td>

                                            <td>{{ $val->event_from_date ? date('d-m-Y', strtotime($val->event_from_date)) : '' }}
                                                - {{ $val->event_to_date ? date('d-m-Y', strtotime($val->event_to_date)) : '' }}
                                            </td>
                                            <td>{{ $val->location_name.''.$val->city_name.' ,'.$val->country_name }}</td>
                                            <td>{{ $val->venue_name }}</td>

                                            <td>

                                                <img alt=""
                                                    @if($val->event_image)
                                                        src="{{ asset('storage/uploads/events/' . $val->event_image) }}"
                                                    @else
                                                        src="{{ asset('assets/img/default-event.jpg') }}"
                                                    @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('tickets/manage_tickets', $val->id) }}"><button type="button"
                                                        class="btn btn-primary">Manage</button></a>
                                            </td>



                                        </tr>
                                        @endif
                                    @else
                                    <tr>
                                        <td>{{ $no++ }}</td>

                                        <td>
                                            {{ $val->event_name }}
                                            @if($val->waiting_for_approval>0)
                                            ( {{ $val->waiting_for_approval.' Waiting ' }})
                                            @endif
                                        </td>
                                        <td>{{ $val->event_type_name }}</td>

                                        <td>{{ $val->event_from_date ? date('d-m-Y', strtotime($val->event_from_date)) : '' }}
                                            - {{ $val->event_to_date ? date('d-m-Y', strtotime($val->event_to_date)) : '' }}
                                        </td>
                                        <td>{{ $val->location_name.' '.$val->city_name.' ,'.$val->country_name }}</td>
                                        <td>{{ $val->venue_name }}</td>
                                        {{-- <td>{{ $val->name }}</td> --}}
                                        <td>
                                            {{-- {{ $val->image }} --}}
                                        <img src="{{ config('app.storage') ."uploads/events/". $val->event_image }}"  alt="img">

                                            {{-- <img alt="" src="{{ Storage::disk('image')->url('uploads/events/' . $val->event_image) }}"> --}}
                                        </td>
                                        <td>
                                            <a href="{{ url('tickets/manage_tickets', $val->id) }}"><button type="button"
                                                    class="btn btn-primary">Manage</button></a>
                                        </td>
                                        {{-- <td>{{ $val->event_is_active == 1 ? 'Active' : 'Inactive' }}</td> --}}

                                    </tr>
                                    @endif

                                    @endif
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
    <script src="admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="admin_assets/js/main.js"></script>
    <!-- End Row -->


    @include('datatable.datatable_js')
@endsection
