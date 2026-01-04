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
                                    <th class="border-bottom-0">Event Status</th>
                                    <th class="border-bottom-0">Action</th>
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
                                                @if($val->event_image)
                                                    <a href="{{ asset('storage/uploads/events/' . $val->event_image) }}" target="_blank" title="View Image">
                                                        <i class="far fa-image fa-2x text-primary"></i>
                                                    </a>
                                                @else
                                                    <i class="far fa-image fa-2x text-muted" title="No Image"></i>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($val->event_is_active))
                                                    @if($val->event_is_active == 1)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="table-action">
                                                    <a href="{{ url('tickets/ticket_view', $val->id) }}" class="btn btn-sm bg-primary-light" title="View">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                    <a href="{{ url('tickets/manage_tickets', $val->id) }}" class="btn btn-sm btn-info" title="Manage">
                                                        <i class="far fa-cog"></i> Manage
                                                    </a>
                                                </div>
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
                                            <div class="table-action">
                                                <a href="{{ url('tickets/ticket_view', $val->id) }}" class="btn btn-sm bg-primary-light" title="View">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                <a href="{{ url('tickets/manage_tickets', $val->id) }}" class="btn btn-sm btn-info" title="Manage">
                                                    <i class="far fa-cog"></i> Manage
                                                </a>
                                            </div>
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
