@extends('layouts.front_layout')
@section('content')
@section('title', ' Forgot Password')


<!--page title start-->
<section class="page-title parallaxie" data-bg-img="{{URL::asset('front/images/bg/03.jpg')}}" data-overlay="6">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col">
                <h1> Forgot Password</h1>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="las la-home me-1"></i>Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Forgot Password</li>
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

<!--body content start-->

<div class="page-content">
    <!--login start-->

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="white-bg box-shadow p-5">
                        <div class="section-title text-center">

                        </div>
                        @if (session('msg'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('msg') }}
                        </div>
                        @endif
                        <form method="post" action="{{url('send-reset-pass-link')}}">
                            @csrf
                            <div class="messages"></div>
                            <div class="form-group">
                                <label>Email Id</label>
                                <input id="form_name" type="text" name="email" class="form-control" value="{{old('email')}}">
                                @error('email')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>



                            <button type="submit" class="btn btn-theme"><span>Submit</span></button>
                        </form>
                        <div class="d-flex align-items-center text-center justify-content-center mt-4">
                            <span class="text-black me-1">Don't have an account?</span><a href="{{url('register')}}">Sign Up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





    @stop