@extends('layouts.front_layout')
@section('content')
@section('title', 'My Profile')

<main class="main account">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{url('/')}}"><i class="d-icon-home"></i></a></li>
                <li>My Orders</li>
            </ul>
        </div>
    </nav>

    <div class="page-content mt-4 mb-10 pb-6">
        <div class="container">
            <h2 class="title title-center mb-10">My Orders</h2>

            <div class="tab tab-vertical gutter-lg">

                @include('user.sidebar')


                <div class="tab-content col-lg-9 col-md-8">
                    <div class="tab-pane active" id="dashboard">

                    <table class="order-table">
                            <thead>
                                <tr>
                                    <th class="pl-2">Order</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th class="pr-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="order-number"><a href="#">#3596</a></td>
                                    <td class="order-date"><span>February 24, 2022</span></td>
                                    <td class="order-status"><span>On hold</span></td>
                                    <td class="order-total"><span>$900.00 for 5 items</span></td>
                                    <td class="order-action"><a href="#" class="btn btn-primary btn-link btn-underline">View</a></td>
                                </tr>
                                <tr>
                                    <td class="order-number"><a href="#">#3593</a></td>
                                    <td class="order-date"><span>February 21, 2022</span></td>
                                    <td class="order-status"><span>On hold</span></td>
                                    <td class="order-total"><span>$290.00 for 2 items</span></td>
                                    <td class="order-action"><a href="#" class="btn btn-primary btn-link btn-underline">View</a></td>
                                </tr>
                                <tr>
                                    <td class="order-number"><a href="#">#2547</a></td>
                                    <td class="order-date"><span>January 4, 2022</span></td>
                                    <td class="order-status"><span>On hold</span></td>
                                    <td class="order-total"><span>$480.00 for 8 items</span></td>
                                    <td class="order-action"><a href="#" class="btn btn-primary btn-link btn-underline">View</a></td>
                                </tr>
                                <tr>
                                    <td class="order-number"><a href="#">#2549</a></td>
                                    <td class="order-date"><span>January 19, 2022</span></td>
                                    <td class="order-status"><span>On hold</span></td>
                                    <td class="order-total"><span>$680.00 for 5 items</span></td>
                                    <td class="order-action"><a href="#" class="btn btn-primary btn-link btn-underline">View</a></td>
                                </tr>
                                <tr>
                                    <td class="order-number"><a href="#">#4523</a></td>
                                    <td class="order-date"><span>Jun 6, 2022</span></td>
                                    <td class="order-status"><span>On hold</span></td>
                                    <td class="order-total"><span>$564.00 for 3 items</span></td>
                                    <td class="order-action"><a href="#" class="btn btn-primary btn-link btn-underline">View</a></td>
                                </tr>
                                <tr>
                                    <td class="order-number"><a href="#">#4526</a></td>
                                    <td class="order-date"><span>Jun 19, 2022</span></td>
                                    <td class="order-status"><span>On hold</span></td>
                                    <td class="order-total"><span>$123.00 for 8 items</span></td>
                                    <td class="order-action"><a href="#" class="btn btn-primary btn-link btn-underline">View</a></td>
                                </tr>
                            </tbody>
                        </table>  


                    </div>

                </div>
            </div>
        </div>
    </div>
</main>


@stop