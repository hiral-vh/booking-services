@extends('layouts.app')

@section('content')
@section('style')
<style>
ul#parsley-id-multiple-radio li {
    position: absolute;
    top: 21px;
    left: 13px;
    white-space: nowrap;
}

.custom-radio.parsley-error {
    position: relative;
}
</style>
@endsection
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('login') }}">{{ env('APP_NAME') }}</a></li>
                                <li class="breadcrumb-item active">Site Setting</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Site Setting</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card-box">

                        <h4 class="header-title mb-4">Edit</h4>
                        <div class="row">
                            <div class="col-xl-12">
                                <form action="{{ route('insert-site-setting') }}" method="POST" id="siteSettingForm"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="id" name="id"
                                        value="{{ !empty($edit_data->id) ? $edit_data->id : '' }}">
                                    <div class="form-group">
                                        <label>Payment Gateway</label>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="custom-radio">
                                                    <input type="radio" name="radio" id="stripe_radio"
                                                        @if (!empty($edit_data->payment_getway)) {{ $edit_data->payment_getway == 'Stripe' ? 'checked' : '' }} @endif
                                                        value="Stripe" required data-parsley-trigger="keyup"
                                                        data-parsley-required-message="Please select Payment Gatway.">
                                                    <label for="radio1">Stripe</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="custom-radio">
                                                    <input type="radio" name="radio" id="paypal_radio"
                                                    @if(!empty($edit_data->payment_getway))

                                                    {{($edit_data->payment_getway=='Paypal')?'checked':''}}

                                                    @endif
                                                    value="Paypal"
                                                    required data-parsley-trigger="keyup"
                                                    data-parsley-required-message="Please select Payment Gatway."
                                                    >
                                                    <label for="radio1">Paypal</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="custom-radio">
                                                    <input type="radio" name="radio" id="razorpay_radio"
                                                    @if(!empty($edit_data->payment_getway))
                                                    {{($edit_data->payment_getway=='Razorpay')?'checked':''}}
                                                    @endif
                                                    value="Razorpay"
                                                    required data-parsley-trigger="keyup"
                                                    data-parsley-required-message="Please select Payment Gatway."
                                                    >
                                                    <label for="radio1">Razorpay</label>
                                                </div>
                                            </div>
                                            <span class="error" id="radioErrorSpan">{{ $errors->sitesetting->first('radio') }}</span>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">SMS Mobile</label>
                                        <input type="text" class="form-control" id="sms_mobile" name="sms_mobile"
                                            required data-parsley-trigger="keyup"
                                            data-parsley-required-message="Please enter SMS Mobile."
                                            value="{{ !empty($edit_data->sms_mobile) ? $edit_data->sms_mobile : '' }}">
                                        <span class="error"
                                            id="smsMobileErrorSpan">{{ $errors->sitesetting->first('sms_mobile') }}</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">SMS API</label>
                                        <input type="text" class="form-control" id="sms_api" name="sms_api" required
                                            data-parsley-trigger="keyup"
                                            data-parsley-required-message="Please enter SMS API."
                                            value="{{ !empty($edit_data->sms_api) ? $edit_data->sms_api : '' }}">
                                        <span class="error"
                                            id="smsApiErrorSpan">{{ $errors->sitesetting->first('sms_api') }}</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">SMS Secret</label>
                                        <input type="text" class="form-control" id="sms_screte" name="sms_screte"
                                            required data-parsley-trigger="keyup"
                                            data-parsley-required-message="Please enter SMS Secret."
                                            value="{{ !empty($edit_data->sms_screte) ? $edit_data->sms_screte : '' }}">
                                        <span class="error"
                                            id="smsScreteErrorSpan">{{ $errors->sitesetting->first('sms_screte') }}</span>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                            <!-- end col -->

                        </div>
                        <!-- end row -->
                    </div>
                </div>
                <!-- end col -->
            </div>
        </div>
    </div>
@section('script')
    <script>
        $(document).ready(function() {
            $('#siteSettingForm').parsley();
        });
    </script>
@endsection
@endsection
