@php use Carbon\Carbon; @endphp
@extends('layouts.layout')

@section('page-name', 'Agent List')

@section('content')
    <div class="container-fluid py-4">
        <!-- Loader -->
        <div id="loader" class="loader-overlay" style="display: none;">
            <div class="loader-spinner"></div>
        </div>

        <!-- Toast Container -->
        <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1080">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-text"><strong>{{ session('success') }}</strong></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-text"><strong>{{ session('error') }}</strong></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <!-- Clean Header Section -->
                    <div class="card-header pb-0">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-6">
                                <h5 class="mb-0">Agent Users</h5>
                                <p class="text-sm text-muted mb-0">Manage your agent accounts</p>
                            </div>
                            <div class="col-lg-6 col-md-6 text-end">
                                @if (auth('admin')->check() || auth()->user()->role === 'distributor')
                                    <button type="button" class="btn bg-gradient-primary mb-0"
                                            data-bs-toggle="modal" data-bs-target="#exampleModalAddAgent">
                                        <i class="fas fa-plus me-2"></i>Add Agent
                                    </button>
                                @endif
                                @include('pages.agent.create')
                            </div>
                        </div>
                    </div>

                    <!-- Unified Filter Bar -->
                    <div class="card-header pt-0 pb-3">
                        <hr class="horizontal dark mt-0 mb-3">
                        <form method="GET" action="{{ route('agentlist.show') }}" id="filterForm">
                            <div class="row g-3 align-items-end">
                                <!-- Show Per Page -->
                                <div class="col-lg-1 col-md-2 col-sm-4">
                                    <label class="form-label text-xs text-uppercase text-muted mb-1">Show</label>
                                    <select name="per_page" class="form-select form-select-sm"
                                            onchange="document.getElementById('filterForm').submit()">
                                        @foreach([10, 20, 30, 40, 50] as $num)
                                            <option
                                                value="{{ $num }}" {{ (int)request('per_page', 10) === $num ? 'selected' : '' }}>{{ $num }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Search -->
                                <div class="col-lg-2 col-md-3 col-sm-8">
                                    <label class="form-label text-xs text-uppercase text-muted mb-1">Search</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-search text-muted"></i></span>
                                        <input type="search" name="search" class="form-control"
                                               value="{{ request('search') }}" placeholder="Name, password...">
                                    </div>
                                </div>

                                <!-- Distributor Filter -->
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <label class="form-label text-xs text-uppercase text-muted mb-1">Distributor</label>
                                    <select name="distributor_name" class="form-select form-select-sm">
                                        <option value="">All Distributors</option>
                                        @foreach ($distributors as $distributor)
                                            <option value="{{ $distributor->player }}"
                                                {{ request('distributor_name') === $distributor->player ? 'selected' : '' }}>
                                                {{ $distributor->player }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Date Range Preset -->
                                <div class="col-lg-2 col-md-2 col-sm-4">
                                    <label class="form-label text-xs text-uppercase text-muted mb-1">Quick
                                        Filter</label>
                                    <select name="date_range" class="form-select form-select-sm">
                                        <option value="">All Time</option>
                                        <option
                                            value="2_days_ago" {{ request('date_range') === '2_days_ago' ? 'selected' : '' }}>
                                            Last 2 Days
                                        </option>
                                        <option
                                            value="this_week" {{ request('date_range') === 'this_week' ? 'selected' : '' }}>
                                            Last Week
                                        </option>
                                        <option
                                            value="last_month" {{ request('date_range') === 'last_month' ? 'selected' : '' }}>
                                            Last Month
                                        </option>
                                    </select>
                                </div>

                                <!-- Date From -->
                                <div class="col-lg-2 col-md-2 col-sm-4">
                                    <label class="form-label text-xs text-uppercase text-muted mb-1">From</label>
                                    <input type="date" name="from_date" class="form-control form-control-sm"
                                           value="{{ request('from_date') }}">
                                </div>

                                <!-- Date To -->
                                <div class="col-lg-1 col-md-2 col-sm-4">
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
                                        @if(request()->hasAny(['search', 'from_date', 'to_date', 'date_range', 'distributor_name']))
                                            <a href="{{ route('agentlist.show') }}"
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Distributor
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Status
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">
                                        Balance
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
                                @forelse ($agents as $index => $agent)
                                    <tr>
                                        <td class="ps-3">
                                            <span
                                                class="text-xs font-weight-bold">{{ $agents->firstItem() + $index }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm font-weight-bold" id="name-{{ $agent->id }}">
                                                {{ $agent->player }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-xs text-secondary" id="password-{{ $agent->id }}">
                                                {{ $agent->original_password }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-sm bg-secondary">{{ ucfirst($agent->role) }}</span>
                                        </td>
                                        <td>
                                            <span class="text-xs font-weight-bold">{{ $agent->distributor }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span id="status-badge-{{ $agent->id }}"
                                                  class="badge badge-sm {{ $agent->status === 'Active' ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                {{ $agent->status }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <span
                                                class="text-sm font-weight-bold">₹{{ number_format($agent->endpoint) }}</span>
                                        </td>
                                        <td>
                                            <span class="text-xs text-secondary">
                                                {{ Carbon::createFromFormat('YmdHis', $agent->DateOfCreation)->setTimezone('Asia/Kolkata')->format('d M Y') }}
                                            </span>
                                            <br>
                                            <span class="text-xs text-muted">
                                                {{ Carbon::createFromFormat('YmdHis', $agent->DateOfCreation)->setTimezone('Asia/Kolkata')->format('H:i') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php $admin = Auth::guard('admin')->user(); @endphp

                                                <!-- Desktop: Inline buttons -->
                                            <div class="btn-group d-none d-md-inline-flex" role="group">
                                                @if ($admin)
                                                    <div class="form-check form-switch me-2">
                                                        <input class="form-check-input agent-radio" type="radio"
                                                               name="agent_select" id="agentSwitch{{ $agent->id }}"
                                                               value="{{ $agent->id }}"
                                                               data-agent-id="{{ $agent->id }}"
                                                               data-agent-name="{{ $agent->player }}"
                                                               data-agent-balance="{{ $agent->balance }}"
                                                               data-agent-distributor="{{ $agent->distributor }}"
                                                               data-agent-endpoint="{{ $agent->endpoint }}"
                                                               title="Select agent">
                                                    </div>
                                                @endif

                                                @if (auth()->check() && auth()->user()->role === 'distributor')
                                                    <a href="javascript:;" class="btn btn-link text-success px-2 mb-0"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#refillModal1{{ $agent->id }}"
                                                       title="Refill Balance">
                                                        <i class="fa-solid fa-indian-rupee-sign fa-sm"></i>
                                                    </a>
                                                @endif

                                                <a href="javascript:void(0);"
                                                   onclick="copyToClipboard('{{ $agent->player }} - {{ $agent->original_password }}')"
                                                   class="btn btn-link text-secondary px-2 mb-0" title="Copy">
                                                    <i class="fas fa-copy fa-sm"></i>
                                                </a>

                                                @if (!(auth()->check() && auth()->user()->role === 'distributor'))
                                                    <a href="javascript:;" class="btn btn-link text-info px-2 mb-0"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#editModal{{ $agent->id }}"
                                                       title="Edit">
                                                        <i class="fas fa-edit fa-sm"></i>
                                                    </a>

                                                    <form action="{{ route('agent.delete', $agent->id) }}"
                                                          method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link text-danger px-2 mb-0"
                                                                onclick="return confirm('Are you sure?')"
                                                                title="Delete">
                                                            <i class="fas fa-trash fa-sm"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                <a href="javascript:;"
                                                   class="btn btn-link px-2 mb-0 toggle-status"
                                                   data-agent-id="{{ $agent->id }}"
                                                   id="toggle-status-{{ $agent->id }}"
                                                   title="{{ $agent->status === 'Active' ? 'Block' : 'Unblock' }}">
                                                    <i class="fas {{ $agent->status === 'Active' ? 'fa-ban text-warning' : 'fa-check text-success' }} fa-sm"></i>
                                                </a>
                                            </div>

                                            <!-- Mobile: 3-dot Dropdown + Delete button -->
                                            <div class="d-inline-flex align-items-center d-md-none">
                                                @if ($admin)
                                                    <div class="form-check form-switch me-1">
                                                        <input class="form-check-input agent-radio" type="radio"
                                                               name="agent_select_mobile"
                                                               value="{{ $agent->id }}"
                                                               data-agent-id="{{ $agent->id }}"
                                                               data-agent-name="{{ $agent->player }}"
                                                               data-agent-balance="{{ $agent->balance }}"
                                                               data-agent-distributor="{{ $agent->distributor }}"
                                                               data-agent-endpoint="{{ $agent->endpoint }}">
                                                    </div>
                                                @endif

                                                <div class="dropdown dropstart">
                                                    <button class="btn btn-link text-secondary px-2 mb-0" type="button"
                                                            data-bs-toggle="dropdown" data-bs-display="static"
                                                            aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu shadow">
                                                        @if (auth()->check() && auth()->user()->role === 'distributor')
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#refillModal1{{ $agent->id }}">
                                                                    <i class="fa-solid fa-indian-rupee-sign text-success me-2 fa-fw"></i>
                                                                    Refill Balance
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0);"
                                                               onclick="copyToClipboard('{{ $agent->player }} - {{ $agent->original_password }}')">
                                                                <i class="fas fa-copy text-secondary me-2 fa-fw"></i>
                                                                Copy Details
                                                            </a>
                                                        </li>
                                                        @if (!(auth()->check() && auth()->user()->role === 'distributor'))
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:;"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#editModal{{ $agent->id }}">
                                                                    <i class="fas fa-edit text-info me-2 fa-fw"></i>
                                                                    Edit
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <a class="dropdown-item toggle-status-mobile"
                                                               href="javascript:;"
                                                               data-agent-id="{{ $agent->id }}">
                                                                <i class="fas {{ $agent->status === 'Active' ? 'fa-ban text-warning' : 'fa-check text-success' }} me-2 fa-fw"></i>
                                                                <span>{{ $agent->status === 'Active' ? 'Block' : 'Unblock' }}</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                @if (!(auth()->check() && auth()->user()->role === 'distributor'))
                                                    <!-- Delete button outside dropdown -->
                                                    <form action="{{ route('agent.delete', $agent->id) }}"
                                                          method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link text-danger px-2 mb-0"
                                                                onclick="return confirm('Are you sure?')"
                                                                title="Delete">
                                                            <i class="fas fa-trash fa-sm"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @include('pages.agent.refil1', ['user' => $agent])
                                    @if (!(auth()->check() && auth()->user()->role === 'distributor'))
                                        @include('pages.agent.edit')
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <i class="fas fa-user-tie fa-3x text-muted mb-3 d-block"></i>
                                            <p class="text-muted mb-0">No agents found</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($agents->hasPages())
                            <div class="d-flex justify-content-between align-items-center px-3 pt-3">
                                <span class="text-sm text-muted">
                                    Showing {{ $agents->firstItem() }} to {{ $agents->lastItem() }} of {{ $agents->total() }} entries
                                </span>
                                {{ $agents->links('vendor.pagination.bootstrap-4') }}
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
                showToast("Copied: " + text);
            }).catch(() => {
                const ta = document.createElement("textarea");
                ta.value = text;
                ta.style.cssText = "position:fixed;opacity:0";
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                showToast("Copied: " + text);
            });
        }

        function showToast(message) {
            const toast = document.createElement("div");
            toast.className = "alert alert-info position-fixed top-0 end-0 m-3";
            toast.style.zIndex = "2000";
            toast.innerHTML = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2000);
        }

        // Shared toggle status handler
        function handleToggleStatus(btn) {
            const id = btn.dataset.agentId;
            fetch(`/agent/toggle-status/${id}`, {
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
                    const mobileBtn = document.querySelector(`.toggle-status-mobile[data-agent-id="${id}"]`);
                    if (mobileBtn) {
                        mobileBtn.querySelector('i').className = `fas ${isActive ? 'fa-ban text-warning' : 'fa-check text-success'} me-2 fa-fw`;
                        mobileBtn.querySelector('span').textContent = isActive ? 'Block' : 'Unblock';
                    }
                })
                .catch(() => alert('Something went wrong.'));
        }

        // Desktop toggle
        document.querySelectorAll('.toggle-status').forEach(btn => {
            btn.addEventListener('click', function () {
                handleToggleStatus(this);
            });
        });

        // Mobile toggle
        document.querySelectorAll('.toggle-status-mobile').forEach(btn => {
            btn.addEventListener('click', function () {
                handleToggleStatus(this);
            });
        });

        // Agent selection functionality
        document.addEventListener('DOMContentLoaded', function () {
            let selectedAgent = JSON.parse(sessionStorage.getItem('selectedAgent')) || null;
            const radioButtons = document.querySelectorAll('.agent-radio');
            const sidebarContent = document.getElementById('sidebar-setting-content');

            radioButtons.forEach(radio => {
                const agentId = radio.getAttribute('data-agent-id');
                radio.checked = (selectedAgent && selectedAgent.id === agentId);
            });

            radioButtons.forEach(radio => {
                radio.addEventListener('click', async function () {
                    const clickedAgentId = this.getAttribute('data-agent-id');

                    if (this.checked && selectedAgent && clickedAgentId === selectedAgent.id) {
                        await handleDeselect(this);
                    } else {
                        await handleSelect(this, clickedAgentId);
                    }
                });
            });

            async function handleDeselect(radioElement) {
                try {
                    radioElement.checked = false;
                    if (sidebarContent) sidebarContent.innerHTML = '';
                    sessionStorage.removeItem('selectedAgent');
                    selectedAgent = null;

                    await fetch("{{ route('agent.deselect') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({})
                    });

                    await fetch("/update-negative-agent", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({agent_id: null})
                    });
                } catch (error) {
                    console.error('Error deselecting agent:', error);
                    radioElement.checked = true;
                }
            }

            async function handleSelect(radioElement, agentId) {
                try {
                    radioButtons.forEach(rb => {
                        if (rb !== radioElement) rb.checked = false;
                    });

                    const agentData = {
                        id: agentId,
                        name: radioElement.getAttribute('data-agent-name'),
                        balance: radioElement.getAttribute('data-agent-balance'),
                        distributor: radioElement.getAttribute('data-agent-distributor'),
                        endpoint: radioElement.getAttribute('data-agent-endpoint')
                    };

                    sessionStorage.setItem('selectedAgent', JSON.stringify(agentData));
                    selectedAgent = agentData;

                    if (sidebarContent) {
                        const sidebarResponse = await fetch('/setting/sidebar/' + agentId);
                        if (sidebarResponse.ok) {
                            sidebarContent.innerHTML = await sidebarResponse.text();
                        }
                    }

                    await fetch("{{ route('agent.select') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({agent_id: agentId})
                    });

                    await fetch("/update-negative-agent", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({agent_id: agentId})
                    });
                } catch (error) {
                    console.error('Error selecting agent:', error);
                    radioButtons.forEach(rb => rb.checked = false);
                }
            }
        });

        // Transfer link functionality
        document.addEventListener('DOMContentLoaded', function () {
            const transferLink = document.getElementById('transfer-link');
            if (transferLink) {
                function updateTransferLink() {
                    const storedAgent = JSON.parse(sessionStorage.getItem('selectedAgent'));
                    if (storedAgent) {
                        transferLink.href = "{{ route('transfer.page') }}?agent_id=" + storedAgent.id;
                        transferLink.classList.remove('disabled');
                    } else {
                        transferLink.href = "#";
                        transferLink.classList.add('disabled');
                    }
                }

                updateTransferLink();
                document.addEventListener('click', function (e) {
                    if (e.target.classList.contains('agent-radio')) {
                        setTimeout(updateTransferLink, 100);
                    }
                });
            }
        });
    </script>
@endsection
