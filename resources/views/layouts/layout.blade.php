<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    <title>
        Dashboard
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Nucleo Icons -->
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->
    <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
</head>

<body class="g-sidenav-show bg-gray-100">
    <x-sidebar />
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbar />
        <!-- End Navbar -->
        @yield('content')
    </main>

    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/chartjs.min.js"></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="/assets/js/soft-ui-dashboard.min.js?v=1.1.0"></script>
    <!-- Toast Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
            var toastList = toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl, {
                    autohide: true,
                    delay: 3000
                })
            })
            toastList.forEach(toast => toast.show())
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fromDate = document.getElementById('from_date');
            const toDate = document.getElementById('to_date');
            const dateRange = document.getElementById('date_range');

            // Set max date for "from" and "to" fields to today
            const today = new Date().toISOString().split('T')[0];
            if (fromDate) fromDate.max = today;
            if (toDate) toDate.max = today;

            // Handle quick date range selection
            if (dateRange) {
                dateRange.addEventListener('change', function() {
                    const range = this.value;
                    const today = new Date();

                    if (range === '2_days_ago') {
                        const twoDaysAgo = new Date();
                        twoDaysAgo.setDate(today.getDate() - 2);
                        fromDate.value = twoDaysAgo.toISOString().split('T')[0];
                        toDate.value = today.toISOString().split('T')[0];
                    } else if (range === 'this_week') {
                        const firstDayOfWeek = new Date(today.setDate(today.getDate() - today.getDay()));
                        fromDate.value = firstDayOfWeek.toISOString().split('T')[0];
                        toDate.value = today.toISOString().split('T')[0];
                    } else if (range === 'this_month') {
                        const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
                        fromDate.value = firstDayOfMonth.toISOString().split('T')[0];
                        toDate.value = today.toISOString().split('T')[0];
                    }
                });
            }

            // Validate date range
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (fromDate.value && toDate.value && fromDate.value > toDate.value) {
                        e.preventDefault();
                        alert('"From" date cannot be after "To" date');
                        return false;
                    }
                    return true;
                });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
