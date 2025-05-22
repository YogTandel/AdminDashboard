@extends('layouts.layout')

@section('page-name', 'Player History of ' . $player->player)

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div
                            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <!-- Left: Title & Info -->
                            <div class="mb-3 mb-md-0">
                                <h5 class="mb-1">
                                    <i class="fas fa-history me-2"></i> Game History - {{ $player->player }}
                                </h5>
                                <div class="d-flex align-items-center flex-wrap">
                                    <span class="badge bg-gradient-primary me-2">
                                        {{ count($player->gameHistory ?? []) }} records
                                    </span>
                                    <span class="text-sm">Current balance: {{ number_format($player->balance, 2) }}</span>
                                </div>
                            </div>

                            <!-- Right: Date + Buttons -->
                            <div class="d-flex flex-wrap align-items-end gap-2 mt-2 mt-md-0">
                                <form method="GET" action="{{ route('player.history', $player->_id) }}">
                                    <div class="d-flex justify-content-end gap-2 mb-3">
                                        <div>
                                            <label for="from_date" class="form-label mb-0">From Date</label>
                                            <input type="date" name="from_date" id="from_date" class="form-control mb-0"
                                                value="{{ request('from_date') }}">
                                        </div>

                                        <div>
                                            <label for="to_date" class="form-label mb-0">To Date</label>
                                            <input type="date" name="to_date" id="to_date" class="form-control mb-0"
                                                value="{{ request('to_date') }}">
                                        </div>

                                        <button type="submit" class="btn btn-sm btn-primary mt-4 mb-0">Filter</button>
                                    </div>

                                    <!-- NEXT LINE BUTTONS -->
                                    <div class="d-flex justify-content-center mt-3 gap-2">
                                        <a href="{{ route('export.game.history', $player->_id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-download me-1"></i> Export Data
                                        </a>

                                        <a href="{{ route('player.show') }}" class="btn btn-sm btn-outline-dark">
                                            ← Back
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @if (!empty($player->gameHistory))
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <!-- Keep the same table header as in your modal -->
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Time</th>
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
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Bet Breakdown</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Keep the same table body as in your modal -->
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
                                                        $netClass =
                                                            $net >= 0 ? 'bg-gradient-success' : 'bg-gradient-danger';
                                                    @endphp
                                                    <span
                                                        class="badge badge-sm {{ $netClass }}">{{ number_format($net) }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="badge badge-sm bg-gradient-dark">{{ $entry['result'] }}</span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="progress-wrapper w-100 mx-auto">
                                                        <div class="progress-info">
                                                            <div class="progress-percentage">
                                                                <span class="text-xs font-weight-bold">Bet
                                                                    Distribution</span>
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
                            <!-- Summary Cards -->
                            <div class="row mt-4">
                                <!-- Total Bets Card -->
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card border-left-info shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                        Total Bets</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        {{ number_format(array_sum(array_column($player->gameHistory, 'playPoint'))) }}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-coins fa-2x text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Wins Card -->
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                        Total Wins</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        {{ number_format(array_sum(array_column($player->gameHistory, 'winpoint'))) }}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-trophy fa-2x text-success"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Net Result Card -->
                                <div class="col-xl-4 col-md-6 mb-4">
                                    @php
                                        $totalNet =
                                            array_sum(array_column($player->gameHistory, 'winpoint')) -
                                            array_sum(array_column($player->gameHistory, 'playPoint'));
                                        $netClass = $totalNet >= 0 ? 'success' : 'danger';
                                        $netIcon = $totalNet >= 0 ? 'arrow-up' : 'arrow-down';
                                    @endphp
                                    <div class="card border-left-{{ $netClass }} shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div
                                                        class="text-xs font-weight-bold text-{{ $netClass }} text-uppercase mb-1">
                                                        Net Result</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        {{ number_format($totalNet) }}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i
                                                        class="fas fa-{{ $netIcon }} fa-2x text-{{ $netClass }}"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center p-5">
                                <i class="fas fa-history text-secondary fa-3x mb-3"></i>
                                <h5 class="text-secondary">No game history available</h5>
                                <p class="text-sm text-muted">This player hasn't played any games yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <x-footer />
    </div>
@endsection
