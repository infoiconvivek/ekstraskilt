@extends('layouts.admin_layout')
@section('content')
@section('title', 'Add Materiale')


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
                            <h4 class="card-title mb-0 flex-grow-1">@if(isset($materiale)) Edit @else Add @endif Materiale</h4>
                            <div class="flex-shrink-0">
                                <a href="{{url('admin/materiale')}}" class="btn btn-info">Back</a>
                            </div>

                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">

                                @if (session('msg'))
                                <div class="alert alert-{{ session('msg_type') }}" role="alert">
                                    {{ session('msg') }}
                                </div>
                                @endif


                                <form method="post" action="{{url('admin/materiale/save')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4">


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" class="form-control" name="title" value="{{ isset($materiale)?$materiale->title:old('title') }}">
                                            </div>
                                            @error('title')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="image" class="form-label">Icon Image</label>
                                                <input type="file" class="form-control" name="image">
                                            </div>
                                            @error('image')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="svg" class="form-label">SVG Image</label>
                                                <input type="file" class="form-control" name="svg">
                                            </div>
                                            @error('svg')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-12 col-md-12">
                                            <div>
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" name="description"> {{ isset($materiale)?$materiale->description:old('description') }} </textarea>
                                            </div>
                                            @error('description')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="order_by" class="form-label">Order By</label>
                                                <input type="text" class="form-control" name="order_by" value="{{ isset($materiale)?$materiale->order_by:old('order_by') }}">
                                            </div>
                                            @error('order_by')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="name" class="form-label">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="" @if(isset($materiale) && $materiale->status == '') {{"selected"}} @endif>--Select--</option>
                                                    <option value="1" @if(isset($materiale) && $materiale->status == 1) {{"selected"}} @endif selected="">Active</option>
                                                    <option value="0" @if(isset($materiale) && $materiale->status == 0) {{"selected"}} @endif>Inactive</option>
                                                </select>

                                                @error('status')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror

                                            </div>
                                        </div>

                                        @if(isset($materiale->image))
                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="image" class="form-label">Old Icon Image</label>
                                                <img src="{{URL::asset($materiale->image)}}" style="height: 120px; width: 120px;">
                                            </div>

                                        </div>
                                        @endif

                                        @if(isset($materiale->svg))
                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="image" class="form-label">Old SVG Image</label>
                                                <img src="{{URL::asset($materiale->svg)}}" style="height: 120px; width: 120px;">
                                            </div>

                                        </div>
                                        @endif


                                        <!--end col-->

                                        <!--end col-->
                                    </div>

                                    <br><br>
                                    <div class="row gy-4">

                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <input type="hidden" name="old_image" value="{{ isset($materiale)?$materiale->image:old('old_image') }}">
                                                <input type="hidden" name="materiale_id" value="{{ isset($materiale)?$materiale->id:old('materiale_id') }}">
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