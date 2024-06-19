<!DOCTYPE html>
<html lang="en">
@include('includes.front.head')
<body class="">

<div class="page-wrapper">
@include('includes.front.header')
@yield('content')
@include('includes.front.footer')
</div>
@include('includes.front.extra')
</body>
</html>