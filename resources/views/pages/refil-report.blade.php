@extends('layouts.layout')

@section('page-name', 'Refil Report')

@section('content')
    <!-- Loader Container -->
    <div id="loader" class="loader-container">
        <div class="loader"></div>
    </div>

    <div class="container py-4">
        <h3 class="mb-4 text-dark" style="font-weight: 600; font-size: 1.2rem;">
            @if (auth('admin')->check())
                All Refil History
            @elseif(auth('web')->check())
                My Refil History
            @else
                Refil History
            @endif
        </h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($refils->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover" style="font-size: 0.8rem; color: #212529;">
                    <thead>
                        <tr>
                            <th>Transfer By Name</th>
                            <th>Transfer To Name</th>
                            <th>Amount</th>
                            <th>Remaining Balance</th>
                            <th>Role</th>
                            <th>Type</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($refils as $refil)
                            <tr>
                                <td>{{ $refil->agent_name }}</td>
                                <td>
                                    @if (str_contains($refil->distributor_name, 'Admin'))
                                        <span class="text-primary">{{ $refil->distributor_name }}</span>
                                    @else
                                        {{ $refil->distributor_name }}
                                    @endif
                                </td>
                                <td class="text-success">{{ number_format($refil->amount, 2) }}</td>
                                <td>{{ number_format($refil->remaining_balance, 2) }}</td>
                                <td>{{ ucfirst($refil->transfer_role) }}</td>
                                <td>{{ $refil->type }}</td>
                                <td>{{ \Carbon\Carbon::parse($refil->created_at)->format('d-M-Y h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info small">No refil records found.</div>
        @endif
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