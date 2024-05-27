@extends('business.layouts.app')
@section('css')
    <!--calendar css-->
    <link href="{{asset('assets/plugins/fullcalendar/css/fullcalendar.min.css')}}" rel="stylesheet" />
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
                                <div class="col-1">
                                    <h4 class="m-t-0 m-b-30">List</h4>
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
<script>
    var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
</script>
@section('page-js')
 <!-- Jquery-Ui -->
 <script src="{{asset('business/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
 <script src="{{asset('business/plugins/moment/moment.js')}}"></script>
 <script src="{{asset('business/plugins/fullcalendar/js/fullcalendar.min.js')}}"></script>
 <script src="{{asset('business/pages/calendar-init.js')}}"></script>
@endsection

<script>
    $(document).ready(function(e){

    });
</script>
<!-- fullcalendar -->
<script>
    $(function() {
        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()
        $('#calendar').fullCalendar({
            eventLimit: true,
            /*defaultView: 'basicWeek',*/

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
            displayEventTime: false,

            //Random default events
            events: function(start, end, timezone, callback) {
                jQuery.ajax({
                    url: "{{route('list-appointments')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        start: start.format(),
                        end: end.format(),
                        _token: "{{csrf_token()}}"
                    },
                    success: function(doc) {
                        var events = [];
                        console.log(doc);
                        if (!!doc) {
                            $.map(doc, function(r) {
                                console.log(r);
                                events.push({
                                    id: r.id,
                                    title: "Booking",
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
                // Display the modal and set the values to the event values.
                // getDataList(event.id);
                // $('.modal').modal('show');
                // $('#particular').html(event.description);
                // $('#booking_date').html(event.booking_date);
                //window.location.href = "{{  URL::to('/') }}/reservation_details/" + event.id;
                // $('#tour_name').html(event.SchedulenameModal);
                //var link_html = '<a target="_blank" href="{{  URL::to("/") }}/booking_details/' + event.id + '" class="btn btn-sm btn-primary">View Booking Details</a>';
                // $('#tour_link').html(link_html);
            },

            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
        })
    })
</script>
<!-- fullcalender -->
@endsection
