@php use Carbon\Carbon; @endphp
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
                            <div class="mb-3 mb-md-0">
                                <h5 class="mb-1"><i class="fas fa-history me-2"></i> Game History
                                    - {{ $player->player }}
                                </h5>
                                <div class="d-flex align-items-center flex-wrap">
                                    <span
                                        class="badge bg-primary me-2">{{ $paginatedHistory ? $paginatedHistory->total() : 0 }}
                                        records</span>
                                    <span
                                        class="text-sm">Current balance: {{ number_format($player->balance, 2) }}</span>
                                </div>
                            </div>

                            <!-- Per Page Dropdown -->
                            <div class="d-flex align-items-center mt-3 mt-md-0">
                                <label for="per_page" class="mb-0 me-2 text-sm fw-bold text-dark">Show:</label>
                                <div class="input-group input-group-outline border-radius-lg shadow-sm">
                                    <select name="per_page" id="per_page" class="form-select border-0 ps-3 pe-4"
                                            style="min-width: 60px;">
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('player.history', $player->_id) }}" class="mt-4">
                            <div class="row g-2 align-items-end">
                                <!-- Quick Date Range -->
                                <div class="col-12 col-md-auto">
                                    <label for="date_range" class="form-label mb-0">Quick Date Range</label>
                                    <select name="date_range" class="form-select form-select-sm"
                                            onchange="this.form.submit()">
                                        <option value="">Date Range</option>
                                        <option value="2_days_ago"
                                            {{ request('date_range') == '2_days_ago' ? 'selected' : '' }}>
                                            Last 2 Days
                                        </option>
                                        <option value="last_week"
                                            {{ request('date_range') == 'last_week' ? 'selected' : '' }}>
                                            Last Week
                                        </option>
                                        <option value="last_month"
                                            {{ request('date_range') == 'last_month' ? 'selected' : '' }}>
                                            Last Month
                                        </option>
                                    </select>
                                </div>

                                <!-- From Date -->
                                <div class="col-12 col-md-auto">
                                    <label for="from_date" class="form-label mb-0">From Date</label>
                                    <input type="date" name="from_date" id="from_date"
                                           class="form-control form-control-sm" value="{{ request('from_date') }}">
                                </div>

                                <!-- To Date -->
                                <div class="col-12 col-md-auto">
                                    <label for="to_date" class="form-label mb-0">To Date</label>
                                    <input type="date" name="to_date" id="to_date" class="form-control form-control-sm"
                                           value="{{ request('to_date') }}">
                                </div>

                                <!-- Filter + Reset -->
                                <div class="col-12 col-md-auto d-flex gap-2">
                                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                    @if (request()->has('from_date') || request()->has('to_date') || request()->has('date_range'))
                                        <a href="{{ route('player.history', $player->_id) }}"
                                           class="btn btn-sm btn-secondary">Reset</a>
                                    @endif
                                </div>

                                <!-- Right-aligned Export + Back -->
                                <div class="col-12 col-md text-md-end">
                                    <div class="d-flex flex-wrap justify-content-center justify-content-md-end gap-2">
                                        <a href="{{ route('export.game.history', $player->_id) }}"
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-download me-1"></i> Export Data
                                        </a>
                                        <a href="{{ route('player.show') }}" class="btn btn-sm btn-outline-dark">←
                                            Back</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2 mt-3">
                        @if (!empty($player->gameHistory))
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Date</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">
                                            Result
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">
                                            Pre_Bet
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">
                                            Betvalue
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">
                                            Balance
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">
                                            Win
                                        </th>

                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">
                                            TB - Win
                                        </th>

                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">
                                            Net_Bal
                                        </th>


                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($player->gameHistory as $entry)
                                        @php

                                            $date = null;
                                            if (!empty($entry['time_stamp']) && is_numeric($entry['time_stamp'])) {
                                                try {
                                                    $date = Carbon::createFromTimestampMs(
                                                        $entry['time_stamp'],
                                                    )->timezone('Asia/Kolkata');
                                                } catch (\Exception $e) {
                                                    $date = null;
                                                }
                                            }

                                            $resultDigits = str_split((string) $entry['result']);
                                        @endphp
                                        <tr>
                                            <!-- Date -->
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $date ? $date->format('Y-m-d') : 'Invalid' }}</h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        {{ $date ? $date->format('h:i:s A') : '' }}</p>
                                                </div>
                                            </td>

                                            <!-- Result -->
                                            <td class="align-middle text-center">
                                                    <span class="badge bg-gradient-dark">
                                                        {{ $entry['result'] }} @if ($entry['result_type'] == 18)
                                                            - J
                                                        @endif
                                                    </span>
                                            </td>

                                            <!-- BF Bet -->
                                            <td class="align-middle text-center">
                                                    <span
                                                        class="badge bg-success">{{ number_format($entry['current_balance'] + array_sum($entry['betValues']) ) }}</span>
                                            </td>

                                            <!-- Betvalues -->
                                            <td class="align-middle">
                                                <div class="betvalue-wrapper">
                                                    <!-- Row 1: Numbers -->
                                                    <div
                                                        class="d-flex flex-wrap justify-content-center mb-1 betvalue-numbers">
                                                        @for ($i = 1; $i <= 9; $i++)
                                                            <div class="text-center me-2 mb-2 betvalue-cell">
                                                                    <span
                                                                        class="fw-bold px-2 py-1 rounded {{ in_array((string) $i, $resultDigits) ? 'bg-success bg-opacity-25 text-dark' : 'text-dark' }}">
                                                                        {{ $i }}
                                                                    </span>
                                                            </div>
                                                        @endfor
                                                        <div class="text-center me-2 mb-2 betvalue-cell">
                                                                <span
                                                                    class="fw-bold px-2 py-1 rounded {{ in_array('0', $resultDigits) ? 'bg-success bg-opacity-25 text-dark' : 'text-dark' }}">
                                                                    0
                                                                </span>
                                                        </div>
                                                        <div class="fw-bold text-dark ms-2 total-label">Total</div>
                                                    </div>

                                                    <!-- Row 2: Values -->
                                                    <div
                                                        class="d-flex flex-wrap justify-content-center betvalue-values">
                                                        @for ($i = 1; $i <= 9; $i++)
                                                            <div class="text-center me-2 mb-2 betvalue-cell">
                                                                    <span
                                                                        class="{{ in_array((string) $i, $resultDigits) ? 'fw-bold text-dark' : '' }}">
                                                                        {{ $entry['betValues'][$i] ?? 0 }}
                                                                    </span>
                                                            </div>
                                                        @endfor
                                                        <div class="text-center me-2 mb-2 betvalue-cell">
                                                                <span
                                                                    class="{{ in_array('0', $resultDigits) ? 'fw-bold text-dark' : '' }}">
                                                                    {{ $entry['betValues'][0] ?? 0 }}
                                                                </span>
                                                        </div>
                                                        <div class="fw-bold text-danger ms-2 total-value">
                                                            {{ array_sum($entry['betValues']) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Balance -->
                                            <td class="align-middle text-center">
                                                    <span
                                                        class="fw-bold text-dark">{{ $entry['current_balance'] ?? 0 }}</span>
                                            </td>

                                            <!-- Win -->
                                            <td class="align-middle text-center">
                                                    <span
                                                        class="badge bg-success">{{ number_format($entry['winpoint']) }}</span>
                                            </td>


                                            <!-- TB - Win -->
                                            <td class="align-middle text-center">
                                                <span class="badge bg-gradient-dark">
                                                    <?php echo $entry['endpoint'] ?? 0; ?>
                                                    {{ isset($entry['endpoint']) ? -1 * number_format($entry['endpoint']) : 0 }}
                                                </span>
                                            </td>

                                            <!-- Net Balance -->
                                            <td class="align-middle text-center">
                                                    <span
                                                        class="badge bg-success">{{ number_format($entry['current_balance'] + $entry['winpoint'] ) }}</span>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                @if ($paginatedHistory)
                                    {{ $paginatedHistory->withQueryString()->links('vendor.pagination.bootstrap-4') }}
                                @endif
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
        <x-footer/>
    </div>

    <style>
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.25rem;
        }

        .page-item.active .page-link {
            z-index: 1;
            color: #fff;
            background-color: #5e72e4;
            border-color: #5e72e4;
        }

        .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #5e72e4;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }

        .page-link:hover {
            color: #3c4fe0;
            text-decoration: none;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        /* Desktop (default) */
        .betvalue-wrapper {
            font-size: 0.85rem;
        }

        .betvalue-cell {
            min-width: 40px;
        }

        .total-label,
        .total-value {
            display: inline-block;
            vertical-align: middle;
        }

        /* Mobile view */
        @media (max-width: 768px) {
            .betvalue-wrapper {
                display: block;
                font-size: 1rem;
            }

            .betvalue-numbers,
            .betvalue-values {
                display: grid !important;
                grid-template-columns: repeat(11, 1fr);
                justify-items: center;
                gap: 6px;
            }

            .total-label,
            .total-value {
                display: block;
                width: 100%;
                text-align: center;
                margin-top: 6px;
                font-size: 1rem;
                font-weight: bold;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('per_page').addEventListener('change', function () {
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', this.value);
                url.searchParams.delete('page');
                window.location.href = url.toString();
            });
        });
    </script>
@endsection
