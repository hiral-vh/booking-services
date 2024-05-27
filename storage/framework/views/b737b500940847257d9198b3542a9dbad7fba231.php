 <!-- ========== Left Sidebar Start ========== -->

 <div class="left side-menu pt-4">
     <div class="sidebar-inner slimscrollleft">
         <div id="sidebar-menu">
             <ul>
                 <li class="menu-title">Main</li>

                 <li>
                     <a href="<?php echo e(route('dashboard')); ?>" class="waves-effect"><i class="ti-home"></i><span> Dashboard</span></a>
                 </li>
                 <li>
                     <a href="<?php echo e(route('admin-index')); ?>" class="waves-effect"><i class="ti-user"></i><span> Admin </span></a>
                 </li>
                 <li class="has_sub">
                     <a href="<?php echo e(route('users.index')); ?>" class="waves-effect" id="appUsersMenu"><i class="ion ion-md-contacts"></i><span>App Users</span><span class="float-right"><i class="mdi mdi-plus"></i></span></a>
                     <ul class="list-unstyled" id="app_users_menu_open">
                         <li><a href="<?php echo e(route('food-users.index')); ?>" id="restaurantUsersMenu">Restaurant Users</a></li>
                         <li><a href="<?php echo e(route('users.index')); ?>" id="businessUsersMenu">Business Users</a></li>
                     </ul>
                 </li>
                 <li class="has_sub">
                     <a href="<?php echo e(route('admin-business-owners.index')); ?>" class="waves-effect"><i class="ion ion-md-contacts"></i><span>Account Management</span><span class="float-right"><i class="mdi mdi-plus"></i></span></a>
                     <ul class="list-unstyled">
                         <li><a href="<?php echo e(route('admin-business-owners.index')); ?>" id="businessOwnersMenu">Business Owners</a></li>
                         <li><a href="<?php echo e(route('food-owners.index')); ?>" id="restaurantOwnersMenu">Restaurant Owners</a></li>
                     </ul>
                 </li>

                 <li class="has_sub">
                     <a href="<?php echo e(route('business-appointment')); ?>" class="waves-effect"><i class="ion ion-md-contacts"></i><span>Booking Management</span><span class="float-right"><i class="mdi mdi-plus"></i></span></a>
                     <ul class="list-unstyled">
                         <li><a href="<?php echo e(route('business-appointment')); ?>" id="bookingsMenu">Bookings</a></li>
                         <li><a href="<?php echo e(route('canceleappointmentlist')); ?>" id="canceledBookingsMenu">Cancelled Bookings</a></li>
                     </ul>
                 </li>
                 <li>
                     <a href="<?php echo e(route('ordermanagement')); ?>" class="waves-effect" id="orderManagementMenu"><i class="fas fa-calendar-alt"></i><span>Order Management</span></a>
                 </li>
                 <li class="has_sub">
                     <a href="<?php echo e(route('sub-services.index')); ?>" class="waves-effect" id="categoryManagementMenu"><i class="ion ion-md-contacts"></i><span>Category Management</span><span class="float-right"><i class="mdi mdi-plus"></i></span></a>
                     <ul class="list-unstyled" id="catgory_menu_open">
                   
                         <li><a href="<?php echo e(route('services.index')); ?>" id="businessServiceMenu">Business Services</a></li>
                         
                         <li><a href="<?php echo e(route('food-type.index')); ?>" id="foodTypeMenu">Food Type</a></li>
                         <li><a href="<?php echo e(route('cuisine.index')); ?>" id="cuisineMenu">Cuisine</a></li>
                       
                       
                     </ul>
                 </li>
                 
                 <li class="has_sub">
                    <a href="<?php echo e(route('admin-subscription-index','business')); ?>" class="waves-effect" id="subscriptionManagementMenu"><i class="far fa-credit-card"></i><span>Subscription</span><span class="float-right"><i class="mdi mdi-plus"></i></span></a>
                    <ul class="list-unstyled" id="subscription_menu_open">
                        <li><a href="<?php echo e(route('admin-subscription-index','business')); ?>" id="businessTypeMenu">Business</a></li>
                        <li><a href="<?php echo e(route('admin-subscription-index','restaurant')); ?>" id="businessTypeMenu">Restaurant</a></li>
                    </ul>
                </li>
                <li>
                     <a href="<?php echo e(route('admin-notification')); ?>" class="waves-effect" id="notification"><i class="fa fa-bell"></i><span>Notifications</span></a>
                 </li>
                 <li class="has_sub">
                    <a href="{route('get-bookit-report')}}" class="waves-effect" id="subscriptionManagementMenu"><i class="far fa-credit-card"></i><span>Purchase Report</span><span class="float-right"><i class="mdi mdi-plus"></i></span></a>
                    <ul class="list-unstyled" id="payment_menu_open">
                        <li><a href="<?php echo e(route('get-bookit-report')); ?>" id="bookReportMenu">Book IT</a></li>
                        <li><a href="<?php echo e(route('get-efood-report')); ?>" id="foodReportMenu">E-Food</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="<?php echo e(route('admin-video-index','business')); ?>" class="waves-effect" id="tutorialMenu"><i class="far fa-credit-card"></i><span>Video</span><span class="float-right"><i class="mdi mdi-plus"></i></span></a>
                    <ul class="list-unstyled" id="tutorial_menu">
                        <li><a href="<?php echo e(route('admin-video-index','business')); ?>" id="businessVideoMenu">Business</a></li>
                        <li><a href="<?php echo e(route('admin-video-index','restaurant')); ?>" id="foodVideoMenu">Restaurant</a></li>
                    </ul>
                </li>
                
                 <li class="menu-title mt-2">Components</li>
                 <li>
                     <a href="<?php echo e(route('site-settings')); ?>" class="waves-effect" ><i class="ti-settings"></i><span> Site Settings</span></a>
                 </li>
                 <li>
                     <a href="<?php echo e(route('cms.index')); ?>" class="waves-effect" id="cmsMenu"><i class="ti-layout"></i><span>CMS</span></a>
                 </li>
                 <li>
                     <a href="<?php echo e(route('faq.index')); ?>" class="waves-effect" id="businessFaqMenu"><i class="fas fa-question"></i><span>Business FAQS</span></a>
                 </li>
                 <li>
                    <a href="<?php echo e(route('efood-faq.index')); ?>" class="waves-effect" id="efoodFaqMenu"><i class="fas fa-question"></i><span>E Food FAQS</span></a>
                </li>
                 <li>
                     <a href="<?php echo e(route('help-and-support')); ?>" class="waves-effect"><i class="fas fa-hands-helping"></i><span>Help & Support</span></a>
                 </li>
                 <!--  <li>
                     <a href="<?php echo e(route('business-owners.index')); ?>" class="waves-effect"><i class="ion ion-md-contacts"></i><span>Business Owners</span></a>
                 </li> -->
                 <!--    <li>
                     <a href="<?php echo e(route('business-appointment')); ?>" class="waves-effect"><i class="fas fa-calendar-alt"></i><span>Booking Management</span></a>
                 </li> -->
                 <!--  <li>
                     <a href="<?php echo e(route('canceleappointmentlist')); ?>" class="waves-effect"><i class="fas fa-calendar-alt"></i><span>Canceled Booking Management</span></a>
                 </li> -->
                 <!-- <li>
                     <a href="<?php echo e(route('sub-services.index')); ?>" class="waves-effect"><i class="mdi mdi-gift-outline"></i><span> Sub Services </span></a>
                 </li> -->
                 <!--   <li>
                     <a href="<?php echo e(route('services.index')); ?>" class="waves-effect"><i class="mdi mdi-gift-outline"></i><span> Services </span></a>
                 </li>
                 <li>
                     <a href="<?php echo e(route('sub-services.create')); ?>" class="waves-effect"><i class="mdi mdi-gift-outline"></i><span> Sub Services </span></a>
                 </li> -->
             </ul>
         </div>
         <div class="clearfix"></div>
     </div>
     <!-- end sidebarinner -->
 </div>
 <!-- Left Sidebar End -->
<?php /**PATH C:\xampp\htdocs\booking-services\resources\views/admin/include/sidebar.blade.php ENDPATH**/ ?>