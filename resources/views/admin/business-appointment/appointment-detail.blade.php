@extends('business.layouts.app')
@section('content')
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Appointments Details</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="m-t-0 m-b-15">Booking Details</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0" id="detailsTable">
                                            <tr>
                                                <td>User Name</td>
                                                <td>{{(!empty($appointment->user->name))?$appointment->user->name:'N/A'}}</td>
                                            </tr>
                                            <tr>
                                                <td>Sub Service</td>
                                                <td>{{(!empty($appointment->subService->name))?$appointment->subService->name:'N/A'}}</td>
                                            </tr>
                                            <tr>
                                                <td>Business Sub Service</td>
                                                <td>{{(!empty($appointment->businessSubService->name))?$appointment->businessSubService->name:'N/A'}}</td>
                                            </tr>
                                            <tr>
                                                <td>Business Team Member</td>
                                                <td>{{(!empty($appointment->businessTeamMember->name))?$appointment->businessTeamMember->name:'N/A'}}</td>
                                            </tr>
                                            <tr>
                                                <td>Appointment Date</td>
                                                <td>{{(!empty($appointment->appointment_date))?date('d-m-Y',strtotime($appointment->appointment_date)):'N/A'}}</td>
                                            </tr>
                                            <tr>
                                                <td>Appointment Time</td>
                                                <td>{{(!empty($appointment->appointment_time))?date('h:i A',strtotime('01-01-2022'.$appointment->appointment_time)):'N/A'}}</td>
                                            </tr>
                                            <tr>
                                                <td>Note</td>
                                                <td>{{(!empty($appointment->note))?$appointment->note:'N/A'}}</td>
                                            </tr>
                                            <tr>
                                                <td>Appointment Status</td>
                                                @if(!empty($appointment->appointment_status))
                                                    @if($appointment->appointment_status=="Confirm")
                                                        <td><span class="badge badge-success">Confirmed</span></td>
                                                    @endif
                                                    @if($appointment->appointment_status=="Pending")
                                                        <td><span class="badge badge-warning">Pending</span></td>
                                                    @endif
                                                    @if($appointment->appointment_status=="Cancel")
                                                        <td><span class="badge badge-danger">Cancelled</span></td>
                                                    @endif
                                                    @if($appointment->appointment_status=="Complete")
                                                        <td><span class="badge badge-info">Completed</span></td>
                                                    @endif
                                                @else
                                                    <td><span class="badge badge-danger">N/A</span></td>
                                                @endif
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                                <div class="col-6">
                                    <h4 class="m-t-0 m-b-15">Payment Details</h4>
                                    <table class="table table-bordered mb-0" id="detailsTable">
                                        <tr>
                                            <td>Order Number</td>
                                            <td>{{(!empty($appointment->payment->order_number))?$appointment->payment->order_number:'N/A'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Amount</td>
                                            <td>£{{(!empty($appointment->payment->total_amount))?$appointment->payment->total_amount:'N/A'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Payment Date & Time</td>
                                            <td>{{(!empty($appointment->payment->created_at))?date('d-m-Y - h:i A',strtotime($appointment->payment->created_at)):'N/A'}}</td>
                                        </tr>
                                    </table>
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
    $('#appointmentsMenu').addClass('active');
</script>
@endsection
@endsection
