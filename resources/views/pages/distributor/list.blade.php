@php use Carbon\Carbon; @endphp
@extends('layouts.layout')

@section('page-name', 'Distributor List')

@section('content')
    <div class="container-fluid py-4">
        <!-- Loader -->
        <div id="loader" class="loader-overlay" style="display: none;">
            <div class="loader-spinner"></div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <!-- Clean Header Section -->
                    <div class="card-header pb-0">
                        <div class="row align-items-center">
                            <div class="col-lg-4 col-md-6">
                                <h5 class="mb-0">Distributor Users</h5>
                                <p class="text-sm text-muted mb-0">Manage your distributor accounts</p>
                            </div>
                            <div class="col-lg-4 col-md-6 text-center d-none d-lg-block">
                                <img src="{{ asset('assets/img/curved-images/golden 1.png') }}"
                                     alt="Logo" style="height: 60px; width: auto;">
                            </div>
                            <div class="col-lg-4 col-md-6 text-end">
                                <button type="button" class="btn bg-gradient-primary mb-0"
                                        data-bs-toggle="modal" data-bs-target="#exampleModalAddAgent">
                                    <i class="fas fa-plus me-2"></i>Add Distributor
                                </button>
                                @include('pages.distributor.create')
                            </div>
                        </div>
                    </div>

                    <!-- Unified Filter Bar -->
                    <div class="card-header pt-0 pb-3">
                        <hr class="horizontal dark mt-0 mb-3">
                        <form method="GET" action="{{ route('distributor.show') }}" id="filterForm">
                            <div class="row g-3 align-items-end">
                                <!-- Show Per Page -->
                                <div class="col-lg-1 col-md-2 col-sm-4">
                                    <label class="form-label text-xs text-uppercase text-muted mb-1">Show</label>
                                    <select name="per_page" class="form-select form-select-sm"
                                            onchange="document.getElementById('filterForm').submit()">
                                        @foreach([10, 20, 30, 40, 50] as $num)
                                            <option
                                                value="{{ $num }}" {{ request('per_page') === $num ? 'selected' : '' }}>{{ $num }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Search -->
                                <div class="col-lg-3 col-md-4 col-sm-8">
                                    <label class="form-label text-xs text-uppercase text-muted mb-1">Search</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-search text-muted"></i></span>
                                        <input type="search" name="search" class="form-control"
                                               value="{{ request('search') }}" placeholder="Name, password...">
                                    </div>
                                </div>

                                <!-- Date Range Preset -->
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <label class="form-label text-xs text-uppercase text-muted mb-1">Quick
                                        Filter</label>
                                    <select name="date_range" class="form-select form-select-sm">
                                        <option value="">All Time</option>
                                        <option
                                            value="2_days_ago" {{ request('date_range') === '2_days_ago' ? 'selected' : '' }}>
                                            Last 2 Days
                                        </option>
                                        <option
                                            value="last_week" {{ request('date_range') === 'last_week' ? 'selected' : '' }}>
                                            Last Week
                                        </option>
                                        <option
                                            value="last_month" {{ request('date_range') === 'last_month' ? 'selected' : '' }}>
                                            Last Month
                                        </option>
                                    </select>
                                </div>

                                <!-- Date From -->
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <label class="form-label text-xs text-uppercase text-muted mb-1">From</label>
                                    <input type="date" name="from_date" class="form-control form-control-sm"
                                           value="{{ request('from_date') }}">
                                </div>

                                <!-- Date To -->
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <label class="form-label text-xs text-uppercase text-muted mb-1">To</label>
                                    <input type="date" name="to_date" class="form-control form-control-sm"
                                           value="{{ request('to_date') }}">
                                </div>

                                <!-- Action Buttons -->
                                <div class="col-lg-2 col-md-4 col-sm-12">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-sm bg-gradient-info mb-0 flex-grow-1">
                                            <i class="fas fa-filter me-1"></i> Apply
                                        </button>
                                        @if(request()->hasAny(['search', 'from_date', 'to_date', 'date_range']))
                                            <a href="{{ route('distributor.show') }}"
                                               class="btn btn-sm btn-outline-secondary mb-0">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">
                                        #
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Password
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Role
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">
                                        Balance
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Status
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Created
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($distributors as $index => $distributor)
                                    <tr>
                                        <td class="ps-3">
                                            <span
                                                class="text-xs font-weight-bold">{{ $distributors->firstItem() + $index }}</span>
                                        </td>
                                        <!-- Name without avatar -->
                                        <td>
                                            <span class="text-sm font-weight-bold" id="name-{{ $distributor->id }}">
                                                {{ $distributor->player }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-xs text-secondary" id="password-{{ $distributor->id }}">
                                                {{ $distributor->original_password }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-sm bg-secondary">{{ $distributor->role }}</span>
                                        </td>
                                        <td class="text-end">
                                            <span
                                                class="text-sm font-weight-bold">₹{{ number_format($distributor->endpoint) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span id="status-badge-{{ $distributor->id }}"
                                                  class="badge badge-sm {{ $distributor->status === 'Active' ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                {{ $distributor->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-xs text-secondary">
                                                {{ Carbon::createFromFormat('YmdHis', (string)(int)$distributor->DateOfCreation)->setTimezone('Asia/Kolkata')->format('d M Y') }}
                                            </span>
                                            <br>
                                            <span class="text-xs text-muted">
                                                {{ Carbon::createFromFormat('YmdHis', (string)(int)$distributor->DateOfCreation)->setTimezone('Asia/Kolkata')->format('H:i') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php $admin = Auth::guard('admin')->user(); @endphp

                                                <!-- Desktop: Inline buttons -->
                                            <div class="btn-group d-none d-md-inline-flex" role="group">
                                                @if ($admin)
                                                    <a href="javascript:;" class="btn btn-link text-success px-2 mb-0"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#refillModal{{ $distributor->id }}"
                                                       title="Refill Balance">
                                                        <i class="fa-solid fa-indian-rupee-sign fa-sm"></i>
                                                    </a>
                                                @endif
                                                <a href="javascript:void(0);"
                                                   onclick="copyToClipboard('{{ $distributor->player }} - {{ $distributor->original_password }}')"
                                                   class="btn btn-link text-secondary px-2 mb-0" title="Copy">
                                                    <i class="fas fa-copy fa-sm"></i>
                                                </a>
                                                <a href="javascript:;" class="btn btn-link text-info px-2 mb-0"
                                                   data-bs-toggle="modal"
                                                   data-bs-target="#Editmodal{{ $distributor->id }}"
                                                   title="Edit">
                                                    <i class="fas fa-edit fa-sm"></i>
                                                </a>
                                                <form action="{{ route('distributor.delete', $distributor->id) }}"
                                                      method="post" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger px-2 mb-0"
                                                            onclick="return confirm('Are you sure?')" title="Delete">
                                                        <i class="fas fa-trash fa-sm"></i>
                                                    </button>
                                                </form>
                                                <a href="javascript:;"
                                                   class="btn btn-link px-2 mb-0 distributor-toggle-status"
                                                   data-distributor-id="{{ $distributor->id }}"
                                                   id="toggle-status-{{ $distributor->id }}"
                                                   title="{{ $distributor->status === 'Active' ? 'Block' : 'Unblock' }}">
                                                    <i class="fas {{ $distributor->status === 'Active' ? 'fa-ban text-warning' : 'fa-check text-success' }} fa-sm"></i>
                                                </a>
                                            </div>

                                            <!-- Mobile: 3-dot Dropdown + Delete button -->
                                            <div class="d-inline-flex align-items-center d-md-none">
                                                <div class="dropdown">
                                                    <button class="btn btn-link text-secondary px-2 mb-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                                        @if ($admin)
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#refillModal{{ $distributor->id }}">
                                                                    <i class="fa-solid fa-indian-rupee-sign text-success me-2 fa-fw"></i>
                                                                    Refill Balance
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0);"
                                                               onclick="copyToClipboard('{{ $distributor->player }} - {{ $distributor->original_password }}')">
                                                                <i class="fas fa-copy text-secondary me-2 fa-fw"></i>
                                                                Copy Details
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:;"
                                                               data-bs-toggle="modal"
                                                               data-bs-target="#Editmodal{{ $distributor->id }}">
                                                                <i class="fas fa-edit text-info me-2 fa-fw"></i>
                                                                Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item distributor-toggle-status-mobile"
                                                               href="javascript:;"
                                                               data-distributor-id="{{ $distributor->id }}">
                                                                <i class="fas {{ $distributor->status === 'Active' ? 'fa-ban text-warning' : 'fa-check text-success' }} me-2 fa-fw"></i>
                                                                <span>{{ $distributor->status === 'Active' ? 'Block' : 'Unblock' }}</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- Delete button outside dropdown -->
                                                <form action="{{ route('distributor.delete', $distributor->id) }}"
                                                      method="post" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger px-2 mb-0"
                                                            onclick="return confirm('Are you sure you want to delete this distributor?')"
                                                            title="Delete">
                                                        <i class="fas fa-trash fa-sm"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @include('pages.distributor.refil')
                                    @include('pages.distributor.edit')
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <i class="fas fa-users fa-3x text-muted mb-3 d-block"></i>
                                            <p class="text-muted mb-0">No distributors found</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($distributors->hasPages())
                            <div class="d-flex justify-content-between align-items-center px-3 pt-3">
                                <span class="text-sm text-muted">
                                    Showing {{ $distributors->firstItem() }} to {{ $distributors->lastItem() }} of {{ $distributors->total() }} entries
                                </span>
                                {{ $distributors->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <x-footer/>
    </div>

    <style>
        .loader-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #cb0c9f;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .btn-group .btn-link {
            padding: 0.25rem 0.5rem;
        }

        .btn-group .btn-link:hover {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 0.25rem;
        }

        /* Mobile dropdown styling */
        .dropdown-menu {
            border: none;
            border-radius: 0.5rem;
            min-width: 160px;
            z-index: 1050;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item i.fa-fw {
            width: 1.25em;
        }

        /* Fix dropdown in table on mobile */
        @media (max-width: 767.98px) {
            td .dropdown {
                position: static;
            }

            td .dropdown-menu {
                position: absolute !important;
                right: 1rem !important;
                left: auto !important;
                top: auto !important;
                transform: none !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('loader').style.display = 'none';
        });

        function copyToClipboard(text) {
            navigator.clipboard?.writeText(text).then(() => {
                showToast?.("Copied: " + text) || alert("Copied!");
            }).catch(() => {
                const ta = document.createElement("textarea");
                ta.value = text;
                ta.style.cssText = "position:fixed;opacity:0";
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                showToast?.("Copied: " + text) || alert("Copied!");
            });
        }

        // Shared toggle status handler
        function handleToggleStatus(btn) {
            const id = btn.dataset.distributorId;
            fetch(`/distributor/toggle-status/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
                .then(r => r.json())
                .then(data => {
                    const badge = document.getElementById(`status-badge-${id}`);
                    const isActive = data.status === 'Active';

                    // Update badge
                    badge.className = `badge badge-sm ${isActive ? 'bg-gradient-success' : 'bg-gradient-danger'}`;
                    badge.textContent = data.status;

                    // Update desktop icon
                    const desktopBtn = document.getElementById(`toggle-status-${id}`);
                    if (desktopBtn) {
                        desktopBtn.querySelector('i').className = `fas fa-sm ${isActive ? 'fa-ban text-warning' : 'fa-check text-success'}`;
                        desktopBtn.title = isActive ? 'Block' : 'Unblock';
                    }

                    // Update mobile dropdown
                    const mobileBtn = document.querySelector(`.distributor-toggle-status-mobile[data-distributor-id="${id}"]`);
                    if (mobileBtn) {
                        mobileBtn.querySelector('i').className = `fas ${isActive ? 'fa-ban text-warning' : 'fa-check text-success'} me-2 fa-fw`;
                        mobileBtn.querySelector('span').textContent = isActive ? 'Block' : 'Unblock';
                    }
                })
                .catch(() => alert('Something went wrong.'));
        }

        // Desktop toggle
        document.querySelectorAll('.distributor-toggle-status').forEach(btn => {
            btn.addEventListener('click', function () {
                handleToggleStatus(this);
            });
        });

        // Mobile toggle
        document.querySelectorAll('.distributor-toggle-status-mobile').forEach(btn => {
            btn.addEventListener('click', function () {
                handleToggleStatus(this);
            });
        });
    </script>
@endsection
