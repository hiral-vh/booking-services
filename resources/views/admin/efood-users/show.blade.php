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
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="m-t-0">User Details</h4>
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                                    <div class="row">

                                        <div class="col-12">
                                            <table class="table table-bordered mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Name</td>
                                                        <td>{{$user->first_name.' '.$user->last_name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email</td>
                                                        <td>{{$user->email}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mobile</td>
                                                        <td>+{{$user->country_code.' '.$user->mobile_no}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-3">
                                            <div class="card appointment-card">
                                                <div class="card-heading p-4">
                                                    <div class="appointcard-inner">
                                                        <input class="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#bb96ea" value="{{$orders}}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" />
                                                        <div class="">
                                                            <h2 class="text mb-0 sub-fonts appointcard-font" style="color:#bb96ea;">${{$orders}}</h2>
                                                            <p class=" mb-0 mt-2 appoint-text" style="color:#bb96ea;">Total Orders</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="card appointment-card">
                                                <div class="card-heading p-4">
                                                    <div class="appointcard-inner">
                                                        <input class="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#fd8442" value="{{$totalAmount}}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" />
                                                        <div class="">
                                                            <h2 class="text mb-0 sub-fonts appointcard-font" style="color:#fd8442;">${{$totalAmount}}</h2>
                                                            <p class="mb-0 mt-2 appoint-text">Total Amount</p>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div style="height: 300px"></div>
                            </div>
                            <div style="height: 300px"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div><!-- container -->

    </div> <!-- Page content Wrapper -->
</div>
<script>
    var success = "{{ Session::get('success') }}";
    var error = "{{ Session::get('error') }}";
</script>
@section('js')
<script>
    $('#appUsersMenu').addClass('active');
    $('#restaurantUsersMenu').addClass('active subdrop');
    $('#app_users_menu_open').css('display','block');
</script>
@endsection
@endsection
