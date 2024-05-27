<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo e($module.' | '.$sitesetting->title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('assets/css/icons.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('assets/css/style.css')); ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/toastr/toastr.min.css')); ?>">
</head>

<body>

    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page">
        <div class="card card-pages">

            <div class="card-body">
                <div class="text-center m-t-0 m-b-15">
                    <a href="<?php echo e(route('admin-login')); ?>" class="logo logo-admin"><img src="<?php echo e(asset($sitesetting->logo)); ?>" alt="Logo" height="100"></a>
                </div>
                <h4 class="text-muted text-center m-t-0"><b>Sign In</b></h4>
                <form method="POST" class="form-horizontal m-t-20" action="<?php echo e(route('admin-authenticate')); ?>" id="userForm">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <div class="col-12">
                            <input class="form-control" type="text"  name="email" id="email" placeholder="Email" <?php if(Cookie::has('adminuser')): ?> value="<?php echo e(Cookie::get('adminuser')); ?>" <?php else: ?> value="<?php echo e(old('email')); ?>"<?php endif; ?>>
                            <span class="error" style="margin-left:10px;" id="emailSpan"><?php echo e($errors->login->first('email')); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-12">
                            <input class="form-control" type="password" id="password" name="password" placeholder="Password" <?php if(Cookie::has('adminuser')): ?> value="<?php echo e(Cookie::get('adminpwd')); ?>" <?php endif; ?>>
                            <span class="error" style="margin-left:10px;" id="passwordSpan"><?php echo e($errors->login->first('password')); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-12">
                            <div class="flex items-center">
                                <input id="remember_me" type="checkbox" name="remember_me" value="remember_me" <?php if(Cookie::has('adminuser')): ?> checked <?php endif; ?>>
                                <label for="checkbox-signup">
                                    Remember me
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-40">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block btn-lg waves-effect waves-light" href="">Sign In</button>
                        </div>
                    </div>
                    <div class="form-group row m-t-30 m-b-0">
                        <div class="col-sm-7">
                            <a href="<?php echo e(route('admin-forgot-password')); ?>" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
    <script src="<?php echo e(asset('assets/js/app.js')); ?>"></script>

    <script>
        var success = "<?php echo e(Session::get('success')); ?>";
        var error = "<?php echo e(Session::get('error')); ?>";
    </script>

    <!-- Toastr -->
    <script src="<?php echo e(asset('assets/plugins/toastr/toastr.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/custom_toast.js')); ?>"></script>

    <script>
        $("#userForm").submit(function(e) {
            var temp = 0;
            var email=$("#email").val();
            if (email == "") {
                $('#emailSpan').html('Please enter Email');
                temp++;
            }
            else {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!regex.test(email)) {
                    $('#emailSpan').html('Please enter valid Email');
                    temp++;
                } else {
                    $('#emailSpan').html('');
                }
            }
            if ($("#password").val() == "") {
                $('#passwordSpan').html('Please enter Password');
                temp++;
            }else{
                $('#passwordSpan').html('');
            }
            if(temp !== 0 )
            {
                return false;
            }
        });
    </script>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\booking-services\resources\views/auth/login.blade.php ENDPATH**/ ?>