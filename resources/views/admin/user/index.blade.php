@extends('admin.layouts.app')
@section('css')
<style>
    .main {
        margin-top: 5px;
        padding: 0 9px;
    }

    .main>.row {
        border: 1px solid #dee2e6;
    }

    .main>.row>.col-sm-6 {
        padding: 5px;
    }
</style>
@endsection
@section('content')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Business Users</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <h4 class="m-t-0">Business Users List</h4>
                                    <a href="{{ route('users.create') }}"><button type="button" class="btn waves-effect btn-secondary" title="Add"><i class="ion ion-md-add"></i></button></a>
                                </div>
                                <div class="col-12 mb-3">
                                    <form class="form-inline" method="GET" action="{{ route('users.index') }}">
                                        <div class="form-group">
                                            <input type="text" class="form-control mr-2" id="userName" name="userName" placeholder="User Name" value="{{$userName}}">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control mr-2" id="mobile" name="mobile" placeholder="Mobile" value="{{$mobile}}">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control mr-2" id="email" name="email" placeholder="Email" value="{{$email}}">
                                        </div>

                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-l-10">Search</button>
                                        <a href="{{ route('users.index') }}"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>

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
                                                    <th>Email</th>
                                                    <!--   <th >Profile Image</th>
                                                    <th >Status</th> -->
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = ($users->currentpage() - 1) * $users->perpage() + 1;

                                                @endphp
                                                @forelse ($users as $value)
                                                <tr id="user_{{$value->id}}">
                                                    <th width="5%">{{ $i }}</th>
                                                    <td width="20%">{{isset($value->first_name)?$value->first_name:'N/A' }}
                                                        {{isset($value->last_name)?' '.$value->last_name:'N/A' }}
                                                    </td>
                                                    <td width="20%">{{ "($value->country_code)" . $value->mobile }}</td>
                                                    <td width="30%">{{ $value->email }}</td>
                                                    <td width="5%"> <a class="btn trash-icon" href="{{route('users.show',$value->id)}}" data-popup="tooltip" title="Show"><i class="fa fa-fw fa-eye" style="color:black"></i></a></td>
                                                    <!--  <td width="100px">
                                                        @if (empty($value->profile_photo_path))
                                                        <div class="col-sm-4">
                                                            <img src="{{ asset('assets/images/users/nouser.png') }}" alt="App-User-Profile-Image" class="logo-lg" style="height:100px;width:100px" id="pic">
                                                        </div>
                                                        @else
                                                        <div class="col-sm-4">
                                                            <img src="{{ asset($value->profile_photo_path) }}" alt="App-User-Profile-Image" class="logo-lg" style="height:100px;width:100px" id="pic">
                                                        </div>
                                                        @endif
                                                    </td> -->
                                                    <!--  <td width="60px">
                                                        <div class="site-toggle">
                                                            <input type="checkbox" id="{{$value->id}}" data-status="{{$value->status}}" @if($value->status ==1)
                                                            checked @endif name="toggle" class="toggle">
                                                            <div class="main-toggle">
                                                                <span class="on">On</span>
                                                                <div class="circle"></div>
                                                                <span class="off">Off</span>
                                                            </div>
                                                        </div>
                                                    </td> -->

                                                    <!--  <a href="{{ route('users.edit', $value->id) }}" class="btn create-icon" title="Edit"><i class="fa fa-fw fa-edit"></i></a>
                                                        <a class="btn trash-icon" href="javascript:;" onclick="openPopup({{ $value->id }}); " data-popup="tooltip" title="Delete"><i class="fa fa-fw fa-trash"></i></a>
                                                        <form id="Deletesubmit_{{ $value->id }}" action="{{ route('users.destroy', $value->id) }}" method="POST" class="d-none">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                        <a href="javascript:;" class="btn create-icon" title="Reset Password" data-toggle="modal" data-target="#custom-width-modal" onclick='getUserId("{{ $value->id }}")'><i class="fa fa-key"></i></a>
                                                        <a href="javascript:;" class="btn create-icon" title="User Address" data-toggle="modal" data-target="#user-address-modal" onclick='getUserId("{{ $value->id }}")'><i class="fa fa-address-card"></i></a> -->

                                                </tr>
                                                @php
                                                $i++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="8" align="center">No Users Available</th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{ $users->appends(request()->except('page'))->links('pagination::bootstrap-4')
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
<div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title m-0" id="custom-width-modalLabel">Reset Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form class="form-horizontal" id="resetPasswordForm" method="POST" action="{{ route('reset-password') }}">
                @csrf
                <input type="hidden" name="user_id" value="" id="user_id">
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-3 control-label">New Password<span class="error">*</span></label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        <span class="error" id="passwordSpan"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword4" class="col-sm-3 control-label">Confirm Password<span class="error">*</span></label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
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
<!-- User Address Modal -->
<div id="user-address-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title m-0" id="custom-width-modalLabel">User Address</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="main">
                <div class="row">
                    <div class="col-sm-6"><Strong>Address Line 1</Strong></div>
                    <div class="col-sm-6">
                        <div class="address_show"></div>
                    </div>
                    <div class="col-sm-6"><strong>Street</strong></div>
                    <div class="col-sm-6">
                        <div class="street_show"></div>
                    </div>
                    <div class="col-sm-6"><strong>City</strong></div>
                    <div class="col-sm-6">
                        <div class="city_show"></div>
                    </div>
                    <div class="col-sm-6"><strong>Post Code</strong></div>
                    <div class="col-sm-6">
                        <div class="post_code_show"></div>
                    </div>
                    <div class="col-sm-6"><strong>Mobile</strong></div>
                    <div class="col-sm-6">
                        <div class="mobile_show"></div>
                    </div>
                </div>
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
@section('js')
<script>
    function getUserId(id) {
        $('#user_id').val(id);
        $(".address_show").text("");
        $(".street_show").text("");
        $(".city_show").text("");
        $(".post_code_show").text("");
        $(".mobile_show").text("");

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('/get-user-address')}}" + "/" + id,
            success: function(data) {
                if (data.address != null) {
                    $(".address_show").text(data.address.address_line1);
                    $(".street_show").text(data.address.street);
                    $(".city_show").text(data.address.city);
                    $(".post_code_show").text(data.address.post_code);
                    $(".mobile_show").text("(" + data.address.country_code + ")" + data.address.mobile);
                } else {
                    $(".address_show").text("NA");
                    $(".street_show").text("NA");
                    $(".city_show").text("NA");
                    $(".post_code_show").text("NA");
                    $(".mobile_show").text("NA");
                }
            }
        });

    }

    $("#resetPasswordForm").submit(function(e) {

        // e.preventDefault();
        var temp = 0;
        var password = $("#password").val();
        var confirmPassword = $("#confirmPassword").val();

        if (password == "") {
            $('#passwordSpan').html('Please enter Password');
            temp++;
        } else if (password.length < 8) {
            $('#passwordSpan').html('Please enter Minimum 8 Character');
            temp++;
        } else {
            var regex = /^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/;
            if (!regex.test(password)) {
                $('#passwordSpan').html('Invalid Password Format');
                temp++;
            } else {
                $('#passwordSpan').html('');
            }
        }

        if (confirmPassword == "") {
            $('#confirmPasswordSpan').html('Please enter Confirm Password');
            temp++;
        } else if (confirmPassword !== password) {
            $('#confirmPasswordSpan').html('The Confirm Password Does Not Match');
            temp++;
        } else {
            $('#confirmPasswordSpan').html('');
        }

        if (temp !== 0) {
            return false;
        }
    });
</script>

<script>
    $(document).ready(function(e){
        $("#businessUsersMenu").css('color','#fd8442');
    });

    $(document).on("change", ".toggle", function() {
        var id = $(this).attr('id');
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('userStatus')}}",
            data: {
                'id': id,
                '_token': token
            },
            success: function(data) {
                if (data == 1) {
                    $("#user_" + id).attr('checked', true);
                } else {
                    $("#user_" + id).attr('checked', false);
                }

            }
        });
    });
</script>
@endsection
@endsection
