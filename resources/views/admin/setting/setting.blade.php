@extends('layouts.admin_layout')
@section('content')
@section('title', 'Setting')

<!-- Begin page -->



<!-- ========== App Menu ========== -->

<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="position-relative mx-n4 mt-n4">
                <div class="profile-wid-bg profile-setting-img">
                    <img src="{{URL::asset('uploads/admin/'.$admin->cover_image)}}" class="profile-wid-img" alt="">
                    <div class="overlay-content">
                        <div class="text-end p-3">
                            <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                                <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input upload_profile_cover_img">
                                <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                                    <i class="ri-image-edit-line align-bottom me-1"></i> Change Cover
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-3">
                    <div class="card mt-n5">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                    <img src="{{URL::asset('uploads/admin/'.$admin->image)}}" class="rounded-circle avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                        <input id="profile-img-file-input" name="file_img" type="file" class="profile-img-file-input upload_profile_img">
                                        <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                            <span class="avatar-title rounded-circle bg-light text-body shadow">
                                                <i class="ri-camera-fill"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <span id="mgs_profile_img"></span>
                                <h5 class="fs-16 mb-1">{{Auth::guard('admin')->user()->name}}</h5>
                                <p class="text-muted mb-0">Administrator</p>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-5">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0">Complete Your Profile</h5>
                                </div>

                            </div>

                            @php
                            $percentage = [];


                            if(isset($admin->name) && $admin->name!='')
                            {
                            $percentage[] = 20;
                            } else
                            {
                            $percentage[] = 0;
                            }

                            if(isset($admin->email) && $admin->email!='')
                            {
                            $percentage[] = 20;
                            } else
                            {
                            $percentage[] = 0;
                            }

                            if(isset($admin->phone) && $admin->phone!='')
                            {
                            $percentage[] = 20;
                            } else
                            {
                            $percentage[] = 0;
                            }

                            if(isset($admin->address) && $admin->address!='')
                            {
                            $percentage[] = 20;
                            } else
                            {
                            $percentage[] = 0;
                            }

                            if(isset($admin->about) && $admin->about!='')
                            {
                            $percentage[] = 20;
                            } else
                            {
                            $percentage[] = 0;
                            }

                            $getPercentage = array_sum($percentage);
                            @endphp
                            <div class="progress animated-progress custom-progress progress-label">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{$getPercentage}}%" aria-valuenow="{{$getPercentage}}" aria-valuemin="0" aria-valuemax="100">
                                    <div class="label">{{$getPercentage}}%</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end card-->
                </div>
                <!--end col-->
                <div class="col-xxl-9">
                    <div class="card mt-xxl-n5">
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                        <i class="fas fa-home"></i> Personal Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                        <i class="far fa-user"></i> Change Password
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#generalSettings" role="tab">
                                        <i class="far fa-envelope"></i> General Settings
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <div class="tab-pane active" id="personalDetails" role="tabpanel">


                                    @if (session('msg'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('msg') }}
                                    </div>
                                    @endif


                                    <form method="post" action="{{url('admin/profile-update')}}" id="">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your Name" value="{{ isset($admin)?$admin->name:old('name') }}">
                                                </div>
                                                @error('name')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email Address</label>
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email Address" value="{{ isset($admin)?$admin->email:old('email') }}">
                                                </div>
                                                @error('email')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Phone Number</label>
                                                    <input type="text" class="form-control" name="phone" placeholder="Enter your phone number" value="{{ isset($admin)?$admin->phone:old('phone') }}">
                                                </div>
                                                @error('phone')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="emailInput" class="form-label">Address</label>
                                                    <input type="text" class="form-control" name="address" placeholder="Enter your address" value="{{ isset($admin)?$admin->address:old('address') }}">
                                                </div>
                                                @error('address')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <!--end col-->

                                            <!--end col-->


                                            <div class="col-lg-12">
                                                <div class="mb-3 pb-2">
                                                    <label for="about" class="form-label">About</label>
                                                    <textarea class="form-control" name="about" rows="3">{{ isset($admin)?$admin->about:old('about') }}</textarea>
                                                </div>
                                                @error('about')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Updates</button>
                                                    <input type="reset" class="btn btn-soft-success" value="Cancel">
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                                <!--end tab-pane-->
                                <div class="tab-pane" id="changePassword" role="tabpanel">

                                    <div class="alert alert-danger print-error-msg" style="display:none">
                                        <ul></ul>
                                    </div>

                                    <span id="succMsg" style="color:red;"></span>

                                    <form action="{{url('admin/update-password')}}" method="post" id="passForm">
                                        <div class="row g-2">
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="oldpasswordInput" class="form-label">Old Password*</label>
                                                    <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Enter current password">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="newpasswordInput" class="form-label">New Password*</label>
                                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter new password">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="confirmpasswordInput" class="form-label">Confirm Password*</label>
                                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm password">
                                                </div>
                                            </div>
                                            <!--end col-->

                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="text-end">
                                                    <button type="button" id="passupdtBtn" class="btn btn-success">Change Password</button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>




                                </div>
                                <!--end tab-pane-->
                                <div class="tab-pane" id="generalSettings" role="tabpanel">
                                    <form method="post" action="{{url('admin/update-general-setting')}}">
                                        @csrf
                                        <div id="newlink">
                                            <div id="1">
                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label for="sitename" class="form-label">Webiste Name</label>
                                                            <input type="text" class="form-control" id="sitename" name="sitename" value="{{ isset($globalSetting)?$globalSetting['sitename']:old('sitename') }}">
                                                        </div>
                                                    </div>

                                                    

                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label for="default_meta_title" class="form-label">Meta Title</label>
                                                            <input type="text" class="form-control" id="default_meta_title" name="default_meta_title" value="{{ isset($globalSetting)?$globalSetting['default_meta_title']:old('default_meta_title') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label for="default_meta_keywords" class="form-label">Meta Keywords</label>
                                                            <input type="text" class="form-control" id="default_meta_keywords" name="default_meta_keywords" value="{{ isset($globalSetting)?$globalSetting['default_meta_keywords']:old('default_meta_keywords') }}">
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label for="address" class="form-label">Meta Description</label>
                                                            <textarea class="form-control" id="default_meta_description" name="default_meta_description" rows="3" placeholder="Enter Address"> {{ isset($globalSetting)?$globalSetting['default_meta_description']:old('default_meta_description') }} </textarea>
                                                        </div>
                                                    </div>

                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email Id</label>
                                                            <input type="text" class="form-control" id="site_email" name="site_email" value="{{ isset($globalSetting)?$globalSetting['site_email']:old('site_email') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="mobile_number" class="form-label">Phone No</label>
                                                            <input type="text" class="form-control" id="site_phone" name="site_phone" value="{{ isset($globalSetting)?$globalSetting['site_phone']:old('site_phone') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="facebook" class="form-label">Facebook URL</label>
                                                            <input type="text" class="form-control" id="facebook_url" name="facebook_url" value="{{ isset($globalSetting)?$globalSetting['facebook_url']:old('facebook_url') }}">
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="instagram" class="form-label">Instagram URL</label>
                                                            <input type="text" class="form-control" id="instagram_url" name="instagram_url" value="{{ isset($globalSetting)?$globalSetting['instagram_url']:old('instagram_url') }}">
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="twitter" class="form-label">Twitter URL</label>
                                                            <input type="text" class="form-control" id="twitter_url" name="twitter_url" value="{{ isset($globalSetting)?$globalSetting['twitter_url']:old('twitter_url') }}">
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="linkedin" class="form-label">Linkedin URL</label>
                                                            <input type="text" class="form-control" id="linkedin_url" name="linkedin_url" value="{{ isset($globalSetting)?$globalSetting['linkedin_url']:old('linkedin_url') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="linkedin" class="form-label">YouTube URL</label>
                                                            <input type="text" class="form-control" id="youtube_url" name="youtube_url" value="{{ isset($globalSetting)?$globalSetting['youtube_url']:old('youtube_url') }}">
                                                        </div>
                                                    </div>



                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label for="address" class="form-label">Address</label>
                                                            <textarea class="form-control" id="site_address" name="site_address" rows="3" placeholder="Enter Address"> {{ isset($globalSetting)?$globalSetting['site_address']:old('site_address') }} </textarea>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label for="site_map" class="form-label">Map</label>
                                                            <textarea class="form-control" id="site_map" name="site_map" rows="3" placeholder="Enter Map"> {{ isset($globalSetting)?$globalSetting['site_map']:old('site_map') }} </textarea>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label for="site_about" class="form-label">About</label>
                                                            <textarea class="form-control" id="site_about" name="site_about" rows="3" placeholder="Enter About Website"> {{ isset($globalSetting)?$globalSetting['site_about']:old('site_about') }} </textarea>
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                </div>
                                                <!--end row-->
                                            </div>
                                        </div>
                                        <div id="newForm" style="display: none;">

                                        </div>
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2">
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </form>
                                </div>



                                <!--end tab-pane-->

                                <!--end tab-pane-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div><!-- End Page-content -->

    @include('includes.admin.footer')
