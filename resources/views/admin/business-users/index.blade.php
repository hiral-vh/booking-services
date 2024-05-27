@extends('admin.layouts.app')
@section('content')
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Business Owners</h4>
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
                                    <form class="form-inline" method="GET" action="">
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputEmail2">Search</label>
                                            <input type="text" class="form-control" id="userName" name="userName"
                                                placeholder="User Name">
                                        </div>
                                        <button type="submit"
                                            class="btn btn-primary waves-effect waves-light m-l-10">Search</button>
                                            <a href="{{route('business-owners.index')}}"><button type="button"
                                                class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>
                                <div class="col-1">
                                    <a href="{{route('business-owners.create')}}"><button type="button"
                                            class="btn waves-effect btn-secondary" title="Add"><i
                                                class="ion ion-md-add"></i></button></a>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">First Name</th>
                                                    <th scope="col">Last Name</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Profile Photo</th>
                                                    <th scope="col">Business</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = ($businessUser->currentpage() - 1) * $businessUser->perpage() + 1;

                                                @endphp
                                                @forelse ($businessUser as $value)
                                                <tr id="user_{{$value->id}}">
                                                    <th scope="row" width="70px">{{ $i }}</th>
                                                    <td>{{ $value->first_name }}</td>
                                                    <td>{{ $value->last_name }}</td>
                                                    <td>{{ $value->email }}</td>
                                                    @if(!empty($value->profile_image))
                                                    <td width="120px" align="center">
                                                        <img src="{{ asset($value->profile_image)}}"
                                                        alt="Profile Photo" class="rounded-circle img-thumbnail" style="height:70px;width:70px">
                                                    </td>
                                                    @else
                                                    <td width="110px" align="center">
                                                        <img src="{{ asset('assets/images/users/nouser.png') }}"
                                                        alt="Services" class="rounded-circle img-thumbnail" style="height:70px;width:70px">
                                                    </td>
                                                    @endif
                                                    <td>{{$value->business->name}}</td>
                                                    <td width="60px">
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
                                                    </td>
                                                    <td width="100px">
                                                        <a href="{{ route('business-owners.edit', $value->id) }}"
                                                            class="btn create-icon" title="Edit"><i
                                                                class="fa fa-fw fa-edit"></i></a>
                                                        <a class="btn trash-icon" href="javascript:;"
                                                            onclick="openPopup({{ $value->id }}); " data-popup="tooltip"
                                                            title="Delete"><i class="fa fa-fw fa-trash"></i></a>
                                                        <form id="Deletesubmit_{{ $value->id }}"
                                                            action="{{ route('business-owners.destroy', $value->id) }}"
                                                            method="POST" class="d-none">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                        <a href="javascript:;" class="btn create-icon"
                                                            title="Reset Password" data-toggle="modal"
                                                            data-target="#custom-width-modal"
                                                            onclick='getUserId("{{ $value->id }}")'><i
                                                                class="fa fa-key"></i></a>
                                                    </td>
                                                </tr>
                                                @php
                                                $i++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="8" align="center">No Business Owners Available</th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{ $businessUser->appends(request()->except('page'))->links('pagination::bootstrap-4')
                                        }}
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
<!-- Reset Password Modal -->
<div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title m-0" id="custom-width-modalLabel">Reset Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form class="form-horizontal" id="resetPasswordForm" method="POST" action="{{route('businessOwnerPwdReset')}}">
                @csrf
                <input type="hidden" name="user_id" value="" id="user_id">
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-3 control-label">New Password<span
                            class="error">*</span></label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password">
                        <span class="error" id="passwordSpan"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword4" class="col-sm-3 control-label">Confirm Password<span
                            class="error">*</span></label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                            placeholder="Confirm Password">
                        <span class="error" id="confirmPasswordSpan"></span>
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
<script>
    var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
</script>
<script>
    function getUserId(id) {
        $('#user_id').val(id);
    }

        $("#resetPasswordForm").submit(function(e) {
            var temp = 0;
            var password = $("#password").val();
            var confirmPassword = $("#confirmPassword").val();

            if (password == "") {
                $('#passwordSpan').html('Please enter Password');
                temp++;
            }else if(password.length < 8)
            {
                $('#passwordSpan').html('Please enter Minimum 8 Character');
                temp++;
            }
            else {
                var regex = /^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/;
                if (!regex.test(password)) {
                    $('#passwordSpan').html('Invalid Password Format');
                    temp++;
                }
                else
                {
                    $('#passwordSpan').html('');
                }
            }

            if (confirmPassword == "") {
                $('#confirmPasswordSpan').html('Please enter Confirm Password');
                temp++;
            }else if(confirmPassword !== password)
            {
                $('#confirmPasswordSpan').html('Confirm Password Does Not Match');
                temp++;
            }else{
                $('#confirmPasswordSpan').html('');
            }

            if (temp !== 0) {
                return false;
            }
        });
</script>

<script>
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
