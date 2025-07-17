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
        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Total Earnings</label>
                <div class="input-group">
                    <input type="number" id="totalEarnings"  name="total_earnings" class="form-control"
                        value="0.1" min="0" max="100" step="0.01" readonly
                        style="pointer-events: none; background-color: #e9ecef;">
                </div>
            </div>
        </div>
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
                                            value="0.1" class="form-control" min="0" max="100" step="0.01" readonly
                                            style="pointer-events: none; background-color: #e9ecef;">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Amount (₹)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"
                                            style="pointer-events: none; background-color: #e9ecef;">₹</span>
                                        <input type="text" id="distributoramount" class="form-control" readonly 
                                        value="{{ number_format($totalWinpointSum * 0.01, 2) }}" 
                                        style="background-color: #e9ecef; pointer-events: none;">

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
                                            value="5" class="form-control" min="0" max="100" step="0.01" readonly
                                            style="pointer-events: none; background-color: #e9ecef;">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Amount (₹)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"
                                            style="pointer-events: none; background-color: #e9ecef;">₹</span>
                                        <input type="text" id="agentamount" class="form-control" readonly 
                                        value="" 
                                        style="background-color: #e9ecef; pointer-events: none;">
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
                                <div class="d-flex flex-column me-5" style="min-width: 250px;">
                                    <label>Distributor</label>
                                    <div class="input-group mb-3">
                                        <select id="distributor_id" name="distributor_id" class="form-control" required>
                                            <option value="">-- Select Distributor --</option>
                                            {{-- Options will be loaded here via JS --}}
                                        </select>
                                    </div>

                                    <input type="hidden" name="distributor" id="distributor" value="">
                                </div>

                                <!-- Last Release -->
                                <div class="d-flex flex-column" style="min-width: 140px;">
                                    <label class="form-label mb-1">Last Release</label>
                                    <div class="form-control bg-light" id="releaseDateBox">N/A</div>
                                </div>

                                <!-- Endpoint -->
                                <div class="d-flex flex-column" style="min-width: 140px;">
                                    <label class="form-label mb-1">Endpoint</label>
                                    <div class="form-control bg-light" id="distEndpoint">N/A</div>
                                </div>

                                <!-- Win Amount -->
                                <div class="d-flex flex-column" style="min-width: 140px;">
                                    <label class="form-label mb-1">Win Amount</label>
                                    <div class="input-group">
                                        <div class="form-control bg-light" id="distWinAmount">0</div>
                                    </div>
                                </div>

                                <!-- Commission -->
                                <div class="d-flex flex-column" style="min-width: 140px;">
                                    <label class="form-label mb-1">Commission</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">₹</span>
                                        <div class="form-control bg-light" id="distCommission">0</div>
                                    </div>
                                </div>

                                <!-- Release Button -->
                                <div class="d-flex flex-column" style="min-width: 140px;">
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
<!-- 
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
    </script> -->

<script>
    var totalWinpointSum={{ $totalWinpointSum  }};
    //alert(totalWinpointSum);
    function fetchLiveGameValues() {
        fetch("{{ route('settings.data') }}")
            .then(response => response.json())
            .then(data => {
        
                document.getElementById('totalEarnings').value = data.earning;

                document.getElementById('distributorPercent').value = data.distributorComission;

                document.getElementById('agentPercent').value = data.agentComission;

                // document.getElementById('distributoramount').value = totalWinpointSum*(data.distributorComission/100).toFixed(2);
                 document.getElementById('distributoramount').value = totalWinpointSum * (data.distributorComission / 100).toFixed(2);
                 document.getElementById('agentamount').value = totalWinpointSum*(data.agentComission/100).toFixed(2);

               
            })
            .catch(error => console.error('Error fetching live game values:', error));
    }

    fetchLiveGameValues(); 
    setInterval(fetchLiveGameValues, 5000); 
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- <script>
$(document).ready(function () {
    // Load all distributors in dropdown on page load
    $.ajax({
        url: '/ajax/distributors',
        method: 'GET',
        success: function (data) {
            let $select = $('#distributor_id');
            $select.empty().append('<option value="">-- Select Distributor --</option>');
            data.forEach(function (item) {
                $select.append(`<option value="${item.id}" data-name="${item.name}">${item.name}</option>`);
            });
        },
        error: function () {
            alert('Distributor list load failed');
        }
    });

    // On distributor change
    $('#distributor_id').on('change', function () {
        let id = $(this).val();
        let selectedName = $(this).find(':selected').data('name') || '';
        $('#distributor').val(selectedName); // hidden input update

        if (!id) {
            clearFields();
            return;
        }

        $.ajax({
            url: `/ajax/distributor/${id}`, // Calls getDistributorDetails($id)
            method: 'GET',
            success: function (data) {
                $('#distEndpoint').text(data.endpoint ?? 'N/A');
                $('#distWinAmount').text(data.winamount ?? 0);  // Note key is 'winamount' from your PHP code
                $('#distCommission').text(data.commission ?? 0);
            },
            error: function () {
                clearFields();
                alert('Could not fetch distributor details');
            }
        });
    });

    function clearFields() {
        $('#distEndpoint').text('N/A');
        $('#distWinAmount').text('0');
        $('#distCommission').text('0');
        $('#distributor').val('');
    }
});
</script> -->

