<?php $page="venue/list";?>
@extends('admin.layout.app')
@section('admin_content')

	<!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Venue</h3>
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
                                        {{-- {{ $val->image }} --}}
                                        <img src="{{ config('app.storage') ."uploads/venue/". $val->image }}"  alt="img">

                                        {{-- <img alt="" src="{{ Storage::disk('image')->url('uploads/venue/' . $val->image) }}"> --}}
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
                                        <form action="{{ url('venue/destroy',$val->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        <a href="{{url('venue/view',$val->id)}}"><button type="button" class="btn btn-primary">view</button></a>
                                        <a href="{{url('venue/edit',$val->id)}}"><button type="button" class="btn btn-info">Edit</button></a>
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
