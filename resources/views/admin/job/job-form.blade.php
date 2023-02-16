@extends('layouts.admin_layout')
@section('content')
@section('title', 'Add Job')


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
                            <h4 class="card-title mb-0 flex-grow-1">@if(isset($job)) Edit @else Add @endif Job</h4>

                        </div><!-- end card header -->

                        <div class="card-body">
                            @if (session('msg'))
                            <div class="alert alert-{{ session('msg_type') }}" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif

                            <form method="post" action="{{url('admin/job/save')}}" enctype="multipart/form-data">
                                @csrf

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs mb-3" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#job" role="tab" aria-selected="false" tabindex="-1">
                                            Job
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#patient" role="tab" aria-selected="false" tabindex="-1">
                                        Patient
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#medicalHistory" role="tab" aria-selected="false" tabindex="-1">
                                        Medical History
                                        </a>
                                    </li>
                                   

                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content  text-muted">

                                    <div class="tab-pane active" id="job" role="tabpanel">
                                        <div class="row gy-4">

                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="title" class="form-label">Title</label>
                                                    <input type="text" class="form-control" name="title" value="{{ isset($job)?$job->title:old('title') }}">
                                                </div>
                                                @error('title')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="title" class="form-label">Location</label>
                                                    <input type="text" class="form-control" name="location" value="{{ isset($job)?$job->location:old('location') }}">
                                                </div>
                                                @error('location')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="title" class="form-label">Time From</label>
                                                    <input type="time" class="form-control" name="time_from" value="{{ isset($job)?$job->time_from:old('time_from') }}">
                                                </div>
                                                @error('time_from')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>


                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="title" class="form-label">Time To</label>
                                                    <input type="time" class="form-control" name="time_to" value="{{ isset($job)?$job->time_to:old('time_to') }}">
                                                </div>
                                                @error('time_to')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="name" class="form-label">Position</label>
                                                   
                                                    <select name="position" class="form-control">
                                                        <option value="" @if(isset($job) && $job->position == '') {{"selected"}} @endif>--Select--</option>
                                                         @foreach($positions as $position)
                                                        <option value="{{$position->id}}" @if(isset($job) && $job->position == $position->id) {{"selected"}} @endif >{{$position->title}}</option>
                                                        @endforeach 
                                                        
                                                    </select>

                                                    @error('position')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror

                                                </div>
                                            </div>


                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="name" class="form-label">Group</label>
                                                    <select name="facility" class="form-control">
                                                        <option value="" @if(isset($job) && $job->facility == '') {{"selected"}} @endif>--Select--</option>
                                                        @foreach($facilities as $facility)
                                                        <option value="{{$facility->id}}" @if(isset($job) && $job->facility == $facility->id) {{"selected"}} @endif >{{$facility->title}}</option>
                                                        @endforeach
                                                    </select>

                                                    @error('facility')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="title" class="form-label">Date</label>
                                                    <input type="date" class="form-control" name="date" value="{{ isset($job)?$job->date:old('date') }}">
                                                </div>
                                                @error('date')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>


                                            
                                            
                                        <div class="col-xxl-12 col-md-12">
                                            <div>
                                                <label for="descriptions" class="form-label">Description</label>
                                                <textarea class="form-control" name="descriptions"> {{ isset($job)?$job->descriptions:old('descriptions') }}</textarea>
                                            </div>
                                            @error('descriptions')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                     
                                            <div class="col-xxl-4 col-md-4">
                                                <div>
                                                    <label for="name" class="form-label">Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="" @if(isset($job) && $job->status == '') {{"selected"}} @endif>--Select--</option>
                                                        <option value="1" @if(isset($job) && $job->status == 1) {{"selected"}} @endif selected="">Active</option>
                                                        <option value="0" @if(isset($job) && $job->status == 0) {{"selected"}} @endif>Inactive</option>
                                                        <option value="2" @if(isset($job) && $job->status == 2) {{"selected"}} @endif>Booked</option>
                                                    </select>

                                                    @error('status')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror

                                                </div>
                                            </div>

                                         


                                            <!--end col-->

                                            <!--end col-->
                                        </div>
                                    </div>


                                    <div class="tab-pane" id="patient" role="tabpanel">
                                        <div class="row gy-4">

                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" class="form-control" name="name" value="{{ isset($job)?$job->patient->name:old('name') }}">
                                                </div>
                                                @error('name')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="title" class="form-label">Date of Birth</label>
                                                    <input type="date" class="form-control" name="dob" value="{{ isset($job)?$job->patient->dob:old('dob') }}">
                                                </div>
                                                @error('dob')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="name" class="form-label">Gender</label>
                                                    <select name="gender" class="form-control">
                                                        <option value="" @if(isset($job) && $job->patient->gender == '') {{"selected"}} @endif>--Select--</option>
                                                        <option value="Male" @if(isset($job) && $job->patient->gender == 'Male') {{"selected"}} @endif selected="">Male</option>
                                                        <option value="Female" @if(isset($job) && $job->patient->gender == 'Female') {{"selected"}} @endif>Female</option>
                                                        <option value="Other" @if(isset($job) && $job->patient->gender == 'Other') {{"selected"}} @endif>Other</option>
                                                    </select>

                                                    @error('gender')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="state" class="form-label">Provinces</label>
                                                    <input type="text" class="form-control" name="state" value="{{ isset($job)?$job->patient->state:old('state') }}">
                                                </div>
                                                @error('state')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>


                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="state" class="form-label">City</label>
                                                    <input type="text" class="form-control" name="city" value="{{ isset($job)?$job->patient->city:old('city') }}">
                                                </div>
                                                @error('city')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>


                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="state" class="form-label">Postal Code</label>
                                                    <input type="number" class="form-control" name="zip_code" value="{{ isset($job)?$job->patient->zip_code:old('zip_code') }}" maxlength="6">
                                                </div>
                                                @error('zip_code')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>


                                            <!--end col-->

                                            <!--end col-->
                                        </div>
                                    </div>


                                    <div class="tab-pane" id="medicalHistory" role="tabpanel">
                                        <div class="row gy-4">

                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="history_title" class="form-label">Title</label>
                                                    <input type="text" class="form-control" name="history_title" value="{{ isset($job)?$job->history->history_title:old('history_title') }}">
                                                </div>
                                                @error('history_title')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-12 col-md-12">
                                            <div>
                                                <label for="history_desc" class="form-label">Description</label>
                                                <textarea class="form-control" name="history_desc"> {{ isset($job)?$job->history->history_desc:old('history_desc') }}</textarea>
                                            </div>
                                            @error('history_desc')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                            

                                        



                                            <!--end col-->

                                            <!--end col-->
                                        </div>
                                    </div>


                                


                                </div>
                                  <br>
                                <div class="row gy-4">
                                <div class="col-xxl-4 col-md-4">
                                <input type="hidden" name="old_image" value="{{ isset($job)?$job->image:old('old_image') }}">
                                 <input type="hidden" name="job_id" value="{{ isset($job)?$job->id:old('job_id') }}">
                                <input type="submit" class="btn btn-info" value="submit">
                                </div>
                                </div>

                            </form>
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

<script>
CKEDITOR.replace( 'descriptions' );
</script>

<script>
CKEDITOR.replace( 'desc' );
</script>

@stop