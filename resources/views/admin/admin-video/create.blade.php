@extends('admin.layouts.app')
@section('content')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Subscription</h4>
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
                                    <a href="{{ route('admin-video.index') }}"><button type="button" class="btn waves-effect btn-secondary"><i class="ion ion-md-arrow-back"></i></button></a>
                                </div>
                                <div class="col-12">
                                    <form method="POST" action="{{ route('admin-video.store') }}" id="adminVideoForm" class="form-horizontal" enctype='multipart/form-data'>
                                        @csrf
                                        <input type="hidden" id="type" name="type" value="{{$type}}">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 control-label space-for-label">Title<span class="error">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ old('title') }}">
                                                <span class="error" id="titleSpan">{{$errors->admin->first('title')}}</span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 control-label space-for-label">URL<span class="error">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="url" name="url" placeholder="URL" value="{{ old('url') }}">
                                                <span class="error" id="urlSpan">{{$errors->admin->first('url')}}</span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 control-label space-for-label">Description<span class="error">*</span></label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="description" name="description" placeholder="Description" rows="2">{{ old('description') }}</textarea>
                                                <span class="error" id="descriptionSpan">{{$errors->admin->first('description')}}</span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="logo" class="col-sm-2 control-label space-for-label">Video</label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" id="video" name="video" value="{{ $sitesetting->logo }}" accept="video/mp4,video/x-m4v,video/*">
                                                <span class="error" id="videoSpan">{{$errors->admin->first('logo')}}</span>
                                            </div>
                                            <div class="col-sm-4">
                                                <!-- <img src="{{ asset('assets/images/' . $sitesetting->logo) }}" alt="Logo" class="logo-lg" style="height:70px;" id="logoImage"> -->
                                            </div>
                                        </div>

                                        <div class="form-group m-b-0">
                                            <div class="col-sm-9">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
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
<script src="https://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>
<script>
    $(document).ready(function() {
        $('#price').on('input', function(event) {
            this.value = this.value.replace(/[^0-9.]/g, '');
        });
        $('#duration').on('input', function(event) {
            this.value = this.value.replace(/[^0-9.]/g, '');
        });
        $('#allowed_order').on('input', function(event) {
            this.value = this.value.replace(/[^0-9.]/g, '');
        });
        $('#price').attr('maxlength', '8');
        $('#plan_name').attr('maxlength', '100');
        $('#allowed_order').attr('maxlength', '5');
    });
    $("#adminVideoForm").submit(function(e) {
        var temp = 0;
        var description = $('#description').val();
        var video = $("#video").val();

        if ($("#title").val().trim() == "") {
            $("#titleSpan").html("Please enter Title");
            temp++;
        } else {
            $("#titleSpan").html("");
        }


        if (description == "" && description == "" && jQuery.trim(description).length == 0) {
            $("#descriptionSpan").html("Please enter Description");
            temp++;
        } else {
            $("#descriptionSpan").html("");
        }

        // if ($("#url").val().trim() == "") {
        //     $("#urlSpan").html("Please enter URL");
        //     temp++;
        // } else {
        //     $("#urlSpan").html("");
        // }

        if (video.trim() == '') {
            $("#videoSpan").html("Please select Video");
            temp++;
        } else {
            var videoRegex = new RegExp("(.*?)\.(mp4|avi|wmv|mov)$");
            if (!(videoRegex.test($("#video").val()))) {
                $('#videoSpan').html('File must Video!! Like: MP4,AVI,WMV,MOV');
                temp++;
            } else {
                $("#videoSpan").html("");
            }
        }
        if (temp !== 0) {
            return false;
        }
    });

    CKEDITOR.replace('description', {
        basicEntities: false
    });

    //$('#subscriptionMenu').addClass('active');
</script>
@endsection
@endsection