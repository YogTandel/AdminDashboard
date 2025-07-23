@extends('layouts.layout')

@section('page-name', 'Player List')

@section('content')
    <!-- Loader Container -->
    <div id="loader" class="loader-container">
        <div class="loader"></div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Player Users</h6>
                        <div class="d-flex align-items-center gap-2 flex-wrap mt-3 me-3">
                            <!-- Show Dropdown -->
                            <form method="GET" class="d-flex align-items-center mb-0">
                                <label for="per_page" class="mb-0 me-2 text-sm text-dark fw-bold">Show:</label>
                                <div class="input-group input-group-outline border-radius-lg shadow-sm">
                                    <select name="per_page" id="per_page" class="form-select border-0 ps-3 pe-4"
                                        onchange="this.form.submit()" style="min-width: 60px;">
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                                    </select>
                                </div>
                                
                                <!-- Add all current query parameters as hidden inputs -->
                                @foreach(request()->query() as $key => $value)
                                    @if($key != 'per_page')
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endif
                                @endforeach
                            </form>
                            <form action="{{ route('player.show') }}" method="GET" class="d-flex align-items-center">
                                <div class="input-group input-group-outline rounded-pill me-2 shadow-sm">
                                    <span class="input-group-text bg-transparent border-0 text-secondary">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <label class="form-label"></label>
                                    <input type="search" name="search" class="form-control border-0"
                                        onfocus="this.parentElement.classList.add('is-focused')"
                                        onfocusout="this.parentElement.classList.remove('is-focused')">
                                </div>
                                <button type="submit" class="btn bg-gradient-warning rounded-pill shadow-sm mb-0">
                                    Search
                                </button>
                            </form>
                            <button type="button" class="btn btn-primary mb-0" data-bs-toggle="modal"
                                data-bs-target="#exampleModalAddplayer">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Player
                            </button>
                            @include('pages.player.create')
                        </div>
                    </div>
                    <!-- Second Row: Date Filter -->
                    <form method="GET" class="d-flex justify-content-end align-items-center flex-wrap gap-2 mt-2 me-3">
                        <!-- Date Range -->
                        <select name="date_range" class="form-select form-select-sm" onchange="this.form.submit()"
                            style="width: 150px;">
                            <option value="">Date Range</option>
                            <option value="2_days_ago" {{ request('date_range') == '2_days_ago' ? 'selected' : '' }}>Last 2
                                Days</option>
                            <option value="this_week" {{ request('date_range') == 'this_week' ? 'selected' : '' }}>This Week
                            </option>
                            <option value="this_month" {{ request('date_range') == 'this_month' ? 'selected' : '' }}>This
                                Month</option>
                        </select>

                        <!-- From Date -->
                        <input type="date" name="from_date" class="form-control form-control-sm"
                            value="{{ request('from_date') }}" style="width: 150px;">

                        <!-- To Date -->
                        <span class="text-sm mx-1">to</span>
                        <input type="date" name="to_date" class="form-control form-control-sm"
                            value="{{ request('to_date') }}" style="width: 150px;">

                        <!-- Search Hidden -->
                        @if (request()->has('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <!-- Filter Button -->
                        <button type="submit" class="btn btn-sm btn-primary  mb-0">Filter</button>

                        <!-- Reset Button -->
                        @if (request()->has('from_date') || request()->has('to_date') || request()->has('date_range'))
                            <a href="{{ route('player.show') }}" class="btn btn-secondary btn-sm px-3 mt-3">Reset</a>
                        @endif
                    </form>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Password
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Role
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Balance
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Distributor
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Agent
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Login Status
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Winamount
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Date
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($players->isEmpty())
                                        <tr>
                                            <td colspan="11" class="text-center">No players data found.</td>
                                        </tr>
                                    @else
                                        @foreach ($players as $index => $player)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 id="name-{{ $player->id }}" class="mb-0 text-sm">{{ $player->player }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p id="password-{{ $player->id }}" class="text-xs font-weight-bold mb-0">
                                                        {{ $player->original_password }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $player->role }}</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        ₹{{ number_format($player->balance, 2) }}</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $player->distributorUser?->player }}
                                                    </p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $player->agent }}</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="badge badge-sm {{ $player->login_status ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                        {{ $player->login_status ? 'True' : 'False' }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="badge badge-sm {{ $player->status === 'Active' ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                        {{ $player->status }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $player->winamount }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ \Carbon\Carbon::createFromFormat('YmdHis', $player->DateOfCreation)->format('d M Y, H:i') }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center justify-content-around">
                                                        <a href="javascript:void(0);" onclick="copyPlayerToClipboard('{{ $player->_id }}')" 
                                                            class="text-secondary font-weight-bold text-xs" 
                                                            data-bs-toggle="tooltip" title="Copy Player Credentials">
                                                            <i class="fas fa-copy me-2" style="cursor: pointer;"></i>
                                                        </a>
                                                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs me-2"
                                                            title="Edit Player" data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $player->id }}">
                                                            <i class="fas fa-edit me-1"></i>
                                                        </a>
                                                        @include('pages.player.edit')
                                                         @if(auth()->check() && auth()->user()->role === 'agent')
                                                            <a href="javascript:;" class="text-success font-weight-bold text-xs me-2"
                                                                data-bs-toggle="modal" data-bs-target="#transferModal{{ $player->id }}">
                                                                <i class="fa-solid fa-indian-rupee-sign me-1"></i>
                                                            </a>
                                                        @endif
                                                        @include('pages.player.refil2', ['user' => $player])
                                                        <form action="{{ route('player.delete', $player->id) }}" method="post"
                                                            style="display:flex;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="text-danger font-weight-bold text-xs me-2"
                                                                onclick="return confirm('Are you sure?')" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Delete Player"
                                                                style="background: none; border: none; padding: 0;">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                        <a href="{{ route('player.history', $player->_id) }}"
                                                            class="text-secondary font-weight-bold text-xs me-2"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Player History">
                                                            <i class="fas fa-history"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{-- Pagination --}}
                            <div class="d-flex justify-content-center mt-3 pagination pagination-info">
                                {{ $players->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-footer />
        </div>
    </div>

    <!-- <style>
        /* Loader Styles */
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }

        .loader {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style> -->

    @push('scripts')
    <script>
        // Show loader when page is loading
        document.addEventListener('DOMContentLoaded', function() {
            // Show loader immediately when page starts loading
            document.getElementById('loader').style.display = 'flex';
            
            // Hide loader when page is fully loaded
            window.addEventListener('load', function() {
                document.getElementById('loader').style.display = 'none';
            });

            // Show loader during AJAX requests
            $(document).ajaxStart(function() {
                document.getElementById('loader').style.display = 'flex';
            });

            $(document).ajaxStop(function() {
                document.getElementById('loader').style.display = 'none';
            });

            $(document).ajaxError(function() {
                document.getElementById('loader').style.display = 'none';
            });
        });

        // Show loader when page is being refreshed
        window.addEventListener('beforeunload', function() {
            document.getElementById('loader').style.display = 'flex';
        });

        function copyPlayerToClipboard(id) {
            const name = document.getElementById('name-' + id)?.innerText.trim();
            const password = document.getElementById('password-' + id)?.innerText.trim();

            if (!name || !password) {
                alert("Name or password missing");
                return;
            }

            const text = `Name: ${name}\nPassword: ${password}`;

            // Show loader during copy operation
            // document.getElementById('loader').style.display = 'flex';

            // navigator.clipboard.writeText(text).then(() => {
            //     alert("Copied to clipboard!");
            // }).catch((err) => {
            //     console.error("Clipboard write failed", err);
            //     alert("Failed to copy.");
            // }).finally(() => {
            //     // Hide loader after copy operation
            //     document.getElementById('loader').style.display = 'none';
            // });
        }
    </script>
    @endpush
@endsection