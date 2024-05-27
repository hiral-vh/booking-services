
 <!-- Topbar Start -->
 <div class="navbar-custom">
     <ul class="list-unstyled topnav-menu float-right mb-0">

         <li class="dropdown notification-list">
             <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown"
                 href="#" role="button" aria-haspopup="false" aria-expanded="false">
                 @if (!empty($admin_login['photo']))
                    <img src="{{asset('upload/'.$admin_login['photo'])}}" alt="user-image" class="rounded-circle">
                @else
                    <img src="{{asset('admin/images/users/no-user.png')}}" alt="user-image" class="rounded-circle">
                 @endif
                 <span class="d-none d-sm-inline-block ml-1 font-weight-medium">{{(isset($admin_login['name']))?$admin_login['name']:'N/A'}}</span>
                 <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
             </a>
             <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                 <!-- item-->
                 <div class="dropdown-header noti-title">
                     <h6 class="text-overflow text-white m-0">Welcome !</h6>
                 </div>

                 <!-- item-->
                 <a href="{{route('profile')}}" class="dropdown-item notify-item">
                     <i class="mdi mdi-account-outline"></i>
                     <span>Profile</span>
                 </a>

                  <!-- item-->
                  <a href="{{route('change-pasword')}}" class="dropdown-item notify-item">
                    <i class="mdi mdi-key-link"></i>
                    <span>Change Password</span>
                </a>

                 <div class="dropdown-divider"></div>

                 <!-- item-->
                 <a href="{{route('logout')}}" class="dropdown-item notify-item" style="color: #91091c">
                     <i class="mdi mdi-logout-variant"></i>
                     <span><strong>Logout</strong></span>
                 </a>

             </div>
         </li>


     </ul>

     <!-- LOGO -->
     <div class="logo-box">
         <a href="{{route('login')}}" class="logo text-center logo-dark">
             <span class="logo-lg">
                 <img src="{{asset('admin/images/logo.png')}}" alt="" height="45">
                 <!-- <span class="logo-lg-text-dark">Uplon</span> -->
             </span>
             <span class="logo-sm">
                 <!-- <span class="logo-lg-text-dark">U</span> -->
                 <img src="{{asset('admin/images/logo-sm.png')}}" alt="" height="60">
             </span>
         </a>
     </div>

     <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
         <li>
             <button class="button-menu-mobile waves-effect waves-light">
                 <i class="mdi mdi-menu"></i>
             </button>
         </li>

     </ul>
 </div>
 <!-- end Topbar -->
