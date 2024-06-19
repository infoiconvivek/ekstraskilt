@extends('layouts.tool_layout')
@section('content')
@section('title', 'Home')

<style>
    #changeDesignOption {
        display: none;
    }
</style>


<main class="main tool-design">

    <div class="hdr">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="hdr_section">
                        <div class="mobile_logo">
                            <a href="#" class="mobile-menu-toggle"><i class="d-icon-bars2"></i></a>
                            <a href="{{url('tool')}}"><img src="{{URL::asset('tool/img/logo-footer.png')}}" alt="logo" class="img-fluid"></a>
                        </div>

                        <div class="d-lg-show">
                            <div class="header-left">
                                <nav class="main-nav">
                                    <ul class="menu">
                                        <li class="active"><a href="{{url('tool')}}">Hjem</a></li>
                                        <li>
                                            <a href="javascript:;">Alle produkte</a>
                                            <div class="megamenu">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                                                            <ul>
                                                                <li><a href="products.php" onmouseenter="changeImage('../images/menu/banner-1.jpg','Skilt for sykkelstativ','Skilt med sterkt 01')">Skilt
                                                                        for sykkelstativ</a>
                                                                <li><a href="products.php" onmouseenter="changeImage('../images/menu/banner-2.jpg','ekstraskilt','Skilt med sterkt 02')">Skilt
                                                                        for sykkelstativ Uten ekstraskilt logo</a>
                                                            </ul>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                                                            <ul>
                                                                <li><a href="products.php" onmouseenter="changeImage('../images/menu/banner-3.jpg','Bilforhandler Skilt','Skilt med sterkt 03')">Bilforhandler
                                                                        Skilt</a>
                                                                <li><a href="products.php" onmouseenter="changeImage('../images/menu/banner-1.jpg','Sjåførskilt','Skilt med sterkt 04')">Sjåførskilt</a>
                                                                <li><a href="products.php" onmouseenter="changeImage('../images/menu/banner-2.jpg','Showplate','Skilt med sterkt 05')">Showplate</a>
                                                            </ul>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                                                            <ul>
                                                                <li><a href="products.php" onmouseenter="changeImage('../images/menu/banner-3.jpg','Snøscooter Skilt','Skilt med sterkt 06')">Snøscooter
                                                                        Skilt</a>
                                                                <li><a href="products.php" onmouseenter="changeImage('../images/menu/banner-1.jpg','Skilt for barn','Skilt med sterkt 07')">Skilt
                                                                        for barn</a>
                                                            </ul>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 menu-banner menu-banner1 banner banner-fixed">
                                                            <figure>
                                                                <img src="../images/menu/banner-3.jpg" alt="Menu banner" width="221" height="330" class="menuImg" />
                                                            </figure>
                                                            <div class="banner-content">
                                                                <p class="ttl">Snøscooter Skilt</p>
                                                                <p class="subttl">Skilt med sterkt lim.</p>
                                                                <a href="products.php" class="btn btn-link btn-underline">shop
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
                                                                <li><a href="products.php"><img src="../images/menu/banner-1.jpg" alt="Menu banner" />N Merker</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-4 col-lg-2">
                                                            <ul>
                                                                <li><a href="products.php"><img src="../images/menu/banner-2.jpg" alt="Menu banner" />Beskyttelse</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-4 col-lg-2">
                                                            <ul>
                                                                <li><a href="products.php"><img src="../images/menu/banner-3.jpg" alt="Menu banner" />Klistremerker bil</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-4 col-lg-2">
                                                            <ul>
                                                                <li><a href="products.php"><img src="../images/menu/banner-1.jpg" alt="Menu banner" />N Merker</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-4 col-lg-2">
                                                            <ul>
                                                                <li><a href="products.php"><img src="../images/menu/banner-2.jpg" alt="Menu banner" />Beskyttelse</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-4 col-lg-2">
                                                            <ul>
                                                                <li><a href="products.php"><img src="../images/menu/banner-3.jpg" alt="Menu banner" />Klistremerker bil</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                        <li>
                                            <a href="javascript:;">Til hjemmet</a>
                                            <ul>
                                                <li><a href="products.php">Dørskilt</a></li>
                                                <li><a href="products.php">Lyd absorberende plater med trykk</a></li>
                                            </ul>
                                        </li>

                                        <li>
                                            <a href="products.php">Marine</a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">Privatrettslige skilt</a>
                                            <div class="megamenu">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                                                            <h4 class="menu-title">OPPLYSNINGSSKILTER</h4>
                                                            <ul>
                                                                <li><a href="products.php" onmouseenter="changeImage('../images/menu/banner-1.jpg','Kameraskilter','Skilt med sterkt 01')">Kameraskilter</a>
                                                                <li><a href="products.php" onmouseenter="changeImage('../images/menu/banner-2.jpg','parkeringsskilter','Skilt med sterkt 02')">parkeringsskilter</a>
                                                                <li><a href="products.php" onmouseenter="changeImage('../images/menu/banner-3.jpg','Barn leker skilt','Skilt med sterkt 03')">Barn
                                                                        leker skilt</a>
                                                            </ul>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                                                            <h4 class="menu-title">FORBUDSSKILTER</h4>
                                                            <ul>
                                                                <li><a href="products.php" onmouseenter="changeImage('../images/menu/banner-2.jpg','Camping forbudt skilter','Skilt med sterkt 04')">Camping
                                                                        forbudt skilter</a>
                                                                <li><a href="products.php" onmouseenter="changeImage('../images/menu/banner-1.jpg','Røyking forbudt skilter','Skilt med sterkt 05')">Røyking
                                                                        forbudt skilter</a>
                                                                <li><a href="products.php" onmouseenter="changeImage('../images/menu/banner-3.jpg','Privat vei og område skilter','Skilt med sterkt 06')">Privat
                                                                        vei og område skilter</a>
                                                                <li><a href="products.php" onmouseenter="changeImage('../images/menu/banner-2.jpg','Se alle forbudsskilt','Skilt med sterkt 07')">Se
                                                                        alle forbudsskilt</a>
                                                            </ul>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                                                            <h4 class="menu-title">SKILT TILBEHØR</h4>
                                                            <ul>
                                                                <li><a href="products.php" onmouseenter="changeImage('../images/menu/banner-1.jpg','Oppsettingsutstyr til skilt','Skilt med sterkt 08')">Oppsettingsutstyr
                                                                        til skilt</a>
                                                            </ul>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 menu-banner menu-banner1 banner banner-fixed">
                                                            <figure>
                                                                <img src="../images/menu/banner-3.jpg" alt="Menu banner" width="221" height="330" class="menuImg" />
                                                            </figure>
                                                            <div class="banner-content">
                                                                <p class="ttl">Snøscooter Skilt</p>
                                                                <p class="subttl">Skilt med sterkt lim.</p>
                                                                <a href="products.php" class="btn btn-link btn-underline">shop
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
                        </div>

                        <div class="search">
                            <form action="">
                                <div class="search-form">
                                    <input type="search" name="" id="" class="form-control" placeholder="Søk etter produkter">
                                    <button type="submit"><i class="d-icon-search"></i></button>
                                </div>
                            </form>
                        </div>

                        <div class="userCart">
                            <ul>
                                <li><a href="#"><i class="d-icon-user"></i> </a></li>
                                <li><a href="#"><i class="d-icon-bag"></i> </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tool-head">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="header_logo">
                        <div class="logo-tools">
                            <div class="logo">
                                <a href="index.php"><img src="{{URL::asset('tool/')}}/img/logo-footer.png" alt="logo" class="img-fluid"></a>
                            </div>
                        </div>

                        <div class="tools">
                            <div class="tools-action">
                                <button class="btn-custom"><i class="d-icon-rotate-left mr-10px"></i> Begynn på
                                    nytt</button>
                            </div>

                            <div class="tools-action">
                                <button class="btn-custom"><i class="d-icon-arrow-left mr-10px"></i> Angre</button>
                                <button class="btn-custom">Gjenta <i class="d-icon-arrow-right ml-10px"></i></button>
                            </div>

                            <div class="tools-action">
                                <button class="btn-custom"><i class="d-icon-zoom mr-10px"></i> Forhåndsvis</button>
                                <button class="btn-custom"><i class="d-icon-refresh mr-10px"></i> Dele</button>
                            </div>

                            <div class="tools-action">
                                <button class="btn-custom"><i class="d-icon-th-list mr-10px"></i> Importer skilt via
                                    Excel</button>
                            </div>
                        </div>

                        <div class="help">
                            <button class="btn-help"><i class="d-icon-alert"></i> Hjelp</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tool-main">
        <aside class="aside">
            <ul class="leftMenu">


                <li><a href="javascript:;" class="popupModal">
                        <div class="img_style"><img src="{{URL::asset('tool/')}}/img/icon/material.svg" class="menu_img" /></div>
                        Materiale
                    </a>
                    <div class="popup_menu">
                        <div class="boxes">


                            @foreach($materiales as $materiale)
                            <div class="box">
                                <div class="box-img">
                                    <img src="{{URL::asset($materiale->image)}}" alt="" class="img-fluid">
                                </div>

                                <div class="box-content">
                                    <h3>{{$materiale->title}}</h3>

                                    <p>{{$materiale->description}}</p>
                                    {{-- <a href="javascript:;" class="les_mer">Les mer...</a>
                                    --}}

                                    <div class="bottom">
                                        <ul>
                                        </ul>
                                        <div class="valgt">
                                            <label for="valgt" style="display:none">Valgt</label>
                                            <input type="radio" name="valgt" id="valgt" class="custom_radio">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach


                        </div>

                        <div class="bottom_boxes">
                            <button class="btn-finish"><i class="d-icon-solid-check"></i> Ferdig</button>
                        </div>
                    </div>
                </li>

                <li><a href="javascript:;" class="popupModal">
                        <div class="img_style"><img src="{{URL::asset('tool/')}}/img/icon/size.svg" class="menu_img" /></div> Størrelse
                    </a>
                    <div class="popup_menu">
                        <div class="boxes">
                            <div class="box2">
                                <div class="box-input">
                                    <input type="radio" name="size" id="suggestion">
                                    <label for="suggestion">
                                        <p>Forslag
                                            <select name="" id="" class="form-control">
                                                @foreach($storrelses as $storrelse)
                                                <option value="{{$storrelse->bredde}},{{$storrelse->hoyde}}">{{$storrelse->bredde}} x {{$storrelse->hoyde}} mm</option>
                                                @endforeach
                                            </select>
                                        </p>
                                    </label>
                                </div>

                                <div class="box-input">
                                    <input type="radio" name="size" id="hw">
                                    <label for="hw">
                                        <p>
                                            Bredde (mm)
                                            <input type="number" value="100" name="" id="" class="form-control">
                                        </p>
                                        <div class="close"><img src="{{URL::asset('tool/img/icon/close.svg')}}" alt="" class="img-fluid"></div>
                                        <p>
                                            Høyde (mm)
                                            <input type="number" value="100" name="" id="" class="form-control">
                                        </p>
                                    </label>
                                </div>



                            </div>
                        </div>

                        <div class="bottom_boxes">
                            <button class="btn-finish"><i class="d-icon-solid-check"></i> Ferdig</button>
                        </div>
                    </div>
                </li>

                <li><a href="javascript:;" class="popupModal">
                        <div class="img_style"><img src="{{URL::asset('tool/')}}/img/icon/square.svg" class="menu_img" /></div> Form
                    </a>
                    <div class="popup_menu">
                        <div class="boxes">
                            <div class="box3">

                                @foreach($forms as $form)
                                <div class="box-img">
                                    <a href="javascript:void(0)" data-id="{{$form->id}}" class="toolForm">
                                        <img src="{{URL::asset($form->image)}}" alt="" class="img-fluid">
                                        {{$form->title}}
                                    </a>
                                </div>
                                @endforeach




                            </div>
                        </div>

                        <div class="bottom_boxes">
                            <button class="btn-finish"><i class="d-icon-solid-check"></i> Ferdig</button>
                        </div>
                    </div>
                </li>

                <li><a href="javascript:;" class="popupModal">
                        <div class="img_style"><img src="{{URL::asset('tool/img/icon/patch.svg')}}" class="menu_img" /></div>
                        Festemetode
                    </a>
                    <div class="popup_menu">
                        <div class="boxes">

                            @foreach($festemetodes as $festemetode)

                            <div class="box">
                                <div class="box-img">
                                    <img src="{{URL::asset($festemetode->image)}}" alt="" class="img-fluid">
                                </div>

                                <div class="box-content">
                                    <h3>Teip</h3>
                                    <p>{{$festemetode->description}}</p>

                                    <div class="bottom">
                                        <ul></ul>
                                        <div class="valgt">
                                            <label for="valgt" style="display: none;">{{$festemetode->title}}</label>
                                            <input type="radio" name="valgt" id="valgt" class="custom_radio">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach



                        </div>

                        <div class="bottom_boxes">
                            <button class="btn-finish"><i class="d-icon-solid-check"></i> Ferdig</button>
                        </div>
                    </div>
                </li>



                <li><a href="javascript:;" class="popupModal">
                        <div class="img_style"><img src="{{URL::asset('tool/img/icon/frame.svg')}}" class="menu_img" /></div> Ramme
                    </a>
                    <div class="popup_menu">
                        <div class="boxes">
                            <div class="box3">

                                @foreach($rammes as $ramme)
                                <div class="box-img">
                                    <a href="javascript:void(0)" onclick="addToolBorder()">
                                        <img src="{{URL::asset($ramme->image)}}" alt="" class="img-fluid">
                                        {{$ramme->title}}
                                    </a>
                                </div>
                                @endforeach

                            </div>
                        </div>

                        <div class="bottom_boxes">
                            <button class="btn-finish"><i class="d-icon-solid-check"></i> Ferdig</button>
                        </div>
                    </div>
                </li>

                <li><a href="javascript:void(0)" class="popupModal">
                        <div class="img_style"><img src="{{URL::asset('tool/')}}/img/icon/text.svg" class="menu_img" /></div> Tekst
                    </a>
                    <div class="popup_menu">
                        <div class="boxes">
                            <div class="box box-4">
                                <div class="box-content">
                                    <h3>Alle tekstobjekter</h3>
                                    <button class="btn-teksa btn-main tekst_pp"><i class="d-icon-plus"></i> Legg til ny
                                        tekst</button>

                                    <div class="ttarea">
                                        <div class="textarea">
                                            <label for="">Tekstobjekt</label>
                                            <textarea name="tool_tekst_val" id="tool_tekst_val" cols="30" rows="10" placeholder="Din tekst her">Din tekst her</textarea>
                                        </div>

                                    </div>

                                    <p><strong>Tips:</strong> Vil du ha flere linjer med tekst som har ulike
                                        innstillinger? Klikk på
                                        «Legg til tekst» for å lage flere tekstobjekter.</p>
                                </div>
                            </div>
                        </div>

                        <div class="bottom_boxes">
                            <button type="button" class="btn-finish" onclick="addToolText()"><i class="d-icon-solid-check"></i> Ferdig</button>
                        </div>
                    </div>
                </li>

                <li><a href="javascript:;" class="popupModal">
                        <div class="img_style"><img src="{{URL::asset('tool/')}}/img/icon/pic.svg" class="menu_img" /></div> Clip art
                    </a>
                    <div class="popup_menu">
                        <div class="boxes">
                            <div class="box box-4">
                                <div class="box-content">
                                    <h3>Legg til bilde</h3>

                                    @foreach($image_categories as $artcat)
                                    <button class="btn-teksa btn-main"><i class="fa fa-folder-open"></i> {{$artcat->title}}
                                        bildearkiv</button>

                                    <hr>
                                    <div class="imgs">

                                        @php
                                        $clipart_galleries = App\Helpers\Helper::getDesignGallery($artcat->id);
                                        @endphp
                                        @if($clipart_galleries->count() >=1)
                                        @foreach($clipart_galleries as $clipart_gallery)
                                        <div class="small_img mb-5" data-img="{{URL::asset($clipart_gallery->image)}}" onclick="addToolImage('{{URL::asset($clipart_gallery->image)}}')">
                                            <img src="{{URL::asset($clipart_gallery->image)}}" alt="" class="img-fluid image">
                                            {{-- <a href="#" class="close_icon"><i class="d-icon-close"></i></a> --}}
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="text-center">
                                            <h4>Nothing Found</h4>
                                        </div>
                                        <div>
                                            @endif
                                        </div>

                                        @endforeach

                                    </div>
                                </div>
                            </div>

                            <div class="bottom_boxes">
                                <button class="btn-finish"><i class="d-icon-solid-check"></i> Ferdig</button>
                            </div>
                        </div>
                </li>


                <li><a href="javascript:;" class="popupModal">
                        <div class="img_style"><img src="{{URL::asset('tool/img/icon/pic.svg')}}" class="menu_img" /></div> Bilde
                    </a>
                    <div class="popup_menu">
                        <div class="boxes">
                            <div class="box box-4">
                                <div class="box-content">
                                    <h3>Legg til bilde 2</h3>
                                    <button class="btn-teksa btn-main"><i class="fa fa-folder-open"></i> Bla gjennom
                                        bildearkiv</button>
                                    <button class="btn-teksa btn-main file-upload"><input type="file" class="file-input"><i class="fa fa-cloud-upload-alt"></i> Last opp
                                        bilde</button>

                                    <hr>
                                    <div class="imgs">

                                        @foreach($bildes as $bilde)
                                        <div class="small_img">
                                            <img src="{{URL::asset($bilde->image)}}" alt="" class="img-fluid image">
                                            {{-- <a href="#" class="close_icon"><i class="d-icon-close"></i></a> --}}
                                        </div>
                                        @endforeach

                                    </div>

                                    <div class="hidden">
                                        <hr>

                                        <div class="imageWrapper">
                                            <h3>I bruk</h3>
                                            <div class="imgs">
                                                <div class="img-style">
                                                    <img class="image" src="http://via.placeholder.com/700x500">
                                                    <a href="#">Rediger bilde</a>
                                                    <p>Maks. bredde: 162 mm</p>
                                                    <p>Maks. høyde: 162 mm</p>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <h3>Nylig brukt</h3>
                                        <div class="imgs">

                                            @foreach($bildes as $bilde)
                                            <div class="small_img">
                                                <img src="{{$bilde->image}}" alt="" class="img-fluid image">
                                                <a href="#" class="close_icon"><i class="d-icon-close"></i></a>
                                            </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bottom_boxes">
                            <button class="btn-finish"><i class="d-icon-solid-check"></i> Ferdig</button>
                        </div>
                    </div>
                </li>

            </ul>
        </aside>

        <div class="tool-content">
            <div class="canvas">
                <div class="jainul-hw">
                    <canvas id="designCanvas" width="800" height="500"></canvas>
                    <div class="title-ab title--center-line"><small id="getCanvaWidth">30cm</small></div>
                    <div class="title-hb title--center-line2"><small id="getCanvaHeight">12cm</small></div>
                </div>

                <div class="help">
                    <button class="btn-help"><i class="d-icon-alert"></i> Hjelp</button>
                </div>
            </div>

            <div class="tool-price">
                <div class="row">
                    <div class="col-md-6">
                        <div class="name-price">
                            <a href="#" class="mobile-sidebar-toggle"><i class="d-icon-bars2"></i></a>
                            <div class="name-price-text">
                                <h3>Navneskilt</h3>
                                <h3>126,00 kr <small><span>Pris per vare </span> <span>inkl. mva.</span></small></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="add-cart">
                            <div class="qty">
                                <div class="number">
                                    <span class="minus">-</span>
                                    <input type="text" value="1" />
                                    <span class="plus">+</span>
                                </div>
                            </div>
                            <button class="btn-cart btn-main"><i class="d-icon-bag"></i> Legg i handlevogn</button>
                            <button class="btn-checkout btn-main">Gå til kassen <i class="d-icon-long-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        var canvas = new fabric.Canvas('canvas');
        var canvasHistory = [];

        document.getElementById('undoBtn').addEventListener('click', function() {
            undo();
        });

        // Function to save canvas state
        function saveCanvasState() {
            canvasHistory.push(JSON.stringify(canvas.toJSON()));
        }

        // Function to revert to previous state
        function undo() {
            if (canvasHistory.length > 1) {
                canvasHistory.pop(); // Remove current state
                var prevState = JSON.parse(canvasHistory[canvasHistory.length - 1]);
                canvas.loadFromJSON(prevState, canvas.renderAll.bind(canvas));
            }
        }

        // Save initial canvas state
        saveCanvasState();

        // Add event listeners or other canvas operations here
    });

    function bgCatData(data_id) {
        $(".popup_menu2").addClass("show");
        let category_id = data_id;
        ///alert(category_id);
        $.ajax({
            url: '/ekstraskilt/admin/design/get-tool-bg-images/' + category_id,
            method: "GET",
            data: {
                category_id: category_id
            },
            success: function(res) {
                $('.bg-gallery-result').html(res);
            }
        });
    }


    function bgImgCatData(data_id) {
        $(".popup_menu2").addClass("show");
        let category_id = data_id;
        ///alert(category_id);
        $.ajax({
            url: '/ekstraskilt/admin/design/get-tool-images/' + category_id,
            method: "GET",
            data: {
                category_id: category_id
            },
            success: function(res) {
                $('.gallery-result').html(res);
            }
        });
    }
</script>



@stop