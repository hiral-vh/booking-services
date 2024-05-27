<!-- Top Bar Start -->
<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center pt-4">
            <a href="{{route('business-dashboard')}}" class="logo"><img src="{{ asset($sitesetting->logo) }}" alt="Logo" height="60"></a>
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
                    <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light notification-icon-box" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-bell"></i> <span class="badge badge-xs badge-primary notification-badge1" id="notification-badge" style="display:none"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg">
                        <li class="text-center notifi-title">Notification <span class="badge badge-xs badge-success" id="notification-count">0</span></li>
                        <li class="list-group">
                            <!-- item-->
                            <div id='notification-div'>

                            </div>
                            <!-- last list item -->
                            <a href="{{route('business-notification')}}" class="list-group-item text-center">
                                <small class="text-primary mb-0">View all </small>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown"
                        aria-expanded="true">
                        @if (empty(Auth::guard('business_user')->user()->profile_image))
                            <img src="{{ asset('business/images/users/nouser.png') }}" alt="user-img"
                                class="rounded-circle">
                        @else
                            <img src="{{ asset(Auth::guard('business_user')->user()->profile_image)}}"
                                alt="user-img" class="rounded-circle">
                        @endif
                        <span class="profile-username">
                            {{ Auth::guard('business_user')->user()->name }}<span class="mdi mdi-chevron-down font-15"></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('business-profile')}}" class="dropdown-item"> Profile</a></li>
                        <li>

                            <form method="POST" action="{{ route('business-logout') }}" class="logout-padding">
                                @csrf
                                <a class="dropdown-item" href="{{ route('business-logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    Logout
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>
<!-- Top Bar End -->
