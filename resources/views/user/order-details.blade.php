@extends('layouts.front_layout')
@section('content')
@section('title', 'Order Detail')


<div id="page" class="full-page">
    @include('includes/front/header')
    <main id="content" class="site-main">
          <!--page title start-->
         <section class="page-title parallaxie" data-bg-img="{{URL::asset('front/images/bg/03.jpg')}}" data-overlay="6">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col">
                        <h1>Order Detail</h1>
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="las la-home me-1"></i>Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Order Detail</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="lines">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </section>
        <!--page title end-->

        <!-- Middle content -->
        <section class="section">
            <div class="login-signup">
                <div class="container">
                    <div class="row profile">
                        <div class="col-md-3">
                            @include('user.sidebar')
                        </div>
                        <div class="col-md-9">

                            <main>
                                <div class="container pt-4">

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
                                    

                                    

                                </div>
                            </main>


                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- Middle content -->



    </main>


    @stop