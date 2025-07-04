@extends('layouts.layout')

@section('page-name', 'Live Game')

@section('content')

    <div class="container">
        <div class="card-header d-flex justify-content-between align-items-center mt-3">
            <div class="ms-5 d-flex align-items-center flex-wrap gap-4">
                <div class="w-100 mt-1">

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div id="alertMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Error Message --}}
                    @if(session('error'))
                        <div id="alertMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                </div>

                {{-- Standing --}}
                <div class="d-flex align-items-center">
                    <span class="text-dark me-2" style="font-size: 1.5rem; font-weight: 700;">Standing:</span>
                    <span id="live-standing" class="badge bg-dark" style="font-size: 1rem;">--</span>
                </div>

                {{-- Earning --}}
                <div class="d-flex align-items-center">
                    <span class="text-dark me-2" style="font-size: 1.5rem; font-weight: 700;">Earning:</span>
                    <span id="live-earning" class="badge bg-gradient-success me-3" style="font-size: 1rem;">--</span>
                </div>

                {{-- Result --}}
                <div class="d-flex align-items-center">
                    <span class="text-dark me-2" style="font-size: 1.5rem; font-weight: 700;">Result:</span>
                    <span id="live-result" class="badge text-white me-3"
                        style="background: linear-gradient(135deg, #f093fb, #f5576c); font-size: 1rem; font-weight: 700;">
                        --
                    </span>
                </div>


                {{-- Custom Bet --}}
                <form action="{{ route('custom.bet.update') }}" method="POST" class="d-flex align-items-center">
                    @csrf
                    <span class="text-dark me-2" style="font-size: 1.5rem; font-weight: 700;">Custom Bet:</span>
                    <input type="number" name="custom_bet" class="form-control form-control-sm"
                        placeholder="Enter Custom Bet" style="width: 200px;" min="0" max="9" required />
                    <button type="submit" class="btn btn-primary btn-sm ms-2 mt-2" style="width: 100px;">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-2 container-fluid py-4">

        <!-- Card 1 -->
        <div class="col-12 col-sm-6 col-md-1 ms-3">
            <div class="p-3 rounded text-white" style="background: linear-gradient(135deg, #ff9a9e, #fad0c4);">
                <p class="font-weight-bolder mb-3">1</p>
                <h5 class="text-sm">34567</h5>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-12 col-sm-6 col-md-1 ms-2">
            <div class="p-3 rounded text-white" style="background: linear-gradient(135deg, #a18cd1, #fbc2eb);">
                <p class="font-weight-bolder mb-3">2</p>
                <h5 class="text-sm">4567</h5>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-12 col-sm-6 col-md-1 ms-2">
            <div class="p-3 rounded text-white" style="background: linear-gradient(135deg, #f6d365, #fda085);">
                <p class="font-weight-bolder mb-3">3</p>
                <h5 class="text-sm">3789</h5>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-12 col-sm-6 col-md-1 ms-2">
            <div class="p-3 rounded text-white" style="background: linear-gradient(135deg, #fdcbf1, #e6dee9);">
                <p class="font-weight-bolder mb-3">4</p>
                <h5 class="text-sm">4987</h5>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="col-12 col-sm-6 col-md-1 ms-2">
            <div class="p-3 rounded text-white" style="background: linear-gradient(135deg, #a1c4fd, #c2e9fb);">
                <p class="font-weight-bolder mb-3">5</p>
                <h5 class="text-sm">5989</h5>
            </div>
        </div>

        <!-- Card 6 -->
        <div class="col-12 col-sm-6 col-md-1 ms-2">
            <div class="p-3 rounded text-white" style="background: linear-gradient(135deg, #84fab0, #8fd3f4);">
                <p class="font-weight-bolder mb-3">6</p>
                <h5 class="text-sm">5679</h5>
            </div>
        </div>

        <!-- Card 7 -->
        <div class="col-12 col-sm-6 col-md-1 ms-2">
            <div class="p-3 rounded text-white" style="background: linear-gradient(135deg, #cfd9df, #e2ebf0);">
                <p class="font-weight-bolder mb-3">7</p>
                <h5 class="text-sm">7236</h5>
            </div>
        </div>

        <!-- Card 8 -->
        <div class="col-12 col-sm-6 col-md-1 ms-2">
            <div class="p-3 rounded text-white" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                <p class="font-weight-bolder mb-3">8</p>
                <h5 class="text-sm">8677</h5>
            </div>
        </div>

        <!-- Card 9 -->
        <div class="col-12 col-sm-6 col-md-1 ms-2">
            <div class="p-3 rounded text-white" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                <p class="font-weight-bolder mb-3">9</p>
                <h5 class="text-sm">9976</h5>
            </div>
        </div>

        <!-- Card 10 -->
        <div class="col-12 col-sm-6 col-md-1 ms-2">
            <div class="p-3 rounded text-white" style="background: linear-gradient(135deg, #30cfd0, #330867);">
                <p class="font-weight-bolder mb-3">0</p>
                <h5 class="text-sm">4567</h5>
            </div>
        </div>

        <!-- Card 10 -->
        <div class="col-12 col-sm-6 col-md-1 ms-2">
            <div class="p-3 rounded text-white" style="background: linear-gradient(135deg, #a18cd1, #fbc2eb);">
                <p class="font-weight-bolder mb-3">Total</p>
                <h5 class="text-sm">167</h5>
            </div>
        </div>

    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class=" text-dark fw-bolder text-center" style="font-size: 1.5rem;">Live Player</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2 mt-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" style="table-layout: fixed; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-dark fw-bold text-center"
                                            style="font-size: 1rem; width: 22%;">Name</th>
                                        <th class="text-uppercase text-dark fw-bold text-center" style="font-size: 1rem;">1
                                        </th>
                                        <th class="text-uppercase text-dark fw-bold text-center" style="font-size: 1rem;">2
                                        </th>
                                        <th class="text-uppercase text-dark fw-bold text-center" style="font-size: 1rem;">3
                                        </th>
                                        <th class="text-uppercase text-dark fw-bold text-center" style="font-size: 1rem;">4
                                        </th>
                                        <th class="text-uppercase text-dark fw-bold text-center" style="font-size: 1rem;">5
                                        </th>
                                        <th class="text-uppercase text-dark fw-bold text-center" style="font-size: 1rem;">6
                                        </th>
                                        <th class="text-uppercase text-dark fw-bold text-center" style="font-size: 1rem;">7
                                        </th>
                                        <th class="text-uppercase text-dark fw-bold text-center" style="font-size: 1rem;">8
                                        </th>
                                        <th class="text-uppercase text-dark fw-bold text-center" style="font-size: 1rem;">9
                                        </th>
                                        <th class="text-uppercase text-dark fw-bold text-center" style="font-size: 1rem;">0
                                        </th>
                                        <th class="text-uppercase text-dark fw-bold text-center" style="font-size: 1rem;">
                                            Total</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <x-footer />
        </div>
    </div>

    
    <script>
        setTimeout(function () {
            const alertEl = document.getElementById('alertMessage');
            if (alertEl) {
                alertEl.classList.remove('show');
                alertEl.classList.add('fade');
                alertEl.style.display = 'none';
            }
        }, 3000);
    </script>
 <script>
    function fetchLiveGameValues() {
        fetch("{{ route('live.game.values') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById('live-standing').innerText = data.standing;
                document.getElementById('live-earning').innerText = data.earning;
                document.getElementById('live-result').innerText = data.result;
            })
            .catch(error => console.error('Error fetching live game values:', error));
    }

    fetchLiveGameValues(); 
    setInterval(fetchLiveGameValues, 5000); 
</script>



@endsection