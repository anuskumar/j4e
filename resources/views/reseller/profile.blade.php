<?php $page = 'Reseller/Profile'; ?>
@extends(Auth::user()->user_type == "reseller" ? 'layouts.reseller_app' : 'admin.layout.app')
@if(Auth::user()->user_type == "reseller")

    @section('content')

@else
    @section('admin_content')
@endif
    <!-- row -->
    <div class="row row-sm">
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="ps-0">
                        <div class="main-profile-overview">
                            <div class="main-img-user profile-user">
                            <img src="{{ config('app.storage') ."uploads/images/". $authdata->profile }}"  alt="img">

                                {{-- <img alt="" src="{{ Storage::disk('image')->url('uploads/images/' . $authdata->profile) }}"> --}}

                            </div>
                            <div class="d-flex justify-content-between mg-b-20">
                                <div>
                                    <h5 class="main-profile-name">{{ $authdata->name }}</h5>
                                    <p class="main-profile-name-text">Web Designer</p>
                                </div>
                            </div>
                            <div class="main-profile-work-list">
                                <div class="media">
                                    <div class="media-logo bg-success-transparent text-success">
                                        <i class="icon ion-logo-whatsapp"></i>
                                    </div>
                                    <div class="media-body">

                                        <h4>{{ $authdata->phone }}</h4>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-logo bg-primary-transparent text-primary">
                                        <i class="icon ion-logo-buffer"></i>
                                    </div>
                                    <div class="media-body">

                                        <h4>{{ $authdata->email }}</h4>
                                    </div>
                                </div>
                            </div><!-- main-profile-work-list -->
                            <hr class="mg-y-30">
                            <label class="main-content-label tx-13 mg-b-20">Social</label>
                            <div class="main-profile-social-list">
                                <div class="media">
                                    <div class="media-icon bg-primary-transparent text-primary">
                                        <i class="icon ion-logo-github"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>Github</span> <a href="">github.com/spruko</a>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-icon bg-success-transparent text-success">
                                        <i class="icon ion-logo-twitter"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>Twitter</span> <a href="">twitter.com/spruko.me</a>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-icon bg-info-transparent text-info">
                                        <i class="icon ion-logo-linkedin"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>Linkedin</span> <a href="">linkedin.com/in/spruko</a>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-icon bg-danger-transparent text-danger">
                                        <i class="icon ion-md-link"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>My Portfolio</span> <a href="">spruko.com/</a>
                                    </div>

                                </div>
                            </div><!-- main-profile-social-list -->
                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="main-content-body main-content-body-profile">
                <div class="">
                    <div class="wideget-user-tab">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu1">
                                <ul class="nav">
                                    <li class=""><a href="#tab-51" class="active show"
                                            data-bs-toggle="tab">Profile</a></li>
                                            <li><a href="#tab-41" data-bs-toggle="tab" class="">Bank Details</a></li>
                                    <li><a href="#tab-61" data-bs-toggle="tab" class="">Address</a></li>
                                    {{-- <li><a href="#tab-71" data-bs-toggle="tab" class="">Listing</a></li>
                                    <li><a href="#tab-81" data-bs-toggle="tab" class="">Sales</a></li> --}}
                                    {{-- <li><a href="#tab-91" data-bs-toggle="tab" class="">Address</a></li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active show" id="tab-51">
                        <div id="profile-log-switch">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header">
                                        <div class="mb-4 main-content-label">Personal Information</div>
                                        <form class="form-horizontal" action="{{ url('reseller/update_profile') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="authid" value="{{$authdata->id }}">
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label"> Name</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="name"
                                                            placeholder=" Name" value="{{ $authdata->name }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Email</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="email" class="form-control" name="company_email"
                                                            placeholder="Email" value="{{ $authdata->email }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Contact Number</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="contact_number"
                                                            placeholder="phone number" value="{{ $authdata->phone}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Profile Image </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="file" class="form-control" placeholder="Profile image" name="profile">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit"
                                                    class="btn btn-primary waves-effect waves-light">Update
                                                    Profile</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="media mg-t-15 profile-footer"> </div>
                                </div>
                            </div>
                            <div class="card mg-b-20">
                                <div class="card-body">
                                    <div class="card-header">
                                        <div class="media">
                                            <div class="ms-auto">
                                                <div class="dropdown show">
                                                    <a class="new" data-bs-toggle="dropdown"
                                                        href="JavaScript:void(0);"><i class="fas fa-ellipsis-v"></i></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Edit Post</a> <a
                                                            class="dropdown-item" href="#">Delete Post</a> <a
                                                            class="dropdown-item" href="#">Personal Settings</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="media mg-t-15 profile-footer">
                                        <div class="media-user me-2">
                                            <div class="demo-avatar-group">

                                            </div><!-- demo-avatar-group -->
                                        </div>
                                        <div class="media-body">
                                            <div class="mb-4 main-content-label">Change Password</div>
                                            <form class="form-horizontal" action="{{ route('reseller.passwordupdate') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $authdata->id }}">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Old password <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="password" class="form-control" name="oldpassword" placeholder="Old password">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">New Password <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="password" class="form-control" name="newpassword" placeholder="New Password">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Confirm Password<span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Change Password</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane " id="tab-41">
                        <div id="profile-log-switch">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header">
                                        <br>
                                       <div class="mb-4 main-content-label"> Bank Details</div>
                                        <form class="form-horizontal" action="{{ route('reseller.bankdataupdate') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $authdata->id }}">
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Bank's Name</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="name" placeholder="Name"
                                                     value="{{ !empty($bankData->bank_name) ? $bankData->bank_name : '' }}">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Bank's Email</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="email" class="form-control" name="bankname"
                                                            placeholder="Email"   value="{{ !empty($bankData->bank_name) ? $bankData->bank_email : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Bank Country</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{-- <input type="text" class="form-control" name="bankcountry"
                                                            placeholder=" country" value="{{ !empty($bankData->bank_country) ? $bankData->bank_country : '' }}"> --}}
                                                            <select name="bank_country" class="form-control select2-select" required>
                                                                <option>Select</option>
                                                                @foreach($country as $loc)
                                                                    <option value="{{ $loc->id }}" {{ ($bankData->bank_country ?? null) == $loc->id ? "selected" : "" }}>
                                                                        {{ $loc->country_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Payment Account IBAN <span
                                                            class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="bankaccno"
                                                            placeholder=" "value="{{ !empty($bankData->accnt_no) ? $bankData->accnt_no : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">BIC <span
                                                            class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="bankbic"
                                                            placeholder=" "value="{{ !empty($bankData->bic) ? $bankData->bic : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Payment Account Beneficiarys Bank/Institution <span
                                                            class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="name"
                                                            placeholder=" " value="{{ !empty($bankData->bank_name) ? $bankData->bank_account : '' }}">
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Comments <span
                                                            class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="textarea" class="form-control" name="bankcomments"
                                                            placeholder=" " value="{{ !empty($bankData->comments) ? $bankData->comments : '' }}">
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="card-footer">
                                                <button type="submit"
                                                    class="btn btn-primary waves-effect waves-light">Update
                                                   </button>
                                            </div>
                                        </form>
                                    </div>




                                    <div class="media mg-t-15 profile-footer"> </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane" id="tab-71">
                        <ul class="widget-users row ps-0 mb-5">
                            <div class="card ">
                                <li class="col-xl-9 col-lg-9  col-md-9 col-sm-12 col-12">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="card custom-card">
                                            <div class="card-body">
                                                <div>
                                                    <h6 class="card-title mb-1">Basic Example</h6>
                                                    <p class="text-muted card-sub-title">Click the buttons below to show
                                                        and hide another element via class changes</p>
                                                </div>
                                                <div>
                                                    <div class=" btn-list">
                                                        <a aria-controls="multiCollapseExample1" aria-expanded="false"
                                                            class="btn ripple btn-primary mb-3 mb-xl-0"
                                                            data-bs-toggle="collapse" href="#multiCollapseExample1"
                                                            role="button">Toggle First Content</a>
                                                        <a aria-controls="multiCollapseExample2" aria-expanded="false"
                                                            class="btn ripple btn-secondary mb-3 mb-xl-0"
                                                            href="#multiCollapseExample2" data-bs-toggle="collapse"
                                                            role="button">Toggle Second Content</a>
                                                    </div>
                                                    <div class="row row-sm">
                                                        <div class="col">
                                                            <div class="collapse multi-collapse mt-2"
                                                                id="multiCollapseExample1">
                                                                <div class="card card-body  border-0">
                                                                    Anim pariatur cliche reprehenderit, enim eiusmod high
                                                                    life accusamus terry richardson ad squid. Nihil anim
                                                                    keffiyeh helvetica, craft beer labore wes anderson cred
                                                                    nesciunt sapiente ea proident.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="collapse multi-collapse mt-2"
                                                                id="multiCollapseExample2">
                                                                <div class="card card-body  border-0">
                                                                    Anim pariatur cliche reprehenderit, enim eiusmod high
                                                                    life accusamus terry richardson ad squid. Nihil anim
                                                                    keffiyeh helvetica, craft beer labore wes anderson cred
                                                                    nesciunt sapiente ea proident.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>




                        </ul>
                    </div>
                    {{-- if($adreesdata) --}}
                    <div class="tab-pane" id="tab-61">
                        {{-- <ul class="widget-users row ps-0 mb-5"> --}}
                            <div class="card ">
                                {{-- <li class="col-xl-9 col-lg-9  col-md-9 col-sm-12 col-12"> --}}
                                    {{-- <div class="col-lg-12 col-md-12"> --}}
                                        {{-- <div class="card custom-card"> --}}
                                            <div class="card-body">
                                                <div class="card-header">
                                                    <div class="mb-4 main-content-label">Address Details</div>
                                                <form class="form-horizontal" action="{{ route('reseller.addressdataupdate') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$authdata->id ?? ' ' }}">
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label"> Name</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="name" placeholder="Name"
                                                         value="{{$adreesdata->name ?? ' '}}">

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">address_line1</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="address_line1" placeholder="Name"
                                                         value="{{$adreesdata->address_line1 ?? ' '}}">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">address_line2</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="address_line2" placeholder="Name"
                                                         value="{{$adreesdata->address_line2 ?? ' '}}">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">country</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{-- <input type="text" class="form-control" name="country" placeholder="Name"
                                                         value="{{$adreesdata->country ?? ' '}}"> --}}
                                                         <select name="country" id="country" class="form-control select2-select" required>
                                                            <option>Select</option>
                                                            @foreach($country as $loc)
                                                                <option value="{{ $loc->id }}" {{ (isset($adreesdata) && $loc->id == $adreesdata->country) ? 'selected' : '' }}>
                                                                    {{ $loc->country_name ?? ' ' }}
                                                                </option>
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
                                                            <select name="city" id="city" class="form-control select2-select">
                                                                <option>Select</option>
                                                                <option value="">Select</option>


                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">City</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select name="city" required class="form-control" id="select2-city">
                                                                <option>Select</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>   --}}
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">postcode</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="postcode" placeholder="Name"
                                                         value="{{$adreesdata->postcode ?? ' '}}">

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">phone</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="phone" placeholder="Name"
                                                         value="{{$adreesdata->phone ?? ' '}}">

                                                        </div>
                                                    </div>
                                                </div>


                                                {{-- <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Payment Account Beneficiarys Bank/Institution <span
                                                                class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="name"
                                                                placeholder=" " value="{{ !empty($bankData->bank_name) ? $bankData->bank_account : '' }}">
                                                        </div>
                                                    </div>
                                                </div> --}}

                                                {{-- <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Comments <span
                                                                class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="textarea" class="form-control" name="bankcomments"
                                                                placeholder=" " value="{{ !empty($bankData->comments) ? $bankData->comments : '' }}">
                                                        </div>
                                                    </div>
                                                </div> --}}




                                                <div class="card-footer">
                                                    <button type="submit"
                                                        class="btn btn-primary waves-effect waves-light">Update
                                                       </button>
                                                </div>
                                            </form>
                                            </div>
                                            </div>
                                        {{-- </div> --}}
                                    {{-- </div> --}}
                                {{-- </li> --}}




                        {{-- </ul> --}}
                    </div>
                    {{-- endif --}}


                </div>
            </div>

        </div>
    </div>
    </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->

    <!--Sidebar-right-->
    <div class="sidebar sidebar-right sidebar-animate">
        <div class="panel panel-primary card mb-0">
            <div class="panel-body tabs-menu-body p-0 border-0">
                <ul class="Date-time">
                    <li class="time">
                        <h1 class="animated ">21:00</h1>
                        <p class="animated ">Sat,October 1st 2029</p>
                    </li>
                </ul>
                <div class="card-body latest-tasks">
                    <h3 class="events-title"><span>Events For Week </span></h3>
                    <div class="event">
                        <div class="Day">Monday 20 Jan</div>
                        <a href="javascript:void(0);">No Events Today</a>
                    </div>
                    <div class="event">
                        <div class="Day">Tuesday 21 Jan</div>
                        <a href="javascript:void(0);">No Events Today</a>
                    </div>
                    <div class="event">
                        <div class="Day">Wednessday 22 Jan</div>
                        <div class="tasks">
                            <div class=" task-line primary">
                                <a href="javascript:void(0);" class="label">
                                    XML Import &amp; Export
                                </a>
                                <div class="time">
                                    12:00 PM
                                </div>
                            </div>
                            <div class="checkbox">
                                <label class="check-box">
                                    <label class="ckbox"><input checked="" type="checkbox"><span></span></label>
                                </label>
                            </div>
                        </div>
                        <div class="tasks">
                            <div class="task-line danger">
                                <a href="javascript:void(0);" class="label">
                                    Connect API to pages
                                </a>
                                <div class="time">
                                    08:00 AM
                                </div>
                            </div>
                            <div class="checkbox">
                                <label class="check-box">
                                    <label class="ckbox"><input type="checkbox"><span></span></label>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="event">
                        <div class="Day">Thursday 23 Jan</div>
                        <div class="tasks">
                            <div class="task-line success">
                                <a href="javascript:void(0);" class="label">
                                    Create Wireframes
                                </a>
                                <div class="time">
                                    06:20 PM
                                </div>
                            </div>
                            <div class="checkbox">
                                <label class="check-box">
                                    <label class="ckbox"><input type="checkbox"><span></span></label>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="event">
                        <div class="Day">Friday 24 Jan</div>
                        <div class="tasks">
                            <div class="task-line warning">
                                <a href="javascript:void(0);" class="label">
                                    Test new features in tablets
                                </a>
                                <div class="time">
                                    02: 00 PM
                                </div>
                            </div>
                            <div class="checkbox">
                                <label class="check-box">
                                    <label class="ckbox"><input type="checkbox"><span></span></label>
                                </label>
                            </div>
                        </div>
                        <div class="tasks">
                            <div class="task-line teal">
                                <a href="javascript:void(0);" class="label">
                                    Design Evommerce
                                </a>
                                <div class="time">
                                    10: 00 PM
                                </div>
                            </div>
                            <div class="checkbox">
                                <label class="check-box">
                                    <label class="ckbox"><input type="checkbox"><span></span></label>
                                </label>
                            </div>
                        </div>
                        <div class="tasks mb-0">
                            <div class="task-line purple">
                                <a href="javascript:void(0);" class="label">
                                    Fix Validation Issues
                                </a>
                                <div class="time">
                                    12: 00 AM
                                </div>
                            </div>
                            <div class="checkbox">
                                <label class="check-box">
                                    <label class="ckbox"><input type="checkbox"><span></span></label>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex pagination wd-100p">
                        <a href="javascript:void(0);">Previous</a>
                        <a href="javascript:void(0);" class="ms-auto">Next</a>
                    </div>
                </div>
                <div class="card-body border-top border-bottom">
                    <div class="row">
                        <div class="col-4 text-center">
                            <a class="" href=""><i
                                    class="dropdown-icon mdi  mdi-message-outline fs-20 m-0 leading-tight"></i></a>
                            <div>Inbox</div>
                        </div>
                        <div class="col-4 text-center">
                            <a class="" href=""><i
                                    class="dropdown-icon mdi mdi-tune fs-20 m-0 leading-tight"></i></a>
                            <div>Settings</div>
                        </div>
                        <div class="col-4 text-center">
                            <a class="" href=""><i
                                    class="dropdown-icon mdi mdi-logout-variant fs-20 m-0 leading-tight"></i></a>
                            <div>Sign out</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/Sidebar-right-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
        var selectedCityId = {{ $adreesdata->city ?? 0 }};

        $('#country').on('change', function () {
            var countryId = $(this).val();
            if (countryId) {
                $.ajax({
                    url: '/get-city/' + countryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#city').empty().append('<option value="">Select city</option>');
                        $.each(data, function (id, name) {
                            var selected = (id == selectedCityId) ? 'selected' : '';
                            $('#city').append('<option value="' + id + '" ' + selected + '>' + name + '</option>');
                        });
                    }
                });
            } else {
                $('#city').empty().append('<option value="">Select City</option>');
            }
        });

        $('#country').trigger('change');
    });


        function validateForm() {
            var oldPassword = document.forms["passwordForm"]["oldpassword"].value;
            var newPassword = document.forms["passwordForm"]["newpassword"].value;
            var confirmPassword = document.forms["passwordForm"]["confirm_password"].value;

            // Validate old password
            if (oldPassword == "") {
                alert("Old password must be filled out");
                return false;
            }

            // Validate new password
            if (newPassword == "") {
                alert("New password must be filled out");
                return false;
            }

            // Validate confirm password
            if (confirmPassword == "") {
                alert("Confirm password must be filled out");
                return false;
            }

            if (newPassword !== confirmPassword) {
                alert("New password and confirm password must match");
                return false;
            }

            return true;
        }
    </script>

@endsection
