@extends('admin.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Admin Profile</h4>
            </div>
        </div>
        <div class="page-content-wrapper ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="m-t-0 m-b-30">Details</h4>
                                <form method="POST" action="{{ route('update-admin-profile') }}" id="adminProfileForm"
                                    class="form-horizontal" enctype='multipart/form-data'>
                                    @csrf
                                    @method('put')
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 control-label">Name<span
                                                class="error">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $admin->name }}" placeholder="Name">
                                            <span class="error" id="nameSpan">{{ $errors->admin->first('name') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 control-label">Email<span
                                                class="error">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="email" name="email"
                                                value="{{ $admin->email }}" placeholder="Email">
                                            <span class="error"
                                                id="emailSpan">{{ $errors->admin->first('email') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="image" class="col-sm-2 control-label">Image</label>
                                        <div class="col-sm-5">
                                            <input type="file" class="form-control" id="admin_image" name="image"
                                                oninput="pic.src=window.URL.createObjectURL(this.files[0])">
                                            <span class="error" id="imageSpan"></span>
                                        </div>
                                        @if (empty($admin->profile_image))
                                            <div class="col-sm-5">
                                                <img src="{{ asset('assets/images/users/nouser.png') }}" alt="user-img"
                                                    class="logo-lg" style="height:100px;width:100px" id="pic">
                                            </div>
                                        @else
                                            <div class="col-sm-5">
                                                <img src="{{ asset($admin->profile_image) }}"
                                                    alt="Admin-Profile-Image" class="logo-lg" style="height:100px;width:100px"
                                                    id="pic">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 control-label">Public Key</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="public_key" name="public_key" value="{{(!empty($admin->public_key))?$admin->public_key:''}}" placeholder="Public Key">
                                            <span class="error" id="publicKeySpan">{{$errors->admin->first('public_key')}}</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 control-label">Secret Key</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="secret_key" name="secret_key" value="{{(!empty($admin->secret_key))?$admin->secret_key:''}}" placeholder="Secret Key">
                                            <span class="error" id="secretKeySpan">{{$errors->admin->first('secret_key')}}</span>
                                        </div>
                                    </div>

                                    <div class="form-group m-b-0">
                                        <div class="col-sm-10">
                                            <button type="button"
                                                class="btn btn-primary waves-effect waves-light" onclick="checkForm();">Update</button>
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
    <script>
        var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
    </script>
    @section('js')
    <script>
        let checkAPIKeyComplete = false;
        let isValidAPIKey = false;
        function checkForm(){
            var email = $("#email").val();
            var name = $("#name").val();
            var image = $("#admin_image").val();
            var nameRegex = /[^a-zA-Z0-9]/;
            var temp = 0;
            if (name == "") {
                temp++;
                $('#nameSpan').html("Please enter Name");
                $('#name').focus();
            } else if (nameRegex.test(name)) {
                temp++;
                $('#nameSpan').html("Special characters not allowed");
                $('#name').focus();
            } else {
                temp = 0;
                $('#nameSpan').html("");
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
                    temp=0;
                }
            }

            if ($("#public_key").val().trim() == "") {
                temp++;
                $('#publicKeySpan').html("Please enter Public Key");
                $('#public_key').focus();
            }else{
                Stripe.setPublishableKey($("#public_key").val().trim());
                Stripe.createToken({}, function(status, response){
                    checkAPIKeyComplete = true;
                    if(status == 401) {
                            temp++;
                            $("#publicKeySpan").html("Please enter valid Public Key");
                            $('#public_key').focus();
                        } else {
                            isValidAPIKey = true;
                            $("#publicKeySpan").html("");
                        }
                    });
                }
            if ($("#secret_key").val().trim() == "") {
                temp++;
                $('#secretKeySpan').html("Please enter Secret Key");
                $('#secret_key').focus();
            }else {
                $('#secretKeySpan').html("");
            }

            if (temp !== 0) {
                return false;
            }
            else{
                setTimeout(() => {
                    if(checkAPIKeyComplete && isValidAPIKey)
                        $("#adminProfileForm").submit();
                    else
                    checkForm();
                },1000);
            }
        };
    </script>
    @endsection
@endsection
