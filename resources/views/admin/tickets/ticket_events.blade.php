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
                            class="table table-striped table-hover table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th class="text-center">Sl No</th>
                                    <th>Event Name</th>
                                    <th>Event Type</th>
                                    <th>Event Date</th>
                                    <th>Location</th>
                                    <th>Venue</th>
                                    <th class="text-center" style="min-width: 200px;">Action</th>
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
                                            <td class="text-center">{{ $no++ }}</td>
                                            <td>
                                                <strong>{{ $val->event_name }}</strong>
                                                @if($val->waiting_for_approval>0)
                                                    <br><span class="badge bg-warning text-dark">{{ $val->waiting_for_approval }} Waiting for Approval</span>
                                                @endif
                                            </td>
                                            <td>{{ $val->event_type_name ?? 'N/A' }}</td>
                                            <td>
                                                @if($val->event_from_date)
                                                    <strong>From:</strong> {{ date('d-m-Y', strtotime($val->event_from_date)) }}<br>
                                                @endif
                                                @if($val->event_to_date)
                                                    <strong>To:</strong> {{ date('d-m-Y', strtotime($val->event_to_date)) }}
                                                @endif
                                            </td>
                                            <td>{{ ($val->location_name ?? '') . ' ' . ($val->city_name ?? '') . ', ' . ($val->country_name ?? '') }}</td>
                                            <td>{{ $val->venue_name ?? 'N/A' }}</td>
                                            <td>
                                                <div class="table-action" style="display: flex; gap: 5px; flex-wrap: wrap; justify-content: center;">
                                                    <a href="{{ url('tickets/ticket_view', $val->id) }}" class="btn btn-sm btn-primary" title="View">
                                                        <i class="far fa-eye"></i> View
                                                    </a>
                                                    <a href="{{ url('tickets/manage_tickets', $val->id) }}" class="btn btn-sm btn-info" title="Manage">
                                                        <i class="far fa-cog"></i> Manage
                                                    </a>
                                                    <a href="{{ url('tickets/transaction-history', $val->id) }}" class="btn btn-sm btn-success" title="Transaction History">
                                                        <i class="far fa-history"></i> Transaction History
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                    @else
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>
                                            <strong>{{ $val->event_name }}</strong>
                                            @if($val->waiting_for_approval>0)
                                                <br><span class="badge bg-warning text-dark">{{ $val->waiting_for_approval }} Waiting for Approval</span>
                                            @endif
                                        </td>
                                        <td>{{ $val->event_type_name ?? 'N/A' }}</td>
                                        <td>
                                            @if($val->event_from_date)
                                                <strong>From:</strong> {{ date('d-m-Y', strtotime($val->event_from_date)) }}<br>
                                            @endif
                                            @if($val->event_to_date)
                                                <strong>To:</strong> {{ date('d-m-Y', strtotime($val->event_to_date)) }}
                                            @endif
                                        </td>
                                        <td>{{ ($val->location_name ?? '') . ' ' . ($val->city_name ?? '') . ', ' . ($val->country_name ?? '') }}</td>
                                        <td>{{ $val->venue_name ?? 'N/A' }}</td>
                                        <td>
                                            <div class="table-action" style="display: flex; gap: 5px; flex-wrap: wrap; justify-content: center;">
                                                <a href="{{ url('tickets/ticket_view', $val->id) }}" class="btn btn-sm btn-primary" title="View">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                                <a href="{{ url('tickets/manage_tickets', $val->id) }}" class="btn btn-sm btn-info" title="Manage">
                                                    <i class="far fa-cog"></i> Manage
                                                </a>
                                                <a href="{{ url('tickets/transaction-history', $val->id) }}" class="btn btn-sm btn-success" title="Transaction History">
                                                    <i class="far fa-history"></i> Transaction History
                                                </a>
                                            </div>
                                        </td>
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
