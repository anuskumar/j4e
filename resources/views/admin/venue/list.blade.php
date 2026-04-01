<?php $page="venue/list";?>
@extends('admin.layout.app')
@section('admin_content')

	<!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Venue</h3>
                        <a href="{{ url('venue/create') }}" class="btn btn-primary">
                            <i class="fa fa-plus me-2"></i>Create Venue
                        </a>
                    </div>
                </div>
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
                                        @if($val->image)
                                            <a href="{{ asset('storage/uploads/venue/' . $val->image) }}" target="_blank" title="View Image">
                                                <img src="{{ asset('storage/uploads/venue/' . $val->image) }}" alt="Venue Image" style="width:40px;height:40px;object-fit:cover;border-radius:4px;">
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $val->venue_name }}</td>
                                    <td>{{ $val->location_name ?? '-' }}</td>
                                    <td>
                                        @if(!empty($val->google_map_link))
                                            <a href="{{ $val->google_map_link }}" target="_blank" rel="noopener">Map</a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    {{-- <td>{{ $val->latitude }}</td>
                                    <td>{{ $val->longitude }}</td> --}}
                                    <td>{{ $val->total_seats ?? 0 }}</td>
                                    <td>{{ $val->total_seat_types ?? 0 }}</td>
                                    <td>
                                        <a href="{{url('venue/manage_Seating',$val->id)}}" class="btn btn-sm btn-primary" title="Manage Seating">
                                            <i class="far fa-cog"></i>
                                           Manage Seating
                                        </a>
                                    </td>

                                    <td>
                                        <div class="table-action">
                                            <a href="{{url('venue/view',$val->id)}}" class="btn btn-sm bg-primary-light" title="View">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <a href="{{url('venue/edit',$val->id)}}" class="btn btn-sm bg-info-light" title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <form action="{{ url('venue/destroy',$val->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm bg-danger-light show_confirm" title="Delete">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
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
    <script src="admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="admin_assets/js/main.js"></script>
    <!-- End Row -->


@include('datatable.datatable_js')
@endsection
