@extends('admin.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Site Settings</h4>
            </div>
        </div>

        <div class="page-content-wrapper ">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="m-t-0 m-b-30">Edit</h4>
                                <form method="POST" action="{{ route('update-site-settings') }}" id="siteSettingsForm"
                                    class="form-horizontal" enctype='multipart/form-data'>
                                    @csrf
                                    @method('put')
                                    <div class="form-group row">
                                        <label for="title" class="col-sm-1 control-label space-for-label">Title<span
                                                class="error">*</span></label>
                                        <div class="col-sm-11">
                                            <input type="text" class="form-control" id="title" name="title"
                                                value="{{ $sitesetting->title }}" placeholder="Title">
                                            <span class="error" id="titleSpan">{{$errors->admin->first('title')}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="logo" class="col-sm-1 control-label space-for-label">Logo</label>
                                        <div class="col-sm-5">
                                            <input type="file" class="form-control" id="logoSelectImage" name="logo"
                                                oninput="logoImage.src=window.URL.createObjectURL(this.files[0])" value="{{ $sitesetting->logo }}" accept="image/png">
                                            <span class="error" id="logoSpan">{{$errors->admin->first('logo')}}</span>
                                        </div>
                                        <div class="col-sm-4">
                                        <img src="{{ asset($sitesetting->logo) }}" alt="Logo" class="logo-lg" style="height:70px;" id="logoImage">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="favicon" class="col-sm-1 control-label">Favicon</label>
                                        <div class="col-sm-5">
                                            <input type="file" class="form-control" id="faviconSelectImage" name="favicon"
                                                oninput="faviconImage.src=window.URL.createObjectURL(this.files[0])" value="{{ $sitesetting->favicon }}" accept="image/jpg">
                                            <span class="error" id="faviconSpan">{{$errors->admin->first('favicon')}}</span>
                                        </div>
                                        <div class="col-sm-4">
                                        <img src="{{ asset($sitesetting->favicon) }}" alt="Favicon" class="logo-lg" style="height:70px;" id="faviconImage">
                                        </div>
                                    </div>
                                    <div class="form-group m-b-0">
                                        <div class="col-sm-9">
                                            <button type="submit"
                                                class="btn btn-primary waves-effect waves-light">Update</button>
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
        $("#siteSettingsForm").submit(function(e){
            var logo=$("#logoSelectImage").val();
            var favicon=$("#faviconSelectImage").val();
            var logoExtenstion=logo.substr( (logo.lastIndexOf('.') +1));
            var faviconExtenstion=favicon.substr( (favicon.lastIndexOf('.') +1));
            if($("#title").val().trim()=="")
            {
                e.preventDefault();
                $("#titleSpan").html("Please enter Title");
                $("#titleSpan").focus();
            }

            if(logo !== "")
            {
                if(logoExtenstion !== "png")
                {
                    e.preventDefault();
                    $("#logoSpan").html("File must PNG Image!!");
                    $("#logoSpan").focus();
                }
            }
            else
            {
                $("#logoSpan").html("");
            }
            if(favicon !== "")
            {
                if(faviconExtenstion !== "ico")
                {
                    e.preventDefault();
                    $("#faviconSpan").html("File must ICO Image!!");
                    $("#faviconSpan").focus();
                }
            }
            else
            {
                $("#faviconSpan").html("");
            }
        });
    </script>
    @endsection
    @endsection
