@extends('layouts.layout')

@section('content')
    <x-sidebar />
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbar />
        <!-- Toast Container -->
        <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1080">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-text"><strong>{{ session('success') }}</strong></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-text"><strong>{{ session('error') }}</strong></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        <!-- End Toast Container -->

        <div class="row g-3 container-fluid py-4">

            <!-- Card 1 -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="p-3 bg-primary rounded">
                    <p class="text-white font-weight-bolder mb-0">Total Agent</p>
                    <h5 class="text-white text-sm">23</h5>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="p-3 bg-info rounded">
                    <p class="text-white font-weight-bolder mb-0">Total Active Agent</p>
                    <h5 class="text-white text-sm">13</h5>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="p-3 bg-dark rounded">
                    <p class="text-white font-weight-bolder mb-0">Total Deactive Agent</p>
                    <h5 class="text-white text-sm">10</h5>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="p-3 bg-danger rounded">
                    <p class="text-white font-weight-bolder mb-0">Total Chips</p>
                    <h5 class="text-white text-sm">370520</h5>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="p-3 bg-primary rounded">
                    <p class="text-white font-weight-bolder mb-0">Total Distributor</p>
                    <h5 class="text-white text-sm">4</h5>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="p-3 bg-info rounded">
                    <p class="text-white font-weight-bolder mb-0">Total Active Distributor</p>
                    <h5 class="text-white text-sm">2</h5>
                </div>
            </div>

            <!-- Card 7 -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="p-3 bg-dark rounded">
                    <p class="text-white font-weight-bolder mb-0">Total Deactive Distributor</p>
                    <h5 class="text-white text-sm">2</h5>
                </div>
            </div>

            <!-- Card 8 -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="p-3 bg-danger rounded">
                    <p class="text-white font-weight-bolder mb-0">Total Kata</p>
                    <h5 class="text-white text-sm">310370</h5>
                </div>
            </div>

            <!-- Card 9 -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="p-3 bg-primary rounded">
                    <p class="text-white font-weight-bolder mb-0">Total Player</p>
                    <h5 class="text-white text-sm">74</h5>
                </div>
            </div>

            <!-- Card 10 -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="p-3 bg-info rounded">
                    <p class="text-white font-weight-bolder mb-0">Total Active Player</p>
                    <h5 class="text-white text-sm">10</h5>
                </div>
            </div>

            <!-- Card 11 -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="p-3 bg-dark rounded">
                    <p class="text-white font-weight-bolder mb-0">Total Deactive Player</p>
                    <h5 class="text-white text-sm">64</h5>
                </div>
            </div>

            <!-- Card 12 -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="p-3 bg-danger rounded">
                    <p class="text-white font-weight-bolder mb-0">Total Bulk</p>
                    <h5 class="text-white text-sm">680890</h5>
                </div>
            </div>

        </div>
    </main>
@endsection
