@extends('layouts.admin_layout')
@section('content')
@section('title', 'Add User')


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

            <!-- start page title -->

            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1"> @if(isset($user)) View @else Add @endif User</h4>

                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">

                                @if (session('msg'))
                                <div class="alert alert-{{ session('msg_type') }}" role="alert">
                                    {{ session('msg') }}
                                </div>
                                @endif


                                <form method="post" action="{{url('admin/user/save')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4">


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="first_name" class="form-label">First Name</label>
                                                <input type="text" class="form-control" name="first_name" value="{{ isset($user)?$user->first_name:old('first_name') }}">
                                            </div>
                                            @error('first_name')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="last_name" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" name="last_name" value="{{ isset($user)?$user->last_name:old('last_name') }}">
                                            </div>
                                            @error('last_name')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="email" class="form-label">UserName</label>
                                                <input type="text" class="form-control" name="username" value="{{ isset($user)?$user->username:old('username') }}">
                                            </div>
                                            @error('username')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="email" class="form-label">Email Id</label>
                                                <input type="email" class="form-control" name="email" value="{{ isset($user)?$user->email:old('email') }}">
                                            </div>
                                            @error('email')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="text" class="form-control" name="phone" value="{{ isset($user)?$user->phone:old('phone') }}">
                                            </div>
                                            @error('phone')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="company" class="form-label"> Company</label>
                                                <input type="text" class="form-control" name="company" value="{{ isset($user_detail)?$user_detail->company:old('company') }}">
                                            </div>
                                            @error('company')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        
                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="street_address" class="form-label"> Address</label>
                                                <input type="text" class="form-control" name="address" value="{{ isset($user_detail)?$user_detail->address:old('address') }}">
                                            </div>
                                            @error('address')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="country" class="form-label"> Country	</label>
                                                <input type="text" class="form-control" name="country" value="{{ isset($user_detail)?$user_detail->country:old('country') }}">
                                            </div>
                                            @error('country')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="state" class="form-label">State</label>
                                                <input type="text" class="form-control" name="state" value="{{ isset($user_detail)?$user_detail->state:old('state') }}">
                                            </div>
                                            @error('state')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="city" class="form-label">City</label>
                                                <input type="text" class="form-control" name="city" value="{{ isset($user_detail)?$user_detail->city:old('city') }}">
                                            </div>
                                            @error('city')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>




                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="last_name" class="form-label">Postal Code</label>
                                                <input type="text" class="form-control" name="zipcode" value="{{ isset($user_detail)?$user_detail->zipcode:old('zipcode') }}">
                                            </div>
                                            @error('zipcode')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                      


                                        
                                     

                                      


                                        <!--end col-->

                                        <!--end col-->
                                    </div>

                                    {{---
                                    <br><br>
                                    <div class="row gy-4">

                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                            <input type="hidden" name="old_image" value="{{ isset($user)?$user->image:old('old_image') }}">
                                                <input type="hidden" name="user_id" value="{{ isset($user)?$user->id:old('user_id') }}">
                                                <input type="submit" class="btn btn-success" value="Submit">
                                            </div>
                                        </div>
                                    </div>
                                    ---}}
                                    <!--end row-->
                                </form>



                            </div>

                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->




        </div> <!-- container-fluid -->
    </div><!-- End Page-content -->

    @include('includes.admin.footer')
</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->



@stop