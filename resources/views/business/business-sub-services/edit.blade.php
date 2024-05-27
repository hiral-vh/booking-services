@extends('business.layouts.app')
@section('content')
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Business Services</h4>
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
                                        <a href="{{ route('business-owner-subservices.index') }}"><button type="button"
                                                class="btn waves-effect btn-secondary"><i
                                                    class="ion ion-md-arrow-back"></i></button></a>
                                    </div>
                                    <div class="col-12">

                                        <form method="POST"
                                            action="{{ route('business-owner-subservices.update', $subService->id) }}"
                                            id="adminEditForm" class="form-horizontal" enctype='multipart/form-data'>
                                            @csrf
                                            @method('put')
                                            <div class="form-group row">
                                                <label for="service" class="col-sm-3 control-label">Business Service<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="business_service_id"
                                                        name="business_service_id">
                                                        <option value="">Select Service</option>
                                                        @foreach ($service as $value)
                                                            <option value="{{ $value->id }}" {{($subService->sub_service_id == $value->id)?'selected':''}}>
                                                                {{ $value->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error"
                                                        id="serviceSpan">{{ $errors->admin->first('business_service_id') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-3 control-label">Name<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        value="{{ $subService->name }}" placeholder="Name" maxlength="30">
                                                    <span class="error"
                                                        id="nameSpan">{{ $errors->admin->first('name') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-3 control-label">Time(Duration)<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="time" name="time"
                                                        placeholder="Time" value="{{ $subService->time }}">
                                                    <span class="error"
                                                        id="timeSpan">{{ $errors->admin->first('name') }}</span>
                                                </div>
                                            </div>
                                            <!-- <div class="form-group row">
                                                <label for="name" class="col-sm-3 control-label">Price<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="price" name="price"
                                                        placeholder="Price" value="{{ $subService->price }}">
                                                    <span class="error"
                                                        id="priceSpan">{{ $errors->admin->first('name') }}</span>
                                                </div>
                                            </div> -->
                                            <div class="form-group row">
                                                <label for="image" class="col-sm-3 control-label">Image<span
                                                        class="error">*</span></label>
                                                <div class="col-sm-5">
                                                    <input type="file" class="form-control" id="sub_service_image" name="image"
                                                        oninput="pic.src=window.URL.createObjectURL(this.files[0])"
                                                        accept="image/png, image/jpg, image/jpeg, image/svg, image/bmp">
                                                    <span class="error"
                                                        id="imageSpan">{{ $errors->admin->first('image') }}</span>
                                                </div>
                                                @if (!empty($subService->image))
                                                    <div class="col-sm-4">
                                                        <img src="{{ asset($subService->image) }}" alt="Image"
                                                            class="logo-lg" style="height:100px;width:100px"
                                                            id="pic">
                                                    </div>
                                                @else
                                                    <div class="col-sm-4">
                                                        <img src="{{ asset('assets/images/no-image.jpg') }}" alt="Image"
                                                            class="logo-lg" style="height:100px;width:100px"
                                                            id="pic">
                                                    </div>
                                                @endif

                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <label for="team_member" class="col-sm-3 control-label pl-0">Team
                                                        Member<span class="error">*</span></label>
                                                    <select class="form-control" id="team_member" name="team_member">
                                                        <option value="">Select Team Member</option>
                                                        @forelse ($teamMembers as $teamMember)
                                                            <option value="{{ $teamMember->id }}">
                                                                {{ $teamMember->name }}</option>
                                                        @empty
                                                            <option value="">No Team Member Available</option>
                                                        @endforelse
                                                    </select>
                                                    <span class="error"
                                                        id="teamMemberSpan">{{ $errors->admin->first('team_member') }}</span>
                                                </div>
                                                <div class="col-sm-5">
                                                    <label for="name" class="col-sm-3 control-label">Price<span
                                                            class="error">*</span></label>

                                                    <input type="text" class="form-control" id="teamPrice"
                                                        name="teamPrice" placeholder="Price">
                                                    <span class="error"
                                                        id="teampriceSpan">{{ $errors->admin->first('price') }}</span>

                                                </div>
                                                <div class="col-sm-1">
                                                    <div class="pt-30">
                                                        <button type="button"
                                                            class="btn btn-primary waves-effect waves-light add_price">Add</button>
                                                    </div>

                                                </div>
                                            </div>
                                            <span style="color:red;" id="same_team_error"></span>
                                            <div class="table-responsive">
                                                <table class="table table-bordered mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Team Member</th>
                                                            <th>Price</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($subService->productTeam as $data)
                                                            <tr id="tabrow{{ $data->id }}">
                                                                <input type="hidden" name="team_member_id[]"
                                                                    value="{{ $data->teamMember->id }}">
                                                                <input type="hidden" name="team_price[]"
                                                                    value="{{ $data->price }}">
                                                                <td>{{ $data->teamMember->name }}</td>
                                                                <td>£{{ $data->price }}</td>
                                                                <td><i class="fa fa-trash" style="color:red" title="Delete"
                                                                        onclick="remove_row({{ $data->id }})"></i></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="team_hidden_value">
                                            </div>


                                            <div class="form-group m-b-0 mt-3">
                                                <div class="col-sm-9">
                                                    <button type="submit"
                                                        class="btn btn-primary waves-effect waves-light">Update</button>
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

    </div>
    <script>
        var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
    </script>
    @section('page-js')
        <script>
            $('#businessDetailMainMenu').addClass('active');
            $('#businessSubServicesMenu').addClass('active subdrop');
            $('#businessDetailMenu').css('display','block');

            var i = 0;
            $(document).ready(function() {
                $('#price').attr('maxlength','10');
                $('#teamPrice').attr('maxlength','10');
                $('#time').attr('maxlength','4');

                $('#price').on('input', function(event) {
                    this.value = this.value.replace(/[^0-9.]/g, '');
                });

                $('#time').on('input', function(event) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });

                $('#teamPrice').on('input', function(event) {
                    this.value = this.value.replace(/[^0-9.]/g, '');
                });
            });
            $('.add_price').click(function() {
                i++;
                var teamMember = $('#team_member option:selected').text();
                var teamMember_val = $('#team_member').val();
                var price = $("#teamPrice").val();
                var temp1 = 0;
                if ($("#team_member").val() == "") {
                    $("#teamMemberSpan").html("The Team Member Field Is Required");
                    temp1++;
                } else {
                    $("#teamMemberSpan").html("");
                }

                if ($("#teamPrice").val() == "") {
                    $("#teampriceSpan").html("The Price Field Is Required");
                    temp1++;
                } else {
                    $("#teampriceSpan").html("");
                }

                if (temp1 == 0) {
                    allattri = $("input[name='team_member_id[]']").map(function() {
                        return $(this).val();
                    }).get();

                    if (allattri.indexOf(teamMember_val) == -1) {
                        var del = '<i class="fa fa-trash" style="color:red" onclick="remove_row(' + i + ')" title="Delete"></i>';
                        var new_row = "<tr id='tabrow" + i + "'><td>" + teamMember + "</td><td>£" + price + "</td><td>" +
                            del + "</td></tr>";
                        var hidden_attribute = "<div id='team_hidden_value1" + i +
                            "'><input type='hidden' name='team_member_id[]' value=" + teamMember_val +
                            "><input type='hidden' name='team_price[]' value=" + price + "></div>";

                        $("table tbody").append(new_row);
                        $("#team_hidden_value").append(hidden_attribute);
                        $('#team_member').val('');
                        $('#teamPrice').val('');
                    } else {
                        $('#same_team_error').html('This Team Member is already added');
                    }
                }
                return false;

            });

            // $('#team_member').change(function() {
            //     var teamMember = $('#team_member option:selected').val();
            //     var teamMember_val = $('#team_member').val();
                
            //     $.ajax({
            //         type: "GET",
            //         dataType: "json",
            //         async: false,
            //         url:"{{ route('team-member-price') }}",
            //         data: {
            //             'teamMember': teamMember,
            //         },
            //         success: function(data) {
            //             $('#teamPrice').val(data.data.price);
            //         }
            //         });
            // });


            function remove_row(id) {
                $('#tabrow' + id).remove();
                $('#team_hidden_value1' + id).remove();
            }


            $("#adminEditForm").submit(function(e) {
                var temp = 0;

                if ($("#business_service_id").val() == "") {
                    $("#serviceSpan").html("Please select Service");
                    temp++;
                } else {
                    $("#serviceSpan").html("");
                }

                if ($("#name").val().trim() == "") {
                    $("#nameSpan").html("Please enter Name");
                    temp++;
                }else if((/[^a-zA-Z0-9 ]/).test($("#name").val()))
                {
                    $("#nameSpan").html("Special characters not allowed");
                    temp++;
                }else if($("#name").val().length > 30)
                {
                    $("#nameSpan").html("Name must not be greater than 30 character");
                    temp++;
                }
                else {
                    $("#nameSpan").html("");
                }

                if ($("#time").val() == "") {
                    $("#timeSpan").html("Please enter Time");
                    temp++;
                }else if (!($("#time").val() >= 1 && $("#time").val() <= 480) ) {
                    $("#timeSpan").html("Please enter Time between 1 To 480");
                    temp++;
                } else {
                    $("#timeSpan").html("");
                }

                if ($("#price").val() == "") {
                    $("#priceSpan").html("Please enter Price");
                    temp++;
                } else {
                    $("#priceSpan").html("");
                }

                if ($("#sub_service_image").val() != "") {
                    var imageRegex = new RegExp("(.*?)\.(jpg|png|jpeg|JPG|PNG|JPEG|svg|SVG)$");
                    if (!(imageRegex.test($("#sub_service_image").val()))) {
                        $('#imageSpan').html('File must Image!! Like: JPG, JPEG, BMP, PNG and SVG');
                        temp++;
                    } else {
                        $('#imageSpan').html('');
                    }
                }

                if (temp !== 0) {
                    return false;
                }
            });
        </script>
    @endsection
@endsection
