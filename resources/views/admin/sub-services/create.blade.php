@extends('admin.layouts.app')
@section('content')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Business Sub Services</h4>
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
                                    <a href="{{ route('sub-services.index') }}"><button type="button" class="btn waves-effect btn-secondary"><i class="ion ion-md-arrow-back"></i></button></a>
                                </div>
                                <div class="col-12">
                                    <form method="POST" action="{{ route('sub-services.store') }}" id="adminCreateForm" class="form-horizontal" enctype='multipart/form-data'>
                                        @csrf
                                        <div class="form-group row">
                                            <label for="service" class="col-sm-2 control-label space-for-label">Business Service<span class="error">*</span></label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="service_id" name="service_id">
                                                    <option value="">Select Service</option>
                                                    @foreach ($service as $value)
                                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach

                                                </select>
                                                <span class="error" id="serviceSpan">{{$errors->admin->first('service_id')}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 control-label space-for-label">Sub Service<span class="error">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Sub Service">
                                                <span class="error" id="nameSpan">{{$errors->admin->first('name')}}</span>
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
@section('page-js')
<script>
    $("#adminCreateForm").submit(function(e) {
        var temp = 0;

        if ($("#service_id").val() == "") {
            $("#serviceSpan").html("Please select Service");
            temp++;
        } else {
            $("#serviceSpan").html("");
        }

        if ($("#name").val() == "") {
            $("#nameSpan").html("Please enter Sub Service");
            temp++;
        }else if((/[^a-zA-Z0-9 ]/).test($("#name").val()))
        {
            $("#nameSpan").html("Special characters not allowed");
            temp++;
        }else if($("#name").val().length > 30 )
        {
            $("#nameSpan").html("Sub Service must not be greater than 30 character");
            temp++;
        }
        else {
            $("#nameSpan").html("");
        }

        if (temp !== 0) {
            return false;
        }
    });

    $('#businessSubServiceMenu').addClass('active');
    $('#catgory_menu_open').css('display','block');
    $('#categoryManagementMenu').addClass('active');
</script>
@endsection
@endsection
