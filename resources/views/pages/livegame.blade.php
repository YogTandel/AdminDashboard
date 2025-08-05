@extends('layouts.layout')

@section('page-name', 'Live Game')

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="container ">
        <div class="card-header d-flex justify-content-between align-items-center mt-3">
            <div class="ms-5 d-flex align-items-center flex-wrap gap-4">
                <div class="w-100 mt-1">

                    {{-- Success Message --}}
                    @if (session('success'))
                        <div id="alertMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Error Message --}}
                    @if (session('error'))
                        <div id="alertMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                </div>

                {{-- Standing --}} 
                <div class="d-flex align-items-center ms-5">
                    <span class="text-dark me-2" style="font-size: 1.5rem; font-weight: 700;">Standing:</span>
                    <span id="live-standing" class="badge bg-dark" style="font-size: 1rem;">--</span>
                </div>

                {{-- Earning --}}
                <div class="d-flex align-items-center">
                    <span class="text-dark me-2" style="font-size: 1.5rem; font-weight: 700;">Earning:</span>
                    <span id="live-earning11" class="badge bg-gradient-success me-2" style="font-size: 1rem;">--</span>
                </div>

                {{-- Result --}}
                <div class="d-flex align-items-center">
                    <span class="text-dark me-2" style="font-size: 1.5rem; font-weight: 700;">Result:</span>
                    <span id="live-result" class="badge text-white "
                        style="background: linear-gradient(135deg, #f093fb, #f5576c); font-size: 1rem; font-weight: 700;">
                        --
                    </span>
                </div>


                {{-- Custom Bet --}}
                <!-- <form action="{{ route('custom.bet.update') }}" method="POST" class="d-flex align-items-center">
                    @csrf
                    <span class="text-dark" style="font-size: 1.5rem; font-weight: 700;">Custom Bet:</span>
                    <input type="number" name="custom_bet" class="form-control form-control-sm" placeholder=""
                        style="width: 100px;" min="0" max="9" required value="{{ old('custom_bet') }}" />
                    <button type="submit" class="btn btn-primary btn-sm ms-2 mt-3" style="width: 100px;">Submit</button>
                </form> -->

                {{-- Timer Badge --}}
                <div class="ms-5 ">
                    <span id="timer-badge" class="badge bg-dark"
                        style="font-size: 16px; color: #FF0000; font-family: 'Share Tech Mono', monospace;">
                        00:00
                    </span>
                </div>
            </div>
        </div>
    </div>
   <div class="last10-container d-flex align-items-center gap-2 me-5 justify-content-center mt-4 ">
    <div class="fs-6 fw-bold text-dark me-2">Last 10 data :-</div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        @for($i = 1; $i <= 10; $i++)
            <span id="result-badge-{{$i}}" 
                  class="d-flex align-items-center justify-content-center" 
                  style="font-size: 1rem;
                         width: 50px;
                         height: 30px;
                         text-align: center;
                         background-color: {{ [
                             '#FFECEC', '#FFEFD8', '#F0FFE2', '#E2F9FF', 
                             '#EEE2FF', '#FFE2F5', '#E2FFEE', '#FFF5E2',
                             '#E2ECFF', '#FFE8E2'
                         ][$i-1] }};
                         color: #333;
                         border-radius: 4px !important;">
                  --
            </span>
        @endfor
    </div>
