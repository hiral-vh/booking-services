<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo e($module." | ".$sitesetting->title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <link rel="shortcut icon" href="<?php echo e(asset($sitesetting->favicon)); ?>">

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/morris/morris.css')); ?>">

    <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('assets/css/icons.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('assets/css/style.css')); ?>" rel="stylesheet" type="text/css">

    <!--toastr-->
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/toastr/toastr.min.css')); ?>">

    <!-- Sweet Alert -->
    <link href="<?php echo e(asset('assets/plugins/sweetalert2/sweetalert2.css')); ?>" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <?php echo $__env->yieldContent('css'); ?>
    <!--jquery-->

</head>

<body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">
        <!-- Top Bar Start -->
        <?php echo $__env->make('admin.include.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- Top Bar End -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php echo $__env->make('admin.include.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <?php echo $__env->yieldContent('content'); ?>

            <?php echo $__env->make('admin.include.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </div>
        <!-- End Right content here -->

    </div>
    <!-- END wrapper -->

    <!-- jQuery  -->
    <script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/modernizr.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/detect.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/fastclick.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery.slimscroll.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery.blockUI.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/waves.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery.nicescroll.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery.scrollTo.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery.inputmask.bundle')); ?>"></script>

    <!--Morris Chart-->
    <script src="<?php echo e(asset('assets/plugins/morris/morris.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/raphael/raphael.min.js')); ?>"></script>

    <!-- KNOB JS -->
    <script src="<?php echo e(asset('assets/plugins/jquery-knob/excanvas.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/jquery-knob/jquery.knob.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/flot-chart/jquery.flot.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/flot-chart/jquery.flot.tooltip.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/flot-chart/jquery.flot.resize.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/flot-chart/jquery.flot.pie.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/flot-chart/jquery.flot.selection.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/flot-chart/jquery.flot.stack.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/flot-chart/jquery.flot.crosshair.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/pages/dashboard.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/app.js')); ?>"></script>

    <!-- Toastr -->
    <script src="<?php echo e(asset('assets/plugins/toastr/toastr.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/custom_toast.js')); ?>"></script>

    <!-- Sweet-Alert  -->
    <script src="<?php echo e(asset('assets/plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/pages/sweet-alert.init.js')); ?>"></script>
    <?php echo $__env->yieldContent('page-js'); ?>

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

    <?php echo $__env->yieldContent('js'); ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\booking-services\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>