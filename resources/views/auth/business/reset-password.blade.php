<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Forgot Password | Business" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <link href="{{ asset('business/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('business/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('business/css/style.css') }}" rel="stylesheet" type="text/css">

</head>

<body>

    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page">
        <div class="card card-pages">
            <div class="card-body">
                <div class="text-center m-t-0 m-b-15">
                    <a href="{{route('business-login')}}" class="logo logo-admin"><img src="{{asset('assets/images')."/".$sitesetting->logo}}" alt="Logo" height="100"></a>
                </div>
                <h4 class="text-muted text-center m-t-0"><b>Reset Password</b></h4>
                <form class="form-horizontal mt-4" method="POST" action="{{route('business-reset-password')}}" id="resetForm">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <div class="form-group">
                        <div class="col-12">
                            <input class="form-control" type="password" id="new_password" name="new_password" placeholder="New Password">
                            <span class="error" id="newPasswordSpan"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-12">
                            <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                            <span class="error" id="confirmPasswordSpan"></span>
                        </div>
                    </div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Reset Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery  -->
    <script src="{{ asset('business/js/jquery.min.js') }}"></script>
    <script src="{{ asset('business/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('business/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('business/js/detect.js') }}"></script>
    <script src="{{ asset('business/js/fastclick.js') }}"></script>
    <script src="{{ asset('business/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('business/js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('business/js/waves.js') }}"></script>
    <script src="{{ asset('business/js/wow.min.js') }}"></script>
    <script src="{{ asset('business/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('business/js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('business/js/app.js') }}"></script>
    <script src="{{ asset('business/js/app.js') }}"></script>

</body>
<script>

    $("#resetForm").submit(function(e) {
        var temp = 0;
        var password=$("#new_password").val();
        var confirmPassword=$("#confirm_password").val();
        var regexp = new RegExp('^(?=.*[A-Z].)(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z].*).{8,}$');

        if (password == "") {
                $('#newPasswordSpan').html('Please enter New password');
                temp++;
        }else if(!(regexp.test(password))){
            $('#newPasswordSpan').html('Password must contain one special character, one lowercase and one number');
            temp++;
        }
        else
        {
            $('#newPasswordSpan').html('');
        }

        if (confirmPassword == "") {
                $('#confirmPasswordSpan').html('Please enter Confirm password');
                temp++;
        }else if(confirmPassword !== password){
            $('#confirmPasswordSpan').html('Confirm password does not match');
            temp++;
        }
        else
        {
            $('#confirmPasswordSpan').html('');
        }

        if(temp !== 0)
        {
            return false;
        }

    });
</script>

</html>
