<div class="modal fade" id="playerHistoryModal-{{ $player->_id }}" tabindex="-1"
    aria-labelledby="playerHistoryLabel-{{ $player->_id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="playerHistoryLabel-{{ $player->_id }}">Game History - {{ $player->player }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (!empty($player->gameHistory))
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Time</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Play Point
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Win Point</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">End Point</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Result</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Bet Values
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($player->gameHistory as $entry)
                                    <tr>
                                        <td class="text-xs">
                                            {{ \Carbon\Carbon::createFromFormat('YmdHis', $entry['stime'])->format('Y-m-d H:i:s') }}
                                        </td>
                                        <td class="text-xs">{{ $entry['playPoint'] }}</td>
                                        <td class="text-xs">{{ $entry['winpoint'] }}</td>
                                        <td class="text-xs">{{ $entry['endpoint'] }}</td>
                                        <td class="text-xs">{{ $entry['result'] }}</td>
                                        <td class="text-xs">{{ implode(', ', $entry['betValues']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No game history available.</p>
                @endif
            </div>
        </div>
    </div>
</div>
