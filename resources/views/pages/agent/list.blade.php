@extends('layouts.layout')

@section('page-name', 'Agent List')

@section('content')
    <div class="container-fluid py-4">
        <!-- Toast Container -->
        <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1080">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-text"><strong>{{ session('success') }}</strong></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-text"><strong>{{ session('error') }}</strong></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        <!-- End Toast Container -->

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Agent Users</h6>
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <!-- Per Page Dropdown -->
                            <form method="GET" class="d-flex align-items-center mb-0 me-3">
                                <!-- Date Range Selector -->
                                <div class="input-group input-group-outline border-radius-lg shadow-sm">
                                    <select name="date_range" class="form-select border-0 ps-3 pe-4"
                                        onchange="this.form.submit()">
                                        <option value="">Select Date Range</option>
                                        <option value="2_days_ago"
                                            {{ request('date_range') == '2_days_ago' ? 'selected' : '' }}>Last 2 Days
                                        </option>
                                        <option value="this_week"
                                            {{ request('date_range') == 'this_week' ? 'selected' : '' }}>This Week</option>
                                        <option value="this_month"
                                            {{ request('date_range') == 'this_month' ? 'selected' : '' }}>This Month
                                        </option>
                                    </select>
                                </div>

                                <!-- Custom Date Range -->
                                <div class="input-group input-group-outline border-radius-lg shadow-sm">
                                    <input type="date" name="from_date" class="form-control border-0 ps-3"
                                        value="{{ request('from_date') }}" placeholder="From Date">
                                </div>
                                <span class="text-sm">to</span>
                                <div class="input-group input-group-outline border-radius-lg shadow-sm">
                                    <input type="date" name="to_date" class="form-control border-0 ps-3"
                                        value="{{ request('to_date') }}" placeholder="To Date">
                                </div>
                                <button type="submit" class="btn bg-gradient-info rounded-pill shadow-sm px-3">
                                    Filter
                                </button>
                                <label for="per_page" class="mb-0 me-2 text-sm text-dark fw-bold">Show:</label>

                                <div class="input-group input-group-outline border-radius-lg shadow-sm">
                                    <select name="per_page" id="per_page" class="form-select border-0 ps-3 pe-4"
                                        onchange="this.form.submit()" style="min-width: 60px;">
                                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    </select>
                                </div>

                                @if (request()->has('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                @if (request()->has('per_page'))
                                    <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                                @endif
                                @if (request()->has('from_date') || request()->has('to_date') || request()->has('date_range'))
                                    <a href="{{ route('agentlist.show') }}"
                                        class="btn bg-gradient-secondary rounded-pill shadow-sm px-3 ms-2">
                                        Reset
                                    </a>
                                @endif
                            </form>
                            <!-- Search Form -->
                            <form action="{{ route('agentlist.show') }}" method="GET" class="d-flex align-items-center">
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
                            <!-- Add Agent Button -->
                            <button type="button" class="btn bg-gradient-primary rounded-pill shadow-sm mb-0 px-3"
                                data-bs-toggle="modal" data-bs-target="#exampleModalAddAgent">
                                <i class="fas fa-plus me-1"></i> Add Agent
                            </button>
                            @include('pages.agent.create')
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Player
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Password
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Role
                                        </th>
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Balance
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Distributor
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Agent
                                        </th>
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Created At
                                        </th>
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($agents as $index => $agent)
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0 text-dark">{{ $index + 1 }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0 text-dark">{{ $agent->player }}
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0 text-dark me-4">
                                                    {{ $agent->original_password }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0 text-dark">
                                                    {{ ucfirst($agent->role) }}</p>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-xs font-weight-bold text-dark">₹{{ number_format($agent->balance, 2) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0 text-dark">
                                                    {{ $agent->distributor }}
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0 text-dark">{{ $agent->agent }}</p>
                                            </td>
                                            <td class="text-center text-dark">
                                                <span
                                                    class="badge badge-sm {{ $agent->status === 'Active' ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                    {{ strtoupper($agent->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center text-dark">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ \Carbon\Carbon::createFromFormat('YmdHis', $agent->DateOfCreation)->format('d M Y, H:i') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="javascript:;"
                                                        class="text-secondary font-weight-bold text-xs me-2"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Copy Agent">
                                                        <i class="fas fa-copy"></i>
                                                    </a>
                                                    <a href="javascript:;"
                                                        class="text-secondary font-weight-bold text-xs me-2"
                                                        title="Edit Agent" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $agent->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @include('pages.agent.edit')
                                                    <form action="{{ route('agent.delete', $agent->id) }}" method="post"
                                                        style="display:flex;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="text-danger font-weight-bold text-xs me-2"
                                                            onclick="return confirm('Are you sure?')"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Delete Agent"
                                                            style="background: none; border: none; padding: 0;">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    <a href="javascript:;"
                                                        class="text-danger font-weight-bold text-xs toggle-status"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Block/Unblock Agent">
                                                        <i class="fas fa-ban"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center text-secondary text-sm">
                                                No agents data found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{-- Pagination --}}
                        <div class="d-flex justify-content-center mt-3 pagination pagination-info">
                            {{ $agents->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>

            <x-footer />
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action="{{ route('agent.add') }}"]');
            if (form) {
                form.addEventListener('submit', function() {
                    const password = form.querySelector('input[name="password"]');
                    const originalPassword = form.querySelector('input[name="original_password"]');
                    if (password && originalPassword) {
                        originalPassword.value = password.value;
                    }
                });
            }
        });
    </script>
@endsection
