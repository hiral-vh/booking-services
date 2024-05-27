@extends('admin.layouts.app')
@section('content')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Cuisine</h4>
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
                                    <a href="{{ route('cuisine.index') }}"><button type="button" class="btn waves-effect btn-secondary"><i class="ion ion-md-arrow-back"></i></button></a>
                                </div>
                                <div class="col-12">
                                    <form method="POST" action="{{ route('cuisine.update',$cuisine->id) }}" id="cuisineForm" class="form-horizontal" enctype='multipart/form-data'>
                                        @csrf
                                        @method('put')
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 control-label space-for-label">Cuisine Name<span class="error">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="cuisine_name" name="cuisine_name" placeholder="Cuisine Name" value="{{$cuisine->cuisine_name}}">
                                                <span class="error" id="cuisineNameSpan">{{$errors->admin->first('cuisine_name')}}</span>
                                            </div>
                                        </div>

                                        <div class="form-group m-b-0">
                                            <div class="col-sm-9">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
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
    $("#cuisineForm").submit(function(e) {
        var temp = 0;
        if ($("#cuisine_name").val().trim() == "") {
            $("#cuisineNameSpan").html("Please enter Cuisine Name");
            temp++;
        }else if((/[^a-zA-Z0-9 ]/).test($("#cuisine_name").val()))
        {
            $("#cuisineNameSpan").html("Special characters not allowed");
            temp++;
        }else if($("#cuisine_name").val().length > 30)
        {
            $("#cuisineNameSpan").html("Cuisine Name must not be greater than 30 character");
            temp++;
        }
        else {
            $("#cuisineNameSpan").html("");
        }

        if (temp !== 0) {
            return false;
        }
    });

    $('#cuisineMenu').addClass('active');
    $('#catgory_menu_open').css('display','block');
    $('#categoryManagementMenu').addClass('active');
</script>
@endsection
@endsection
