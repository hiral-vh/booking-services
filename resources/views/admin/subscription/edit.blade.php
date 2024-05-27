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
                                        <h4 class="m-t-0 m-b-30">Edit</h4>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{ route('admin-subcription.index') }}"><button type="button" class="btn waves-effect btn-secondary"><i class="ion ion-md-arrow-back"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        <form method="POST" action="{{ route('admin-subcription.update',$subscription->id) }}" id="adminSubscriptionForm"
                                            class="form-horizontal" enctype='multipart/form-data'>
                                            @csrf
                                            @method('put')
                                            <input type="hidden" id="type" name="type" value="{{$type}}">
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 control-label space-for-label">Plan Name<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="plan_name" name="plan_name" value="{{$subscription->plan_name}}"
                                                        placeholder="Plan Name" value="{{ old('plan_name') }}" >
                                                    <span class="error" id="planNameSpan">{{$errors->admin->first('plan_name')}}</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 control-label space-for-label">Description<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" id="description" name="description"
                                                    placeholder="Description" rows="10">{{ old('description') }} {{$subscription->plan_description}}</textarea>
                                                    <span class="error" id="descriptionSpan">{{$errors->admin->first('description')}}</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 control-label space-for-label">Allowed Order<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="allowed_order" name="allowed_order"
                                                        placeholder="Allowed Order" value="{{$subscription->allowed_order}}">
                                                    <span class="error" id="allowedOrderSpan">{{$errors->admin->first('allowed_order')}}</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 control-label space-for-label">Price<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="price" name="price"
                                                        placeholder="Price" value="{{$subscription->plan_price}}">
                                                    <span class="error" id="priceSpan">{{$errors->admin->first('price')}}</span>
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
    <script src="https://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>
     <script>
          $( document ).ready(function() {
            $('#price').on('input', function (event) {
                this.value = this.value.replace(/[^0-9.]/g, '');
            });
            $('#duration').on('input', function (event) {
                this.value = this.value.replace(/[^0-9.]/g, '');
            });
            $('#allowed_order').on('input', function (event) {
                this.value = this.value.replace(/[^0-9.]/g, '');
            });
          });
        $("#adminSubscriptionForm").submit(function(e) {
            var temp = 0;
            var description = $('#description').val();

            if($("#plan_name").val().trim() == "")
            {
                $("#planNameSpan").html("Please enter Plan Name");
                temp++;
            }
            else{
                $("#planNameSpan").html("");
            }

            if(description == "" && description == "" && jQuery.trim(description).length == 0)
            {
                $("#descriptionSpan").html("Please enter Description");
                temp++;
            }
            else{
                $("#descriptionSpan").html("");
            }

            if($("#allowed_order").val().trim() == "")
            {
                $("#allowedOrderSpan").html("Please enter Allowed Order");
                temp++;
            }else{
                $("#allowedOrderSpan").html("");
            }

            if($("#price").val().trim() == "")
            {
                $("#priceSpan").html("Please enter Price");
                temp++;
            }else{
                $("#priceSpan").html("");
            }

            if(temp !== 0 )
            {
                return false;
            }
        });

        CKEDITOR.replace('description', {
            basicEntities: false
        });

        $('#subscriptionMenu').addClass('active');
    </script>
    @endsection
@endsection
