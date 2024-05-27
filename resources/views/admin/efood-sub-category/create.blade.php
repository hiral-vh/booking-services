@extends('admin.layouts.app')
@section('content')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Food Sub Category</h4>
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
                                    <a href="{{ route('food-sub-category.index') }}"><button type="button" class="btn waves-effect btn-secondary"><i class="ion ion-md-arrow-back"></i></button></a>
                                </div>
                                <div class="col-12">
                                    <form method="POST" action="{{ route('food-sub-category.store') }}" id="adminCreateForm" class="form-horizontal" enctype='multipart/form-data'>
                                        @csrf
                                        <div class="form-group row">
                                            <label for="service" class="col-sm-2 control-label space-for-label">Category<span class="error">*</span></label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="category_id" name="category_id">
                                                    <option value="">Select Category</option>
                                                    @foreach ($category as $value)
                                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach

                                                </select>
                                                <span class="error" id="categorySpan">{{$errors->admin->first('service')}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 control-label space-for-label">Sub Category<span class="error">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Sub Category">
                                                <span class="error" id="nameSpan">{{$errors->admin->first('name')}}</span>
                                            </div>
                                        </div>
                                        {{-- <div class="form-group row">
                                            <label for="image" class="col-sm-2 control-label space-for-label">Image<span class="error">*</span></label>
                                            <div class="col-sm-5">

                                                <input type="file" class="form-control" id="subCategoryImage" name="image" oninput="pic.src=window.URL.createObjectURL(this.files[0])">
                                                <span class="error" id="imageSpan">{{$errors->admin->first('image')}}</span>
                                            </div>
                                            <div class="col-sm-4">
                                                <img src="{{ asset('assets/images/no-image.jpg') }}" alt="Image" class="logo-lg" style="height:100px;width:100px" id="pic">
                                            </div>
                                        </div> --}}


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
@section('page-js')
<script>
    $("#adminCreateForm").submit(function(e) {
        var temp = 0;

        if ($("#category_id").val() == "") {
            $("#categorySpan").html("Please select Category");
            temp++;
        } else {
            $("#categorySpan").html("");
        }

        if ($("#name").val() == "") {
            $("#nameSpan").html("Please enter Sub Category");
            temp++;
        }else if($("#name").val().length > 30)
        {
            $("#nameSpan").html("Sub Category must not be greater than 30 character");
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

        // if ($("#subCategoryImage").val() == "") {
        //     $("#imageSpan").html("Please select Image");
        //     temp++;
        // } else {
        //     var imageRegex = new RegExp("(.*?)\.(jpg|png|jpeg|JPG|PNG|JPEG|svg|SVG)$");
        //     if (!(imageRegex.test($("#subCategoryImage").val()))) {
        //         $('#imageSpan').html('Please select valid Image');
        //         temp++;
        //     } else {
        //         $('#imageSpan').html('');
        //     }
        // }


        if (temp !== 0) {
            return false;
        }
    });

    $('#restaurantSubCategoryMenu').addClass('active');
    $('#restaurantSubCategoryMenu').addClass('active subdrop');
    $('#catgory_menu_open').css('display','block');
    $('#categoryManagementMenu').addClass('active');
</script>
@endsection
@endsection
