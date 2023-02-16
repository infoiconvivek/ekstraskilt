@extends('layouts.admin_layout')
@section('content')
@section('title', 'Add Page')


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
                            <h4 class="card-title mb-0 flex-grow-1">Add Page</h4>

                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">

                                @if (session('msg'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('msg') }}
                                </div>
                                @endif


                                @if(isset($page))
                                <form method="post" action="{{url('auth/update-page',['page_id' => ($page->id)])}}" enctype="multipart/form-data">
                                    @else
                                    <form method="post" action="{{url('auth/save-page')}}" enctype="multipart/form-data">
                                        @endif


                                        @csrf
                                        <div class="row gy-4">


                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="title" class="form-label">Title</label>
                                                    <input type="text" class="form-control" name="title" value="{{ isset($page)?$page->title:old('title') }}">
                                                </div>
                                                @error('title')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="image" class="form-label">Image</label>
                                                    <input type="file" class="form-control" name="image">
                                                    <input type="hidden" class="form-control" name="old_image" value="{{ isset($page)?$page->image:old('old_image') }}">
                                                </div>
                                                @error('image')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            @if(isset($page))
                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="image" class="form-label">Image Preview</label>
                                            @if(file_exists(public_path().'/uploads/pages/'.$page->image) && !empty($page->image))
											<img src="{{ URL::asset('uploads/pages/'.$page->image) }}" height="100px; width:100px;">
											@else
											<img src="{{ URL::asset('admin/images/default.jpg') }}" height="100px; width:100px;">
											@endif

                                                </div>
                                                @error('image')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            @endif

                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="descriptions" class="form-label">Description</label>
                                                   <textarea class="form-control" name="descriptions">{{ isset($page)?$page->descriptions:old('descriptions') }}</textarea>
                                                </div>
                                                @error('description')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="name" class="form-label">Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="" @if(isset($page) && $page->status == '') {{"selected"}} @endif>--Select--</option>
                                                        <option value="1" @if(isset($page) && $page->status == 1) {{"selected"}} @endif selected="">Active</option>
                                                        <option value="0" @if(isset($page) && $page->status == 0) {{"selected"}} @endif>Inactive</option>
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
                                                    <input type="hidden" name="page_id" value="{{ isset($page)?$page->id:old('page_id') }}">
                                                    <input type="submit" class="btn btn-success" value="Save">
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