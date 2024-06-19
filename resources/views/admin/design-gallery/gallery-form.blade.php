@extends('layouts.admin_layout')
@section('content')
@section('title', 'Add Gallery')


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
                            <h4 class="card-title mb-0 flex-grow-1">@if(isset($gallery)) Edit @else Add @endif Gallery</h4>

                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">

                                @if (session('msg'))
                                <div class="alert alert-{{ session('msg_type') }}" role="alert">
                                    {{ session('msg') }}
                                </div>
                                @endif


                                <form method="post" action="{{url('admin/design-gallery/save')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4">


                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="title" class="form-label">Name</label>
                                                <input type="text" class="form-control" name="title" value="{{ isset($gallery)?$gallery->title:old('title') }}">
                                            </div>
                                            @error('title')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="type" class="form-label">Type</label>
                                                <select name="type" class="form-control">
                                                    <option value="" @if(isset($gallery) && $gallery->type == '') {{"selected"}} @endif>--Select--</option>
                                                    <option value="1" @if(isset($gallery) && $gallery->type == 1) {{"selected"}} @endif>Image</option>
                                                    <option value="2" @if(isset($gallery) && $gallery->type == 2) {{"selected"}} @endif>Background</option>
                                                </select>

                                                @error('type')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="type" class="form-label">Category</label>
                                                <select name="category_id" class="form-control">
                                                </select>

                                                @error('category_id')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="image" class="form-label">Image</label>
                                                <input type="file" class="form-control" name="image">
                                            </div>
                                            @error('image')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="name" class="form-label">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="" @if(isset($gallery) && $gallery->status == '') {{"selected"}} @endif>--Select--</option>
                                                    <option value="1" @if(isset($gallery) && $gallery->status == 1) {{"selected"}} @endif selected="">Active</option>
                                                    <option value="0" @if(isset($gallery) && $gallery->status == 0) {{"selected"}} @endif>Inactive</option>
                                                </select>

                                                @error('status')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        @if(isset($gallery))
                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="image" class="form-label">Old Image</label>
                                                <img src="{{URL::asset($gallery->image)}}" style="height: 120px; width: 120px;">
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
                                                <input type="hidden" name="old_image" value="{{ isset($gallery)?$gallery->image:old('old_image') }}">
                                                <input type="hidden" name="gallery_id" value="{{ isset($gallery)?$gallery->id:old('gallery_id') }}">
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

<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="type"]').on('change', function() {
            var type_id = $(this).val();
            if(type_id) {
                $.ajax({
                    url: '/ekstraskilt/admin/design-gallery/get-design-category/'+type_id,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {                      
                        $('select[name="category_id"]').empty();
                        $.each(data, function(key, value) {
                        $('select[name="category_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="category_id"]').empty();
            }
        });
    });
</script>

@stop