<h1>Forget Password Email</h1>
   
<p>Hii {{$arr['email']}}</p>
<p>You can reset password from bellow link:</p>
<a href="{{url('auth/reset-password?token='.$arr['token'])}}">Reset Password</a>