




<?php $page="companysettings/edit/update";?>
@extends('admin.layout.app')
@section('admin_content')

<!-- row -->
<div class="row row-sm">
    <!-- Col -->
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="ps-0">
                    <div class="main-profile-overview">
                        <div class="main-img-user profile-user">
                            <img src="{{ asset('storage/uploads/images/' . $settings->company_logo) }}" alt="img">

                            {{-- <img alt="" src="{{ Storage::disk('image')->url('uploads/images/' . $settings->company_logo) }}"> --}}
                            <a href="JavaScript:void(0);" class="fas fa-camera profile-edit"></a></div>

                        <div class="d-flex justify-content-between mg-b-20">
                            <div>
                                <h5 class="main-profile-name">{{ $settings->company_name }}</h5>
                                <p class="main-profile-name-text">{{ $settings->company_website }}</p>
                            </div>
                        </div>
                        <h6>About Company</h6>
                        <div class="main-profile-bio">
                            {{ $settings->company_about }}
                        </div>
                        <h6>Footer Text</h6>
                        <div class="main-profile-bio">
                            {{ $settings->company_footer_text }}
                        </div>

                        <!-- main-profile-bio -->
                        <hr class="mg-y-30">
                        <label class="main-content-label tx-13 mg-b-20">Contact</label>
                        <div class="main-profile-work-list">
                            <div class="media">
                                <div class="media-logo bg-success-transparent text-success">
                                    <i class="icon ion-md-phone-portrait"></i>
                                </div>
                                <div class="media-body">
                                    <h6>Contact Number</h6>
                                    <div class="main-profile-bio">
                                        {{ $settings->contact_number }}
                                    </div>
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-logo bg-success-transparent text-success">
                                    <i class="icon ion-md-document"></i>
                                </div>
                                <div class="media-body">
                                    <h6>Email</h6>
                                    <div class="main-profile-bio">
                                        {{ $settings->company_email }}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- main-profile-work-list -->
                        <label class="main-content-label tx-13 mg-b-20">Company logo small</label><br>
                        <div class="main-img-user profile-user">
                            <img src="{{ asset('storage/uploads/images/' . $settings->company_logo_small) }}" alt="img">

                            {{-- <img alt="" src="{{ Storage::disk('image')->url('uploads/images/' . $settings->company_logo_small) }}"> --}}
                            <a href="JavaScript:void(0);" class="fas fa-camera profile-edit"></a></div><br>

                            <label class="main-content-label tx-13 mg-b-20">Company Favicon</label><br>
                        <div class="main-img-user profile-user">
                            <img src="{{ asset('storage/uploads/images/' . $settings->company_favicon) }}" alt="img">

                            {{-- <img alt="" src="{{ Storage::disk('image')->url('uploads/images/' . $settings->company_favicon) }}"> --}}
                            <a href="JavaScript:void(0);" class="fas fa-camera profile-edit"></a></div>


                        <hr class="mg-y-30">
                        <label class="main-content-label tx-13 mg-b-20">Social</label>
                        <div class="main-profile-social-list">

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

                        </div><!-- main-profile-social-list -->
                    </div><!-- main-profile-overview -->
                </div>
            </div>
        </div>

    </div>
    <!-- /Col -->

    <!-- Col -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-4 main-content-label">Company Information</div>
                <form class="form-horizontal" action="{{ url('company/update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $settings-> id }}">
                       <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Company Name</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="company_name" placeholder="Company Name" value="{{ $settings-> company_name }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Company website</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="company_website" placeholder="Website" value="{{ $settings-> company_website }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Logo</label>
                            </div>
                            <div class="col-md-6">
                                <input type="file" class="form-control"  placeholder="logo" name="company_logo">
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Company Footer Text</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="company_footer_text" placeholder="Footertext" value="{{ $settings-> company_footer_text }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Company About</label>
                            </div>
                            <div class="col-md-6">
                                {{-- <input type="textarea" class="form-control"  placeholder="About company" value="Web Designer"> --}}
                                <textarea class="form-control"  name="company_about" placeholder="About company" value="{{ $settings-> company_about }}" >

                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Contact Number</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="contact_number" placeholder="phone number" value="{{ $settings-> contact_number }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Email</label>
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="company_email" placeholder="Email" value="{{ $settings->company_email }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Companylogo Small</label>
                            </div>
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="company_logo_small" placeholder="small logo" value="@spruko.w" id="fileInput" accept="image">
                            </div>

                            <div class="col-md-3" id="imagePreviewContainer">
                                {{-- <img id="imagePreview" src="" alt="Image Preview" width="50" height="50"> --}}
                        </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Favicon </label>
                            </div>
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="company_favicon" placeholder="Favicon" value="@spruko.w" id="fileInput1">
                            </div>
                            <div class="col-md-3" id="imagePreviewContainer1">
                                {{-- <img id="imagePreview1" src="" alt="Image Preview" width="50" height="50"> --}}
                        </div>
                        </div>
                    </div>



                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Twitter</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control"  placeholder="twitter" value="twitter.com/spruko.me">
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Facebook</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control"  placeholder="facebook" value="https://www.facebook.com/Redash">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Update Profile</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- /Col -->
</div>



<script>

    var fileinput=

    const fileInput = document.getElementById('fileInput');
    const imagePreview = document.getElementById('imagePreview');
    fileInput.addEventListener('change', function() {
        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };

            reader.readAsDataURL(fileInput.files[0]);
        } else {
            imagePreview.style.display = 'none';
        }
    });
</script>
<script>
    const fileInput1 = document.getElementById('fileInput1');
    const imagePreview1 = document.getElementById('imagePreview1');
    fileInput1.addEventListener('change', function() {
        if (fileInput1.files && fileInput1.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview1.src = e.target.result;
                imagePreview1.style.display = 'block';
            };
            reader.readAsDataURL(fileInput1.files[0]);
        } else {
            imagePreview1.style.display = 'none';
        }
    });
</script>

@endsection



