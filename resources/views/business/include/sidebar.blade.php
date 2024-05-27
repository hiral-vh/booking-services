 <!-- ========== Left Sidebar Start ========== -->



 <div class="left side-menu pt-4">

    <div class="sidebar-inner slimscrollleft">

        <div id="sidebar-menu">

            <ul>

                <li class="menu-title">Main</li>



                <li>

                    <a href="{{route('business-dashboard')}}" class="waves-effect"><i class="ti-home"></i><span> Dashboard</span></a>

                </li>

                <li class="has_sub">

                    <a href="javascript:void(0);" id="businessDetailMainMenu" class="waves-effect"><i class="fas fa-briefcase"></i> <span>Business Detail</span> <span class="float-right"><i class="mdi mdi-plus"></i></span></a>

                    <ul class="list-unstyled" style="display: none;" id="businessDetailMenu">

                      

                        {{-- <li><a href="{{ route('business-user-business-services.index')}}" id="business_services_menu">Services</a></li> --}}

                        <li><a href="{{route('sub-services.index')}}" id="businessSubServicesMenu">Business Services</a></li>

						<li><a href=" {{route('business-owner-subservices.index')}}" id="businessSubServiceMenu">Business Sub-Services</a></li>

                        <li><a href="{{route('business-team-members.index')}}" id="teamMembersMenu">Team Members</a></li>

                        <li><a href="{{ route('business-user-about-us.index')}}" id="aboutMenu">About</a></li>

                      

                        <li><a href="{{route('business-user-offers.index')}}" id="OffersMenu">Offers</a></li>

                        <li><a href="{{route('week-settings')}}" id="timingMenu">Opening Times</a></li>

                    </ul>

                   

                   

                    <li>

                        <a href="{{route('app-users')}}" class="waves-effect" id="appUsersMenu"><i class="fas fa-users"></i><span>App Users</span></a>

                    </li>

                    <li>

                        <a href="{{route('appointments')}}" class="waves-effect" id="appointmentsMenu"><i class="fas fa-calendar-alt"></i><span>Appointments</span></a>

                    </li>

                    <li>

                        <a href="{{route('business-notification')}}" class="waves-effect"><i class="fas fa-bell"></i><span>Notifications</span></a>

                    </li>

                    <li>

                        <a href="{{route('subscription-details')}}" class="waves-effect"><i class="fas fa-gift"></i><span>Subscription</span></a>

                    </li>

                    <li>

                        <a href="{{route('video-details')}}" class="waves-effect"><i class="fas fa-hands-helping"></i><span>How to Use</span></a>

                    </li>

                  

            </ul>

        </div>

        <div class="clearfix"></div>

    </div>

    <!-- end sidebarinner -->

</div>

<!-- Left Sidebar End -->

