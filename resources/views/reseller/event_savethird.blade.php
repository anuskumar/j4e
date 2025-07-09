@extends('admin.layout.app')
@section('admin_content')
<form class="form-horizontal"  action="{{route('reseller.savethird', ['id' => request()->route('id')]) }}" method="POST" enctype="multipart/form-data">
    @csrf
<div class="row">
    <form class="form-horizontal" action="{{ route('reseller.savethird',['id' => request()->route('id')]) }}" method="POST" enctype="multipart/form-data">
        @csrf
       <input type="hidden" name="id" value="{{ $id }}">
    <div class="col-lg-9 col-md-12">
        <div class="card mg-b-20">
            <div class="card-body h-100" id="optioncontrollingid">
                @if ($oldaddress->isEmpty())
                    <p class="bg-danger text-white p-1">Collection empty</p>
                @else
                    @foreach ($oldaddress as $oldaddres)
                        <label>
                            <input type="checkbox" id="{{ 'checkbox_' . $oldaddres->id }}" name="address_checkbox" value="{{ $oldaddres->id }}">
                            <p>{{ $oldaddres->address_line1 }}</p>
                            <p>{{ $oldaddres->address_line2 }}</p>
                        </label>
                        <br>
                    @endforeach
                @endif
            </div>
            <div class="card-body h-100" id="formcontrollingid">

                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Full Name</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name"  value="{{$authname}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Address Line1</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" max="???" min="???" id="no-of-tickets" name="address_line1" >

                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Address Line2</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" max="???" min="???" id="no-of-tickets" name="address_line2">

                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Country</label>
                            </div>
                            <div class="col-md-6">
                                <select name="country" class="form-control" onchange="changecityname(this.value)">
                                    <option>Select</option>
                                    @foreach($country_name as $val)
                                    <option value="{{ $val->id }}">{{ $val->country_name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">City</label>
                            </div>
                            <div class="col-md-6">
                                <select name="city" class="form-control"  id="citySelect">
h
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Postcode</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="postcode"  >

                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Phone Number</label>
                            </div>
                            <div class="col-md-1">
                                <input type="text" class="form-control" name="code" id="countrycode" readonly placeholder="91">
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" name="phone" id="" >
                            </div>
                        </div>
                    </div>

                   <div class="card-footer">
                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float:right;">Add</button>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function changecityname(val)
    {
     var countryid=val;
     var urlname="{{ route('reseller.pickcity') }}";
     console.log(urlname);

     $.ajax({
            url: urlname,
            type: "GET",
            data: {
                country_code: countryid,
            },

            success: function(result) {
                console.log(result);

                var citySelect = document.getElementById("citySelect");
                citySelect.innerHTML = "";
                result.forEach(function(city) {
                    var option = document.createElement("option");
                    option.value = city.id;
                    option.text = city.name;
                    citySelect.appendChild(option);
                });


            }
     });
    }
</script>

@endsection
