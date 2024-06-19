@extends('layouts.admin_layout')
@section('content')
@section('title', 'Add Faq')


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
                            <h4 class="card-title mb-0 flex-grow-1">@if(isset($faq)) Edit @else Add @endif Faq</h4>

                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">

                                @if (session('msg'))
                                <div class="alert alert-{{ session('msg_type') }}" role="alert">
                                    {{ session('msg') }}
                                </div>
                                @endif


                                <form method="post" action="{{url('admin/faq/save')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4">


                                        <div class="col-xxl-12 col-md-12">
                                            <div>
                                                <label for="question" class="form-label">question</label>
                                                <input type="text" class="form-control" name="question" value="{{ isset($faq)?$faq->question:old('question') }}">
                                            </div>
                                            @error('question')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>


                                        <div class="col-xxl-12 col-md-12">
                                            <div>
                                                <label for="answer" class="form-label">Answer</label>
                                                <textarea class="form-control" name="answer"> {{ isset($faq)?$faq->answer:old('answer') }}</textarea>
                                            </div>
                                            @error('answer')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        

                                        <div class="col-xxl-4 col-md-4">
                                            <div>
                                                <label for="name" class="form-label">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="" @if(isset($faq) && $faq->status == '') {{"selected"}} @endif>--Select--</option>
                                                    <option value="1" @if(isset($faq) && $faq->status == 1) {{"selected"}} @endif selected="">Active</option>
                                                    <option value="0" @if(isset($faq) && $faq->status == 0) {{"selected"}} @endif>Inactive</option>
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
                                                <input type="hidden" name="faq_id" value="{{ isset($faq)?$faq->id:old('faq_id') }}">
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