</div>


     

    <div class="row g-2 container-fluid py-4">
        @for ($i = 1; $i <= 10; $i++)
            @php
                $displayNumber = $i % 10; 
            @endphp
            <div class="col-12 col-sm-6 col-md-1 ms-2" id="card-{{ $displayNumber }}">
                <div class="p-3 rounded text-white card-bg-{{ $displayNumber }}">
                    <p class="font-weight-bolder mb-3" style="font-size: 1.5rem; font-weight: 800;">{{ $displayNumber }}</p>
                    <h5 class="text-sm value">0</h5>
                </div>
            </div>
        @endfor

        <div class="col-12 col-sm-6 col-md-1 ms-2" id="card-total">
            <div class="p-3 rounded text-white card-bg-total">
                <p class="font-weight-bolder mb-3" style="font-size: 1.5rem; font-weight: 800;">Total</p>
                <h5 class="text-sm value">0</h5>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="text-dark fw-bolder text-center" style="font-size: 1.5rem;">Live Player</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2 mt-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" style="table-layout: fixed; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-dark fw-bold text-center"
                                            style="font-size: 1rem; width: 22%;">Name</th>
                                        @for ($i = 1; $i <= 9; $i++)
                                            <th class="text-uppercase text-dark fw-bold text-center"
                                                style="font-size: 1rem;">
                                                {{ $i }}</th>
                                        @endfor
                                        <th class="text-uppercase text-dark fw-bold text-center" style="font-size: 1rem;">0
                                        </th>
                                        <th class="text-uppercase text-dark fw-bold text-center" style="font-size: 1rem;">
                                            Total</th>
                                    </tr>
                                </thead>
                                <tbody id="player-table-body"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <x-footer />
        </div>
    </div>


    <script>
        setTimeout(function() {
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
                    document.getElementById('live-earning11').innerText = data.earning;
                    document.getElementById('live-result').innerText = data.result;
                })
                .catch(error => console.error('Error fetching live game values:', error));
        }

        fetchLiveGameValues();
        setInterval(fetchLiveGameValues, 5000);
    </script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const config = {
        refreshInterval: 5000,
        apiEndpoint: "{{ route('last10.results') }}"
    };

    // Predefined colors for each badge position
    const badgeColors = [
        { bg: '#333b3bff', text: '#ffff' }, // Light red
        { bg: '#333b3bff', text: '#ffff' },  // Light orange
        { bg: '#333b3bff', text: '#ffff' },  // Light green
        { bg: '#333b3bff', text: '#ffff' },  // Light blue
        { bg: '#333b3bff', text: '#ffff' },  // Light purple
        { bg: '#333b3bff', text: '#ffff' },  // Light pink
        { bg: '#333b3bff', text: '#ffff' },  // Light teal
        { bg: '#333b3bff', text: '#ffff' },  // Light deep orange
        { bg: '#333b3bff', text: '#ffff' },  // Light blue
        { bg: '#333b3bff', text: '#ffff' }   // Light brown
    ];

    // Get all badge elements
    const badges = Array.from({length: 10}, (_, i) => 
        document.getElementById(`result-badge-${i+1}`)).filter(Boolean);

    // Initialize badges with their unique colors
    function initBadges() {
        badges.forEach((badge, index) => {
            if (badge) {
                badge.textContent = '--';
                badge.style.backgroundColor = badgeColors[index].bg;
                badge.style.color = badgeColors[index].text;
                badge.className = 'badge rounded-pill p-2 me-0';
            }
        });
    }

    // Update badges with data (maintaining their unique colors)
    function updateBadges(data) {
        data.forEach((result, index) => {
            if (badges[index]) {
                badges[index].textContent = result;
                // Keep the same background color but update text if needed
                badges[index].style.color = (
                    result === 'W' ? '#388E3C' :
                    result === 'L' ? '#D32F2F' :
                    !isNaN(result) ? badgeColors[index].text : '#6c757d'
                );
            }
        });
    }

    // Fetch data from server
    async function fetchData() {
        try {
            const response = await fetch(config.apiEndpoint);
            const {success, data} = await response.json();
            
            if (success) {
                updateBadges(data);
            } else {
                initBadges(); // Reset to defaults on error
            }
        } catch (error) {
            console.error('Fetch error:', error);
            initBadges();
        }
    }

    // Initialize and start polling
    initBadges();
    fetchData();
    setInterval(fetchData, config.refreshInterval);
});
</script>

    <script>
        function fetchBetTotals() {
            $.ajax({
                url: '{{ route('bet.totals') }}',
                method: 'GET',
                success: function(response) {
                    for (let i = 0; i < 10; i++) {
                        $('#card-' + i + ' .value').text(response.totals[i]);
                    }
                    $('#card-total .value').text(response.grandTotal);
                },
                error: function(err) {
                    console.error('Error fetching bet totals:', err);
                }
            });
        }

        $(document).ready(function() {
            fetchBetTotals(); // First load
            setInterval(fetchBetTotals, 5000); // Auto update every 5 seconds
        });
    </script>

    <style>
        .card-bg-0 {
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
        }

        .card-bg-1 {
            background: linear-gradient(135deg, #a18cd1, #fbc2eb);
        }

        .card-bg-2 {
            background: linear-gradient(135deg, #f6d365, #fda085);
        }

        .card-bg-3 {
            background: linear-gradient(135deg, #fdcbf1, #e6dee9);
        }

        .card-bg-4 {
            background: linear-gradient(135deg, #a1c4fd, #c2e9fb);
        }

        .card-bg-5 {
            background: linear-gradient(135deg, #84fab0, #8fd3f4);
        }

        .card-bg-6 {
            background: linear-gradient(135deg, #cfd910df, rgb(153, 191, 211));
        }

        .card-bg-7 {
            background: linear-gradient(135deg, #f093fb, #f5576c);
        }

        .card-bg-8 {
            background: linear-gradient(135deg, #43e97b, #38f9d7);
        }

        .card-bg-9 {
            background: linear-gradient(135deg, #30cfd0, #330867);
        }

        .card-bg-total {
            background: linear-gradient(135deg, #a18cd1, #fbc2eb);
        }
    </style>

    <script>
        function loadPlayers() {
            $.ajax({
                url: "{{ route('players.live') }}",
                type: 'GET',
                success: function(response) {
                    let players = response.players;
                    let tableBody = '';

                    players.forEach(function(player) {
                        let name = player.name;
                        let betValues = player.betValues;
                        let total = player.total;
                        let stime = player.stime;

                        let row = `<tr>`;
                        row += `<td class="text-center text-dark fw-bold">${ name }</td>`;

                        row += `<td class="text-center">${ betValues[1] ?? 0 }</td>`;
                        row += `<td class="text-center">${ betValues[2] ?? 0 }</td>`;
                        row += `<td class="text-center">${ betValues[3] ?? 0 }</td>`;
                        row += `<td class="text-center">${ betValues[4] ?? 0 }</td>`;
                        row += `<td class="text-center">${ betValues[5] ?? 0 }</td>`;
                        row += `<td class="text-center">${ betValues[6] ?? 0 }</td>`;
                        row += `<td class="text-center">${ betValues[7] ?? 0 }</td>`;
                        row += `<td class="text-center">${ betValues[8] ?? 0 }</td>`;
                        row += `<td class="text-center">${ betValues[9] ?? 0 }</td>`;
                        row += `<td class="text-center">${ betValues[0] ?? 0 }</td>`;



                        row += `<td class="text-center fw-bold">${ total }</td>`;
                        row += `</tr>`;

                        tableBody += row;
                    });


                    $('#player-table-body').html(tableBody);
                },
                error: function(err) {
                    console.error("Error fetching player data", err);
                }
            });
        }

        // Initial load
        $(document).ready(function() {
            loadPlayers();
            // Optional: Auto refresh every 15 seconds
            // setInterval(loadPlayers, 15000);
        });
    </script>

    <script>
        let timeOffset = 0;
        let targetTime = 0;
        let countdownInterval = null;
        let lastTimerSentAt = 0;

        function setServerTime(serverTimeMilliseconds) {
            const serverTimeTicks = (serverTimeMilliseconds * 10000) + 621355968000000000;
            const serverTimeSeconds = Math.floor(serverTimeTicks / 10000000);
            const localTimeSeconds = Math.floor(((Date.now()) * 10000 + 621355968000000000) / 10000000);
            timeOffset = serverTimeSeconds - localTimeSeconds;
            console.log(`✅ [setServerTime] Time offset set: ${timeOffset} seconds`);
        }

        function handleTimerEvent(currentTimeMilliseconds, systemTimeMilliseconds) {
            const receiveTime = Date.now();
            const networkDelay = (receiveTime - lastTimerSentAt) / 1000; // delay in seconds

            setServerTime(systemTimeMilliseconds);
            const utcDateTime = new Date(currentTimeMilliseconds);
            targetTime = Math.floor(utcDateTime.getTime() / 1000) + networkDelay; // adjust forward

            console.log(
                `✅ [handleTimerEvent] targetTime set to: ${targetTime} (+${networkDelay.toFixed(2)}s delay compensated)`
            );
        }

        function updateCountdown() {
            const currentTime = Math.floor(Date.now() / 1000) + timeOffset;
            let timeRemaining = targetTime - currentTime;

            if (timeRemaining < 0) {
                timeRemaining = 60 - Math.abs(timeRemaining % 60);
            }

            const seconds = Math.floor(timeRemaining % 60);
            const formattedSeconds = seconds < 10 ? '0' + seconds : seconds;
            document.getElementById('timer-badge').innerText = `00:${formattedSeconds}`;
        }

        function sendTimerRequest(socket) {
            const message = {
                data: "Timer request"
            };
            lastTimerSentAt = Date.now(); // record send time
            socket.send(JSON.stringify(message));
            console.log("📤 [WebSocket] Timer request sent");
        }

        function startTimerSocket() {
            const socket = new WebSocket('ws://128.199.64.164:3101');

            socket.onopen = function() {
                console.log("✅ [WebSocket] Connection opened");

                sendTimerRequest(socket);

                if (!countdownInterval) {
                    countdownInterval = setInterval(updateCountdown, 1000);
                }

                setInterval(() => sendTimerRequest(socket), 5000);
            };

            socket.onmessage = function(event) {
                const data = JSON.parse(event.data);
                console.log("📩 [WebSocket] Message received:", data);

                if (data.eventName === "TIMER") {
                    handleTimerEvent(data.currentTime, data.systemTime);
                }
            };

            socket.onclose = function(event) {
                console.log("❌ [WebSocket] Connection closed", event);
                if (countdownInterval) clearInterval(countdownInterval);
            };

            socket.onerror = function(event) {
                console.error("❌ [WebSocket] Error occurred:", event);
                if (countdownInterval) clearInterval(countdownInterval);
            };
        }

        startTimerSocket();
    </script>

  <script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event to number cards
    @for($i = 0; $i <= 9; $i++)
        document.getElementById('card-{{$i}}').addEventListener('click', function() {
            if(confirm('Are you sure you want to bet on {{$i}}?')) {
                submitCustomBet({{$i}});
            }
        });
    @endfor

    function submitCustomBet(betNumber) {
        // Create a form dynamically
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("custom.bet.update") }}';
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add custom_bet field
        const betInput = document.createElement('input');
        betInput.type = 'hidden';
        betInput.name = 'custom_bet';
        betInput.value = betNumber;
        form.appendChild(betInput);
        
        // Submit the form
        document.body.appendChild(form);
        form.submit();
    }
});
</script>


@endsection
