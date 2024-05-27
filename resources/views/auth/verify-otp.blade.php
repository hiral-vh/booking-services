<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Verify OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
                <h4 class="text-muted text-center m-t-0"><b>Verify OTP</b></h4>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        {{ $error }}
                        @endforeach
                    </ul>
                </div>
                @endif
                <form class="form-horizontal mt-4" method="POST" action="{{route('admin-submit-otp')}}" id="VerifyOtpForm">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                    <div class="form-group">
                        <div class="col-12">
                            <input class="form-control" type="text" id="otp" name="otp" placeholder="OTP">
                            <span class="error" id="otpSpan"></span>
                        </div>
                    </div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Verify</button>
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
    $(document).ready(function() {

        $('#otp').on('input', function(event) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
    $("#VerifyOtpForm").submit(function(e) {
        var temp = 0;
        var otp = $("#otp").val();
        var user_id = $("#user_id").val();
        if (otp == "") {
            $('#otpSpan').html('The OTP Field Is Required');
            temp++;
        } else {
            $('#otpSpan').html('');
            $.ajax({
                type: "GET",
                dataType: "json",
                async: false,
                url: '{{route("admin-check-otp")}}',
                data: {
                    otp: otp,
                    user_id: user_id,
                },
                success: function(data) {
                    if (data.message == 'not_match') {
                        $('#otpSpan').html('OTP Does Not Match');
                        temp++;
                    } else {
                        temp = 0;
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