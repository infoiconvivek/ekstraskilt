<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
@include('includes.admin.head')
<body>

 <div id="layout-wrapper">
@include('includes.admin.header')
@include('includes.admin.sidebar')
@yield('content')

@include('includes.admin.extra')
<.div
</body>
</html>