<!-- <script>
var distributordata=[];    
$(document).ready(function () {
    // Load all distributors in dropdown on page load
    $.ajax({
        url: '/ajax/distributors',
        method: 'GET',
        success: function (data) {
            console.log(data);
            let $select = $('#distributor_id');
            $select.empty().append('<option value="">-- Select Distributor --</option>');
            data.forEach(function (item) {
                $select.append(`<option value="${item.id}" data-name="${item.name}">${item.name}</option>`);
                distributordata[item.id] = item;
            });
        },
        error: function () {
            alert('Distributor list load failed');
        }
    });

    // On distributor change
    $('#distributor_id').on('change', function () {
        let id = $(this).val();
        let selectedName = $(this).find(':selected').data('name') || '';
        $('#distributor').val(selectedName); // hidden input update
        $('#distEndpoint').text(distributordata[id].endpoint);
        $('#releaseDateBox').text(distributordata[id].release_date);

        if (!id) {
            clearFields();
            return;
        }
        

        $.ajax({
            url: `/ajax/distributor/${id}`, 
            method: 'GET',
            success: function (data) {
                console.log(data);
                var distributorpercentage=$('#distributorPercent').val();
                //$('#distEndpoint').text(data.endpoint ?? 'N/A');
                $('#distWinAmount').text(data.totalWinpointSum_distributor ); 
                let commission = ((data.totalWinpointSum_distributor) * (distributorpercentage/100)).toFixed(2);
                $('#distCommission').text(commission);

                if (id && parseFloat(commission) >= 0) {
                    $('#releaseButton').prop('disabled', false);
                } else {
                    $('#releaseButton').prop('disabled', true);
                }
                 
            },
            
            error: function () {
                clearFields();
                alert('Could not fetch distributor details');
            }
        });
    });

    function clearFields() {
     
         $('#releaseDateBox').text('N/A')
         $('#distEndpoint').text('N/A');
        $('#distWinAmount').text('0');
        $('#distCommission').text('0');
        $('#distributor').val('');
         $('#releaseButton').prop('disabled', true);
    }
    $('#releaseButton').prop('disabled', true);
});
</script> -->

<script>
var distributordata = [];

$(document).ready(function () {
    // Load all distributors in dropdown on page load
    $.ajax({
        url: '/ajax/distributors',
        method: 'GET',
        success: function (data) {
            console.log(data);
            let $select = $('#distributor_id');
            $select.empty().append('<option value="">-- Select Distributor --</option>');
            data.forEach(function (item) {
                $select.append(`<option value="${item.id}" data-name="${item.name}">${item.name}</option>`);
                distributordata[item.id] = item;
            });
        },
        error: function () {
            alert('Distributor list load failed');
        }
    });

    // On distributor change
    $('#distributor_id').on('change', function () {
        let id = $(this).val();
        let selectedName = $(this).find(':selected').data('name') || '';
        $('#distributor').val(selectedName); // hidden input update
        $('#distEndpoint').text(distributordata[id]?.endpoint ?? 'N/A');
        $('#releaseDateBox').text(distributordata[id]?.release_date ?? 'N/A');

        if (!id) {
            clearFields();
            return;
        }

        // Fetch distributor details (also includes agents)
        $.ajax({
            url: `/ajax/distributor/${id}`, 
            method: 'GET',
            success: function (data) {
                console.log(data);
                var distributorpercentage = $('#distributorPercent').val();
                var agentpercentage = $('#agentPercent').val();
                
                $('#distWinAmount').text(data.totalWinpointSum_distributor); 
                let commission = ((data.totalWinpointSum_distributor) * (distributorpercentage / 100)).toFixed(2);
                $('#distCommission').text(commission);
                //alert(commission);    
                let releaseAllowed = true;

                // Check if distributor commission is valid
                if (!id || parseFloat(commission) <= 0) {
                    releaseAllowed = false;
                }

                // ✅ Populate agent table from data.agent
                const agentTableBody = $('#agentTableBody');
                agentTableBody.empty();

                if (data.agent && data.agent.length > 0) {
                    data.agent.forEach(function (agent) {
                        const row = `
                            <tr>
                                <td><p class="text-xs font-weight-bold mb-0">${agent.name}</p></td>
                                <td><p class="text-xs font-weight-bold mb-0">${agent.date || '-'}</p></td>
                                <td><p class="text-xs mb-0 text-secondary">${agent.endpoint}</p></td>
                                <td><p class="text-xs mb-0 text-success fw-bold">₹${agent.winAmount}</p></td>
                                <td><p class="text-xs mb-0 text-secondary">${agent.winAmount*(agentpercentage/100).toFixed(2)}</p></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success">
                                        Release
                                    </button>
                                </td>
                            </tr>
                        `;
                        agentTableBody.append(row);

                        // Check agent commission
                        if (parseFloat(agent.commission) <= 0) {
                            releaseAllowed = false;
                        }
                    });
                } else {
                    agentTableBody.html('<tr><td colspan="6" class="text-muted">No agents to display.</td></tr>');
                }

                // Final check: only enable release button if all commissions > 0
                $('#releaseButton').prop('disabled', !releaseAllowed);
            },
            error: function () {
                clearFields();
                alert('Could not fetch distributor details');
            }
        });
    });

    function clearFields() {
        $('#releaseDateBox').text('N/A');
        $('#distEndpoint').text('N/A');
        $('#distWinAmount').text('0');
        $('#distCommission').text('0');
        $('#distributor').val('');
        $('#releaseButton').prop('disabled', true);
        $('#agentTableBody').html('<tr><td colspan="6" class="text-muted">No agents to display.</td></tr>');
    }

    $('#releaseButton').prop('disabled', true);
});
</script>



