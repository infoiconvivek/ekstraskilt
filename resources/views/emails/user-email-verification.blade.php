<h1>Email Verification Mail</h1>

<p>Hii {{$email}}</p>
  
<p>Please verify your email with bellow link: </p>
<a href="{{url('user/account-verify?token='.$token)}}">Verify Email</a>