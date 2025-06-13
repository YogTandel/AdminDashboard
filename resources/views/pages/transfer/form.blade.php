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
                <div class="card-header pb-0">
                    <h6 class="mb-0">Transfer Funds</h6>
                </div>
                <div class="card-body pt-4">
                    <form id="transferForm" method="POST" action="{{ route('transfer.execute') }}">
                        @csrf
                        <input type="hidden" name="agent_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="type" value="subtract">

                        <div class="mb-4">
                            <label class="form-label">Agent Balance</label>
                            <input type="text" class="form-control" value="{{ number_format(auth()->user()->endpoint, 2) }}" readonly>
                        </div>

                        <div class="mb-4">
                            <label for="transferAmount" class="form-label">Amount to Transfer</label>
                            <input type="number" class="form-control" name="amount" id="transferAmount" min="0.01" step="0.01" max="{{ auth()->user()->endpoint }}" required>
                        </div>

                        <div class="text-danger mb-4" id="amountError" style="display:none">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Amount exceeds available balance
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Remaining Balance</label>
                            <input type="text" class="form-control" id="remainingBalance" readonly>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn bg-gradient-primary w-100" id="submitBtn">
                                <i class="fas fa-exchange-alt me-2"></i> Process Transfer
                            </button>
                        </div>

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
    const agentBalance = parseFloat("{{ auth()->user()->endpoint }}");
    const transferAmount = document.getElementById('transferAmount');
    const remainingBalance = document.getElementById('remainingBalance');
    const amountError = document.getElementById('amountError');
    const submitBtn = document.getElementById('submitBtn');
    const successMessage = document.getElementById('successMessage');

    if (agentBalance <= 0) {
        submitBtn.disabled = true;
        amountError.style.display = 'block';
        amountError.innerHTML = `<i class="fas fa-exclamation-circle me-2"></i> Agent has zero balance. Transfer not allowed.`;
    }

    remainingBalance.value = agentBalance.toFixed(2);

    transferAmount.addEventListener('input', function () {
        const amount = parseFloat(this.value) || 0;
        const remaining = agentBalance - amount;

        if (amount > agentBalance || agentBalance <= 0) {
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
        if (amount > agentBalance || amount <= 0 || agentBalance <= 0) {
            alert('Please enter a valid amount. Agent must have sufficient balance.');
            return;
        }

        const data = {
            agent_id: "{{ auth()->id() }}",
            amount: amount,
            type: 'subtract',
            _token: "{{ csrf_token() }}"
        };

        fetch("{{ route('transfer.execute') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                successMessage.classList.remove('d-none');
                successMessage.innerHTML = `<i class="fas fa-check-circle me-2"></i> ${res.success}`;
                submitBtn.disabled = true;
            } else {
                alert('Transfer failed: ' + (res.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('An error occurred: ' + error.message);
        });
    });
});
</script>
@endsection