<!-- <script>
var distributordata = [];

$(document).ready(function () {
    // Load all distributors in dropdown on page load
    $.ajax({
        url: '/ajax/distributors',
        method: 'GET',
        success: function (data) {
            console.log(data);
            let $select = $('#distributor_id');
            $select.empty().append('<option value="">-- Select Distributor --</option>');
            data.forEach(function (item) {
                $select.append(`<option value="${item.id}" data-name="${item.name}">${item.name}</option>`);
                distributordata[item.id] = item;
            });
        },
        error: function () {
            alert('Distributor list load failed');
        }
    });

    // On distributor change
    $('#distributor_id').on('change', function () {
        let id = $(this).val();
        let selectedName = $(this).find(':selected').data('name') || '';
        $('#distributor').val(selectedName); // hidden input update
        $('#distEndpoint').text(distributordata[id]?.endpoint ?? 'N/A');
        $('#releaseDateBox').text(distributordata[id]?.release_date ?? 'N/A');

        if (!id) {
            clearFields();
            return;
        }

        // Fetch distributor details (also includes agents)
        $.ajax({
            url: `/ajax/distributor/${id}`, 
            method: 'GET',
            success: function (data) {
                console.log(data);
                var distributorpercentage = $('#distributorPercent').val();
                $('#distWinAmount').text(data.totalWinpointSum_distributor); 
                let commission = ((data.totalWinpointSum_distributor) * (distributorpercentage / 100)).toFixed(2);
                $('#distCommission').text(commission);

                if (id && parseFloat(commission) >= 0) {
                    $('#releaseButton').prop('disabled', false);
                } else {
                    $('#releaseButton').prop('disabled', true);
                }

                // ✅ Populate agent table from data.agent
                const agentTableBody = $('#agentTableBody');
                agentTableBody.empty();

                if (data.agent && data.agent.length > 0) {
                    data.agent.forEach(function (agent) {
                        const row = `
                            <tr>
                                <td><p class="text-xs font-weight-bold mb-0">${agent.name}</p></td>
                                <td><p class="text-xs font-weight-bold mb-0">${agent.date || '-'}</p></td>
                                <td><p class="text-xs mb-0 text-secondary">${agent.endpoint}</p></td>
                                <td><p class="text-xs mb-0 text-success fw-bold">₹${agent.winAmount}</p></td>
                                <td><p class="text-xs mb-0 text-secondary">${agent.commission}%</p></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-success">
                                        Release
                                    </button>
                                </td>
                            </tr>
                        `;
                        agentTableBody.append(row);
                    });

                } else {
                    agentTableBody.html('<tr><td colspan="6" class="text-muted">No agents to display.</td></tr>');
                }
            },
            error: function () {
                clearFields();
                alert('Could not fetch distributor details');
            }
        });
    });

    function clearFields() {
        $('#releaseDateBox').text('N/A');
        $('#distEndpoint').text('N/A');
        $('#distWinAmount').text('0');
        $('#distCommission').text('0');
        $('#distributor').val('');
        $('#releaseButton').prop('disabled', true);
        $('#agentTableBody').html('<tr><td colspan="6" class="text-muted">No agents to display.</td></tr>');
    }

    $('#releaseButton').prop('disabled', true);
});
</script> -->

@endsection
