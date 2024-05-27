@extends('business.layouts.app')
@section('css')

@endsection
@section('content')
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Team Members Time Slot</h4>
            </div>
        </div>
        <div class="page-content-wrapper ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-10">
                                        <h4 class="m-t-0 m-b-30">List</h4>
                                    </div>
                                    <div class="col-2" align="right">
                                        @php 
                                            $btnName = ''; 
                                            $class = ''; 
                                        @endphp    
                                        @if(count($timeSlots) > 0)
                                            @php $btnName = 'Edit';@endphp
                                        @else
                                            @php $btnName = 'Add';@endphp
                                        @endif
                                        <button type="button" class="btn waves-effect btn-secondary dayTitle"
                                            data-toggle="modal" data-target="#myModal">{{$btnName}} </button>
                                    </div>
                                </div>

                                <form method="POST" action="{{route('add-time-slot')}}">
                                @csrf
                                <input type="hidden" id="business_id" name="business_id"
                                                        value="{{ $business->id }}">
                                <input type="hidden" id="business_team_member_id"
                                                        name="business_team_member_id" value="{{ $teamMemberId }}">
                                @foreach($timeSlots as $data)
                                <input type="hidden" id="duration" name="duration" value="{{ $data->duration }}">
                                <input type="hidden" id="team_start_time" name="team_start_time" value="{{ $data->team_start_time }}">
                                <input type="hidden" id="team_end_time" name="team_end_time" value="{{ $data->team_end_time }}">
                                @endforeach
                                <div class="col-12" id="timeList">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0" id="edit_teamMember_timeSlots">
                                            <thead>
                                                <tr id="editSlots">
                                                @if(!empty($slots[0]['days']))
                                                @foreach($slots[0]['days'] as $data)
                                              
                                                    <th>{{$data}}</th>
                                                
                                                @endforeach
                                                @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @if(!empty($slots[0]['weekData']))
                                                @foreach($slots[0]['weekData'] as $list)
                                                <tr>
                                                    @foreach($list as $data)
                                                    @php 
                                                    $value = $data['day'].'-'.$data['slot_start_time'].'-'.$data['slot_end_time'];
                                                    @endphp
                                         
                                                 
                                                        <td><div id='divID' class='d-flex align-items-center'><input type='checkbox' @if(in_array($value, $weekData)) checked @endif class='checkbox' name='timeSlots[]' value="{{$value}}"><label class='team-mem-check'>{{$data['slot_start_time'].' - '.$data['slot_end_time']}}</label></div></td>

                                                    @endforeach
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>

                                     
                                    </div>
                                    <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mt-3" value="Submit" id="editSubmit">Submit
                                    </button>
                                    </div>  
                                </div>
                                
                                <div class="col-12 tableclass" id="showTimeSlot" style="display:none;">
                                   
                                </div>
                                <div class="addTimeSlot" id="addTimeSlot">
                                <span id="submitBtn"></span>
                                </form>

                                <div id="myModal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true" >
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title m-0" id="myModalLabel">Update Time Slot</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" id="teamMemberTimeSlotCreateForm">
                                                 
                                                    <input type="hidden" id="business_id" name="business_id"
                                                        value="{{ $business->id }}">
                                                    <input type="hidden" id="business_team_member_id"
                                                        name="business_team_member_id" value="{{ $teamMemberId }}">

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Start Time<span
                                                                class="error">*</span></label>
                                                                <select class="form-control" id="start_time" name="start_time">
                                                                    <option value="">Select Start Time</option>
                                                                    @for ($a=0;$a<=23;$a++)
                                                                        <option value="{{$a}}:00:00">{{$a}} : 00</option>
                                                                    @endfor
                                                                </select>
                                                                <span class="error" id="startTimeSpan">{{ $errors->teamMember->first('start_time') }}</span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">End Time<span
                                                                class="error">*</span></label>
                                                                <select class="form-control" id="end_time" name="end_time">
                                                                    <option value="">Select End Time</option>
                                                                    @for ($a=0;$a<=23;$a++)
                                                                        <option value="{{$a}}:00:00">{{$a}} : 00</option>
                                                                    @endfor
                                                                </select>
                                                            <span class="error" id="endTimeSpan">{{ $errors->teamMember->first('end_time') }}</span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Duration(Mins)<span
                                                                class="error">*</span></label>
                                                                <input type="text"  class="form-control" id="duration" name="duration" placeholder="Duration" maxlength="3">
                                                                <span class="error" id="durationSpan">{{ $errors->teamMember->first('duration') }}</span>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="submit"
                                                            class="btn btn-primary waves-effect waves-light" id="setTimeSlots">Update</button>
                                                        <button type="button" class="btn btn-secondary waves-effect"
                                                            data-dismiss="modal">Close</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
    <script>
        var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
    </script>
