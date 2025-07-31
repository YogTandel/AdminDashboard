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
                                    <input type="number" id="totalEarnings" name="total_earnings" class="form-control"
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
                                            value="0.1" class="form-control" min="0" max="100" step="0.01"
                                            readonly style="pointer-events: none; background-color: #e9ecef;">
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
                                        <input type="number" id="agentPercent" name="agent_commission" value="5"
                                            class="form-control" min="0" max="100" step="0.01" readonly
                                            style="pointer-events: none; background-color: #e9ecef;">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Amount (₹)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"
                                            style="pointer-events: none; background-color: #e9ecef;">₹</span>
                                        <input type="text" id="agentamount" class="form-control" readonly value=""
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
            <div class="row" id="distributorDropdown">
                <div class="col-12">
                    <div class="card shadow-sm border-radius-xl mb-4">
                        <div class="card-body py-4 px-4">
                            <div class="d-flex flex-wrap gap-4 align-items-end gap-5">
                                <div class="d-flex flex-column" style="min-width: 290px;">
                                    <label>Distributor</label>
                                    <div class="input-group">
                                        <select id="distributor_id" name="distributor_id" class="form-control" required>
                                            <option value="">-- Select Distributor --</option>
                                            {{-- Options will be loaded here via JS --}}
                                        </select>
                                    </div>

                                    <input type="hidden" name="distributor" id="distributor" value="">
                                </div>

                                <!-- Last Release -->
                                <!-- <div class="d-flex flex-column" style="min-width: 140px;">
                                    <label class="form-label">Last Release</label>
                                    <div class="form-control bg-light" id="releaseDateBox">N/A</div>
                                </div> -->

                                <!-- Endpoint -->
                                <div class="d-flex flex-column" style="min-width: 190px;">
                                    <label class="form-label mb-1"> Balance</label>
                                    <div class="form-control bg-light" id="distEndpoint">N/A</div>
                                </div>

                                <!-- Win Amount -->
                                <div class="d-flex flex-column" style="min-width: 190px;">
                                    <label class="form-label mb-1">Play Amount</label>
                                    <div class="input-group">
                                        <div class="form-control bg-light" id="distWinAmount">0</div>
                                    </div>
                                </div>

                                <!-- Commission -->
                                <div class="d-flex flex-column" style="min-width: 190px;">
                                    <label class="form-label mb-1">Commission</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">₹</span>
                                        <div class="form-control bg-light" id="distCommission">0</div>
                                    </div>
                                </div>

                                <!-- Release Button -->
                                <!-- <div class="d-flex flex-column" style="min-width: 140px;">
                                    <label class="form-label mb-1 invisible">Placeholder</label> -->
                                    <!-- <button type="button" class="btn btn-success w-100 mb-0" id="releaseButton">
                                                                                                Release
                                                                                            </button> -->
                                <!-- </div> -->

                                <input type="hidden" id="totalBet" value="0">
                                <input type="hidden" id="distCommissionPercentage" value="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Distributor Dropdown Section -->

            <!-- Dynamic Agent Summary Table Section -->
            <div class="row mt-4" id="agentSummaryTable">
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
                                                Last Release
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Balance
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Play amount
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var totalWinpointSum = {{ $totalWinpointSum }};
        //alert(totalWinpointSum);
        function fetchLiveGameValues() {
            fetch("{{ route('settings.data') }}")
                .then(response => response.json())
                .then(data => {

                    document.getElementById('totalEarnings').value = data.earning;

                    document.getElementById('distributorPercent').value = data.distributorComission;

                    document.getElementById('agentPercent').value = data.agentComission;

                    // document.getElementById('distributoramount').value = totalWinpointSum*(data.distributorComission/100).toFixed(2);
                    document.getElementById('distributoramount').value = (totalWinpointSum * (data.distributorComission /
                        100)).toFixed(2);
                    document.getElementById('agentamount').value = (totalWinpointSum * (data.agentComission / 100))
                        .toFixed(2);

                    //if totalEarnings is zero then hide the distributorDropdown, agentSummaryTable
                    if (data.earning == 0) {
                        document.getElementById('distributorDropdown').style.display = 'none';
                        document.getElementById('agentSummaryTable').style.display = 'none';
                    }


                })
                .catch(error => console.error('Error fetching live game values:', error));
        }

        fetchLiveGameValues();
        setInterval(fetchLiveGameValues, 5000);
    </script>

    <script>
        var distributordata = [];

        $(document).ready(function() {
            // Load all distributors in dropdown on page load
            $.ajax({
                url: '/ajax/distributors',
                method: 'GET',
                success: function(data) {
                    console.log('Distributors:', data);
                    let $select = $('#distributor_id');
                    $select.empty().append('<option value="">-- Select Distributor --</option>');
                    data.forEach(function(item) {
                        $select.append(
                            `<option value="${item.id}" data-name="${item.name}">${item.name}</option>`
                        );
                        distributordata[item.id] = item;
                    });
                },
                error: function() {
                    alert('Distributor list load failed');
                }
            });

            // On distributor change
            $('#distributor_id').on('change', function() {
                let id = $(this).val();
                let selectedName = $(this).find(':selected').data('name') || '';
                $('#distributor').val(selectedName);
                $('#distEndpoint').text(distributordata[id]?.endpoint ?? 'N/A');

                let releaseDateRaw = distributordata[id]?.release_date;
                $('#releaseDateBox').text(releaseDateRaw ? new Date(releaseDateRaw).toLocaleString(
                    'en-IN', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    }) : 'N/A');

                if (!id) {
                    clearFields();
                    return;
                }

                // Fetch distributor details (includes agents)
                $.ajax({
                    url: `/ajax/distributor/${id}`,
                    method: 'GET',
                    success: function(data) {
                        console.log('Distributor details:', data);
                        const distributorpercentage = $('#distributorPercent').val();
                        const agentpercentage = $('#agentPercent').val();

                        $('#distWinAmount').text(data.totalWinpointSum_distributor);
                        const commission = ((data.totalWinpointSum_distributor) * (
                            distributorpercentage / 100)).toFixed(2);
                        $('#distCommission').text(commission);

                        const releaseAllowed = !(parseInt(commission) <= 0);

                        const agentTableBody = $('#agentTableBody');
                        agentTableBody.empty();

                        if (data.agent && data.agent.length > 0) {
                            data.agent.forEach(function(agent) {
                                console.log('Agent object:', agent);

                                // Determine correct agent id field
                                const agentId = agent._id || agent.id || agent.agent_id;
                                const agentCommission = (agent.winAmount * (
                                    agentpercentage / 100)).toFixed(2);
                                const isDisabled = parseInt(agentCommission) <= 0;

                                const row = /* HTML */ `
                        <tr>
                            <td><p class="text-xs font-weight-bold mb-0">${agent.name}</p></td>
                            <td><p class="text-xs font-weight-bold mb-0">${agent.date || '-'}</p></td>
                            <td><p class="text-xs mb-0 text-secondary">${agent.endpoint}</p></td>
                            <td><p class="text-xs mb-0 text-success fw-bold agent-win-amount">₹${agent.winAmount}</p></td>
                            <td><p class="text-xs mb-0 text-secondary agent-commission">₹${agentCommission}</p></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success agent-release-btn"
                                    data-agentid="${agentId}"
                                    data-agent-name="${agent.name}"
                                    data-win-amount="${agent.winAmount}"
                                    data-agent-commission="${agentCommission}"
                                    ${isDisabled ? 'disabled style="opacity:0.6; cursor:not-allowed;"' : ''}>
                                    Release
                                </button>
                            </td>
                        </tr>`;
                                agentTableBody.append(row);
                            });
                        } else {
                            agentTableBody.html(
                                '<tr><td colspan="6" class="text-muted">No agents to display.</td></tr>'
                            );
                        }

                        $('#releaseButton').prop('disabled', !releaseAllowed);
                    },
                    error: function() {
                        clearFields();
                        alert('Could not fetch distributor details');
                    }
                });
            });

            // Agent release button
            $(document).on('click', '.agent-release-btn', function() {
                const $button = $(this);
                const $row = $button.closest('tr');
                const agentId = $button.data('agentid');
                const distributorId = $('#distributor_id').val();
                const agentName = $button.data('agent-name');
                const winAmount = parseInt($button.data('win-amount'));
                const commissionAmount = parseFloat($button.data('agent-commission'));

                if (!distributorId || !agentId || isNaN(commissionAmount) || commissionAmount <= 0 || isNaN(
                        winAmount) || winAmount <= 0) {
                    alert('Invalid agent data.');
                    return;
                }

                if (!confirm(
                        `Are you sure you want to release ₹${(commissionAmount/100).toFixed(2)} commission to ${agentName}?`
                    )) {
                    return;
                }

                $.ajax({
                    url: '/release-commission',
                    method: 'POST',
                    data: {
                        transfer_to: agentId,
                        distributor_id: distributorId,
                        name: agentName,
                        type: 'agent',
                        total_bet: winAmount,
                        commission_amount: commissionAmount,
                        win_amount: winAmount,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        // Update the UI without reloading the page
                        $row.find('.agent-win-amount').text('₹0');
                        $row.find('.agent-commission').text('₹0');
                        $button.prop('disabled', true).css({
                            'opacity': '0.6',
                            'cursor': 'not-allowed'
                        });

                        // Update the distributor totals
                        const currentWin = parseInt($('#distWinAmount').text());
                        const currentComm = parseFloat($('#distCommission').text());
                        $('#distWinAmount').text(currentWin - winAmount);
                        $('#distCommission').text((currentComm - (commissionAmount / 100))
                            .toFixed(2));

                        alert('Agent Commission Released Successfully!');
                        fetchLiveGameValues();
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON?.error || 'Failed to release agent commission.');
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



@endsection
