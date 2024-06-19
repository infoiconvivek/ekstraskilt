@extends('layouts.admin_layout')
@section('content')
@section('title', 'Add Attribute')


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
                            <h4 class="card-title mb-0 flex-grow-1">@if(isset($attribute)) Edit @else Add @endif Attribute</h4>

                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">

                                @if (session('msg'))
                                <div class="alert alert-{{ session('msg_type') }}" role="alert">
                                    {{ session('msg') }}
                                </div>
                                @endif


                                <form method="post" action="{{url('admin/attribute/save')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4">


                                        <div class="col-xxl-12 col-md-12">
                                            <div>
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" name="name" value="{{ isset($attribute)?$attribute->name:old('name') }}">
                                            </div>
                                            @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="type" class="form-label">Type</label>
                                                <select name="type" class="form-control">
                                                    <option value="" @if(isset($attribute) && $attribute->type == '') {{"selected"}} @endif>--Select--</option>
                                                    <option value="dropdown" @if(isset($attribute) && $attribute->type == 'dropdown') {{"selected"}} @endif> Dropdown </option>
                                                    <option value="radio" @if(isset($attribute) && $attribute->type == 'radio') {{"selected"}} @endif> Radio Button </option>
                                                </select>

                                                @error('type')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror

                                            </div>
                                        </div>




                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="name" class="form-label">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="" @if(isset($attribute) && $attribute->status == '') {{"selected"}} @endif>--Select--</option>
                                                    <option value="1" @if(isset($attribute) && $attribute->status == 1) {{"selected"}} @endif selected="">Active</option>
                                                    <option value="0" @if(isset($attribute) && $attribute->status == 0) {{"selected"}} @endif>Inactive</option>
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
                                                <input type="hidden" name="attribute_id" value="{{ isset($attribute)?$attribute->id:old('attribute_id') }}">
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