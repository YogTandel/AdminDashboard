<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl position-sticky blur shadow-blur mt-4 left-auto top-1 z-index-sticky"
    id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-dark" href="javascript:;">Pages</a>
                </li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                    @yield('page-name', 'Dashboard')
                </li>
            </ol>
            <h6 class="font-weight-bolder mb-0">@yield('page-name', 'Dashboard')</h6>
        </nav>

        <ul class="navbar-nav justify-content-end">
            {{-- Display logged-in user info --}}
            @php
                $user = null;
                $endpointType = '';
                $endpointValue = '';

                if (Auth::guard('admin')->check()) {
                    $user = Auth::guard('admin')->user();
                    $endpointType = 'Admin';
                    $endpointValue = $user->endpoint ?? 'N/A';
                } elseif (Auth::guard('web')->check()) {
                    $user = Auth::guard('web')->user();
                    $endpointType = 'Agent';
                    $endpointValue = $user->endpoint ?? 'N/A';
                }
            @endphp

                <div class="d-flex align-items-center">
                    <span class="text-dark me-2" style="font-size: 1.5rem; font-weight: 700;">Profit:</span>
                    <span id="live-earning" class="badge bg-gradient-success me-3" style="font-size: 1rem;">--</span>
                </div>
            @if ($user)
                <li class="nav-item d-flex align-items-center">
                    <a class="nav-link text-body font-weight-bold px-0">
                        <i class="ps-3 fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">
                            {{ $user->player }} — endpoint: {{ $endpointValue }}
                        </span>
                    </a>
                </li>
            @endif


            {{-- Logout button --}}
            @php
                $isAdmin = Auth::guard('admin')->check();
                $isUser = Auth::guard('web')->check();
            @endphp

            @if ($isAdmin || $isUser)
                <li class="nav-item d-flex align-items-center">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link text-body font-weight-bold px-0 bg-transparent border-0">
                            <i class="ps-3 fas fa-sign-out-alt me-sm-1"></i>
                        </button>
                    </form>
                </li>
            @else
                <li class="nav-item d-flex align-items-center">
                    <a href="{{ route('show.login') }}" class="nav-link text-body font-weight-bold px-0">
                        <i class="ps-3 fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">Login</span>
                    </a>
                </li>
            @endif

            {{-- Toggle for mobile --}}
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </a>
            </li>

            {{-- Notifications --}}
            <li class="nav-item dropdown px-2 pe-2 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fa fa-bell cursor-pointer"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                    <li class="mb-2">
                        <a class="dropdown-item border-radius-md" href="javascript:;">
                            <div class="d-flex py-1">
                                <div class="my-auto">
                                    <img src="/assets/img/team-2.jpg" class="avatar avatar-sm me-3">
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="text-sm font-weight-normal mb-1">
                                        <span class="font-weight-bold">New message</span> from Laur
                                    </h6>
                                    <p class="text-xs text-secondary mb-0">
                                        <i class="fa fa-clock me-1"></i>
                                        13 minutes ago
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a class="dropdown-item border-radius-md" href="javascript:;">
                            <div class="d-flex py-1">
                                <div class="my-auto">
                                    <img src="/assets/img/small-logos/logo-spotify.svg"
                                        class="avatar avatar-sm bg-gradient-dark me-3">
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="text-sm font-weight-normal mb-1">
                                        <span class="font-weight-bold">New album</span> by Travis Scott
                                    </h6>
                                    <p class="text-xs text-secondary mb-0">
                                        <i class="fa fa-clock me-1"></i>
                                        1 day
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item border-radius-md" href="javascript:;">
                            <div class="d-flex py-1">
                                <div class="avatar avatar-sm bg-gradient-secondary me-3 my-auto">
                                    <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <title>credit-card</title>
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF"
                                                fill-rule="nonzero">
                                                <g transform="translate(1716.000000, 291.000000)">
                                                    <g transform="translate(453.000000, 454.000000)">
                                                        <path class="color-background"
                                                            d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                                            opacity="0.593633743"></path>
                                                        <path class="color-background"
                                                            d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                                        </path>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="text-sm font-weight-normal mb-1">
                                        Payment successfully completed
                                    </h6>
                                    <p class="text-xs text-secondary mb-0">
                                        <i class="fa fa-clock me-1"></i>
                                        2 days
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>