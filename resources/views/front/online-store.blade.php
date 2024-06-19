@extends('layouts.front_layout')
@section('content')
@section('title', 'Online Store')



<!--page title start-->
@php 
$innerBanner = App\Helpers\Helper::getInnerBanner('online_store');
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
                        @php 
                         $section_content1 = App\Helpers\Helper::getPageSectionData(30);
                         $section_content2 = App\Helpers\Helper::getPageSectionData(31);
                         $section_content3 = App\Helpers\Helper::getPageSectionData(38);
                        @endphp 
                        <h3 class="mb-3">{{$section_content1->title}}</h3>
                        <p>{{$section_content1->short_desc}}</p>
                    </div>
                    <div class="col-lg-12 mt-5">
                        <table class="table table-striped table-hover table-bordered ">
                           <tr>
                                <th rowspan="2" style="width: 40%;">{{$section_content2->title}}</th>
                                <th>{{$section_content2->sub_title}}</th>
                                <th>{{$section_content2->short_desc}}</th>
                            </tr>
                            <tr>
                                <th colspan="2">{!!$section_content2->descriptions!!}</th>
                            </tr>

                            @foreach($categories as $cat_key=>$cat)
                            <tr>
                                <th colspan="3"><i class="las la-folder"></i> <span style="color: blue;">{{$cat->title}} </span> &nbsp;&nbsp; @if($cat_key == 0) {{$section_content1->sub_title}} @endif</th>
                            </tr>
                            @foreach($cat->products as $product)
                            <tr>
                                <td>{{$product->title}} </td>
                                <td>
                                    <form method="post" action="{{url('add-cart')}}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        <input type="hidden" name="price" value="{{$product->price}}">
                                        <input type="hidden" name="category_id" value="{{$product->category_id}}">
                                        <input type="hidden" name="is_renewal" value="0">
                                        <button type="submit">${{$product->price}}<i class="las la-shopping-cart"></i></button>
                                    </form>

                                </td>
                                <td>
                                    <form method="post" action="{{url('add-cart')}}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        <input type="hidden" name="price" value="{{$product->renewal_price}}">
                                        <input type="hidden" name="category_id" value="{{$product->category_id}}">
                                        <input type="hidden" name="is_renewal" value="1">
                                        <button type="submit">${{$product->renewal_price}}<i class="las la-shopping-cart"></i></button>
                                    </form>

                                </td>
                            </tr>
                            @endforeach
                            @endforeach

                        </table>


                        {!!$section_content3->descriptions!!}

                    </div>
                </div>
            </div>
        </div>
    </section>



    @stop
