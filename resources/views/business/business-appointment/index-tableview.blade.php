@extends('business.layouts.app')
@section('css')
    <!--calendar css-->
    <link href="{{ asset('assets/plugins/fullcalendar/css/fullcalendar.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Appointments</h4>
            </div>
        </div>
        {{-- {{dd($businessAppointment)}} --}}
        <div class="page-content-wrapper ">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <h4 class="m-t-0 m-b-30">List</h4>
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="list_type" name="list_type"
                                            onchange="location = this.value;">
                                            <option selected>Table View</option>
                                            <option value="{{ route('appointments') }}">Calender View</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">User Name</th>
                                                        <th scope="col">Sub Service</th>
                                                        <th scope="col">Business Sub Service</th>
                                                        <th scope="col">Team Member</th>
                                                        <th scope="col">Appointment Date & Time</th>
                                                        <th scope="col">Note</th>
                                                        <th scope="col">Price(£)</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = ($appointment->currentpage() - 1) * $appointment->perpage() + 1;
                                                    @endphp
                                                
                                                    @forelse ($appointment as $value)
                                                  
                                                        <tr>
                                                            <td width="70px">{{ $i }}</td>
                                                            <td width="100px">
                                                                {{ !empty($value->user) ? $value->user->name : 'N/A' }}</td>
                                                            <td width="100px">
                                                                {{ !empty($value->subService) ? $value->subService->name : 'N/A' }}
                                                            </td>
                                                            <td width="100px">
                                                                {{ !empty($value->businessSubService) ? $value->businessSubService->name : 'N/A' }}
                                                            </td>
                                                            <td width="100px">
                                                                {{ !empty($value->businessTeamMember) ? $value->businessTeamMember->name : 'N/A' }}
                                                            </td>
                                                            <td width="100px">
                                                                {{ !empty($value->appointment_date)? date('d-m-Y - h:i A', strtotime($value->appointment_date . $value->appointment_time)): 'N/A' }}
                                                            </td>
                                                            <td width="150px">
                                                                {{ !empty($value->note) ? $value->note : 'N/A' }}</td>
                                                            <td width="100px">                                                                
                                                            £{{(!empty($value->appointmentPayment->total_amount))?$value->appointmentPayment->total_amount:'N/A'}}
                                                            </td>
                                                                @if (!empty($value->appointment_status))
                                                                    @if ($value->appointment_status == 'Confirm')
                                                                        <td width="60px"><span class="badge badge-success">Confirmed</span></td>
                                                                    @endif
                                                                    @if ($value->appointment_status == 'Pending')
                                                                        <td width="60px"><span class="badge badge-warning">Pending</span></td>
                                                                    @endif
                                                                    @if ($value->appointment_status == 'Cancel')
                                                                        <td width="60px"><span class="badge badge-danger">Cancelled</span></td>
                                                                    @endif
                                                                    @if ($value->appointment_status == 'Complete')
                                                                        <td width="60px"><span class="badge badge-info">Completed</span></td>
                                                                    @endif
                                                            @else
                                                                <td width="60px"><span class="badge badge-danger">N/A</span></td>
                                                            @endif
                                                            <td width="60px"><a
                                                            href="{{ route('appointment-details', $value->id) }}"><i
                                                                class="fa fa-fw fa-eye" style="color:black;font-size: 18px"
                                                                title="Details"></i></a>
                                                                @if($value->appointment_status != 'Cancel' && $value->appointment_status != 'Complete')
                                                                <a href="javascript:void(0);"><i
                                                                class="far fa-plus-square" style="color:black;font-size: 18px"
                                                                title="Change Status" data-toggle="modal" data-target='#status-modal' onclick="getStatus('{{$value->id}}','{{$value->appointment_status}}')">
                                                                </i></a>@endif</td>
                                                    </tr>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @empty
                                                    <tr>
                                                        <td colspan="10" align="center">No Appointment Available</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
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
<div id="status-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="status-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title m-0" id="status-modalLabel">Update Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form class="form-horizontal" id="changeStatusForm" method="POST" action="{{route('update-appointment-status')}}">
                @csrf
                <input type="hidden" name="appointment_id" id="appointment_id" value="">
                <input type="hidden" name="appointment_status" id="appointment_status" value="">

                <div class="form-group row mt-4 mb-4">
                    <label for="edit_team_member" class="col-sm-3 control-label">Status<span class="error">*</span></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="status" name="status">
                            <option value="">Select Status</option>
                            <option value="Pending" disabled>Pending</option>
                            <option value="Confirm">Confirmed</option>
                            <option value="Cancel" class="cancelModal">Cancelled</option>
                            <option value="Complete">Completed</option>
                        </select>
                        <span class="error" id="statusSpan"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="statusSave">Save</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div id="cancelModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
        aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="timeslotsModalLabel">Reason of Cancellation Appointment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form class="form-horizontal" id="cancelForm" method="POST" action="">
                    @csrf
                    @method('post')
                    <input type="hidden" name="businessId" id="businessId">
                    <div class="form-group">
                        <label for="name" class="control-label">Reason<span class="error">*</span></label>
                        <div>
                            <input type="text" class="form-control" id="reason" name="reason" placeholder="Reason">
                            <span class="error" id="reasonSpan"></span>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light reasonSave">Save</button>
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
</div>
    <script>
        var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
    </script>
    @section('js')
    <script>
        $('#appointmentsMenu').addClass('active');

        function getStatus(id,status)
        {
            $('#appointment_id').val(id);
            $('#appointment_status').val(status);
            $('#status').val(status);

        }

        $('#status').on('change', function() {
        var value = $(this).val();
            if(value == 'Cancel')
            {
                $('#cancelModal').modal('show');
                $('#status-modal').modal('hide');
            }
        });

        $('#changeStatusForm').submit(function(e){
            var temp = 0;
            if ($("#status").val() == "") {
                $("#statusSpan").html("Please select Status");
                temp++;
            } else {
                $("#statusSpan").html("");
            }
            if (temp !== 0) {
                return false;
            }
        });

        $(".reasonSave").click(function(e) {
        var reason = $("#reason").val();
        var id = $("#appointment_id").val();
        $('#statusSave').prop('disabled','true');
        var temp = 0;
            
        if(reason.trim() == '')
        {
            $('#reasonSpan').html('Please enter Reason');   
            temp++;
        }
        else
        {   
            $('#reasonSpan').html('');   
        }
        if (temp !== 0) 
        {
            return false;
        }
        else{

            jQuery.ajax({
                url: "{{ route('appointment-status-change') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    reason: reason,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#detailsModal').modal('hide');
                    $('#cancelModal').modal('hide');
                    window.location.reload();
                    toastr.success('Appointment successfully cancelled', {timeOut: 5000});
                }
            });
        }
        });

    </script>
    @endsection
@endsection
