<!DOCTYPE html>
<html lang="en">
@include('includes.tool.head')
<body class="">

<div class="page-wrapper">
@include('includes.tool.header')
@yield('content')
@include('includes.tool.footer')
</div>
@include('includes.tool.extra')
</body>
</html>