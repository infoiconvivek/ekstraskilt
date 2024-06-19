<!--newsletter start-->
<section class="light-bg py-7">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="subscribe-form">
        <div id="emailMsg" class="text-danger"></div> 
          <form id="mc-form" class="group">
            <input id="newsletter_email" name="newsletter_email" type="email" placeholder="Enter Email Address" required="">
            <button type="button" class="btn btn-theme" id="subscribeBtn">SUBSCRIBE NOW</button>
          </form>
        </div>
      </div>
      <div class="col-lg-6 mt-6 mt-lg-0 text-lg-end">
        <div class="social-icons social-colored footer-social">
          <ul class="list-inline">
            <li class="social-facebook"><a href="{{App\Helpers\Helper::getSettingData('facebook_url')}}"><i class="lab la-facebook-f"></i></a></li>
            <li class="social-facebook"><a href="{{App\Helpers\Helper::getSettingData('twitter_url')}}"><img src="{{URL::asset('front/images/twitter.png')}}" style="height: 30px;"></a></li>
            <li class="social-instagram"><a href="{{App\Helpers\Helper::getSettingData('instagram_url')}}"><i class="lab la-instagram"></i></a></li>
            <li class="social-facebook"><a href="#"><img src="{{URL::asset('front/images/threads.png')}}"></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<!--newsletter end-->

<script>
    $("#subscribeBtn").on('click', function() {
        var email = $('#newsletter_email').val();
        ///alert(email);
        $.ajax({
            type: 'GET',
            url: "{{url('save-newsletter')}}",
            data: {
                email: email
            },
            success: function(data) {
                $("#emailMsg").text(data.msg);
                // $("#emailMsg").fadeOut(5000);
                // $('#newsletter_email').val('');
            }

        });

        ///alert(email);

    });
</script>