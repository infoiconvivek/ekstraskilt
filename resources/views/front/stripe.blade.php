@extends('layouts.front_layout')
@section('content')
@section('title', 'Payment')


<div id="page" class="full-page">
    @include('includes/front/header')
    <main id="content" class="site-main">
        <!-- Inner Banner html start-->
        <section class="inner-banner-wrap">
            <div class="inner-baner-container" style="background-image: url({{URL::asset('front/images/inner-banner.jpg')}});">
                <div class="container">
                    <div class="inner-banner-content">
                        <h1 class="inner-title">Payment </h1>
                    </div>
                </div>
            </div>
            <div class="inner-shape"></div>
        </section>
        <!-- Inner Banner html end-->

        <!-- Middle content -->
        <section class="section">
            <div class="login-signup">
                <div class="global-container">
                    <div class="card login-form">
                        <div class="card-body">
                            <h3 class="card-title text-center">Payment</h3>
                            <div class="card-text">

                                @if (Session::has('success'))
                                <div class="alert alert-success text-center">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    <p>{{ Session::get('success') }}</p>
                                </div>
                                @endif


                                @if (\Session::has('errMsg'))
                                <div class="alert alert-danger">
                                    <ul>
                                        <li>{!! \Session::get('errMsg') !!}</li>
                                    </ul>
                                </div>
                                @endif

                                <form role="form" action="{{ url('stripe-pay') }}" method="post" class="require-validation stripe-cart-form" data-cc-on-file="false" data-stripe-publishable-key="pk_test_51NVTlPHGmofNXC0OBSEb5of0LqwNe8sozQqfMGhJCScz6Guwcp5BSB6UsxOYl2jPKEbtaT8u0r5YtGDcWtR3FfCQ00TAXnZ06Y" id="payment-form">
                                    @csrf

                                    <div class='form-row row'>
                                        <div class='col-xs-12 form-group required'>
                                            <label class='control-label'>Name on Card</label> <input class='form-control' size='4' type='text' autocomplete="off">
                                        </div>
                                    </div>

                                    <div class='form-row row'>
                                        <div class='col-xs-12 form-group card required'>
                                            <label class='control-label'>Card Number</label> <input autocomplete='off' class='form-control card-number' size='20' type='text' autocomplete="off">
                                        </div>
                                    </div>

                                    <div class='form-row row'>
                                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                                            <label class='control-label'>CVC</label> <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='password' autocomplete="off">
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                            <label class='control-label'>Expiration Month</label> <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text' autocomplete="off">
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                            <label class='control-label'>Expiration Year</label> <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text' autocomplete="off">
                                        </div>
                                    </div>

                                    <div class='form-row row'>
                                        <div class='col-md-12 error form-group hide'>
                                            <div class='alert-danger alert'></div>
                                            <br><br>
                                        </div>
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-xs-12">
                                            <input type="hidden" name="ref" value="">
                                            <button class="btn-style1" type="submit">Pay Now (CHF 45)</button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- Middle content -->



    </main>

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script type="text/javascript">
        $(function() {

            /*------------------------------------------
            --------------------------------------------
            Stripe Payment Code
            --------------------------------------------
            --------------------------------------------*/

            var $form = $(".require-validation");
            //alert('test');
            $('form.require-validation').bind('submit', function(e) {
                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'
                    ].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }

            });

            /*------------------------------------------
            --------------------------------------------
            Stripe Response Handler
            --------------------------------------------
            --------------------------------------------*/
            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    /* token contains id, last4, and card type */
                    var token = response['id'];

                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
                ///alert(token);
            }

        });
    </script>

    @stop