 <!--script-src-->
    <script src="{{URL::asset('front/js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('front/js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('front/js/wow.min.js')}}"></script>
    <script src="{{URL::asset('front/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('front/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{URL::asset('front/js/owl.carousel.min.js')}}"></script>
    <script src="{{URL::asset('front/js/main.min.js')}}"></script>
    <script src="{{URL::asset('front/js/custom.js')}}"></script>
    <script src="{{URL::asset('front/js/swiper-bundle.min.js')}}"></script>



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

