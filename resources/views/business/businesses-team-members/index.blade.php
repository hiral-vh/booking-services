@extends('business.layouts.app')
@section('content')
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Team Members</h4>
        </div>
    </div>
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-1">
                                    <h4 class="m-t-0 m-b-30">List</h4>
                                </div>
                                <div class="col-10">
                                    <form class="form-inline" method="GET">
                                        <div class="form-group">
                                            <select class="form-control mr-2" id="team_member" name="team_member">
                                                <option value="">Select Team Member</option>
                                                @foreach ($listBusinessTeamMembers as $value)
                                                    <option {{($value->id==$teamMember)?'selected':''}} value="{{$value->id}}">{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" class="form-control mr-2" id="phone" name="phone" placeholder="Phone" value="{{$phone}}">
                                            <input type="text" class="form-control mr-2" id="email" name="email" placeholder="Email" value="{{$email}}">
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-l-10">Search</button>
                                        <a href="{{ route('business-team-members.index') }}"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>
                                <div class="col-1 pl-0" align="right">
                                    <a href="{{route('business-team-members.create')}}"><button type="button" class="btn waves-effect btn-secondary">Add <i class="ion ion-md-add"></i></button></a>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Team Member</th>
                                                    <th scope="col">Phone</th>
                                                    <th scope="col">Email</th>
                                                    {{-- <th scope="col">Status</th> --}}
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
                                                    <td width="250px">{{ (isset($value->name)?$value->name:'N/A') }}</td>
                                                    <td width="250px">{{ (isset($value->phone_no)?$value->phone_no:'N/A') }}</td>
                                                    <td width="250px">{{ (isset($value->email)?$value->email:'N/A') }}</td>
                                                    {{-- <td width="60px">
                                                        <div class="site-toggle">
                                                            <input type="checkbox" id="{{ $value->id }}" data-status="{{ $value->status }}" @if ($value->status == 1)
                                                            checked @endif name="toggle" class="toggle">
                                                            <div class="main-toggle">
                                                                <span class="on">On</span>
                                                                <div class="circle"></div>
                                                                <span class="off">Off</span>
                                                            </div>
                                                        </div>
                                                    </td> --}}
                                                    <td width="100px">
                                                        <a href="{{route('business-team-members.edit',$value->id)}}" class="btn create-icon"><i class="fa fa-fw fa-edit" title="Edit"></i></a>

                                                        <a class="btn trash-icon" href="javascript:;" onclick="openPopup({{ $value->id }}); " data-popup="tooltip" title="Delete"><i class="fa fa-fw fa-trash"></i></a>
                                                        <form id="Deletesubmit_{{ $value->id }}" action="{{ route('business-team-members.destroy', $value->id) }}" method="POST" class="d-none">
                                                            @csrf
                                                            @method('delete')
                                                            <input type="hidden" name="business_id" id="business_id" value="{{ $business->id }}">
                                                        </form>

                                                        <a href="{{route('time-slot',$value->id)}}" title="Time Slot" class="btn create-icon"><i class="fa fa-fw fa-clock"></i></a>
                                                    </td>
                                                </tr>
                                                @php
                                                $i++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="8" align="center">No Team Member Available</th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $businessTeamMembers->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
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
    $('#businessDetailMainMenu').addClass('active');
    $('#teamMembersMenu').addClass('active subdrop');
    $('#businessDetailMenu').css('display','block');

    $(document).on("change", ".toggle", function() {
        var id = $(this).attr('id');
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('businessUserTeamMemberStatus')}}",
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
@endsection
