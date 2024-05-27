<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ $module }} | {{ $sitesetting->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ asset($sitesetting->favicon) }}">

    <link href="{{ asset('business/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('business/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('business/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('business/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">

    <style>
        .field-icon {
        float: right;
        margin-left: -25px;
        margin-top: -25px;
        position: relative;
        z-index: 2;
    }
    </style>
</head>

<body>
    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page" style="width: 800px;">
        <div class="card card-pages">

            <div class="card-body">
                <div class="text-center m-t-0 m-b-15">
                    <img src="{{ asset($sitesetting->logo) }}" alt="" height="100">
                </div>
                <h4 class="text-muted text-center m-t-0"><b>Sign Up</b></h4>
                <form class="form-horizontal m-t-20" method="POST" action="{{ route('store-register') }}"
                    id="businessRegisterForm" enctype='multipart/form-data'>
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name<span class="error">*</span></label>
                                <input class="form-control" type="text" name="first_name" id="first_name"
                                    placeholder="First Name" maxlength="30">
                                <span class="error"
                                    id="firstNameSpan">{{ $errors->login->first('first_name') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name<span class="error">*</span></label>
                                <input class="form-control" type="text" name="last_name" id="last_name"
                                    placeholder="Last Name" maxlength="30">
                                <span class="error"
                                    id="lastNameSpan">{{ $errors->login->first('last_name') }}</span>
                            </div>
                        </div>


                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Email<span class="error">*</span></label>
                                <input class="form-control" type="text" id="email" name="email" placeholder="Email">
                                <span class="error" id="emailSpan">{{ $errors->login->first('email') }}</span>
                            </div>
                        </div>


                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Password<span class="error">*</span></label>
                                <input class="form-control" type="password" id="password" name="password"
                                    placeholder="Password">
                                    <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                <span class="error"
                                    id="passwordSpan">{{ $errors->login->first('password') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Confirm Password<span class="error">*</span></label>
                                <input class="form-control" type="password" id="confirm_password"
                                    name="confirm_password" placeholder="Confirm Password">
                                    <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                <span class="error"
                                    id="confirmPasswordSpan">{{ $errors->login->first('confirm_password') }}</span>
                            </div>
                        </div>


                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Profile Image</label>
                                <input type="file" class="form-control" id="image" name="image"
                                    oninput="pic.src=window.URL.createObjectURL(this.files[0])"
                                    accept="image/png, image/jpg, image/jpeg, image/svg">
                                <span class="error" id="imageSpan">{{ $errors->login->first('image') }}</span>
                            </div>
                        </div>
                        {{-- <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <img src="{{ asset('assets/images/no-image.jpg') }}" alt="Image"
                                    class="logo-lg" style="height:100px;width:100px" id="pic">
                            </div>
                        </div> --}}

                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Business Name<span class="error">*</span></label>
                                <input class="form-control" type="text" id="business_name" name="business_name"
                                    placeholder="Business Name">
                                <span class="error"
                                    id="businessNameSpan">{{ $errors->login->first('business_name') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Business Email<span class="error">*</span></label>
                                <input class="form-control" type="text" id="business_email" name="business_email"
                                    placeholder="Business Email">
                                <span class="error"
                                    id="businessEmailSpan">{{ $errors->login->first('business_email') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Business Contact<span class="error">*</span></label>
                                <input class="form-control" type="text" id="business_contact" name="business_contact"
                                    placeholder="Business Contact">
                                <span class="error"
                                    id="businessContactSpan">{{ $errors->login->first('business_contact') }}</span>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Address Line 1<span class="error">*</span></label>
                                <input class="form-control" type="text" id="address_line1" name="address_line1"
                                    placeholder="Address Line 1">
                                <span class="error"
                                    id="addressLine1Span">{{ $errors->login->first('address_line1') }}</span>
                            </div>
                        </div>
                        <input type="hidden" id="latitude" name="latitude" >

                        <input type="hidden" name="longitude" id="longitude" >

                        <div class="col-6">
                            <div class="form-group">
                                <label>Address Line 2<span class="error">*</span></label>
                                <input class="form-control" type="text" id="address_line2" name="address_line2"
                                    placeholder="Address Line 2">
                                <span class="error"
                                    id="addressLine2Span">{{ $errors->login->first('address_line2') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>City<span class="error">*</span></label>
                                <input class="form-control" type="text" id="city" name="city" placeholder="City">
                                <span class="error" id="citySpan">{{ $errors->login->first('city') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Postcode<span class="error">*</span></label>
                                <input class="form-control" type="text" id="zip_code" name="zip_code"
                                    placeholder="Postcode">
                                <span class="error"
                                    id="zipCodeSpan">{{ $errors->login->first('zip_code') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Service<span class="error">*</span></label>
                                <select class="form-control" id="service" name="service">
                                    <option value="">Select Service</option>
                                    @foreach ($service as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error"
                                    id="serviceSpan">{{ $errors->login->first('service') }}</span>
                            </div>
                        </div>

                       
                
                        <div style="display:none;" id="divLocation"></div>
                      

                        <div class="col-md-12 col-lg-12">
                            <div class="form-group">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-signup" type="checkbox" id="terms_and_conditions"
                                        name="terms_and_conditions">
                                    <label for="checkbox-signup">
                                    I accept <a href="{{route('terms-conditions')}}" target="_blank">Terms and Conditions &</a>
                                            <a href="{{route('privacy-policy')}}" target="_blank">Privacy and Policy and</a>
                                            <a href="{{route('cookies')}}" target="_blank">Cookies</a>
                                    </label>
                                </div>
                                <span class="error"
                                    id="termsAndConditionsSpan">{{ $errors->login->first('terms_and_conditions') }}</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group text-center m-t-40">
                                <button class="btn btn-primary btn-block btn-lg waves-effect waves-light"
                                    type="submit">Register</button>
                            </div>
                        </div>

                        <div class="col-sm-12 text-center">
                            <div class="form-group m-t-30 m-b-0">
                                <a href="{{ route('business-login') }}" class="text-muted">Already have
                                    account?</a>
                            </div>
                        </div>
                </form>
            </div>
        </div>

        <div id="examplemodal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
            aria-labelledby="cancelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title m-0" id="timeslotsModalLabel">Terms & Conditions</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <p>
                        1. ACCEPTANCE THE USE OF LOREM IPSUM TERMS AND CONDITIONS
                        Your access to and use of Lorem Ipsum (the app) is subject exclusively to these Terms and
                        Conditions. You will not use the app for any purpose that is unlawful or prohibited by these
                        Terms and Conditions. By using the app you are fully accepting the terms, conditions and
                        disclaimers contained in this notice. If you do not accept these Terms and Conditions you must
                        immediately stop using the app.
                    </p>
                    <p>
                        2. CREDIT CARD DETAILS
                        All Lorem Ipsum purchases are managed by the individual App Stores (Apple, Google Windows) and
                        Lorem Ipsum will never store your credit card information or make it available to any third
                        parties. Any purchasing information provided will be provided directly from you to the
                        respective App Store and you will be subject to their credit card policies.
                    </p>
                    <p>
                        3. LEGAL ADVICE
                        The contents of Lorem Ipsum app do not constitute advice and should not be relied upon in making
                        or refraining from making, any decision.
                        All material contained on Lorem Ipsum is provided without any or warranty of any kind. You use
                        the material on Lorem Ipsum at your own discretion
                    </p>
                    <p>
                        4. CHANGE OF USE
                        Lorem Ipsum reserves the right to:
                        4.1 change or remove (temporarily or permanently) the app or any part of it without notice and
                        you confirm that Lorem Ipsum shall not be liable to you for any such change or removal and.
                        4.2 change these Terms and Conditions at any time, and your continued use of the app following
                        any changes shall be deemed to be your acceptance of such change.
                    </p>
                    <p>
                        5. LINKS TO THIRD PARTY APPS AND WEBSITES
                        Lorem Ipsum app may include links to third party apps and websites that are controlled and
                        maintained by others. Any link to other apps and websites is not an endorsement of such and you
                        acknowledge and agree that we are not responsible for the content or availability of any such
                        apps and websites.
                    </p>
                    <p>
                        6. COPYRIGHT
                        6.1 All copyright, trade marks and all other intellectual property rights in the app and its
                        content (including without limitation the app design, text, graphics and all software and source
                        codes connected with the app) are owned by or licensed to Lorem Ipsum or otherwise used by Lorem
                        Ipsum as permitted by law.
                        6.2 In accessing the app you agree that you will access the content solely for your personal,
                        non-commercial use. None of the content may be downloaded, copied, reproduced, transmitted,
                        stored, sold or distributed without the prior written consent of the copyright holder. This
                        excludes the downloading, copying and/or printing of pages of the app for personal,
                        non-commercial home use only.
                    </p>
                    <p>
                        7. LINKS TO AND FROM OTHER APPS AND WEBSITES
                        7.1 Throughout this app you may find links to third party apps. The provision of a link to such
                        an app does not mean that we endorse that app. If you visit any app via a link in this app you
                        do so at your own risk.
                        7.2 Any party wishing to link to this app is entitled to do so provided that the conditions
                        below are observed:
                        (a) You do not seek to imply that we are endorsing the services or products of another party
                        unless this has been agreed with us in writing;
                        (b) You do not misrepresent your relationship with this app; and
                        (c) The app from which you link to this app does not contain offensive or otherwise
                        controversial content or, content that infringes any intellectual property rights or other
                        rights of a third party.
                        7.3 By linking to this app in breach of our terms, you shall indemnify us for any loss or damage
                        suffered to this app as a result of such linking.
                    </p>
                    <p>
                        8. DISCLAIMERS AND LIMITATION OF LIABILITY
                        8.1 The app is provided on an AS IS and AS AVAILABLE basis without any representation or
                        endorsement made and without warranty of any kind whether express or implied, including but not
                        limited to the implied warranties of satisfactory quality, fitness for a particular purpose,
                        non-infringement, compatibility, security and accuracy.
                        8.2 To the extent permitted by law, Lorem Ipsum will not be liable for any indirect or
                        consequential loss or damage whatever (including without limitation loss of business,
                        opportunity, data, profits) arising out of or in connection with the use of the app.
                        8.3 Lorem Ipsum makes no warranty that the functionality of the app will be uninterrupted or
                        error free, that defects will be corrected or that the app or the server that makes it available
                        are free of viruses or anything else which may be harmful or destructive.
                        8.4 Nothing in these Terms and Conditions shall be construed so as to exclude or limit the
                        liability of Lorem Ipsum for death or personal injury as a result of the negligence of Lorem
                        Ipsum or that of its employees or agents.
                    </p>
                    <p>
                        9. INDEMNITY
                        You agree to indemnify and hold Lorem Ipsum and its employees and agents harmless from and
                        against all liabilities, legal fees, damages, losses, costs and other expenses in relation to
                        any claims or actions brought against Lorem Ipsum arising out of any breach by you of these
                        Terms and Conditions or other liabilities arising out of your use of this app.
                    </p>
                    <p>
                        10. SEVERANCE
                        If any of these Terms and Conditions should be determined to be invalid, illegal or
                        unenforceable for any reason by any court of competent jurisdiction then such Term or Condition
                        shall be severed and the remaining Terms and Conditions shall survive and remain in full force
                        and effect and continue to be binding and enforceable.
                    </p>
                    <p>
                        11. WAIVER
                        If you breach these Conditions of Use and we take no action, we will still be entitled to use
                        our rights and remedies in any other situation where you breach these Conditions of Use.
                    </p>
                    <p>
                        12. GOVERNING LAW
                        These Terms and Conditions shall be governed by and construed in accordance with the law of and
                        you hereby submit to the exclusive jurisdiction of the courts.
                    </p>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

    </div>
    </div>
    <div id="testt"></div>
    <!-- jQuery  -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/js/detect.js') }}"></script>
    <script src="{{ asset('assets/js/fastclick.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('assets/js/waves.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{asset('business/plugins/timepicker/bootstrap-timepicker.js')}}"></script>
    <script src="{{asset('business/pages/form-advanced.js')}}"></script>
    
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ENV('GOOGLE_MAP_KEY')}}&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
    <script>
        jQuery('#timepicker4').timepicker({showMeridian: false});
        jQuery('#timepicker5').timepicker({showMeridian: false});
        jQuery('#timepicker6').timepicker({showMeridian: false});
        function initAutocomplete() {

            var address = document.getElementById('address_line1');
            var autocomplete = new google.maps.places.Autocomplete(address);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                
                var htmldiv = $("#divLocation").html(place.adr_address);
                
                var to_aadress_short = place.name;
                var to_aadress_full = place.formatted_address;
                var locality = $(".locality").html();
                var country_name = $(".country-name").html();
                var postcode = $(".postal-code").html();
               
                $("#address_line1").val(to_aadress_full);
                $("#city").val(locality);
                $("#zip_code").val(postcode);

                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();

                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $("#business_contact").attr('maxlength','10');
            $("#zip_code").attr('maxlength','6');
            $("#city").attr('maxlength','100');

            $('#zip_code').on('input', function(event) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            $('#business_contact').on('input', function(event) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });

        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });



        $("#businessRegisterForm").submit(function(e) {
            var temp = 0;
            var password = $("#password").val();
            var email = $("#email").val();
            var business_contact = $("#business_contact").val();
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            let isChecked = $('input[name=terms_and_conditions]:checked').val();

            if ($("#first_name").val() == "") {
                $("#firstNameSpan").html("Please enter First Name");
                temp++;
            } else if ((/[^a-zA-Z0-9]/).test($("#first_name").val())) {
                $("#firstNameSpan").html("Special characters not allowed");
                temp++;
            } else {
                $("#firstNameSpan").html("");
            }

            if ($("#last_name").val() == "") {
                $("#lastNameSpan").html("Please enter Last Name");
                temp++;
            } else if ((/[^a-zA-Z0-9]/).test($("#last_name").val())) {
                $("#lastNameSpan").html("Special characters not allowed");
                temp++;
            } else {
                $("#lastNameSpan").html("");
            }

            if (email == "") {
                $('#emailSpan').html('Please enter Email');
                temp++;
            } else if (!regex.test(email)) {
                $('#emailSpan').html('Please enter valid Email');
                temp++;
            } else {
                $('#emailSpan').html('');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    async: false,
                    url: '{{ route('businessuser-check-email') }}',
                    data: {
                        email: $("#email").val()
                    },
                    success: function(data) {
                        if (data.message == 'exist') {
                            $('#emailSpan').html('Email is already exists');
                            temp++;
                        }
                    },
                });
            }


            if (password == "") {
                $('#passwordSpan').html('Please enter Password');
                temp++;
            } else if (password.length < 8) {
                $('#passwordSpan').html('Please enter minimum 8 character');
                temp++;
            } else {
                var regex = /^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/;
                if (!regex.test(password)) {
                    $('#passwordSpan').html(
                        'Password must contain one special character, one lowercase and one number');
                    temp++;
                } else {
                    $('#passwordSpan').html('');
                }
            }


            if ($("#image").val() != "") {
                var imageRegex = new RegExp("(.*?)\.(jpg|png|jpeg|JPG|PNG|JPEG|svg|SVG)$");
                if (!(imageRegex.test($("#image").val()))) {
                    $('#imageSpan').html('Invalid Image Format');
                    temp++;
                } else {
                    $('#imageSpan').html('');
                }
            }

            if ($("#confirm_password").val() == "") {
                $('#confirmPasswordSpan').html('Please enter Confirm Password');
                temp++;
            } else if ($("#confirm_password").val() !== password) {
                $('#confirmPasswordSpan').html('Conform password does not match');
                temp++;
            } else {
                $('#confirmPasswordSpan').html('');
            }

            if ($("#business_name").val() == "") {
                $('#businessNameSpan').html('Please enter Business Name');
                temp++;
            } else {
                $('#businessNameSpan').html('');
            }

            if ($("#business_email").val() == "") {
                $('#businessEmailSpan').html('Please enter Business Email');
                temp++;
            } else {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!regex.test($("#business_email").val())) {
                    $('#businessEmailSpan').html('Please enter valid Email');
                    temp++;
                } else {
                    $('#businessEmailSpan').html('');
                }
            }

            if (business_contact == "") {
                $('#businessContactSpan').html('Please enter Business Contact');
                temp++;
            } else if (business_contact.length !== 10) {
                $('#businessContactSpan').html('Please enter valid Contact');
                temp++;
            } else {
                $('#businessContactSpan').html('');
            }

            if ($("#address_line1").val() == "") {
                $('#addressLine1Span').html('Please enter Address Line1');
                temp++;
            } else {
                $('#addressLine1Span').html('');
            }

            if ($("#address_line2").val() == "") {
                $('#addressLine2Span').html('Please enter Address Line2');
                temp++;
            } else {
                $('#addressLine2Span').html('');
            }

            if ($("#city").val() == "") {
                $('#citySpan').html('Please enter City');
                temp++;
            } else if ((/[^a-zA-Z]/).test($("#city").val())) {
                $("#citySpan").html("Please enter Valid");
                temp++;
            } else {
                $('#citySpan').html('');
            }

            if ($("#zip_code").val() == "") {
                $('#zipCodeSpan').html('Please enter Zip Code');
                temp++;
            } else {
                $('#zipCodeSpan').html('');
            }

            if ($("#service").val() == "") {
                $('#serviceSpan').html('Please select Service');
                temp++;
            } else {
                $('#serviceSpan').html('');
            }
            if (isChecked != "on") {
                $('#termsAndConditionsSpan').html('Please accept Terms and Conditions');
                temp++;
            } else {
                $('#termsAndConditionsSpan').html('');
            }

            // if ($("#opening_time").val() == "") {
            //     $('#openingTimeSpan').html('Please enter Opening time');
            //     temp++;
            // }else {
            //     $('#openingTimeSpan').html('');
            // }

            // if ($("#closing_time").val() == "") {
            //     $('#closingTimeSpan').html('Please enter Closing time');
            //     temp++;
            // }else {
            //     $('#closingTimeSpan').html('');
            // }

            if (temp !== 0) {
                return false;
            }
        });
    </script>
</body>

</html>
