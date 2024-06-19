@extends('layouts.front_layout')
@section('content')
@section('title', 'Distributors')


<!--page title start-->
@php
$innerBanner = App\Helpers\Helper::getInnerBanner('distributors');
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
    <section>
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-12 col-12 mt-6 mt-lg-0">
                    <div class="section-title">

                        {{-- <h2 class="title">{{$page->title}}</h2> --}}
                        {!! $page->descriptions !!}
                    </div>


                    @if (session('msg'))
                    <div class="col-sm-12">
                        <div class="alert alert-success" role="alert">
                            {{ session('msg') }}
                        </div>
                    </div>
                    @endif
                    <form method="post" action="{{url('save-enquiry')}}">
                        @csrf
                        <div class="messages"></div>
                        <div class="form-group">
                            <input id="form_name" type="text" name="name" class="form-control" placeholder="Your Name">
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="form_email" type="email" name="email" class="form-control" placeholder="Email Address">
                            @error('email')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="company" type="text" name="company" class="form-control" placeholder="Company Name or Website">
                            @error('company')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="form_subject" type="text" name="subject" class="form-control" placeholder="Subject">
                            @error('subject')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <textarea id="form_message" name="message" class="form-control" placeholder="Type Message" rows="4"></textarea>
                            @error('message')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <button class="btn btn-theme mt-5" type="submit"> <span>Download Contract</span>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </section>



    @stop