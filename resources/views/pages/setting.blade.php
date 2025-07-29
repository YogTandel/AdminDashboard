@extends('layouts.layout')

@section('page-name', 'Setting')

@section('content')
    <div class="container-fluid py-4">
        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="d-none"
            style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999; display: flex; justify-content: center; align-items: center;">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        {{-- Success/Error Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-success-auto" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show alert-danger-auto" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($selectedAgent)
            <div class="alert alert-custom alert-dismissible fade show" role="alert">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Currently managing settings for: {{ $selectedAgent['name'] }}</strong>
                    </div>
                    <div>
                        <strong>Balance: ₹{{ number_format($selectedAgent['balance'], 2) }}</strong>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                No agent selected. Please select an agent from the agent list.
            </div>
        @endif

        <div class="row">
            <!-- Commissions Section -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-radius-xl">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">Commissions</h6>
                    </div>
                    <div class="card-body pt-3">
                        <form action="{{ route('settings.updateCommissions') }}" method="POST" id="commissionForm">
                            @csrf
                            <input type="hidden" name="agent_id" value="{{ $selectedAgent['id'] ?? '' }}">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Agent Commission</label>
                                    <div class="input-group">
                                        <span class="input-group-text">%</span>
                                        <input type="number" name="agent_commission" class="form-control"
                                            placeholder="e.g. 5" value="{{ $settings->agentComission ?? 5 }}" min="0"
                                            max="100" step="0.01" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Distributor Commission</label>
                                    <div class="input-group">
                                        <span class="input-group-text">%</span>
                                        <input type="number" name="distributor_commission" class="form-control"
                                            placeholder="e.g. 0.10" value="{{ $settings->distributorComission ?? 0.1 }}"
                                            min="0" max="100" step="0.01" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <button type="submit" class="btn bg-gradient-info mb-2"style="font-size:13px">
                                    Update Commissions
                                </button>
                                <a href="{{ route('commission.report') }}" class="btn bg-gradient-success mb-2" style="font-size:13px">
                                    Release Commission
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Standing & Earnings Section -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-soft border-radius-xl">
                    <div class="card-header pb-0">
                        <h6 class="mb-0 d-flex justify-content-between align-items-center">
                            <span>Standing & Earnings</span>
                            <span class="text-muted big" id="admin-endpoint">Balance</span>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div><strong>Standing:</strong> <span
                                    class="text-primary">{{ $settings->standing ?? 'N/A' }}</span></div>
                            <div><strong>Admin% Earning:</strong> <span class="text-success">{{ $settings->earning }}</span>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <form action="{{ route('settings.standingToEarning') }}" method="POST"
                                id="standingToEarningForm">
                                @csrf
                                <button type="submit" class="equal-btn btn-orange " style="font-size:15px">Standing To Earning</button>
                            </form>

                            <form action="{{ route('settings.earningToZero') }}" method="POST" id="earningToZeroForm">
                                @csrf
                                <button type="submit" class="equal-btn btn-red" style="font-size:15px">Earning to 0</button>
                            </form>

                            <!-- Your existing button HTML remains exactly the same -->
                            <button id="toggleSetToMinimumBtn" type="button" class="equal-btn btn-green" style="font-size:15px">
                                Set To Minimum
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profit Section -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-soft border-radius-xl">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">Profit Settings</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('settings.updateProfit') }}" method="POST" id="profitForm">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">Earning %</label>
                                <div class="input-group">
                                    <span class="input-group-text">%</span>
                                    <input type="number" name="earningPercentage" class="form-control"
                                        placeholder="Enter Earning Percentage"
                                        value="{{ $settings->earningPercentage ?? '' }}" min="0" max="100" step="0.01"
                                        required>
                                </div>
                                <div class="d-grid mt-3">
                                    <button type="submit" class="btn bg-gradient-info"style="font-size:14px">
                                        Update Earning%
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Admin Points Section -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-soft border-radius-xl">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">Admin Points Management</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.addPoints') }}" method="POST" id="addPointsForm">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">Add Points</label>
                                <input type="number" class="form-control" name="add_points"
                                    placeholder="Enter Points to Add" required>
                                <div class="d-grid mt-2">
                                    <button type="submit" class="btn btn-success shadow-soft"style="font-size:14px">Add To Admin</button>
                                </div>
                            </div>
                        </form>
                        <form action="{{ route('admin.removePoints') }}" method="POST" id="removePointsForm">
                            @csrf
                            <label class="form-label">Remove Points</label>
                            <input type="number" class="form-control" name="remove_points"
                                placeholder="Enter Points to Remove" required min="1">
                            <div class="d-grid mt-2">
                                <button type="submit" class="btn btn-danger shadow-soft"style="font-size:14px">Remove from Admin</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .alert-custom {
            background-color: #e7f1ff;
            border-color: #b8daff;
            color: #004085;
            padding: 1rem;
            border-radius: 0.25rem;
            margin-bottom: 1rem;
        }

        .equal-btn {
            min-width: 160px;
            height: 45px;
            font-weight: bold;
            color: white;
            border: none;
            border-radius: 8px;
            text-align: center;
        }

        .btn-orange {
            background-color: #f57c00;
        }

        .btn-green {
            background-color: #4caf50;
        }

        .btn-red {
            background-color: #e53935;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Show loading spinner
        function showLoader() {
            $('#loadingSpinner').removeClass('d-none').addClass('d-flex');
        }

        // Hide loading spinner
        function hideLoader() {
            $('#loadingSpinner').removeClass('d-flex').addClass('d-none');
        }

        const initialValue = @json($settings->setTominimum ?? false);

        function updateButtonColor(value) {
            const btn = $('#toggleSetToMinimumBtn');
            btn.removeClass('btn-green btn-red');

            if (value) {
                btn.addClass('btn-green');
            } else {
                btn.addClass('btn-red');
            }
        }

        $(document).ready(function () {
            updateButtonColor(initialValue);

            // Form submissions with loader
            $('#commissionForm').on('submit', function () {
                showLoader();
            });

            $('#standingToEarningForm').on('submit', function () {
                showLoader();
            });

            $('#earningToZeroForm').on('submit', function () {
                showLoader();
            });

            $('#profitForm').on('submit', function () {
                showLoader();
            });

            $('#addPointsForm').on('submit', function () {
                showLoader();
            });

            $('#removePointsForm').on('submit', function () {
                showLoader();
            });

            // Toggle Set To Minimum button

            function updateButtonColor(isSetToMinimum) {
                if(isSetToMinimum) {
                    $('#toggleSetToMinimumBtn').text('ON - Set To Minimum');
                    $('#toggleSetToMinimumBtn').removeClass('btn-red').addClass('btn-green');
                } else {
                    $('#toggleSetToMinimumBtn').text('OFF - Set To Minimum');
                    $('#toggleSetToMinimumBtn').removeClass('btn-green').addClass('btn-red');
                }
            }
            $('#toggleSetToMinimumBtn').click(function () {
                showLoader();
                $.ajax({
                    url: "{{ route('toggle.setToMinimum') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.setTominimum !== undefined) {
                            updateButtonColor(response.setTominimum);
                        } else {
                            alert('Unexpected response from server.');
                        }
                        hideLoader();
                    },
                    error: function () {
                        alert('Error toggling Set To Minimum');
                        hideLoader();
                    }
                });
            });

            // Fetch endpoint
            showLoader();
            $.ajax({
                url: "{{ route('admin.endpoint') }}",
                method: 'GET',
                success: function (response) {
                    $('#admin-endpoint').text("Balance: " + response.endpoint);
                    hideLoader();
                },
                error: function () {
                    $('#admin-endpoint').text("Balance: Error loading");
                    hideLoader();
                }
            });

            // Auto-dismiss alerts
            setTimeout(function () {
                $('.alert-success-auto').fadeOut('slow');
                $('.alert-danger-auto').fadeOut('slow');
            }, 5000);
        });
    </script>

    <x-footer />
@endsection