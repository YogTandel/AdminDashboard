@extends('layouts.layout')

@section('content')
    <!-- Toast Container -->
    <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1080">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <strong>{{ session('success') }}</strong>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-success" role="alert">
                <strong>{{ session('error') }}</strong>
            </div>
        @endif
    </div>
    <!-- End Toast Container -->

    <div class="row g-3 container-fluid py-4">

        <!-- Card 1 -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="p-3 bg-primary rounded">
                <p class="text-white font-weight-bolder mb-3">Total Agent</p>
                <h5 class="text-white text-sm">23</h5>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="p-3 bg-info rounded">
                <p class="text-white font-weight-bolder mb-3">Total Active Agent</p>
                <h5 class="text-white text-sm">13</h5>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="p-3 bg-dark rounded">
                <p class="text-white font-weight-bolder mb-3">Total Deactive Agent</p>
                <h5 class="text-white text-sm">10</h5>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="p-3 bg-danger rounded">
                <p class="text-white font-weight-bolder mb-3">Total Chips</p>
                <h5 class="text-white text-sm">370520</h5>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="p-3 bg-primary rounded">
                <p class="text-white font-weight-bolder mb-3">Total Distributor</p>
                <h5 class="text-white text-sm">4</h5>
            </div>
        </div>

        <!-- Card 6 -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="p-3 bg-info rounded">
                <p class="text-white font-weight-bolder mb-3">Total Active Distributor</p>
                <h5 class="text-white text-sm">2</h5>
            </div>
        </div>

        <!-- Card 7 -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="p-3 bg-dark rounded">
                <p class="text-white font-weight-bolder mb-3">Total Deactive Distributor</p>
                <h5 class="text-white text-sm">2</h5>
            </div>
        </div>

        <!-- Card 8 -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="p-3 bg-danger rounded">
                <p class="text-white font-weight-bolder mb-3">Total Kata</p>
                <h5 class="text-white text-sm">310370</h5>
            </div>
        </div>

        <!-- Card 9 -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="p-3 bg-primary rounded">
                <p class="text-white font-weight-bolder mb-3">Total Player</p>
                <h5 class="text-white text-sm">74</h5>
            </div>
        </div>

        <!-- Card 10 -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="p-3 bg-info rounded">
                <p class="text-white font-weight-bolder mb-3">Total Active Player</p>
                <h5 class="text-white text-sm">10</h5>
            </div>
        </div>

        <!-- Card 11 -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="p-3 bg-dark rounded">
                <p class="text-white font-weight-bolder mb-3">Total Deactive Player</p>
                <h5 class="text-white text-sm">64</h5>
            </div>
        </div>

        <!-- Card 12 -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="p-3 bg-danger rounded">
                <p class="text-white font-weight-bolder mb-3">Total Bulk</p>
                <h5 class="text-white text-sm">680890</h5>
            </div>
        </div>

    </div>
@endsection
