@extends('layouts.admin_layout')
@section('content')
@section('title', 'View Enquiry')

<style>
    .live-preview svg {
        width: 15px;
    }
</style>


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

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">View Enquiry</h4>
                            <div class="flex-shrink-0">
                               &nbsp;
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">

                            <div class="live-preview">
                                <div class="table-responsive pb-4">
                                    <table class="table align-middle table-nowrap mb-0">
                                       
                                        <tbody>


                                            <tr>
                                                <th>Name</th>
                                                <td>{{$enquiry->name ?? ''}}</td>                                                
                                            </tr>

                                            <tr>
                                                <th>Email</th>
                                                <td>{{$enquiry->email ?? ''}}</td>                                                
                                            </tr>


                                            <tr>
                                                <th>Mobile</th>
                                                <td>{{$enquiry->mobile ?? ''}}</td>                                                
                                            </tr>


                                            <tr>
                                                <th>Subject</th>
                                                <td>{{$enquiry->subject ?? ''}}</td>                                                
                                            </tr>


                                            <tr>
                                                <th>Message</th>
                                                <td>{{$enquiry->message ?? ''}}</td>                                                
                                            </tr>

                                            <tr>
                                                <th>Date/Time</th>
                                                <td>{{ date('d-M-Y h:i:s A', strtotime($enquiry->created_at))}}</td>                                                
                                            </tr>
                                           

                                        </tbody>

                                    </table>

                                  
                                    <!-- end table -->
                                </div>
                                <!-- end table responsive -->
                            </div>

                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    @include('includes.admin.footer')
</div>
<!-- end main content-->


<!-- END layout-wrapper -->



@stop