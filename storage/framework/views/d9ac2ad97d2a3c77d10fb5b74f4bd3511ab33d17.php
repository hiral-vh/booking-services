
<?php $__env->startSection('content'); ?>

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Restaurant Users</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="m-t-0">Restaurant Users List</h4>
                                </div>
                                <div class="col-12 mb-3">
                                    <form class="form-inline" method="GET" action="<?php echo e(route('food-users.index')); ?>">
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputEmail2">Search</label>
                                            <input type="text" class="form-control mr-2" id="firstName" name="firstName" placeholder="First Name">
                                            <input type="text" class="form-control mr-2" id="lastName" name="lastName" placeholder="Last Name">
                                            <input type="text" class="form-control mr-2" id="email" name="email" placeholder="Email">
                                            <input type="text" class="form-control mr-2" id="mobile" name="mobile" placeholder="Mobile">
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-l-10">Search</button>
                                        <a href="<?php echo e(route('food-users.index')); ?>"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>
                                <div class="col-1">
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = ($list->currentpage() - 1) * $list->perpage() + 1;
                                                ?>
                                                <?php $__empty_1 = true; $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <th scope="row" width="5%"><?php echo e($i); ?></th>
                                                    <td width="20%"><?php echo e($value->first_name); ?></td>
                                                    <td width="20%"><?php echo e($value->last_name); ?></td>
                                                    <td width="30%"><?php echo e($value->email); ?></td>
                                                    <td width="20%">+(<?php echo e($value->country_code.')'.$value->mobile_no); ?></td>
                                                    <td width="5%"> <a class="btn trash-icon" href="<?php echo e(route('food-users.show',$value->id)); ?>" data-popup="tooltip" title="Show"><i class="fa fa-fw fa-eye" style="color:black"></i></a></td>
                                                </tr>
                                                <?php
                                                $i++;
                                                ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="6" align="center">No Users Available</th>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                        <?php echo e($list->appends(request()->except('page'))->links('pagination::bootstrap-4')); ?>

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
<?php $__env->startSection('js'); ?>
<script>
    $(document).ready(function(e){
        $("#restaurantUsersMenu").css('color','#fd8442');
    });

    $(document).on("change", ".toggle", function() {
        var id = $(this).attr('id');
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo e(route('businessStatus')); ?>",
            data: {
                'id': id,
                '_token': token
            },
            success: function(data) {
                if (data == 1) {
                    $("#business_" + id).attr('checked', true);
                } else {
                    $("#business_" + id).attr('checked', false);
                }

            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\booking-services\resources\views/admin/efood-users/index.blade.php ENDPATH**/ ?>