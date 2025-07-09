@extends('admin.layout.app')
@section('admin_content')
<div class="row">

    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card mg-b-20 text-center">
            <div class="card-body h-100">
                <table class="table table-hover">
                    <thead>
                        <tr>

                            <th scope="col">id</th>
                            <th scope="col">Split Name</th>
                            <th scope="col">Status</th>
                          </tr>
                    </thead>
                    <tbody>
                        @php
                                    $no = 1;
                                @endphp
                                @foreach ($datas as $val)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $val->split_name }}</td>
                                    <td>{{ $val->is_active == 1 ? "Active" :"Inactive" }}</td>


                                </tr>
                                @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>

</div>
@endsection

