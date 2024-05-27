<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{$module}} | {{$sitesetting->title}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="{{ asset('assets/images/' . $sitesetting->favicon) }}">

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">

    </head>


    <body>

        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">
            <div class="card card-pages">

                <div class="card-body">
                    <div class="text-center m-t-0 m-b-15">
                            <a href="index.html" class="logo logo-admin"><img src="{{asset('assets/images/').'/'.$sitesetting->logo}}" alt="" height="100"></a>
                    </div>
                    <h4 class="text-muted text-center m-t-0"><b>Business Register</b></h4>
                    <form class="form-horizontal m-t-20" method="POST" action="{{route('store-register')}}" id="businessRegisterForm" enctype='multipart/form-data'>
                        @csrf
                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control" type="text" name="first_name" id="first_name"  placeholder="First Name">
                                <span class="error" id="firstNameSpan">{{$errors->login->first('first_name')}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control" type="text" name="last_name" id="last_name"  placeholder="Last Name">
                                <span class="error" id="lastNameSpan">{{$errors->login->first('last_name')}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control" type="text"  id="email" name="email" placeholder="Email" >
                                <span class="error" id="emailSpan">{{$errors->login->first('email')}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                                <span class="error" id="passwordSpan">{{$errors->login->first('password')}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                                <span class="error" id="confirmPasswordSpan">{{$errors->login->first('confirm_password')}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <input type="file" class="form-control" id="image" name="image"
                                    oninput="pic.src=window.URL.createObjectURL(this.files[0])" accept="image/png, image/jpg, image/jpeg, image/svg">
                                <span class="error" id="imageSpan">{{$errors->login->first('image')}}</span>
                            </div>
                            <div class="col-sm-4">
                                <img src="{{ asset('assets/images/no-image.jpg') }}"
                                    alt="Image" class="logo-lg"
                                    style="height:100px;width:100px" id="pic">
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control" type="text" id="business_name" name="business_name" placeholder="Business Name">
                                <span class="error" id="businessNameSpan">{{$errors->login->first('business_name')}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control" type="text" id="business_email" name="business_email" placeholder="Business Email">
                                <span class="error" id="businessEmailSpan">{{$errors->login->first('business_email')}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control" type="text" id="business_about" name="business_about" placeholder="Business About">
                                <span class="error" id="businessAboutSpan">{{$errors->login->first('business_about')}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <select class="form-control" id="service" name="service">
                                <option value="" >Select Service</option>
                                @foreach ($service as $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                            <span class="error" id="serviceSpan">{{$errors->login->first('service')}}</span>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-signup" type="checkbox" checked="checked">
                                    <label for="checkbox-signup">
                                        I accept <a href="#">Terms and Conditions</a>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="form-group text-center m-t-40">
                            <div class="col-12">
                                <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Register</button>
                            </div>
                        </div>

                        <div class="form-group m-t-30 m-b-0">
                            <div class="col-sm-12 text-center">
                                <a href="{{route('business-login')}}" class="text-muted">Already have account?</a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/js/app.js"></script>
        <script>
            $("#businessRegisterForm").submit(function(e) {
            var temp = 0;
            var password=$("#password").val();
            var email=$("#email").val();
            if($("#first_name").val() == "")
            {
                $("#firstNameSpan").html("Please enter First Name");
                temp++;
            }else if((/[^a-zA-Z0-9]/).test($("#first_name").val()))
            {
                $("#firstNameSpan").html("Special Characters Not Allowed");
                temp++;
            }
            else
            {
                $("#firstNameSpan").html("");
            }

            if($("#last_name").val() == "")
            {
                $("#lastNameSpan").html("Please enter Last Name");
                temp++;
            }else if((/[^a-zA-Z0-9]/).test($("#last_name").val()))
            {
                $("#lastNameSpan").html("Special Characters Not Allowed");
                temp++;
            }
            else
            {
                $("#lastNameSpan").html("");
            }

            if (email == "") {
                $('#emailSpan').html('Please enter Email');
                temp++;
            } else {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!regex.test(email)) {
                    $('#emailSpan').html('The Email is Not Valid');
                    temp++;
                } else {
                    $('#emailSpan').html('');
                }
            }

            if (password == "") {
                $('#passwordSpan').html('Please enter Password');
                temp++;
            }else if(password.length < 8)
            {
                $('#passwordSpan').html('Please enter Minimum 8 Character');
                temp++;
            }
            else {
                var regex = /^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/;
                if (!regex.test(password)) {
                    $('#passwordSpan').html('Invalid Password Format');
                    temp++;
                }
                else
                {
                    $('#passwordSpan').html('');
                }
            }


            if($("#image").val() != "")
            {
                var imageRegex = new RegExp("(.*?)\.(jpg|png|jpeg|JPG|PNG|JPEG|svg|SVG)$");
                if (!(imageRegex.test($("#image").val())))
                {
                    $('#imageSpan').html('Invalid Image Format');
                    temp++;
                }
                else
                {
                    $('#imageSpan').html('');
                }
            }

            if ($("#confirm_password").val() == "") {
                $('#confirmPasswordSpan').html('Please enter Confirm Password');
                temp++;
            }else if($("#confirm_password").val() !== password)
            {
                $('#confirmPasswordSpan').html('The Confirm Password Does Not Match');
                temp++;
            }else{
                $('#confirmPasswordSpan').html('');
            }

            if ($("#business_name").val() == "") {
                $('#businessNameSpan').html('Please enter Business Name');
                temp++;
            }else {
                $('#businessNameSpan').html('');
            }

            if ($("#business_email").val() == "") {
                $('#businessEmailSpan').html('Please enter Business Email');
                temp++;
            } else {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!regex.test($("#business_email").val())) {
                    $('#businessEmailSpan').html('The Email is Not Valid');
                    temp++;
                } else {
                    $('#businessEmailSpan').html('');
                }
            }

            if ($("#business_about").val() == "") {
                $('#businessAboutSpan').html('Please enter Business About');
                temp++;
            }else {
                $('#businessAboutSpan').html('');
            }

            if ($("#service").val() == "") {
                $('#serviceSpan').html('Please select Service');
                temp++;
            }else {
                $('#serviceSpan').html('');
            }

            if(temp !== 0 )
            {
                return false;
            }
        });

        </script>
    </body>
</html>