</div>

<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        });

        $('#passupdtBtn').on('click', function() {
            var current_password = $('#current_password').val();
            var password = $('#password').val();
            var password_confirmation = $('#password_confirmation').val();
            var csrf_token = $('input[name="csrf_token"]').val();

            $.ajax({
                type: 'POST',
                url: 'update-password',
                data: {
                    current_password: current_password,
                    password: password,
                    password_confirmation: password_confirmation,
                    _token: csrf_token
                },
                beforeSend: function() {
                    $('.web-spinner').show();
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        $("#succMsg").text(data.success);
                        $('.toast').toast('show');
                        $('.print-error-msg').toast('hide');
                        $("#passForm")[0].reset();
                    } else {
                        $('.succMsg').toast('hide');
                        $('.toast').toast('hide');
                        printErrorMsg(data.error);
                    }
                },
                complete: function() {
                    $('.web-spinner').hide();
                }

            });


        });



        $('.upload_profile_img').on('change', function(event) {

            var filedata = this.files[0];
            var imgtype = filedata.type;
            var match = ['image/jpeg', 'image/jpg', 'image/png'];

            if (!(imgtype == match[0]) || (imgtype == match[1])) {
                $('#mgs_profile_img').html('<p style="color:red">Plz select a valid type image..only png jpg jpeg allowed</p>');
            } else {
                $('#mgs_profile_img').empty();
            }

            var reader = new FileReader();
            reader.onload = function(ev) {
                $('#img_profile_prv').attr('src', ev.target.result).css('width', '50px').css('height', '50px');
            }
            reader.readAsDataURL(this.files[0]);

            var postData = new FormData();
            postData.append('file', this.files[0]);
            var url = "{{url('admin/save-profile-image')}}";

            $.ajax({
                async: true,
                type: "post",
                contentType: false,
                url: url,
                data: postData,
                processData: false,
                success: function() {
                    $('#mgs_profile_img').html('<p style="color:green">Profile image updated successfully.</p>');
                    console.log("success");
                }

            });

        });


        $('.upload_profile_cover_img').on('change', function(event) {

            var filedata = this.files[0];
            var imgtype = filedata.type;
            var match = ['image/jpeg', 'image/jpg', 'image/png'];

            if (!(imgtype == match[0]) || (imgtype == match[1])) {
                $('#mgs_profile_cover_img').html('<p style="color:red">Plz select a valid type image..only jpg jpeg png allowed</p>');
            } else {
                $('#mgs_profile_cover_img').empty();
            }

            var postData = new FormData();
            postData.append('file', this.files[0]);
            var url = "{{url('admin/save-profile-cover-image')}}";

            $.ajax({
                async: true,
                type: "post",
                contentType: false,
                url: url,
                data: postData,
                processData: false,
                success: function() {
                    $('#mgs_profile_cover_img').html('<p style="color:green">cover image updated successfully.</p>');
                    console.log("success");
                }

            });


        });




    });


    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function(key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        });
    }
</script>

@stop