@extends('layouts.front_layout')
@section('content')
@section('title', 'Login')


<!--page title start-->
@php 
$innerBanner = App\Helpers\Helper::getInnerBanner('login');
@endphp
<section class="page-title parallaxie" data-bg-img="{{URL::asset($innerBanner->image)}}" data-overlay="6">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col">
                <h1>{{$innerBanner->title}}</h1>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="las la-home me-1"></i>{{$innerBanner->title2}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$innerBanner->title3}}</li>
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
@php 
$content = App\Helpers\Helper::getPageSectionData('28');
@endphp
  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-6">
          <div class="white-bg box-shadow p-5">
            <div class="section-title text-center">
              <h6>{{$content->title}}</h6>
              <h2 class="title mb-0">{{$content->sub_title}} <span>{{$content->short_desc}}</span></h2>
            </div>
            @if (session('msg'))
            <div class="alert alert-danger" role="alert">
              {{ session('msg') }}
            </div>
            @endif
            <form method="post" action="{{url('user-auth/login')}}">
              @csrf
              <div class="messages"></div>
              <div class="form-group">
                <label>User Name</label>
                <input id="form_name" type="text" name="username" class="form-control" value="{{old('username')}}">
                @error('username')
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              <div class="form-group">
                <label>Password</label>
                <input id="form_password" type="password" name="password" class="form-control">
                @error('password')
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              <div class="form-group mt-4 mb-5">
                <div class="remember-checkbox d-flex align-items-center justify-content-between">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="check1">
                    <label class="form-check-label" for="check1">Remember me</label>
                  </div> <a class="btn-link" href="{{url('forgot-password')}}">Forgot Password?</a>
                </div>
              </div>

              <button type="submit" class="btn btn-theme"><span>Login Now</span></button>
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