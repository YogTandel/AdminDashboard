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
                            <form method="GET" action="{{ route('player.show') }}" class="d-flex align-items-center mb-0">
                                <label for="per_page" class="mb-0 me-2 text-sm text-dark fw-bold">Show:</label>
                                <div class="input-group input-group-outline border-radius-lg shadow-sm">
                                    <select name="per_page" id="per_page" class="form-select border-0 ps-3 pe-4"
                                        onchange="this.form.submit()" style="min-width: 60px;">
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                    </select>
                                </div>

                                <!-- Preserve other parameters -->
                                @if (request()->has('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                @if (request()->has('distributor_name'))
                                    <input type="hidden" name="distributor_name" value="{{ request('distributor_name') }}">
                                @endif
                                @if (request()->has('agent_name'))
                                    <input type="hidden" name="agent_name" value="{{ request('agent_name') }}">
                                @endif
                                @if (request()->has('status'))
                                    <input type="hidden" name="status" value="{{ request('status') }}">
                                @endif
                                @if (request()->has('date_range'))
                                    <input type="hidden" name="date_range" value="{{ request('date_range') }}">
                                @endif
                                @if (request()->has('from_date'))
                                    <input type="hidden" name="from_date" value="{{ request('from_date') }}">
                                @endif
                                @if (request()->has('to_date'))
                                    <input type="hidden" name="to_date" value="{{ request('to_date') }}">
                                @endif
                            </form>

                            <!-- Search Form -->
                            <form action="{{ route('player.show') }}" method="GET" class="d-flex align-items-center">
                                <div class="input-group input-group-outline rounded-pill me-2 shadow-sm">
                                    <span class="input-group-text bg-transparent border-0 text-secondary">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="search" name="search" class="form-control border-0"
                                        placeholder="Search players..." value="{{ request('search') }}"
                                        onfocus="this.parentElement.classList.add('is-focused')"
                                        onfocusout="this.parentElement.classList.remove('is-focused')">
                                </div>
                                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

                                <button type="submit" class="btn bg-gradient-warning rounded-pill shadow-sm mb-0">
                                    Search
                                </button>
                                @if (request()->has('search') && request('search') != '')
                                    <a href="{{ route('player.show') }}"
                                        class="btn btn-secondary btn-sm px-3 ms-2">Reset</a>
                                @endif
                            </form>

                            @if (auth('admin')->check())
                                <button type="button" class="btn btn-primary mb-0" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalAddplayer">
                                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Player
                                </button>
                            @endif
                            @include('pages.player.create')
                        </div>
                    </div>

                    <!-- Second Row: Filters -->
                    <form action="{{ route('player.show') }}" method="GET"
                        class="d-flex justify-content-end align-items-center flex-wrap gap-2 mt-2 me-3 p-3">
                        <!-- Date Range -->
                        <select name="date_range" class="form-select form-select-sm" style="width: 150px;">
                            <option value="">Date Range</option>
                            <option value="2_days_ago" {{ request('date_range') == '2_days_ago' ? 'selected' : '' }}>Last 2
                                Days</option>
                            <option value="last_week" {{ request('date_range') == 'last_week' ? 'selected' : '' }}>Last
                                Week</option>
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

                        <!-- Distributor Filter -->
                        @if (auth('admin')->check())
                            <select name="distributor_name" class="form-select form-select-sm" style="width: 160px;">
                                <option value="">All Distributors</option>
                                @foreach ($distributors as $distributor)
                                    <option value="{{ $distributor->player }}"
                                        {{ request('distributor_name') == $distributor->player ? 'selected' : '' }}>
                                        {{ $distributor->player }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Agent Filter -->
                            <select name="agent_name" class="form-select form-select-sm" style="width: 160px;">
                                <option value="">All Agents</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->player }}"
                                        {{ request('agent_name') == $agent->player ? 'selected' : '' }}>
                                        {{ $agent->player }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Status Filter -->
                            <select name="status" class="form-select form-select-sm" style="width: 120px;">
                                <option value="">All Status</option>
                                <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        @endif

                        <!-- Hidden Inputs -->
                        @if (request()->has('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

                        <!-- Filter & Reset -->
                        <button type="submit" class="btn btn-sm btn-primary mb-0">Filter</button>
                        @if (request()->has('from_date') ||
                                request()->has('to_date') ||
                                request()->has('date_range') ||
                                request()->has('distributor_name') ||
                                request()->has('agent_name') ||
                                request()->has('status'))
                            <a href="{{ route('player.show') }}" class="btn btn-secondary btn-sm">Reset</a>
                        @endif
                    </form>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Password</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Role</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Balance</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Distributor</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Agent</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Login</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Win</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Date</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($players->isEmpty())
                                        <tr>
                                            <td colspan="12" class="text-center py-4">
                                                <i class="fas fa-inbox fa-2x text-secondary mb-2 d-block"></i>
                                                No players data found.
                                                @if (request()->hasAny(['search', 'distributor_name', 'agent_name', 'status', 'from_date', 'to_date', 'date_range']))
                                                    <br><small class="text-info">Try adjusting your filters or <a
                                                            href="{{ route('player.show') }}">reset filters</a></small>
                                                @endif
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($players as $index => $player)
                                            <tr class="text-center">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $players->firstItem() + $index }}
                                                            </h6>
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
                                                        {{ $player->distributorUser?->player ?? 'N/A' }}</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $player->agent }}</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="badge badge-sm {{ $player->login_status ? 'bg-gradient-success' : 'bg-gradient-danger' }} toggle-login-status"
                                                        data-player-id="{{ $player->id }}" style="cursor: pointer;">
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
                                                    <div
                                                        class="d-flex align-items-center justify-content-around d-none d-md-flex">
                                                        {{-- Desktop: show all action buttons inline --}}
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
                                                            onclick="copyToClipboard('{{ $player->player }} - {{ $player->original_password }}')"
                                                            class="text-secondary font-weight-bold text-xs ms-2 me-2"
                                                            data-bs-toggle="tooltip" title="Copy Player">
                                                            <i class="fas fa-copy" style="cursor: pointer;"></i>
                                                        </a>

                                                        @if (Auth::guard('admin')->check())
                                                            <a href="javascript:;"
                                                                class="text-secondary font-weight-bold text-xs me-2"
                                                                title="Edit Player" data-bs-toggle="modal"
                                                                data-bs-target="#editModal{{ $player->id }}">
                                                                <i class="fas fa-edit me-1"></i>
                                                            </a>
                                                            @include('pages.player.edit')

                                                            <form action="{{ route('player.delete', $player->id) }}"
                                                                method="post" style="display:flex;">
                                                                @csrf @method('DELETE')
                                                                <button class="text-danger font-weight-bold text-xs me-2"
                                                                    onclick="return confirm('Are you sure?')"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
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
                                                            <i
                                                                class="fas {{ $player->status === 'Active' ? 'fa-ban text-danger' : 'fa-check text-success' }}"></i>
                                                        </a>
                                                    </div>

                                                    {{-- Mobile: collapse into 3-dots dropdown --}}
                                                    <div class="dropdown d-md-none">
                                                        <button class="btn btn-sm" type="button"
                                                            id="dropdownMenu{{ $player->id }}"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end"
                                                            aria-labelledby="dropdownMenu{{ $player->id }}">
                                                            @if (auth()->check() && auth()->user()->role === 'agent')
                                                                <li>
                                                                    <a class="dropdown-item text-success"
                                                                        href="javascript:;" data-bs-toggle="modal"
                                                                        data-bs-target="#transferModal{{ $player->id }}">
                                                                        <i class="fa-solid fa-indian-rupee-sign me-1"></i>
                                                                        Transfer
                                                                    </a>
                                                                </li>
                                                            @endif
                                                            <li>@include('pages.player.refil2', [
                                                                'user' => $player,
                                                            ])</li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0);"
                                                                    onclick="copyToClipboard('{{ $player->player }} - {{ $player->original_password }}')">
                                                                    <i class="fas fa-copy me-1"></i> Copy Player
                                                                </a>
                                                            </li>
                                                            @if (Auth::guard('admin')->check())
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:;"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editModal{{ $player->id }}">
                                                                        <i class="fas fa-edit me-1"></i> Edit
                                                                    </a>
                                                                </li>
                                                            @endif
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('player.history', $player->_id) }}">
                                                                    <i class="fas fa-history me-1"></i> History
                                                                </a>
                                                            </li>
                                                            @if (Auth::guard('admin')->check())
                                                                <li>
                                                                    <form
                                                                        action="{{ route('player.delete', $player->id) }}"
                                                                        method="post"
                                                                        onsubmit="return confirm('Are you sure?')">
                                                                        @csrf @method('DELETE')
                                                                        <button class="dropdown-item text-danger"
                                                                            type="submit">
                                                                            <i class="fas fa-trash me-1"></i> Delete
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            @endif
                                                            <li>
                                                                <a class="dropdown-item toggle-status" href="javascript:;"
                                                                    data-player-id="{{ $player->id }}">
                                                                    <i
                                                                        class="fas {{ $player->status === 'Active' ? 'fa-ban text-danger' : 'fa-check text-success' }} me-1"></i>
                                                                    {{ $player->status === 'Active' ? 'Block Player' : 'Unblock Player' }}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            {{-- Pagination --}}
                            @if ($players->hasPages())
                                <div class="d-flex justify-content-center mt-3 pagination pagination-info">
                                    {{ $players->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <x-footer />
        </div>
    </div>

    @push('scripts')
        <script>
            function copyToClipboard(text) {
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(text).then(() => {
                        alert("Copied: " + text);
                    }).catch(err => {
                        console.error("Failed to copy: ", err);
                    });
                } else {
                    let textarea = document.createElement("textarea");
                    textarea.value = text;
                    textarea.style.position = "fixed";
                    textarea.style.opacity = "0";
                    document.body.appendChild(textarea);
                    textarea.focus();
                    textarea.select();
                    try {
                        document.execCommand('copy');
                        alert("Copied: " + text);
                    } catch (err) {
                        console.error("Fallback copy failed", err);
                    }
                    document.body.removeChild(textarea);
                }
            }

            $(document).on('click', '.toggle-status', function(e) {
                e.preventDefault();
                const playerId = $(this).data('player-id');
                const $icon = $(this).find('i');
                const $link = $(this);
                const $row = $(this).closest('tr');
                const $statusBadge = $row.find('td:nth-child(9) .badge-sm');

                $.ajax({
                    url: '/player/toggle-status/' + playerId,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'Active') {
                            $icon.removeClass('fa-check text-success').addClass('fa-ban text-danger');
                            $link.attr('title', 'Block Player');
                            $statusBadge.removeClass('bg-gradient-danger').addClass('bg-gradient-success')
                                .text('Active');
                        } else {
                            $icon.removeClass('fa-ban text-danger').addClass('fa-check text-success');
                            $link.attr('title', 'Unblock Player');
                            $statusBadge.removeClass('bg-gradient-success').addClass('bg-gradient-danger')
                                .text('Inactive');
                        }
                    },
                    error: function(xhr) {
                        alert('Error occurred while updating status.');
                        console.error('AJAX error:', xhr.responseText);
                    }
                });
            });

            $(document).on('click', '.toggle-login-status', function() {
                const playerId = $(this).data('player-id');
                const $badge = $(this);
                const currentStatus = $badge.text().trim();

                if (currentStatus === 'True') {
                    $.ajax({
                        url: '/player/toggle-login-status/' + playerId,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === false || response.status === 0) {
                                $badge.removeClass('bg-gradient-success').addClass('bg-gradient-danger')
                                    .text('False');
                            }
                        },
                        error: function() {
                            alert('Error updating login status.');
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
