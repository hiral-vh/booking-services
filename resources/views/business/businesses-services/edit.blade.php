@extends('business.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">{{ucfirst($businessService['business']->name)}} Services</h4>
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
                                        <a href="{{ route('business-user-business-services.index') }}"><button type="button"
                                                class="btn waves-effect btn-secondary"><i
                                                    class="ion ion-md-arrow-back" title="back"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        <form method="POST" action="{{route('business-user-business-services.update',$businessService->id)}}" id="businessServiceEditForm"
                                            class="form-horizontal" enctype='multipart/form-data'>
                                            @csrf
                                            @method('put')
                                            <input type="hidden" id="business_id" name="business_id" value="{{$businessService->business['id']}}">
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-3 control-label">Name<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        placeholder="Name" value="{{$businessService->name}}">
                                                    <span class="error" id="nameSpan">{{$errors->admin->first('name')}}</span>
                                                </div>
                                            </div>

                                            <div class="form-group m-b-0">
                                                <div class="col-sm-9">
                                                    <button type="submit"
                                                        class="btn btn-primary waves-effect waves-light">Submit</button>
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
        $("#businessServiceEditForm").submit(function(e) {
            var temp = 0;
            if ($("#name").val() == "") {
                $("#nameSpan").html("Please enter Name");
                temp++;
            } else {
                $("#nameSpan").html("");
            }

            if($("#timing").val() == "")
            {
                $("#timingSpan").html("Please enter Timing");
                temp++;
            }
            else
            {
                $("#timingSpan").html("");
            }

            if($("#price").val() == "")
            {
                $("#priceSpan").html("Please enter Price");
                temp++;
            }
            else
            {
                $("#priceSpan").html("");
            }

            if(temp !== 0 )
            {
                return false;
            }
        });
    </script>
@endsection
