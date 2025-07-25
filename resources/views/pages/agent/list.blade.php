@extends('layouts.layout')

@section('page-name', 'Agent List')

@section('content')
    <!-- Loader Container -->
    <div id="loader" class="loader-container">
        <div class="loader"></div>
    </div>

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
                    <!-- First Row -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
                        <h6 class="mb-0 ms-4 mt-3 text-bolder">Agent Users</h6>
                        <div class="d-flex align-items-center gap-2 flex-wrap mt-3 me-3">
                            <!-- Show Dropdown -->
                            <form method="GET" class="d-flex align-items-center mb-0" id="perPageForm">
                                <label for="per_page" class="mb-0 me-2 text-sm text-dark fw-bold">Show:</label>

                                <div class="input-group input-group-outline border-radius-lg shadow-sm">
                                    <select name="per_page" id="per_page" class="form-select border-0 ps-3 pe-4"
                                        style="min-width: 60px;">
                                        <option value="10"
                                            {{ (int) request()->query('per_page', 10) === 10 ? 'selected' : '' }}>10
                                        </option>
                                        <option value="15"
                                            {{ (int) request()->query('per_page', 10) === 15 ? 'selected' : '' }}>15
                                        </option>
                                    </select>
                                </div>

                                <!-- Persist ALL parameters EXCEPT page -->
                                @foreach (request()->query() as $key => $value)
                                    @if ($key != 'per_page')
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endif
                                @endforeach
                            </form>

                            <!-- Search -->
                            <form action="{{ route('agentlist.show') }}" method="GET" class="d-flex align-items-center">
                                <div class="input-group input-group-outline rounded-pill me-2 shadow-sm">
                                    <span class="input-group-text bg-transparent border-0 text-secondary">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <label class="form-label"></label>
                                    <input type="search" name="search" class="form-control border-0"
                                        value="{{ request('search') }}"
                                        onfocus="this.parentElement.classList.add('is-focused')"
                                        onfocusout="this.parentElement.classList.remove('is-focused')">
                                </div>

                                <button type="submit" class="btn bg-gradient-warning rounded-pill shadow-sm mb-0">
                                    Search
                                </button>
                                @if (request()->has('from_date') ||
                                        request()->has('to_date') ||
                                        request()->has('date_range') ||
                                        request()->has('search'))
                                    <a href="{{ route('agentlist.show') }}"
                                        class="btn btn-secondary btn-sm px-3 mt-3">Reset</a>
                                @endif

                            </form>

                            <!-- Add Agent -->
                            <button type="button" class="btn bg-primary mb-0 text-white" data-bs-toggle="modal"
                                data-bs-target="#exampleModalAddAgent">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Agent
                            </button>
                            @include('pages.agent.create')
                        </div>
                    </div>

                    <!-- Second Row: Date Filter -->
                    <form action="{{ route('agentlist.show') }}" method="GET"
                        class="d-flex justify-content-end align-items-center flex-wrap gap-2 mt-2 me-3">
                        <!-- Date Range -->
                        <select name="date_range" class="form-select form-select-sm" onchange="this.form.submit()"
                            style="width: 150px;">
                            <option value="">Date Range</option>
                            <option value="2_days_ago" {{ request('date_range') == '2_days_ago' ? 'selected' : '' }}>Last 2
                                Days</option>
                            <option value="this_week" {{ request('date_range') == 'this_week' ? 'selected' : '' }}>Last
                                Week
                            </option>
                            <option value="this_month" {{ request('date_range') == 'this_month' ? 'selected' : '' }}>Last
                                Month</option>
                        </select>

                        <!-- From Date -->
                        <input type="date" name="from_date" class="form-control form-control-sm"
                            value="{{ request('from_date') }}" style="width: 150px;">

                        <!-- To Date -->
                        <span class="text-sm mx-1">to</span>
                        <input type="date" name="to_date" class="form-control form-control-sm"
                            value="{{ request('to_date') }}" style="width: 150px;">

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
                            <a href="{{ route('agentlist.show') }}" class="btn btn-secondary btn-sm px-3 mt-3">Reset</a>
                        @endif
                        <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                    </form>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity- text-center">
                                            No
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 ">
                                            Password
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                            Role
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Distributor
                                        </th>
                                        <th
                                            class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Status
                                        </th>
                                        <th
                                            class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Balance
                                        </th>
                                        <th
                                            class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Created At
                                        </th>
                                        <th
                                            class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
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
                                                <p class="text-xs font-weight-bold mb-0 text-dark">
                                                    {{ $agent->distributor }}</p>
                                            </td>
                                            <td class="text-center text-dark">
                                                <span id="status-badge-{{ $agent->id }}"
                                                    class="badge {{ $agent->status === 'Active' ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                    {{ strtoupper($agent->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0 text-dark">{{ $agent->endpoint }}
                                                </p>
                                            </td>
                                            <td class="text-center text-dark">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ \Carbon\Carbon::createFromFormat('YmdHis', $agent->DateOfCreation)->format('d M Y, H:i') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2 align-items-center">
                                                    <!-- Radio Button -->
                                                    @php $admin = Auth::guard('admin')->user(); @endphp

                                                    @if ($admin)
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input agent-radio" type="radio"
                                                                name="agent_select" id="agentSwitch{{ $agent->id }}"
                                                                value="{{ $agent->id }}"
                                                                data-agent-id="{{ $agent->id }}"
                                                                data-agent-name="{{ $agent->player }}"
                                                                data-agent-balance="{{ $agent->balance }}"
                                                                data-agent-distributor="{{ $agent->distributor }}"
                                                                data-agent-endpoint="{{ $agent->endpoint }}"
                                                                data-bs-toggle="tooltip"
                                                                title="Select agent {{ $agent->player }}">
                                                        </div>
                                                    @endif

                                                    @if (auth()->check() && auth()->user()->role === 'distributor')
                                                        <a href="javascript:;"
                                                            class="text-success font-weight-bold text-xs me-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#refillModal1{{ $agent->id }}">
                                                            <i class="fa-solid fa-indian-rupee-sign"></i>
                                                        </a>
                                                    @endif
                                                    @foreach ($agents as $agent_data)
                                                        @include('pages.agent.refil1', [
                                                            'user' => $agent_data,
                                                        ])
                                                    @endforeach

                                                    <!-- Copy -->
                                                    <a href="javascript:;"
                                                        onclick="copyToClipboard(`{{ $agent->player }} - {{ $agent->original_password }}`)"
                                                        class="text-secondary font-weight-bold text-xs ms-2 me-2"
                                                        data-bs-toggle="tooltip" title="Copy agent">
                                                        <i class="fas fa-copy" style="cursor: pointer;"></i>
                                                    </a>

                                                    <!-- Edit -->
                                                    <a href="javascript:;"
                                                        class="text-secondary font-weight-bold text-xs me-2"
                                                        title="Edit Agent" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $agent->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    @include('pages.agent.edit')

                                                    <!-- Delete -->
                                                    <form action="{{ route('agent.delete', $agent->id) }}" method="post"
                                                        style="display:flex;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="text-danger font-weight-bold text-xs me-2"
                                                            onclick="return confirm('Are you sure?')"
                                                            data-bs-toggle="tooltip" title="Delete Agent"
                                                            style="background: none; border: none; padding: 0;">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>

                                                    <!-- Block/Unblock -->
                                                    <a href="javascript:;" class="font-weight-bold text-xs toggle-status"
                                                        data-bs-toggle="tooltip"
                                                        title="{{ $agent->status === 'Active' ? 'Block Agent' : 'Unblock Agent' }}"
                                                        data-agent-id="{{ $agent->id }}">
                                                        <i
                                                            class="fas {{ $agent->status === 'Active' ? 'fa-ban text-danger' : 'fa-check text-success' }}"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center text-secondary text-sm">No agents data
                                                found.</td>
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

    <!-- <style>
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
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            </style> -->

    <script>
        // Show loader when page is loading
        document.addEventListener('DOMContentLoaded', function() {
            // Show loader immediately when page starts loading
            document.getElementById('loader').style.display = 'flex';

            // Hide loader when page is fully loaded
            window.addEventListener('load', function() {
                document.getElementById('loader').style.display = 'none';
            });

            // Show loader during AJAX requests
            $(document).ajaxStart(function() {
                document.getElementById('loader').style.display = 'flex';
            });

            $(document).ajaxStop(function() {
                document.getElementById('loader').style.display = 'none';
            });

            $(document).ajaxError(function() {
                document.getElementById('loader').style.display = 'none';
            });
        });

        // Show loader when page is being refreshed
        window.addEventListener('beforeunload', function() {
            document.getElementById('loader').style.display = 'flex';
        });

        // Password copy functionality
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

        // Toggle status functionality with loader
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-status').forEach(btn => {
                btn.addEventListener('click', function() {
                    const agentId = this.dataset.agentId;
                    const icon = this.querySelector('i');
                    const statusBadge = document.getElementById(`status-badge-${agentId}`);
                    const tooltipTitle = this;

                    // Show loader
                    document.getElementById('loader').style.display = 'flex';

                    fetch(`/agent/toggle-status/${agentId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'Active') {
                                icon.classList.remove('fa-check', 'text-success');
                                icon.classList.add('fa-ban', 'text-danger');
                                tooltipTitle.setAttribute('title', 'Block Agent');
                                statusBadge.classList.remove('bg-gradient-danger');
                                statusBadge.classList.add('bg-gradient-success');
                            } else {
                                icon.classList.remove('fa-ban', 'text-danger');
                                icon.classList.add('fa-check', 'text-success');
                                tooltipTitle.setAttribute('title', 'Unblock Agent');
                                statusBadge.classList.remove('bg-gradient-success');
                                statusBadge.classList.add('bg-gradient-danger');
                            }

                            statusBadge.innerText = data.status.toUpperCase();
                        })
                        .catch(error => {
                            alert('Something went wrong.');
                            console.error(error);
                        })
                        .finally(() => {
                            // Hide loader
                            document.getElementById('loader').style.display = 'none';
                        });
                });
            });
        });

        // Agent selection with loader
        document.addEventListener('DOMContentLoaded', function() {
            let selectedAgent = JSON.parse(sessionStorage.getItem('selectedAgent')) || null;
            const radioButtons = document.querySelectorAll('.agent-radio');
            const sidebarContent = document.getElementById('sidebar-setting-content');

            // Initialize radio buttons state
            radioButtons.forEach(radio => {
                const agentId = radio.getAttribute('data-agent-id');
                radio.checked = (selectedAgent && selectedAgent.id === agentId);
            });

            // Handle radio button clicks
            radioButtons.forEach(radio => {
                radio.addEventListener('click', async function() {
                    const clickedAgentId = this.getAttribute('data-agent-id');

                    // Show loader
                    document.getElementById('loader').style.display = 'flex';

                    // If deselecting current agent
                    if (this.checked && selectedAgent && clickedAgentId === selectedAgent.id) {
                        await handleDeselect(this);
                    }
                    // Selecting a new agent
                    else {
                        await handleSelect(this, clickedAgentId);
                    }

                    // Hide loader
                    document.getElementById('loader').style.display = 'none';
                });
            });

            // Deselect handler
            async function handleDeselect(radioElement) {
                try {
                    // Uncheck the radio
                    radioElement.checked = false;

                    // Clear UI
                    if (sidebarContent) {
                        sidebarContent.innerHTML = '';
                    }

                    // Clear storage
                    sessionStorage.removeItem('selectedAgent');
                    selectedAgent = null;

                    // Send deselect request
                    const response = await fetch("{{ route('agent.deselect') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({})
                    });

                    if (!response.ok) throw new Error('Deselect failed');

                    // Only send negative agent update after successful deselect
                    await fetch("/update-negative-agent", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            agent_id: null
                        })
                    });

                    console.log('Agent deselected successfully');
                } catch (error) {
                    console.error('Error deselecting agent:', error);
                    // Revert UI if error occurs
                    radioElement.checked = true;
                }
            }

            // Select handler
            async function handleSelect(radioElement, agentId) {
                try {
                    // Uncheck all other radios
                    radioButtons.forEach(rb => {
                        if (rb !== radioElement) rb.checked = false;
                    });

                    // Store new selection
                    const agentData = {
                        id: agentId,
                        name: radioElement.getAttribute('data-agent-name'),
                        balance: radioElement.getAttribute('data-agent-balance'),
                        distributor: radioElement.getAttribute('data-agent-distributor'),
                        endpoint: radioElement.getAttribute('data-agent-endpoint')
                    };

                    sessionStorage.setItem('selectedAgent', JSON.stringify(agentData));
                    selectedAgent = agentData;

                    // First update UI
                    if (sidebarContent) {
                        const sidebarResponse = await fetch('/setting/sidebar/' + agentId);
                        if (!sidebarResponse.ok) throw new Error('Sidebar load failed');
                        sidebarContent.innerHTML = await sidebarResponse.text();
                    }

                    // Then send select request
                    const selectResponse = await fetch("{{ route('agent.select') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            agent_id: agentId
                        })
                    });

                    if (!selectResponse.ok) throw new Error('Select failed');

                    // Finally update negative agent
                    await fetch("/update-negative-agent", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            agent_id: agentId
                        })
                    });

                    console.log('Agent selected successfully');
                } catch (error) {
                    console.error('Error selecting agent:', error);
                    // Revert UI if error occurs
                    radioButtons.forEach(rb => rb.checked = false);
                    if (sidebarContent) sidebarContent.innerHTML =
                        '<p class="text-danger">Error loading agent settings</p>';
                }
            }
        });

        // Transfer functionality
        document.addEventListener('DOMContentLoaded', function() {
            const transferLink = document.getElementById('transfer-link');

            // Update transfer link when agent is selected
            function updateTransferLink() {
                const storedAgent = JSON.parse(sessionStorage.getItem('selectedAgent'));
                if (storedAgent) {
                    // Update the href to include agent ID as parameter
                    transferLink.href = "{{ route('transfer.page') }}?agent_id=" + storedAgent.id;
                    transferLink.classList.remove('disabled');
                } else {
                    transferLink.href = "#";
                    transferLink.classList.add('disabled');
                }
            }

            // Check selection on page load
            updateTransferLink();

            // Update when radio buttons are clicked
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('agent-radio')) {
                    setTimeout(updateTransferLink, 100);
                }
            });
        });

        // Copy to clipboard functionality
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text)
                .then(() => {
                    alert("Copied: " + text);
                })
                .catch(err => {
                    console.error("Failed to copy: ", err);
                });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('perPageForm');
            const select = document.getElementById('per_page');

            if (select) {
                select.addEventListener('change', function() {
                    // Update the force_per_page hidden field
                    const hiddenField = form.querySelector('input[name="force_per_page"]');
                    if (hiddenField) {
                        hiddenField.value = this.value;
                    }
                    form.submit();
                });
            }
        });
    </script>
@endsection
