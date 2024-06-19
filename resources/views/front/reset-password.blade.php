@extends('layouts.front_layout')
@section('content')
@section('title', 'Reset Password')


<div id="page" class="full-page">
    @include('includes/front/header')
    <main id="content" class="site-main">
        <!-- Inner Banner html start-->
        <section class="inner-banner-wrap">
            <div class="inner-baner-container" style="background-image: url({{URL::asset('front/images/inner-banner.jpg')}});">
                <div class="container">
                    <div class="inner-banner-content">
                        <h1 class="inner-title">Reset Password </h1>
                    </div>
                </div>
            </div>
            <div class="inner-shape"></div>
        </section>
        <!-- Inner Banner html end-->

        <!-- Middle content -->
        <section class="section">
            <div class="login-signup">
                <div class="global-container">
                    <div class="card login-form">
                        <div class="card-body">
                            <h3 class="card-title text-center">Reset Password</h3>
                            <div class="card-text">
                               
                                @if (session('msg'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('msg') }}
                                </div>
                                @endif
                                <form method="post" action="{{url('update-user-email-password')}}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">New Password</label>
                                        <input type="password" class="form-control form-control-sm" name="password" placeholder="">
                                        @error('password')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Confirm Password</label>
                                        <input type="password" class="form-control form-control-sm" name="password_confirmation" placeholder="">
                                        @error('password_confirmation')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="pswtoken" value="{{request()->get('pswtoken')}}">
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>

                                   
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- Middle content -->



    </main>


    @stop