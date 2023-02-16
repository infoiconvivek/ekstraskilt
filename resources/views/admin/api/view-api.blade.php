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

            <div class="row justify-content-evenly">

                <div class="col-lg-12">
                    <div class="mt-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0 me-1">
                                <i class="ri-question-line fs-24 align-middle text-success me-1"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-16 mb-0 fw-semibold">View API</h5>
                            </div>
                        </div>

                        <div class="accordion accordion-border-box" id="genques-accordion">
                            <div class="accordion-item shadow">
                                <h2 class="accordion-header" id="genques-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseOne" aria-expanded="false" aria-controls="genques-collapseOne">
                                    End Point
                                    </button>
                                </h2>
                                <div id="genques-collapseOne" class="accordion-collapse collapse" aria-labelledby="genques-headingOne" data-bs-parent="#genques-accordion" style="">
                                    <div class="accordion-body">
                                    {{ isset($api->api_endpoint)?$api->api_endpoint:'End Point not available.' }}
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item shadow">
                                <h2 class="accordion-header" id="genques-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseTwo" aria-expanded="false" aria-controls="genques-collapseTwo">
                                    Method
                                    </button>
                                </h2>
                                <div id="genques-collapseTwo" class="accordion-collapse collapse" aria-labelledby="genques-headingTwo" data-bs-parent="#genques-accordion" style="">
                                    <div class="accordion-body">
                                    {{ isset($api->api_method)?$api->api_method:'Method not available.' }}
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item shadow">
                                <h2 class="accordion-header" id="genques-headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseThree" aria-expanded="false" aria-controls="genques-collapseThree">
                                    Request
                                    </button>
                                </h2>
                                <div id="genques-collapseThree" class="accordion-collapse collapse" aria-labelledby="genques-headingThree" data-bs-parent="#genques-accordion" style="">
                                    <div class="accordion-body">
                                    {{ isset($api->api_request)?$api->api_request:'Request not available.' }}
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item shadow">
                                <h2 class="accordion-header" id="genques-headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseFour" aria-expanded="false" aria-controls="genques-collapseFour">
                                    Response
                                    </button>
                                </h2>
                                <div id="genques-collapseFour" class="accordion-collapse collapse" aria-labelledby="genques-headingFour" data-bs-parent="#genques-accordion" style="">
                                    <div class="accordion-body">
                                    {{ isset($api->api_response)?$api->api_response:'Response not available.' }}
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item shadow">
                                <h2 class="accordion-header" id="genques-headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseFive" aria-expanded="false" aria-controls="genques-collapseFive">
                                    Status
                                    </button>
                                </h2>
                                <div id="genques-collapseFive" class="accordion-collapse collapse" aria-labelledby="genques-headingFive" data-bs-parent="#genques-accordion" style="">
                                    <div class="accordion-body">
                                    {{ isset($api->api_status)?$api->api_status:'Status not available.' }}
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item shadow">
                                <h2 class="accordion-header" id="genques-headingSix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseSix" aria-expanded="false" aria-controls="genques-collapseSix">
                                    Comment
                                    </button>
                                </h2>
                                <div id="genques-collapseSix" class="accordion-collapse collapse" aria-labelledby="genques-headingSix" data-bs-parent="#genques-accordion" style="">
                                    <div class="accordion-body">
                                    {{ isset($api->api_comment)?$api->api_comment:'Comment not available.' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end accordion-->
                    </div>
                </div>




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