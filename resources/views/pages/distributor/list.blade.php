@extends('layouts.layout')

@section('page-name', 'Distributor List')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Distributor Users</h6>
                        <div class="d-flex align-items-center gap-2 flex-wrap mt-3 me-3">
                            <!-- Show Dropdown -->
                            <form method="GET" class="d-flex align-items-center mb-0">
                                <label for="per_page" class="mb-0 me-2 text-sm text-dark fw-bold">Show:</label>
                                <div class="input-group input-group-outline border-radius-lg shadow-sm">
                                    <select name="per_page" id="per_page" class="form-select border-0 ps-3 pe-4"
                                        onchange="this.form.submit()" style="min-width: 60px;">
                                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    </select>
                                </div>
                                @if (request()->has('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                            </form>
                            <form action="{{ route('distributor.show') }}" method="GET" class="d-flex align-items-center">
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
                            <button type="button" class="btn bg-primary mb-0 text-white" data-bs-toggle="modal"
                                data-bs-target="#exampleModalAddAgent">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Distributor
                            </button>
                            @include('pages.distributor.create')
                        </div>
                    </div>
                    <!-- Second Row: Date Filter -->
                    <form method="GET" class="d-flex justify-content-end align-items-center flex-wrap gap-2 mt-2 me-3">
                        <select name="date_range" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 150px;">
                            <option value="">Date Range</option>
                            <option value="2_days_ago" {{ request('date_range') == '2_days_ago' ? 'selected' : '' }}>Last 2 Days</option>
                            <option value="this_week" {{ request('date_range') == 'this_week' ? 'selected' : '' }}>This Week</option>
                            <option value="this_month" {{ request('date_range') == 'this_month' ? 'selected' : '' }}>This Month</option>
                        </select>
                        <input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}" style="width: 150px;">
                        <span class="text-sm mx-1">to</span>
                        <input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}" style="width: 150px;">
                        @if (request()->has('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <button type="submit" class="btn btn-sm btn-primary  mb-0">Filter</button>
                        @if (request()->has('from_date') || request()->has('to_date') || request()->has('date_range'))
                            <a href="{{ route('distributor.show') }}" class="btn btn-secondary btn-sm px-3 mt-3">Reset</a>
                        @endif
                    </form>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Password</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Endpoint</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">DateOfCreation</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($distributors->isEmpty())
                                        <tr><td colspan="8" class="text-center">No agents data found.</td></tr>
                                    @else
                                        @foreach ($distributors as $index => $distributor)
                                            <tr>
                                                <td><h6 class="mb-0 text-sm">{{ $index + 1 }}</h6></td>
                                                <td><h6 class="mb-0 text-sm" id="name-{{ $distributor->id }}">{{ $distributor->player }}</h6></td>
                                                <td><p class="text-xs font-weight-bold mb-0" id="password-{{ $distributor->id }}">{{ $distributor->original_password }}</p></td>
                                                <td><p class="text-xs font-weight-bold mb-0">{{ $distributor->role }}</p></td>
                                                <td class="align-middle text-center text-sm"><p class="text-xs font-weight-bold mb-0">{{ $distributor->endpoint }}</p></td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="badge badge-sm {{ $distributor->status === 'Active' ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                        {{ $distributor->status }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ \Carbon\Carbon::createFromFormat('YmdHis', (string)(int) $distributor->DateOfCreation)->format('d M Y, H:i') }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center justify-content-around">
                                                        <a href="javascript:;" onclick="copyToClipboard({{ $distributor->id }})"
                                                           class="text-secondary font-weight-bold text-xs me-2"
                                                           data-bs-toggle="tooltip" title="Copy distributor">
                                                           <i class="fas fa-copy" onclick="copyToClipboard('{{ $distributor->_id }}')" style="cursor: pointer;"></i>
                                                        </a>
                                                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs me-2"
                                                           data-bs-toggle="modal" data-bs-target="#Editmodal{{ $distributor->id }}"
                                                           title="Edit Distributor">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @foreach ($distributors as $distributor_data)
                                                            @include('pages.distributor.edit')
                                                        @endforeach
                                                        @php $admin = Auth::guard('admin')->user(); @endphp
                                                        @if ($admin)
                                                            <a href="javascript:;" class="text-success font-weight-bold text-xs me-2"
                                                               data-bs-toggle="modal" data-bs-target="#refillModal{{ $distributor->id }}"
                                                               title="Refill Balance">
                                                                <i class="fa-solid fa-indian-rupee-sign"></i>
                                                            </a>
                                                        @endif
                                                        @foreach ($distributors as $distributor_data)
                                                            @include('pages.distributor.refil')
                                                        @endforeach
                                                        <form action="{{ route('Distributor.delete', $distributor->id) }}" method="post" style="display:flex;">
                                                            @csrf @method('DELETE')
                                                            <button class="text-danger font-weight-bold text-xs me-2"
                                                                    onclick="return confirm('Are you sure?')"
                                                                    style="background: none; border: none; padding: 0;"
                                                                    title="Delete Agent">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                        <td>
                                                            @if ($distributor->status === 'Active')
                                                            <a href="javascript:void(0);" onclick="toggleStatus('{{ $distributor->_id }}', 'Inactive')" title="Block">
                                                                <i class="fas fa-user-lock text-danger" style="cursor: pointer;"></i>
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0);" onclick="toggleStatus('{{ $distributor->_id }}', 'Active')" title="Unblock">
                                                                <i class="fas fa-user-check text-success" style="cursor: pointer;"></i>
                                                            </a>
                                                        @endif

                                                        </td>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3 pagination pagination-info">
                                {{ $distributors->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-footer />
        </div>
    </div>
@endsection


@push('scripts')
<script>
    function copyToClipboard(distributorId) {
        console.log("Icon clicked", distributorId); // Debug line

        const name = document.getElementById('name-' + distributorId)?.innerText.trim();
        const password = document.getElementById('password-' + distributorId)?.innerText.trim();

        if (!name || !password) {
            console.error('Name or password not found');
            return;
        }

        const textToCopy = `Name: ${name}\nPassword: ${password}`;

        navigator.clipboard.writeText(textToCopy).then(() => {
            alert('Copied successfully!');
        }).catch((err) => {
            console.error('Copy failed:', err);
            alert('Copy failed. Check clipboard permission.');
        });
    }
</script>
<script>
    function toggleStatus(distributorId, newStatus) {
        fetch(`/distributor/status-update/${distributorId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Status updated successfully!');
                location.reload(); // Reload to reflect updated status and icon
            } else {
                alert('Something went wrong!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Request failed.');
        });
    }
</script>
@endpush



