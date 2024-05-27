@extends('admin.layouts.app')
@section('content')
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Order Report</h4>
            </div>
        </div>

        <div class="page-content-wrapper ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4>User Detail</h4>
                                <hr />
                                <div class="row">
                                    <div class="col-md-4">
                                        <dl class="dl-horizontal mb-0">
                                            <dt><strong>User Name</strong> :</dt>
                                            <dd>{{(isset($order->user->first_name))?$order->user->first_name:'N/A'}}
                                                 {{(isset($order->user->last_name))?' '.$order->user->last_name:'N/A' }}</dd>
                                            <dt><strong>Delivery Address</strong> :</dt>
                                            <dd>{{ (isset($order->user->address->address_line))?$order->user->address->address_line:'N/A' }}</dd>
                                            <dd>{{ (isset($order->user->address->address_street))?$order->user->address->address_street:'N/A' }}</dd>
                                            <dd>{{ (isset($order->user->address->address_city))?$order->user->address->address_city:'N/A'}}
                                                {{(isset($order->user->address->address_postcode))?'-'.$order->user->address->address_postcode:'N/A' }}
                                            </dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-4">
                                        <dl class="dl-horizontal mb-0">
                                            <dt><strong>User Email</strong> :</dt>
                                            <dd>{{ (isset($order->user->email))?$order->user->email:'N/A' }}</dd>
                                            <dt><strong>Delivery Contact Person</strong> :</dt>
                                            <dd>{{ (isset($order->deliveryPerson->delivery_person_name))?$order->deliveryPerson->delivery_person_name:'N/A' }}</dd>
                                            <dt><strong>Delivery Contact Number</strong> :</dt>
                                            <dd>+{{(isset($order->deliveryPerson->delivery_person_country_code))?$order->deliveryPerson->delivery_person_country_code:'N/A'}}
                                                 {{(isset($order->deliveryPerson->delivery_person_mobile))?' '.$order->deliveryPerson->delivery_person_mobile:'N/A' }}
                                            </dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-4">
                                        <dl class="dl-horizontal mb-0">
                                            <dt><strong>User Mobile</strong> :</dt>
                                            <dd>+{{ (isset($order->user->country_code))?$order->user->country_code:'N/A'}}
                                            {{(isset($order->user->mobile_no))?' '.$order->user->mobile_no:'N/A' }}</dd>
                                        </dl>
                                    </div>
                                </div>
                                <h4>Order Detail</h4>
                                <hr />
                                <div class="row">
                                    <div class="col-md-4">
                                        <dl class="dl-horizontal mb-0">
                                            <dt><strong>Order Number</strong> :</dt>
                                            <dd>#{{ (isset($order->order_number))?$order->order_number:'N/A' }}</dd>
                                            <dt><strong>Delivery Charge</strong> :</dt>
                                            <dd>{{ (isset($order->delivery_charge))?$order->delivery_charge:'N/A' }}</dd>
                                            <dt><strong>Order Status</strong> :</dt>
                                            <dd><span class="badge badge-primary">{{ (isset($order->order_status))?$order->order_status:'N/A' }}</span>
                                            </dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-4">
                                        <dl class="dl-horizontal mb-0">
                                            <dt><strong>Order Type</strong>:</dt>
                                            @if ($order->order_type == 1)
                                                <dd>Collection</dd>
                                            @elseif ($order->order_type == 2)
                                                <dd>Dine-in</dd>
                                            @elseif ($order->order_type == 3)
                                                <dd>Delivery</dd>
                                            @else
                                                <dd>N/A</dd>
                                            @endif
                                            <dt><strong>Sub Total</strong> :</dt>
                                            <dd>{{ (isset($order->sub_total))?$order->sub_total:'N/A' }}</dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-4">
                                        <dl class="dl-horizontal mb-0">
                                            <dt><strong>Order Date Time</strong> :</dt>
                                            <dd>{{ (isset($order->order_date_time))?$order->order_date_time:'N/A' }}</dd>
                                            <dt><strong>Total Amount</strong> :</dt>
                                            <dd>{{ (isset($order->total_amount))?$order->total_amount:'N/A' }}</dd>
                                        </dl>
                                    </div>
                                </div>

                                <hr />
                                <h4>User Book Table Detail</h4>
                                <hr />
                                <div class="row">
                                    <div class="col-md-4">
                                        <dl class="dl-horizontal mb-0">
                                            <dt><strong>Booking Ref. Id</strong> :</dt>
                                            <dd>{{ (isset($order->userBookTable->booking_ref_id))?$order->userBookTable->booking_ref_id:'N/A' }}</dd>
                                            <dt><strong>Booking Note</strong> :</dt>
                                            <dd>{{ (isset($order->userBookTable->booking_notes))?$order->userBookTable->booking_notes:'N/A' }}</dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-4">
                                        <dl class="dl-horizontal mb-0">
                                            <dt><strong>Booking Date</strong> :</dt>
                                            <dd>{{ (isset($order->userBookTable->book_date))?date('d/m/Y', strtotime($order->userBookTable->book_date)):'N/A' }}</dd>
                                            <dt><strong>Booking From - To Time</strong> :</dt>
                                            <dd>{{ (isset($order->userBookTable->booktime->time_from))?$order->userBookTable->booktime->time_from:'N/A'}}
                                                 {{(isset($order->userBookTable->booktime->time_to))?' To '.$order->userBookTable->booktime->time_to:'N/A' }}
                                            </dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-4">
                                        <dl class="dl-horizontal mb-0">
                                            <dt><strong>Number of People</strong> :</dt>
                                            <dd>{{ (isset($order->userBookTable->number_of_people))?$order->userBookTable->number_of_people:'N/A' }}</dd>
                                            <dt><strong>Table Name</strong> :</dt>
                                            <dd>{{ (isset($order->userBookTable->tableName->table_name))?$order->userBookTable->tableName->table_name:'N/A' }}</dd>
                                        </dl>
                                    </div>
                                </div>

                                <h4>Menu Detail</h4>
                                <hr />
                                <div class="row">
                                    <table class="menuTble" style="border-collapse: collapse;" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->orderItems as $value)
                                                <tr>
                                                    <td style="width:15%">
                                                        @if (!empty($value->menudata->image))
                                                            <img src="{{ asset($value->menudata->image) }}" height="60px"
                                                                width="60px"
                                                                onerror="this.onerror=null;this.src='{{ asset('assets/images/No-image.jpg') }}';" />
                                                        @else
                                                            <img src="{{ asset('assets/images/NoImage.png') }}"
                                                                height="60px" width="60px" />
                                                        @endif
                                                    </td>
                                                    <td>{{(isset($value->menudata->name))?$value->menudata->name:'N/A' }}</td>
                                                    <td>{{ (isset($value->menudata->description))?$value->menudata->description:'N/A' }}</td>
                                                    <td>{{ (isset($value->item_qty))?$value->item_qty:'N/A' }}</td>
                                                    <td>{{ (isset($value->item_price))?$value->item_price:'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="4" style="text-align: right"><b>Total</b></td>
                                                <td>{{ (isset($order->total_amount))?$order->total_amount:'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End Row -->

            <!-- sample modal content -->
            <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content cur-content">
                        <div class="modal-header cur-header">
                            <h4 class="modal-title m-0" id="custom-width-modalLabel">Track Order</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body cur-body">

                            <div class="cur-order-main">
                                <div class="cur-order-inner">
                                    <div class="cur-between">
                                        <p class="arrival-tit">Estimated Arrival</p>
                                        <p class="arrival-tit">Order Number</p>
                                    </div>
                                    <div class="cur-between">
                                        <p class="curtime">07:43 AM - 08:13 AM</p>
                                        <p class="curid">#202202240743456820</p>
                                    </div>
                                </div>
                                <div class="stepdesign-main">
                                    <div class="">
                                        <ul class="step-ul">

                                            <li id="orderconfrimData" style="display:block">
                                                <div class="step-ul-inner">
                                                    <div class="line"></div>
                                                    <img src="https://php8.appworkdemo.com/e_food/public/OrderConfirmed.png"
                                                        alt="">
                                                    <p class="step-text">Order Confirmed</p>
                                                </div>
                                            </li>
                                            <li id="preparingorderData" style="display:none">
                                                <div class="step-ul-inner">
                                                    <div class="line"></div>
                                                    <img src="https://php8.appworkdemo.com/e_food/public/PreparingyourOrder.png"
                                                        alt="">
                                                    <p class="step-text">Preparing your Order</p>
                                                </div>
                                            </li>
                                            <li id="orderonthewayData" style="display:none">
                                                <div class="step-ul-inner">
                                                    <div class="line"></div>
                                                    <img src="https://php8.appworkdemo.com/e_food/public/Yourordersareonitsway.png"
                                                        alt="">
                                                    <p class="step-text">Your orders are on its way</p>
                                                </div>
                                            </li>
                                            <li id="deleiveredData" style="display:none">
                                                <div class="step-ul-inner">
                                                    <div class="line"></div>
                                                    <img src="https://php8.appworkdemo.com/e_food/public/Delivered.png"
                                                        alt="">
                                                    <p class="step-text">Delivered</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
    </div>
    <script>
        var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
    </script>
    @section('js')
    <script>
        function opentrackStatus(id) {
            $("#myModal").modal('show');
        }
        $('#orderManagementMenu').addClass('active');
    </script>
    @endsection
@endsection
