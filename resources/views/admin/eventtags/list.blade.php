<?php $page="eventtags/list";?>
@extends('admin.layout.app')
@section('admin_content')

	<!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Event tag</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="file-datatable"  class="border-top-0 dataTables  table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th class="border-bottom-0">EventTag Name</th>
                                    <th class="border-bottom-0">Image</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($tags as $val)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $val->tag_name }}</td>
                                    <td>
                                        @if($val->tag_image)
                                            <img alt="image" src="{{ asset('storage/uploads/event_tag_images/' . $val->tag_image) }}" width="100" >
                                        @else
                                            <img alt="image" src="{{ asset('assets/img/default-tag.jpg') }}" width="100">
                                        @endif
                                    </td>

                                    <td>{{ $val->is_active == 1 ? "Active" :"Inactive" }}</td><td>
                                        <form action="{{ url('eventtags/destroy',$val->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                        <a href="{{url('eventtags/edit',$val->id)}}"><button type="button" class="btn btn-info">Edit</button></a>
                                        {{-- <a href="{{url('customer/delete',$val->id)}}"><button type="button" class="btn btn-danger">Delete</button></a> --}}
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
