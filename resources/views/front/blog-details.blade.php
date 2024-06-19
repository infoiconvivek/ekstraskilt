@extends('layouts.front_layout')
@section('content')
@section('title', 'Blog')


<main class="main">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li>
                    <a href="{{url('/')}}">
                        <i class="d-icon-home"></i>
                    </a>
                </li>
                <li>
                    <a href="{{url('blogs')}}" class="active">Blog</a>
                </li>
                <li>Blog Detail</li>
            </ul>
        </div>
    </nav>
    <div class="page-content with-sidebar">
        <div class="container">
            <div class="row gutter-lg">
            <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <article class="post-single">
                        <figure class="post-media">
                            <a href="#">
                                <img src="{{URL::asset($blog->image)}}" width="880" height="450" alt="post" />
                            </a>
                        </figure>
                        <div class="post-details">
                            
                            <h4 class="post-title">
                                <a href="javascript:void(0)">{{$blog->title}}</a>
                            </h4>
                            <div class="post-body mb-7">
                               
                               {!! $blog->descriptions !!}
                            </div>
                            
                        
                        </div>
                    </article>

                
                </div>


                <aside class="col-lg-2 right-sidebar sidebar-fixed sticky-sidebar-wrapper">
                    
                </aside>
            </div>
        </div>
    </div>
</main>


    @stop