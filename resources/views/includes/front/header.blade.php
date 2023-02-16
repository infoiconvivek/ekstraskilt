<header class="header">
    <div class="text-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="upper-tap">
                        <p>Podjetje za proizvodnjo prometnih in neprometnih znakov ter obvestil</p>
                        <div class="email">
                            <ul>
                                <li><a href="#"><i class="fa-solid fa-phone"></i> 01 723 09 73</a></li>
                                <li><a href="#"><i class="fa-solid fa-envelope"></i> info@signaco.si</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- top-head -->
    <div class="top-head">
        <div class="container">

            <div class="logo_sec">
                <div class="logo">
                    <a href="{{url('/')}}"><img src="{{URL::asset('front/img/logo.png')}}" alt="Logo" class="img-fluid"></a>
                </div>

                <div class="contact">
                    <ul class="right-ul">
                        <li><a href="tel:"><i class="fa-solid fa-phone"></i> 01 723 09 73</a> <span>(appel local)
                            </span></li>
                        <li><a href="#"><i class="fa-solid fa-user"></i> My Account</a></li>
                        <li><a href="#"><i class="fa-solid fa-cart-shopping"></i> Cart</a></li>
                        <li>
                            <select name="search" id="search" class="custom-select">
                                <option value="en">English</option>
                                <option value="fr">France</option>
                                <option value="en">English</option>
                            </select>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div><!-- /top-head -->

    <header class="header header-border inner-page">
        <div class="header-bottom sticky-content fix-top sticky-header">
            <div class="container">
                <div class="inner-wrap">
                    <div class="header-left">
                        <nav class="main-nav">
                            <ul class="menu active-underline">
                                <li class="active"><a href="{{url('/')}}">Domov</a></li>
                                <li class="has-submenu">
                                    <a href="shop.html">
                                        <i class="fa-solid fa-chevron-down"></i>izdelki
                                    </a>
                                    <ul class="megamenu">
                                        <li>
                                            <ul>
                                                <li><a href="#">Prometni znaki</a></li>
                                                <li><a href="#">Horizontalna signalizacija</a></li>
                                                <li><a href="#">Ostala signalizacija</a></li>
                                                <li><a href="#">Prometna oprema</a></li>
                                                <li><a href="#">Druga oprema</a></li>
                                                <li><a href="#">Katalogi</a></li>
                                                <li><a href="#">Navodila</a></li>
                                                <li><a href="#">Galerija izdelkov</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{url('about-us')}}">O Podjetju</a></li>
                                <li><a href="{{url('signs')}}">Znak Po Meri</a></li>
                                <li><a href="{{url('catalogue')}}">Katalogi</a></li>
                                <li><a href="{{url('contact-us')}}">kontakt</a></li>
                                <li><a href="{{url('news')}}">Novice</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- End of Header -->

</header>