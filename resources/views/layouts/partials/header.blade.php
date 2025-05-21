<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <div class="navbar-brand-box">
                <a href="" class="logo logo-dark">
                    <span class="logo-lg">
                    <span class="logo-lg-text-light" style="font-size: 22px;">CRS</span>
                    </span>
                </a>

                <a href="" class="logo logo-light">
                    <span class="logo-sm">
                    </span>
                    <span class="logo-lg">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>



            <div class="dropdown dropdown-mega d-none d-lg-block ms-2">
                <button type="button" class="btn header-item">
                    <span key="t-megamenu">CRS</span>
                </button>

            </div>
        </div>

        <div class="d-flex">


            <div class="dropdown d-inline-block">


            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>

                       @php
                $unreadNotifications = Auth::user()->unreadNotifications ?? collect();
            @endphp
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" id="notificationDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-bell-outline"></i>
                    @if($unreadNotifications->count() > 0)
                        <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">{{ $unreadNotifications->count() }}</span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="min-width: 300px; max-height: 250px; overflow-y: auto;">
                    <span class="dropdown-header">Notifications</span>
                    <div style="max-height: 100px; overflow-y: auto;">
                        @forelse($unreadNotifications as $notification)
                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    {{ $notification->data['message'] }}<br>
                                    <small>{{ $notification->data['user_name'] }} ({{ $notification->data['user_email'] }})</small>
                                </button>
                            </form>
                        @empty
                            <span class="dropdown-item">No new notifications</span>
                        @endforelse
                    </div>
                    <div class="d-flex justify-content-between align-items-center px-2 py-1 border-top" style="background: #f8f9fa;">
                        <form method="POST" action="{{ route('notifications.markAllRead') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0" style="font-size: 13px;">Mark all as read</button>
                        </form>
                        <a href="{{ route('notifications.page') }}" class="btn btn-link p-0 m-0" style="font-size: 13px;">View all</a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if(Auth::user()->profile_picture)
                    <img class="rounded-circle header-profile-user" src="{{asset('assets/images/profile/'.Auth::user()->profile_picture)}}" alt="Header Avatar">
                    @else
                    <img class="rounded-circle header-profile-user" src="{{asset('assets/images/users/avatar-1.jpg')}}" alt="Header Avatar">
                    @endif

                    <span class="d-none d-xl-inline-block ms-1" key="t-henry"> {{ Auth::user()->name }} </span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('profile') }}"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('user.logout') }}"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                </div>
            </div>

 
        </div>
    </div>
  </div>
</header>

