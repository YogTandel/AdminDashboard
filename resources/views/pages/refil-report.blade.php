@extends('layouts.layout')

@section('page-name', 'Refil Report')

@section('content')
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
                            <th>Transfer By ID</th>
                            <th>Transfer To Name</th>
                            <th>Transfer To ID</th>
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
                                <td>{{ $refil->transfer_by }}</td>
                                <td>
                                    @if (str_contains($refil->distributor_name, 'Admin'))
                                        <span class="text-primary">{{ $refil->distributor_name }}</span>
                                    @else
                                        {{ $refil->distributor_name }}
                                    @endif
                                </td>
                                <td>{{ $refil->transfer_to }}</td>
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
@endsection
