@extends('layouts.layout')

@section('page-name', 'Report')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Agent Commissions -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-radius-xl">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">Agent Commissions</h6>
                    </div>
                    <div class="card-body pt-3">
                        <form method="POST">
                            @csrf
                            <input type="hidden" name="agent_id">

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Agent Commission</label>
                                    <div class="input-group">
                                        <span class="input-group-text">%</span>
                                        <input type="number" name="agent_commission"
                                            value="{{ $settings->agentComission ?? 5 }}" class="form-control"
                                            placeholder="e.g. 5" min="0" max="100" step="0.01" required>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Agent Commissions -->

            <!-- Distributor Commissions -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-radius-xl">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">Distributor Commissions</h6>
                    </div>
                    <div class="card-body pt-3">
                        <form method="POST">
                            @csrf
                            <input type="hidden" name="agent_id">

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Distributor Commission</label>
                                    <div class="input-group">
                                        <span class="input-group-text">%</span>
                                        <input type="number" name="distributor_commission"
                                            value="{{ $settings->distributorComission ?? 0.1 }}" class="form-control"
                                            placeholder="e.g. 0.10" min="0" max="100" step="0.01" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-3">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Distributor Commissions -->

            <!-- Total Earnings -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-radius-xl">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">Total Earnings</h6>
                    </div>
                    <div class="card-body pt-3">
                        <form method="POST">
                            @csrf
                            <input type="hidden" name="agent_id">

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Total Earnings</label>
                                    <div class="input-group">
                                        <span class="input-group-text"
                                            style="pointer-events: none; background-color: #e9ecef;">%</span>
                                        <input type="number" name="agent_commission" class="form-control"
                                            value="{{ $settings->winamount ?? 0.1 }}" min="0" max="100"
                                            step="0.01" readonly
                                            style="pointer-events: none; background-color: #e9ecef;">

                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-3">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Total Earnings -->

            <!-- Moved Distributor Dropdown Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-radius-xl mb-4">
                        <div class="card-body pt-3">
                            <label class="form-label">Select Distributor</label>
                            <select id="distributorSelect" class="form-select w-100" required>
                                <option value="">-- Select Distributor --</option>
                                <option value="dist1">Distributor A</option>
                                <option value="dist2">Distributor B</option>
                                <option value="dist3">Distributor C</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Moved Distributor Dropdown Section -->

            <!-- Dynamic Agent Summary Table Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border-radius-xl">
                        <div class="card-header pb-0">
                            <h6 class="mb-0">Agent Summary</h6>
                        </div>
                        <div class="card-body pt-3">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Agent Name
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Endpoint
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Win Amount
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="agentTableBody">
                                        <tr>
                                            <td colspan="4" class="text-muted">No agents to display.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Dynamic Agent Summary Table Section -->

        </div>
    </div>


    <script>
        const distributorAgents = {
            dist1: [{
                    name: 'Agent Alpha',
                    endpoint: 'alpha123',
                    winAmount: 200
                },
                {
                    name: 'Agent Beta',
                    endpoint: 'beta456',
                    winAmount: 150
                }
            ],
            dist2: [{
                name: 'Agent Charlie',
                endpoint: 'charlie789',
                winAmount: 300
            }],
            dist3: [{
                    name: 'Agent Delta',
                    endpoint: 'delta111',
                    winAmount: 100
                },
                {
                    name: 'Agent Echo',
                    endpoint: 'echo222',
                    winAmount: 80
                },
                {
                    name: 'Agent Foxtrot',
                    endpoint: 'fox333',
                    winAmount: 50
                }
            ]
        };

        const distributorSelect = document.getElementById('distributorSelect');
        const agentTableBody = document.getElementById('agentTableBody');

        distributorSelect.addEventListener('change', function() {
            const selected = this.value;
            const agents = distributorAgents[selected] || [];

            // Clear existing table rows
            agentTableBody.innerHTML = '';

            // If agents exist for selected distributor, populate table
            if (agents.length > 0) {
                agents.forEach(agent => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <td><p class="text-xs font-weight-bold mb-0">${agent.name}</p></td>
                    <td><p class="text-xs mb-0 text-secondary">${agent.endpoint}</p></td>
                    <td><p class="text-xs mb-0 text-success fw-bold">₹${agent.winAmount}</p></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-success">
                            Release
                        </button>
                    </td>
                `;
                    agentTableBody.appendChild(tr);
                });
            } else {
                // Fallback row if no agents
                const tr = document.createElement('tr');
                tr.innerHTML = `<td colspan="4" class="text-muted">No agents to display.</td>`;
                agentTableBody.appendChild(tr);
            }
        });
    </script>

@endsection
