@extends('business.layouts.app')
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
                <h4 class="page-title">About</h4>
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
                                        <a href="{{ route('business-user-about-us.index')}}"><button type="button"
                                                class="btn waves-effect btn-secondary"><i
                                                    class="ion ion-md-arrow-back" title="back"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        <form method="POST" action="{{ route('business-user-about-us.update',$businessAboutUs->id) }}" id="businessAboutUsEditForm"
                                            class="form-horizontal" enctype='multipart/form-data'>
                                            @csrf
                                            @method('put')
                                            {{-- <input type="hidden" value="{{ $business->id }}" id="business" name="business"> --}}
                                            <div class="form-group row">
                                                <label for="image" class="col-sm-3 control-label">Image</label>
                                                <div class="col-sm-5">
                                                    <input type="file" class="form-control" id="image"
                                                        name="image" value="{{$businessAboutUs->business->business_image}}"
                                                        oninput="pic.src=window.URL.createObjectURL(this.files[0])" accept="image/png, image/jpg, image/jpeg, image/svg">
                                                    <span class="error" id="imageSpan">{{$errors->admin->first('image')}}</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    @if (empty($businessAboutUs->business->business_image))
                                                    <img src="{{ asset('assets/images/no-image.jpg') }}"
                                                    alt="No Image" class="logo-lg"
                                                    style="height:100px;width:100px" id="pic">
                                                    @else
                                                    <img src="{{ asset($businessAboutUs->business->business_image) }}"
                                                    alt="Business Image" class="logo-lg"
                                                    style="height:100px;width:100px" id="pic">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="description" class="col-sm-3 control-label">Business<span
                                                    class="error">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="business" name="business" class="form-control" value="{{$businessAboutUs->business->name}}" placeholder="Business" maxlength="30">
                                                        <span class="error" id="businessSpan">{{$errors->admin->first('business')}}</span>
                                                    </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="description" class="col-sm-3 control-label">Email<span
                                                    class="error">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="email" name="email" class="form-control" value="{{$businessAboutUs->business->email}}" placeholder="Email" maxlength="100">
                                                        <span class="error" id="emailSpan">{{$errors->admin->first('email')}}</span>
                                                    </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="description" class="col-sm-3 control-label">Contact<span
                                                    class="error">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="contact" name="contact" class="form-control" value="{{$businessAboutUs->business->contact}}" placeholder="Contact" maxlength="10">
                                                        <span class="error" id="contactSpan">{{$errors->admin->first('contact')}}</span>
                                                    </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="description" class="col-sm-3 control-label">Address Line 1<span
                                                    class="error">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="address_line1" name="address_line1" class="form-control" value="{{$businessAboutUs->business->address_line1}}" placeholder="Address Line 1" maxlength="100">
                                                        <span class="error" id="addressLine1Span">{{$errors->admin->first('address_line1')}}</span>
                                                    </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="description" class="col-sm-3 control-label">Address Line 2<span
                                                    class="error">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="address_line2" name="address_line2" class="form-control" value="{{$businessAboutUs->business->address_line2}}" placeholder="Address Line 2" maxlength="100">
                                                        <span class="error" id="addressLine2Span">{{$errors->admin->first('address_line2')}}</span>
                                                    </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="description" class="col-sm-3 control-label">City<span
                                                    class="error">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="city" name="city" class="form-control" value="{{$businessAboutUs->business->city}}" placeholder="City" maxlength="100">
                                                        <span class="error" id="citySpan">{{$errors->admin->first('city')}}</span>
                                                    </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="description" class="col-sm-3 control-label">Zip Code<span
                                                    class="error">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="zip_code" name="zip_code" class="form-control" value="{{$businessAboutUs->business->zip_code}}" placeholder="Zip Code" maxlength="6">
                                                        <span class="error" id="zipCodeSpan">{{$errors->admin->first('zip_code')}}</span>
                                                    </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="description" class="col-sm-3 control-label">About<span
                                                    class="error">*</span></label>
                                                    <div class="col-sm-9">
                                                    <textarea class="form-control" id="about" name="about" rows="10" placeholder="About" maxlength="500">{{$businessAboutUs->business->about}}</textarea>
                                                    <span class="error" id="aboutSpan">{{$errors->admin->first('about')}}</span>
                                                    </div>
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
    @section('js')
    <script>
        $('#businessDetailMainMenu').addClass('active');
        $('#aboutMenu').addClass('active subdrop');
        $('#businessDetailMenu').css('display','block');

        $(document ).ready(function() {
            $('#contact').on('input', function (event) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            $('#zip_code').on('input', function (event) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
        $("#businessAboutUsEditForm").submit(function(e) {
            var temp = 0;
            var image=$("#image").val();
            var email=$("#email").val();

            if($("#business").val().trim() == "")
            {
                $("#businessSpan").html("Please enter Business");
                temp++;
            }else if((/[^a-zA-Z0-9 ]/).test($("#business").val()))
            {
                $("#businessSpan").html("Special characters not allowed");
                temp++;
            }else if($("#business").val().length > 30)
            {
                $("#businessSpan").html("Business must not be greater than 30 character");
                temp++;
            }
            else
            {
                $("#businessSpan").html("");
            }

            if (email == "") {
                $('#emailSpan').html('Please enter Email');
                temp++;
            }else if($("#email").val().length > 100)
            {
                $("#emailSpan").html("Email must not be greater than 100 character");
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

            if($("#contact").val() == "")
            {
                $("#contactSpan").html("Please enter Contact");
                temp++;
            }else if($("#contact").val().length !== 10)
            {
                $("#contactSpan").html("Invalid Contact Format");
                temp++;
            }
            else
            {
                $("#contactSpan").html("");
            }

            if($("#address_line1").val() == "")
            {
                $("#addressLine1Span").html("Please enter Address Line1");
                temp++;
            }
            else
            {
                $("#addressLine1Span").html("");
            }

            if($("#address_line2").val() == "")
            {
                $("#addressLine2Span").html("Please enter Address Line2");
                temp++;
            }
            else
            {
                $("#addressLine2Span").html("");
            }

            if($("#city").val().trim() == "")
            {
                $("#citySpan").html("Please enter City");
                temp++;
            }else if((/[^a-zA-Z0-9 ]/).test($("#city").val()))
            {
                $("#citySpan").html("Special characters not allowed");
                temp++;
            }
            else
            {
                $("#citySpan").html("");
            }

            if($("#zip_code").val() == "")
            {
                $("#zipCodeSpan").html("Please enter Zip Code");
                temp++;
            }
            else
            {
                $("#zipCodeSpan").html("");
            }

            if($("#about").val() == "")
            {
                $("#aboutSpan").html("Please enter About");
                temp++;
            }
            else
            {
                $("#aboutSpan").html("");
            }

            if (image !== "") {
                var regex = new RegExp("(.*?)\.(jpg|png|jpeg|JPG|PNG|JPEG|svg|SVG)$");
                if (!(regex.test(image))) {
                    temp++;
                    $('#imageSpan').html("File must Image!! Like: JPG, JPEG, PNG and SVG");
                    $('#image').focus();
                } else {
                    $('#imageSpan').html("");
                    temp=0;
                }
            }

            if(temp !== 0 )
            {
                return false;
            }
        });
    </script>
    @endsection
@endsection
