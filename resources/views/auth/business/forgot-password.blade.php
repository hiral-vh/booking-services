<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Forgot Password | Business" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <link href="{{ asset('business/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('business/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('business/css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('business/plugins/toastr/toastr.min.css')}}">

</head>

<body>

    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page">
        <div class="card card-pages">
            <div class="card-body">
                <div class="text-center m-t-0 m-b-15">
                    <a href="{{route('business-login')}}" class="logo logo-admin"><img src="{{asset($sitesetting->logo)}}" alt="Logo" height="100"></a>
                </div>
                <h4 class="text-muted text-center m-t-0"><b>Forgot Password</b></h4>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        {{ $error }}
                        @endforeach
                    </ul>
                </div>
                @endif
                <form class="form-horizontal mt-4" method="POST" action="{{route('business-send-link')}}" id="resetForm">
                    @csrf
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
    <script>
        var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
    </script>

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

    <!-- Toastr -->
    <script src="{{asset('business/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{ asset('business/js/custom_toast.js') }}"></script>

</body>
<script>
    $("#resetForm").submit(function(e) {
        var temp = 0;
        var email = $("#email").val();
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (email == "") {
                $('#emailSpan').html('Please enter Email');
                temp++;
        }
        else if (!regex.test(email)) {
                $('#emailSpan').html('Please enter valid Email');
                temp++;
        }else {
            $('#emailSpan').html('');
            $.ajax({
                type: "GET",
                dataType: "json",
                async: false,
                url: '{{ route("business-check-email") }}',
                data: {
                    email: $("#email").val()
                },
                success: function(data) {
                    if(data.message=='not_exist')
                    {
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
