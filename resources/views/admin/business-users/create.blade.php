@extends('admin.layouts.app')
@section('content')
<style>
    .hide {
        display: none;
    }

    #country_code+.intl-tel-input {
        width: 100% !important;
    }
</style>
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Business Owners</h4>
            </div>
        </div>

        <div class="page-content-wrapper ">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-11">
                                        <h4 class="m-t-0 m-b-30">Add</h4>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{ route('business-owners.index') }}"><button type="button"
                                                class="btn waves-effect btn-secondary" title="Back"><i
                                                    class="ion ion-md-arrow-back"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        <form method="POST" action="{{ route('business-owners.store') }}" id="userCreateForm"
                                            class="form-horizontal" enctype='multipart/form-data'>
                                            @csrf
                                            <div class="form-group row">
                                                <label for="firstName" class="col-sm-3 control-label">First Name<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="firstName" name="firstName"
                                                        placeholder="First Name">
                                                    <span class="error" id="firstNameSpan">{{$errors->admin->first('firstName')}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="firstName" class="col-sm-3 control-label">Last Name<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="lastName" name="lastName"
                                                        placeholder="Last Name">
                                                    <span class="error" id="lastNameSpan">{{$errors->admin->first('lastName')}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-3 control-label">Email<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="email" name="email"
                                                        placeholder="Email">
                                                    <span class="error" id="emailSpan">{{$errors->admin->first('email')}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-3 control-label">Password<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="password" class="form-control" id="password" name="password"
                                                        placeholder="Password">
                                                    <span class="error" id="passwordSpan">{{$errors->admin->first('password')}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-3 control-label">Confirm Password<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="password" class="form-control" id="confirmPassword"
                                                        name="confirmPassword" placeholder="Confirm Password">
                                                    <span class="error" id="confirmPasswordSpan">{{$errors->admin->first('confirmPassword')}}</span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label for="businessName" class="col-sm-3 control-label">Business Name<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="businessName" name="businessName"
                                                        placeholder="Business Name">
                                                    <span class="error" id="businessNameSpan">{{$errors->admin->first('businessName')}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="businessEmail" class="col-sm-3 control-label">Business Email<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="businessEmail" name="businessEmail"
                                                        placeholder="Business Email">
                                                    <span class="error" id="businessEmailSpan">{{$errors->admin->first('businessEmail')}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="businessAbout" class="col-sm-3 control-label">Business About<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="businessAbout" name="businessAbout"
                                                    placeholder="Business About"  cols="30" rows="5"></textarea>
                                                    <span class="error" id="businessAboutSpan">{{$errors->admin->first('businessAbout')}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">

                                                <label for="service" class="col-sm-3 control-label">Service<span
                                                    class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="service" name="service">
                                                        <option value="">Select Service</option>
                                                        @foreach ($service as $value)
                                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                                        @endforeach

                                                    </select>
                                                    <span class="error" id="serviceSpan">{{$errors->admin->first('service')}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="image" class="col-sm-3 control-label">Profile Image</label>
                                                <div class="col-sm-5">
                                                    <input type="file" class="form-control" id="profileImage"
                                                        name="profileImage"
                                                        oninput="pic.src=window.URL.createObjectURL(this.files[0])" accept="image/png, image/jpg, image/jpeg, image/svg">
                                                    <span class="error" id="profileImageSpan"></span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <img src="{{ asset('assets/images/users/nouser.png') }}"
                                                        alt="Profile Image" class="logo-lg"
                                                        style="height:100px;width:100px" id="pic">
                                                </div>
                                            </div>
                                            <div class="form-group m-b-0">
                                                <div class="col-sm-9">
                                                    <button type="submit"
                                                        class="btn btn-primary waves-effect waves-light">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- card-body -->
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->

    </div>
    <!-- Page content Wrapper -->

    </div>
    <script>
        var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
    </script>
    <script>
        $("#userCreateForm").submit(function(e) {
            var temp = 0;
            var firstName = $("#firstName").val();
            var email = $("#email").val();
            var password=$("#password").val();
            var confirmPassword=$("#confirmPassword").val();
            var image=$("#profileImage").val();
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (firstName == "") {
                $("#firstNameSpan").html("Please enter First Name");
                temp++;
                var regex=/[^a-zA-Z0-9]/;
            }else if((/[^a-zA-Z0-9]/).test(firstName))
            {
                $("#firstNameSpan").html("Special Characters Not Allowed");
                temp++;
            }
            else {
                $("#firstNameSpan").html("");
            }

            if ($("#lastName").val() == "") {
                $("#lastNameSpan").html("Please enter Last Name");
                temp++;
            }else if((/[^a-zA-Z0-9]/).test($("#lastName").val()))
            {
                $("#lastNameSpan").html("Special Characters Not Allowed");
                temp++;
            }
            else {
                $("#lastNameSpan").html("");
            }

            if($("#phone").val()=="")
            {
                $('#Phoneerror').html('The Mobile Field Is Required');
                temp++;
            }
            else
            {
                $('#Phoneerror').html('');
            }

            if (email == "") {
                $('#emailSpan').html('Please enter Email');
                temp++;
            }else if (!regex.test(email)) {
                    $('#emailSpan').html('Email is not Valid');
                    temp++;
            }else if(email != ""){
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    async: false,
                    url:"{{ route('checkEmail') }}",
                    data: {
                        'email': email,
                    },
                    success: function(data) {
                        if(data.message == 'exist')
                        {
                            $('#emailSpan').html('Email is already exist');
                            temp++;
                        }else{
                            $('#emailSpan').html('');
                        }
                    }
                });

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

            if (confirmPassword == "") {
                $('#confirmPasswordSpan').html('Please enter Confirm Password');
                temp++;
            }else if(confirmPassword !== password)
            {
                $('#confirmPasswordSpan').html('Confirm Password Does Not Match');
                temp++;
            }else{
                $('#confirmPasswordSpan').html('');
            }

            if ($("#businessName").val() == "") {
                $("#businessNameSpan").html("Please enter Business Name");
                temp++;
            }else if((/[^a-zA-Z0-9 ]/).test($("#businessName").val()))
            {
                $("#businessNameSpan").html("Special Characters Not Allowed");
                temp++;
            }
            else {
                $("#businessNameSpan").html("");
            }

            if ($("#businessEmail").val() == "") {
                $('#businessEmailSpan').html('Please enter Business Email');
                temp++;
            }else{
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!regex.test($("#businessEmail").val())) {
                    $('#businessEmailSpan').html('Email is not Valid');
                    temp++;
                } else {
                    $('#businessEmailSpan').html('');
                }
            }

            if ($("#businessAbout").val() == "") {
                $('#businessAboutSpan').html('Please enter Business About');
                temp++;
            }else{
                $('#businessAboutSpan').html('');
            }

            if ($("#service").val() == "") {
                $('#serviceSpan').html('Please select Service');
                temp++;
            }else{
                $('#serviceSpan').html('');
            }

            if (image !== "") {
                var regex = new RegExp("(.*?)\.(jpg|png|jpeg|JPG|PNG|JPEG|svg|SVG)$");
                if (!(regex.test(image))) {
                    temp++;
                    $('#profileImageSpan').html("Please Select Valid Image");
                } else {
                    $('#profileImageSpan').html("");
                    temp=0;
                }
            }
            if(temp !== 0 )
            {
                return false;
            }
        });
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.7/js/intlTelInput.js">
    </script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/css/intlTelInput.css">

    <script>
        // Country code with phone number
        var telInput = $("#phone"),
            errorMsg = $("#mobileerror").html('Invalid Mobile Number'),
            validMsg = $("#valid-msg");
        errorMsg.addClass("hide");
        telInput.intlTelInput({
            preferredCountries: ['sg'],
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
        });
        var reset = function() {

            telInput.removeClass("error");
            errorMsg.addClass("hide");
            validMsg.addClass("hide");
        };

        // on blur: validate
        telInput.blur(function() {
            reset();
            if ($.trim(telInput.val())) {
                if (telInput.intlTelInput("isValidNumber")) {
                    validMsg.removeClass("hide");
                    var getCode = '+' + telInput.intlTelInput('getSelectedCountryData').dialCode;
                    $('#country_code').val(getCode);
                    $("#Phoneerror").html("");
                    $("#mobileerror").html("");
                } else {
                    telInput.addClass("error");
                    errorMsg.removeClass("hide");
                    $("#mobileerror").html('Invalid Mobile Number');
                    $("#Phoneerror").html('');
                }
            }
        });
    </script>
@endsection
