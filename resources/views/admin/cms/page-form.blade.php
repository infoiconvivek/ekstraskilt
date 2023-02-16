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
                            <h4 class="card-title mb-0 flex-grow-1">@if(isset($page)) Edit @else Add @endif Page</h4>

                        </div><!-- end card header -->

                        <div class="card-body">
                            @if (session('msg'))
                            <div class="alert alert-{{ session('msg_type') }}" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif

                            <form method="post" action="{{url('admin/page/save')}}" enctype="multipart/form-data">
                                @csrf

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs mb-3" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#page" role="tab" aria-selected="false" tabindex="-1">
                                            Page
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#meta" role="tab" aria-selected="true">
                                            Meta
                                        </a>
                                    </li>

                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content  text-muted">

                                    <div class="tab-pane active" id="page" role="tabpanel">
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
                                                </div>
                                                @error('image')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            
                                        <div class="col-xxl-12 col-md-12">
                                            <div>
                                                <label for="descriptions" class="form-label">Content</label>
                                                <textarea class="form-control" name="descriptions"> {{ isset($page)?$page->descriptions:old('descriptions') }}</textarea>
                                            </div>
                                            @error('descriptions')
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

                                            @if(isset($page))
                                            <div class="col-xxl-4 col-md-4">
                                                <div>
                                                    <label for="page" class="form-label">Old Image</label>
                                                    <img src="{{URL::asset($page->image)}}" style="height: 120px; width: 120px;">
                                                </div>

                                            </div>
                                            @endif


                                            <!--end col-->

                                            <!--end col-->
                                        </div>
                                    </div>

                                    <div class="tab-pane show" id="meta" role="tabpanel">
                                        <div class="row gy-4">


                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="meta_title" class="form-label">Meta Title</label>
                                                    <input type="text" class="form-control" name="meta_title" value="{{ isset($page)?$page->meta_title:old('meta_title') }}">
                                                </div>
                                                @error('meta_title')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-12 col-md-12">
                                            <div>
                                                <label for="meta_keyword" class="form-label">Meta Keyword</label>
                                                <textarea class="form-control" name="meta_keyword"> {{ isset($page)?$page->meta_keyword:old('meta_keyword') }}</textarea>
                                            </div>
                                            @error('meta_keyword')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                            </div>

                                            <div class="col-xxl-12 col-md-12">
                                            <div>
                                                <label for="meta_description" class="form-label">Meta Description</label>
                                                <textarea class="form-control" name="meta_description"> {{ isset($page)?$page->meta_description:old('meta_description') }}</textarea>
                                            </div>
                                            @error('meta_description')
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
                                <input type="hidden" name="old_image" value="{{ isset($page)?$page->image:old('old_image') }}">
                                 <input type="hidden" name="page_id" value="{{ isset($page)?$page->id:old('page_id') }}">
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

@stop