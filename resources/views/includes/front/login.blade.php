<style> 
.error
{
    color: red;
    font-size: 17px;
}
</style>
<div class="dropdown-box scrollable">
    <div class="login-popup">
        <div class="form-box">
            <div class="tab tab-nav-simple tab-nav-boxed form-tab">
                <ul class="nav nav-tabs nav-fill align-items-center border-no justify-content-center mb-5" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active border-no lh-1 ls-normal" href="#signin">Login</a>
                    </li>
                    <li class="delimiter">or</li>
                    <li class="nav-item">
                        <a class="nav-link border-no lh-1 ls-normal" href="#register">Register</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="signin">
                    <span style="color: red;" id="logMessage"> </span>
                    <div id="errorMessages" class="error"></div>
                        <form method="post" id="log_form">
                            <div class="form-group mb-3">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email Address *">
                                <span id="email-error" class="error"></span>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password *">
                                <span id="password-error" class="error"></span>
                            </div>
                            <div class="form-footer">
                                <div class="form-checkbox">
                                    <input type="checkbox" class="custom-checkbox" id="signin-remember" name="signin-remember">
                                    <label class="form-control-label" for="signin-remember">Remember
                                        me</label>
                                </div>
                                <a href="#" class="lost-link">Lost your password?</a>
                            </div>
                            <button class="btn btn-dark btn-block btn-rounded" id="login-form" type="button">Login</button>
                        </form>
                        <div class="form-choice text-center">
                            <label class="ls-m">or Login With</label>
                            <div class="social-links">
                                <a href="#" title="social-link" class="social-link social-google fab fa-google border-no"></a>
                                <a href="#" title="social-link" class="social-link social-facebook fab fa-facebook-f border-no"></a>
                                <a href="#" title="social-link" class="social-link social-twitter fab fa-twitter border-no"></a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="register">
                         <span style="color: green;" id="regMessage"> </span>
                        <form method="post" id="reg_form">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Your Email Address *">
                                <span id="user_email-error" class="error"></span>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password *">
                                <span id="user_password-error" class="error"></span>
                            </div>
                            <div class="form-footer">
                                <div class="form-checkbox">
                                    <input type="checkbox" class="custom-checkbox" id="register-agree" name="register-agree" required>
                                    <label class="form-control-label" for="register-agree">I agree to the privacy policy</label>
                                </div>
                            </div>
                            <button class="btn btn-dark btn-block btn-rounded" id="register-form" type="button">Register</button>
                        </form>

                        <div class="form-choice text-center">
                            <label class="ls-m">or Register With</label>
                            <div class="social-links">
                                <a href="#" title="social-link" class="social-link social-google fab fa-google border-no"></a>
                                <a href="#" title="social-link" class="social-link social-facebook fab fa-facebook-f border-no"></a>
                                <a href="#" title="social-link" class="social-link social-twitter fab fa-twitter border-no"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button title="Close (Esc)" type="button" class="mfp-close"><span>×</span></button>
    </div>
</div>


<script>
    $('#register-form').click(function(e) {
        ///alert(act);
    e.preventDefault();

    var formData = $('#reg_form').serialize();
    console.log(formData);
    $.ajax({
        url: "{{ url('user-auth/register') }}",
        type: 'POST',
        data: formData,
        success: function(response) {
            // Handle success response
            ///console.log(response);
            $('#regMessage').text(response.regMessage);
            $('.error').text('');
            $('#reg_form :input').each(function() {
            $(this).val('');
        });
        },
        error: function(xhr, status, error) {
            // Handle error response
            var errors = xhr.responseJSON.errors;
            $.each(errors, function(key, value) {
                // Display validation errors on the form
                $('#'+key+'-error').html(value[0]);
            });
        }
    });
});
</script>


<script>
    $('#login-form').click(function(e) {
        ///alert(act);
    e.preventDefault();
    var base_url = "url('/')";
    var formData = $('#log_form').serialize();
    console.log(formData);
    $.ajax({
        url: "{{ url('user-auth/login') }}",
        type: 'POST',
        data: formData,
        success: function(response) {
            // Handle success response
            ///console.log(response);
            ///alert(response.status);
            if(response.status == 1)
            {
                location.reload();
            }
            $('#logMessage').text(response.logMessage);
            $('.error').text('');
            $('#log_form :input').each(function() {
            $(this).val('');
        });
        },
        error: function(xhr, status, error) {
            // Handle error response
            var errors = xhr.responseJSON.errors;
            var errorMessage = '<ul>';
            $.each(errors, function(key, value) {
                errorMessage += '<li>' + value + '</li>';
            });
            errorMessage += '</ul>';
            $('#errorMessages').html(errorMessage);
        }
    });
});
</script>