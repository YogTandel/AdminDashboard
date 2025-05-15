@extends('layouts.layout')

@section('page-name', 'Distributor List')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Distributor Users</h6>
                        <div class="d-flex align-items-center gap-3">
                            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                                <div class="input-group">
                                    <span class="input-group-text text-body"><i class="fas fa-search"
                                            aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" placeholder="Search agent...">
                                    <button class="btn btn-outline-primary mb-0" type="button">Search</button>
                                </div>
                            </div>
                            <button type="button" class="btn bg-primary mb-0 text-white" data-bs-toggle="modal"
                                data-bs-target="#exampleModalAddAgent">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Distributor
                            </button>
                            @include('pages.distributor.create')
                        </div>
                    </div>
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
                                            Endpoint
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            DateOfCreation
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($distributors->isEmpty())
                                        <tr>
                                            <td colspan="8" class="text-center">No agents data found.</td>
                                        </tr>
                                    @else
                                        @foreach ($distributors as $index => $distributor)
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
                                                            <h6 class="mb-0 text-sm">{{ $distributor->player }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $distributor->original_password }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $distributor->role }}</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        ₹{{ number_format($distributor->balance, 2) }}</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $distributor->endpoint }}
                                                    </p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="badge badge-sm {{ $distributor->status === 'Active' ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                        {{ $distributor->status }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ \Carbon\Carbon::createFromFormat('YmdHis', $distributor->DateOfCreation)->format('d M Y, H:i') }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center justify-content-around">
                                                        <a href="javascript:;"
                                                            class="text-secondary font-weight-bold text-xs me-2"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Copy Agent">
                                                            <i class="fas fa-copy"></i>
                                                        </a>
                                                        <a href="javascript:;"
                                                            class="text-secondary font-weight-bold text-xs me-2"
                                                            data-bs-placement="top" title="Edit Distributor"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#Editmodal{{ $distributor->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @foreach ($distributors as $distributor)
                                                            @include('pages.distributor.edit')
                                                        @endforeach
                                                        <a href="javascript:;"
                                                            class="text-danger font-weight-bold text-xs toggle-status"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Block/Unblock Agent">
                                                            <i class="fas fa-ban"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <x-footer />
        </div>
    </div>
@endsection
