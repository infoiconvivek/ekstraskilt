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
                            <h4 class="card-title mb-0 flex-grow-1">View Order </h4>
                            <div class="flex-shrink-0">
                                &nbsp;
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">

                            <div class="live-preview">
                                <div class="table-responsive pb-4">

                                <h4> Order Items </h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Category</th>
                                                <th>Amount</th>
                                            </tr>
                                              @foreach($items as $key=>$item)
                                                <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $item->product->title ?? '-' }}</td>
                                                <td>{{ $item->category->title ?? '-' }}</td>
                                                <td>${{ $item->price ?? '-' }}</td>
                                                </tr>
                                               

                                                @endforeach
                                            
                                        </tbody>
                                    </table>

                                    <h4> Order Address Detail </h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <td>{{ $address->first_name ?? '-' }} {{ $address->last_name ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Email Id</th>
                                                <td>{{ $address->email ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Phone No</th>
                                                <td>{{ $address->phone ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Address</th>
                                                <td>{{ $address->address ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Country</th>
                                                <td>{{ $address->country ?? '-' }} </td>
                                            </tr>

                                            <tr>
                                                <th>State</th>
                                                <td>{{ $address->state ?? '-' }} </td>
                                            </tr>

                                            <tr>
                                                <th>City</th>
                                                <td> {{ $address->city ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Zip Code</th>
                                                <td> {{ $address->zipcode ?? '-' }}</td>
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



@stop