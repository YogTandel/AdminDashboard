@extends('layouts.layout')

@section('page-name', 'Commission Report')

@section('content')
    <!-- Loader Container -->
    <div id="loader" class="loader-container">
        <div class="loader"></div>
    </div>

    <div class="container py-4">
        <h3 class="mb-4 text-dark" style="font-weight: 600; font-size: 1.2rem;">
            @if (auth('admin')->check())
                All Commission History
            @elseif(auth('web')->check())
                My Commission History
            @else
                Commission History
            @endif
        </h3>

        <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
            <h4 class="mb-0 ms-4 mt-3 text-bolder">Release History</h4>
            <div class="d-flex align-items-center gap-2 flex-wrap mt-3 me-3">
                <!-- Show Dropdown -->
                <form method="GET" class="d-flex align-items-center mb-0">
                    <label for="per_page" class="mb-0 me-2 text-sm text-dark fw-bold">Show:</label>

                    <div class="input-group input-group-outline border-radius-lg shadow-sm">
                        <select name="per_page" id="per_page" class="form-select border-0 ps-3 pe-4"
                            onchange="this.form.submit()" style="min-width: 60px;">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                        </select>
                    </div>
                    @if (request()->has('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                </form>

                <!-- Search -->
                <form action="{{ route('relesecommission-report') }}" method="GET" class="d-flex align-items-center">
                    <div class="input-group input-group-outline rounded-pill me-2 shadow-sm">
                        <span class="input-group-text bg-transparent border-0 text-secondary">
                            <i class="fas fa-search"></i>
                        </span>
                        <label class="form-label"></label>
                        <input type="search" name="search" class="form-control border-0"
                            onfocus="this.parentElement.classList.add('is-focused')"
                            onfocusout="this.parentElement.classList.remove('is-focused')">
                    </div>
                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

                    <button type="submit" class="btn bg-gradient-warning rounded-pill shadow-sm mb-0">
                        Search
                    </button>
                    @if (request()->has('from_date') ||
                            request()->has('to_date') ||
                            request()->has('date_range') ||
                            request()->has('search'))
                        <a href="{{ route('relesecommission-report') }}"
                            class="btn btn-secondary btn-sm px-3 mt-3">Reset</a>
                    @endif
                </form>
            </div>
        </div>
        <form action="{{ route('relesecommission-report') }}" method="GET"
            class="d-flex justify-content-end align-items-center flex-wrap gap-2 mt-2 me-3">
            <!-- Date Range -->
            <select name="date_range" class="form-select form-select-sm" onchange="this.form.submit()"
                style="width: 150px;">
                <option value="">Date Range</option>
                <option value="2_days_ago" {{ request('date_range') == '2_days_ago' ? 'selected' : '' }}>Last 2 Days
                </option>
                <option value="last_week" {{ request('date_range') == 'last_week' ? 'selected' : '' }}>Last Week</option>
                <option value="last_month" {{ request('date_range') == 'last_month' ? 'selected' : '' }}>Last Month</option>
            </select>

            <!-- From Date -->
            <input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}"
                style="width: 150px;">

            <!-- To Date -->
            <span class="text-sm mx-1">to</span>
            <input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}"
                style="width: 150px;">

            <!-- Search Hidden -->
            @if (request()->has('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

            <!-- Filter Button -->
            <button type="submit" class="btn btn-sm btn-primary  mb-0">Filter</button>
            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

            <!-- Reset Button -->
            @if (request()->has('from_date') || request()->has('to_date') || request()->has('date_range'))
                <a href="{{ route('relesecommission-report') }}" class="btn btn-secondary btn-sm px-3 mt-3">Reset</a>
            @endif
        </form>


        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="container mt-2">
            <!-- <h3 class="mb-4">Release History</h3> -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Transfer To</th>
                        <th>Type</th>
                        <th>Total Bet</th>
                        <th> %</th>
                        <th>Comission</th>
                        <th>Before</th>
                        <th>After</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($releases as $index => $release)
                        <tr class="text-dark text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $release['name'] ?? 'N/A' }}</td>
                            <td>{{ $release['type'] ?? 'N/A' }}</td>
                            <td>₹ {{ $release['total_bet'] ?? '0' }}</td>
                            <td>{{ $release['commission_percentage'] ?? '0' }}%</td>
                            <td>{{ $release['commission_amount'] ?? '0' }}</td>
                            <td>₹ {{ $release['remaining_balance'] ?? '0' }}</td>
                            <td></td>
                            <td>{{ \Carbon\Carbon::parse(time: $release->created_at)->format('d-M-Y h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-dark">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-3">
                {{ $releases->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>

    <style>
        /* Loader Styles */
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }

        .loader {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <script>
        // Show loader when page is loading
        document.addEventListener('DOMContentLoaded', function() {
            // Show loader immediately when page starts loading
            document.getElementById('loader').style.display = 'flex';

            // Hide loader when page is fully loaded
            window.addEventListener('load', function() {
                document.getElementById('loader').style.display = 'none';
            });
        });

        // Show loader when page is being refreshed
        window.addEventListener('beforeunload', function() {
            document.getElementById('loader').style.display = 'flex';
        });
    </script>
@endsection
