@extends('layouts.front_layout')
@section('content')
@section('title', 'chat')


<!--page title start-->
@php 
$innerBanner = App\Helpers\Helper::getInnerBanner('chat');
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
                      
                       {{-- <h2 class="title">{{$page->title}}</h2>  --}}
                        {!! $page->descriptions !!}
                    </div>
                   
                </div>
            </div>
        </div>
    </section>



  @stop