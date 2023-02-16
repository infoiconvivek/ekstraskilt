@extends('layouts.admin_layout')
@section('content')
@section('title', 'Add Api')


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
                            <h4 class="card-title mb-0 flex-grow-1">Add Api</h4>

                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">

                                @if (session('msg'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('msg') }}
                                </div>
                                @endif


                                @if(isset($page))
                                <form method="post" action="{{url('auth/update-api',['api_id' => ($api->id)])}}" enctype="multipart/form-data">
                                    @else
                                    <form method="post" action="{{url('auth/save-api')}}" enctype="multipart/form-data">
                                        @endif


                                        @csrf
                                        <div class="row gy-4">


                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="api_endpoint" class="form-label">End Point</label>
                                                    <input type="text" class="form-control" name="api_endpoint" value="{{ isset($api)?$api->api_endpoint:old('api_endpoint') }}">
                                                </div>
                                                @error('api_endpoint')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="api_method" class="form-label">Method</label>
                                                    <select name="api_method" class="form-control">
                                                        <option value="" @if(isset($api) && $api->api_method == '') {{"selected"}} @endif>--Select--</option>
                                                        <option value="POST" @if(isset($api) && $api->api_method == 'POST') {{"selected"}} @endif >POST</option>
                                                        <option value="PUT" @if(isset($api) && $api->api_method == 'PUT') {{"selected"}} @endif >PUT</option>
                                                        <option value="PATCH" @if(isset($api) && $api->api_method == 'PATCH') {{"selected"}} @endif>PATCH</option>
                                                        <option value="GET" @if(isset($api) && $api->api_method == 'GET') {{"selected"}} @endif>GET</option>
                                                        <option value="DELETE" @if(isset($api) && $api->api_method == 'DELETE') {{"selected"}} @endif>DELETE</option>
                                                    </select>
                                                </div>
                                                @error('api_method')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>



                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="api_request" class="form-label">Request</label>
                                                   <textarea class="form-control" name="api_request" rows="5">{{ isset($api)?$api->api_request:old('api_request') }}</textarea>
                                                </div>
                                                @error('api_request')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>


                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="api_response" class="form-label">Response</label>
                                                   <textarea class="form-control" name="api_response" rows="5">{{ isset($api)?$api->api_response:old('api_response') }}</textarea>
                                                </div>
                                                @error('api_response')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="api_status" class="form-label">Status</label>
                                                    <select name="api_status" class="form-control">
                                                        <option value="" @if(isset($api) && $api->api_status == '') {{"selected"}} @endif>--Select--</option>
                                                        <option value="Working" @if(isset($api) && $api->api_status == 'Working') {{"selected"}} @endif >Working</option>
                                                        <option value="Completed" @if(isset($api) && $api->api_status == 'Completed') {{"selected"}} @endif >Completed</option>
                                                        <option value="Pending" @if(isset($api) && $api->api_status == 'Pending') {{"selected"}} @endif>Pending</option>
                                                    </select>

                                                </div>
                                                @error('api_status')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>


                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="api_comment" class="form-label">Comment</label>
                                                   <textarea class="form-control" name="api_comment">{{ isset($api)?$api->api_comment:old('api_comment') }}</textarea>
                                                </div>
                                                @error('api_comment')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                 


                                            <!--end col-->

                                            <!--end col-->
                                        </div>

                                        <br><br>
                                        <div class="row gy-4">

                                            <div class="col-xxl-3 col-md-6">
                                                <div>
                                                    <input type="hidden" name="api_id" value="{{ isset($api)?$api->id:old('api_id') }}">
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