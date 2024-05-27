@extends('business.layouts.app')
@section('css')
{{-- <style>
    #discountDiv
    {
        display:none;
    }
    #priceDiv
    {
        display:flex;
    }
    </style> --}}
@endsection
@section('content')
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Offers </h4>
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
                                        <a href="{{ route('business-user-offers.index') }}"><button type="button"
                                                class="btn waves-effect btn-secondary"><i
                                                    class="ion ion-md-arrow-back" title="back"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        <form method="POST" action="{{route('business-user-offers.update',$businessOffer->id)}}" id="businessOfferEditForm"
                                            class="form-horizontal" enctype='multipart/form-data'>
                                            @csrf
                                            @method('put')
                                            <input type="hidden" id="business_id" name="business_id" value="{{$business->id}}">
                                            <input type="hidden" id="id" name="id" value="{{$businessOffer->id}}">
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-3 control-label">Name<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        placeholder="Name" value="{{$businessOffer->name}}" maxlength="30">
                                                    <span class="error" id="nameSpan">{{$errors->admin->first('name')}}</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="image" class="col-sm-3 control-label">Image<span
                                                    class="error">*</span></label>
                                                <div class="col-sm-5">
                                                    <input type="file" class="form-control" id="image"
                                                        name="image"
                                                        oninput="pic.src=window.URL.createObjectURL(this.files[0])" accept="image/png, image/jpg, image/jpeg, image/svg" value="{{$businessOffer->image}}">
                                                    <span class="error" id="imageSpan">{{$errors->admin->first('image')}}</span>
                                                </div>

                                                <div class="col-sm-4">
                                                    <img src="{{ asset($businessOffer->image) }}"
                                                        alt="Image" class="logo-lg"
                                                        style="height:100px;width:100px" id="pic">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="type" class="col-sm-3 control-label">Type<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <select  class="form-control" id="type" name="type">
                                                        <option value="0" @if($businessOffer->type==0) selected @endif>Amount(£)</option>
                                                        <option value="1" @if($businessOffer->type==1) selected @endif>Percentage(%)</option>
                                                    </select>
                                                    <span class="error" id="typeSpan">{{$errors->admin->first('type')}}</span>
                                                </div>
                                            </div>

                                            <div class="form-group row" id="priceDiv">
                                                <label for="price" class="col-sm-3 control-label">Price(£)<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="price" name="price"
                                                        placeholder="Price" value="{{($businessOffer->price != 0)?$businessOffer->price:'0'}}">
                                                    <span class="error" id="priceSpan">{{$errors->admin->first('price')}}</span>
                                                </div>
                                            </div>

                                            <div class="form-group row" id="discountDiv">
                                                <label for="discount" class="col-sm-3 control-label">Discount<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="discount" name="discount"
                                                        placeholder="Discount" value="{{($businessOffer->discount != 0)?$businessOffer->discount:'0'}}">
                                                    <span class="error" id="discountSpan">{{$errors->admin->first('discount')}}</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="coupon_code" class="col-sm-3 control-label">Coupon Code<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="coupon_code" name="coupon_code"
                                                        placeholder="Coupon Code" value="{{$businessOffer->coupon_code}}" maxlength="50">
                                                    <span class="error" id="couponCodeSpan">{{$errors->admin->first('coupon_code')}}</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="name" class="col-sm-3 control-label">Valid Till<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input placeholder="Valid Till" class="textbox-n form-control" type="date" id="valid_till" name="valid_till"  value="{{date('Y-m-d',strtotime($businessOffer->valid_till))}}" onkeydown="return false">
                                                        <span class="error" id="validTillSpan"> {{$errors->add->first('valid_till')}}</span>
                                                </div>
                                            </div>

                                            <div class="form-group m-b-0">
                                                <div class="col-sm-9">
                                                    <button type="submit" id="submit"
                                                        class="btn btn-primary waves-effect waves-light">
                                                        Update
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
    <script>
        var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
    </script>
    @section('page-js')
    <script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $('#businessDetailMainMenu').addClass('active');
        $('#OffersMenu').addClass('active subdrop');
        $('#businessDetailMenu').css('display','block');

        var temp = 0;
        var given_date="{{$businessOffer->valid_till}}";
        var convertedDate= new Date(given_date);
        var getMonth=convertedDate.getMonth()+1;

        // $(function(){
        //     var convertedDate= new Date(given_date);
        //     var month = convertedDate.getMonth() + 1;
        //     var day = convertedDate.getDate();
        //     var year = convertedDate.getFullYear();
        //     if(month < 10)
        //         month = '0' + month.toString();
        //     if(day < 10)
        //         day = '0' + day.toString();

        //     var finalDate = day + '-' + month + '-' + year;
        //     // $("#valid_till").val(finalDate);
        // });

        $(function(){
            var dtToday = new Date();
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();

            var maxDate = year + '-' + month + '-' + day;

            $('#valid_till').attr('min', maxDate);
        });

        $( document ).ready(function() {
            $("#discount").attr('maxlength','2');
            $("#price").attr('maxlength','6');

            if($("#price").val() == 0)
            {
                $("#priceDiv").css('display','none');
            }

            if($("#discount").val() == 0)
            {
                $("#discountDiv").css('display','none');
            }

            $( "#type" ).change(function() {
            var value=$(this).val();
            if(value == 1)
            {

                $("#priceDiv").hide();
                $("#discountDiv").css('display','flex');
                if($("#price").val() < 1)
                {
                    $("#price").val(0);
                }
            }
            if(value == 0)
            {
                $("#discountDiv").hide();
                $("#priceDiv").show();
                if($("#discount").val() < 1)
                {
                    $("#discount").val(0);
                }
            }
        });
            $('#price').on('input', function (event) {
                this.value = this.value.replace(/[^0-9.]/g, '');
            });

            $('#discount').on('input', function (event) {
                this.value = this.value.replace(/[^0-9.]/g, '');
            });

        });

        $("#businessOfferEditForm").submit(function(e) {

            if($("#name").val() == "")
            {
                $("#nameSpan").html("Please enter Name");
                temp++;
            }else if((/[^a-zA-Z0-9_ ]/).test($("#name").val()))
            {
                $("#nameSpan").html("Special characters not allowed");
                temp++;
            }else if($("#name").val().length > 30)
            {
                $("#nameSpan").html("Name must not be greater than 30 character");
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
            }else if($("#coupon_code").val() != ''){
                $.ajax({
                type: "GET",
                dataType: "json",
                async: false,
                url: '{{route('business-user-coupon-code')}}',
                data:{
                    coupon_code:$("#coupon_code").val(),
                    id:$("#id").val(),
                },
                success: function(data) {
                        if(data == 1)
                        {
                            $("#couponCodeSpan").html("This Coupon Code is already exist");
                            temp++;
                        }else{
                            $("#couponCodeSpan").html("");
                            temp=0;
                        }
                    },
                });
            }

            if($("#image").val() !== "")
            {
                var imageRegex = new RegExp("(.*?)\.(jpg|png|jpeg|JPG|PNG|JPEG|svg|SVG)$");
                if (!(imageRegex.test($("#image").val())))
                {
                    $('#imageSpan').html('File must Image!! Like: JPG, JPEG, PNG and SVG');
                    temp++;
                }
                else
                {
                    $('#imageSpan').html('');
                }
            }

            if( $("#priceDiv").css('display') == 'flex' && $("#price").val() == "")
            {
                $("#priceSpan").html("Please enter Price");
                temp++;
            }
            else
            {
                $("#priceSpan").html("");
            }

            if( $("#discountDiv").css('display') == 'flex' && $("#discount").val() == "")
            {
                $("#discountSpan").html("Please enter Discount");
                temp++;
            }else if($("#discountDiv").css('display') == 'flex' && ($("#discount").val()>=100))
            {
                $("#discountSpan").html("Please enter valid Discount(1 To 99)");
                temp++;
            }
            else
            {
                $("#discountSpan").html("");
            }

            if ($("#valid_till").val() == "") {
                $("#validTillSpan").html("Please enter Valid Till");
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
@endsection
