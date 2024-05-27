<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Subscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="{{asset('favicon.png')}}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/plugins/toastr/toastr.min.css')}}">
    <style>
        /* Style the list */
        .price {
            list-style-type: none;
            /* border: 1px solid #eee; */
            margin: 0;
            padding: 0;
            -webkit-transition: 0.3s;
            transition: 0.3s;
            background: #fff;
            min-height: 519px;
        }

        /* Add shadows on hover */
        .price:hover {
            box-shadow: 0 8px 12px 0 rgba(0, 0, 0, 0.2)
        }

        /* Pricing header */
        .price .headermain {
            background-color: #111;
            color: white;
            font-size: 25px;
        }

        /* List items */
        .price li {

            padding: 10px;
            text-align: center;
            font-size: 15px;
        }

        /* Grey list item */
        .price .grey {
            font-size: 20px;
            padding: 40px 0 65px;
        }

        /* The "Sign Up" button */
        .button1 {
            background-color: #27c4b5;
            border: none;
            color: #fff !important;
            padding: 5px 25px;
            text-align: center;
            text-decoration: none;
            font-size: 17px;
        }

        .price .header-main {
            padding-top: 30px;
            padding-bottom: 60px;
            background: #27c4b5;
            position: relative;
        }

        .price li:nth-child(2) {
            padding-top: 60px;
        }

        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header-main p {
            font-size: 22px;
            font-weight: 900;
            color: #fff
        }

        .mh-88px {
            min-height: 88px;
        }

        /* .header-main:after {
            content: '';
            border-left: 39px solid transparent;
            border-right: 70px solid transparent;
            border-bottom: 73px solid #71778f;
            display: flex;
            position: absolute;
            top: 0;
            right: -39px;
            transform: rotate(180deg);
        } */

        .columns {
            position: relative;
            overflow: hidden;
            border-radius: 25px;
        }

        .price-round {
            font-size: 17px;
            background: #27c4b5;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-weight: 800;
            padding: 21px;
            bottom: -52px;
            width: 120px;
            height: 120px;
            position: absolute;
            border: 6px solid #fff;
        }

        /* .grey::before {
            content: '';
            border-left: 39px solid transparent;
            border-right: 70px solid transparent;
            border-bottom: 73px solid #71778f;
            display: flex;
            position: absolute;
            bottom: 0px;
            left: -39px;
            transform: rotate(1deg);
        } */

        /* .price-red .header-main:after {
            content: '';
            border-left: 39px solid transparent;
            border-right: 70px solid transparent;
            border-bottom: 73px solid #c12c4eab;
        } */

        .price-red .header-main .header .price-round {
            background: #d57288;
        }

        .price.price-red .header-main {
            background: #d57288;
        }

        .price.price-blue .header-main {
            background: #1579cf;
        }

        .price-red .header-main .header p {
            color: #fff;
        }

        .price-red li.grey .button1 {
            background: #d57288;
        }

        .price-red li.grey::before {
            border-bottom: 73px solid #d57288;
        }

        /* .price-blue .header-main:after {
            content: '';
            border-left: 39px solid transparent;
            border-right: 70px solid transparent;
            border-bottom: 73px solid #1579cf;
        } */

        .price-blue .header-main .header .price-round {
            background: #1579cf;
        }

        .price-blue .header-main .header p {
            color: #fff;
        }

        .price-blue li.grey .button1 {
            background: #1579cf;
        }

        .price-blue li.grey::before {
            border-bottom: 73px solid #1579cf;
        }

        .wrapper-page {
            width: 80% !important;
        }

        .cus-wrapper {
            margin: 0.5% auto !important;
        }

        .card-border {
            background: transparent;
            border: none !important;
        }

        .card {
            box-shadow: none !important;
        }

        .card-body {
            padding: 0px;
        }
        .child-col:active {
            transform: scale(1.1);
        }
        .child-col{
            padding: 20px;
        }
        .main-class{
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page cus-wrapper">
        <div class="text-center m-t-0 ">
            <img  src="{{asset('assets/images/logo.png')}}" alt="" height="75">
        </div>
        <div class="card card-pages card-border ">

            <div class="card-body">

                <!-- <h4 class="text-muted text-center m-t-0"><b>Subscription</b></h4> -->
                <div class="row main-class">
                    @if(count($getAllsubscription) > 0)
                    @php $i=0; @endphp
                    @foreach($getAllsubscription as $key)
                    @php
                    $class = 'price';
                    if($i == 0){
                    $class= 'price';
                    }else if($i == 1){
                    $class= 'price price-red';
                    }else if($i == 2){
                    $class= 'price price-blue';
                    } @endphp
                    <div class="col-sm-4 child-col active">
                        <div class="columns">
                            <ul class="{{$class}}">
                                <li class="header-main">
                                    <div class="header">
                                        <p>{{$key->plan_name}}</p>
                                        <div class="price-round">$ {{$key->plan_price}} / Month</div>
                                    </div>
                                </li>
                                <li>{{$key->plan_duration}} Month</li>
                                <li>{{$key->allowed_order}} Allowed Order</li>
                                <li>{{substr($key->plan_description, 0, 100)}}..</li>
                                <li class="grey"><a href="{{url('subscription-purchase')}}?id={{$key->id}}" class="button1">Select</a></li>
                            </ul>
                        </div>
                    </div>
                    @php $i++; @endphp
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
    </script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/js/detect.js') }}"></script>
    <script src="{{ asset('assets/js/fastclick.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('assets/js/waves.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Toastr -->
    <script src="{{asset('assets/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{ asset('assets/js/custom_toast.js') }}"></script>
</body>

</html>
