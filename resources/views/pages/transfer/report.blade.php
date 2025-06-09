@extends('layouts.layout')

@section('page-name', 'report')

@section('content')

  <div class="container-fluid py-4">
        <!-- Toast Container -->
        <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1080">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-text"><strong>{{ session('success') }}</strong></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-text"><strong>{{ session('error') }}</strong></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        <!-- End Toast Container -->

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <!-- First Row -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
                        <h6 class="mb-0 ms-4 mt-3 text-bolder">Transfer Report</h6>
                        <div class="d-flex align-items-center gap-2 flex-wrap mt-3 me-3">
                           
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
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Balance
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Agent
                                        </th>
                                      
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            endpoint
                                        </th>
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

@endsection