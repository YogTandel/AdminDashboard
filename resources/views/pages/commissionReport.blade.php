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
                                <div class="col-md-6">
                                    <label class="form-label">Commission (%)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"
                                            style="pointer-events: none; background-color: #e9ecef;">%</span>
                                        <input type="number" id="distributorPercent" name="distributor_commission"
                                            value="{{ $settings->distributorComission ?? 0.1 }}" class="form-control"
                                            min="0" max="100" step="0.01" readonly
                                            style="pointer-events: none; background-color: #e9ecef;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Amount (₹)</label>
                                    <div class="input-group">
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
                                <div class="col-md-6">
                                    <label class="form-label">Commission (%)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"
                                            style="pointer-events: none; background-color: #e9ecef;">%</span>
                                        <input type="number" id="agentPercent" name="agent_commission"
                                            value="{{ $settings->agentComission ?? 5 }}" class="form-control" min="0"
                                            max="100" step="0.01" readonly
                                            style="pointer-events: none; background-color: #e9ecef;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Amount (₹)</label>
                                    <div class="input-group">
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


            <!-- Distributor Dropdown Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-radius-xl mb-4">
                        <div class="card-body py-4 px-4">
                            <div class="d-flex flex-wrap gap-4 align-items-end">
                                <div class="d-flex flex-column" style="min-width: 180px;">
                                    <label class="form-label mb-1">Select Distributor</label>
                                    <select id="distributorSelect" class="form-select" required>
                                        <option value="">-- Select --</option>
                                        <option value="dist1">Distributor A</option>
                                        <option value="dist2">Distributor B</option>
                                        <option value="dist3">Distributor C</option>
                                    </select>
                                </div>

                                <!-- Last Release -->
                                <div class="d-flex flex-column" style="min-width: 130px;">
                                    <label class="form-label mb-1">Last Release</label>
                                    <div class="form-control bg-light" id="distLastRelease">2025-07-05</div>
                                </div>

                                <!-- Endpoint -->
                                <div class="d-flex flex-column" style="min-width: 130px;">
                                    <label class="form-label mb-1">Endpoint</label>
                                    <div class="form-control bg-light" id="distEndpoint">distA-001</div>
                                </div>

                                <!-- Win Amount -->
                                <div class="d-flex flex-column" style="min-width: 130px;">
                                    <label class="form-label mb-1">Win Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">₹</span>
                                        <div class="form-control bg-light" id="distWinAmount">4200</div>
                                    </div>
                                </div>

                                <!-- Commission -->
                                <div class="d-flex flex-column" style="min-width: 130px;">
                                    <label class="form-label mb-1">Commission</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">%</span>
                                        <div class="form-control bg-light" id="distCommission">4.5</div>
                                    </div>
                                </div>

                                <!-- Release Button -->
                                <div class="d-flex flex-column" style="min-width: 130px;">
                                    <label class="form-label mb-1 invisible">Placeholder</label>
                                    <button type="button" class="btn btn-success w-100 mb-0" id="releaseButton">
                                        Release
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Distributor Dropdown Section -->

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
                                                Lst Release
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
        function calculateAmount(percent, total) {
            return ((percent / 100) * total).toFixed(2);
        }

        function updateCommissionAmounts() {
            const total = parseFloat(document.getElementById('totalEarnings')?.value || 0);

            const agentPercent = parseFloat(document.getElementById('agentPercent')?.value || 0);
            document.getElementById('agentAmount').value = calculateAmount(agentPercent, total);

            const distributorPercent = parseFloat(document.getElementById('distributorPercent')?.value || 0);
            document.getElementById('distributorAmount').value = calculateAmount(distributorPercent, total);
        }

        // Run on page load
        window.addEventListener('DOMContentLoaded', updateCommissionAmounts);
    </script>

    <script>
        const distributorData = {
            dist1: {
                lastRelease: '2025-07-05',
                endpoint: 'distA-001',
                winAmount: 4200,
                commission: 4.5
            },
            dist2: {
                lastRelease: '2025-07-08',
                endpoint: 'distB-789',
                winAmount: 3400,
                commission: 3.2
            },
            dist3: {
                lastRelease: '2025-07-11',
                endpoint: 'distC-123',
                winAmount: 2800,
                commission: 5.0
            }
        };

        document.getElementById('distributorSelect').addEventListener('change', function() {
            const data = distributorData[this.value];
            if (data) {
                document.getElementById('distLastRelease').value = data.lastRelease;
                document.getElementById('distEndpoint').value = data.endpoint;
                document.getElementById('distWinAmount').value = data.winAmount;
                document.getElementById('distCommission').value = data.commission;
            } else {
                document.getElementById('distLastRelease').value = '';
                document.getElementById('distEndpoint').value = '';
                document.getElementById('distWinAmount').value = '';
                document.getElementById('distCommission').value = '';
            }
        });
    </script>



@endsection
