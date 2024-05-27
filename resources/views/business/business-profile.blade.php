@extends('business.layouts.app')
@section('content')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Profile</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="m-t-0 m-b-30">Details</h4>
                            <form method="POST" action="{{ route('update-business-profile',) }}" id="businessProfileForm" class="form-horizontal" enctype='multipart/form-data'>
                                @csrf
                                @method('put')
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 control-label">First Name<span class="error">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $business->first_name }}" placeholder="First Name" maxlength="25">
                                        <span class="error" id="firstNameSpan">{{$errors->admin->first('first_name')}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 control-label">Last Name<span class="error">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $business->last_name }}" placeholder="Last Name" maxlength="25">
                                        <span class="error" id="lastNameSpan">{{$errors->admin->first('last_name')}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 control-label">Email<span class="error">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="email" name="email" value="{{ $business->email }}" placeholder="Email" maxlength="100">
                                        <span class="error" id="emailSpan">{{ $errors->admin->first('email') }}</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="image" class="col-sm-2 control-label">Image</label>
                                    <div class="col-sm-5">
                                        <input type="file" class="form-control" id="image" name="image" oninput="pic.src=window.URL.createObjectURL(this.files[0])" accept="image/png,image/gif,image/jpeg,image/jpg,image/svg">
                                        <span class="error" id="imageSpan">{{$errors->admin->first('profile_image')}}</span>
                                    </div>
                                    @if (empty($business->profile_image))
                                    <div class="col-sm-4">
                                        <img src="{{ asset('business/images/users/nouser.png') }}" alt="Business User Image" class="logo-lg" style="height:100px;width:100px" id="pic">
                                    </div>
                                    @else
                                    <div class="col-sm-4">
                                        <img src="{{asset($business->profile_image)}}" alt="Business User Image" class="logo-lg" style="height:100px;width:100px" id="pic">
                                    </div>
                                    @endif
                                </div>
                                <!-- <div class="form-group row">
                                    <label for="name" class="col-sm-2 control-label">APK Link<span class="error">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="apk_link" name="apk_link" value="{{$sitesetting->apk_link}}" placeholder="APK Link">
                                        <span class="error" id="apkLinkSpan">{{$errors->admin->first('apk_link')}}</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 control-label">IPA Link<span class="error">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="ipa_link" name="ipa_link" value="{{$sitesetting->ipa_link}}" placeholder="IPA Link">
                                        <span class="error" id="ipaLinkSpan">{{$errors->admin->first('ipa_link')}}</span>
                                    </div>
                                </div> -->

                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 control-label">Stripe Public Key</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="public_key" name="public_key" value="{{(!empty($businessOwner->public_key))?$businessOwner->public_key:''}}" placeholder="Public Key">
                                        <span class="error" id="publicKeySpan">{{$errors->admin->first('public_key')}}</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 control-label">Stripe Secret Key</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="secret_key" name="secret_key" value="{{(!empty($businessOwner->secret_key))?$businessOwner->secret_key:''}}" placeholder="Secret Key">
                                        <span class="error" id="secretKeySpan">{{$errors->admin->first('secret_key')}}</span>
                                    </div>
                                </div>

                                <div class="form-group m-b-0">
                                    <div class="col-sm-10">
                                        <button type="button" class="btn btn-primary waves-effect waves-light" onclick="checkForm();">Update</button>
                                    </div>
                                </div>
                            </form>
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

<!-- Modal show when strip key null -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Stripe Key</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('updateStripeKey')}}" autocomplete="off" method="POST" id="stripeKeyForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Stripe Public Key<span class="text-danger">*</span></label>
                        <input type="text" name="stripe_public_key" id="stripe_public_key" class="form-control" placeholder="Enter Stripe Public Key">
                        <span id="stripe_pk_error" style="color:red;"><span>
                    </div>
                    <div class="form-group">
                        <label>Stripe Secret Key<span class="text-danger">*</span></label>
                        <input type="text" name="stripe_secret_key" id="stripe_secret_key" class="form-control" placeholder="Enter Stripe Secret Key">
                        <span id="stripe_sk_error" style="color:red;"><span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="stripeCheck();">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal -->


<script>
    var success = "{{ Session::get('success') }}";
    var error = "{{ Session::get('error') }}";
