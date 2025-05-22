<div class="modal fade" id="playerHistoryModal-{{ $player->_id }}" tabindex="-1"
    aria-labelledby="playerHistoryLabel-{{ $player->_id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header pb-0">
                <div>
                    <h5 class="modal-title">
                        <i class="fas fa-history me-2"></i> Game History - {{ $player->player }}
                    </h5>
                    <p class="text-sm mb-0">
                        <span class="badge bg-gradient-primary">{{ count($player->gameHistory ?? []) }} records</span>
                        <span class="ms-2">Current balance: {{ number_format($player->balance, 2) }}</span>
                    </p>
                </div>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                @if (!empty($player->gameHistory))
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Time
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Bet</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Win</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Net</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Result</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bet
                                        Breakdown</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($player->gameHistory as $entry)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ \Carbon\Carbon::createFromFormat('YmdHis', $entry['stime'])->format('Y-m-d') }}
                                                    </h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        {{ \Carbon\Carbon::createFromFormat('YmdHis', $entry['stime'])->format('H:i:s') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                                class="badge badge-sm bg-gradient-info">{{ number_format($entry['playPoint']) }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                                class="badge badge-sm bg-gradient-success">{{ number_format($entry['winpoint']) }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @php
                                                $net = $entry['winpoint'] - $entry['playPoint'];
                                                $netClass = $net >= 0 ? 'bg-gradient-success' : 'bg-gradient-danger';
                                            @endphp
                                            <span
                                                class="badge badge-sm {{ $netClass }}">{{ number_format($net) }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge badge-sm bg-gradient-dark">{{ $entry['result'] }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="progress-wrapper w-100 mx-auto">
                                                <div class="progress-info">
                                                    <div class="progress-percentage">
                                                        <span class="text-xs font-weight-bold">Bet Distribution</span>
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    @foreach (array_slice($entry['betValues'], 0, 5) as $bet)
                                                        <div class="progress-bar bg-gradient-{{ ['info', 'primary', 'warning', 'danger', 'success'][$loop->index] }}"
                                                            role="progressbar"
                                                            style="width: {{ $entry['playPoint'] > 0 ? ($bet / $entry['playPoint']) * 100 : 0 }}%"
                                                            aria-valuenow="{{ $bet }}" aria-valuemin="0"
                                                            aria-valuemax="{{ $entry['playPoint'] }}">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="d-flex justify-content-between mt-1">
                                                    @foreach ($entry['betValues'] as $index => $bet)
                                                        <span class="text-xs">{{ $index + 1 }}:
                                                            {{ $bet }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-4 col-md-6 mb-lg-0 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="d-flex">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Bets</p>
                                            <h5 class="font-weight-bolder mb-0">
                                                {{ number_format(array_sum(array_column($player->gameHistory, 'playPoint'))) }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-lg-0 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="d-flex">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Wins</p>
                                            <h5 class="font-weight-bolder mb-0 text-success">
                                                {{ number_format(array_sum(array_column($player->gameHistory, 'winpoint'))) }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="d-flex">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Net Result</p>
                                            @php
                                                $totalNet =
                                                    array_sum(array_column($player->gameHistory, 'winpoint')) -
                                                    array_sum(array_column($player->gameHistory, 'playPoint'));
                                                $netClass = $totalNet >= 0 ? 'text-success' : 'text-danger';
                                            @endphp
                                            <h5 class="font-weight-bolder mb-0 {{ $netClass }}">
                                                {{ number_format($totalNet) }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card mt-4">
                        <div class="card-body text-center p-5">
                            <i class="fas fa-history text-secondary fa-3x mb-3"></i>
                            <h5 class="text-secondary">No game history available</h5>
                            <p class="text-sm text-muted">This player hasn't played any games yet.</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm bg-gradient-primary">Export Data</button>
            </div>
        </div>
    </div>
</div>
