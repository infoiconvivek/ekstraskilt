@extends('layouts.admin_layout')
@section('content')
@section('title', 'Page List')

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
                            <h4 class="card-title mb-0 flex-grow-1">Page List</h4>
                            <div class="flex-shrink-0">
                                <a href="{{url('admin/page/create')}}" class="btn btn-info">Add Page</a>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">

                            <div class="live-preview">
                                <div class="table-responsive pb-4">
                                    <table class="table align-middle table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">S.No</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            @forelse($pages as $key=>$row)
                                            <tr row_id="{{$row->id}}" class="get_row_{{$row->id}}">
                                                <td>{{$key+1+($pages->currentPage()-1) * ($pages->perPage())}}</td>
                                                <td><a href="{{url('admin/page-section?pid='.$row->id)}}">{{$row->title}} </a></td>
                                                <td>@if($row->status == 1) <button type="button" class="btn btn-sm btn-light"> Active</button> @else <button type="button" class="btn btn-sm btn-light"> Inactive</button> @endif</td>
                                                <td>
                                                <a class="btn btn-success btn-sm waves-effect waves-light" href="{{url('admin/page-section?pid='.$row->id)}}">
                                                        <i class="fe fe-pencil"></i> View Page Section
                                                    </a>
                                                    <a class="btn btn-info btn-sm waves-effect waves-light" href="{{url('admin/page/edit/'.$row->id)}}">
                                                        <i class="fe fe-pencil"></i> Edit
                                                    </a>
                                                   {{--- <a class="btn btn-danger btn-sm waves-effect waves-light deleteBtn" data-toggle="modal" href="javascript:void(0)" row_id="{{$row->id}}">
                                                        <i class="fe fe-trash"></i> Delete
                                                    </a>
                                                    ---}}
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                               <td colspan="5">Data not found</td> 
                                            </tr>
                                            @endif

                                        </tbody>

                                    </table>

                                    {{$pages->links()}}
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