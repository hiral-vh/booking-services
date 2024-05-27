@extends('admin.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">CMS</h4>
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
                                        <a href="{{ route('cms.index') }}"><button type="button"
                                                class="btn waves-effect btn-secondary"><i
                                                    class="ion ion-md-arrow-back"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        <form method="POST" action="{{ route('cms.update',$cms->id) }}" id="cmsEditForm"
                                            class="form-horizontal" enctype='multipart/form-data'>
                                            @csrf
                                            @method('put')
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 control-label space-for-label">Title<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-10">
                                                    <label for="name" class="col-sm-2 control-label space-for-label">{{$cms->title}}</label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="description" class="col-sm-2 control-label space-for-label">Description<span
                                                    class="error">*</span></label>
                                                    <div class="col-sm-10">
                                                    <textarea class="form-control" id="description" name="description" rows="15" placeholder="Description">{{ $cms->description }}</textarea>
                                                    <span class="error" id="descriptionSpan">{{$errors->admin->first('description')}}</span>
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
        $("#cmsEditForm").submit(function(e) {
            var temp = 0;

            if($("#description").val() == "")
            {
                $("#descriptionSpan").html("Please enter Description");
                temp++;
            }else if($("#description").val().length > 500)
            {
                $("#descriptionSpan").html("Description must not be greater than 500 character");
                temp++;
            }
            else
            {
                $('#descriptionSpan').html('');
            }

            if(temp !== 0 )
            {
                return false;
            }
        });

        $('#cmsMenu').addClass('active');
    </script>
@endsection
@endsection
