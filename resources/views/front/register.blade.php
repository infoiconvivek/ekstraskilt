@extends('layouts.front_layout')
@section('content')
@section('title', 'Registration')


<!--page title start-->
@php 
$innerBanner = App\Helpers\Helper::getInnerBanner('register');
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
$content = App\Helpers\Helper::getPageSectionData('29');
@endphp
  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-6">
          <div class="white-bg box-shadow p-5">
            <div class="section-title text-center">
              <h2 class="title mb-0">{{$content->title}} <span>{{$content->sub_title}}</span></h2>
            </div>

            @if (session('msg'))
            <div class="alert alert-success" role="alert">
              {{ session('msg') }}
            </div>
            @endif
            <form method="post" action="{{url('user-auth/register')}}">
              @csrf
              <div class="messages"></div>

              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label>User Name</label>
                    <input id="form_name" type="text" name="username" class="form-control" value="{{old('username')}}">
                    @error('username')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label>Password</label>
                    <input id="form_password" type="password" name="password" class="form-control">
                    @error('password')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label>Confirm Password</label>
                    <input id="form_password" type="password" name="password_confirmation" class="form-control">
                    @error('password_confirmation')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label>First Name</label>
                    <input id="form_name" type="text" name="first_name" class="form-control" value="{{old('first_name')}}">
                    @error('first_name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label>Last Name</label>
                    <input id="form_name" type="text" name="last_name" class="form-control" value="{{old('last_name')}}">
                    @error('last_name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label>Company Name</label>
                    <input id="form_name" type="text" name="company" class="form-control" value="{{old('company')}}">
                    @error('company')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label>Title</label>
                    <input id="form_name" type="text" name="title" class="form-control" value="{{old('title')}}">
                    @error('title')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label>Address</label>
                    <input id="form_name" type="text" name="address" class="form-control" value="{{old('address')}}">
                    @error('address')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label>Country/Region</label>
                    <select class="form-control" name="country">
                      <option value="">--Select--</option>
                      @foreach($countries as $country)
                      <option value="{{$country->name}}"> {{$country->name}} </option>
                      @endforeach
                    </select>
                    @error('country')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label>State</label>
                    <input id="form_name" type="text" name="state" class="form-control" value="{{old('state')}}">
                    @error('state')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>
              </div>


              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label>City</label>
                    <input id="form_name" type="text" name="city" class="form-control" value="{{old('city')}}">
                    @error('city')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label>Zip</label>
                    <input id="form_name" type="text" name="zipcode" class="form-control" value="{{old('zipcode')}}">
                    @error('zipcode')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>
              </div>


              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label>Phone</label>
                    <input id="form_name" type="text" name="phone" class="form-control" value="{{old('phone')}}">
                    @error('phone')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label>E-mail</label>
                    <input id="form_name" type="text" name="email" class="form-control" value="{{old('email')}}">
                    @error('email')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <input class="form-check-input" type="checkbox" value="" id="check1">
                    <label class="form-check-label" for="check1">Yes, I wish to receive Prof-UIS news by e-mail</label>
                  </div>
                </div>
              </div>

             



              <button type="submit" class="btn btn-theme"><span>Register Now</span></button>
            </form>
            <div class="d-flex align-items-center text-center justify-content-center mt-4">
              <span class="text-black me-1">Already an account holder?</span><a href="{{url('login')}}">Login</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>





  @stop