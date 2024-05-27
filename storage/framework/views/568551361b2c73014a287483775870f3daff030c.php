
<?php $__env->startSection('content'); ?>
<?php $__env->startSection('css'); ?>
<style>
   .cus-inputwidth .form-control{
        width: 239px;
    }
</style>
<?php $__env->stopSection(); ?>
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Order Management</h4>
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
                                    <h4 class="m-t-0 m-b-30">Order Management List</h4>
                                </div>

                                <div class="col-12 mb-3">
                                    <form class="form-inline d-inline-block cus-inputwidth" method="GET" action="<?php echo e(route('ordermanagement')); ?>">
                                        <div class="form-group">
                                            <input type="text" class="form-control mr-2 mb-2" id="userName" name="userName" placeholder="User Name" value="<?php echo e($userName); ?>">
                                            <select class="form-control mr-2 mb-2" id="order_type" name="order_type">
                                                <option value="">Select Order Type</option>
                                                <option <?php echo e(($orderType==1)?'selected':''); ?> value="1">Collection</option>
                                                <option <?php echo e(($orderType==2)?'selected':''); ?> value="2">Dine in</option>
                                                <option <?php echo e(($orderType==3)?'selected':''); ?> value="3">Delivery</option>
                                            </select>
                                            <input type="text" class="form-control mr-2 mb-2" id="order_number" name="order_number" placeholder="Order Number" value="<?php echo e($orderNumber); ?>">
                                            <select class="form-control mr-2 mb-2" id="order_status" name="order_status">
                                                <option value="">Select Order Status</option>
                                                <option <?php echo e(($orderStatus=='Accepted Order')?'selected':''); ?> value="Accepted Order">Accepted Order</option>
                                                <option <?php echo e(($orderStatus=='Delivered')?'selected':''); ?> value="Delivered">Delivered</option>
                                                <option <?php echo e(($orderStatus=='Order Confirmed')?'selected':''); ?> value="Order Confirmed">Order Confirmed</option>
                                                <option <?php echo e(($orderStatus=='Preparing your Order')?'selected':''); ?> value="Preparing your Order">Preparing your Order</option>
                                                <option <?php echo e(($orderStatus=='Rejected Order')?'selected':''); ?> value="Rejected Order">Rejected Order</option>
                                            </select>
                                            <input type="text" class="form-control mr-2 mb-2" id="delivery_charge" name="delivery_charge" placeholder="Delivery Charge" value="<?php echo e($deliveryCharge); ?>">
                                            <input type="text" class="form-control mr-2 mb-2" id="total_amount" name="total_amount" placeholder="Total Amount" value="<?php echo e($totalAmount); ?>">
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Search</button>
                                        <a href="<?php echo e(route('ordermanagement')); ?>"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Restaurant Name</th>
                                                    <th>User Name</th>
                                                    <th>Order Type</th>
                                                    <th>Order Number</th>
                                                    <th>Order Status</th>
                                                    <th>Delivery Charge</th>
                                                    <th>Total Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = ($orderManagementList->currentpage() - 1) * $orderManagementList->perpage() + 1;

                                                ?>
                                                <?php $__empty_1 = true; $__currentLoopData = $orderManagementList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr id="user_<?php echo e($value->id); ?>">
                                                    <th width="5%"><?php echo e($i); ?></th>
                                                    <td width="15%"><?php echo e((isset($value->restaurant->restaurant_name))?$value->restaurant->restaurant_name:'N/A'); ?></td>
                                                    <td width="20%"><?php echo e((isset($value->user->first_name))?$value->user->first_name:'N/A'); ?> <?php echo e((isset($value->user->last_name))?$value->user->last_name:'N/A'); ?></td>
                                                    <td width="10%">
                                                        <?php if($value->order_type == '1'): ?>
                                                            <span class="badge badge-info">Collection</span>
                                                        <?php elseif($value->order_type == '2'): ?>
                                                            <span class="badge badge-primary">Dine-in</span>
                                                        <?php elseif($value->order_type == '3'): ?>
                                                            <span class="badge badge-success">Delivery</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td width="20%"><a href="<?php echo e(route('order-details',$value->id)); ?>"><?php echo e(isset($value->order_number)?$value->order_number:'N/A'); ?></a></td>
                                                    <td width="10%">
                                                        <?php if($value->order_status == 'Delivered'): ?>
                                                            <span class="badge badge-success">Delivered</span>
                                                        <?php elseif($value->order_status == 'Order Confirmed'): ?>
                                                            <span class="badge badge-primary">Order Confirmed</span>
                                                        <?php elseif($value->order_status == 'Rejected Order'): ?>
                                                            <span class="badge badge-danger">Rejected Order</span>
                                                        <?php elseif($value->order_status == 'Preparing your Order'): ?>
                                                            <span class="badge badge-warning">Preparing your Order</span>
                                                        <?php elseif($value->order_status == 'Accepted Order'): ?>
                                                            <span class="badge badge-info">Accepted Order</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-dark">N/A</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td width="10%"><?php echo e(isset($value->delivery_charge)?$value->delivery_charge:'N/A'); ?></td>
                                                    <td width="10%"><?php echo e(isset($value->total_amount)?$value->total_amount:'N/A'); ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                                ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="7" align="center">No Order Management Available</th>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                        <?php echo e($orderManagementList->appends(request()->except('page'))->links('pagination::bootstrap-4')); ?>

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
    var success = "<?php echo e(Session::get('success')); ?>";
    var error = "<?php echo e(Session::get('error')); ?>";
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\booking-services\resources\views/admin/ordermanagement/index.blade.php ENDPATH**/ ?>