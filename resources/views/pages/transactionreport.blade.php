@extends('layouts.layout')

@section('page-name', 'Transaction Report')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Transactions</h6>
                        <div class="d-flex align-items-center gap-2 flex-wrap mt-3 me-3">
                            <!-- Show Dropdown -->
                            <form method="GET" class="d-flex align-items-center mb-0">
                            <label for="per_page" class="mb-0 me-2 text-sm text-dark fw-bold">Show:</label>

                            <div class="input-group input-group-outline border-radius-lg shadow-sm">
                                <select name="per_page" id="per_page" class="form-select border-0 ps-3 pe-4"
                                    onchange="this.form.submit()" style="min-width: 60px;">
                                    <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                </select>
                            </div>
                                @if (request()->has('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                            </form>
                            <!-- Search Form -->
                            <form action="{{ route('transactionreport') }}" method="GET"
                                class="d-flex align-items-center">
                                <div class="input-group input-group-outline rounded-pill me-2 shadow-sm">
                                    <span class="input-group-text bg-transparent border-0 text-secondary">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="search" name="search" class="form-control border-0"
                                        placeholder="Search..." value="{{ request('search') }}"
                                        onfocus="this.parentElement.classList.add('is-focused')"
                                        onfocusout="this.parentElement.classList.remove('is-focused')">
                                </div>
                                <button type="submit" class="btn bg-gradient-warning rounded-pill shadow-sm mb-0 px-3">
                                    Search
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- Second Row: Date Filter -->
                    <form method="GET" class="d-flex justify-content-end align-items-center flex-wrap gap-2 mt-2 me-3">
                        <!-- Date Range -->
                        <select name="date_range" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 150px;">
                            <option value="">Date Range</option>
                            <option value="2_days_ago" {{ request('date_range') == '2_days_ago' ? 'selected' : '' }}>Last 2 Days</option>
                            <option value="this_week" {{ request('date_range') == 'this_week' ? 'selected' : '' }}>This Week</option>
                            <option value="this_month" {{ request('date_range') == 'this_month' ? 'selected' : '' }}>This Month</option>
                        </select>

                        <!-- From Date -->
                        <input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}" style="width: 150px;">

                        <!-- To Date -->
                        <span class="text-sm mx-1">to</span>
                        <input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}" style="width: 150px;">

                        <!-- Search Hidden -->
                        @if (request()->has('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <!-- Filter Button -->
                        <button type="submit" class="btn btn-sm btn-primary  mb-0">Filter</button>

                        <!-- Reset Button -->
                        @if (request()->has('from_date') || request()->has('to_date') || request()->has('date_range'))
                            <a href="{{ route('transactionreport') }}" class="btn btn-secondary btn-sm px-3 mt-3">Reset</a>
                        @endif
                    </form>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            NO
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            ID
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Amount
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            DateTime
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Form
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            To
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $index => $transaction)
                                        <tr>
                                            <td class="align-middle text-center text-sm">
                                                <div class="d-flex px-2 py-1">
                                                    <p class="text-sm font-weight-bold mb-0">{{ $index + 1 }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $transaction->_id }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $transaction->amount }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ \Carbon\Carbon::parse($transaction->date_time)->format('d M Y h:i A') }}
                                                </p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-bold mb-0">{{ $transaction->from }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-bold mb-0">{{ $transaction->to }}</p>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-secondary text-sm">
                                                No Transaction data found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{-- Pagination --}}
                        <div class="d-flex justify-content-center mt-3 pagination pagination-info">
                            {{ $transactions->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
            <x-footer />
        </div>
    </div>
@endsection
