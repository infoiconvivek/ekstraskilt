@extends('layouts.admin_layout')
@section('content')
@section('title', 'Add Page Section')


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
                            <h4 class="card-title mb-0 flex-grow-1">@if(isset($section)) Edit @else Add @endif Page Section</h4>

                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">

                                @if (session('msg'))
                                <div class="alert alert-{{ session('msg_type') }}" role="alert">
                                    {{ session('msg') }}
                                </div>
                                @endif


                                <form method="post" action="{{url('admin/page-section/save')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4">

                                    <div class="col-xxl-6 col-md-6">
                                            <div>
                                                <label for="name" class="form-label">Page</label>
                                                <select name="page_id" class="form-control">
                                                    <option value="" @if(isset($section) && $section->status == '') {{"selected"}} @endif>--Select--</option>
                                                    @foreach($pages as $page)
                                                    <option value="{{$page->id}}" @if(isset($section) && $section->page_id == $page->id) {{"selected"}} @endif>{{$page->title}}</option>
                                                    @endforeach
                                                </select>

                                                @error('status')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-xxl-6 col-md-6">
                                            <div>
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" class="form-control" name="title" value="{{ isset($section)?$section->title:old('title') }}">
                                            </div>
                                            @error('title')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-6 col-md-6">
                                            <div>
                                                <label for="title" class="form-label">Sub Title</label>
                                                <input type="text" class="form-control" name="sub_title" value="{{ isset($section)?$section->sub_title:old('sub_title') }}">
                                            </div>
                                            @error('sub_title')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                       
                                        <div class="col-xxl-12 col-md-12">
                                            <div>
                                                <label for="short_desc" class="form-label">Short Description</label>
                                                <textarea class="form-control" name="short_desc"> {{ isset($section)?$section->short_desc:old('short_desc') }}</textarea>
                                            </div>
                                            @error('short_desc')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    


                                        <div class="col-xxl-12 col-md-12">
                                            <div>
                                                <label for="descriptions" class="form-label">Description</label>
                                                <textarea class="form-control" name="descriptions"> {{ isset($section)?$section->descriptions:old('descriptions') }}</textarea>
                                            </div>
                                            @error('descriptions')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-6 col-md-6">
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
                                                    <option value="" @if(isset($section) && $section->status == '') {{"selected"}} @endif>--Select--</option>
                                                    <option value="1" @if(isset($section) && $section->status == 1) {{"selected"}} @endif selected="">Active</option>
                                                    <option value="0" @if(isset($section) && $section->status == 0) {{"selected"}} @endif>Inactive</option>
                                                </select>

                                                @error('status')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror

                                            </div>
                                        </div>

                                        @if(isset($section))
                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="image" class="form-label">Old Image</label>
                                                <img src="{{URL::asset($section->image)}}" style="height: 120px; width: 120px;">
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
                                                <input type="hidden" name="old_image" value="{{ isset($section)?$section->image:old('old_image') }}">
                                                <input type="hidden" name="page_section_id" value="{{ isset($section)?$section->id:old('page_section_id') }}">
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

<script>
CKEDITOR.replace( 'descriptions' );
</script>

@stop