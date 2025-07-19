@extends('layouts.layout')

@section('page-name', 'Commission Report')

@section('content')
    <!-- Loader Container -->
    <div id="loader" class="loader-container">
        <div class="loader"></div>
    </div>

    <div class="container py-4">
        <h3 class="mb-4 text-dark" style="font-weight: 600; font-size: 1.2rem;">
            @if (auth('admin')->check())
                All Commission History
            @elseif(auth('web')->check())
                My Commission History
            @else
                Commission History
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
                        <th> %</th>
                        <th>Remaining Balance</th>
                        <th>Transfer Role</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($releases as $release)
                        <tr class="text-dark">
                            <td>{{ $release['name'] ?? 'N/A' }}</td>
                            <td>{{ $release['type'] ?? 'N/A' }}</td>
                            <td>₹ {{ $release['total_bet'] ?? '0' }}</td>
                            <td>{{ $release['commission_percentage'] ?? '0' }}%</td>
                            <td>₹ {{ $release['remaining_balance'] ?? '0' }}</td>
                            <td>{{ $release['transfer_role'] ?? 'N/A' }}</td>
                            <td>{{ $release['created_at'] }}</td>
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

    <style>
        /* Loader Styles */
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }

        .loader {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <script>
        // Show loader when page is loading
        document.addEventListener('DOMContentLoaded', function() {
            // Show loader immediately when page starts loading
            document.getElementById('loader').style.display = 'flex';
            
            // Hide loader when page is fully loaded
            window.addEventListener('load', function() {
                document.getElementById('loader').style.display = 'none';
            });
        });

        // Show loader when page is being refreshed
        window.addEventListener('beforeunload', function() {
            document.getElementById('loader').style.display = 'flex';
        });
    </script>
@endsection