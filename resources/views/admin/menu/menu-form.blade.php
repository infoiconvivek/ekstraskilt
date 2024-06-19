@extends('layouts.admin_layout')
@section('content')
@section('title', 'Add Menu')


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
                            <h4 class="card-title mb-0 flex-grow-1">@if(isset($menu)) Edit @else Add @endif Menu</h4>

                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">

                                @if (session('msg'))
                                <div class="alert alert-{{ session('msg_type') }}" role="alert">
                                    {{ session('msg') }}
                                </div>
                                @endif


                                <form method="post" action="{{url('admin/menu/save')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4">

                                        <div class="col-xxl-6 col-md-6">
                                            <div>
                                                <label for="type" class="form-label">Type</label>
                                                <select name="type" class="form-control">
                                                    <option value="" @if(isset($menu) && $menu->type == '') {{"selected"}} @endif>--Select--</option>
                                                    <option value="header" @if(isset($menu) && $menu->type == 'header') {{"selected"}} @endif>Header</option>
                                                    <option value="footer" @if(isset($menu) && $menu->type == 'footer') {{"selected"}} @endif>Footer</option>
                                                </select>

                                                @error('type')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror

                                            </div>
                                        </div>


                                        <div class="col-xxl-6 col-md-6">
                                            <div>
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" class="form-control" name="menu_title" value="{{ isset($menu)?$menu->menu_title:old('menu_title') }}">
                                            </div>
                                            @error('menu_title')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-6 col-md-6">
                                            <div>
                                                <label for="name" class="form-label">Parent Menu</label>
                                                <select name="parent_id" class="form-control">
                                                    <option value="0" @if(isset($menu) && $menu->parent_id == 0) {{"selected"}} @endif>--Select--</option>
                                                    @foreach($parent_menu as $pmenu)
                                                    <option value="{{$pmenu->id}}" @if(isset($menu) && $menu->parent_id == $pmenu->id) {{"selected"}} @endif>{{$pmenu->menu_title}}</option>
                                                    @endforeach
                                                </select>

                                                @error('parent_id')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-xxl-6 col-md-6">
                                            <div>
                                                <label for="slug" class="form-label">Slug</label>
                                                <input type="text" class="form-control" name="slug" value="{{ isset($menu)?$menu->slug:old('slug') }}">
                                            </div>
                                            @error('slug')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-6 col-md-6">
                                            <div>
                                                <label for="sort_order" class="form-label">Order</label>
                                                <input type="text" class="form-control" name="sort_order" value="{{ isset($menu)?$menu->sort_order:old('sort_order') }}">
                                            </div>
                                            @error('sort_order')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>




                                        <div class="col-xxl-6 col-md-6">
                                            <div>
                                                <label for="name" class="form-label">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="" @if(isset($menu) && $menu->status == '') {{"selected"}} @endif>--Select--</option>
                                                    <option value="1" @if(isset($menu) && $menu->status == 1) {{"selected"}} @endif selected="">Active</option>
                                                    <option value="0" @if(isset($menu) && $menu->status == 0) {{"selected"}} @endif>Inactive</option>
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
                                                <input type="hidden" name="menu_id" value="{{ isset($menu)?$menu->id:old('menu_id') }}">
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