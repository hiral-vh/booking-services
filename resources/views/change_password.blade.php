@extends('layouts.app')
@section('content')
@section('style')
    <style>
        .field-icon {
            right: 10px;
            position: absolute;
            z-index: 2;
            top: 40px;
        }

        .container {
            padding-top: 50px;
            margin: auto;
        }
    </style>
@endsection
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('login') }}">{{ env('APP_NAME') }}</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Change Password</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <h4 class="header-title mb-4">Edit</h4>

                    <div class="row">
                        <div class="col-xl-12">
                            <form action="{{ route('update-password') }}" method="POST" id="changePasswordForm"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="id" name="id" value="{{ $edit_data->id }}">
                                <div class="form-group position-relative">
                                    <label for="exampleInputEmail1">Old Password</label>
                                    <input type="password" class="form-control" id="old_password" name="old_password"
                                        placeholder="Enter Old Password" required data-parsley-trigger="keyup"
                                        data-parsley-required-message="Please enter Old Password."
                                        data-parsley-checkoldpassword
                                        data-parsley-checkoldpassword-message="Entered Old Password does not match.">
                                    <span toggle="#old_password" class="fa fa-fw fa-eye field-icon toggle-password"
                                        style="cursor: pointer"></span>
                                    <span class="error"
                                        id="oldPasswordErrorSpan">{{ $errors->changePassword->first('old_password') }}</span>
                                </div>
                                <div class="form-group position-relative">
                                    <label for="exampleInputEmail1">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password"
                                        placeholder="Enter New Password" required data-parsley-trigger="keyup"
                                        data-parsley-required-message="Please enter New Password."
                                        data-parsley-minlength="6"
                                        data-parsley-minlength-message="New Password must be at least 6 characters."
                                        data-parsley-maxlength="40"
                                        data-parsley-maxlength-message="New Password must be maximum 40 characters.">
                                    <span toggle="#new_password" class="fa fa-fw fa-eye field-icon toggle-password1"
                                        style="cursor: pointer"></span>
                                    <span class="error"
                                        id="newPasswordErrorSpan">{{ $errors->changePassword->first('new_password') }}</span>
                                </div>
                                <div class="form-group position-relative">
                                    <label for="exampleInputEmail1">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password"
                                        name="confirm_password" placeholder="Enter Confirm Password" required
                                        data-parsley-trigger="keyup"
                                        data-parsley-required-message="Please enter Confirm Password."
                                        data-parsley-equalto="#new_password"
                                        data-parsley-equalto-message="Confirm Password must be same as New Password">
                                    <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password2"
                                        style="cursor: pointer"></span>
                                    <span class="error"
                                        id="newPasswordErrorSpan">{{ $errors->changePassword->first('new_password') }}</span>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                        <!-- end col -->

                    </div>
                    <!-- end row -->
                </div>
            </div>
            <!-- end col -->
        </div>
    </div>
</div>
@section('script')
    <script>
        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $(".toggle-password1").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $(".toggle-password2").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        window.ParsleyValidator.addValidator('checkoldpassword', {
            validateString: function(value) {
                return $.ajax({
                    url: "{{ route('check-old-password') }}?",
                    method: "GET",
                    async: false,
                    data: {
                        id: $("#id").val(),
                        old_password:$("#old_password").val()
                    },
                    dataType: "json",
                    success: function(data) {
                        return true;
                    }
                });
            }
        });

        $(document).ready(function() {
            $('#changePasswordForm').parsley();
        });
    </script>
@endsection
@endsection
