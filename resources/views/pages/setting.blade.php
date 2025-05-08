@extends('layouts.layout')

@section('page-name', 'Setting')

@section('content')
    <div class="container-fluid py-4">
        <div class="card-shadow">
            <div class="card card-frame">
                <div class="card-body pb-3">
                    <div class="text-center mb-3 fw-bold">
                        <div class="d-flex justify-content-between mb-3">
                            <div><strong>Standing: </strong>30</div>
                            <div><strong>Admin% Earning: </strong>0</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-lable">Agent Commission%</label>
                        <input type="text" class="form-control" value="0.45">
                    </div>

                    <div class="mb-3">
                        <label class="form-lable">Distributor Commission%</label>
                        <input type="text" class="form-control" value="0.1000000000149012">
                    </div>

                    <div class="flex flex-col text-center mb-4">
                        <button type="button" class="btn btn-info btn-sm">Update Agent And Distributor
                            Commission</button>
                        <button type="button" class="btn btn-info btn-sm ms-2">Release Commission</button>
                        <button type="button" class="btn btn-info btn-sm ms-2">Set To Minimum</button>
                        <button type="button" class="btn btn-info btn-sm ms-2">Standing To Earing</button>
                        <button type="button" class="btn btn-info btn-sm ms-2">Earning to 0</button>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-lable">Profit%</label>
                            <input type="text" class="form-control" placeholder="Enter Profit Percentage">
                        </div>

                        <div class="col-md-6 d-grid">
                            <label class="form-lable invisible">.</label>
                            <button class="btn btn-info">Update Earning%</button>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-lable">Add Points</label>
                            <input type="text" class="form-control" placeholder="Enter Points to Add">
                        </div>

                        <div class="col-md-6 d-grid">
                            <label class="form-lable invisible">.</label>
                            <button class="btn btn-info">Add To Admin</button>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-lable">Remove Points</label>
                            <input type="text" class="form-control" placeholder="Enter Profit Percentage">
                        </div>

                        <div class="col-md-6 d-grid">
                            <label class="form-lable invisible">.</label>
                            <button class="btn btn-danger">Remove from Admin</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer />
@endsection
