<header class="header header-border">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <p class="welcome-msg">post@ekstraskilt.no</p>
            </div>
            <div class="header-right">
                <a href="{{url('contact-us')}}" class="contact d-lg-show"><i class="d-icon-map"></i>Kundeservice</a>
                <a href="{{url('about-us')}}" class="help d-lg-show"><i class="d-icon-info"></i> Trenger hjelp</a>

                <span class="divider"></span>

                @guest
                <a href="#signin" class="login-toggle link-to-tab d-md-show"><i class="d-icon-user"></i> Logg
                    inn</a>
                <span class="delimiter">/</span>
                <a href="#register" class="register-toggle link-to-tab d-md-show ml-0">Registrere</a>
                @endguest

                @auth 
                <a href="{{url('user/myaccount')}}" class=""> <i class="d-icon-user"></i> Dashboard </a>
                @endauth
                <div class="dropdown login-dropdown off-canvas">
                    <div class="canvas-overlay"></div>

                    @include('includes.front.login')

                </div>

            </div>
        </div>
    </div>

    <div class="header-middle sticky-header fix-top sticky-content">
        <div class="container">
            <div class="header-left">
                <a href="#" class="mobile-menu-toggle">
                    <i class="d-icon-bars2"></i>
                </a>
                <a href="{{url('/')}}" class="logo">
                    <img src="{{URL::asset('front/images/logo.svg')}}" alt="logo" />
                </a>

                <div class="header-search hs-simple">
                    <form action="#" class="input-wrapper">
                        <input type="text" class="form-control" name="search" autocomplete="off" placeholder="Hva leter du etter...?" required />
                        <button class="btn btn-search" type="submit" title="submit-button">
                            <i class="d-icon-search"></i>
                        </button>
                    </form>
                </div>

            </div>
            <div class="header-right">
                <a href="tel:0(800) 123-456" class="icon-box icon-box-side">
                    <div class="icon-box-icon mr-0 mr-lg-2">
                        <i class="d-icon-phone"></i>
                    </div>
                    <div class="icon-box-content d-lg-show">
                        <h4 class="icon-box-title">Ring oss nå:</h4>
                        <p>0(800) 123-456</p>
                    </div>
                </a>
                <span class="divider"></span>
                <div class="dropdown wishlist wishlist-dropdown off-canvas">
                    <a href="wishlist.php" class="wishlist-toggle">
                        <i class="d-icon-heart"></i>
                    </a>
                    <div class="canvas-overlay"></div>

                    <div class="dropdown-box scrollable">
                        <div class="canvas-header">
                            <h4 class="canvas-title">ønskeliste</h4>
                            <a href="javascript:;" class="btn btn-dark btn-link btn-icon-right btn-close">Lukk<i class="d-icon-arrow-right"></i><span class="sr-only">ønskeliste</span></a>
                        </div>
                        <div class="products scrollable">
                            <div class="product product-wishlist">
                                <figure class="product-media">
                                    <a href="{{url('products')}}">
                                        <img src="{{URL::asset('front/images/wishlist/product-1.jpg')}}" width="100" height="100" alt="product" />
                                    </a>
                                    <button class="btn btn-link btn-close">
                                        <i class="fas fa-times"></i><span class="sr-only">Lukk</span>
                                    </button>
                                </figure>
                                <div class="product-detail">
                                    <a href="{{url('products')}}" class="product-name">Ekstra skilt</a>
                                    <div class="price-box">
                                        <span class="product-price"><small>Fra</small> 199 kr <small>Ink.
                                                mva</small></span>
                                    </div>
                                </div>
                            </div>

                            <div class="product product-wishlist">
                                <figure class="product-media">
                                    <a href="{{url('products')}}">
                                        <img src="{{URL::asset('front/images/images/wishlist/product-2.jpg')}}" width="100" height="100" alt="product" />
                                    </a>
                                    <button class="btn btn-link btn-close">
                                        <i class="fas fa-times"></i><span class="sr-only">Lukk</span>
                                    </button>
                                </figure>
                                <div class="product-detail">
                                    <a href="{{url('products')}}" class="product-name">Ekstra skilt
                                    </a>
                                    <div class="price-box">
                                        <span class="product-price"><small>Fra</small> 199 kr <small>Ink.
                                                mva</small></span>
                                    </div>
                                </div>
                            </div>

                            <div class="product product-wishlist">
                                <figure class="product-media">
                                    <a href="{{url('products')}}">
                                        <img src="{{URL::asset('front/images/images/wishlist/product-3.jpg')}}" width="100" height="100" alt="product" />
                                    </a>
                                    <button class="btn btn-link btn-close">
                                        <i class="fas fa-times"></i><span class="sr-only">Lukk</span>
                                    </button>
                                </figure>
                                <div class="product-detail">
                                    <a href="{{url('products')}}" class="product-name">Ekstra skilt</a>
                                    <div class="price-box">
                                        <span class="product-price"><small>Fra</small> 199 kr <small>Ink.
                                                mva</small></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <a href="wishlist.php" class="btn btn-dark wishlist-btn mt-4"><span>Gå til
                                ønskeliste</span></a>
                    </div>
                </div>

                <span class="divider"></span>

                <div class="dropdown cart-dropdown type2 off-canvas mr-0 mr-lg-2">
                    <a href="javascript:;" class="cart-toggle label-block link">
                        <div class="cart-label d-lg-show">
                            <span class="cart-name">Handlevogn:</span>
                            <span class="cart-price">$0.00</span>
                        </div>
                        <i class="d-icon-bag"><span class="cart-count">{{App\Helpers\Helper::cartCount()}}</span></i>
                    </a>
                    <div class="canvas-overlay"></div>

                    <div class="dropdown-box">
                        <div class="canvas-header">
                            <h4 class="canvas-title">Handlevogn</h4>
                            <a href="javascript:;" class="btn btn-dark btn-link btn-icon-right btn-close">Lukk<i class="d-icon-arrow-right"></i><span class="sr-only">Cart</span></a>
                        </div>
                        <div class="products scrollable">
                            <div class="product product-cart">
                                <figure class="product-media">
                                    <a href="{{url('products')}}">
                                        <img src="{{URL::asset('front/images/cart/product-1.jpg')}}" alt="product" width="80" height="88" />
                                    </a>
                                    <button class="btn btn-link btn-close">
                                        <i class="fas fa-times"></i><span class="sr-only">Lukk</span>
                                    </button>
                                </figure>
                                <div class="product-detail">
                                    <a href="{{url('products')}}" class="product-name">Sjåfør skilt – For alle
                                        sjåfører med navn
                                        52x11cm</a>
                                    <div class="price-box">
                                        <span class="product-quantity">1</span>
                                        <span class="product-price"><small>Fra</small>225 kr<small>Ink.
                                                mva</small></span>
                                    </div>
                                </div>
                            </div>

                            <div class="product product-cart">
                                <figure class="product-media">
                                    <a href="{{url('products')}}">
                                        <img src="{{URL::asset('front/images/cart/product-2.jpg')}}" alt="product" width="80" height="88" />
                                    </a>
                                    <button class="btn btn-link btn-close">
                                        <i class="fas fa-times"></i><span class="sr-only">Lukk</span>
                                    </button>
                                </figure>
                                <div class="product-detail">
                                    <a href="{{url('products')}}" class="product-name">Ekstra skilt – for
                                        varebiler</a>
                                    <div class="price-box">
                                        <span class="product-quantity">1</span>
                                        <span class="product-price"><small>Fra</small>219 kr<small>Ink.
                                                mva</small></span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="cart-total">
                            <label>Delsum:</label>
                            <span class="price">$139.00</span>
                        </div>

                        <div class="cart-action">
                            <a href="cart.php" class="btn btn-dark btn-link">Se handlekurv</a>
                            <a href="checkout.php" class="btn btn-dark"><span>Gå til utsjekk</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-bottom d-lg-show">
        <div class="container">
            <div class="header-left">
                <nav class="main-nav">
                    <ul class="menu">
                        <li class="active"><a href="{{url('/')}}">Hjem</a></li>
                        <li>
                            <a href="javascript:;">Alle produkte</a>
                            <div class="megamenu">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                                            <ul>
                                                <li><a href="{{url('products')}}" onmouseenter="changeImage('{{URL::asset('front/images/menu/banner-1.jpg')}}','Skilt for sykkelstativ','Skilt med sterkt 01')">Skilt
                                                        for sykkelstativ</a>
                                                <li><a href="{{url('products')}}" onmouseenter="changeImage('{{URL::asset('front/images/menu/banner-2.jpg')}}','ekstraskilt','Skilt med sterkt 02')">Skilt
                                                        for sykkelstativ Uten ekstraskilt logo</a>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                                            <ul>
                                                <li><a href="{{url('products')}}" onmouseenter="changeImage('{{URL::asset('front/images/menu/banner-3.jpg')}}','Bilforhandler Skilt','Skilt med sterkt 03')">Bilforhandler
                                                        Skilt</a>
                                                <li><a href="{{url('products')}}" onmouseenter="changeImage('{{URL::asset('front/images/menu/banner-1.jpg')}}','Sjåførskilt','Skilt med sterkt 04')">Sjåførskilt</a>
                                                <li><a href="{{url('products')}}" onmouseenter="changeImage('{{URL::asset('front/images/menu/banner-2.jpg')}}','Showplate','Skilt med sterkt 05')">Showplate</a>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                                            <ul>
                                                <li><a href="{{url('products')}}" onmouseenter="changeImage('{{URL::asset('front/images/menu/banner-3.jpg')}}','Snøscooter Skilt','Skilt med sterkt 06')">Snøscooter
                                                        Skilt</a>
                                                <li><a href="{{url('products')}}" onmouseenter="changeImage('{{URL::asset('front/images/menu/banner-1.jpg')}}','Skilt for barn','Skilt med sterkt 07')">Skilt
                                                        for barn</a>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 menu-banner menu-banner1 banner banner-fixed">
                                            <figure>
                                                <img src="{{URL::asset('front/images/menu/banner-3.jpg')}}" alt="Menu banner" width="221" height="330" class="menuImg" />
                                            </figure>
                                            <div class="banner-content">
                                                <p class="ttl">Snøscooter Skilt</p>
                                                <p class="subttl">Skilt med sterkt lim.</p>
                                                <a href="{{url('products')}}" class="btn btn-link btn-underline">shop
                                                    now<i class="d-icon-arrow-right"></i></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="javascript:;">Biltilbehør</a>
                            <div class="megamenu megamenu-with-img">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-2">
                                            <ul>
                                                <li><a href="{{url('products')}}"><img src="{{URL::asset('front/images/menu/banner-1.jpg')}}" alt="Menu banner" />N Merker</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-2">
                                            <ul>
                                                <li><a href="{{url('products')}}"><img src="{{URL::asset('front/images/menu/banner-2.jpg')}}" alt="Menu banner" />Beskyttelse</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-2">
                                            <ul>
                                                <li><a href="{{url('products')}}"><img src="{{URL::asset('front/images/menu/banner-3.jpg')}}" alt="Menu banner" />Klistremerker bil</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-2">
                                            <ul>
                                                <li><a href="{{url('products')}}"><img src="{{URL::asset('front/images/menu/banner-1.jpg')}}" alt="Menu banner" />N Merker</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-2">
                                            <ul>
                                                <li><a href="{{url('products')}}"><img src="{{URL::asset('front/images/menu/banner-2.jpg')}}" alt="Menu banner" />Beskyttelse</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-2">
                                            <ul>
                                                <li><a href="{{url('products')}}"><img src="{{URL::asset('front/images/menu/banner-3.jpg')}}" alt="Menu banner" />Klistremerker bil</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <a href="javascript:;">Til hjemmet</a>
                            <ul>
                                <li><a href="{{url('products')}}">Dørskilt</a></li>
                                <li><a href="{{url('products')}}">Lyd absorberende plater med trykk</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{url('products')}}">Marine</a>
                        </li>
                        <li>
                            <a href="javascript:;">Privatrettslige skilt</a>
                            <div class="megamenu">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                                            <h4 class="menu-title">OPPLYSNINGSSKILTER</h4>
                                            <ul>
                                                <li><a href="{{url('products')}}" onmouseenter="changeImage('{{URL::asset('front/images/menu/banner-1.jpg')}}','Kameraskilter','Skilt med sterkt 01')">Kameraskilter</a>
                                                <li><a href="{{url('products')}}" onmouseenter="changeImage('{{URL::asset('front/images/menu/banner-2.jpg')}}','parkeringsskilter','Skilt med sterkt 02')">parkeringsskilter</a>
                                                <li><a href="{{url('products')}}" onmouseenter="changeImage('{{URL::asset('front/images/menu/banner-3.jpg')}}','Barn leker skilt','Skilt med sterkt 03')">Barn
                                                        leker skilt</a>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                                            <h4 class="menu-title">FORBUDSSKILTER</h4>
                                            <ul>
                                                <li><a href="{{url('products')}}" onmouseenter="changeImage('{{URL::asset('front/images/menu/banner-2.jpg')}}','Camping forbudt skilter','Skilt med sterkt 04')">Camping
                                                        forbudt skilter</a>
                                                <li><a href="{{url('products')}}" onmouseenter="changeImage('{{URL::asset('front/images/menu/banner-1.jpg')}}','Røyking forbudt skilter','Skilt med sterkt 05')">Røyking
                                                        forbudt skilter</a>
                                                <li><a href="{{url('products')}}" onmouseenter="changeImage('{{URL::asset('front/images/menu/banner-3.jpg')}}','Privat vei og område skilter','Skilt med sterkt 06')">Privat
                                                        vei og område skilter</a>
                                                <li><a href="{{url('products')}}" onmouseenter="changeImage('{{URL::asset('front/images/menu/banner-2.jpg')}}','Se alle forbudsskilt','Skilt med sterkt 07')">Se
                                                        alle forbudsskilt</a>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                                            <h4 class="menu-title">SKILT TILBEHØR</h4>
                                            <ul>
                                                <li><a href="{{url('products')}}" onmouseenter="changeImage('{{URL::asset('front/images/menu/banner-1.jpg')}}','Oppsettingsutstyr til skilt','Skilt med sterkt 08')">Oppsettingsutstyr
                                                        til skilt</a>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 menu-banner menu-banner1 banner banner-fixed">
                                            <figure>
                                                <img src="{{URL::asset('front/images/menu/banner-3.jpg')}}" alt="Menu banner" width="221" height="330" class="menuImg" />
                                            </figure>
                                            <div class="banner-content">
                                                <p class="ttl">Snøscooter Skilt</p>
                                                <p class="subttl">Skilt med sterkt lim.</p>
                                                <a href="{{url('products')}}" class="btn btn-link btn-underline">shop
                                                    now<i class="d-icon-arrow-right"></i></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="header-right">
                <a href="{{url('products')}}"><i class="d-icon-card"></i>Spesialtilbud</a>
                <a href="javascript:;" class="ml-6 popup-btn">BESTILLE SKILT? SE VIDEO</a>
            </div>
        </div>
    </div>
