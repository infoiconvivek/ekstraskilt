@extends('layouts.admin_layout')
@section('content')
@section('title', 'Order List')

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
                            <h4 class="card-title mb-0 flex-grow-1">Order List</h4>
                            <div class="flex-shrink-0">
                                &nbsp;
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">

                            <div class="live-preview">

                                @if (session('msg'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('msg') }}
                                </div>
                                @endif


                                <div class="table-responsive pb-4">
                                    <table class="table align-middle table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                            <th>#</th>
                                                <th>Order Id</th>
                                                <th>Amount </th>
                                                <th>Status</th>
                                                <th>Date/Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                        @foreach($orders as $key=>$order)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $order->id ?? '-' }}</td>
                                                <td>${{ $order->amount ?? '-' }}</td>
                                                <td>@if($order->order_status == 1) Success @else Pending @endif </td>
                                                <td>{{ date('d-M-Y h:i:s A', strtotime($order->created_at))}}</td>
                                                <td>
                                                    <a href="{{url('admin/order/view/'.$order->id)}}" class="btn btn-info btn-sm">View </a> &nbsp;
                                                </td>
                                                @endforeach
                                            </tr>

                                        </tbody>

                                    </table>

                                    {{$orders->links()}}
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


<!-- The Modal -->


<!-- END layout-wrapper -->

@include('includes/admin/delete-model')


@stop