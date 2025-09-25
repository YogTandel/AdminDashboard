@extends('layouts.layout')

@section('page-name', 'Dashboard')

@section('content')

    {{-- 🔵 Loader --}}
    <div id="loader"
        style="
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #fff;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.5s ease;
">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>


    <div id="mainContent" style="display: none;">
        <div class="container-fluid py-4">
            <div class="row g-3">
                @if (auth('admin')->check())
                    <!-- Card 1 -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="p-3 bg-primary rounded">
                            <p class="text-white font-weight-bolder mb-3">Total Agent</p>
                            <h5 class="text-white text-sm">{{ $totalAgents }}</h5>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="p-3 bg-info rounded">
                            <p class="text-white font-weight-bolder mb-3">Total Active Agent</p>
                            <h5 class="text-white text-sm">{{ $activeAgents }}</h5>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="p-3 bg-dark rounded">
                            <p class="text-white font-weight-bolder mb-3">Total Deactive Agent</p>
                            <h5 class="text-white text-sm">{{ $deactiveAgents }}</h5>
                        </div>
                    </div>



                    <!-- Card 5 -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="p-3 bg-primary rounded">
                            <p class="text-white font-weight-bolder mb-3">Total Distributor</p>
                            <h5 class="text-white text-sm">{{ $totalDistributors }}</h5>
                        </div>
                    </div>

                    <!-- Card 6 -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="p-3 bg-info rounded">
                            <p class="text-white font-weight-bolder mb-3">Total Active Distributor</p>
                            <h5 class="text-white text-sm">{{ $activeDistributors }}</h5>
                        </div>
                    </div>

                    <!-- Card 7 -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="p-3 bg-dark rounded">
                            <p class="text-white font-weight-bolder mb-3">Total Deactive Distributor</p>
                            <h5 class="text-white text-sm">{{ $deactiveDistributors }}</h5>
                        </div>
                    </div>



                    <!-- Card 9 -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="p-3 bg-primary rounded">
                            <p class="text-white font-weight-bolder mb-3">Total Player</p>
                            <h5 class="text-white text-sm">{{ $totalPlayers }}</h5>
                        </div>
                    </div>

                    <!-- Card 10 -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="p-3 bg-info rounded">
                            <p class="text-white font-weight-bolder mb-3">Total Active Player</p>
                            <h5 class="text-white text-sm">{{ $activePlayers }}</h5>
                        </div>
                    </div>

                    <!-- Card 11 -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="p-3 bg-dark rounded">
                            <p class="text-white font-weight-bolder mb-3">Total Deactive Player</p>
                            <h5 class="text-white text-sm">{{ $deactivePlayers }}</h5>
                        </div>
                    </div>
                @elseauth('web')
                    @if (auth()->user()->role === 'distributor')

                        <!-- Card 1 -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="p-3 bg-primary rounded">
                                <p class="text-white font-weight-bolder mb-3">Total Distributor</p>
                                <h5 class="text-white text-sm">{{ $totalDistributors }}</h5>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="p-3 bg-info rounded">
                                <p class="text-white font-weight-bolder mb-3">Total Active Distributor</p>
                                <h5 class="text-white text-sm">{{ $activeDistributors }}</h5>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="p-3 bg-dark rounded">
                                <p class="text-white font-weight-bolder mb-3">Total Deactive Distributor</p>
                                <h5 class="text-white text-sm">{{ $deactiveDistributors }}</h5>
                            </div>
                        </div>

                        <!-- Card 1 -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="p-3 bg-primary rounded">
                                <p class="text-white font-weight-bolder mb-3">Total Player</p>
                                <h5 class="text-white text-sm">{{ $totalPlayers }}</h5>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="p-3 bg-info rounded">
                                <p class="text-white font-weight-bolder mb-3">Total Active Player</p>
                                <h5 class="text-white text-sm">{{ $activePlayers }}</h5>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="p-3 bg-dark rounded">
                                <p class="text-white font-weight-bolder mb-3">Total Deactive Player</p>
                                <h5 class="text-white text-sm">{{ $deactivePlayers }}</h5>
                            </div>
                        </div>
                    @elseif(auth()->user()->role === 'agent')
                        <!-- Card 1 -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="p-3 bg-primary rounded">
                                <p class="text-white font-weight-bolder mb-3">Total Agent</p>
                                <h5 class="text-white text-sm">{{ $totalAgents }}</h5>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="p-3 bg-info rounded">
                                <p class="text-white font-weight-bolder mb-3">Total Active Agent</p>
                                <h5 class="text-white text-sm">{{ $activeAgents }}</h5>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="p-3 bg-dark rounded">
                                <p class="text-white font-weight-bolder mb-3">Total Deactive Agent</p>
                                <h5 class="text-white text-sm">{{ $deactiveAgents }}</h5>
                            </div>
                        </div>

                        <!-- Card 1 -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="p-3 bg-primary rounded">
                                <p class="text-white font-weight-bolder mb-3">Total Player</p>
                                <h5 class="text-white text-sm">{{ $totalPlayers }}</h5>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="p-3 bg-info rounded">
                                <p class="text-white font-weight-bolder mb-3">Total Active Player</p>
                                <h5 class="text-white text-sm">{{ $activePlayers }}</h5>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="p-3 bg-dark rounded">
                                <p class="text-white font-weight-bolder mb-3">Total Deactive Player</p>
                                <h5 class="text-white text-sm">{{ $deactivePlayers }}</h5>
                            </div>
                        </div>

                    @endif
                @endauth
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>
    window.addEventListener('load', function() {
        setTimeout(() => {
            const loader = document.getElementById('loader');
            const content = document.getElementById('mainContent');

            loader.style.opacity = '0';


            setTimeout(() => {
                loader.remove();
                content.style.display = 'block';
            }, 500);
        }, 1000);
    });
</script>
