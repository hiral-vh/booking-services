@extends('admin.layouts.app')
@section('content')
@section('css')
<style>
   .cus-inputwidth .form-control{
        width: 239px;
    }
</style>
@endsection
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Cancelled Bookings</h4>
        </div>
    </div>
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="m-t-0 m-b-30">Cancelled Bookings List</h4>
                                </div>
                                <div class="col-12 mb-3">
                                    <form class="form-inline d-inline-block cus-inputwidth" method="GET" action="{{ route('canceleappointmentlist') }}">
                                        <div class="form-group">
                                            <label class="sr-only">Search</label>
                                            <input type="text" class="form-control mr-2 mb-2" id="userName" name="userName" placeholder="Name" value="{{$userName}}">
                                            <input type="text" class="form-control mr-2 mb-2" id="mobile" name="mobile" placeholder="Mobile" value="{{$mobile}}">
                                            @php
                                                $tempArrayBusiness=array();
                                                $tempArraySubService=array();
                                                $tempArrayBusinessSubService=array();
                                                $tempArrayBusinessTeamMember=array();
                                                $tempArrayAppointmentDate=array();
                                                $tempArrayAppointmentTime=array();
                                            @endphp
                                            <select class="form-control mr-2 mb-2" id="business" name="business">
                                                <option value="">Select Business</option>
                                                @foreach ($canceleAppointmentList as $value)
                                                    @if (isset($value->business))
                                                        @if(!in_array($value->business->id,$tempArrayBusiness))
                                                            <option {{($value->business->id==$business)?'selected':''}} value="{{$value->business->id}}">{{$value->business->name}}</option>
                                                        @endif
                                                        @php
                                                            array_push($tempArrayBusiness,$value->business->id);
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            </select>

                                            <select class="form-control mr-2 mb-2" id="sub_service" name="sub_service">
                                                <option value="">Select Sub Service</option>
                                                @foreach ($canceleAppointmentList as $value)
                                                    @if (isset($value->subService))
                                                        @if(!in_array($value->subService->id,$tempArraySubService))
                                                            <option {{($value->subService->id==$sub_service)?'selected':''}} value="{{$value->subService->id}}">{{$value->subService->name}}</option>
                                                        @endif
                                                        @php
                                                            array_push($tempArraySubService,$value->subService->id);
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            </select>

                                            <select class="form-control mr-2 mb-2" id="business_sub_service" name="business_sub_service">
                                                <option value="">Select Business Sub Service</option>
                                                @foreach ($canceleAppointmentList as $value)
                                                    @if (isset($value->businessSubService))
                                                        @if(!in_array($value->businessSubService->id,$tempArrayBusinessSubService))
                                                            <option {{($value->businessSubService->id==$business_sub_service)?'selected':''}} value="{{$value->businessSubService->id}}">{{$value->businessSubService->name}}</option>
                                                        @endif
                                                        @php
                                                            array_push($tempArrayBusinessSubService,$value->businessSubService->id);
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            </select>

                                            <select class="form-control mr-2 mb-2" id="business_team_member" name="business_team_member">
                                                <option value="">Select Business Team Member</option>
                                                @foreach ($canceleAppointmentList as $value)
                                                    @if (isset($value->businessTeamMember))
                                                        @if(!in_array($value->businessTeamMember->id,$tempArrayBusinessTeamMember))
                                                            <option {{($value->businessTeamMember->id==$business_team_member)?'selected':''}} value="{{$value->businessTeamMember->id}}">{{$value->businessTeamMember->name}}</option>
                                                        @endif
                                                        @php
                                                            array_push($tempArrayBusinessTeamMember,$value->businessTeamMember->id);
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            </select>

                                            <select class="form-control mr-2 mb-2" id="appointment_date" name="appointment_date">
                                                <option value="">Select Appointment Date</option>
                                                @foreach ($canceleAppointmentList as $value)
                                                    @if(isset($value->appointment_date))
                                                        @if(!in_array($value->appointment_date,$tempArrayAppointmentDate))
                                                            <option {{($value->appointment_date==$appointment_date)?'selected':''}} value="{{$value->appointment_date}}">{{date('d-m-Y',strtotime($value->appointment_date))}}</option>
                                                        @endif
                                                        @php
                                                            array_push($tempArrayAppointmentDate,$value->appointment_date);
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            </select>

                                            <select class="form-control mr-2 mb-2" id="appointment_time" name="appointment_time">
                                                <option value="">Select Appointment Time</option>
                                                @foreach ($canceleAppointmentList as $value)
                                                    @if(isset($value->appointment_time))
                                                        @if(!in_array($value->appointment_time,$tempArrayAppointmentTime))
                                                            <option  {{($value->appointment_time==$appointment_time)?'selected':''}} value="{{$value->appointment_time}}">{{date('h:i A',strtotime($value->appointment_time))}}</option>
                                                        @endif
                                                        @php
                                                            array_push($tempArrayAppointmentTime,$value->appointment_time);
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Search</button>
                                        <a href="{{ route('business-appointment') }}"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Mobile</th>
                                                    <th>Business Name</th>
                                                    <th>Sub Service</th>
                                                    <th>Business Sub Service</th>
                                                    <th>Team Member</th>
                                                    <th>Appointment Date</th>
                                                    <th>Appointment Time</th>
                                                    <th>Note</th>
                                                    <!-- <th>Status</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = ($canceleAppointmentListFilter->currentpage() - 1) * $canceleAppointmentListFilter->perpage() + 1;

                                                @endphp
                                                @forelse ($canceleAppointmentListFilter as $value)
                                                <tr id="user_{{$value->id}}">
                                                    <th width="5%">{{ $i }}</th>
                                                    <td width="10%">{{(isset($value->user->name))?$value->user->name:'N/A'}}</td>
                                                    <td width="10%">{{(isset($value->user->mobile))?$value->user->mobile:'N/A'}}</td>
                                                    <td width="10%">{{(isset($value->business->name))?$value->business->name:'N/A'}}</td>
                                                    <td width="10%">{{(isset($value->subService->name))?$value->subService->name:'N/A'}}</td>
                                                    <td width="10%">{{(isset($value->businessSubService->name))?$value->businessSubService->name:'N/A'}}</td>
                                                    <td width="10%">{{(isset($value->businessTeamMember->name))?$value->businessTeamMember->name:'N/A'}}</td>
                                                    <td width="10%">{{(isset($value->appointment_date))?date('d-m-Y',strtotime($value->appointment_date)):'N/A'}}</td>
                                                    <td width="10%">{{(isset($value->appointment_time))?date('h:i A',strtotime($value->appointment_time)):'N/A'}}</td>
                                                    <td width="10%">{{(isset($value->note))?$value->note:'N/A'}}</td>
                                                    <!-- <td width="60px">
                                                        <div class="site-toggle">
                                                            <input type="checkbox" id="{{$value->id}}"
                                                                data-status="{{$value->status}}" title="Status" @if($value->status ==1)
                                                            checked @endif name="toggle" class="toggle">
                                                            <div class="main-toggle">
                                                                <span class="on">On</span>
                                                                <div class="circle"></div>
                                                                <span class="off">Off</span>
                                                            </div>
                                                        </div>
                                                    </td> -->
                                                </tr>
                                                @php
                                                $i++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="9" align="center">No Cancelled Bookings Available</th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{ $canceleAppointmentListFilter->appends(request()->except('page'))->links('pagination::bootstrap-4')}}
                                    </div>
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
<script>
    var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
</script>
@section('js')
<script>
     $(document).ready(function(e){
        $("#canceledBookingsMenu").css('color','#fd8442');
    });
    $(document).on("change", ".toggle", function() {
        var id=$(this).attr('id');
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('businessUserStatus')}}",
            data: {
                'id': id,
                '_token':token
            },
            success: function(data) {
                if(data ==1){
                    $("#user_"+id).attr('checked',true);
                }else{
                    $("#user_"+id).attr('checked',false);
                }

            }
        });
    });
</script>
@endsection
@endsection
