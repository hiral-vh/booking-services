<!-- Top Bar Start -->
<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center pt-4">
            <a href="<?php echo e(route('dashboard')); ?>" class="logo"><img src="<?php echo e(asset($sitesetting->logo)); ?>" alt="Logo" height="60"></a>
        </div>
    </div>
    <!-- Button mobile view to collapse sidebar menu -->

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="list-inline menu-left mb-0">
                <li class="float-left">
                    <button class="button-menu-mobile open-left waves-light waves-effect">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li>
            </ul>

            <ul class="nav navbar-right float-right list-inline">
                <li class="dropdown d-none d-sm-block">
                    <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light notification-icon-box"
                        data-toggle="dropdown" aria-expanded="true">
                        <i class="fa fa-bell"></i><span class="badge badge-xs badge-danger"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg">
                        <li class="text-center notifi-title">Notification <span
                                class="badge badge-xs badge-success">3</span></li>
                        <li class="list-group">
                            <!-- <a href="javascript:void(0);" class="dropdown-item notify-item mt-2">
                                <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>
                                <p class="notify-details">Your order is placed<span class="text-muted">Dummy text of
                                        the printing and typesetting industry.</span></p>
                            </a> -->
                            <!-- item-->

                            <!-- item-->
                            <!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-info"><i class="mdi mdi-glass-cocktail"></i></div>
                                <p class="notify-details">Your item is shipped<span class="text-muted">It is a long
                                        established fact that a reader will</span></p>
                            </a> -->

                            <!-- item-->
                            <?php $__currentLoopData = $notification; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="javascript:void(0);" class="dropdown-item notify-item mb-2">
                                <div class="notify-icon bg-danger"><i class="mdi mdi-message-text-outline"></i></div>
                                <p class="notify-details"><?php echo e($data->title); ?><span class="text-muted"><?php echo e($data->message); ?></span></p>
                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <!-- last list item -->
                            <a href="<?php echo e(route('admin-notification')); ?>" class="list-group-item text-center">
                                <small class="text-primary mb-0">View all </small>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="d-none d-sm-block">
                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light notification-icon-box"><i
                            class="fas fa-expand"></i></a>
                </li>

                <li class="dropdown">
                    <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown"
                        aria-expanded="true">
                        <?php if(empty(Auth::guard('admin')->user()->profile_image)): ?>
                            <img src="<?php echo e(asset('assets/images/users/nouser.png')); ?>" alt="user-img"
                                class="rounded-circle">
                        <?php else: ?>
                            <img src="<?php echo e(asset(Auth::guard('admin')->user()->profile_image)); ?>"
                                alt="user-img" class="rounded-circle">
                        <?php endif; ?>
                        <span class="profile-username">
                            <?php echo e(Auth::guard('admin')->user()->name); ?><span class="mdi mdi-chevron-down font-15"></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo e(route('admin-profile')); ?>" class="dropdown-item"> Profile</a></li>
                        <li>
                            <!-- Authentication -->
                            <form method="POST" action="<?php echo e(route('admin-logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dropdown-link','data' => ['class' => 'dropdown-item','href' => ''.e(route('admin-logout')).'','onclick' => 'event.preventDefault();
                                                this.closest(\'form\').submit();']]); ?>
<?php $component->withName('jet-dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'dropdown-item','href' => ''.e(route('admin-logout')).'','onclick' => 'event.preventDefault();
                                                this.closest(\'form\').submit();']); ?>
                                    <?php echo e(__('Log Out')); ?>

                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>
<!-- Top Bar End -->
<?php /**PATH C:\xampp\htdocs\booking-services\resources\views/admin/include/header.blade.php ENDPATH**/ ?>