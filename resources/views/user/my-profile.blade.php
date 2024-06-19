@extends('layouts.front_layout')
@section('content')
@section('title', 'My Profile')

<main class="main account">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{url('/')}}"><i class="d-icon-home"></i></a></li>
                <li>My Account</li>
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

                        @if (session('msg'))
                        <span style="color: green;">
                            {{ session('msg') }}
                        </span>
                        <br>
                        @endif
                        <form action="{{url('user/update-profile')}}" method="post" class="form">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>First Name *</label>
                                    <input type="text" class="form-control" name="first_name" value="{{$user->first_name}}">
                                    @error('first_name')
                                    <span class="error">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label>Last Name *</label>
                                    <input type="text" class="form-control" name="last_name" value="{{$user->last_name}}">
                                    @error('last_name')
                                    <span class="error">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Email Address *</label>
                                    <input type="email" class="form-control" name="email" value="{{$user->email}}" readonly>
                                    @error('email')
                                    <span class="error">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label>Phone Number *</label>
                                    <input type="text" class="form-control" name="phone" value="{{$user->phone}}">
                                    @error('phone')
                                    <span class="error">{{$message}}</span>
                                    @enderror
                                </div>

                            </div>

                            <label>Address *</label>
                            <input type="text" class="form-control" name="address" value="{{$details->address}}">
                            @error('address')
                            <span class="error">{{$message}}</span>
                            @enderror

                            <label>City *</label>
                            <input type="text" class="form-control" name="city" value="{{$details->city}}">
                            @error('city')
                            <span class="error">{{$message}}</span>
                            @enderror

                            <label>Zip Code *</label>
                            <input type="text" class="form-control" name="zip_code" value="{{$details->zip_code}}">
                            @error('zip_code')
                            <span class="error">{{$message}}</span>
                            @enderror
                            <br>
                            <button type="submit" class="btn btn-primary">SAVE CHANGES</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>


@stop