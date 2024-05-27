<!-- Top Bar Start -->
<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center pt-4">
            <a href="{{route('dashboard')}}" class="logo"><img src="{{ asset($sitesetting->logo) }}" alt="Logo" height="60"></a>
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
                            @foreach($notification as $data)
                            <a href="javascript:void(0);" class="dropdown-item notify-item mb-2">
                                <div class="notify-icon bg-danger"><i class="mdi mdi-message-text-outline"></i></div>
                                <p class="notify-details">{{$data->title}}<span class="text-muted">{{$data->message}}</span></p>
                            </a>
                            @endforeach
                            <!-- last list item -->
                            <a href="{{route('admin-notification')}}" class="list-group-item text-center">
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
                        @if (empty(Auth::guard('admin')->user()->profile_image))
                            <img src="{{ asset('assets/images/users/nouser.png') }}" alt="user-img"
                                class="rounded-circle">
                        @else
                            <img src="{{ asset(Auth::guard('admin')->user()->profile_image) }}"
                                alt="user-img" class="rounded-circle">
                        @endif
                        <span class="profile-username">
                            {{ Auth::guard('admin')->user()->name }}<span class="mdi mdi-chevron-down font-15"></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('admin-profile')}}" class="dropdown-item"> Profile</a></li>
                        <li>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('admin-logout') }}">
                                @csrf
                                <x-jet-dropdown-link class="dropdown-item" href="{{ route('admin-logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>
<!-- Top Bar End -->
