@extends('layouts.layout')

@section('page-name', 'Setting')

@section('content')
    <div class="container-fluid py-4">
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
                        <form action="{{ route('settings.updateCommissions') }}" method="POST">
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
                                <button type="submit" class="btn bg-gradient-info mb-2">
                                    Update Commissions
                                </button>
                                <button type="button" class="btn bg-gradient-success mb-2">
                                    Release Commission
                                </button>
                                <button type="button" class="btn bg-gradient-warning text-white mb-2">
                                    Set To Minimum
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Standing & Earnings Section -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-soft border-radius-xl">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">Standing & Earnings</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div><strong>Standing:</strong> <span class="text-primary">30</span></div>
                            <div><strong>Admin% Earning:</strong> <span class="text-success">0</span></div>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-primary btn-sm shadow-soft">Standing To Earning</button>
                            <button type="button" class="btn btn-danger btn-sm shadow-soft">Earning to 0</button>
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
                        <form>
                            <div class="mb-4">
                                <label class="form-label">Profit</label>
                                <div class="input-group">
                                    <span class="input-group-text">%</span>
                                    <input type="number" class="form-control" placeholder="Enter Profit Percentage"
                                        min="0" max="100">
                                </div>
                                <div class="d-grid mt-3">
                                    <button type="submit" class="btn bg-gradient-info">
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
                        <form>
                            <!-- Add Points -->
                            <div class="mb-4">
                                <label class="form-label">Add Points</label>
                                @if ($selectedAgent['endpoint'])
                                    <input type="number" class="form-control" value={{ $selectedAgent['endpoint'] }}
                                        placeholder="Enter Profit Percentage">
                                @endif
                                <div class="d-grid mt-2">
                                    <button type="submit" class="btn btn-success shadow-soft">Add To Admin</button>
                                </div>
                            </div>

                            <!-- Remove Points -->
                            <div>
                                <label class="form-label">Remove Points</label>
                                <input type="text" class="form-control" placeholder="Enter Points to Remove">
                                <div class="d-grid mt-2">
                                    <button type="submit" class="btn btn-danger shadow-soft">Remove from Admin</button>
                                </div>
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
    </style>

    <x-footer />
@endsection
