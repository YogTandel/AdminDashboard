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
                <tr>
                    <td>{{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</td>
                    <td class="text-end">{{ number_format($total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
