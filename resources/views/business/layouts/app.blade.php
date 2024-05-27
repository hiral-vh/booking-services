<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ $module." | ".$sitesetting->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Business Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset($sitesetting->favicon) }}">


    <link href="business/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">


    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ asset('business/plugins/morris/morris.css') }}">
    <link href="{{asset('business/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('business/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">

    <link href="{{ asset('business/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('business/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('business/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('business/css/daterangepicker.css') }}" rel="stylesheet" type="text/css">

    <!--toastr-->
    <link rel="stylesheet" href="{{ asset('business/plugins/toastr/toastr.min.css') }}">

    <!-- Sweet Alert -->
    <link href="{{ asset('business/plugins/sweetalert2/sweetalert2.css') }}" rel="stylesheet" type="text/css">
    @yield('css')
    <!--jquery-->
    {{-- <script src="{{ asset('business/js/jquery.min.js') }}"></script> --}}

</head>

<body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">
        <!-- Top Bar Start -->
        @include('business.include.header')
        <!-- Top Bar End -->

        <!-- ========== Left Sidebar Start ========== -->
        @include('business.include.sidebar')
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            @yield('content')

            @include('business.include.footer')

        </div>
        <!-- End Right content here -->

    </div>
    <!-- END wrapper -->

    <!-- jQuery  -->
    <script src="{{ asset('business/js/jquery.min.js') }}"></script>
    <script src="{{ asset('business/js/moment.min.js') }}"></script>
    <script src="{{ asset('business/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('business/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('business/js/detect.js') }}"></script>
    <script src="{{ asset('business/js/fastclick.js') }}"></script>
    <script src="{{ asset('business/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('business/js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('business/js/waves.js') }}"></script>
    <script src="{{ asset('business/js/wow.min.js') }}"></script>
    <script src="{{ asset('business/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('business/js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('business/js/daterangepicker.min.js') }}"></script>
    <script src="{{asset('business/plugins/timepicker/bootstrap-timepicker.js')}}"></script>

    <!--Morris Chart-->
    <script src=" {{ asset('business/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('business/plugins/raphael/raphael.min.js') }}"></script>

    <!-- KNOB JS -->
    <script src="{{ asset('business/plugins/jquery-knob/excanvas.js') }}"></script>
    <script src="{{ asset('business/plugins/jquery-knob/jquery.knob.js') }}"></script>
    <script src="{{ asset('business/plugins/flot-chart/jquery.flot.min.js') }}"></script>
    <script src="{{ asset('business/plugins/flot-chart/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('business/plugins/flot-chart/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('business/plugins/flot-chart/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('business/plugins/flot-chart/jquery.flot.selection.js') }}"></script>
    <script src="{{ asset('business/plugins/flot-chart/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('business/plugins/flot-chart/jquery.flot.crosshair.js') }}"></script>
    <script src="{{ asset('business/pages/dashboard.js') }}"></script>
    <script src="{{ asset('business/js/app.js') }}"></script>
    <script src="{{ asset('business/js/jquery.inputmask.bundle.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('business/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('business/js/custom_toast.js') }}"></script>

    <!-- Sweet-Alert  -->
    <script src="{{ asset('business/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('business/pages/sweet-alert.init.js') }}"></script>
    <script src="{{ asset('business/js/ckeditor.js') }}"></script>

    <!-- Required datatable js-->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>

    <script src="assets/plugins/datatables/jszip.min.js"></script>
    <script src="assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.keyTable.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.scroller.min.js"></script>

    <!-- Responsive examples -->
    <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
    <script src="{{asset('business/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="assets/pages/datatables.init.js">
    </script>

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <!-- <script src="assets/js/app.js"></script> -->

    @yield('page-js')
    

    <!-- function for open sweet-alert time of delete record -->
    <script>
        function validateFloatKeyPress(el, evt) {

            var charCode = (evt.which) ? evt.which : event.keyCode;
            var number = el.value.split('.');


            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }

            //just one dot
            if (number.length > 1 && charCode == 46) {
                return false;
            }
            //get the carat position

            var caratPos = getSelectionStart(el);
            var dotPos = el.value.indexOf(".");
            if (caratPos > dotPos && dotPos > -1 && (number[1].length > 1)) {
                return false;
            }
            //alert(number[0].length);
            return true;
        }

        function openPopup(id) {
            Swal.fire({
                title: 'Are you sure you want to delete this record?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fd8442',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $('#Deletesubmit_' + id).submit();
                } else {
                    return false;
                }
            })
        }
    </script>

    <script>
        var id = "{{Auth::guard('business_user')->user()->business_id}}";
        var firebaseConfig = {
            apiKey: "AIzaSyB5xJ-79-dh1PYZEFg1fawSbBTviQUajqI",
            authDomain: "booking-services-2ae12.firebaseapp.com",
            projectId: "booking-services-2ae12",
            storageBucket: "booking-services-2ae12.appspot.com",
            messagingSenderId: "610198799984",
            appId: "1:610198799984:web:5c83d136560225714556b5",
            measurementId: "G-CFZR5NXGEJ"
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

       // webNotifications();
        setTimeout(function(){
            notifications();
            webNotifications();
        }, 5000);

        function notifications() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{route('getNotificationsByBusinessId')}}",
                data: {
                    'business_id': id,
                },
                success: function(response) {
                    $("#notification-div").html('');
                    if (response.notifications.length >= 1) {
                        var html = '';
                        $("#notification-badge").css('display', 'flex');
                        $("#notification-count").html(response.notifications.length);
                        $("#notification-badge").html(response.notifications.length);

                        $(response.notifications).each(function(index, value) {
                            if (index > 2) {
                                return false;
                            }
                            html = '<a href="{{route("appointments-table")}}" class="dropdown-item notify-item mb-2">\
                                <div class="notify-icon bg-danger"><i class="mdi mdi-message-text-outline"></i></div>\
                                <p class="notify-details" id="notification-title">' + value.title + '<span class="text-muted" id="notification_text_' + value.id + '">' + value.message + '</span></p>\
                                </a>';

                            $("#notification-div").append(html);
                        });

                    } else {
                        $("#notification-badge").css('display', 'none');
                        $("#notification-count").html('0');
                    }
                }
            });
        }

        function clearNotification(id) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{route('clearNotificationById')}}",
                data: {
                    '_token': '{{csrf_token()}}',
                    'notification_id': id,
                },
                success: function(response) {
                    notifications();
                }
            });
        }
        
        function webNotifications()
        {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{route('getWebNotifications')}}",
                data: {
                    'business_id': id,
                },
                success: function(response) {
                  console.log('send notification');
                }
            });
        }
    </script>
    <script>
        

        function initFirebaseMessagingRegistration() {

            messaging
                .requestPermission()

                .then(function() {
                    return messaging.getToken()
                })
                .then(function(token) {
                    console.log(token);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: '{{ route("save-token") }}',
                        type: 'POST',
                        data: {
                            token: token
                        },
                        dataType: 'JSON',
                        success: function(response) {
                           // alert('Token saved successfully.');
                        },
                        error: function(err) {
                            console.log('User Chat Token Error' + err);
                        },
                    });

                }).catch(function(err) {

                    console.log('User Chat Token Error' + err);
                });
        }
        setTimeout(function(){
            messaging.onMessage(function(payload) {
            
                const noteTitle = payload.notification.title;
                const noteOptions = {
                    body: payload.notification.body,
                    icon: payload.notification.icon,
                };
                new Notification(noteTitle, noteOptions);
            });
        }, 5000);

    </script>
    @yield('js')
</body>

</html>