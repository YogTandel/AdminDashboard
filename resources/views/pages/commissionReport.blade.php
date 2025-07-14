@extends('layouts.layout')

@section('page-name', 'Report')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
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
                                        <input type="number" id="totalEarnings" name="total_earnings" class="form-control"
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
                                        <input type="number" id="distributorPercent" name="distributor_commission"
                                            value="{{ $settings->distributorComission ?? 0.1 }}" class="form-control"
                                            min="0" max="100" step="0.01" required>
                                    </div>
                                    <div class="input-group mt-1">
                                        <span class="input-group-text"
                                            style="pointer-events: none; background-color: #e9ecef;">₹</span>
                                        <input type="text" id="distributorAmount" class="form-control" readonly
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
            <!-- End Distributor Commissions -->

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
                                        <input type="number" id="agentPercent" name="agent_commission"
                                            value="{{ $settings->agentComission ?? 5 }}" class="form-control" min="0"
                                            max="100" step="0.01" required>
                                    </div>
                                    <div class="input-group mt-1">
                                        <span class="input-group-text"
                                            style="pointer-events: none; background-color: #e9ecef;">₹</span>
                                        <input type="text" id="agentAmount" class="form-control" readonly
                                            style="pointer-events: none; background-color: #e9ecef;">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Agent Commissions -->


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
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Agent Name
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Release Date
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
                                                Commissions
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
                    date: '2023-08-01',
                    endpoint: 'alpha123',
                    winAmount: 200,
                    commission: 10
                },
                {
                    name: 'Agent Beta',
                    date: '2023-08-01',
                    endpoint: 'beta456',
                    winAmount: 150,
                    commission: 10
                }
            ],
            dist2: [{
                name: 'Agent Charlie',
                date: '2023-08-01',
                endpoint: 'charlie789',
                winAmount: 300,
                commission: 10
            }],
            dist3: [{
                    name: 'Agent Delta',
                    date: '2023-08-01',
                    endpoint: 'delta111',
                    winAmount: 100,
                    commission: 10
                },
                {
                    name: 'Agent Echo',
                    date: '2023-08-01',
                    endpoint: 'echo222',
                    winAmount: 80,
                    commission: 10
                },
                {
                    name: 'Agent Foxtrot',
                    endpoint: 'fox333',
                    winAmount: 50,
                    commission: 10
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
                    <td><p class="text-xs font-weight-bold mb-0">${agent.date}</p></td>
                    <td><p class="text-xs mb-0 text-secondary">${agent.endpoint}</p></td>
                    <td><p class="text-xs mb-0 text-secondary">${agent.commission}</p></td>
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

    <script>
        function calculateCommissionAmount(percent, total) {
            return ((percent / 100) * total).toFixed(2);
        }

        function updateAmounts() {
            const total = parseFloat(document.getElementById('totalEarnings').value) || 0;
            const agentPercent = parseFloat(document.getElementById('agentPercent').value) || 0;
            const distributorPercent = parseFloat(document.getElementById('distributorPercent').value) || 0;

            document.getElementById('agentAmount').value = calculateCommissionAmount(agentPercent, total);
            document.getElementById('distributorAmount').value = calculateCommissionAmount(distributorPercent, total);
        }

        document.getElementById('agentPercent').addEventListener('input', updateAmounts);
        document.getElementById('distributorPercent').addEventListener('input', updateAmounts);

        // Initial call
        updateAmounts();
    </script>

@endsection
