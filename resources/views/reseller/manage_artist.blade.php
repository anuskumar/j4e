<?php $page = 'manage_artist'; ?>
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
                            <h4 class="mb-4">Artists</h4>
                            <div class="appointment-tab">

                                <!-- Appointment Tab -->
                                <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
                                    {{-- <li class="nav-item">
                                        <a class="nav-link active" href="#upcoming-appointments" data-toggle="tab">All</a>
                                    </li> --}}
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" href="#today-appointments" data-toggle="tab">Upcomming</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a class="btn ripple btn-info nav-item" style="float:right;"
                                            href="{{ url('reseller/artist_create') }}">Create Artist</a>
                                    </li>

                                </ul>
                                <!-- /Appointment Tab -->

                                <div class="row row-sm">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                {{-- <h3 class="card-title">Artists</h3> --}}
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="file-datatable"  class="border-top-0 dataTables  table table-bordered text-nowrap key-buttons border-bottom">
                                                        <thead>
                                                            <tr>
                                                                <th>Sl</th>
                                                                <th class="border-bottom-0">Artist Name</th>
                                                                <th class="border-bottom-0">Artist Field</th>
                                                                <th class="border-bottom-0">Contact Number </th>
                                                                <th class="border-bottom-0"> About</th>
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

                                                                <td>{{ $val->artist_name }}</td>
                                                                <td>{{ $val->field_name }}</td>
                                                                <td>{{ $val->contact_number }}</td>
                                                                <td>{{ $val->about }}</td>

                                                                 <td>
                                                                    <form action="{{ url('reseller/delete_artist',$val->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    <a href="{{url('reseller/artist_view',$val->id)}}"><button type="button" class="btn btn-primary">view</button></a>
                                                                    <a href="{{url('reseller/artist_edit',$val->id)}}"><button type="button" class="btn btn-info">Edit</button></a>
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
                            </div>
                        </div>
                    </div>

                </div>


            </div>


        </div>


    </div>
    <!-- /Page Content -->

    </div>

    <script>

    function demofunction123(){

        swal({
    position: "top-end",
    type: "success",
    title: "Your work has been saved",
    showConfirmButton: false,
    timer: 1500
  });

// alert('demo');


    }
    </script>
@endsection
