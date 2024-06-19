@extends('layouts.front_layout')
@section('content')
@section('title', 'Track')

<main class="main contact-us">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="index.php"><i class="d-icon-home"></i></a></li>
                <li>Contact Us</li>
            </ul>
        </div>
    </nav>
    <div class="page-header" style="background-image: url({{URL::asset('front/images/')}}/page-header/contact-us.jpg)">
        <div class="banner-content">
            <h1 class="page-title font-weight-bold text-capitalize ls-l">Contact Us</h1>
        </div>
    </div>
    <div class="page-content mt-10 pt-7">
        <section class="contact-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 ls-m mb-4">
                        <div class="grey-section d-flex align-items-center h-100">
                            <div>
                                <h4 class="mb-2 text-capitalize">Headquarters</h4>
                                <p>c/o Promerch AS
                                    Stasjonsveien 21, 1550 Hølen</p>
                                <h4 class="mb-2 text-capitalize">Phone Number</h4>
                                <p>
                                    <a href="tel:#">xxx xxx xxxx</a><br>
                                    <a href="tel:#">xxx xxx xxxx</a>
                                </p>
                                <h4 class="mb-2 text-capitalize">Support</h4>
                                <p class="mb-4">
                                    <a href="mailto:post@ekstraskilt.no">post@ekstraskilt.no</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 d-flex align-items-center mb-4">
                        <div class="w-100">
                            <form class="pl-lg-2" action="#">
                                <h4 class="ls-m font-weight-bold">Send oss en mail</h4>
                                <p>Your email address will not be published. Required fields are
                                    marked *</p>
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <label for="">Ditt Navn <span>*</span></label>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <input class="form-control" type="text" placeholder="Fornavn *" required>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <input class="form-control" type="text" placeholder="Etternavn *" required>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label for="">Mailadresse <span>*</span></label>
                                        <input class="form-control" type="email" placeholder="Mailadresse" required>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label for="">Telefonnummer <span>*</span></label>
                                        <input class="form-control" type="tel" placeholder="Telefonnummer" required>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <label for="">Din Melding <span>*</span></label>
                                        <textarea class="form-control" required placeholder="Comment*"></textarea>
                                    </div>
                                </div>
                                <button class="btn btn-dark btn-rounded">Submit<i
                                        class="d-icon-arrow-right"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <div class="google-map" id="map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2023.1179999294268!2d10.733660695758513!3d59.53112602965508!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x464151c905a5318f%3A0xb94a682281af9c1f!2sStasjonsveien%2021%2C%201550%20H%C3%B8len%2C%20Norway!5e0!3m2!1sen!2sin!4v1693552393262!5m2!1sen!2sin"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

    </div>
</main>

    @stop