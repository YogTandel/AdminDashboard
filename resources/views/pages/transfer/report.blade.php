@extends('layouts.layout')

@section('page-name', 'Transfer History')

@section('content')
<div class="container py-4">
    <h3 class="mb-4 text-dark" style="font-weight: 600; font-size: 1.2rem;">Transfer History</h3>

    @if(count($transfers) > 0)
        <table class="table table-bordered table-hover" style="font-size: 0.8rem; color: #212529;">
            <thead>
                <tr>
                    <th scope="col" class="text-dark">Agent name</th>
                    <th scope="col" class="text-dark">Agent ID</th>
                    <th scope="col" class="text-dark">distributor name</th>
                    <th scope="col" class="text-dark">Distributor ID</th>
                    <th scope="col" class="text-dark">Amount</th>
                    <th scope="col" class="text-dark">Remaining Balance</th>
                    <th scope="col" class="text-dark">Created At</th>
                    <th scope="col" class="text-dark">Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transfers as $transfer)
                    <tr>
                         <td>{{ $transfer->agent_name }}</td>
                        <td class="text-dark">{{ $transfer->agent_id }}</td>
                        <td>{{ $transfer->distributor_name ?? 'N/A' }}</td>
                        <td>{{ $transfer->distributor_id ?? 'N/A' }}</td>
                        <td class="text-dark">{{ number_format($transfer->amount, 2) }}</td>
                        <td>{{ $transfer->remaining_balance ?? 'N/A' }}</td>
                        <td class="text-dark">{{ \Carbon\Carbon::parse($transfer->created_at)->format('d-M-Y h:i A') }}</td>
                        <td class="text-dark">{{ \Carbon\Carbon::parse($transfer->updated_at)->format('d-M-Y h:i A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info small">No transfer records found.</div>
    @endif
</div>
@endsection
