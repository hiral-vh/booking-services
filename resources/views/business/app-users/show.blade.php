@extends('business.layouts.app')
@section('content')

<div class="content">

    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">App Users</h4>
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
                                        <div class="col-9">
                                            <table class="table table-bordered mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Name</td>
                                                        <td>{{$appUsers->name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email</td>
                                                        <td>{{$appUsers->email}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mobile</td>
                                                        <td>{{$appUsers->country_code.' '.$appUsers->mobile}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>


                                        </div>
                                        <!-- <div class="col-3">
                                            @if(empty($appUsers->profile_photo_path))
                                                <img src="{{asset('assets/images/no-image.jpg')}}" alt="" class="view-img" onerror="this.src='{{asset('assets/images/no-image.jpg')}}'">
                                            @else
                                                <img src="{{asset($appUsers->profile_photo_path)}}" alt="" class="view-img" onerror="this.src='{{asset('assets/images/no-image.jpg')}}'">
                                            @endif
                                        </div> -->
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-3">
                                            <div class="card appointment-card">
                                                <div class="card-heading p-4">
                                                    <div class="appointcard-inner">
                                                        <input class="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#bb96ea" value="{{$appointment}}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" />
                                                        <div class="">
                                                            <p class=" mb-0 mt-2 appoint-text" style="color:#bb96ea;">Total Appointments</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="card appointment-card">
                                                <div class="card-heading p-4">
                                                    <div class="appointcard-inner">
                                                        <input class="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#fd8442" value="{{$cancelAppointment}}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" />
                                                        <div class="">
                                                            <p class="mb-0 mt-2 appoint-text">Cancel<br>Appointment</p>
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
@section('js')
<script>
    $('#appUsersMenu').addClass('active');
</script>
@endsection
@endsection
