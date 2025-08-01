@extends('layouts.layout')

@section('page-name', 'Refil Report')

@section('content')
    <!-- Loader Container -->
    <div id="loader" class="loader-container">
        <div class="loader"></div>
    </div>

    <div class="container py-4">
        <h3 class="mb-4 text-dark" style="font-weight: 600; font-size: 1.2rem;">
            @if (auth('admin')->check())
                All Refil History
            @elseif(auth('web')->check())
                My Refil History
            @else
                Refil History
            @endif
        </h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
            <h6 class="mb-0 ms-4 mt-3 text-bolder"></h6>
            <div class="d-flex align-items-center gap-2 flex-wrap me-3">
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
                <form action="{{ route('refil.report') }}" method="GET" class="d-flex align-items-center">
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
                    @if (request()->has('search') && request('search') != '')
                        <a href="{{ route('refil.report') }}" class="btn btn-secondary btn-sm px-3 mt-3">Reset</a>
                    @endif
                </form>
            </div>
        </div>
        <!-- Second Row: Date Filter -->
        <form action="{{ route('refil.report') }}" method="GET"
            class="d-flex justify-content-end align-items-center flex-wrap gap-2 mt-2 me-3 mb-2">
            <!-- Date Range -->
            <select name="date_range" class="form-select form-select-sm" onchange="this.form.submit()"
                style="width: 150px;">
                <option value="">Date Range</option>
                <option value="2_days_ago" {{ request('date_range') == '2_days_ago' ? 'selected' : '' }}>Last 2 Days
                </option>
                <option value="last_week" {{ request('date_range') == 'last_week' ? 'selected' : '' }}>Last Week</option>
                <option value="last_month" {{ request('date_range') == 'last_month' ? 'selected' : '' }}>Last Month
                </option>
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
                <a href="{{ route('refil.report') }}" class="btn btn-secondary btn-sm px-3 mt-3">Reset</a>
            @endif
        </form>

        @if ($refils->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped" style="font-size: 0.8rem; color: #212529;">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Transfer By</th>
                            <th>Transfer To</th>
                            <th>Remaining Balance</th>
                            <th>Amount</th>
                            <th>Role</th>
                            <th>Type</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($refils as $index => $refil)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $refil->agent_name }}</td>
                                <td>
                                    @if (str_contains($refil->distributor_name, 'Admin'))
                                        <span class="text-primary">{{ $refil->distributor_name }}</span>
                                    @else
                                        {{ $refil->distributor_name }}
                                    @endif
                                </td>
                                <td>{{ number_format($refil->remaining_balance, 2) }}</td>
                                <td>{{ number_format($refil->amount) }}</td>
                                <td>{{ ucfirst($refil->transfer_role) }}</td>
                                <td>{{ $refil->type }}</td>
                                <td>{{ \Carbon\Carbon::parse($refil->created_at)->setTimezone('Asia/Kolkata')->format('d-M-Y h:i A') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-3 pagination pagination-info">
                    {{ $refils->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        @else
            <div class="alert alert-info small">No refil records found.</div>
        @endif
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
