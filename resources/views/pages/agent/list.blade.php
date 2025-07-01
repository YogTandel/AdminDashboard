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
                    <!-- First Row -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
                        <h6 class="mb-0 ms-4 mt-3 text-bolder">Agent Users</h6>
                        <div class="d-flex align-items-center gap-2 flex-wrap mt-3 me-3">
                            <!-- Show Dropdown -->
                            <form method="GET" class="d-flex align-items-center mb-0">
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
                            </form>

                            <!-- Search -->
                            <form action="{{ route('agentlist.show') }}" method="GET" class="d-flex align-items-center">
                                <div class="input-group input-group-outline rounded-pill me-2 shadow-sm">
                                    <span class="input-group-text bg-transparent border-0 text-secondary">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <label class="form-label"></label>
                                    <input type="search" name="search" class="form-control border-0"
                                        onfocus="this.parentElement.classList.add('is-focused')"
                                        onfocusout="this.parentElement.classList.remove('is-focused')">
                                </div>
                                <button type="submit" class="btn bg-gradient-warning rounded-pill shadow-sm mb-0">
                                    Search
                                </button>
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
                            <option value="this_week" {{ request('date_range') == 'this_week' ? 'selected' : '' }}>This Week
                            </option>
                            <option value="this_month" {{ request('date_range') == 'this_month' ? 'selected' : '' }}>This
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

                        <!-- Filter Button -->
                        <button type="submit" class="btn btn-sm btn-primary  mb-0">Filter</button>

                        <!-- Reset Button -->
                        @if (request()->has('from_date') || request()->has('to_date') || request()->has('date_range'))
                            <a href="{{ route('agentlist.show') }}" class="btn btn-secondary btn-sm px-3 mt-3">Reset</a>
                        @endif
                    </form>

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
                                            Name
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
                                            endpoint
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
                                                    class="text-xs font-weight-bold text-dark">₹{{ number_format($agent->balance, 2) }}
                                                </span>
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
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0 text-dark">
                                                    {{ $agent->endpoint }}
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
                                                    
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input agent-radio" 
                                                                type="radio" 
                                                                name="agent_select" 
                                                                id="agentSwitch{{ $agent->id }}" 
                                                                value="{{ $agent->id }}"
                                                                data-agent-id="{{ $agent->id }}"
                                                                data-agent-name="{{ $agent->player }}"
                                                                data-agent-balance="{{ $agent->balance }}"
                                                                data-agent-distributor="{{ $agent->distributor }}"
                                                                data-agent-endpoint="{{ $agent->endpoint }}">
                                                        </div>

                                                    <!-- Edit Icon -->
                                                    <a href="javascript:;"
                                                        class="text-secondary font-weight-bold text-xs me-2"
                                                        title="Edit Agent" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $agent->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    @include('pages.agent.edit')

                                                    <!-- Delete Button -->
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

                                                    <!-- Transfer Icon -->
                                                    {{-- <a href="#" class="btn bg-gradient-info mb-0 text-white"
                                                        id="transfer-link">
                                                        <i class="fas fa-exchange-alt"></i>
                                                    </a> --}}

                                                    <!-- Block/Unblock Icon -->
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
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password copy functionality (existing)
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

        // Improved Agent Selection/Deselection
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
                
                // If deselecting current agent
                if (this.checked && selectedAgent && clickedAgentId === selectedAgent.id) {
                    await handleDeselect(this);
                } 
                // Selecting a new agent
                else {
                    await handleSelect(this, clickedAgentId);
                }
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
                    body: JSON.stringify({ agent_id: null })
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
                    body: JSON.stringify({ agent_id: agentId })
                });

                if (!selectResponse.ok) throw new Error('Select failed');

                // Finally update negative agent
                await fetch("/update-negative-agent", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ agent_id: agentId })
                });

                console.log('Agent selected successfully');
            } catch (error) {
                console.error('Error selecting agent:', error);
                // Revert UI if error occurs
                radioButtons.forEach(rb => rb.checked = false);
                if (sidebarContent) sidebarContent.innerHTML = '<p class="text-danger">Error loading agent settings</p>';
            }
        }
    });
    </script>

    <!-- Transfer -->
    <script>
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
    </script>
@endsection
