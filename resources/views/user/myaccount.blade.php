@extends('layouts.front_layout')
@section('content')
@section('title', 'Login')

<main class="main account">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="index.php"><i class="d-icon-home"></i></a></li>
                <li>Account</li>
            </ul>
        </div>
    </nav>

    <div class="page-content mt-4 mb-10 pb-6">
        <div class="container">
            <h2 class="title title-center mb-10">My Account</h2>

            <div class="tab tab-vertical gutter-lg">

                @include('user.sidebar')


                <div class="tab-content col-lg-9 col-md-8">
                    <div class="tab-pane active" id="dashboard">
                        <p class="mb-0">
                            Hello <span>{{Auth::user()->first_name}}</span> (not <span>{{Auth::user()->first_name}}</span>? <a href="{{url('user/logout')}}" class="text-primary">Log
                                out</a>)
                        </p>
                        <p class="mb-8">
                            From your account dashboard you can view your
                            <a href="#orders" class="link-to-tab text-primary">recent orders, manage your
                                shipping and
                                billing
                                addresses,<br>and edit your password and account details</a>.
                        </p>
                        <a href="{{url('/')}}" class="btn btn-dark btn-rounded">Go To Shop<i class="d-icon-arrow-right"></i></a>
                    </div>
                
                
                
                </div>
            </div>
        </div>
    </div>
</main>


@stop