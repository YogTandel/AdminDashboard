@extends('layouts.layout')

@section('page-name', 'Comission Report')

@section('content')
    <div class="container py-4">
        <h3 class="mb-4 text-dark" style="font-weight: 600; font-size: 1.2rem;">
            @if (auth('admin')->check())
                All Comission History
            @elseif(auth('web')->check())
                My Comission History
            @else
                Comission History
            @endif
        </h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="container">
            <h3 class="mb-4">Release History</h3>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Transfer To</th>
                        <th>Type</th>
                        <th>Total Bet</th>
                        <th>Commission (%)</th>
                        <th>Remaining Balance</th>
                        <th>Transfer Role</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($releases as $release)
                        <tr class="text-dark">
                            <td>{{ $release['transfer_to'] ?? 'N/A' }}</td>
                            <td>{{ $release['type'] ?? 'N/A' }}</td>
                            <td>₹ {{ $release['total_bet'] ?? '0' }}</td>
                            <td>{{ $release['commission_percentage'] ?? '0' }}%</td>
                            <td>₹ {{ $release['remaining_balance'] ?? '0' }}</td>
                            <td>{{ $release['transfer_role'] ?? 'N/A' }}</td>
                            <td>{{ $release['created_at'] }}</td>
                            <td>{{ $release['updated_at'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-dark">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection