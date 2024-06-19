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


                                <h3> customer Detail </h3>
                                    <table class="table table-bordered">
                                        <tbody>
                                             <tr>
                                                <th>Email Id</th>
                                                <td>{{ $booking_detail->customerEmail ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Phone No</th>
                                                <td>{{ $booking_detail->customerPhone ?? '-' }}</td>
                                            </tr>

                                        </tbody>
                                    </table>


                                    <h3> Booking Detail </h3>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Location</th>
                                                <td>{{ $booking->city_name ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Checkin Date</th>
                                                <td>{{ $booking_detail->checkIn ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>checkOut Date</th>
                                                <td>{{ $booking_detail->checkOut ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Days</th>
                                                <td>{{ $booking_detail->days ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>NetPrice</th>
                                                <td>{{ $booking_detail->currency ?? '-' }} {{ $booking_detail->NetPrice ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Fare Type</th>
                                                <td>{{ $booking_detail->fareType ?? '-' }} </td>
                                            </tr>

                                            <tr>
                                                <th>Cancellation Policy</th>
                                                <td> {{ $booking_detail->cancellationPolicy ?? '-' }}</td>
                                            </tr>



                                        </tbody>
                                    </table>
                                    <h3> Room Detail </h3>
                                    <table class="table table-bordered">
                                        <tbody>
                                            @foreach($booking_detail->rooms as $key=>$room)
                                            <tr>
                                                <td>Room: {{ $room->name ?? '-' }}</td>
                                            </tr>
                                            @foreach($room->paxDetails->name as $keypax=>$pax)
                                            <tr>
                                                <td>Pax-{{ $keypax+1 }}: {{ $pax ?? '-' }}</td>
                                            </tr>
                                            @endforeach

                                            @endforeach

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