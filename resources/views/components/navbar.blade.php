<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl position-sticky blur shadow-blur mt-4 left-auto top-1 z-index-sticky"
    id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-dark" href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                    @yield('page-name', 'Dashboard')
                </li>
            </ol>
            <h6 class="font-weight-bolder mb-0">@yield('page-name', 'Dashboard')</h6>
        </nav>

        <ul class="navbar-nav justify-content-end">
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
            @php
                $admin1 = Auth::guard('admin')->user();
                $user1 = Auth::guard('web')->user();
                $role = $admin1 ? 'admin' : ($user1 ? $user1->role : null);
            @endphp
            @php
                $isAdmin = Auth::guard('admin')->check();
                $isUser = Auth::guard('web')->check();
            @endphp

            @if ($isAdmin)
                <div class="d-flex align-items-center">
                    <span class="text-dark me-2" style="font-size: 1.5rem; font-weight: 700;">Profit:</span>
                    <span id="live-earning" class="badge bg-gradient-success me-3" style="font-size: 1rem;">--</span>
                </div>
            @endif
            @if ($user)
                <li class="nav-item d-flex align-items-center">
                    <a class="nav-link text-body font-weight-bold px-0">
                        <span >
                            {{ $user->player }} — Balance: {{ $endpointValue }}
                        </span>
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
        </ul>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function fetchLiveEarning() {
            $.ajax({
                url: '/live-game-value',
                method: 'GET',
                success: function(response) {
                    if (response.earningPercentage !== undefined) {
                        $('#live-earning').text(response.earningPercentage);
                    } else {
                        $('#live-earning').text('--');
                    }
                },
                error: function() {
                    $('#live-earning').text('--');
                }
            });
        }

        // Initial call
        fetchLiveEarning();

        // Optional: Refresh every 10 seconds
        setInterval(fetchLiveEarning, 10000);
    });
</script>
