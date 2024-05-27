@extends('layouts.app')
@section('content')
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
                        <h4 class="page-title">Profile</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card-box">

                        <h4 class="header-title mb-4">Edit</h4>

                        <div class="row">
                            <div class="col-xl-12">
                                <form action="{{ route('update-profile') }}" method="POST" id="profileForm"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="id" name="id" value="{{ $edit_data->id }}">
                                    <input type="hidden" id="old_img" name="old_img" value="{{ $edit_data->photo }}">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            placeholder="Enter First Name" value="{{ $edit_data->first_name }}"
                                            maxlength="50" required data-parsley-trigger="keyup"
                                            data-parsley-required-message="Please enter First Name."
                                            data-parsley-pattern="/^[a-zA-Z]+$/"
                                            data-parsley-pattern-message="Please enter valid First Name.">
                                        <span class="error"
                                            id="firstNameErrorSpan">{{ $errors->profile->first('first_name') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                            placeholder="Enter Last Name" value="{{ $edit_data->last_name }}"
                                            maxlength="50" required data-parsley-trigger="keyup"
                                            data-parsley-required-message="Please enter Last Name."
                                            data-parsley-pattern="/^[a-zA-Z]+$/"
                                            data-parsley-pattern-message="Please enter valid Last Name.">
                                        <span class="error"
                                            id="lastNameErrorSpan">{{ $errors->profile->first('last_name') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            placeholder="Enter email" value="{{ $edit_data->email }}" required
                                            data-parsley-trigger="keyup" data-parsley-type="email"
                                            data-parsley-required-message="Please enter Email."
                                            data-parsley-type-message="Please enter valid Email." maxlength="150">
                                        <span class="error"
                                            id="emailErrorSpan">{{ $errors->profile->first('email') }}</span>
                                    </div>
                                    {{-- Mobile will support the following formats:
                                    8880344456
                                    +918880344456
                                    +91 8880344456
                                    +91-8880344456
                                    08880344456
                                    918880344456 --}}
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Mobile</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile"
                                            placeholder="Enter Mobile" value="{{ $edit_data->mobile }}" maxlength="30"
                                            required data-parsley-trigger="keyup"
                                            data-parsley-required-message="Please enter Mobile."
                                            data-parsley-pattern="^(\+91[\-\s]?)?[0]?(91)?[789]\d{9}$"
                                            data-parsley-pattern-message="Please enter valid Mobile.">
                                        <span class="error"
                                            id="mobileErrorSpan">{{ $errors->profile->first('mobile') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Address</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            placeholder="Enter Address" value="{{ $edit_data->address }}"
                                            maxlength="250">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Image</label>
                                        <input type="file" class="form-control" id="file_img" name="file_img"
                                            accept="image/*" data-parsley-trigger="change"
                                            data-parsley-required-message='Please select Image.'
                                            data-parsley-filemaxmegabytes="4"
                                            data-parsley-filemimetypes="image/jpeg, image/png, image/jpg, image/bmp">
                                        <span class="error"
                                            id="imageErrorSpan">{{ $errors->profile->first('file_img') }}</span>
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
        var app = app || {};

        // Utils
        (function($, app) {
            'use strict';

            app.utils = {};

            app.utils.formDataSuppoerted = (function() {
                return !!('FormData' in window);
            }());

        }(jQuery, app));

        // Parsley validators
        (function($, app) {
            'use strict';

            window.Parsley
                .addValidator('filemaxmegabytes', {
                    requirementType: 'string',
                    validateString: function(value, requirement, parsleyInstance) {

                        if (!app.utils.formDataSuppoerted) {
                            return true;
                        }

                        var file = parsleyInstance.$element[0].files;
                        var maxBytes = requirement * 1048576;

                        if (file.length == 0) {
                            return true;
                        }

                        return file.length === 1 && file[0].size <= maxBytes;

                    },
                    messages: {
                        en: 'The profile photo must not be greater than 4 MB.'
                    }
                })
                .addValidator('filemimetypes', {
                    requirementType: 'string',
                    validateString: function(value, requirement, parsleyInstance) {

                        if (!app.utils.formDataSuppoerted) {
                            return true;
                        }

                        var file = parsleyInstance.$element[0].files;

                        if (file.length == 0) {
                            return true;
                        }

                        var allowedMimeTypes = requirement.replace(/\s/g, "").split(',');
                        return allowedMimeTypes.indexOf(file[0].type) !== -1;

                    },
                    messages: {
                        en: 'Image format must be in :jpg,jpeg,png,bmp'
                    }
                });

        }(jQuery, app));

        // Parsley Init
        (function($, app) {
            'use strict';

        }(jQuery, app));
        $(document).ready(function() {
            $('#profileForm').parsley();
        });
    </script>
@endsection
@endsection
