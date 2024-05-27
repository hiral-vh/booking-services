<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In | {{env('APP_NAME')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive bootstrap 4 admin template" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"
        id="bootstrap-stylesheet" />
    <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-stylesheet" />
    <link href="{{ asset('admin/css/parsley.css') }}" rel="stylesheet" type="text/css">

    <!-- Notification css (Toastr) -->
    <link href="{{ asset('admin/libs/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />


    <style>
        .field-icon {
            float: right;
            margin-left: 350px;
            position: absolute;
            z-index: 2;
            top: 13px;
            color: #495057;
        }

        .container {
            padding-top: 50px;
            margin: auto;
        }
    </style>

</head>

<body class="authentication-bg">

    <div class="account-pages pt-5 my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="account-card-box">
                        <div class="card mb-0">
                            <div class="card-body p-4">

                                <div class="text-center">
                                    <div class="my-3">
                                        <a href="{{ route('login') }}">
                                            <span><img src="{{ asset('admin/images/logo.png') }}" alt=""
                                                    height="50"></span>
                                        </a>
                                    </div>
                                    <h5 class="text-muted text-uppercase py-3 font-16">Log In</h5>
                                </div>

                                <form class="mt-2" action="{{ route('verifyLogin') }}" method="POST"
                                    id="loginForm">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <input class="form-control" type="text" placeholder="Email" id="user_name"
                                            name="user_name" required data-parsley-trigger="keyup"
                                            data-parsley-type="email"
                                            data-parsley-required-message="Please enter Email."
                                            data-parsley-type-message="Please enter valid Email."
                                            value="{{ old('user_name') }}" />
                                        <span class="error"
                                            id="userNameErrorSpan">{{ $errors->login->first('user_name') }}</span>
                                    </div>

                                    <div class="form-group mb-3 position-relative">
                                        <input class="form-control" type="password" id="password" name="password"
                                            placeholder="Password" required data-parsley-trigger="keyup"
                                            data-parsley-required-message="Please enter Password.">
                                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"
                                            style="cursor: pointer"></span>
                                        <span class="error"
                                            id="passwordErrorSpan">{{ $errors->login->first('password') }}</span>
                                    </div>

                                    {{-- <div class="form-group mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                                <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                            </div>
                                        </div> --}}

                                    <div class="form-group text-center">
                                        <button class="btn btn-success btn-block waves-effect waves-light"
                                            type="submit"> Log In </button>
                                    </div>

                                    <a href="{{route('forgot-password')}}" class="text-muted"><i class="mdi mdi-lock mr-1"></i>
                                        Forgot your password?</a>

                                </form>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->
                    </div>

                    {{-- <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-white-50">Don't have an account? <a href="pages-register.html"
                                    class="text-white ml-1"><b>Sign Up</b></a></p>
                        </div> <!-- end col -->
                    </div> --}}
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- Vendor js -->
    <script src="{{ asset('admin/js/vendor.js') }}"></script>

    <!-- Toastr js -->
    <script src="{{ asset('admin/libs/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('admin/js/pages/toastr.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('admin/js/app.min.js') }}"></script>
    <script src="{{ asset('admin/js/parsley.js') }}"></script>

    <script>
        var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
    </script>

    <script>
        $(window).bind("pageshow", function() {
            var form = $('#loginForm');
            form[0].reset();

            $('#loginForm').parsley().reset();
        });

        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $(document).ready(function() {
            $('#loginForm').parsley();
            if(error)
            {
                Command: toastr["error"](error);
            }
            if(success)
            {
                Command: toastr["success"](success);
            }
        });

    </script>

</body>

</html>
