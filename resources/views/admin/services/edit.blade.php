@extends('admin.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Business Services</h4>
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
                                        <a href="{{ route('services.index') }}"><button type="button"
                                                class="btn waves-effect btn-secondary"><i
                                                    class="ion ion-md-arrow-back"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        <form method="POST" action="{{ route('services.update',$service->id) }}" id="adminEditForm"
                                            class="form-horizontal" enctype='multipart/form-data'>
                                            @csrf
                                            @method('put')
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-1 control-label space-for-label">Service<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-11">
                                                    <input type="text" class="form-control" id="name" name="name" value="{{$service->name}}"
                                                        placeholder="Service">
                                                    <span class="error" id="nameSpan">{{$errors->admin->first('name')}}</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="image" class="col-sm-1 control-label space-for-label">Image<span
                                                    class="error">*</span></label>
                                                <div class="col-sm-5">
                                                    <input type="file" class="form-control" id="serviceImage"
                                                        name="image" value="{{$service->image}}"
                                                        oninput="pic.src=window.URL.createObjectURL(this.files[0])" accept="image/png, image/jpg, image/jpeg, image/svg">
                                                    <span class="error" id="imageSpan">{{$errors->admin->first('image')}}</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    @if (empty($service->image))
                                                    <img src="{{ asset('assets/images/no-image.jpg') }}"
                                                    alt="Image" class="logo-lg"
                                                    style="height:100px;width:100px" id="pic">
                                                    @else
                                                    <img src="{{ asset($service->image) }}"
                                                    alt="Image" class="logo-lg"
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
            var temp = 0;
            if ($("#name").val() == "") {
                $("#nameSpan").html("Please enter Service");
                temp++;
            }else if($("#name").val().length > 30)
            {
                $("#nameSpan").html("Service must not be greater than 30 character");
                temp++;
            }
            else if((/[^a-zA-Z0-9 ]/).test($("#name").val()))
            {
                $("#nameSpan").html("Special characters not allowed");
                temp++;
            }
            else {
                $("#nameSpan").html("");
            }

            if($('#serviceImage').val() !== "")
            {
                var imageRegex = new RegExp("(.*?)\.(jpg|png|jpeg|JPG|PNG|JPEG|svg|SVG)$");
                if (!(imageRegex.test($("#serviceImage").val())))
                {
                    $('#imageSpan').html('File must Image!! Like: JPG, JPEG, SVG and PNG');
                    temp++;
                }
                else
                {
                    $('#imageSpan').html('');
                }
            }
            if(temp !== 0 )
            {
                return false;
            }
        });

    $('#catgory_menu_open').css('display','block');
    $('#businessServiceMenu').addClass('active');
    $('#categoryManagementMenu').addClass('active');
    </script>
    @endsection
@endsection