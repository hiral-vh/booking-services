@extends('admin.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Business</h4>
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
                                        <a href="{{ route('business-admin.index') }}"><button type="button"
                                                class="btn waves-effect btn-secondary"><i
                                                    class="ion ion-md-arrow-back" title="back"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        <form method="POST" action="{{ route('business-admin.update',$business->id) }}" id="businessEditForm"
                                            class="form-horizontal" enctype='multipart/form-data'>
                                            @csrf
                                            @method('put')
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-3 control-label">Name<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        placeholder="Name" value="{{$business->name}}">
                                                    <span class="error" id="nameSpan">{{$errors->admin->first('name')}}</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="image" class="col-sm-3 control-label">Service<span
                                                    class="error">*</span></label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control"  id="service" name="service">
                                                            <option value="">Select Service</option>
                                                            @forelse ($services as $service)
                                                                <option value="{{$service->id}}" @if($service->id==$business->service_id) selected @endif>{{$service->name}}</option>
                                                            @empty
                                                                <option value="">No Service Available</option>
                                                            @endforelse
                                                        </select>
                                                        <span class="error" id="serviceSpan">{{$errors->admin->first('service')}}</span>
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
    <script>
        $("#businessEditForm").submit(function(e) {
            var temp = 0;
            if ($("#name").val() == "") {
                $("#nameSpan").html("The Name Field Is Required");
                temp++;
            } else {
                $("#nameSpan").html("");
            }

            if($("#service").val() == "")
            {
                $("#serviceSpan").html("The Service Field Is Required");
                temp++;
            }
            else
            {
                $("#serviceSpan").html("");
            }

            if(temp !== 0 )
            {
                return false;
            }
        });
    </script>
@endsection
