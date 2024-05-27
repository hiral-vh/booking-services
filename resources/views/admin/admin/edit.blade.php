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
                                        <h4 class="m-t-0 m-b-30">Edit</h4>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{ route('admin-index') }}" title="Back"><button type="button"
                                                class="btn waves-effect btn-secondary"><i
                                                    class="ion ion-md-arrow-back"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        <form method="POST" action="{{ route('admin-update', $admin->id) }}"
                                            id="adminEditForm" class="form-horizontal" enctype='multipart/form-data'>
                                            @csrf
                                            @method('put')
                                            <input type="hidden" class="form-control" id="id" name="id" value="{{ $admin->id }}">
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 control-label space-for-label">Name<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        value="{{ $admin->name }}" placeholder="Name">
                                                    <span class="error" id="nameSpan">{{$errors->admin->first('name')}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-2 control-label space-for-label">Email<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="email" name="email"
                                                        placeholder="Email" value="{{ $admin->email }}">
                                                    <span class="error" id="emailSpan">{{$errors->admin->first('email')}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="image" class="col-sm-2 control-label space-for-label">Profile Image</label>
                                                <div class="col-sm-5">
                                                    <input type="file" class="form-control" id="profileImage"
                                                        name="profileImage"
                                                        oninput="pic.src=window.URL.createObjectURL(this.files[0])" accept="image/png, image/jpg, image/jpeg, image/svg">
                                                    <span class="error" id="profileImageSpan">{{$errors->admin->first('profileImage')}}</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    @if (!empty($admin->profile_image))
                                                        <img src="{{ asset($admin->profile_image) }}"
                                                            alt="Profile Image" class="logo-lg"
                                                            style="height:100px;width:100px" id="pic">
                                                    @else
                                                        <img src="{{ asset('assets/images/users/nouser.png') }}"
                                                            alt="Profile Image" class="logo-lg"
                                                            style="height:100px;width:100px" id="pic">
                                                    @endif
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
        $("#adminEditForm").submit(function(e) {
            var id=$("#id").val();
            var temp = 0;
            var email = $("#email").val();

            if($("#name").val() == "")
            {
                $("#nameSpan").html("Please enter Name");
                temp++;
            }else if((/[^a-zA-Z0-9 ]/).test($("#name").val()))
            {
                $("#nameSpan").html("Special Characters Not Allowed");
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
                    $('#emailSpan').html('The Email Is Not Valid');
                    temp++;
                } else {
                    $('#emailSpan').html('');
                }
            }


            if ($("#profileImage").val() !== "") {
                var imageRegex = new RegExp("(.*?)\.(jpg|png|jpeg|JPG|PNG|JPEG|svg|SVG)$");
                if (!(imageRegex.test($("#profileImage").val()))) {
                    $('#profileImageSpan').html('File must Image!! Like: JPG, JPEG, PNG and SVG');
                    temp++;
                }
            }

            if (temp !== 0) {
                return false;
            }
        });
    </script>
@endsection
@endsection
