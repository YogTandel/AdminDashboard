@extends('layouts.layout')

@section('page-name', 'Agent List')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Agent Users</h6>
                        <div class="d-flex align-items-center gap-3">
                            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                                <div class="input-group">
                                    <span class="input-group-text text-body"><i class="fas fa-search"
                                            aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" placeholder="Search agent...">
                                    <button class="btn btn-outline-primary mb-0" type="button">Search</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary mb-0" data-bs-toggle="modal"
                                data-bs-target="#exampleModalAddAgent">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Agent
                            </button>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Player
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Password
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Role
                                        </th>
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Balance
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Distributor
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Agent
                                        </th>
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Created At
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Distributor ID
                                        </th>
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($agents as $index => $agent)
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $agent->player }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $agent->original_password }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ ucfirst($agent->role) }}</p>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-xs font-weight-bold">₹{{ number_format($agent->balance, 2) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $agent->distributor }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $agent->agent }}</p>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="badge badge-sm {{ $agent->status === 'Active' ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                    {{ strtoupper($agent->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ \Carbon\Carbon::createFromFormat('YmdHis', $agent->DateOfCreation)->format('d M Y, H:i') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $agent->distributor_id }}</p>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="javascript:;"
                                                        class="text-secondary font-weight-bold text-xs me-2"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Copy Agent">
                                                        <i class="fas fa-copy"></i>
                                                    </a>
                                                    <a href="javascript:;"
                                                        class="text-secondary font-weight-bold text-xs me-2"
                                                        data-bs-placement="top" title="Edit Agent" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalEditAgent">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:;"
                                                        class="text-danger font-weight-bold text-xs toggle-status"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Block/Unblock Agent">
                                                        <i class="fas fa-ban"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center text-secondary text-sm">No agents data
                                                found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Agent Modal -->
            <div class="modal fade" id="exampleModalAddAgent" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalAddAgent" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bolder text-primary text-gradient">Add New Agent</h3>
                                    <p class="mb-0">Enter Agent name and password to register</p>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left">
                                        <label>Agent Name</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Name" aria-label="Name"
                                                name="name" aria-describedby="name-addon">
                                        </div>
                                        <label>Initial Point (RS.0000)</label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" placeholder="0.00"
                                                aria-label="Point" name="point" aria-describedby="email-addon">
                                        </div>
                                        <label>Password</label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control" placeholder="Password"
                                                aria-label="Password" name="password" aria-describedby="password-addon">
                                        </div>
                                        <label>Confirm Password</label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control" placeholder="Password"
                                                aria-label="Password" name="password" aria-describedby="password-addon">
                                        </div>
                                        <div class="text-center">
                                            <button type="button"
                                                class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Save
                                                Agent
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Add Agent Modal -->

            <!-- Edit Agent Modal -->
            <div class="modal fade" id="exampleModalEditAgent" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalEditAgent" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h3 class="font-weight-bolder text-primary text-gradient">Edit Agent</h3>
                                </div>
                                <div class="card-body pb-3">
                                    <form role="form text-left">
                                        <label>Agent Name</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Name"
                                                aria-label="Name" name="name" aria-describedby="name-addon">
                                        </div>
                                        <label>Initial Point (RS.0000)</label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" placeholder="0.00"
                                                aria-label="Point" name="point" aria-describedby="email-addon">
                                        </div>
                                        <label>Password</label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control" placeholder="Password"
                                                aria-label="Password" name="password" aria-describedby="password-addon">
                                        </div>
                                        <label>Confirm Password</label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control" placeholder="Confirm Password"
                                                aria-label="password_confirmation" name="password_confirmation"
                                                aria-describedby="password-addon">
                                        </div>
                                        <div class="text-center">
                                            <button type="button"
                                                class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Update
                                                Agent
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Edit Agent Modal -->

            <x-footer />
        </div>
    </div>
@endsection
