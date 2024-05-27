<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ $module." | ".$sitesetting->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset($sitesetting->favicon) }}">

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/morris/morris.css') }}">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">

    <!--toastr-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

    <!-- Sweet Alert -->
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.css') }}" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    @yield('css')
    <!--jquery-->

</head>

<body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">
        <!-- Top Bar Start -->
        @include('admin.include.header')
        <!-- Top Bar End -->

        <!-- ========== Left Sidebar Start ========== -->
        @include('admin.include.sidebar')
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            @yield('content')

            @include('admin.include.footer')

        </div>
        <!-- End Right content here -->

    </div>
    <!-- END wrapper -->

    <!-- jQuery  -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/js/detect.js') }}"></script>
    <script src="{{ asset('assets/js/fastclick.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('assets/js/waves.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.inputmask.bundle') }}"></script>

    <!--Morris Chart-->
    <script src="{{ asset('assets/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/raphael/raphael.min.js') }}"></script>

    <!-- KNOB JS -->
    <script src="{{ asset('assets/plugins/jquery-knob/excanvas.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot-chart/jquery.flot.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot-chart/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot-chart/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot-chart/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot-chart/jquery.flot.selection.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot-chart/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot-chart/jquery.flot.crosshair.js') }}"></script>
    <script src="{{ asset('assets/pages/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom_toast.js') }}"></script>

    <!-- Sweet-Alert  -->
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/pages/sweet-alert.init.js') }}"></script>
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

    @yield('js')
</body>

</html>
