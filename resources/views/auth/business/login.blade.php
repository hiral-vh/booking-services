<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{isset($module)?$module:''.' | '.$sitesetting->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
                    <img src="{{ asset($sitesetting->logo) }}" alt="Logo" height="100">
                </div>
                <h4 class="text-muted text-center m-t-0"><b>Sign In</b></h4>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" class="form-horizontal m-t-20" id="BusinessUserForm">
                    <input type="hidden" name="type" value="2">
                    <div class="form-group">
                        <div class="col-12">
                            <input class="form-control" type="text" name="email" id="email" placeholder="Email" >
                            <span class="error" id="emailSpan" style="margin-left:10px;">{{$errors->login->first('email')}}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-12">
                            <input class="form-control" type="password" id="password" name="password"
                                placeholder="Password">
                            <span class="error" id="passwordSpan" style="margin-left:10px;">{{$errors->login->first('password')}}</span>
                        </div>
                    </div>

                    <div class="form-group text-center m-t-40">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary btn-block btn-lg waves-effect waves-light"
                                href="" id="loginbtn">Sign In</button>
                        </div>
                    </div>

                    <div class="form-group row m-t-30 m-b-0">
                        <div class="col-sm-7">
                            <a href="{{route('business-forgot-password')}}" class="text-muted"><i
                                    class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                        </div>
                        <div class="col-sm-5 text-right">
                            <a href="{{route('business-register')}}" class="text-muted">Create an account</a>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
    <!-- jQuery  -->
    <script>
        var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
    </script>
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

    <!-- Toastr -->
    <script src="{{asset('business/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{ asset('business/js/custom_toast.js') }}"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <script>
        $("#loginbtn").click(function(e) {
            var temp = 0;
            var email=$("#email").val();
            var password = $("#password").val();
            if (email == "") {
                $('#emailSpan').html('Please enter Email');
                temp++;
            }
            else {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!regex.test(email)) {
                    $('#emailSpan').html('Please enter valid Email');
                    temp++;
                } else {
                    $('#emailSpan').html('');
                }
            }
            if ($("#password").val() == "") {
                $('#passwordSpan').html('Please enter Password');
                temp++;
            }else{
                $('#passwordSpan').html('');
            }
            if(temp !== 0 )
            {
                return false;
            }
            else{
                $.ajax({
                        url: '{{route("business-authenticate")}}',
                        type: 'POST',
                        data : {_token : '{{ csrf_token() }}',email:email,password:password},
                        dataType: 'JSON',
                            success:function(response){
                                initFirebaseMessagingRegistration(response);
                            },
                            error: function(err) {
                            console.log('User Chat Token Error');
                            }
                    });  
            }
        });

        //token update
        function initFirebaseMessagingRegistration(sendData) {
        var firebaseConfig = {
            apiKey: "AIzaSyB5xJ-79-dh1PYZEFg1fawSbBTviQUajqI",
            authDomain: "booking-services-2ae12.firebaseapp.com",
            projectId: "booking-services-2ae12",
            storageBucket: "booking-services-2ae12.appspot.com",
            messagingSenderId: "610198799984",
            appId: "1:610198799984:web:5c83d136560225714556b5",
            measurementId: "G-CFZR5NXGEJ"
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
            messaging
                .requestPermission()

                .then(function() {
                    return messaging.getToken()
                })
                .then(function(token) {
                    console.log(token);
                    console.log('here');
                    $.ajax({
                        url: '{{ route("save-token") }}',
                        type: 'POST',
                        data : {_token : '{{ csrf_token() }}' ,device_token: token },
                        
                            success:function(response){
                                if(sendData.status == '1')
                                {
                                    window.location.href = sendData.route;
                                   
                                }
                            },
                            error: function(err) {
                            console.log('User Chat Token Error' + err);
                            }
                    });

            }).catch(function(err) {

                console.log('User Chat Token Errorsss' + err);
            });
        }

    </script>
</body>
</html>
