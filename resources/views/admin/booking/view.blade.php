@extends('layouts.admin_layout')
@section('content')
@section('title', 'View Booking')

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
                            <h4 class="card-title mb-0 flex-grow-1">View Booking </h4>
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
                                            <th scope="col">Name</th>
                                            <td>{{$booking->first_name ?? ''}} {{$booking->last_name ?? ''}}</td>
                                            </tr>

                                            <tr>
                                            <th scope="col">Email Id</th>
                                            <td>{{$booking->email ?? ''}} </td>
                                            </tr>


                                            <tr>
                                            <th scope="col">Mobile No</th>
                                            <td>{{$booking->phone ?? ''}} </td>
                                            </tr>


                                            <tr>
                                            <th scope="col">Job Title</th>
                                            <td>{{$booking->title ?? ''}} </td>
                                            </tr>

                                            <tr>
                                            <th scope="col">Job Location</th>
                                            <td>{{$booking->location ?? ''}} </td>
                                            </tr>

                                            <tr>
                                            <th scope="col">Job Time From</th>
                                            <td>{{$booking->time_from ?? ''}} </td>
                                            </tr>


                                            <tr>
                                            <th scope="col">Job Time To</th>
                                            <td>{{$booking->time_to ?? ''}} </td>
                                            </tr>

                                            <tr>
                                            <th scope="col">Job Date</th>
                                            <td>{{$booking->date ?? ''}} </td>
                                            </tr>


                                            <tr>
                                            <th scope="col">Job Descriptions</th>
                                            <td>{!! $booking->descriptions ?? '' !!} </td>
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

@include('includes/admin/delete-model')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        });

        $('.deleteBtn').on('click', function() {
            var row_id = $(this).attr('row_id');
            $('.get_row_id').val(row_id);
            $('#delete_modal').modal('show');
        });

        $('.deleteBtnYs').on('click', function() {
            var row_id = $('.get_row_id').val();
            //alert(row_id);
            var csrf_token = $('input[name="csrf_token"]').val();
            var getUrl = window.location.href+'/delete/' + row_id;
            $.ajax({
                url: getUrl,
                method: "get",
                data: {
                    id: row_id,
                    _token: csrf_token
                },
                beforeSend: function() {
                    $('.get_msg').text('deleting...');
                },
                success: function(data) {
                    $('#delete_modal').modal('hide');
                    $('.get_row_' + row_id).remove();
                }

            });

        });

        $('.deleteBtnNo').on('click', function() {
            $('#delete_modal').modal('hide');
        });

    });
</script>

@stop