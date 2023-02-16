<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>
    <meta charset="utf-8" />
    <title>User Reset Password </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{URL::asset('admin/images/fav.jpg')}}">

    <!-- Layout config Js -->
    <script src="{{URL::asset('admin/assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{URL::asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{URL::asset('admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{URL::asset('admin/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{URL::asset('admin/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
  

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Create new password</h5>
                                </div>

                                <div class="p-2">
                                   @if (session('msg'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('msg') }}
                                    </div>
                                    @endif
                                    <form action="{{url('user/update-user-password')}}" method="post">
                                        @csrf

                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input type="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password-input" name="password">
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            @error('password')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                            </div>
                                            <div id="passwordInput" class="form-text">Must be at least 6 characters.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="confirm-password-input">Confirm Password</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input" placeholder="Confirm password" name="password_confirmation">
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="confirm-password-input"><i class="ri-eye-fill align-middle"></i></button>
                                                @error('password_confirmation')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>


                                      

                                        <div class="mt-4">
                                            <input type="hidden" name="pswtoken" value="{{request()->get('pswtoken')}}">
                                            <button class="btn btn-success w-100" type="submit">Reset Password</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                Copyright © {{now()->year}} {{env('SITE_URL')}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{URL::asset('admin/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{URL::asset('admin/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{URL::asset('admin/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{URL::asset('admin/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{URL::asset('admin/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
    <script src="{{URL::asset('admin/js/plugins.js')}}"></script>

    <!-- particles js -->
    <script src="{{URL::asset('admin/libs/particles.js/particles.js')}}"></script>
    <!-- particles app js -->
    <script src="{{URL::asset('admin/js/pages/particles.app.js')}}"></script>
    <!-- password-addon init -->
    <script src="{{URL::asset('admin/js/pages/password-addon.init.js')}}"></script>
</body>

</html>