</script>
@section('js')
<script>
    $(window).on('load', function() {
        var stripePK = $('#public_key').val();
        var stripeSK = $('#secret_key').val();
        if (stripePK == '' || stripeSK == '') {
            $('#exampleModal').modal('show');
        }
    });

    let checkAPIKeyComplete = false;
    let isValidAPIKey = false;

    let checkAPIKeyCompleteUpdate = false;
    let isValidAPIKeyUpdate = false;

    function checkForm() {
        var temp = 0;
        var email = $("#email").val();
        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var image = $("#image").val();
        var nameRegex = /[^a-zA-Z0-9 ]/;
        // var apk_link = $("#apk_link").val();
        // var ipa_link = $("#ipa_link").val();

        if (first_name.trim() == "") {
            temp++;
            $('#firstNameSpan').html("Please enter First Name");
            $('#first_name').focus();
        } else if (nameRegex.test(first_name)) {
            temp++;
            $('#firstNameSpan').html("Special characters Not allowed");
            $('#first_name').focus();
        } else {
            $('#firstNameSpan').html("");
        }

        if (last_name.trim() == "") {
            temp++;
            $('#lastNameSpan').html("Please enter Last Name");
            $('#last_name').focus();
        } else if (nameRegex.test(last_name)) {
            temp++;
            $('#lastNameSpan').html("Special characters not allowed");
            $('#last_name').focus();
        } else {
            $('#lastNameSpan').html("");
        }

        if (email == "") {
            temp++;
            $('#emailSpan').html("Please enter Email");
            $('#email').focus();
        } else {
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!regex.test(email)) {
                $('#emailSpan').html('Please enter valid Email');
                temp++;
            } else {
                $("#emailSpan").html("");
            }
        }
        if (image !== "") {
            var regex = new RegExp("(.*?)\.(jpg|png|jpeg|JPG|PNG|JPEG|svg|SVG)$");
            if (!(regex.test(image))) {
                temp++;
                $('#imageSpan').html("File must Image!! Like: JPG, JPEG, PNG and SVG");
                $('#image').focus();
            } else {
                $('#imageSpan').html("");
            }
        }

        if ($("#public_key").val().trim() == "") {
            temp++;
            $('#publicKeySpan').html("Please enter Stripe Public Key");
            $('#public_key').focus();
        } else {
            Stripe.setPublishableKey($("#public_key").val().trim());
            Stripe.createToken({}, function(status, response) {
                checkAPIKeyComplete = true;
                if (status == 401) {
                    temp++;
                    $("#publicKeySpan").html("Please enter valid Stripe Public Key");
                    $('#public_key').focus();
                } else {
                    isValidAPIKey = true;
                    $("#publicKeySpan").html("");
                }
            });
        }
        if ($("#secret_key").val().trim() == "") {
            temp++;
            $('#secretKeySpan').html("Please enter Stripe Secret Key");
            $('#secret_key').focus();
        } else {
            $('#secretKeySpan').html("");
        }

        if (temp !== 0) {
            return false;
        } else {
            setTimeout(() => {
                if (checkAPIKeyComplete && isValidAPIKey)
                    $("#businessProfileForm").submit();
                else
                    checkForm();
            }, 1000);
        }
    }

    function stripeCheck() {
        var s = 0;
        var stripePK = $('#stripe_public_key').val();
        var stripeSK = $('#stripe_secret_key').val();

        if (stripePK.trim() == "") {
            s++;
            $('#stripe_pk_error').html("Please enter Stripe Public Key");

        } else {
            Stripe.setPublishableKey($("#stripe_public_key").val().trim());
            Stripe.createToken({}, function(status, response) {
                checkAPIKeyCompleteUpdate = true;
                if (status == 401) {
                    s++;
                    $("#stripe_pk_error").html("Please enter valid Stripe Public Key");

                } else {
                    isValidAPIKeyUpdate = true;
                    $("#stripe_pk_error").html("");
                }
            });
            $("#stripe_pk_error").html("");
        }

        if (stripeSK.trim() == "") {
            s++;
            $('#stripe_sk_error').html("Please enter Stripe Secret Key");
        } else {
            $('#stripe_sk_error').html("");
        }

        if (s == 0) {
            // $("#stripeKeyForm").submit();
            setTimeout(() => {
                if (checkAPIKeyCompleteUpdate && isValidAPIKeyUpdate)
                    $("#stripeKeyForm").submit();

            }, 1000);

        } else {
            return false;
        }
    }
</script>
@endsection
@endsection