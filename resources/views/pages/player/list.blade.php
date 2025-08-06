@extends('layouts.layout')

@section('page-name', 'Player List')

@section('content')
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
                                @foreach (request()->query() as $key => $value)
                                    @if ($key != 'per_page')
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
                                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

                                <button type="submit" class="btn bg-gradient-warning rounded-pill shadow-sm mb-0">
                                    Search
                                </button>
                                @if (request()->has('search') && request('search') != '')
                                    <a href="{{ route('player.show') }}"
                                        class="btn btn-secondary btn-sm px-3 mt-3">Reset</a>
                                @endif
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
                            <option value="last_week" {{ request('date_range') == 'last_week' ? 'selected' : '' }}>Last Week
                            </option>
                            <option value="last_month" {{ request('date_range') == 'last_month' ? 'selected' : '' }}>Last
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
                        <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

                        <!-- Filter Button -->
                        <button type="submit" class="btn btn-sm btn-primary  mb-0">Filter</button>
                        <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

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
                                            Login
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Win
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
                                                            <h6 id="name-{{ $player->id }}" class="mb-0 text-sm">
                                                                {{ $player->player }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p id="password-{{ $player->id }}"
                                                        class="text-xs font-weight-bold mb-0">
                                                        {{ $player->original_password }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $player->role }}</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        ₹{{ number_format($player->balance) }}</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $player->distributorUser?->player }}
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
                                                        {{ \Carbon\Carbon::createFromFormat('YmdHis', $player->DateOfCreation)->setTimezone('Asia/Kolkata')->format('d M Y') }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center justify-content-around">
                                                        @if (auth()->check() && auth()->user()->role === 'agent')
                                                            <a href="javascript:;"
                                                                class="text-success font-weight-bold text-xs me-2"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#transferModal{{ $player->id }}">
                                                                <i class="fa-solid fa-indian-rupee-sign me-1"></i>
                                                            </a>
                                                        @endif
                                                        @include('pages.player.refil2', [
                                                            'user' => $player,
                                                        ])
                                                        <a href="javascript:void(0);"
                                                            onclick="copyPlayerToClipboard('{{ $player->_id }}')"
                                                            class="text-secondary font-weight-bold text-xs"
                                                            data-bs-toggle="tooltip" title="Copy Player Credentials">
                                                            <i class="fas fa-copy me-2" style="cursor: pointer;"></i>
                                                        </a>
                                                        
                                                    @if (Auth::guard('admin')->check())      
                                                    <a href="javascript:;"
                                                                class="text-secondary font-weight-bold text-xs me-2"
                                                                title="Edit Player" 
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal{{ $player->id }}">
                                                                <i class="fas fa-edit me-1"></i>
                                                            </a>
                                                            @include('pages.player.edit')

                                                            <!-- Delete Button -->
                                                            <form action="{{ route('player.delete', $player->id) }}" method="post" style="display:flex;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="text-danger font-weight-bold text-xs me-2"
                                                                    onclick="return confirm('Are you sure?')"
                                                                    data-bs-toggle="tooltip" 
                                                                    data-bs-placement="top"
                                                                    title="Delete Player"
                                                                    style="background: none; border: none; padding: 0;">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <a href="{{ route('player.history', $player->_id) }}"
                                                            class="text-secondary font-weight-bold text-xs me-2"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Player History">
                                                            <i class="fas fa-history"></i>
                                                        </a>
                                                        <a href="javascript:;"
                                                            class="font-weight-bold text-xs toggle-status"
                                                            data-bs-toggle="tooltip"
                                                            title="{{ $player->status === 'Active' ? 'Block Player' : 'Unblock Player' }}"
                                                            data-player-id="{{ $player->id }}">
                                                            <i class="fas {{ $player->status === 'Active' ? 'fa-ban text-danger' : 'fa-check text-success' }}"></i>
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

    @push('scripts')
     <script>
    // Clipboard Copy Function (no change)
    function copyPlayerToClipboard(id) {
        const name = document.getElementById('name-' + id)?.innerText.trim();
        const password = document.getElementById('password-' + id)?.innerText.trim();

        if (!name || !password) {
            alert("Name or password missing");
            return;
        }

        const text = `Name: ${name}\nPassword: ${password}`;

        navigator.clipboard.writeText(text).then(() => {
            alert("Copied to clipboard!");
        }).catch((err) => {
            console.error("Clipboard write failed", err);
            alert("Failed to copy.");
        });
    }

    // Unified status toggle using jQuery only
   $(document).on('click', '.toggle-status', function (e) {
    e.preventDefault();

    const playerId = $(this).data('player-id');
    const $icon = $(this).find('i');
    const $link = $(this);
    const $row = $(this).closest('tr');
    
    // SPECIFICALLY target the Status badge (6th td in the row)
    const $statusBadge = $row.find('td:nth-child(9) .badge-sm');

    $.ajax({
        url: '/player/toggle-status/' + playerId,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (response) {
            if (response.status === 'Active') {
                // Update icon
                $icon.removeClass('fa-check text-success').addClass('fa-ban text-danger');
                $link.attr('title', 'Block Player');
                
                // Update status badge
                $statusBadge.removeClass('bg-gradient-danger').addClass('bg-gradient-success');
                $statusBadge.text('Active');
            } else {
                // Update icon
                $icon.removeClass('fa-ban text-danger').addClass('fa-check text-success');
                $link.attr('title', 'Unblock Player');
                
                // Update status badge
                $statusBadge.removeClass('bg-gradient-success').addClass('bg-gradient-danger');
                $statusBadge.text('Inactive');
            }
        },
        error: function (xhr, status, error) {
            alert('Error occurred while updating status.');
            console.error('AJAX error:', xhr.responseText);
        }
    });
});
</script>


    @endpush
@endsection