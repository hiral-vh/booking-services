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
                <h4 class="page-title">About {{ ucfirst($business->name) }}</h4>
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
                                        <a href="{{ route('business-about-us.index',['business_id'=>$business->id]) }}"><button type="button"
                                                class="btn waves-effect btn-secondary"><i
                                                    class="ion ion-md-arrow-back" title="back"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        <form method="POST" action="{{ route('business-about-us.store') }}" id="businessAboutUsCreateForm"
                                            class="form-horizontal" enctype='multipart/form-data'>
                                            @csrf
                                            <input type="hidden" value="{{ $business->id }}" id="business" name="business">
                                            <div class="form-group row">
                                                <label for="image" class="col-sm-3 control-label">Image<span
                                                    class="error">*</span></label>
                                                <div class="col-sm-5">
                                                    <input type="file" class="form-control" id="image"
                                                        name="image"
                                                        oninput="pic.src=window.URL.createObjectURL(this.files[0])">
                                                    <span class="error" id="imageSpan">{{$errors->admin->first('image')}}</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <img src="{{ asset('assets/images/no-image.jpg') }}"
                                                        alt="Image" class="logo-lg"
                                                        style="height:100px;width:100px" id="pic">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="description" class="col-sm-3 control-label">Location<span
                                                    class="error">*</span></label>
                                                    <div class="col-sm-9">
                                                    <textarea class="form-control" id="location" name="location" row="5"></textarea>
                                                    <span class="error" id="locationSpan">{{$errors->admin->first('location')}}</span>
                                                    </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="mobile" class="col-sm-3 control-label">Contact<span style="color:red" class="required-error"> *</span></label>
                                                <input type="hidden" id="country_code" value="" name="country_code" />
                                                <div class="col-sm-9">
                                                    <input type="text" name="mobile" autocomplete="off" value="{{ old('mobile')}}" class="form-control" id="phone" onkeypress="return isNumber(event)" placeholder="Mobile"> <span style="color: red;" id="Phoneerror">{{$errors->admin->first('mobile')}}</span>
                                                    <p><span style="color: red;" class="spnerrorclasscss" id="mobileerror"></span>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="description" class="col-sm-3 control-label">Description<span
                                                    class="error">*</span></label>
                                                    <div class="col-sm-9">
                                                    <textarea class="form-control" id="description" name="description" row="5"></textarea>
                                                    <span class="error" id="descriptionSpan">{{$errors->admin->first('description')}}</span>
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
        $("#businessAboutUsCreateForm").submit(function(e) {
            var temp = 0;
            var image=$("#image").val();

            if($("#location").val() == "")
            {
                $("#locationSpan").html("The Location Field Is Required");
                temp++;
            }
            else
            {
                $("#locationSpan").html("");
            }

            if (image !== "") {
                var regex = new RegExp("(.*?)\.(jpg|png|jpeg|JPG|PNG|JPEG|svg|SVG)$");
                if (!(regex.test(image))) {
                    temp++;
                    $('#imageSpan').html("Please Select Valid Image");
                    $('#image').focus();
                } else {
                    $('#imageSpan').html("");
                    temp=0;
                }
            }
            else
            {
                $('#imageSpan').html("Image Field Is Required");
                temp++;
            }

            if ($("#phone").val() == "") {
                    temp++;
                    $('#Phoneerror').html("Contact Field Is Required");
                    $('#phone').focus();
            }
            else
            {
                $('#Phoneerror').html("");
            }

            if ($("#description").val() == "") {
                    temp++;
                    $('#descriptionSpan').html("Description Field Is Required");
                    $('#description').focus();
            }
            else
            {
                $('#descriptionSpan').html("");
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
