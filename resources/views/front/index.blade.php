@extends('layouts.front_layout')
@section('content')
@section('title', 'Home')


<main class="main home">
    <div class="page-content">
        <section class="intro-section">
            <div class="owl-carousel owl-theme row owl-dot-inner owl-dot-white intro-slider animation-slider cols-1 gutter-no"
                data-owl-options="{
                        'nav': false,
                        'dots': true,
                        'loop': false,
                        'items': 1,
                        'autoplay': false,
                        'autoplayTimeout': 8000
                    }">
                <div class="banner banner-fixed intro-slide1" style="background-color: #46b2e8;">
                    <figure>
                        <img src="{{URL::asset($banner1->image)}}" alt="intro-banner" width="1903" height="630"
                            style="background-color: #34ace5;" />
                    </figure>
                    <div class="container">
                        <div class="banner-content y-50">
                            <h4 class="banner-subtitle font-weight-bold ls-l">
                                <span class="d-inline-block slide-animate"
                                    data-animation-options="{'name': 'fadeInRightShorter', 'duration': '1s', 'delay': '.2s'}">{{$banner1->title}}</span>
                            </h4>
                            <h2 class="banner-title font-weight-bold text-white lh-1 ls-md slide-animate"
                                data-animation-options="{'name': 'fadeInUpShorter', 'duration': '1.2s', 'delay': '1s'}">
                                {{$banner1->title2}}</h2>
                            <p class="slide-animate text-white ls-s mb-7"
                                data-animation-options="{'name': 'fadeInUpShorter', 'duration': '1.2s', 'delay': '1s'}">
                                {{$banner1->desc1}}</p>
                            <a href="{{url('contact-us')}}" class="btn btn-dark btn-rounded slide-animate"
                                data-animation-options="{'name': 'fadeInUpShorter', 'duration': '1s', 'delay': '1.8s'}"><i
                                    class="d-icon-bag"></i> {{$banner1->title3}}<i class="d-icon-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="banner banner-fixed intro-slide2" style="background-color: #dddee0;">
                    <figure>
                        <img src="{{URL::asset($banner2->image)}}" alt="intro-banner" width="1903" height="630"
                            style="background-color: #d8d9d9;" />
                    </figure>
                    <div class="container">
                        <div class="banner-content y-50 ml-auto text-right">
                            <h4 class="banner-subtitle ls-s mb-1 slide-animate"
                                data-animation-options="{'name': 'fadeInUp', 'duration': '.7s'}"><span
                                    class="d-block text-uppercase mb-2">{{$banner2->title}} </span><strong
                                    class="font-weight-semi-bold ls-m">{{$banner2->title2}}</strong></h4>
                            <h2 class="banner-title mb-2 d-inline-block font-weight-bold text-primary slide-animate"
                                data-animation-options="{'name': 'fadeInRight', 'duration': '1.2s', 'delay': '.5s'}">
                                {{$banner2->desc1}}</h2>
                            <p class="slide-animate font-primary ls-s text-dark mb-4"
                                data-animation-options="{'name': 'fadeInUp', 'duration': '1s', 'delay': '1.2s'}">
                                {{$banner2->desc2}}</p>
                            <a href="{{url('contact-us')}}" class="btn btn-dark btn-rounded slide-animate"
                                data-animation-options="{'name': 'fadeInUp', 'duration': '1s', 'delay': '1.4s'}"><i
                                    class="d-icon-bag"></i>{{$banner2->title3}}<i class="d-icon-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="banner banner-fixed video-banner intro-slide3" style="background-color: #dddee0;">
                    <figure>
                        <video src="{{URL::asset($banner3->image)}}" width="1903" height="630"></video>
                    </figure>
                    <div class="container">
                        <div class="banner-content x-50 y-50 text-center">
                            <h4 class="banner-subtitle text-white text-uppercase mb-3 ls-normal slide-animate"
                                data-animation-options="{'name': 'fadeIn', 'duration': '.7s'}"> {{$banner3->title}}
                            </h4>
                            <h2 class="banner-title mb-3 text-white font-weight-bold text-uppercase ls-m slide-animate"
                                data-animation-options="{'name': 'fadeInUp', 'duration': '.7s', 'delay': '.5s'}">
                                {{$banner3->title2}}</h2>
                            <p class="slide-animate mb-7 text-white ls-s font-primary "
                                data-animation-options="{'name': 'fadeInUp', 'duration': '1s', 'delay': '.8s'}">
                                {{$banner3->desc1}}</p>
                            <a href="{{url('contact-us')}}" class="btn btn-dark btn-rounded slide-animate mb-1"
                                data-animation-options="{'name': 'fadeInLeft', 'duration': '1s', 'delay': '1.5s'}"><i
                                    class="d-icon-bag"></i>  {{$banner3->title3}} <i class="d-icon-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-6 appear-animate">
                <div class="service-list">
                    <div class="owl-carousel owl-theme row cols-lg-3 cols-sm-2 cols-1" data-owl-options="{
                                    'items': 3,
                                    'nav': false,
                                    'dots': false,
                                    'loop': true,
                                    'autoplay': false,
                                    'autoplayTimeout': 5000,
                                    'responsive': {
                                        '0': {
                                            'items': 1
                                        },
                                        '576': {
                                            'items': 2
                                        },
                                        '768': {
                                            'items': 3,
                                            'loop': false
                                        }
                                    }
                                }">
                        <div class="icon-box icon-box-side icon-box1 appear-animate" data-animation-options="{
                                        'name': 'fadeInRightShorter',
                                        'delay': '.3s'
                                    }">
                            <i class="icon-box-icon d-icon-truck"></i>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title text-capitalize ls-normal lh-1">Free Shipping &amp;
                                    Return
                                </h4>
                                <p class="ls-s lh-1">Free shipping on orders over $99</p>
                            </div>
                        </div>
                        <div class="icon-box icon-box-side icon-box2 appear-animate" data-animation-options="{
                                        'name': 'fadeInRightShorter',
                                        'delay': '.4s'
                                    }">
                            <i class="icon-box-icon d-icon-service"></i>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title text-capitalize ls-normal lh-1">Customer Support 24/7
                                </h4>
                                <p class="ls-s lh-1">Instant access to perfect support</p>
                            </div>
                        </div>
                        <div class="icon-box icon-box-side icon-box3 appear-animate" data-animation-options="{
                                        'name': 'fadeInRightShorter',
                                        'delay': '.5s'
                                    }">
                            <i class="icon-box-icon d-icon-secure"></i>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title text-capitalize ls-normal lh-1">100% Secure Payment
                                </h4>
                                <p class="ls-s lh-1">We ensure secure payment!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="customer-section pt-10 appear-animate">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-7 mb-4">
                        <figure>
                            <img src="front/images/subpages/customer.jpg" alt="Happy Customer" width="580" height="507"
                                class="banner-radius" style="background-color: #BDD0DE;" />
                        </figure>
                    </div>
                    <div class="col-md-5 mb-4">
                        <h5 class="section-subtitle lh-2 ls-md font-weight-normal">Velkommen til Ekstraskilt.no </h5>
                        <h3 class="section-title lh-1 font-weight-bold">De originale skiltene!</h3>
                        <p class="section-desc text-grey">Ekstra bilskilt, de små skiltene som er på størrelse med
                            kjennemerkene på din bil. Du er kanskje ikke helt klar over det, men dersom du velger å
                            kjøre uten ekstra skilt når kjennemerket er dekket til – Kan man faktisk få flere tusen
                            kroner i bot.</p>
                        <p class="section-desc text-grey">Teamet bak Ekstraskilt har produsert og levert skilt til hele
                            Norge i over 10 år. I dag er ekstraskilt.no en av de fremste leverandørene av sykkelstativ
                            skilt, showplater, privatrettslige skilt, forbudsskilt og mye mer. Vi tør påstå at vi er en
                            av de fremste og mest kompetente aktører på skilt, og vi deler mer enn gjerne vår kunnskap
                            med deg når du er i kontakt med oss.</p>
                        <p class="section-desc text-grey"></p>
                        <p class="section-desc text-grey"></p>

                        <a href="about.php" class="btn btn-dark btn-link btn-underline ls-m">Les artikler om våre
                            produkter<i class="d-icon-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <section class="pt-10 mt-7 appear-animate" data-animation-options="{
                    'delay': '.3s'
                }">
            <div class="container">
                <h2 class="title title-center mb-5">Våre kategorier</h2>
                <div class="row">
                    <div class="col-xs-6 col-lg-3 mb-4">
                        <div class="category category-default1 category-absolute banner-radius overlay-zoom">
                            <a href="products.php">
                                <figure class="category-media">
                                    <img src="front/images/categories/category1.jpg" alt="category" width="280" height="280"
                                        style="background-color: #8c8c8d;" />
                                </figure>
                            </a>
                            <div class="category-content">
                                <h4 class="category-name font-weight-bold ls-l"><a href="products.php">Skilt for
                                        sykkelstativ</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-lg-3 mb-4">
                        <div class="category category-default1 category-absolute banner-radius overlay-zoom">
                            <a href="products.php">
                                <figure class="category-media">
                                    <img src="front/images/categories/category2.jpg" alt="category" width="280" height="280"
                                        style="background-color: #bcbdb7;" />
                                </figure>
                            </a>
                            <div class="category-content">
                                <h4 class="category-name font-weight-bold ls-l"><a href="products.php">Sjåførskilt</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-lg-3 mb-4">
                        <div class="category category-default1 category-absolute banner-radius overlay-zoom">
                            <a href="products.php">
                                <figure class="category-media">
                                    <img src="front/images/categories/category3.jpg" alt="category" width="280" height="280"
                                        style="background-color: #ececef;" />
                                </figure>
                            </a>
                            <div class="category-content">
                                <h4 class="category-name font-weight-bold ls-l"><a
                                        href="products.php">opplysningsskilter</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-lg-3 mb-4">
                        <div class="category category-default1 category-absolute banner-radius overlay-zoom">
                            <a href="products.php">
                                <figure class="category-media">
                                    <img src="front/images/categories/category4.jpg" alt="category" width="280" height="280"
                                        style="background-color: #e8eded;" />
                                </figure>
                            </a>
                            <div class="category-content font-weight-bold">
                                <h4 class="category-name font-weight-bold ls-l"><a
                                        href="products.php">forbudsskilter</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="product-wrapper container appear-animate mt-6 mt-md-10 pt-4 pb-8" data-animation-options="{
                    'delay': '.3s'
                }">
            <h2 class="title title-center mb-5">Bilskilt – 8000+ Solgte</h2>
            <div class="owl-carousel owl-theme row owl-nav-full cols-2 cols-md-3 cols-lg-4" data-owl-options="{
                        'items': 5,
                        'nav': false,
                        'loop': false,
                        'dots': true,
                        'margin': 20,
                        'responsive': {
                            '0': {
                                'items': 2
                            },
                            '768': {
                                'items': 3
                            },
                            '992': {
                                'items': 4,
                                'dots': false,
                                'nav': true
                            }
                        }
                    }">
                <div class="product text-center">
                    <figure class="product-media">
                        <a href="product-detail.php">
                            <img src="front/images/demos/demo1/products/product1.jpg" alt="Blue Pinafore Denim Dress"
                                width="280" height="315" style="background-color: #f2f3f5;" />
                        </a>
                        <div class="product-label-group">
                            <label class="product-label label-new">Popular</label>
                        </div>
                        <div class="product-action-vertical">
                            <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                            <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i
                                    class="d-icon-heart"></i></a>
                        </div>
                        <div class="product-action">
                            <a href="#" class="btn-product btn-quickview" title="Hurtigvisning">Hurtigvisning</a>
                        </div>
                    </figure>
                    <div class="product-details">
                        <div class="product-cat">
                            <a href="product-detail.php">Ekstraskilt</a>
                        </div>
                        <h3 class="product-name">
                            <a href="product-detail.php">Ekstra skilt – for sykkelstativ</a>
                        </h3>
                        <div class="product-price">
                            <span class="price">Fra <strong>199 kr</strong> Ink. mva</span>
                        </div>
                        <div class="ratings-container">
                            <div class="ratings-full">
                                <span class="ratings" style="width:100%"></span>
                                <span class="tooltiptext tooltip-top"></span>
                            </div>
                            <a href="#" class="rating-reviews">( 12 reviews )</a>
                        </div>

                        <a href="product-detail.php" class="btn btn-velg">Velg alternativ</a>
                    </div>
                </div>

                <div class="product text-center">
                    <figure class="product-media">
                        <a href="product-detail.php">
                            <img src="front/images/demos/demo1/products/product1.jpg" alt="Blue Pinafore Denim Dress"
                                width="280" height="315" style="background-color: #f2f3f5;" />
                        </a>
                        <div class="product-label-group">
                            <label class="product-label label-new">10% OFF</label>
                        </div>
                        <div class="product-action-vertical">
                            <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                            <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i
                                    class="d-icon-heart"></i></a>
                        </div>
                        <div class="product-action">
                            <a href="#" class="btn-product btn-quickview" title="Hurtigvisning">Hurtigvisning</a>
                        </div>
                    </figure>
                    <div class="product-details">
                        <div class="product-cat">
                            <a href="product-detail.php">Ekstraskilt</a>
                        </div>
                        <h3 class="product-name">
                            <a href="product-detail.php">Ekstra skilt – for sykkelstativ</a>
                        </h3>
                        <div class="product-price">
                            <span class="price">Fra <strong>199 kr</strong> Ink. mva</span>
                        </div>
                        <div class="ratings-container">
                            <div class="ratings-full">
                                <span class="ratings" style="width:100%"></span>
                                <span class="tooltiptext tooltip-top"></span>
                            </div>
                            <a href="#" class="rating-reviews">( 12 reviews )</a>
                        </div>

                        <a href="product-detail.php" class="btn btn-velg">Velg alternativ</a>
                    </div>
                </div>

                <div class="product text-center">
                    <figure class="product-media">
                        <a href="product-detail.php">
                            <img src="front/images/demos/demo1/products/product1.jpg" alt="Blue Pinafore Denim Dress"
                                width="280" height="315" style="background-color: #f2f3f5;" />
                        </a>
                        <div class="product-action-vertical">
                            <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                            <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i
                                    class="d-icon-heart"></i></a>
                        </div>
                        <div class="product-action">
                            <a href="#" class="btn-product btn-quickview" title="Hurtigvisning">Hurtigvisning</a>
                        </div>
                    </figure>
                    <div class="product-details">
                        <div class="product-cat">
                            <a href="product-detail.php">Ekstraskilt</a>
                        </div>
                        <h3 class="product-name">
                            <a href="product-detail.php">Ekstra skilt – for sykkelstativ</a>
                        </h3>
                        <div class="product-price">
                            <span class="price">Fra <strong>199 kr</strong> Ink. mva</span>
                        </div>
                        <div class="ratings-container">
                            <div class="ratings-full">
                                <span class="ratings" style="width:100%"></span>
                                <span class="tooltiptext tooltip-top"></span>
                            </div>
                            <a href="#" class="rating-reviews">( 12 reviews )</a>
                        </div>

                        <a href="product-detail.php" class="btn btn-velg">Velg alternativ</a>
                    </div>
                </div>

                <div class="product text-center">
                    <figure class="product-media">
                        <a href="product-detail.php">
                            <img src="front/images/demos/demo1/products/product1.jpg" alt="Blue Pinafore Denim Dress"
                                width="280" height="315" style="background-color: #f2f3f5;" />
                        </a>
                        <div class="product-label-group">
                            <label class="product-label label-new">NEW</label>
                        </div>
                        <div class="product-action-vertical">
                            <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                            <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i
                                    class="d-icon-heart"></i></a>
                        </div>
                        <div class="product-action">
                            <a href="#" class="btn-product btn-quickview" title="Hurtigvisning">Hurtigvisning</a>
                        </div>
                    </figure>
                    <div class="product-details">
                        <div class="product-cat">
                            <a href="product-detail.php">Ekstraskilt</a>
                        </div>
                        <h3 class="product-name">
                            <a href="product-detail.php">Ekstra skilt – for sykkelstativ</a>
                        </h3>
                        <div class="product-price">
                            <span class="price">Fra <strong>199 kr</strong> Ink. mva</span>
                        </div>
                        <div class="ratings-container">
                            <div class="ratings-full">
                                <span class="ratings" style="width:100%"></span>
                                <span class="tooltiptext tooltip-top"></span>
                            </div>
                            <a href="#" class="rating-reviews">( 12 reviews )</a>
                        </div>

                        <a href="product-detail.php" class="btn btn-velg">Velg alternativ</a>
                    </div>
                </div>

                <div class="product text-center">
                    <figure class="product-media">
                        <a href="product-detail.php">
                            <img src="front/images/demos/demo1/products/product1.jpg" alt="Blue Pinafore Denim Dress"
                                width="280" height="315" style="background-color: #f2f3f5;" />
                        </a>
                        <div class="product-action-vertical">
                            <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                            <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i
                                    class="d-icon-heart"></i></a>
                        </div>
                        <div class="product-action">
                            <a href="#" class="btn-product btn-quickview" title="Hurtigvisning">Hurtigvisning</a>
                        </div>
                    </figure>
                    <div class="product-details">
                        <div class="product-cat">
                            <a href="product-detail.php">Ekstraskilt</a>
                        </div>
                        <h3 class="product-name">
                            <a href="product-detail.php">Ekstra skilt – for sykkelstativ</a>
                        </h3>
                        <div class="product-price">
                            <span class="price">Fra <strong>199 kr</strong> Ink. mva</span>
                        </div>
                        <div class="ratings-container">
                            <div class="ratings-full">
                                <span class="ratings" style="width:100%"></span>
                                <span class="tooltiptext tooltip-top"></span>
                            </div>
                            <a href="#" class="rating-reviews">( 12 reviews )</a>
                        </div>

                        <a href="product-detail.php" class="btn btn-velg">Velg alternativ</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="banner-group mt-4">
            <div class="container">
                <h2 class="title d-none">Banner Group</h2>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <div class="banner banner-3 overlay-zoom banner-fixed banner-radius content-middle appear-animate"
                            data-animation-options="{'name': 'fadeInLeftShorter', 'duration': '1s', 'delay': '.2s'}">
                            <figure>
                                <img src="front/images/demos/demo1/banners/banner1.jpg" alt="banner" width="380" height="207"
                                    style="background-color: #836648;" />
                            </figure>
                            <div class="banner-content">
                                <h3 class="banner-title text-white mb-1">Skiltklammer</h3>
                                <h4 class="banner-subtitle text-uppercase font-weight-normal text-white">
                                    ø60mm ink tilbehør
                                </h4>
                                <hr class="banner-divider">
                                <a href="products.php" class="btn btn-white btn-link btn-underline">Kjøp<i
                                        class="d-icon-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 mb-4 order-lg-auto order-sm-last">
                        <div class="banner banner-4 banner-fixed banner-radius overlay-effect2 content-middle content-center appear-animate"
                            data-animation-options="{'name': 'fadeIn', 'duration': '1s', 'delay': '.2s'}">
                            <figure>
                                <img src="front/images/demos/demo1/banners/banner2.jpg" alt="banner" width="350" height="177"
                                    style="background-color: #1e1e1e;" />
                            </figure>
                            <div class="banner-content d-flex align-items-center w-100 text-left">
                                <div class="mr-auto mb-4 mb-md-0">
                                    <h4 class="banner-subtitle text-white">
                                        Standardskilt <br><span class="ls-l"> Kamera </span>
                                    </h4>
                                    <h3 class="banner-title text-primary font-weight-bold lh-1 mb-0">skilt</h3>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <div class="banner overlay-zoom banner-5 banner-fixed banner-radius content-middle appear-animate"
                            data-animation-options="{'name': 'fadeInRightShorter', 'duration': '1s', 'delay': '.2s'}">
                            <figure>
                                <img src="front/images/demos/demo1/banners/banner3.jpg" alt="banner" width="380" height="207"
                                    style="background-color: #97928b;" />
                            </figure>
                            <div class="banner-content">
                                <h3 class="banner-title text-white mb-1">Skiltklammer</h3>
                                <h4 class="banner-subtitle text-uppercase font-weight-normal text-white">ø60mm ink
                                    tilbehør
                                </h4>
                                <hr class="banner-divider">
                                <a href="products.php" class="btn btn-white btn-link btn-underline">Kjøp<i
                                        class="d-icon-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="product-wrapper mt-6 mt-md-10 pt-4 mb-10 pb-2 container appear-animate" data-animation-options="{
                    'delay': '.6s'
                }">
            <h2 class="title title-center">Populære Nyheter</h2>
            <div class="owl-carousel owl-theme row cols-2 cols-md-3 cols-lg-4 cols-xl-5" data-owl-options="{
                        'items': 5,
                        'nav': false,
                        'loop': false,
                        'dots': true,
                        'margin': 20,
                        'responsive': {
                            '0': {
                                'items': 2
                            },
                            '768': {
                                'items': 3
                            },
                            '992': {
                                'items': 4
                            },
                            '1200': {
                                'items': 5,
                                'dots': false,
                                'nav': true
                            }
                        }
                    }">
                <div class="product">
                    <figure class="product-media">
                        <a href="product-detail.php">
                            <img src="front/images/demos/demo1/products/product5.jpg" alt="Blue Pinafore Denim Dress"
                                width="220" height="245" style="background-color: #f2f3f5;" />
                        </a>
                        <div class="product-action-vertical">
                            <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                            <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i
                                    class="d-icon-heart"></i></a>
                        </div>
                        <div class="product-action">
                            <a href="#" class="btn-product btn-quickview" title="Hurtigvisning">Hurtigvisning</a>
                        </div>
                    </figure>
                    <div class="product-details">
                        <div class="product-cat">
                            <a href="product-detail.php">FORBUDSSKILT</a>
                        </div>
                        <h3 class="product-name">
                            <a href="product-detail.php">Gjennomgang forbudt – Privat område skilt med symbol og
                                tekst</a>
                        </h3>
                        <div class="product-price">
                            <span class="price"><strong>1,475 kr</strong> Ink. mva</span>
                        </div>
                        <a href="product-detail.php" class="btn btn-velg">Kjøp</a>
                    </div>
                </div>
                <div class="product">
                    <figure class="product-media">
                        <a href="product-detail.php">
                            <img src="front/images/demos/demo1/products/product6.jpg" alt="Blue Pinafore Denim Dress"
                                width="220" height="245" style="background-color: #f2f3f5;" />
                        </a>
                        <div class="product-action-vertical">
                            <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                            <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i
                                    class="d-icon-heart"></i></a>
                        </div>
                        <div class="product-action">
                            <a href="#" class="btn-product btn-quickview" title="Hurtigvisning">Hurtigvisning</a>
                        </div>
                    </figure>
                    <div class="product-details">
                        <div class="product-cat">
                            <a href="product-detail.php">FORBUDSSKILT</a>
                        </div>
                        <h3 class="product-name">
                            <a href="product-detail.php">Gjennomgang forbudt – Privat område skilt med symbol og
                                tekst</a>
                        </h3>
                        <div class="product-price">
                            <span class="price"><strong>1,475 kr</strong> Ink. mva</span>
                        </div>
                        <a href="product-detail.php" class="btn btn-velg">Kjøp</a>
                    </div>
                </div>
                <div class="product">
                    <figure class="product-media">
                        <a href="product-detail.php">
                            <img src="front/images/demos/demo1/products/product7.jpg" alt="Blue Pinafore Denim Dress"
                                width="220" height="245" style="background-color: #f2f3f5;" />
                        </a>
                        <div class="product-action-vertical">
                            <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                            <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i
                                    class="d-icon-heart"></i></a>
                        </div>
                        <div class="product-action">
                            <a href="#" class="btn-product btn-quickview" title="Hurtigvisning">Hurtigvisning</a>
                        </div>
                    </figure>
                    <div class="product-details">
                        <div class="product-cat">
                            <a href="product-detail.php">FORBUDSSKILT</a>
                        </div>
                        <h3 class="product-name">
                            <a href="product-detail.php">Gjennomgang forbudt – Privat område skilt med symbol og
                                tekst</a>
                        </h3>
                        <div class="product-price">
                            <span class="price"><strong>1,475 kr</strong> Ink. mva</span>
                        </div>
                        <a href="product-detail.php" class="btn btn-velg">Kjøp</a>
                    </div>
                </div>
                <div class="product">
                    <figure class="product-media">
                        <a href="product-detail.php">
                            <img src="front/images/demos/demo1/products/product8.jpg" alt="Blue Pinafore Denim Dress"
                                width="220" height="245" style="background-color: #f2f3f5;" />
                        </a>
                        <div class="product-action-vertical">
                            <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                            <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i
                                    class="d-icon-heart"></i></a>
                        </div>
                        <div class="product-action">
                            <a href="#" class="btn-product btn-quickview" title="Hurtigvisning">Hurtigvisning</a>
                        </div>
                    </figure>
                    <div class="product-details">
                        <div class="product-cat">
                            <a href="product-detail.php">FORBUDSSKILT</a>
                        </div>
                        <h3 class="product-name">
                            <a href="product-detail.php">Gjennomgang forbudt – Privat område skilt med symbol og
                                tekst</a>
                        </h3>
                        <div class="product-price">
                            <span class="price"><strong>1,475 kr</strong> Ink. mva</span>
                        </div>
                        <a href="product-detail.php" class="btn btn-velg">Kjøp</a>
                    </div>
                </div>
                <div class="product">
                    <figure class="product-media">
                        <a href="product-detail.php">
                            <img src="front/images/demos/demo1/products/product9.jpg" alt="Blue Pinafore Denim Dress"
                                width="220" height="245" style="background-color: #f2f3f5;" />
                        </a>
                        <div class="product-action-vertical">
                            <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                            <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i
                                    class="d-icon-heart"></i></a>
                        </div>
                        <div class="product-action">
                            <a href="#" class="btn-product btn-quickview" title="Hurtigvisning">Hurtigvisning</a>
                        </div>
                    </figure>
                    <div class="product-details">
                        <div class="product-cat">
                            <a href="product-detail.php">FORBUDSSKILT</a>
                        </div>
                        <h3 class="product-name">
                            <a href="product-detail.php">Gjennomgang forbudt – Privat område skilt med symbol og
                                tekst</a>
                        </h3>
                        <div class="product-price">
                            <span class="price"><strong>1,475 kr</strong> Ink. mva</span>
                        </div>
                        <a href="product-detail.php" class="btn btn-velg">Kjøp</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="banner banner-background parallax text-center" data-option="{'offset': -60}"
            data-image-src="front/images/demos/demo1/parallax.jpg" style="background-color: #2d2f33;">
            <div class="container">
                <div class="banner-content appear-animate"
                    data-animation-options="{'name': 'blurIn', 'duration': '1s', 'delay': '.2s'}">
                    <h4 class="banner-subtitle text-white font-weight-bold ls-l">OVER 8000+ SOLGTE SKILT</h4>
                    <h3 class="banner-title font-weight-bold text-white">Kjøretøy Skilt</h3>
                    <p class="text-white ls-s">Lorem ipsum dolor, sit amet consectetur adipisicing.</p>
                    <a href="#" class="btn btn-primary btn-rounded btn-icon-right">Bestill bilskilt<i
                            class="d-icon-arrow-right"></i></a>
                </div>
            </div>
        </section>

        <section class="blog-post-wrapper mt-6 mt-md-10 pt-7 appear-animate"
            data-animation-options="{'name': 'fadeIn', 'duration': '1s'}">
            <div class="container">
                <h2 class="title title-center">Utvalgte artikler</h2>
                <div class="owl-carousel owl-theme post-slider row cols-lg-3 cols-sm-2 cols-1" data-owl-options="{
                            'nav': false,
                            'dots': true,
                            'margin': 20,
                            'responsive': {
                                '0': {
                                    'items': 1
                                },
                                '576': {
                                    'items': 2
                                },
                                '992': {
                                    'items': 3,
                                    'dots': false
                                }
                            }
                        }">


                    @foreach ($blogs as $blog)
                    
                    <div class="blog-post mb-4">
                        <article class="post post-frame overlay-zoom">
                            <figure class="post-media">
                                <a href="{{url('blog/'.$blog->slug)}}">
                                    <img src="{{URL::asset($blog->image)}}" alt="Blog post" width="340" height="206"
                                        style="background-color: #919fbc;" />
                                </a>
                            </figure>
                            <div class="post-details">
                                <h4 class="post-title"><a href="{{url('blog/'.$blog->slug)}}">{{$blog->title}}</a></h4>
                                <p class="post-content">{{ Str::of($blog->short_desc)->limit(100)}}</p>
                                <a href="{{url('blog/'.$blog->slug)}}" class="btn btn-primary btn-link btn-underline">CONTINUE
                                    READING<i class="d-icon-arrow-right"></i></a>
                            </div>
                        </article>
                    </div>
                    @endforeach

                    
                
                </div>
            </div>
        </section>

        <section class="mt-2 pb-6 pt-10 pb-md-10 appear-animate" data-animation-options="{
                    'delay': '.3s'
                }">
            <h2 class="title d-none">Our Brand</h2>
            <div class="container">
                <div class="owl-carousel owl-theme row brand-carousel cols-xl-6 cols-lg-5 cols-md-4 cols-sm-3 cols-2"
                    data-owl-options="{
                            'nav': false,
                            'dots': false,
                            'autoplay': true,
                            'margin': 20,
                            'loop': true,
                         'responsive': {
                                '0': {
                                    'items': 2
                                },
                                '576': {
                                    'items': 3
                                },
                                '768': {
                                    'items': 4
                                },
                                '992': {
                                    'items': 5
                                },
                                '1200': {
                                    'items': 6
                                }
                            }
                        }">

                    @foreach ($partners as $partner)
                    <figure><img src="{{URL::asset($partner->image)}}" alt="brand" width="180" height="100" /></figure>
                    @endforeach
                    
                    
                </div>
            </div>
        </section>
    </div>
</main>

    @stop