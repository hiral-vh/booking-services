@extends('business.layouts.app')
@section('content')
@if ($errors->any())
toastr.success("Email is incorrect");
@endif
<style>
    .warningdiv {
        margin-bottom: 15px;
        padding: 4px 6px;
    }

    .warning {
        background-color: #ffffcc;
        border-left: 6px solid #ffeb3b;
        border-radius: 4px;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .warning p {
        margin: 0;
    }

    #barchart_material {
        width: 100% !important;
    }

    .flex-width {
        flex: 0 0 195px;
        max-width: 195px;
        width: 100%;
    }
</style>
<div class="content">

    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Dashboard</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">

        <div class="container-fluid">
            @if($getBusinessData->numbers_of_appointment <= 0) <div class="warningdiv">
                <div class="warningdiv">
                    <div class="warning">
                        <p style="font-size: 18px;font-weight: 900;"><strong> Your subscription order is over. If you want extra order please top up.</strong></p>
                        <button onclick="openModel()" class="btn btn-primary">Top Up</button>
                    </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card-heading p-4">
                                <div class="d-flex">
                                    <input class="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#fd8442" value="{{(isset($getBusinessData->numbers_of_appointment) && isset($TotalPayments))?$getBusinessData->numbers_of_appointment :'N/A'}}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" />
                                    <div class="float-right pl-3">
                                        <h2 class="text-primary mb-0">{{(isset($TotalPayments))?$TotalPayments:'N/A'}}</h2>
                                        <p class="text-muted mb-0 mt-2 dashtext-ellip">Booked Appointments</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card-heading p-4">
                                <div class="d-flex">
                                    <input class="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#bb96ea" value="{{$getBusinessData->numbers_of_appointment}}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" />
                                    <div class="float-right pl-3">
                                        <h2 class="text-purple mb-0">{{$getBusinessData->numbers_of_appointment}}</h2>
                                        <p class="text-muted mb-0 mt-2 dashtext-ellip">Remaining Appointments</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card-heading p-4">
                                <div class="d-flex">
                                    <input class="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#bf9ee7" value="{{$services}}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" />
                                    <div class="float-right pl-3">
                                        <h2 class="text-purple mb-0">{{$services}}</h2>
                                        <p class="text-muted mb-0 mt-2 dashtext-ellip">Total Service</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card-heading p-4">
                                <div class="d-flex">
                                    <input class="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#fd8442" value="{{$totalRevenue}}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" />
                                    <div class="float-right pl-3">
                                        <h2 class="text-primary mb-0">£{{$totalRevenue}}</h2>
                                        <p class="text-muted mb-0 mt-2 dashtext-ellip">Total Revenue</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-4 justify-content-between">
                                    <div class="col-3">
                                        <select class="form-control" id="list_type" name="list_type">
                                            <option selected value="Appointments">Appointments</option>
                                            <option value="revenue">Revenue</option>
                                            <option value="services">Services</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="filter" id="filter">
                                    <div class="col-4">
                                        <div class="row">
                                            <div class="col-12">
                                                <!-- <label for="name" class="col-sm-3 control-label">From Date<span class="error">*</span></label> -->

                                                <input type="text" class="form-control" id="dates" name="dates" placeholder="Select Date" value="">
                                                <span class="error" id="validTillSpan"> {{$errors->add->first('valid_till')}}</span>

                                            </div>

                                        </div>

                                    </div>

                                    <div class=" col-3 d-flex justify-content-end align-items-center flex-width">
                                        <div class="fc-right">
                                            <div class="fc-button-group cus-fc-button-group ">
                                                <button type="button" class="fc-month-button fc-button fc-state-default cus-fc-state-default fc-corner-left cus-fc-state-active" onclick="searchGraph()">Month</button><button type="button" class="fc-basicWeek-button fc-button fc-state-default cus-fc-state-default" onclick="searchGraph('week')">Week</button><button type="button" class="fc-basicDay-button fc-button fc-state-default cus-fc-state-default fc-corner-right cus-fc button" onclick="searchGraph('day')">Day</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div id="barchart_material" style="width: 900px; height: 500px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- end row -->


                <!-- end col -->
        </div>
        <!-- end row -->

    </div>
    <!-- container-fluid -->

</div>
<!-- Page content Wrapper -->

</div>
<!-- content -->

