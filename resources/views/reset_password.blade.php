<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Forgot Password | {{ env('APP_NAME') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.png') }}">

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
                                    <div class="py-3">
                                        <h5 class="text-muted text-uppercase font-16">Reset Password</h5>
                                        {{-- <p class="text-muted">Enter your email address and we'll send you an email with
                                            instructions to reset your password.</p> --}}
                                    </div>
                                </div>

                                <form action="{{ route('new-pass') }}" method="POST" class="mt-2"
                                    id="resetPasswordForm">
                                    @csrf
                                    <input type="hidden" id="code" name="code" value="{{ $code }}">
                                    <div class="form-group mb-3 position-relative">
                                        <input class="form-control" type="password" name="password" id="password"
                                            placeholder="New Password" value="{{ old('password') }}" required
                                            data-parsley-trigger="keyup"
                                            data-parsley-required-message="Please enter New Password."
                                            data-parsley-minlength="6"
                                            data-parsley-minlength-message="New Password must be at least 6 characters."
                                            data-parsley-maxlength="40"
                                            data-parsley-maxlength-message="New Password must be maximum 40 characters." />
                                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"
                                            style="cursor: pointer"></span>
                                        <span class="error"
                                            id="newPasswordErrorSpan">{{ $errors->reset_pass->first('password') }}</span>
                                    </div>

                                    <div class="form-group mb-3 position-relative">
                                        <input class="form-control" type="password" name="re_password" id="re_password"
                                            placeholder="Retype Password" value="{{ old('re_password') }}" required
                                            data-parsley-trigger="keyup"
                                            data-parsley-required-message="Please enter Retype Password."
                                            data-parsley-equalto="#password"
                                            data-parsley-equalto-message="Retype Password must be same as New Password" />
                                        <span toggle="#re_password" class="fa fa-fw fa-eye field-icon toggle-password1"
                                            style="cursor: pointer"></span>
                                        <span class="error"
                                            id="rePasswordErrorSpan">{{ $errors->reset_pass->first('re_password') }}</span>
                                    </div>

                                    <div class="form-group text-center mb-0">
                                        <button class="btn btn-success btn-block waves-effect waves-light"
                                            type="submit"> Reset Password </button>
                                    </div>

                                </form>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-white-50">Return to <a href="{{ route('login') }}"
                                    class="text-white ml-1"><b>Log In</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- Vendor js -->
    <script src="{{ asset('admin/js/vendor.min.js') }}"></script>

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
        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $(".toggle-password1").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $(document).ready(function() {
            $('#resetPasswordForm').parsley();
            if (error) {
                Command: toastr["error"](error);
            }
            if (success) {
                Command: toastr["success"](success);
            }
        });
    </script>
</body>

</html>
