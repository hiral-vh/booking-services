@extends('admin.layouts.app')
@section('content')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Restaurant Owners</h4>
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
                                    <h4 class="m-t-0 m-b-30">List</h4>
                                </div>
                                <div class="col-12 mb-3">
                                    <form class="form-inline" method="GET" action="{{ route('food-owners.index') }}">
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputEmail2">Search</label>
                                            <input type="text" class="form-control mr-2" id="restaurantName" name="restaurantName" placeholder="Restaurant Name">
                                            <input type="text" class="form-control mr-2" id="ownerName" name="ownerName" placeholder="Owner Name">
                                            <input type="text" class="form-control mr-2" id="email" name="email" placeholder="Email">
                                            <input type="text" class="form-control mr-2" id="mobile" name="mobile" placeholder="Mobile">
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-l-10">Search</button>
                                        <a href="{{ route('food-owners.index') }}"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Restaurant Name</th>
                                                    <th>Owner Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = ($list->currentpage() - 1) * $list->perpage() + 1;
                                                @endphp
                                                @forelse ($list as $value)
                                                <tr>
                                                    <th scope="row" width="5%">{{ $i }}</th>
                                                    <td width="20%">{{ $value->restaurant_name }}</td>
                                                    <td width="20%">{{ $value->owner_name }}</td>
                                                    <td width="30%">{{ $value->email }}</td>
                                                    <td width="25%">{{$value->phone_no}}</td>
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
        $("#restaurantOwnersMenu").css('color','#fd8442');
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
