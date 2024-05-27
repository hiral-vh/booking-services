<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Error 404 | <?php echo e(env('APP_NAME')); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo e(asset('admin/images/favicon.png')); ?>">

        <!-- App css -->
        <link href="<?php echo e(asset('admin/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="<?php echo e(asset('admin/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('admin/css/app.min.css')); ?>" rel="stylesheet" type="text/css"  id="app-stylesheet" />

    </head>

    <body class="authentication-bg">

        <div class="account-pages pt-5 my-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="text-center">
                            <div class="text-error">4<i class="ion ion-md-sad mx-2"></i>4</div>
                            <h3 class="text-uppercase text-white">Page not Found</h3>
                            <p class="text-white mt-4">
                                It's looking like you may have taken a wrong turn. Don't worry... it happens to
                                the best of us. You might want to check your internet connection. Here's a little tip that might
                                help you get back on track.
                            </p>
                            <br>
                            <a class="btn btn-pink waves-effect waves-light" href="<?php echo e(route('login')); ?>"> Return Home</a>
                        </div>

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <!-- Vendor js -->
        <script src="<?php echo e(asset('admin/js/vendor.min.js')); ?>"></script>

        <!-- App js -->
        <script src="<?php echo e(asset('admin/js/app.min.js')); ?>"></script>

    </body>
</html>
<?php /**PATH C:\xampp\htdocs\booking-services\resources\views/errors/404.blade.php ENDPATH**/ ?>