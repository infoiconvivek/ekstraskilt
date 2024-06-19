@extends('layouts.admin_layout')
@section('content')
@section('title', 'Add Blog')


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
                            <h4 class="card-title mb-0 flex-grow-1">@if(isset($download)) Edit @else Add @endif Download</h4>

                        </div><!-- end card header -->

                        <div class="card-body">
                            @if (session('msg'))
                            <div class="alert alert-{{ session('msg_type') }}" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif

                            <form method="post" action="{{url('admin/download/save')}}" enctype="multipart/form-data">
                                @csrf


                                <div class="tab-content  text-muted">

                                    <div class="tab-pane active" id="blog" role="tabpanel">
                                        <div class="row gy-4">

                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="title" class="form-label">Title</label>
                                                    <input type="text" class="form-control" name="title" value="{{ isset($download)?$download->title:old('title') }}">
                                                </div>
                                                @error('title')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="file_title" class="form-label">File Title</label>
                                                    <input type="text" class="form-control" name="file_title" value="{{ isset($download)?$download->file_title:old('file_title') }}">
                                                </div>
                                                @error('file_title')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>


                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="file_extension_name" class="form-label">File Extension Name</label>
                                                    <input type="text" class="form-control" name="file_extension_name" value="{{ isset($download)?$download->file_extension_name:old('file_title') }}">
                                                </div>
                                                @error('file_extension_name')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="file_name" class="form-label">File</label>
                                                    <input type="file" class="form-control" name="file_name">
                                                </div>
                                                @error('file_name')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="descriptions" class="form-label">Description</label>
                                                    <textarea class="form-control" name="descriptions"> {{ isset($download)?$download->descriptions:old('descriptions') }}</textarea>
                                                </div>
                                                @error('descriptions')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>



                                            <div class="col-xxl-4 col-md-4">
                                                <div>
                                                    <label for="name" class="form-label">Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="" @if(isset($download) && $download->status == '') {{"selected"}} @endif>--Select--</option>
                                                        <option value="1" @if(isset($download) && $download->status == 1) {{"selected"}} @endif selected="">Active</option>
                                                        <option value="0" @if(isset($download) && $download->status == 0) {{"selected"}} @endif>Inactive</option>
                                                    </select>

                                                    @error('status')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror

                                                </div>
                                            </div>

                                            @if(isset($download))
                                            <div class="col-xxl-4 col-md-4">
                                                <div>
                                                    <label for="download" class="form-label">Old File:</label>
                                                    <td><a href="{{URL::asset($download->file_name)}}" download>download </a></td>
                                                </div>

                                            </div>
                                            @endif


                                            <!--end col-->

                                            <!--end col-->
                                        </div>
                                    </div>




                                </div>
                                <br>
                                <div class="row gy-4">
                                    <div class="col-xxl-4 col-md-4">
                                        <input type="hidden" name="old_file_name" value="{{ isset($download)?$download->image:old('old_file_name') }}">
                                        <input type="hidden" name="download_id" value="{{ isset($download)?$download->id:old('download_id') }}">
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
    CKEDITOR.replace('descriptions');
</script>

@stop