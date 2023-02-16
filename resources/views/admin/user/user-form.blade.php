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
                            <h4 class="card-title mb-0 flex-grow-1"> @if(isset($user)) Edit @else Add @endif User</h4>

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
                                                <label for="position" class="form-label">Position</label>
                                                <select class="form-control" name="position">
                                                <option value="">-Select-</option>
                                                    @foreach($positions as $position)
                                                     <option value="{{$position->id}}" @if(isset($user_detail) && $user_detail->position == $position->id) {{"selected"}} @endif>{{$position->title}}</option>
                                                 @endforeach
                                                </select>
                                            </div>
                                            @error('position')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="facility" class="form-label">Group</label>
                                                <select class="form-control" name="facility">
                                                <option value="">-Select-</option>
                                                    @foreach($facilities as $facility)
                                                     <option value="{{$facility->id}}" @if(isset($user_detail) && $user_detail->facility == $facility->id) {{"selected"}} @endif>{{$facility->title}}</option>
                                                 @endforeach
                                                </select>
                                            </div>
                                            @error('facility')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="street_address" class="form-label">Street Address</label>
                                                <input type="text" class="form-control" name="street_address" value="{{ isset($user_detail)?$user_detail->street_address:old('street_address') }}">
                                            </div>
                                            @error('street_address')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="apartment" class="form-label">Apartment</label>
                                                <input type="text" class="form-control" name="apartment" value="{{ isset($user_detail)?$user_detail->apartment:old('apartment') }}">
                                            </div>
                                            @error('apartment')
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
                                                <label for="prov" class="form-label">Province</label>
                                                <input type="text" class="form-control" name="prov" value="{{ isset($user_detail)?$user_detail->prov:old('prov') }}">
                                            </div>
                                            @error('prov')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="last_name" class="form-label">Postal Code</label>
                                                <input type="text" class="form-control" name="postal_code" value="{{ isset($user_detail)?$user_detail->postal_code:old('postal_code') }}">
                                            </div>
                                            @error('postal_code')
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
                                                <label for="dob" class="form-label">DOB</label>
                                                <input type="date" class="form-control" name="dob" value="{{ isset($user_detail)?$user_detail->dob:old('dob') }}">
                                            </div>
                                            @error('dob')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="insurance_no" class="form-label">Insurance No</label>
                                                <input type="text" class="form-control" name="insurance_no" value="{{ isset($user_detail)?$user_detail->insurance_no:old('insurance_no') }}">
                                            </div>
                                            @error('insurance_no')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="career" class="form-label">Objective</label>
                                                <select class="form-control" name="career">
                                                <option value="">-Select-</option>
                                                    @foreach($categories as $category)
                                                     <option value="{{$category->title}}" @if(isset($user_detail) && $user_detail->career == $category->title) {{"selected"}} @endif>{{$category->title}}</option>
                                                 @endforeach
                                                </select>
                                            </div>
                                            @error('career')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-4 col-md-4">
                                        @php
                                         //print_r(unserialize($user_detail->user_provided));
                                         if(isset($user_detail) && $user_detail->user_provided)
                                         {
                                            $providedArr = unserialize($user_detail->user_provided);
                                         }
                                         
                                        
                                        @endphp
                                            <div>
                                                <label for="user_provided" class="form-label">I’ve provided UMS with the following</label>
                                           
                                                <br>
                                                    @foreach($provided as $row)
                                                    <input type="checkbox" name="user_provided[]" value="{{$row->title}}" id="{{$row->id}}" <?php if(isset($user_detail) && $providedArr) { echo in_array($row->title,$providedArr)?'checked' :''; } ?>> <label for="{{$row->id}}"  >{{$row->title}}</label> 
                                                    @endforeach
                                            </div>
                                            @error('user_provided')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-4 col-md-4">
                                        @php
                                        if(isset($user_detail) && $user_detail->covid_vaccines)
                                        {
                                            $vaccinesArr = unserialize($user_detail->covid_vaccines);
                                        }
                                         
                                        @endphp
                                            <div>
                                                <label for="covid_vaccines" class="form-label">Covid Vaccines</label>
                                                     <br>
                                                    @foreach($vaccines as $row)
                                                    <input type="checkbox" name="covid_vaccines[]" value="{{$row->title}}" id="co{{$row->id}}"   <?php if(isset($user_detail) && $vaccinesArr) { echo in_array($row->title,$vaccinesArr)?'checked' :''; } ?>>  <label for="co{{$row->id}}">{{$row->title}}</label> 
                                                    @endforeach
                                              
                                            </div>
                                            @error('covid_vaccines')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        @if(!isset($user))
                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" name="password" value="{{ isset($user)?$user->password:old('password') }}">
                                            </div>
                                            @error('password')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        @endif

                                       

                                      

                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="name" class="form-label">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="" @if(isset($user) && $user->status == '') {{"selected"}} @endif>--Select--</option>
                                                    <option value="1" @if(isset($user) && $user->status == 1) {{"selected"}} @endif selected="">Active</option>
                                                    <option value="0" @if(isset($user) && $user->status == 0) {{"selected"}} @endif>Inactive</option>
                                                </select>

                                                @error('status')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror

                                            </div>
                                        </div>

                                      


                                        <!--end col-->

                                        <!--end col-->
                                    </div>

                                    <br><br>
                                    <div class="row gy-4">

                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <input type="hidden" name="user_id" value="{{ isset($user)?$user->id:old('user_id') }}">
                                                <input type="submit" class="btn btn-success" value="Submit">
                                            </div>
                                        </div>
                                    </div>
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