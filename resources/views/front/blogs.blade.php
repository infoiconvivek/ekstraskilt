@extends('layouts.front_layout')
@section('content')
@section('title', 'Blog')



<main class="main">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{url('/')}}"><i class="d-icon-home"></i></a></li>
                <li><a href="#" class="active">Blog</a></li>
                <li>all blog</li>
            </ul>
        </div>
    </nav>
    <div class="page-content with-sidebar">
        <div class="container">
            <div class="row gutter-lg">
                <div class="col-lg-12">
                    <div class="posts row mb-4">

                    @foreach ($blogs as $blog)
                        <article class="col-md-4 post post-frame overlay-zoom">
                            <figure class="post-media">
                                <a href="{{url('blog/'.$blog->slug)}}">
                                    <img src="{{URL::asset($blog->image)}}" alt="Blog post" width="340" height="206"
                                        style="background-color: #919fbc;" />
                                </a>
                            </figure>
                            <div class="post-details">
                                <h4 class="post-title"><a href="{{url('blog/'.$blog->slug)}}">{{$blog->title}}</a></h4>
                                <p class="post-content">{{ Str::of($blog->short_desc)->limit(100)}} </p>
                                <a href="{{url('blog/'.$blog->slug)}}" class="btn btn-primary btn-link btn-underline">CONTINUE
                                    READING<i class="d-icon-arrow-right"></i></a>
                            </div>
                        </article>
                        @endforeach
                       
                    </div>

                   
                </div>
                
            </div>
        </div>
    </div>
</main>


    @stop