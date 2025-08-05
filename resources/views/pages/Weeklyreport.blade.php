@extends('layouts.layout')

@section('page-name', 'Weekly Bet Report')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 text-bolder">Weekly Bet Report</h4>

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
</div>
@endsection
