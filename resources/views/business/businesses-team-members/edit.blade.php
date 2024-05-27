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
                                <div class="col-11">
                                    <h4 class="m-t-0 m-b-30">Edit</h4>
                                </div>
                                <div class="col-1">
                                    <a href="{{ route('business-team-members.index') }}"><button type="button"
                                            class="btn waves-effect btn-secondary"><i class="ion ion-md-arrow-back"
                                                title="back"></i></button></a>
                                </div>
                                    <div class="col-12">

                                        <form method="POST" action="{{route('business-team-members.update',$businessTeamMembers->id)}}" id="businessTeamMemberCreateForm" class="form-horizontal" enctype='multipart/form-data'>
                                            @csrf
                                            @method('put')
                                            <input type="hidden" value="{{ $business->id }}" id="business_id" name="business_id">
                                            <div class="form-group row">
                                                <label for="team_member" class="col-sm-3 control-label">Team Member<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="team_member"
                                                        name="team_member" placeholder="Team Member" value="{{$businessTeamMembers->name}}" maxlength="30">
                                                    <span class="error"
                                                        id="teamMemberSpan">{{ $errors->admin->first('team_member') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="phone_no" class="col-sm-3 control-label">Phone<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="phone_no" name="phone_no"
                                                        placeholder="Phone" value="{{$businessTeamMembers->phone_no}}" maxlength="10">
                                                    <span class="error"
                                                        id="phoneNoSpan">{{ $errors->admin->first('phone_no') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="email" class="col-sm-3 control-label">Email<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="email" name="email"
                                                        placeholder="Email" value="{{$businessTeamMembers->email}}" maxlength="100">
                                                    <span class="error"
                                                        id="emailSpan">{{ $errors->admin->first('email') }}</span>
                                                </div>
                                            </div>

                                            <!-- <div class="form-group row">
                                                <label for="phone_no" class="col-sm-3 control-label">Price<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="price" name="price"
                                                        placeholder="Price" value="{{$businessTeamMembers->price}}">
                                                    <span class="error"
                                                        id="priceSpan">{{ $errors->admin->first('price') }}</span>
                                                </div>
                                            </div> -->

                                            <div class="form-group m-b-0">
                                                <div class="col-sm-9">
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                                                </div>
                                            </div>
                                        </form>
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

    <script>
        var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
    </script>
@section('js')
<script>
$('#businessDetailMainMenu').addClass('active');
$('#teamMembersMenu').addClass('active subdrop');
$('#businessDetailMenu').css('display','block');

        $( document ).ready(function() {
            $("#phone_no").attr('maxlength','10');
            $('#phone_no').on('input', function (event) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });

        $("#businessTeamMemberCreateForm").submit(function(e) {
            var temp = 0;
            var email=$("#email").val();
            if ($("#team_member").val() == "") {
                $("#teamMemberSpan").html("Please enter Team Member");
                temp++;
            }else if((/[^a-zA-Z0-9 ]/).test($("#team_member").val()))
            {
                $("#teamMemberSpan").html("Special characters not allowed");
                temp++;
            }else if($("#team_member").val().length > 30)
            {
                $("#teamMemberSpan").html("Team Member must not be greater than 30 character");
                temp++;
            }
            else {
                $("#teamMemberSpan").html("");
            }

            if ($("#phone_no").val() == "") {
                $("#phoneNoSpan").html("Please enter Phone");
                temp++;
            }else if($("#phone_no").val().length != 10){
                $("#phoneNoSpan").html("Please enter valid Phone");
                temp++;
            }else {
                $("#phoneNoSpan").html("");
            }

            if (email == "") {
                temp++;
                $('#emailSpan').html("Please enter Email");
                $('#email').focus();
            }else if($("#email").val().length > 100)
            {
                $("#emailSpan").html("Email must not be greater than 100 character");
                temp++;
            }
            else {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!regex.test(email)) {
                    $('#emailSpan').html('Please enter valid Email');
                    temp++;
                } else {
                    $("#emailSpan").html("");
                }
            }

            if(temp !== 0 )
            {
                return false;
            }
        });
    </script>
@endsection
@endsection