<!-- sample modal content -->
<div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title m-0" id="custom-width-modalLabel">Top Up Orders</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" action="{{route('topup-orders')}}" id="food-menu-add">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">

                                <span class="text-primary">*</span>
                                <input type="text" id="total_order" name="total_order" class="form-control only-numeric" placeholder="Total Orders" />
                                <span id="total_ordererror" class=" name-error text-primary"></span>
                            </div>
                            <div class="form-group">
                                <span class="text-primary">*</span>
                                <input type="text" id="total_days" name="total_days" class="form-control only-numeric" placeholder="Total Days" />
                                <span id="total_dayserror" class=" name-error text-primary"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" onclick="return validateForm()" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    var success = "{{ Session::get('success') }}";
    var error = "{{ Session::get('error') }}";
</script>
@section('page-js')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    $('input[name="dates"]').daterangepicker();

    var typeText = 'Appointments';

    $(document).ready(function(e) {
        typeText = $('#list_type:nth-child(1)').val();
        notifications();
     
    });

    $('#list_type').change(function(e) {
        typeText = $(this).val();
        searchGraph();
    });

    $('#dates').change(function(e) {
        $("#filter").val(1);
        searchGraph();
    });

    searchGraph('');
    var listType = $("#list_type").val();

    if (listType == 'Appointments') {
        var graphArray1 = [
            ['Date', typeText]
        ];
    }

    function searchGraph(searchType = '') {

        if (searchType == '') {
            $('#dates').val('');
            $('#filter').val('');
            graphArray1 = [];
            graphArray1 = [
                ['Date', typeText]
            ];
            $('.fc-month-button').addClass('cus-fc-state-active');
            $('.fc-basicWeek-button').removeClass('cus-fc-state-active');
            $('.fc-basicDay-button').removeClass('cus-fc-state-active');
        }

        if (searchType == 'week') {
            $('#dates').val('');
            $('#filter').val('');

            graphArray1 = [];
            graphArray1 = [
                ['Date', typeText]
            ];
            $('.fc-month-button').removeClass('cus-fc-state-active');
            $('.fc-basicDay-button').removeClass('cus-fc-state-active');
            $('.fc-basicWeek-button').addClass('cus-fc-state-active');
        }

        if (searchType == 'day') {
            $('#dates').val('');
            $('#filter').val('');
            graphArray1 = [];
            graphArray1 = [
                ['Date', typeText]
            ];
            $('.fc-month-button').removeClass('cus-fc-state-active');
            $('.fc-basicWeek-button').removeClass('cus-fc-state-active');
            $('.fc-basicDay-button').addClass('cus-fc-state-active');
        }

        var listType = $("#list_type").val();
        var dt = new Date();
        var month = dt.getMonth() + 1;
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();
        var dateFilter = 'datefilter';
        var dates = $('#dates').val();
        var filter = $('#filter').val();



        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{route('getMonthlyData')}}',
            data: {
                _token: "<?php echo csrf_token(); ?>",
                listType: listType,
                searchType: searchType,
                dates: dates,
                filter: filter
            },
            success: function(response) {
                for (var i = 0; i < response.length; i++) {

                    graphArray1.push([response[i].allDates, response[i].totalCount]);
                }
                google.charts.load('current', {
                    'packages': ['bar']
                });
                google.charts.setOnLoadCallback(drawChart);
                drawChart();
            },
        });
    }



    function drawChart() {
        //console.log(graphArray1);
        var data = google.visualization.arrayToDataTable(graphArray1);


        var options = {
            chart: {
                title: 'Appointments',
                //subtitle: 'Sales, Expenses, and Profit: 2014-2017',
            },
            bars: 'vertical', // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    function openModel() {
        $("#total_order").val('');
        $("#total_days").val('{{$diffrenceDay}}');
        $("#total_ordererror").html('');
        $("#total_dayserror").html('');
        $("#custom-width-modal").modal('show');
    }

    function validateForm() {
        var temp = 0;
        var total_order = $("#total_order").val();
        var total_days = $("#total_days").val();

        if (total_days == '') {
            $("#total_dayserror").html('Please enter Total Days');
            temp++;
        } else {
            var diffrenceDay = '{{$diffrenceDay}}';

            if (parseFloat(total_days) > parseFloat(diffrenceDay)) {
                $("#total_dayserror").html('Please enter valid Day');
                temp++;
            } else {
                $("#total_dayserror").html('');
            }
        }

        if (total_order == '') {
            $("#total_ordererror").html('Please enter Total Orders');
            temp++;
        } else {
            $("#total_ordererror").html('');
        }
        if (temp == 0) {
            $("#food-menu-add").submit();
            return true;
        } else {
            return false;
        }

    }
</script>


@endsection
@endsection