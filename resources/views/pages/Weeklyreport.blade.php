@extends('layouts.layout')

@section('page-name', 'Weekly Report')

@section('content')

<div class="container py-4">
        

        <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
            <h4 class="mb-0 ms-4 mt-3 text-bolder">Weekly Report</h4>
            
            <div class="container mt-4">
            <!-- <h3 class="mb-4">Release History</h3> -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th>Date</th>
                        <th>bet amount</th>
                        <th>win amount</th>
                        <th>Profit</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>

           
        </div>
        
@endsection