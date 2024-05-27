
<?php $__env->startSection('content'); ?>

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Admin</h4>
            </div>
        </div>
        <div class="page-content-wrapper ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                <div class="col-10">
                                    <h4 class="m-t-0 m-b-30">List</h4>
                                </div>
                                <div class="col-2" align="right">
                                    <a href="<?php echo e(route('admin-create')); ?>" title="Add"><button type="button" class="btn waves-effect btn-secondary">Add <i class="ion ion-md-add"></i></button></a>
                                </div>
                                <div class="col-10 mb-3">
                                    <form class="form-inline" method="GET" action="">
                                        <div class="form-group">
                                            <input type="text" class="form-control mr-2" id="name" name="name" placeholder="Name">
                                            <input type="text" class="form-control mr-2" id="email" name="email" placeholder="Email">
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-l-10">Search</button>
                                        <a href="<?php echo e(route('admin-index')); ?>"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                              <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Image</th>
                                                
                                                <th scope="col">Action</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $i = ($admin->currentpage() - 1) * $admin->perpage() + 1;
                                                ?>
                                                <?php $__empty_1 = true; $__currentLoopData = $admin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr id="admin_<?php echo e($value->id); ?>">
                                                    <th scope="row" width="100px"><?php echo e($i); ?></th>
                                                    <td width="300px"><?php echo e($value->name); ?></td>
                                                    <td width="400px"><?php echo e($value->email); ?></td>
                                                    <?php if(!empty($value->profile_image)): ?>
                                                    <td width="100px">
                                                        <img src="<?php echo e(asset($value->profile_image)); ?>"
                                                        alt="Admin" class="rounded-circle img-thumbnail" style="height:70px;width:70px">
                                                    </td>
                                                    <?php else: ?>
                                                    <td width="100px">
                                                        <img src="<?php echo e(asset('assets/images/users/nouser.png')); ?>"
                                                        alt="Admin" class="rounded-circle img-thumbnail" style="height:70px;width:70px">
                                                    </td>
                                                    <?php endif; ?>
                                                    <td width="80px">
                                                        <a href="<?php echo e(route('admin-edit', $value->id)); ?>" class="btn create-icon"><i
                                                            class="fa fa-fw fa-edit" title="Edit"></i></a>
                                                    <a class="btn trash-icon" href="javascript:;"
                                                        onclick="openPopup(<?php echo e($value->id); ?>); " data-popup="tooltip"
                                                        title="Delete"><i class="fa fa-fw fa-trash"></i></a>
                                                    <form id="Deletesubmit_<?php echo e($value->id); ?>"
                                                        action="<?php echo e(route('admin-delete', $value->id)); ?>"
                                                        method="POST" class="d-none">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('delete'); ?>
                                                    </form>
                                                    </td>
                                                </tr>
                                                <?php
                                                    $i++;
                                                ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="6" align="center">No Admin Available</th>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                          </table>
                                          <?php echo e($admin->appends(request()->except('page'))->links("pagination::bootstrap-4")); ?>

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
    <!-- Page content Wrapper -->

    </div>
    <script>
        var success = "<?php echo e(Session::get('success')); ?>";
        var error = "<?php echo e(Session::get('error')); ?>";
    </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\booking-services\resources\views/admin/admin/index.blade.php ENDPATH**/ ?>