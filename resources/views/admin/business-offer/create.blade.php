@extends('admin.layouts.app')
@section('css')
<link href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">{{ ucfirst($business->name) }} Offer </h4>
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
                                        <a href="{{ route('business-offer-index',$business->id) }}"><button type="button"
                                                class="btn waves-effect btn-secondary"><i
                                                    class="ion ion-md-arrow-back" title="back"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        <form method="POST" action="{{route('business-offer-store')}}" id="businessOfferCreateForm"
                                            class="form-horizontal" enctype='multipart/form-data'>
                                            @csrf
                                            <input type="hidden" id="business_id" name="business_id" value="{{$business->id}}">

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
                                                <label for="image" class="col-sm-3 control-label">Image<span
                                                    class="error">*</span></label>
                                                <div class="col-sm-5">
                                                    <input type="file" class="form-control" id="image"
                                                        name="image"
                                                        oninput="pic.src=window.URL.createObjectURL(this.files[0])" accept="image/png, image/jpg, image/jpeg, image/svg">
                                                    <span class="error" id="imageSpan">{{$errors->admin->first('image')}}</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <img src="{{ asset('assets/images/no-image.jpg') }}"
                                                        alt="Image" class="logo-lg"
                                                        style="height:100px;width:100px" id="pic">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="price" class="col-sm-3 control-label">Price<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="price" name="price"
                                                        placeholder="Price">
                                                    <span class="error" id="priceSpan">{{$errors->admin->first('price')}}</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="coupon_code" class="col-sm-3 control-label">Coupon Code<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="coupon_code" name="coupon_code"
                                                        placeholder="Coupon Code">
                                                    <span class="error" id="couponCodeSpan">{{$errors->admin->first('coupon_code')}}</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="name" class="col-sm-3 control-label">Valid Till<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="valid_till" name="valid_till" placeholder="Valid Till" value="">
                                                        <span class="error" id="validTillSpan"> {{$errors->add->first('valid_till')}}</span>
                                                </div>
                                            </div>

                                            <div class="form-group m-b-0">
                                                <div class="col-sm-9">
                                                    <button type="submit" id="submit"
                                                        class="btn btn-primary waves-effect waves-light">
                                                        Submit
                                                    </button>
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

    @section('page-js')
    <script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    @endsection
    </div>
    <script>
        var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
    </script>
    <script>
        var temp = 0;
        $( document ).ready(function() {

            $('#price').on('input', function (event) {
                this.value = this.value.replace(/[^0-9.]/g, '');
            });

            $('#valid_till').datepicker({
                dateFormat: "dd-M-yy",
                minDate: 0
            });
        });

        $('#coupon_code').on('input', function (event) {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{route('coupon-code')}}',
                data:{coupon_code:$("#coupon_code").val()},
                success: function(data) {

                        if(data.message == 'exist')
                        {
                            $("#couponCodeSpan").html("This Coupon Code Already Exist");
                            temp++;
                        }
                        else
                        {
                            $("#couponCodeSpan").html("");
                            temp=0;
                        }

                },
            });
        });

        $("#businessOfferCreateForm").submit(function(e) {

            if($("#name").val() == "")
            {
                $("#nameSpan").html("Please enter Name");
                temp++;
            }
            else
            {
                $("#nameSpan").html("");
            }

            if($("#coupon_code").val() == "")
            {
                $("#couponCodeSpan").html("Please enter Coupon Code");
                temp++;
            }

            if($("#image").val() == "")
            {
                $("#imageSpan").html("Please select Image");
                temp++;
            }
            else
            {
                var imageRegex = new RegExp("(.*?)\.(jpg|png|jpeg|JPG|PNG|JPEG|svg|SVG)$");
                if (!(imageRegex.test($("#image").val())))
                {
                    $('#imageSpan').html('Invalid Image Format');
                    temp++;
                }
                else
                {
                    $('#imageSpan').html('');
                }
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

            if ($("#valid_till").val() == "") {
                $("#validTillSpan").html("Please select Valid Till");
                temp++;
            } else {
                $("#validTillSpan").html("");
            }

            if(temp !== 0 )
            {
                return false;
            }
            else
            {
                $("#submit").prop("disabled", true);
                $("#submit").text("Please Wait...");
            }

        });
    </script>
@endsection
