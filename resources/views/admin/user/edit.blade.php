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
                <h4 class="page-title">Users</h4>
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
                                        <h4 class="m-t-0 m-b-30">Edit</h4>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{ route('users.index') }}"><button type="button"
                                                class="btn waves-effect btn-secondary" title="Back"><i
                                                    class="ion ion-md-arrow-back"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        <form method="POST" action="{{ route('users.update',$user->id) }}" id="userEditForm"
                                            class="form-horizontal" enctype='multipart/form-data'>
                                            @csrf
                                            @method('put')
                                            <div class="form-group row">
                                                <label for="firstName" class="col-sm-3 control-label">First Name<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="firstName" name="firstName"
                                                        placeholder="First Name" value="{{$user->first_name}}">
                                                    <span class="error" id="firstNameSpan">{{$errors->admin->first('firstName')}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="firstName" class="col-sm-3 control-label">Last Name<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="lastName" name="lastName"
                                                        placeholder="Last Name"  value="{{$user->last_name}}">
                                                    <span class="error" id="lastNameSpan">{{$errors->admin->first('lastName')}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="mobile" class="col-sm-3 control-label">Mobile<span style="color:red" class="required-error"> *</span></label>
                                                <input type="hidden" id="country_code" value="{{$user->country_code}}" name="country_code" />
                                                <div class="col-sm-9">
                                                    <input type="text" name="mobile" autocomplete="off" value="{{$user->country_code}}" class="form-control" id="phone" onkeypress="return isNumber(event)" placeholder="Mobile"> <span style="color: red;" id="Phoneerror">{{$errors->admin->first('mobile')}}</span>
                                                    <p><span style="color: red;" class="spnerrorclasscss" id="mobileerror"></span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-3 control-label">Email<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="email" name="email"
                                                        placeholder="Email"  value="{{$user->email}}">
                                                    <span class="error" id="emailSpan">{{$errors->admin->first('email')}}</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="image" class="col-sm-3 control-label">Profile Image</label>
                                                <div class="col-sm-5">
                                                    <input type="file" class="form-control" id="image" name="image"
                                                        oninput="pic.src=window.URL.createObjectURL(this.files[0])">
                                                    <span class="error" id="imageSpan"></span>
                                                </div>
                                                @if (empty($user->profile_photo_path))
                                                    <div class="col-sm-4">
                                                        <img src="{{ asset('assets/images/users/nouser.png') }}" alt="App-User-Profile-Image"
                                                            class="logo-lg" style="height:100px;width:100px" id="pic">
                                                    </div>
                                                @else
                                                    <div class="col-sm-4">
                                                        <img src="{{ asset($user->profile_photo_path) }}"
                                                            alt="App-User-Profile-Image" class="logo-lg" style="height:100px;width:100px"
                                                            id="pic">
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group row">
                                                <label for="status" class="col-sm-3 control-label">Status<span
                                                    class="error">*</span></label>
                                                    <div class="col-sm-2">
                                                        <label for="status"> Active </label>
                                                        <input type="radio" id="active" value="1" name="status" @if($user->status==1)checked="checked"@endif>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="status"> Deactive </label>
                                                        <input type="radio" id="active" value="0" name="status" @if($user->status==0)checked="checked"@endif>
                                                    </div>
                                                    <span class="error" id="statusSpan">{{$errors->admin->first('status')}}</span>
                                            </div>

                                            <div class="form-group m-b-0">
                                                <div class="col-sm-9">
                                                    <button type="submit"
                                                        class="btn btn-primary waves-effect waves-light">Update</button>
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
        $("#userEditForm").submit(function(e) {
            var temp = 0;
            var email = $("#email").val();
            var password=$("#password").val();
            var confirmPassword=$("#confirmPassword").val();
            var firstName = $("#firstName").val();

            if ($("#firstName").val() == "") {
                $("#firstNameSpan").html("The First Name Field Is Required");
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
                $("#lastNameSpan").html("The Last Name Field Is Required");
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
                $('#emailSpan').html('The Email Field Is Required');
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
                console.log("if");
                validMsg.removeClass("hide");
                var getCode = '+' + telInput.intlTelInput('getSelectedCountryData').dialCode;

                $('#country_code').val(getCode);
                $("#Phoneerror").html("");
                $("#mobileerror").html("");
            } else {
                console.log("else");
                telInput.addClass("error");
                errorMsg.removeClass("hide");
                $("#mobileerror").html('Invalid Mobile Number');
                $("#Phoneerror").html('');
            }
        }
    });


    setTimeout(function() {
        $("#phone").val('<?= $user->mobile ?>');
    }, 1000);
    </script>
@endsection
