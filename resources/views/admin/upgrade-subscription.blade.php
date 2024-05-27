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
    <link href="{{ asset('assets/plugins/carousel/owl.carousel.css')}}" rel="stylesheet">
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
            padding: 20px 0 35px;
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
            min-height: 160px;
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
            font-size: 18px;
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
            margin: 35px 29px;
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

        .price.price-orange .header-main {
            background: #cf8015;
        }

        .price.price-sky .header-main {
            background: #27a2c4;
        }

        .price.price-grey .header-main {
            background: #607d8b;
        }

        .price.price-green .header-main {
            background: #4caf50;
        }

        .price.price-yellow .header-main {
            background: #ffc107;
        }

        .price.price-purple .header-main {
            background: #3f51b5;
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

        .price-orange .header-main .header .price-round {
            background: #cf8015;
        }

        .price-orange .header-main .header p {
            color: #fff;
        }

        .price-orange li.grey .button1 {
            background: #cf8015;
        }

        .price-orange li.grey::before {
            border-bottom: 73px solid #cf8015;
        }

        .price-sky .header-main .header .price-round {
            background: #27a2c4;
        }

        .price-sky .header-main .header p {
            color: #fff;
        }

        .price-sky li.grey .button1 {
            background: #27a2c4;
        }

        .price-sky li.grey::before {
            border-bottom: 73px solid #27a2c4;
        }

        .price-grey .header-main .header .price-round {
            background: #607d8b;
        }

        .price-grey .header-main .header p {
            color: #fff;
        }

        .price-grey li.grey .button1 {
            background: #607d8b;
        }

        .price-grey li.grey::before {
            border-bottom: 73px solid #607d8b;
        }

        .price-green .header-main .header .price-round {
            background: #4caf50;
        }

        .price-green .header-main .header p {
            color: #fff;
        }

        .price-green li.grey .button1 { 
            background: #4caf50;
        }

        .price-green li.grey::before {
            border-bottom: 73px solid #4caf50;
        }

        .price-yellow .header-main .header .price-round {
            background: #ffc107;
        }

        .price-yellow .header-main .header p {
            color: #fff;
        }

        .price-yellow li.grey .button1 { 
            background: #ffc107;
        }

        .price-yellow li.grey::before {
            border-bottom: 73px solid #ffc107;
        }

        .price-purple .header-main .header .price-round {
            background: #3f51b5;
        }

        .price-purple .header-main .header p {
            color: #fff;
        }

        .price-purple li.grey .button1 { 
            background: #3f51b5;
        }

        .price-purple li.grey::before {
            border-bottom: 73px solid #3f51b5;
        }


        .wrapper-page {
            width: 91.545% !important;
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

        .subscription .owl-dots {
            display: flex;
            justify-content: center;
            padding-top: 20px;
        }

        .subscription .owl-dot {
            display: flex;
            background: #989494 !important;
            width: 11px;
            height: 11px;
            border-radius: 50%;
            margin: 0 7px;
        }

        .subscription .owl-dot.active {
            background: #3e445e !important;
        }
        .subscription .owl-stage-outer{
            /* padding: 0px 18px; */
        }
        .columns.active {
            box-shadow: 0 0 0 6px #ed008d;
            transform: scale(1.1);
        }
      .subscription .owl-stage{
          display: flex;
          align-items:center;
          margin: 0px 0px;
          /* margin: 0px 10px; */
      }
    </style>
</head>

<body>

    <!-- Begin page -->
    <div class="accountbg"></div>
   
    <div class="wrapper-page cus-wrapper">
    
        <div class="m-t-0 back-btn">
        <a href="{{route('subscription-details')}}"><button class="btn btn-primary btn-mb-18">Back</button></a>
            <img  src="{{asset('assets/images/1653482217_487.png')}}" alt="" height="75">
            <div></div>
           
        </div>
        
      
        <div class="card card-pages card-border ">
            
            <div class="card-body">
            <div class="owl-carousel owl-theme subscription mt-3">
                <!-- <h4 class="text-muted text-center m-t-0"><b>Subscription</b></h4> -->
                
                    @if(count($getAllsubscription) > 0)
                    @php $i=0; @endphp
                    @foreach($getAllsubscription as $key)
                    @php
                    $divClass='';
                    $head = '';
                    if($plan_id == $key->id){
                        $divClass='active';
                        $head = 'Your current Ongoing Plan';
                    }


                    $class = 'price';
                    if($i == 0){
                    $class= 'price';
                    }else if($i == 1){
                    $class= 'price price-red';
                    }else if($i == 2){
                    $class= 'price price-blue';
                    }
                    else if($i == 3){
                        $class='price price-orange';
                    }
                    else if($i == 4){
                        $class='price price-sky';
                    } 
                    else if($i == 5){
                        $class='price price-grey';
                    }
                    else if($i == 6){
                        $class='price price-green';
                    }else if($i == 7){
                        $class='price price-yellow';
                    } else if($i == 8){
                        $class='price price-purple';
                    }@endphp
                    <div class="items">
                        <div class="columns {{$divClass}}">
                            <ul class="{{$class}}">
                                <li class="header-main">
                                    <div class="header">
                                        <p class="mb-0">{{$head}}</p>
                                        <p>{{$key->plan_name}}</p>
                                        <div class="price-round">£ {{$key->plan_price}} / Month</div>
                                    </div>
                                </li>
                                <!-- <li>{{$key->plan_duration}} Month</li>
                                <li>{{$key->allowed_order}} Allowed Order</li> -->
                                <!-- <li class="" ><a href="javascript:void(0);" class="getDescription" data-desc="{{ $key->plan_description }}" data-toggle="modal" data-target="#description-modal">View Details</a></li> -->
                                @if($plan_id != $key->id)
                                <li class="grey"><a href="{{url('subscription-purchase')}}?id={{$key->id}}" class="button1">Select</a></li>
                                @endif
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

<div id="description-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="status-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title m-0" id="status-modalLabel">Description</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="submitId">
                    <div class="form-group">
                        <span id="appendDescription" style="word-break: break-all">Description</span>
                    </div>
                </form>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                </div>
            </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
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
    <script src="{{asset('assets/plugins/carousel/owl.carousel.js')}}"></script>

    <script>
        $('.subscription').owlCarousel({
            loop: false,
            // margin: 10,
            nav: false,
            // center: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,

                },
                600: {
                    items: 1,

                },
                1000: {
                    items: 4,
                    loop: false
                }
            }
        })

        $(".getDescription").click(function() {
            $("#appendDescription").html('');
            var msg = $(this).attr('data-desc');
            $("#appendDescription").html(msg);
        });
      
    </script>
</body>

</html>
