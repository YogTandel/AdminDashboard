@extends('layouts.layout')

@section('page-name', 'Transfer')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Transfer Funds</h6>
                            <a href="{{ route('agentlist.show') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to Agents
                            </a>
                        </div>
                    </div>

                    <!-- Card body -->
                    <div class="card-body pt-4">
                        <form id="transferForm" method="POST" action="{{ route('transfer.execute') }}">
                        @csrf
                        <input type="hidden" name="agent_id" value="{{ $selectedAgent['id'] }}">
                        <input type="hidden" name="type" value="subtract">

                        <!-- Agent Balance -->
                        <div class="mb-4">
                            <label class="form-label">Agent Balance</label>
                            <input type="text" class="form-control" value="{{ number_format($selectedAgent['balance'], 2) }}" readonly>
                        </div>

                        <!-- Amount to Transfer -->
                        <div class="mb-4">
                            <label for="transferAmount" class="form-label">Amount to Transfer</label>
                            <input type="number" class="form-control" name="amount" id="transferAmount" min="0.01" step="0.01" max="{{ $selectedAgent['balance'] }}" required>
                        </div>

                        <!-- Error Message -->
                        <div class="text-danger mb-4" id="amountError" style="display:none">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Amount exceeds available balance
                        </div>

                        <!-- Remaining Balance -->
                        <div class="mb-4">
                            <label class="form-label">Remaining Balance</label>
                            <input type="text" class="form-control" id="remainingBalance" readonly>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn bg-gradient-primary w-100" id="submitBtn">
                                <i class="fas fa-exchange-alt me-2"></i> Process Transfer
                            </button>
                        </div>
                        <!-- Success message -->
<div class="alert alert-success d-none" id="successMessage">
    <i class="fas fa-check-circle me-2"></i> Transfer processed successfully!
</div>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer />



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const agentBalance = parseFloat({{ $selectedAgent['balance'] }});
        const transferAmount = document.getElementById('transferAmount');
        const remainingBalance = document.getElementById('remainingBalance');
        const amountError = document.getElementById('amountError');
        const submitBtn = document.getElementById('submitBtn');
        const successMessage = document.getElementById('successMessage');

        remainingBalance.value = agentBalance.toFixed(2);

        transferAmount.addEventListener('input', function () {
            const amount = parseFloat(this.value) || 0;
            const remaining = agentBalance - amount;

            if (amount > agentBalance) {
                amountError.style.display = 'block';
                submitBtn.disabled = true;
                remainingBalance.value = '0.00';
                this.classList.add('is-invalid');
            } else {
                amountError.style.display = 'none';
                submitBtn.disabled = false;
                remainingBalance.value = remaining.toFixed(2);
                this.classList.remove('is-invalid');
            }
        });

        document.getElementById('transferForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const amount = parseFloat(transferAmount.value);
            if (amount > agentBalance || amount <= 0) {
                alert('Please enter a valid amount.');
                return;
            }

            const data = {
                agent_id: "{{ $selectedAgent['id'] }}",
                amount: amount,
                type: 'subtract', // Or 'add' based on your business logic
                _token: "{{ csrf_token() }}"
            };

            fetch("{{ route('transfer.execute') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(res => {
                    if (res.success) {
                        successMessage.classList.remove('d-none');
                        successMessage.innerHTML =
                            `<i class="fas fa-check-circle me-2"></i> ${res.success}`;

                        // Optionally disable form after success
                        submitBtn.disabled = true;
                    } else {
                        alert('Transfer failed.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while processing the transfer.');
                });
        });
    });
</script>

@endsection
