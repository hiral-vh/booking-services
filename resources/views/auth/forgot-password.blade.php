<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">

</head>

<body>

    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page">

        <div class="card card-pages">
            <div class="card-body">
                <div class="text-center m-t-0 m-b-15">
                    <a href="{{route('login')}}" class="logo logo-admin"><img src="assets/images/logo-dark.png" alt="" height="34"></a>
                </div>
                <h4 class="text-muted text-center m-t-0"><b>Reset Password</b></h4>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        {{ $error }}
                        @endforeach
                    </ul>
                </div>
                @endif
                <form class="form-horizontal mt-4" method="POST" action="{{ route('admin-check-email') }}" id="resetForm">
                    @csrf
                    <div class="pl-3 pr-3">
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Enter your <b>Email</b> and instructions will be sent to
                            you!
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-12">
                            <input class="form-control" type="text" id="email" name="email" placeholder="Email">
                            <span class="error" id="emailSpan"></span>
                        </div>
                    </div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Send
                                Mail</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- jQuery  -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/js/detect.js') }}"></script>
    <script src="{{ asset('assets/js/fastclick.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('assets/js/waves.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

</body>
<script>
    $("#resetForm").submit(function() {
        var temp = 0;
        var f = 0;
        var email = $("#email").val();

        function ValidateEmail(email) {
            var expr =
                /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            return expr.test(email);
        }


        if (email.trim() == "") {
            $('#emailSpan').html("Please Enter Email");
            temp++;
            f++;
            if (f == 1) {
                $('#email').focus();
            }
        } else if (!ValidateEmail(email)) {
            $('#emailSpan').html("Please enter valid Email");
            temp++;
            f++;
            if (f == 1) {
                $('#email').focus();
            }
        } else {
            $('#emailSpan').html('');
            $.ajax({
                type: "GET",
                dataType: "json",
                async: false,
                url: '{{ route("admin-user-email") }}',
                data: {
                    email: $("#email").val()
                },
                success: function(data) {
                    if (data.message == 'not_exist') {
                        $('#emailSpan').html('Email not exist');
                        temp++;
                    }
                },
            });
        }


        if (temp !== 0) {
            return false;
        }

    });
</script>

</html>
