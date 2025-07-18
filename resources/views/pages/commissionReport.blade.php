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
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-radius-xl mb-4">
                        <div class="card-body py-4 px-4">
                            <div class="d-flex flex-wrap gap-4 align-items-end">
                                <div class="d-flex flex-column" style="min-width: 250px;">
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
                                <div class="d-flex flex-column" style="min-width: 140px;">
                                    <label class="form-label">Last Release</label>
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

                                <input type="hidden" id="totalBet" value="0">
                                <input type="hidden" id="distCommissionPercentage" value="0">
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
                    document.getElementById('distributoramount').value = totalWinpointSum * (data.distributorComission /
                        100).toFixed(2);
                    document.getElementById('agentamount').value = totalWinpointSum * (data.agentComission / 100)
                        .toFixed(2);


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
                    console.log(data);
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
                $('#distributor').val(selectedName); // hidden input update
                $('#distEndpoint').text(distributordata[id]?.endpoint ?? 'N/A');
                let releaseDateRaw = distributordata[id]?.release_date;
                let releaseDateFormatted = 'N/A';
                if (releaseDateRaw) {
                    let date = new Date(releaseDateRaw);
                    releaseDateFormatted = date.toLocaleString('en-IN', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });
                }
                $('#releaseDateBox').text(releaseDateFormatted);

                if (!id) {
                    clearFields();
                    return;
                }

                // Fetch distributor details (also includes agents)
                $.ajax({
                    url: `/ajax/distributor/${id}`,
                    method: 'GET',
                    success: function(data) {
                        console.log(data);
                        var distributorpercentage = $('#distributorPercent').val();
                        var agentpercentage = $('#agentPercent').val();

                        $('#distWinAmount').text(data.totalWinpointSum_distributor);
                        let commission = ((data.totalWinpointSum_distributor) * (
                            distributorpercentage / 100)).toFixed(2);
                        $('#distCommission').text(commission);
                        let releaseAllowed = true;

                        if (!id || parseFloat(commission) <= 0) {
                            releaseAllowed = false;
                        }

                        const agentTableBody = $('#agentTableBody');
                        agentTableBody.empty();

                        if (data.agent && data.agent.length > 0) {
                            data.agent.forEach(function(agent) {
                                const agentCommission = (agent.winAmount * (
                                    agentpercentage / 100)).toFixed(2);
                                const isDisabled = parseFloat(agentCommission) <= 0;

                                const row = `
                                <tr>
                                    <td><p class="text-xs font-weight-bold mb-0">${agent.name}</p></td>
                                    <td><p class="text-xs font-weight-bold mb-0">${agent.date || '-'}</p></td>
                                    <td><p class="text-xs mb-0 text-secondary">${agent.endpoint}</p></td>
                                    <td><p class="text-xs mb-0 text-success fw-bold">₹${agent.winAmount}</p></td>
                                    <td><p class="text-xs mb-0 text-secondary">₹${agentCommission}</p></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success"
                                            ${isDisabled ? 'disabled style="opacity:0.6; cursor:not-allowed;"' : ''}>
                                            Release
                                        </button>
                                    </td>
                                </tr>
                            `;
                                agentTableBody.append(row);

                                // if (isDisabled) {
                                //     releaseAllowed = false;
                                // }
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

            $('#releaseButton').on('click', function() {
                const distributorId = $('#distributor_id').val();
                const commissionAmount = parseFloat($('#distCommission').text());
                const commissionPercentage = parseFloat($('#distributorPercent').val());
                const winAmount = parseFloat($('#distWinAmount').text());

                if (!distributorId || isNaN(commissionAmount) || commissionAmount <= 0 || isNaN(
                        commissionPercentage) || isNaN(winAmount) || winAmount <= 0) {
                    alert('Invalid input: Check Distributor, Total Bet, or Commission %');
                    return;
                }

                $.ajax({
                    url: '/release-commission',
                    method: 'POST',
                    data: {
                        transfer_to: distributorId,
                        type: 'distributor',
                        total_bet: winAmount,
                        commission_percentage: commissionPercentage,
                        win_amount: winAmount,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        alert('Commission Released Successfully!');
                        fetchLiveGameValues(); // Refresh live values if needed
                        $('#releaseButton').prop('disabled', true);
                        $('#releaseDateBox').text(res.released_at || new Date()
                        .toLocaleString());
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON?.error || 'Failed to release commission.');
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
