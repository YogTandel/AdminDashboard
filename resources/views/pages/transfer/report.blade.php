@extends('layouts.layout')

@section('page-name', 'Transfer History')

@section('content')
    <div class="container py-4">
        <h3 class="mb-4 text-dark" style="font-weight: 600; font-size: 1.2rem;">
            @if (auth('admin')->check())
                All Transfer History
            @elseif(auth('web')->check())
                My Transfer History
            @else
                Transfer History
            @endif
        </h3>

        @if (count($transfers) > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover" style="font-size: 0.8rem; color: #212529;">
                    <thead>
                        <tr>
                            <th scope="col" class="text-dark">transfer by Name</th>
                            <th scope="col" class="text-dark">transfer to Name</th>
                            <th scope="col" class="text-dark">Amount</th>
                            <th scope="col" class="text-dark">Remaining Balance</th>
                            <th scope="col" class="text-dark">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transfers as $transfer)
                            <tr>
                                <td>{{ $transfer->agent_name }}</td>
                                <td>
                                    @if (str_contains($transfer->distributor_name, 'Admin'))
                                        <span class="text-primary">{{ $transfer->distributor_name }}</span>
                                    @else
                                        {{ $transfer->distributor_name }}
                                    @endif
                                </td>
                                <td class="text-success">{{ number_format($transfer->amount, 2) }}</td>
                                <td>{{ number_format($transfer->remaining_balance, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($transfer->created_at)->format('d-M-Y h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info small">No transfer records found.</div>
        @endif
    </div>
@endsection
