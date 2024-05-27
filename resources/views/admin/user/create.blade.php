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
                <h4 class="page-title">Business Users</h4>
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
                                        <a href="{{ route('users.index') }}"><button type="button"
                                                class="btn waves-effect btn-secondary" title="Back"><i
                                                    class="ion ion-md-arrow-back"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        <form method="POST" action="{{ route('users.store') }}" id="userCreateForm"
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
                                                <label for="mobile" class="col-sm-3 control-label">Mobile<span style="color:red" class="required-error"> *</span></label>
                                                <input type="hidden" id="country_code" value="" name="country_code" />
                                                <div class="col-sm-9">
                                                    <input type="text" name="mobile" autocomplete="off" value="{{ old('mobile')}}" class="form-control" id="phone" onkeypress="return isNumber(event)" placeholder="Mobile"> <span style="color: red;" id="Phoneerror">{{$errors->admin->first('mobile')}}</span>
                                                    <p><span style="color: red;" class="spnerrorclasscss" id="mobileerror"></span>
                                                    </p>
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

                                            <div class="form-group row">
                                                <label for="image" class="col-sm-3 control-label">Image</label>
                                                <div class="col-sm-5">
                                                    <input type="file" class="form-control" id="image"
                                                        name="image"
                                                        oninput="pic.src=window.URL.createObjectURL(this.files[0])" accept="image/png, image/jpg, image/jpeg, image/svg">
                                                    <span class="error" id="imageSpan">{{$errors->admin->first('image')}}</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <img src="{{ asset('assets/images/no-image.jpg') }}"
                                                        alt="Image" class="logo-lg"
                                                        style="height:100px;width:100px" id="pic">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="status" class="col-sm-3 control-label">Status<span
                                                    class="error">*</span></label>
                                                    <div class="col-sm-2">
                                                        <label for="status"> Active </label>
                                                        <input type="radio" id="active" value="1" name="status" checked="checked">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="status"> Deactive </label>
                                                        <input type="radio" id="active" value="0" name="status">
                                                    </div>
                                                    <span class="error" id="statusSpan">{{$errors->admin->first('status')}}</span>
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
    @section('js')
    <script>
        $("#userCreateForm").submit(function(e) {
            var temp = 0;
            var firstName = $("#firstName").val();
            var email = $("#email").val();
            var password=$("#password").val();
            var confirmPassword=$("#confirmPassword").val();
            if ($("#firstName").val() == "") {
                $("#firstNameSpan").html("Please enter First Name");
                temp++;
            }else if((/[^a-zA-Z0-9]/).test(firstName))
            {
                $("#firstNameSpan").html("Special characters not allowed");
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
                $("#lastNameSpan").html("Special characters not allowed");
                temp++;
            }
            else {
                $("#lastNameSpan").html("");
            }

            if($("#phone").val()=="")
            {
                $('#Phoneerror').html('Please enter Mobile');
                temp++;
            }
            else
            {
                $('#Phoneerror').html('');
            }

            if (email == "") {
                $('#emailSpan').html('Please enter Email');
                temp++;
            } else {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!regex.test(email)) {
                    $('#emailSpan').html('The Email Is Not Valid');
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
                    $('#passwordSpan').html('Password must contain one special character, one lowercase and one number');
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
                $('#confirmPasswordSpan').html('Confirm Password does not match');
                temp++;
            }

            if($("#image").val()!=="")
            {
                var imageRegex = new RegExp("(.*?)\.(jpg|png|jpeg|JPG|PNG|JPEG|svg|SVG)$");
                if (!(imageRegex.test($("#image").val())))
                {
                    $('#imageSpan').html('Please choose valid Image');
                    temp++;
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
@endsection
