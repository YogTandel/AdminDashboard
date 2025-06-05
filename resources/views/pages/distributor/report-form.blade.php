@extends('layouts.layout')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Distributor Transfer Form</h5>
                    </div>
                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('distributor.transfer') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="distributor_id" class="form-label">Select Distributor</label>
                                <select name="distributor_id" id="distributor_id" class="form-select" required>
                                    <option value="">-- Select --</option>
                                    @foreach ($distributors as $distributor)
                                        <option value="{{ $distributor->id }}">{{ $distributor->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="agent_id" class="form-label">Agent ID</label>
                                <input type="text" class="form-control" name="agent_id" id="agent_id" required>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">Transfer Amount</label>
                                <input type="number" class="form-control" name="amount" id="amount" required min="1">
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
