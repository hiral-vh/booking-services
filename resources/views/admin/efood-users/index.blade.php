@extends('admin.layouts.app')
@section('content')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Restaurant Users</h4>
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
                                    <h4 class="m-t-0">Restaurant Users List</h4>
                                </div>
                                <div class="col-12 mb-3">
                                    <form class="form-inline" method="GET" action="{{ route('food-users.index') }}">
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputEmail2">Search</label>
                                            <input type="text" class="form-control mr-2" id="firstName" name="firstName" placeholder="First Name">
                                            <input type="text" class="form-control mr-2" id="lastName" name="lastName" placeholder="Last Name">
                                            <input type="text" class="form-control mr-2" id="email" name="email" placeholder="Email">
                                            <input type="text" class="form-control mr-2" id="mobile" name="mobile" placeholder="Mobile">
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-l-10">Search</button>
                                        <a href="{{ route('food-users.index') }}"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>
                                <div class="col-1">
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = ($list->currentpage() - 1) * $list->perpage() + 1;
                                                @endphp
                                                @forelse ($list as $value)
                                                <tr>
                                                    <th scope="row" width="5%">{{ $i }}</th>
                                                    <td width="20%">{{ $value->first_name }}</td>
                                                    <td width="20%">{{ $value->last_name }}</td>
                                                    <td width="30%">{{ $value->email }}</td>
                                                    <td width="20%">+({{$value->country_code.')'.$value->mobile_no}}</td>
                                                    <td width="5%"> <a class="btn trash-icon" href="{{route('food-users.show',$value->id)}}" data-popup="tooltip" title="Show"><i class="fa fa-fw fa-eye" style="color:black"></i></a></td>
                                                </tr>
                                                @php
                                                $i++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="6" align="center">No Users Available</th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{ $list->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
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
<script>
    var success = "{{ Session::get('success') }}";
    var error = "{{ Session::get('error') }}";
</script>
@section('js')
<script>
    $(document).ready(function(e){
        $("#restaurantUsersMenu").css('color','#fd8442');
    });

    $(document).on("change", ".toggle", function() {
        var id = $(this).attr('id');
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('businessStatus') }}",
            data: {
                'id': id,
                '_token': token
            },
            success: function(data) {
                if (data == 1) {
                    $("#business_" + id).attr('checked', true);
                } else {
                    $("#business_" + id).attr('checked', false);
                }

            }
        });
    });
</script>
@endsection
@endsection
