@extends('business.layouts.app')
@section('content')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Week Schedule</h4>
        </div>
    </div>
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="m-t-0 m-b-30">Settings</h4>
                                </div>
                                <div class="col-md-9">
                                    <div class="setting-data-main">

                                        @foreach ($days as $data)
                                        @php
                                        $btnName="Set Time";
                                        @endphp
                                        @if(isset($dayArr[$data]))
                                        @php $btnName = "Update Time"; @endphp
                                        @endif
                                        <div class="d-flex justify-content-between settings-data">
                                            <label class="mb-0">{{ $data }}</label>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light" onclick="openModal('{{ $data }}')">{{$btnName}}</button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </diV>
                        </div>
                        <!-- <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="mb-0 mt-0">Break Time</h4>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light"
                                                        onclick="openModal('{{ $data }}')">Add Break Time</button>
                                    </div>
                                    </div>
                                </div>
                            </div> -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="setTimeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title m-0" id="myModalLabel">Update Schedule</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{route('add-weekly-schedule')}}" id="scheduleCreateForm" method="post">
                    @csrf
                    @method('POST')
                    <input type="hidden" id="businessId" name="businessId" value="{{$time->id}}">
                    <input type="hidden" id="day" name="day" value="">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Start Time<span class="error">*</span></label>
                        <input type="" class="form-control" id="open_time" name="open_time" placeholder="" value="{{$time->opening_time}}" autofocus>
                        <span class="error" id="open_time_span">{{ $errors->teamMember->first('start_time') }}</span>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">End Time<span class="error">*</span></label>
                        <input type="" class="form-control" id="close_time" name="close_time" placeholder="" value="{{$time->closing_time}}" autofocus>
                        <span class="error" id="close_time_span">{{ $errors->teamMember->first('end_time') }}</span>
                    </div>

                  

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary waves-effect waves-light" id="setSchedule" onclick="setValidate()">Update</button>
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script>
    var success = "{{ Session::get('success') }}";
    var error = "{{ Session::get('error') }}";
  
</script>
@section('page-js')
<script>
    function openModal(day) {
        //alert(day);
        $('#setTimeModal').modal('show');
        $('#day').val(day);
    }
   
    $("#open_time").timepicker();
    $("#close_time").timepicker();

    function setValidate() {
        var temp = 0;
        var open_time = $("#open_time").val();
        var close_time = $("#close_time").val();
      

        // if (open_time.trim() == '') {
        //     $("#open_time_span").html("Please enter open time.");
        //     temp++;
        // } else {
        //     $("#open_time_span").html("");
        // }

        // if (close_time.trim() == '') {
        //     $("#close_time_span").html("Please enter close time.");
        //     temp++;
        // } else if (close_time < open_time) {
        //     $("#close_time_span").html("Close time should be greater than or equal to Open time.");
        //     temp++;
        // } else {
        //     $("#close_time_span").html("");
        // }

        var timefrom = new Date();
            timestart = $('#open_time').val().split(":");
            timefrom.setHours((parseInt(timestart[0]) - 1 + 24) % 24);
            timefrom.setMinutes(parseInt(timestart[1]));

            var timeto = new Date();
            timestart = $('#close_time').val().split(":");
            timeto.setHours((parseInt(timestart[0]) - 1 + 24) % 24);
            timeto.setMinutes(parseInt(timestart[1]));

            //convert both time into timestamp
            var stt = new Date("November 13, 2013 " + open_time);
            stt = stt.getTime();

            var endt = new Date("November 13, 2013 " + close_time);
            endt = endt.getTime();


            if (stt > endt) {
                $("#close_time_span").html("Close time should be greater than or equal to Open time.");
                temp++;
            } else {
                $("#close_time_span").html("");
            }

      
        if (temp == 0) {
            $("#scheduleCreateForm").submit();
            return true;
        } else {
            return false;
        }

    }
</script>
@endsection
@endsection