<head>

    <meta charset="utf-8" />
    <title>Admin Dashboard </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{URL::asset('admin/images/logo.png')}}">

    <!-- Layout config Js -->
    <script src="{{URL::asset('admin/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{URL::asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{URL::asset('admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{URL::asset('admin/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{URL::asset('admin/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>



</head>