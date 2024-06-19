@extends('layouts.front_layout')
@section('content')
@section('title', 'Download')

<!--page title start-->
@php 
$innerBanner = App\Helpers\Helper::getInnerBanner('download');
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
    <section class="product-read">
        <div class="container">
            <div class="row">
                    @include('front.sidebar')
                <div class="col-lg-9 col-md-12 order-lg-12">
                    <div class="mt-6">
                        <h3 class="mb-3">MFC Components and Libraries - ProfUIS</h3>
                    </div>
                    <div class="row">



                        @foreach($downloads as $download)
                        <div class="col-lg-12 col-md-6">
                            <div class="cases-item style-3">

                                <h5>{{$download->title}}</h5>
                                <div class="cases-desc">
                                    <div>
                                       {!! $download->descriptions !!}
                                    </div>
                                  
                                </div>
                              
                                <div class="">
                                    <a href="{{url($download->file_name)}}" download> <i class="lar la-file-archive"></i>{{$download->file_title}}</a>  {{$download->file_extension_name}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                        



                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!--body content end--> 




    @stop