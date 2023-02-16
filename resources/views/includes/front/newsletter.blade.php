<section class="footer-newsletter">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-xl-5 col-lg-6">
                        <div class="icon-box icon-box-side text-white">
                            <div class="icon-box-icon d-inline-flex">
                                <i class="fa fa-envelope"></i>
                            </div>
                            @php $fSec5 = App\Helpers\Helper::getPageSection(8); @endphp
                    <div class="box-content">
                        <h4 class="icon-box-title text-white text-uppercase font-weight-bold">Subscribe To
                        {{$fSec5->title ?? ''}}</h4>
                        <p class="text-white">{{$fSec5->short_desc ?? ''}}
                        </p>
                    </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6 col-md-9 mt-4 mt-lg-0 ">
                    <div id="emailMsg" style="color:#fff;"></div> <br>
                        <form action="javascript:void(0)" method="get" class="input-wrapper input-wrapper-inline input-wrapper-rounded">
                            <input type="email" class="form-control mr-2 bg-white" name="newsletter_email" id="newsletter_email"
                                placeholder="Your E-mail Address">
                            <button class="btn btn-dark btn-rounded" id="subscribeBtn">Subscribe<i
                                    class="fa fa-arrow-right"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

