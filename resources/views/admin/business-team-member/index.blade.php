@extends('admin.layouts.app')
@section('content')
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">{{ ucfirst($business->name) }} Team Member</h4>
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
                                    <h4 class="m-t-0 m-b-30">Create</h4>
                                </div>
                                <div class="col-1">
                                    <a href="{{ route('business-admin.index') }}"><button type="button" class="btn waves-effect btn-secondary" title="Back"><i class="ion ion-md-arrow-back"></i></button></a>
                                </div>
                                <div class="col-12">
                                    <form method="POST" action="{{ route('business-team-member-store') }}" id="businessTeamMemberCreateForm" class="form-horizontal" enctype='multipart/form-data'>
                                        @csrf
                                        <input type="hidden" value="{{ $business->id }}" id="business_id" name="business_id">
                                        <div class="form-group row">
                                            <label for="team_member" class="col-sm-3 control-label">Team Member<span class="error">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="team_member" name="team_member">
                                                    <option value="">Select Team Member</option>
                                                    @forelse ($teamMembers as $teamMember)
                                                    <option value="{{ $teamMember->id }}">
                                                        {{ $teamMember->name }}
                                                    </option>
                                                    @empty
                                                    <option value="">No Team Member Available</option>
                                                    @endforelse
                                                </select>
                                                <span class="error" id="teamMemberSpan">{{ $errors->admin->first('team_member') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-0">
                                            <div class="col-sm-9">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> <!-- card-body -->
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-11">
                                    <h4 class="m-t-0 m-b-30">List</h4>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Business</th>
                                                    <th scope="col">Team Member</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = ($businessTeamMembers->currentpage() - 1) * $businessTeamMembers->perpage() + 1;
                                                @endphp
                                                @forelse ($businessTeamMembers as $value)
                                                <tr id="business_team_member_{{ $value->id }}">
                                                    <th scope="row" width="100px">{{ $i }}</th>
                                                    <td width="350px">{{ $value->business->name }}</td>
                                                    <td width="250px">{{ $value->teamMember->name }}</td>
                                                    <td width="250px">
                                                        {{ date('d-m-Y', strtotime($value->created_at)) }}
                                                    </td>
                                                    <td width="60px">
                                                        <div class="site-toggle">
                                                            <input type="checkbox" id="{{ $value->id }}" data-status="{{ $value->status }}" @if ($value->status == 1)
                                                            checked @endif name="toggle" class="toggle">
                                                            <div class="main-toggle">
                                                                <span class="on">On</span>
                                                                <div class="circle"></div>
                                                                <span class="off">Off</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td width="100px">
                                                        <a href="javascript:;" class="btn create-icon"><i class="fa fa-fw fa-edit" title="Edit" data-toggle="modal" data-target="#custom-width-modal" onclick='getBusinessTeamMemberId("{{ $value->id }}","{{ $value->teamMember->id }}")'></i></a>

                                                        <a class="btn trash-icon" href="javascript:;" onclick="openPopup({{ $value->id }}); " data-popup="tooltip" title="Delete"><i class="fa fa-fw fa-trash"></i></a>
                                                        <form id="Deletesubmit_{{ $value->id }}" action="{{ route('business-team-member-delete', $value->id) }}" method="POST" class="d-none">
                                                            @csrf
                                                            @method('delete')
                                                            <input type="hidden" name="business_id" id="business_id" value="{{ $business->id }}">
                                                        </form>

                                                        <a href="javascript:;" class="btn"><i class="fa fa-fw fa-clock" title="TimeSlots" data-toggle="modal" data-target="#timeslotsModal" onclick='getBusinessId("{{ $business->id }}","{{ $value->teamMember->id }}")'></i></a>
                                                    </td>
                                                </tr>
                                                @php
                                                $i++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="6" align="center">No Business Team Member Available
                                                        </th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{ $businessTeamMembers->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
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
<!-- Page content Wrapper -->
</div>
<div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title m-0" id="custom-width-modalLabel">{{ ucfirst($business->name) }} Team Member
                    Edit </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form class="form-horizontal" id="BusinessTeamMemberEditForm" method="POST" action="{{ route('business-team-member-update') }}">
                @csrf
                @method('put')
                <input type="hidden" name="edit_business_id" value="{{ $business->id }}" id="edit_business_id">
                <input type="hidden" name="business_team_member_id" value="" id="business_team_member_id">
                <input type="hidden" name="previous_team_member_id" value="" id="previous_team_member_id">
                <div class="form-group row">
                    <label for="edit_team_member" class="col-sm-3 control-label">Team Member<span class="error">*</span></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="edit_team_member" name="edit_team_member">
                            <option value="">Select Team Member</option>
                            @forelse ($teamMembers as $teamMember)
                            <option value="{{ $teamMember->id }}">{{ $teamMember->name }}
                            </option>
                            @empty
                            <option value="">No Team Member Available</option>
                            @endforelse
                        </select>
                        <span class="error" id="editTeamMemberSpan"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div id="timeslotsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="timeslotsModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title m-0" id="timeslotsModalLabel">TimeSlots</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form class="form-horizontal" id="timeSlotsForm" method="POST" action="{{ route('business-time-slots-store')}}">
                @csrf
                @method('post')
                <input type="hidden" name="business_id" value="{{ $business->id }}" id="business_id">
                <input type="hidden" name="team_member_id" value="" id="team_member_id">

                <div class="form-group row">
                    <div class="checkbox checkbox-primary">
                        <input class="timeslot" id="checkbox9" type="checkbox" value="9:00" name="checkbox[]">
                        <label for="checkbox9">
                            9:00
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="checkbox checkbox-primary">
                        <input class="timeslot" id="checkbox10" type="checkbox" value="10:00" name="checkbox[]">
                        <label for="checkbox10">
                            10:00
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="checkbox checkbox-primary">
                        <input class="timeslot" id="checkbox11" type="checkbox" value="11:00" name="checkbox[]">
                        <label for="checkbox11">
                            11:00
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="checkbox checkbox-primary">
                        <input class="timeslot" id="checkbox12" type="checkbox" value="12:00" name="checkbox[]">
                        <label for="checkbox12">
                            12:00
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="checkbox checkbox-primary">
                        <input class="timeslot" id="checkbox13" type="checkbox" value="13:00" name="checkbox[]">
                        <label for="checkbox13">
                            13:00
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="checkbox checkbox-primary">
                        <input class="timeslot" id="checkbox14" type="checkbox" value="14:00" name="checkbox[]">
                        <label for="checkbox14">
                            14:00
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="checkbox checkbox-primary">
                        <input class="timeslot" id="checkbox15" type="checkbox" value="15:00" name="checkbox[]">
                        <label for="checkbox15">
                            15:00
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="checkbox checkbox-primary">
                        <input class="timeslot" id="checkbox16" type="checkbox" value="16:00" name="checkbox[]">
                        <label for="checkbox16">
                            16:00
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="checkbox checkbox-primary">
                        <input class="timeslot" id="checkbox17" type="checkbox" value="17:00" name="checkbox[]">
                        <label for="checkbox17">
                            17:00
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="checkbox checkbox-primary">
                        <input class="timeslot" id="checkbox18" type="checkbox" value="18:00" name="checkbox[]">
                        <label for="checkbox18">
                            18:00
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="checkbox checkbox-primary">
                        <input class="timeslot" id="checkbox19" type="checkbox" value="19:00" name="checkbox[]">
                        <label for="checkbox19">
                            19:00
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="checkbox checkbox-primary">
                        <input class="timeslot" id="checkbox20" type="checkbox" value="20:00" name="checkbox[]">
                        <label for="checkbox20">
                            20:00
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script>
    var success = "{{ Session::get('success') }}";
    var error = "{{ Session::get('error') }}";
</script>
<script>
    function getBusinessTeamMemberId(id, tid) {
        $('#business_team_member_id').val(id);
        $('#edit_team_member').val(tid).find('option:selected').attr('id');
        $('#previous_team_member_id').val(tid);


    }

    function getBusinessId(id, tid) {

        $("#team_member_id").val(tid);
        var token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: "GET",
            url: "{{route('checkedTimeSlots')}}",
            data: {
                'id': id,
                'tid': tid,
                '_token': token
            },
            success: function(response) {
                $.each(response, function(index, val) {
                    $("input[value='" + val.timeslots + "']").attr('checked', true);
                });
            }
        });
    }
    $("#businessTeamMemberCreateForm").submit(function(e) {
        var temp = 0;
        if ($("#team_member").val() == "") {
            $("#teamMemberSpan").html("The Team Member Field Is Required");
            temp++;
        } else {
            $("#teamMemberSpan").html("");
        }
        if (temp !== 0) {
            return false;
        }
    });
    $("#BusinessTeamMemberEditForm").submit(function(e) {
        var temp = 0;
        if ($("#edit_team_member").val() == "") {
            $("#editTeamMemberSpan").html("The Team Member Field Is Required");
            temp++;
        } else {
            $("#editTeamMemberSpan").html("");
        }
        if (temp !== 0) {
            return false;
        }
    });
</script>

<script>
    $(document).on("change", ".toggle", function() {
        var id = $(this).attr('id');
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('businessTeamMemberStatus')}}",
            data: {
                'id': id,
                '_token': token
            },
            success: function(data) {
                if (data == 1) {
                    $("#business_team_member_" + id).attr('checked', true);
                } else {
                    $("#business_team_member_" + id).attr('checked', false);
                }

            }
        });
    });
</script>

@endsection