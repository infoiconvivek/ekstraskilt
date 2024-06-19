@extends('layouts.admin_layout')
@section('content')
@section('title', 'Payment List')

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
                            <h4 class="card-title mb-0 flex-grow-1">Payment List</h4>
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
                                                <th>S.No</th>
                                                <th>Email Id</th>
                                                <th>Confirmation No.</th>
                                                <th>Amount </th>
                                                <th>Stripe Customer</th>
                                                <th>Charge Id</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            @foreach($payments as $key=>$payment)
                                            <tr>
                                            <td>{{$key+1+($payments->currentPage()-1) * ($payments->perPage())}}</td>
                                                <td>{{ $payment->user->email ?? '-' }} </td>
                                                <td>{{ $payment->confirmation_num ?? '-' }}</td>
                                                <td>{{ $payment->currency ?? '-' }} {{ $payment->amount ?? '-' }}</td>
                                                <td>{{ $payment->customer_id ?? '-' }}</td>
                                                <td>{{ $payment->charge_id ?? '-' }}</td>
                                                <td>@if ($payment->status == 1)  Success @elseif($payment->status == 2) Refunded @else Failled @endif</td>
                                               
                                                @endforeach
                                            </tr>

                                        </tbody>

                                    </table>

                                    {{$payments->links()}}
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