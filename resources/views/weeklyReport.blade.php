@extends('layouts.layout')

@section('page-name', 'Weekly Bet Report')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 text-bolder">Weekly Bet Report</h4>

    <form method="GET" action="{{ route('Weekly-report') }}" class="row g-2 align-items-end mb-4">
        <div class="col-md-4">
            <label for="distributor_id" class="form-label">Select Distributor</label>
            <select name="distributor_id" id="distributor_id" class="form-select">
                <option value="">Choose distributor</option>
                @foreach($distributors as $distributor)
                    <option value="{{ $distributor->_id }}" {{ (string)$distributor->_id === (string)$selectedDistributorId ? 'selected' : '' }}>
                        {{ $distributor->player ?? $distributor->name ?? 'Unknown Distributor' }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="agent_id" class="form-label">Select Agent</label>
            <select name="agent_id" id="agent_id" class="form-select">
                <option value="">Choose agent</option>
                @foreach($agents as $agent)
                    <option value="{{ $agent->_id }}" {{ (string)$agent->_id === (string)$selectedAgentId ? 'selected' : '' }}>
                        {{ $agent->player ?? $agent->name ?? 'Unknown Agent' }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('Weekly-report') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    @if($hasSelection)
    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>Date</th>
                <th>Bet Amount</th>
                <th>win amount</th>
                <th>Profit</th>
            </tr>
        </thead>
         <tbody>
        @foreach($dailyTotals as $date => $total)
            @php
                $win = $winTotals[$date] ?? 0;
                $profit = $total - $win;
            @endphp
            <tr>
                <td class="text-center">{{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</td>
                <td class="text-center">{{ number_format($total, 2) }}</td>
                <td class="text-center">{{ number_format($win, 2) }}</td>
                <td class="text-center">{{ number_format($profit, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
    </table>
    @else
        <div class="alert alert-info mb-0">
            Select an agent to view the weekly report.
        </div>
    @endif
</div>
@endsection
