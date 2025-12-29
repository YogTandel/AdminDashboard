<nav
    class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl position-sticky blur shadow-blur mt-4 left-auto top-1 z-index-sticky"
    id="navbarBlur" navbar-scroll="true">

    <div class="container-fluid py-1 px-3">

        {{-- LEFT: Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-dark" href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                    @yield('page-name', 'Dashboard')
                </li>
            </ol>
            <h6 class="font-weight-bolder mb-0">
                @yield('page-name', 'Dashboard')
            </h6>
        </nav>

        {{-- RIGHT: Controls --}}
        <ul class="navbar-nav justify-content-end align-items-center flex-row gap-3">

            @php
                $user = null;
                $endpointValue = '';

                if (Auth::guard('admin')->check()) {
                    $user = Auth::guard('admin')->user();
                    $endpointValue = $user->endpoint ?? 'N/A';
                } elseif (Auth::guard('web')->check()) {
                    $user = Auth::guard('web')->user();
                    $endpointValue = $user->endpoint ?? 'N/A';
                }

                $isAdmin = Auth::guard('admin')->check();
            @endphp

            {{-- PROFIT (ADMIN ONLY) --}}
            @if ($isAdmin)
                <li class="nav-item d-flex align-items-center">
                    <span class="text-dark me-2" style="font-size:1.5rem;font-weight:700;">
                        Profit:
                    </span>
                    <span id="live-earning"
                          class="badge bg-gradient-success"
                          style="font-size:1rem;min-width:36px;text-align:center;">
                        --
                    </span>
                </li>
            @endif

            {{-- USER INFO --}}
            @if ($user)
                <li class="nav-item d-flex align-items-center">
                    <a class="nav-link text-body font-weight-bold px-0">
                        {{ $user->player }} — Balance: {{ $endpointValue }}
                    </a>
                </li>
            @endif

            {{-- MOBILE SIDENAV TOGGLE --}}
            <li class="nav-item d-xl-none d-flex align-items-center">
                <a href="javascript:;"
                   id="iconNavbarSidenav"
                   class="nav-link p-0 d-flex align-items-center justify-content-center"
                   style="width:32px;height:32px;">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </a>
            </li>

            {{-- MOBILE LOGOUT --}}
            <li class="nav-item d-xl-none d-flex align-items-center">
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit"
                            class="btn btn-link nav-link p-0 d-flex align-items-center justify-content-center text-danger"
                            style="width:32px;height:32px;"
                            aria-label="Logout">
                        <i class="fas fa-sign-out-alt fs-5"></i>
                    </button>
                </form>
            </li>

        </ul>
    </div>
</nav>

{{-- ===============================
   MOBILE ALIGNMENT FIXES
   =============================== --}}
<style>
    @media (max-width: 991px) {

        .navbar-nav.flex-row > .nav-item {
            display: flex;
            align-items: center;
        }

        .navbar-nav.flex-row .nav-link,
        .navbar-nav.flex-row button {
            line-height: 1;
        }

        .navbar-nav.flex-row i {
            vertical-align: middle;
        }
    }
</style>

{{-- ===============================
   LIVE PROFIT FETCH
   =============================== --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function fetchLiveEarning() {
            $.ajax({
                url: '/live-game-value',
                method: 'GET',
                success: function (response) {
                    $('#live-earning').text(
                        response.earningPercentage !== undefined
                            ? response.earningPercentage
                            : '--'
                    );
                },
                error: function () {
                    $('#live-earning').text('--');
                }
            });
        }

        fetchLiveEarning();
        setInterval(fetchLiveEarning, 10000);
    });
</script>

{{-- ===============================
   SIDENAV OPEN / CLOSE
   =============================== --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidenav = document.getElementById('sidenav-main');
        const backdrop = document.getElementById('sidenav-backdrop');
        const navbarToggle = document.getElementById('iconNavbarSidenav');
        const closeBtn = document.getElementById('iconSidenav');

        function openSidenav() {
            sidenav?.classList.add('show');
            backdrop?.classList.add('show');
        }

        function closeSidenav() {
            sidenav?.classList.remove('show');
            backdrop?.classList.remove('show');
        }

        navbarToggle?.addEventListener('click', function (e) {
            e.preventDefault();
            openSidenav();
        });

        closeBtn?.addEventListener('click', closeSidenav);
        backdrop?.addEventListener('click', closeSidenav);
    });
</script>
