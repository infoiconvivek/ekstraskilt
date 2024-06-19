@extends('layouts.front_layout')
@section('content')
@section('title', 'Change Password')

<main class="main account">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{url('/')}}"><i class="d-icon-home"></i></a></li>
                <li>Change Password</li>
            </ul>
        </div>
    </nav>

    <div class="page-content mt-4 mb-10 pb-6">
        <div class="container">
            <h2 class="title title-center mb-10">Change Password</h2>

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
                        <form action="{{url('user/update-user-password')}}" method="post" class="form">
                            @csrf
                        
                            <label>Current password (leave blank to leave unchanged)</label>
                            <input type="password" class="form-control" name="current_password" value="{{old('current_password')}}">
                            @error('current_password')
                            <span class="error">{{$message}}</span>
                            @enderror

                            <label>New password (leave blank to leave unchanged)</label>
                            <input type="password" class="form-control" name="password" value="{{old('password')}}">
                            @error('password')
                            <span class="error">{{$message}}</span>
                            @enderror

                            <label>Confirm new password</label>
                            <input type="password" class="form-control" name="password_confirmation" value="{{old('password_confirmation')}}">
                            @error('password_confirmation')
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