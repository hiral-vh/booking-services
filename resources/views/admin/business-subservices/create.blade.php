@extends('admin.layouts.app')
@section('content')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Business SubServices</h4>
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
                                    <a href="{{ route('services.index') }}"><button type="button" class="btn waves-effect btn-secondary"><i class="ion ion-md-arrow-back"></i></button></a>
                                </div>
                                <div class="col-12">
                                    <form method="POST" action="{{ route('sub-services.store') }}" id="adminCreateForm" class="form-horizontal" enctype='multipart/form-data'>
                                        @csrf
                                        <div class="form-group row">
                                            <label for="service" class="col-sm-3 control-label">Business Service<span class="error">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="business_service_id" name="business_service_id">
                                                    <option value="">Select Service</option>
                                                    @foreach ($service as $value)
                                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach

                                                </select>
                                                <span class="error" id="serviceSpan">{{$errors->admin->first('service')}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3 control-label">Name<span class="error">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                                                <span class="error" id="nameSpan">{{$errors->admin->first('name')}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3 control-label">Time<span class="error">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="time" name="time" placeholder="Time">
                                                <span class="error" id="timeSpan">{{$errors->admin->first('time')}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3 control-label">Price<span class="error">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="price" name="price" placeholder="Price">
                                                <span class="error" id="priceSpan">{{$errors->admin->first('price')}}</span>
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
<script>
    $("#adminCreateForm").submit(function(e) {
        var temp = 0;

        if ($("#business_service_id").val() == "") {
            $("#serviceSpan").html("The Service Field Is Required");
            temp++;
        } else {
            $("#serviceSpan").html("");
        }

        if ($("#name").val() == "") {
            $("#nameSpan").html("The Name Field Is Required");
            temp++;
        } else {
            $("#nameSpan").html("");
        }

        if ($("#time").val() == "") {
            $("#timeSpan").html("The Time Field Is Required");
            temp++;
        } else {
            $("#timeSpan").html("");
        }

        if ($("#price").val() == "") {
            $("#priceSpan").html("The Price Field Is Required");
            temp++;
        } else {
            $("#priceSpan").html("");
        }


        if (temp !== 0) {
            return false;
        }
    });
</script>
@endsection