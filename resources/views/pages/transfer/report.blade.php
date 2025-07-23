@extends('layouts.layout')

@section('page-name', 'Transfer History')

@section('content')
    <!-- Loader Container -->
    <div id="loader" class="loader-container">
        <div class="loader"></div>
    </div>

    <div class="container py-1">
        <h3 class="mb-4 text-dark" style="font-weight: 600; font-size: 1.2rem;">
            @if (auth('admin')->check())
                All Transfer History
            @elseif(auth('web')->check())
                My Transfer History
            @else
                Transfer History
            @endif
        </h3>

        <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
            <h6 class="mb-0 ms-4 mt-3 text-bolder">Redeem report</h6>
            <div class="d-flex align-items-center gap-2 flex-wrap mt-3 me-3">
                <!-- Show Dropdown -->
                <form method="GET" class="d-flex align-items-center mb-0" id="perPageForm">
                    <label for="per_page" class="mb-0 me-2 text-sm text-dark fw-bold">Show:</label>

                    <div class="input-group input-group-outline border-radius-lg shadow-sm">
                        <select name="per_page" id="per_page" class="form-select border-0 ps-3 pe-4" style="min-width: 60px;">
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ request('per_page', 10) == 15 ? 'selected' : '' }}>15</option>
                        </select>
                    </div>
                    
                    <!-- Persist all query parameters -->
                    @foreach(request()->except(['per_page', 'page']) as $key => $value)
                        @if(!is_array($value))
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                </form>

                <!-- Search -->
                <form action="" method="GET" class="d-flex align-items-center">
                    <div class="input-group input-group-outline rounded-pill me-2 shadow-sm">
                        <span class="input-group-text bg-transparent border-0 text-secondary">
                            <i class="fas fa-search"></i>
                        </span>
                        <label class="form-label"></label>
                        <input type="search" name="search" class="form-control border-0" value="{{ request('search') }}"
                            onfocus="this.parentElement.classList.add('is-focused')"
                            onfocusout="this.parentElement.classList.remove('is-focused')">
                    </div>
                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                    <button type="submit" class="btn bg-gradient-warning rounded-pill shadow-sm mb-0">
                        Search
                    </button>
                    
                    <!-- Persist per_page in search form -->
                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                </form>
            </div>
        </div>
        
        <form action="{{ route('transfer.report') }}" method="GET"
            class="d-flex justify-content-end align-items-center flex-wrap gap-2 mt-2 me-3">
            <!-- Date Range -->
            <select name="date_range" class="form-select form-select-sm" onchange="this.form.submit()"
                style="width: 150px;">
                <option value="">Date Range</option>
                <option value="2_days_ago" {{ request('date_range') == '2_days_ago' ? 'selected' : '' }}>Last 2
                    Days</option>
                <option value="this_week" {{ request('date_range') == 'this_week' ? 'selected' : '' }}>last Week
                </option>
                <option value="this_month" {{ request('date_range') == 'this_month' ? 'selected' : '' }}>last
                    Month</option>
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
                <a href="{{ route('transfer.report') }}" class="btn btn-secondary btn-sm px-3 mt-3">Reset</a>
            @endif
        </form>

        @if(count($transfers) > 0)
            <div class="table-responsive mt-2">
                <table class="table table-bordered table-hover" style="font-size: 0.8rem; color: #212529;">
                    <thead>
                        <tr>
                            <th scope="col" class="text-dark">transfer by </th>
                            <th scope="col" class="text-dark">transfer to </th>
                            <th scope="col" class="text-dark">Amount</th>
                            <th scope="col" class="text-dark">Remaining Balance</th>
                            <th scope="col" class="text-dark">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transfers as $transfer)
                            <tr>
                                <td>{{ $transfer->agent_name }}</td>
                                <td>
                                    @if(str_contains($transfer->distributor_name, 'Admin'))
                                        <span class="text-primary">{{ $transfer->distributor_name }}</span>
                                    @else
                                        {{ $transfer->distributor_name }}
                                    @endif
                                </td>
                                <td class="text-success">{{ number_format($transfer->amount, 2) }}</td>
                                <td>{{ number_format($transfer->remaining_balance, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($transfer->created_at)->format('d-M-Y h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-3 pagination pagination-info">
                    {{ $transfers->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        @else
            <div class="alert alert-info small">No transfer records found.</div>
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

        // Handle per_page form submission
        document.getElementById('per_page')?.addEventListener('change', function() {
            document.getElementById('perPageForm').submit();
        });
    </script>
@endsection