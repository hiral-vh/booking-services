@extends('admin.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Team Members</h4>
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
                                        <a href="{{ route('team-members.index') }}"><button type="button"
                                                class="btn waves-effect btn-secondary"><i
                                                    class="ion ion-md-arrow-back"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        <form method="POST" action="{{ route('team-members.store') }}" id="teamMemberCreateForm"
                                            class="form-horizontal" enctype='multipart/form-data'>
                                            @csrf
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-3 control-label">Name<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        placeholder="Name">
                                                    <span class="error" id="nameSpan">{{$errors->admin->first('name')}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="charge" class="col-sm-3 control-label">Charge<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="charge" name="charge"
                                                        placeholder="Charge" onkeypress="return validateFloatKeyPress(this,event);" onpaste="return false">
                                                    <span class="error" id="chargeSpan">{{$errors->admin->first('charge')}}</span>
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
        $("#teamMemberCreateForm").submit(function(e) {
            var temp = 0;
            var charge=$("#charge").val();
            if ($("#name").val() == "") {
                $("#nameSpan").html("The Name Field Is Required");
                temp++;
            } else {
                $("#nameSpan").html("");
            }
            if ($("#charge").val() == "") {
                $("#chargeSpan").html("The Charge Field Is Required");
                temp++;
            }
            else
            {
                $("#chargeSpan").html("");
            }

            if(temp !== 0 )
            {
                return false;
            }
        });
    </script>
@endsection
