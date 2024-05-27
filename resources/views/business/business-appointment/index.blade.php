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
                                        <select class="form-control" id="list_type" name="list_type" onchange="location = this.value;">
                                            <option selected>Calender View</option>
                                            <option value="{{route('appointments-table')}}">Table View</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div id='calendar' class="col-xl-12 col-md-9"></div>
                                                </div>
                                                <!-- end row -->
                                            </div>
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
    <div id="detailsModal" class="modal fade bs-example-modal-lg appointment-modal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="timeslotsModalLabel">Appointment Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered mb-0" id="detailsTable">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Business Name</th>
                                <th scope="col">Sub Service</th>
                                <th scope="col">Business Sub Service</th>
                                <th scope="col">Team Member</th>
                                <th scope="col">Appointment Date & Time</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div id="cancelModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
        aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="timeslotsModalLabel">Reason of Cancellation Appointment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form class="form-horizontal" id="timeSlotsForm" method="POST" action="">
                    @csrf
                    @method('post')
                    <input type="hidden" name="businessId" id="businessId">
                    <div class="form-group">
                        <label for="name" class="control-label">Reason<span class="error">*</span></label>
                        <div>
                            <input type="text" class="form-control" id="reason" name="reason" placeholder="Reason">
                            <span class="error" id="nameSpan">{{ $errors->admin->first('name') }}</span>
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
    <script>
        var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
    </script>
@section('page-js')
    <!-- Jquery-Ui -->
    <script src="{{ asset('business/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('business/plugins/fullcalendar/js/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('business/pages/calendar-init.js') }}"></script>
    <script src="{{ asset('business/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- fullcalendar -->
<script>
     $('#appointmentsMenu').addClass('active');

    $(function() {
        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date()
        var i = 0;
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()
        $('#calendar').fullCalendar({
            eventLimit: true,
            //defaultView: 'basicWeek',
            views: {
                month: {
                    eventLimit: 3, // adjust to 6 only for agendaWeek/agendaDay
                },
                week: {
                    eventLimit: 3, // adjust to 6 only for agendaWeek/agendaDay
                },
                day: {
                    eventLimit: 3, // adjust to 6 only for agendaWeek/agendaDay
                }
            },
            eventLimitText:function(args){
                return 'View All';
            },

            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            buttonText: {
                today: 'today',
                month: 'month',
                week: 'week',
                day: 'day'
            },
            displayEventTime: true,

            //Random default events
            events: function(start, end, timezone, callback) {
                jQuery.ajax({
                    url: "{{ route('list-appointments') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        start: start.format(),
                        end: end.format(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(doc) {
                        var events = [];
                        if (!!doc) {
                            $.map(doc, function(r) {
                                events.push({
                                    id: r.id,
                                    title: r.business_team_member.name+" ("+ r.business_sub_service.name +" )",
                                    start: r.appointment_date,
                                    // description: "Timing is :" + r.schedule_time,
                                    // description: r.participants,
                                    // backgroundColor: r.backgroundColor,
                                    // borderColor: r.borderColor,
                                    // SchedulenameModal: r.Tourname,
                                    // booking_date: r.schedule_time,
                                });

                            });
                        }

                        callback(events);
                    }
                });

            },

            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectHelper: true,
            select: function(start, end) {
            },

            eventClick: function(event, element) {
                var detailsDate = event.start._i;
                $('#detailsModal').modal('show');
                jQuery.ajax({
                    url: "{{ route('list-appointments-bydate') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        detailsDate: detailsDate,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $("#detailsTable tbody").html('');
                        $.each(response, function(index, val) {
                            var detailsURL = "{{ url('appointment-details')}}"+"/"+val.id;
                            var date=new Date(val.appointment_date);
                            var day = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(date);
                            var month = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(date);
                            var year = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(date);
                            var formatedDate=day+'-'+month+'-'+year;
                            var time=val.appointment_time;
                            var H = +time.substr(0, 2);
                            var h = H % 12 || 12;
                            var ampm = (H < 12 || H === 24) ? " AM" : " PM";
                            var formatedTime = h + time.substr(2, 3) + ampm;
                            i++;
                            var new_row= "<tr><td>" + i + "</td><td>" + val
                                .user.name + "</td><td>" + val.business.name +
                                "</td><td>" + val.business_sub_service.name +
                                "</td><td>" + val.sub_service.name +
                                "</td><td>" + val.business_team_member.name +
                                "</td><td>" + formatedDate + ' - ' + formatedTime +
                                "</td>";
                                if(val.appointment_status != ""){
                                    if (val.appointment_status == 'Confirm'){
                                        new_row+= "<td><span class='badge badge-success'>Confirmed</td>";
                                    }
                                    if (val.appointment_status == 'Pending'){
                                        new_row+= "<td><span class='badge badge-warning'>Pending</td>";
                                    }
                                    if (val.appointment_status == 'Cancel'){
                                        new_row+= "<td><span class='badge badge-danger'>Cancelled</td>";
                                    }
                                    if (val.appointment_status == 'Complete'){
                                        new_row+= "<td><span class='badge badge-info'>Completed</td>";
                                    }
                                }
                                else{
                                    new_row+= "<td><span class='badge badge-danger'>N/A</span></td>";
                                }
                                new_row+= "<td>";
                                if(val.appointment_status != 'Cancel' && val.appointment_status != 'Complete'){
                                new_row+= "<i class='far fa-plus-square' style='color:black' title='Change Status' id='statusChange' onclick='changeStatus(" +
                                val.id + ")' data-status="+val.appointment_status+" ></i>";
                                }
                                new_row+= " <a href='"+detailsURL+"' title='Details' class='fa fa-fw fa-eye' style='color:black'></i></a></td>";

                                new_row+= "</tr>";
                            $("#detailsTable tbody").append(new_row);
                        });

                    }
                });

            },

            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
        })
    })

    function changeStatus(id) {
        var businessId = $("#businessId").val(id);
        var appointment_id = $('#appointment_id').val(id);
        //$('#cancelModal').modal('show');
        $('#detailsModal').modal('hide');
        $('#status-modal').modal('show');
        var status = $('#statusChange').attr('data-status');
        console.log(status);
        $('#status').val(status);
        $("#reason").html('');
    }

    $('#status').on('change', function() {
    var value = $(this).val();
        if(value == 'Cancel')
        {
            $('#cancelModal').modal('show');
            $('#status-modal').modal('hide');
            $('#detailsModal').modal('hide');
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
<!-- fullcalender -->
@endsection

@endsection