</header>


<div class="mobile-menu-wrapper">
    <div class="mobile-menu-overlay">
    </div>

    <a class="mobile-menu-close" href="#"><i class="d-icon-times"></i></a>

    <div class="mobile-menu-container scrollable">
        <form action="#" class="input-wrapper">
            <input type="text" class="form-control" name="search" autocomplete="off" placeholder="Search your keyword..." required />
            <button class="btn btn-search" type="submit" title="submit-button">
                <i class="d-icon-search"></i>
            </button>
        </form>

        <ul class="mobile-menu mmenu-anim">
            <li><a href="{{url('/')}}">Hjem</a></li>
            <li><a href="about.php">om oss</a></li>
            <li>
                <a href="javascript:;">Ekstra skilt til bil</a>
                <ul>
                    <li><a href="{{url('product/1')}}">Skilt for sykkelstativ</a>
                    <li><a href="{{url('product/1')}}">Skilt for sykkelstativ Uten ekstraskilt logo</a>
                    <li><a href="{{url('product/1')}}">Bilforhandler Skilt</a>
                    <li><a href="{{url('product/1')}}">Sjåførskilt</a>
                    <li><a href="{{url('product/1')}}">Showplate</a>
                    <li><a href="{{url('product/1')}}">Snøscooter Skilt</a>
                    <li><a href="{{url('product/1')}}">Skilt for barn</a>
                </ul>
            </li>

            <li>
                <a href="javascript:;">Biltilbehør</a>
                <ul>
                    <li><a href="{{url('product/1')}}">N Merker</a></li>
                    <li><a href="{{url('product/1')}}">Beskyttelse</a></li>
                    <li><a href="{{url('product/1')}}">Klistremerker bil</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">Til hjemmet</a>
                <ul>
                    <li><a href="{{url('product/1')}}">Dørskilt</a></li>
                    <li><a href="{{url('product/1')}}">Lyd absorberende plater med trykk</a></li>
                </ul>
            </li>
            <li><a href="{{url('product/1')}}">Marine</a></li>

            <li>
                <a href="javascript:;">Privatrettslige skilt</a>
                <ul>
                    <li>
                        <a href="javascript:;">OPPLYSNINGSSKILTER</a>
                        <ul>
                            <li><a href="{{url('product/1')}}">Kameraskilter</a>
                            <li><a href="{{url('product/1')}}">parkeringsskilter</a>
                            <li><a href="{{url('product/1')}}">Barn leker skilt</a>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">FORBUDSSKILTER</a>
                        <ul>
                            <li><a href="{{url('product/1')}}">Camping forbudt skilter</a>
                            <li><a href="{{url('product/1')}}">Røyking forbudt skilter</a>
                            <li><a href="{{url('product/1')}}">Privat vei og område skilter</a>
                            <li><a href="{{url('product/1')}}">Se alle forbudsskilt</a>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">SKILT TILBEHØR</a>
                        <ul>
                            <li><a href="{{url('product/1')}}">Oppsettingsutstyr til skilt</a>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="{{url('contact-us')}}">kontakt oss</a></li>
        </ul>
    </div>
</div>

<div class="video-popup header_popup">
    <div class="popup-bg"></div>
    <div class="popup-content">
        <iframe src="https://youtube.com/embed/gQojMIhELvM?autoplay=0" class="video"></iframe>
    </div>
</div>

<!-- preloader area start -->
<div id="pre-loader">
    <div class="pre-loader">
        <span></span>
        <span></span>
    </div>
</div>
<!-- preloader area end -->