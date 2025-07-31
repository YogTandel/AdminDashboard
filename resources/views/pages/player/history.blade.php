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
                                <h5 class="mb-1"><i class="fas fa-history me-2"></i> Game History - {{ $player->player }}
                                </h5>
                                <div class="d-flex align-items-center flex-wrap">
                                    <span
                                        class="badge bg-primary me-2">{{ $paginatedHistory ? $paginatedHistory->total() : 0 }}
                                        records</span>
                                    <span class="text-sm">Current balance: {{ number_format($player->balance, 2) }}</span>
                                </div>
                            </div>

                            <!-- <div class="d-flex flex-wrap align-items-end gap-2 mt-2 mt-md-0"> -->
                            <!-- Show Dropdown -->
                            <div class="d-flex align-items-center mb-2">
                                <label for="per_page" class="mb-0 me-2 text-sm text-dark fw-bold">Show:</label>
                                <div class="input-group input-group-outline border-radius-lg shadow-sm">
                                    <select name="per_page" id="per_page" class="form-select border-0 ps-3 pe-4"
                                        style="min-width: 60px;">
                                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    </select>
                                </div>
                            </div>

                            <form method="GET" action="{{ route('player.history', $player->_id) }}">
                                <div class="d-flex justify-content-end gap-2 mt-5">
                                    <div>
                                        <label for="date_range" class="form-label mb-0">Quick Date Range</label>
                                        <select name="date_range" id="date_range" class="form-control mb-0">
                                            <option value="">Select a range</option>
                                            <option value="2_days_ago"
                                                {{ request('date_range') == '2_days_ago' ? 'selected' : '' }}>Last 2 Days
                                            </option>
                                            <option value="this_week"
                                                {{ request('date_range') == 'this_week' ? 'selected' : '' }}>This Week
                                            </option>
                                            <option value="this_month"
                                                {{ request('date_range') == 'this_month' ? 'selected' : '' }}>This Month
                                            </option>
                                        </select>
                                    </div>

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
                                    @if (request()->has('from_date') || request()->has('to_date') || request()->has('date_range'))
                                        <a href="{{ route('player.history', $player->_id) }}"
                                            class="btn btn-sm btn-secondary mt-4 mb-0">Reset</a>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-center mt-3 gap-2">
                                    <a href="{{ route('export.game.history', $player->_id) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-download me-1"></i> Export Data
                                    </a>
                                    <a href="{{ route('player.show') }}" class="btn btn-sm btn-outline-dark">← Back</a>
                                </div>
                            </form>
                            <!-- </div> -->
                        </div>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2 mt-3">
                        @if (!empty($player->gameHistory))
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%;"
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder ">Date</th>
                                            <th style="width: 10%;"
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder  text-center">
                                                WinPoint</th>
                                            <th style="width: 10%;"
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder  text-center">
                                                Result</th>

                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ">Betvalue
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($player->gameHistory as $entry)
                                            @php
                                                $date = null;
                                                if (!empty($entry['stime']) && is_string($entry['stime'])) {
                                                    try {
                                                        $date = Carbon::createFromFormat(
                                                            'Y/m/d H:i:s',
                                                            $entry['stime'],
                                                        );
                                                    } catch (\Exception $e) {
                                                        try {
                                                            $date = Carbon::parse($entry['stime']);
                                                        } catch (\Exception $e) {
                                                            $date = null;
                                                        }
                                                    }
                                                }
                                            @endphp

                                            <tr>
                                                <!-- Date -->
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">
                                                                {{ $date ? $date->format('Y-m-d') : 'Invalid' }}
                                                            </h6>
                                                            <p class="text-xs text-secondary mb-0">
                                                                {{ $date ? $date->format('H:i:s') : '' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- Win -->
                                                <td class="align-middle text-center  py-1">
                                                    <span
                                                        class="badge bg-success text-white">{{ number_format($entry['winpoint']) }}</span>
                                                </td>


                                                <!-- Result -->
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="badge badge-sm bg-gradient-dark">{{ $entry['result'] }}</span>
                                                </td>

                                                <td class="align-middle" style="min-width: 100%;">
                                                    <!-- Row 1: Position numbers (0-9) -->
                                                    <div class="d-flex align-items-center mb-1">
                                                        <div class="fw-bold text-nowrap me-3 text-dark text-xs"
                                                            style="width: 80px;">Betvalue</div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="fw-bold px-2 py-1 rounded {{ $entry['result'] == 1 ? 'bg-success bg-opacity-25 text-dark' : 'text-dark' }}">
                                                                1
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="fw-bold px-2 py-1 rounded {{ $entry['result'] == 2 ? 'bg-success bg-opacity-25 text-dark' : 'text-dark' }}">
                                                                2
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="fw-bold px-2 py-1 rounded {{ $entry['result'] == 3 ? 'bg-success bg-opacity-25 text-dark' : 'text-dark' }}">
                                                                3
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="fw-bold px-2 py-1 rounded {{ $entry['result'] == 4 ? 'bg-success bg-opacity-25 text-dark' : 'text-dark' }}">
                                                                4
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="fw-bold px-2 py-1 rounded {{ $entry['result'] == 5 ? 'bg-success bg-opacity-25 text-dark' : 'text-dark' }}">
                                                                5
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="fw-bold px-2 py-1 rounded {{ $entry['result'] == 6 ? 'bg-success bg-opacity-25 text-dark' : 'text-dark' }}">
                                                                6
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="fw-bold px-2 py-1 rounded {{ $entry['result'] == 7 ? 'bg-success bg-opacity-25 text-dark' : 'text-dark' }}">
                                                                7
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="fw-bold px-2 py-1 rounded {{ $entry['result'] == 8 ? 'bg-success bg-opacity-25 text-dark' : 'text-dark' }}">
                                                                8
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="fw-bold px-2 py-1 rounded {{ $entry['result'] == 9 ? 'bg-success bg-opacity-25 text-dark' : 'text-dark' }}">
                                                                9
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="fw-bold px-2 py-1 rounded {{ $entry['result'] == 0 ? 'bg-success bg-opacity-25 text-dark' : 'text-dark' }}">
                                                                0
                                                            </span>
                                                        </div>
                                                        <div class="me-3 fw-bold text-dark text-xl" style="width: 80px;">
                                                            Total</div>
                                                    </div>

                                                    <!-- Row 2: Bet values -->
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3" style="width: 80px;"></div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="{{ $entry['result'] == 1 ? 'fw-bold text-dark' : '' }}">
                                                                {{ $entry['betValues'][1] }}
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="{{ $entry['result'] == 2 ? 'fw-bold text-dark' : '' }}">
                                                                {{ $entry['betValues'][2] }}
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="{{ $entry['result'] == 3 ? 'fw-bold text-dark' : '' }}">
                                                                {{ $entry['betValues'][3] }}
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="{{ $entry['result'] == 4 ? 'fw-bold text-dark' : '' }}">
                                                                {{ $entry['betValues'][4] }}
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="{{ $entry['result'] == 5 ? 'fw-bold text-dark' : '' }}">
                                                                {{ $entry['betValues'][5] }}
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="{{ $entry['result'] == 6 ? 'fw-bold text-dark' : '' }}">
                                                                {{ $entry['betValues'][6] }}
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="{{ $entry['result'] == 7 ? 'fw-bold text-dark' : '' }}">
                                                                {{ $entry['betValues'][7] }}
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="{{ $entry['result'] == 8 ? 'fw-bold text-dark' : '' }}">
                                                                {{ $entry['betValues'][8] }}
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="{{ $entry['result'] == 9 ? 'fw-bold text-dark' : '' }}">
                                                                {{ $entry['betValues'][9] }}
                                                            </span>
                                                        </div>
                                                        <div class="text-center me-4" style="min-width: 40px;">
                                                            <span
                                                                class="{{ $entry['result'] == 0 ? 'fw-bold text-dark' : '' }}">
                                                                {{ $entry['betValues'][0] }}
                                                            </span>
                                                        </div>
                                                        <?php /*@endforeach */?>
                                                        <div class="d-flex align-items-center mt-1">
                                                            <div class="text-dark fw-bold ps-2">
                                                                {{ array_sum($entry['betValues']) }}
                                                            </div>
                                                        </div>
                                                    </div>
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
        <x-footer />
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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle per_page dropdown changes
            document.getElementById('per_page').addEventListener('change', function() {
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', this.value);
                url.searchParams.delete('page'); // Reset to first page
                window.location.href = url.toString();
            });

            // Preserve form inputs on page refresh
            const form = document.querySelector('form[method="GET"]');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // No need to prevent default, let the form submit normally
                });
            }
        });
    </script>
@endsection
