
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
            <h4 class="page-title">Cancelled Bookings</h4>
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
                                    <h4 class="m-t-0 m-b-30">Cancelled Bookings List</h4>
                                </div>
                                <div class="col-12 mb-3">
                                    <form class="form-inline d-inline-block cus-inputwidth" method="GET" action="<?php echo e(route('canceleappointmentlist')); ?>">
                                        <div class="form-group">
                                            <label class="sr-only">Search</label>
                                            <input type="text" class="form-control mr-2 mb-2" id="userName" name="userName" placeholder="Name" value="<?php echo e($userName); ?>">
                                            <input type="text" class="form-control mr-2 mb-2" id="mobile" name="mobile" placeholder="Mobile" value="<?php echo e($mobile); ?>">
                                            <?php
                                                $tempArrayBusiness=array();
                                                $tempArraySubService=array();
                                                $tempArrayBusinessSubService=array();
                                                $tempArrayBusinessTeamMember=array();
                                                $tempArrayAppointmentDate=array();
                                                $tempArrayAppointmentTime=array();
                                            ?>
                                            <select class="form-control mr-2 mb-2" id="business" name="business">
                                                <option value="">Select Business</option>
                                                <?php $__currentLoopData = $canceleAppointmentList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(isset($value->business)): ?>
                                                        <?php if(!in_array($value->business->id,$tempArrayBusiness)): ?>
                                                            <option <?php echo e(($value->business->id==$business)?'selected':''); ?> value="<?php echo e($value->business->id); ?>"><?php echo e($value->business->name); ?></option>
                                                        <?php endif; ?>
                                                        <?php
                                                            array_push($tempArrayBusiness,$value->business->id);
                                                        ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

                                            <select class="form-control mr-2 mb-2" id="sub_service" name="sub_service">
                                                <option value="">Select Sub Service</option>
                                                <?php $__currentLoopData = $canceleAppointmentList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(isset($value->subService)): ?>
                                                        <?php if(!in_array($value->subService->id,$tempArraySubService)): ?>
                                                            <option <?php echo e(($value->subService->id==$sub_service)?'selected':''); ?> value="<?php echo e($value->subService->id); ?>"><?php echo e($value->subService->name); ?></option>
                                                        <?php endif; ?>
                                                        <?php
                                                            array_push($tempArraySubService,$value->subService->id);
                                                        ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

                                            <select class="form-control mr-2 mb-2" id="business_sub_service" name="business_sub_service">
                                                <option value="">Select Business Sub Service</option>
                                                <?php $__currentLoopData = $canceleAppointmentList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(isset($value->businessSubService)): ?>
                                                        <?php if(!in_array($value->businessSubService->id,$tempArrayBusinessSubService)): ?>
                                                            <option <?php echo e(($value->businessSubService->id==$business_sub_service)?'selected':''); ?> value="<?php echo e($value->businessSubService->id); ?>"><?php echo e($value->businessSubService->name); ?></option>
                                                        <?php endif; ?>
                                                        <?php
                                                            array_push($tempArrayBusinessSubService,$value->businessSubService->id);
                                                        ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

                                            <select class="form-control mr-2 mb-2" id="business_team_member" name="business_team_member">
                                                <option value="">Select Business Team Member</option>
                                                <?php $__currentLoopData = $canceleAppointmentList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(isset($value->businessTeamMember)): ?>
                                                        <?php if(!in_array($value->businessTeamMember->id,$tempArrayBusinessTeamMember)): ?>
                                                            <option <?php echo e(($value->businessTeamMember->id==$business_team_member)?'selected':''); ?> value="<?php echo e($value->businessTeamMember->id); ?>"><?php echo e($value->businessTeamMember->name); ?></option>
                                                        <?php endif; ?>
                                                        <?php
                                                            array_push($tempArrayBusinessTeamMember,$value->businessTeamMember->id);
                                                        ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

                                            <select class="form-control mr-2 mb-2" id="appointment_date" name="appointment_date">
                                                <option value="">Select Appointment Date</option>
                                                <?php $__currentLoopData = $canceleAppointmentList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(isset($value->appointment_date)): ?>
                                                        <?php if(!in_array($value->appointment_date,$tempArrayAppointmentDate)): ?>
                                                            <option <?php echo e(($value->appointment_date==$appointment_date)?'selected':''); ?> value="<?php echo e($value->appointment_date); ?>"><?php echo e(date('d-m-Y',strtotime($value->appointment_date))); ?></option>
                                                        <?php endif; ?>
                                                        <?php
                                                            array_push($tempArrayAppointmentDate,$value->appointment_date);
                                                        ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

                                            <select class="form-control mr-2 mb-2" id="appointment_time" name="appointment_time">
                                                <option value="">Select Appointment Time</option>
                                                <?php $__currentLoopData = $canceleAppointmentList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(isset($value->appointment_time)): ?>
                                                        <?php if(!in_array($value->appointment_time,$tempArrayAppointmentTime)): ?>
                                                            <option  <?php echo e(($value->appointment_time==$appointment_time)?'selected':''); ?> value="<?php echo e($value->appointment_time); ?>"><?php echo e(date('h:i A',strtotime($value->appointment_time))); ?></option>
                                                        <?php endif; ?>
                                                        <?php
                                                            array_push($tempArrayAppointmentTime,$value->appointment_time);
                                                        ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Search</button>
                                        <a href="<?php echo e(route('business-appointment')); ?>"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Mobile</th>
                                                    <th>Business Name</th>
                                                    <th>Sub Service</th>
                                                    <th>Business Sub Service</th>
                                                    <th>Team Member</th>
                                                    <th>Appointment Date</th>
                                                    <th>Appointment Time</th>
                                                    <th>Note</th>
                                                    <!-- <th>Status</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = ($canceleAppointmentListFilter->currentpage() - 1) * $canceleAppointmentListFilter->perpage() + 1;

                                                ?>
                                                <?php $__empty_1 = true; $__currentLoopData = $canceleAppointmentListFilter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr id="user_<?php echo e($value->id); ?>">
                                                    <th width="5%"><?php echo e($i); ?></th>
                                                    <td width="10%"><?php echo e((isset($value->user->name))?$value->user->name:'N/A'); ?></td>
                                                    <td width="10%"><?php echo e((isset($value->user->mobile))?$value->user->mobile:'N/A'); ?></td>
                                                    <td width="10%"><?php echo e((isset($value->business->name))?$value->business->name:'N/A'); ?></td>
                                                    <td width="10%"><?php echo e((isset($value->subService->name))?$value->subService->name:'N/A'); ?></td>
                                                    <td width="10%"><?php echo e((isset($value->businessSubService->name))?$value->businessSubService->name:'N/A'); ?></td>
                                                    <td width="10%"><?php echo e((isset($value->businessTeamMember->name))?$value->businessTeamMember->name:'N/A'); ?></td>
                                                    <td width="10%"><?php echo e((isset($value->appointment_date))?date('d-m-Y',strtotime($value->appointment_date)):'N/A'); ?></td>
                                                    <td width="10%"><?php echo e((isset($value->appointment_time))?date('h:i A',strtotime($value->appointment_time)):'N/A'); ?></td>
                                                    <td width="10%"><?php echo e((isset($value->note))?$value->note:'N/A'); ?></td>
                                                    <!-- <td width="60px">
                                                        <div class="site-toggle">
                                                            <input type="checkbox" id="<?php echo e($value->id); ?>"
                                                                data-status="<?php echo e($value->status); ?>" title="Status" <?php if($value->status ==1): ?>
                                                            checked <?php endif; ?> name="toggle" class="toggle">
                                                            <div class="main-toggle">
                                                                <span class="on">On</span>
                                                                <div class="circle"></div>
                                                                <span class="off">Off</span>
                                                            </div>
                                                        </div>
                                                    </td> -->
                                                </tr>
                                                <?php
                                                $i++;
                                                ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="9" align="center">No Cancelled Bookings Available</th>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                        <?php echo e($canceleAppointmentListFilter->appends(request()->except('page'))->links('pagination::bootstrap-4')); ?>

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
<?php $__env->startSection('js'); ?>
<script>
     $(document).ready(function(e){
        $("#canceledBookingsMenu").css('color','#fd8442');
    });
    $(document).on("change", ".toggle", function() {
        var id=$(this).attr('id');
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo e(route('businessUserStatus')); ?>",
            data: {
                'id': id,
                '_token':token
            },
            success: function(data) {
                if(data ==1){
                    $("#user_"+id).attr('checked',true);
                }else{
                    $("#user_"+id).attr('checked',false);
                }

            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\booking-services\resources\views/admin/business-appointment/canceleappointmentlist.blade.php ENDPATH**/ ?>