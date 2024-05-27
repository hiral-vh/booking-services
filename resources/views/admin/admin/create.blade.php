@extends('admin.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Admin</h4>
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
                                        <a href="{{ route('admin-index') }}" title="Back"><button type="button"
                                                class="btn waves-effect btn-secondary"><i
                                                    class="ion ion-md-arrow-back"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                    <li>{{$error}}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <form method="POST" action="{{ route('admin-store') }}" id="adminCreateForm"
                                            class="form-horizontal" enctype='multipart/form-data'>
                                            @csrf
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 control-label space-for-label">Name<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        placeholder="Name" value="{{old('name')}}" maxlength="25">
                                                    <span class="error" id="nameSpan">{{$errors->admin->first('name')}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-2 control-label space-for-label">Email<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="email" name="email"
                                                        placeholder="Email" value="{{old('email')}}">
                                                    <span class="error" id="emailSpan">{{$errors->admin->first('email')}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-2 control-label space-for-label">Password<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" id="password" name="password"
                                                        placeholder="Password">
                                                    <span class="error" id="passwordSpan"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-2 control-label space-for-label">Confirm Password<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" id="confirmPassword"
                                                        name="confirmPassword" placeholder="Confirm Password">
                                                    <span class="error" id="confirmPasswordSpan"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="image" class="col-sm-2 control-label space-for-label">Profile Image</label>
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
    @section('page-js')
    <script>
        $("#adminCreateForm").submit(function(e) {
            var temp = 0;
            var email = $("#email").val();
            var password=$("#password").val();
            var confirmPassword=$("#confirmPassword").val();
            if($("#name").val() == "")
            {
                $("#nameSpan").html("Please enter Name");
                temp++;
            }else if((/[^a-zA-Z0-9 ]/).test($("#name").val()))
            {
                $("#nameSpan").html("Special characters not allowed");
                temp++;
            }
            else
            {
                $("#nameSpan").html("");
            }

            if (email == "") {
                $('#emailSpan').html('Please enter Email');
                temp++;
            } else {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!regex.test(email)) {
                    $('#emailSpan').html('Please enter valid Email');
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
                $('#passwordSpan').html('Please enter minimum 8 character');
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
            }else{
                $('#confirmPasswordSpan').html('');
            }

            if($("#profileImage").val()!=="")
            {
                var imageRegex = new RegExp("(.*?)\.(jpg|png|jpeg|JPG|PNG|JPEG|svg|SVG)$");
                if (!(imageRegex.test($("#profileImage").val())))
                {
                    $('#profileImageSpan').html('File must Image!! Like: JPG, JPEG, PNG and SVG');
                    temp++;
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