@section('page-js')
<script src="{{asset('business/plugins/timepicker/bootstrap-timepicker.js')}}"></script>
<script src="{{asset('business/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $('#businessDetailMainMenu').addClass('active');
        $('#teamMembersMenu').addClass('active subdrop');
        $('#businessDetailMenu').css('display','block');

       /*  $('#duration').timepicker({
            defaultTime: false,
            showMeridian:false,
            timeFormat: 'mm',
            minMinutes: 15,
            maxMinutes: 120,
        }); */

        $( document ).ready(function() {
            //$('#timeList').css('display','none');
           // $('#showTimeSlot').css('display','block');
           $('#editSubmit').hide();
        });
        

        // $("#teamMemberTimeSlotCreateForm").submit(function(e) {
        //     var temp = 0;
        //     var start_time=$("#start_time").val();
        //     var end_time=$("#end_time").val();
        //     var duration = $("#duration").val();
        //     var startTimeSplit = start_time.split(":");
        //     var endTimeSplit = end_time.split(":");
           
        //     if(start_time=="")
        //     {
        //         $("#startTimeSpan").html("Please select Start Time");
        //         $("#start_time").focus();
        //         temp++;
        //     }else{
        //         $("#startTimeSpan").html("");
        //     }

        //     if(end_time=="")
        //     {
        //         $("#endTimeSpan").html("Please select End Time");
        //         $("#end_time").focus();
        //         temp++;
        //     }else if(parseInt(startTimeSplit[0]) == parseInt(endTimeSplit[0])){
        //         $("#endTimeSpan").html("End time and Start time is same");
        //         $("#end_time").focus();
        //         temp++;
        //     }else if(parseInt(startTimeSplit[0]) > parseInt(endTimeSplit[0])){
        //         $("#endTimeSpan").html("End time smaller is than Start time ");
        //         $("#end_time").focus();
        //         temp++;
        //     }
        //     else{
        //         $("#endTimeSpan").html("");
        //     }

        //     if($("#duration").val()=="")
        //     {
        //         $("#durationSpan").html("Please select Duration");
        //         $("#duration").focus();
        //         temp++;
        //     }else{
        //         $("#durationSpan").html("");
        //     }

        //     if(duration < 15)
        //     {
        //         $("#durationSpan").html('please enter greater than 15 mins');
        //         temp++;
        //     }

        //     if(duration > 120)
        //     {
        //         $("#durationSpan").html('please enter less than 120 mins');
        //         temp++;
        //     }

        //     $.ajax({
        //     type: "POST",
        //     dataType: "json",
        //     async: false,
        //     url:"{{ route('show-time-slot') }}",
        //     data: {
        //         'start_time': start_time,
        //         'end_time':end_time,
        //         'duration':duration,
        //     },
        //     success: function(data) {
               
        //     }
           
        //     });
        //     return false;
            

        //     if (temp !== 0) {
        //         return false;
        //     }
        // });

        var edit = "{{count($timeSlots)}}";
        console.log(edit);
        $("#setTimeSlots").click(function(e) {
            
            $('#myModal').modal('hide');
            $('#editSubmit').hide();
           
          
            var start_time=$("#start_time").val();
            var end_time=$("#end_time").val();
            var duration = $("#duration").val();
            var business_id = $("#business_id").val();
            var business_team_member_id = $("#business_team_member_id").val();

           
            $.ajax({
            type: "GET",
            dataType: "json",
            async: false,
            url:"{{ route('show-time-slot') }}",
            data: {
                'start_time': start_time,
                'end_time':end_time,
                'duration':duration,
                'business_team_member_id':business_team_member_id,
                'business_id':business_id,
            },
            success: function(response) {
                var Days = response.days;
                var weekData = response.weekData;
                $('#showTimeSlot').css('display','block');

               /*  if(edit != 0)
                {
                 
              
            }else{ */
                $('#edit_teamMember_timeSlots').html('');
                var newTBL ='<table class="table table-striped" id="teamMember_timeSlots"> <thead><tr class="mainSlots">';
                $.each(Days, function(index, val) {
                    newTBL += '<th>'+val+'</th>';
                });
                newTBL+='</tr></thead><tbody></tbody></table>';
                $("#showTimeSlot").html(newTBL);
                var newRow = "";
                var hidden_div = "";
                $.each(weekData, function(index, val) {
                    newRow += '<tr>';
                    $.each(val, function(indexs, vals) {
                     
                       newRow += "<td><div id='divID_"+id+"' class='d-flex align-items-center'><input type='checkbox' class='checkbox' name='timeSlots[]' value='"+vals.day+'-'+vals.slot_start_time+'-'+vals.slot_end_time+"'><label class='team-mem-check'>"+vals.slot_start_time+' - '+vals.slot_end_time+"</label></div></td>";
                    
                       hidden_div += "<div id='addTimeSlot'><input type='hidden' name='business_team_member_id' value=" + business_team_member_id + "><input type='hidden' name='business_id' value=" + business_id + "><input type='hidden' name='duration' value=" + duration + "><input type='hidden' name='team_start_time' value=" + start_time + "><input type='hidden' name='team_end_time' value=" + end_time + "></div>";
                   });
                   newRow += '</tr>';
                 
                });
               
                $("#teamMember_timeSlots tbody").html(newRow);
                $("#addTimeSlot").append(hidden_div);
                $('#submitBtn').html('<input type="submit" class="btn btn-primary waves-effect waves-light mt-3" value="Submit" id="insSubmit">');
                  
            }
            // }
               
           
            });
            return false;
        });
    </script>
@endsection
@endsection
