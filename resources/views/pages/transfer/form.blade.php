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
                        <p class="text-sm mb-0">
                            @if ($user->role === 'player')
                                Player ID: {{ $user->id }} | 
                                Transferring to your agent: {{ $transferTo->name ?? 'Not assigned' }}
                            @elseif($user->role === 'agent')
                                Agent ID: {{ $user->id }} | 
                                Transferring to your distributor: {{ $transferTo->name ?? 'Not assigned' }}
                            @endif
                        </p>
                    </div>

                    <div class="card-body pt-4">
                        <form id="transferForm" method="POST" action="{{ route('transfer.execute') }}">
                            @csrf
                            <input type="hidden" name="transfer_by" value="{{ $user->id }}">
                            <input type="hidden" name="type" value="subtract">

                           <div class="mb-4">
                                <label class="form-label">Your {{ $userType }} Balance</label>
                                <input type="text" class="form-control"
                                    value="{{ number_format($currentBalance, 2) }}" readonly>
                            </div>

                            <div class="mb-4">
                                <label for="transferAmount" class="form-label">Amount to Transfer</label>
                                <input type="number" class="form-control" name="amount" id="transferAmount" min="0.01"
                                    step="0.01" max="{{ $currentBalance }}" required>
                            </div>

                            <div class="text-danger mb-4" id="amountError" style="display:none">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <span id="errorText">Amount exceeds available balance</span>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Remaining Balance After Transfer</label>
                                <input type="text" class="form-control" id="remainingBalance"
                                    value="{{ number_format($currentBalance, 2) }}" readonly>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn bg-gradient-primary w-100" id="submitBtn">
                                    <i class="fas fa-exchange-alt me-2"></i> Process Transfer
                                </button>
                            </div>

                            <div class="alert alert-success d-none" id="successMessage">
                                <i class="fas fa-check-circle me-2"></i>
                                <span id="successText">Transfer processed successfully!</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const initialBalance = parseFloat("{{ $currentBalance }}");
            const transferAmount = document.getElementById('transferAmount');
            const remainingBalance = document.getElementById('remainingBalance');
            const amountError = document.getElementById('amountError');
            const submitBtn = document.getElementById('submitBtn');
            const successMessage = document.getElementById('successMessage');
            const errorText = document.getElementById('errorText');
            const successText = document.getElementById('successText');

            // Initial setup
            if (initialBalance <= 0) {
            submitBtn.disabled = true;
            amountError.style.display = 'block';
            errorText.textContent = 'You have zero balance. Transfer not allowed.';
            transferAmount.disabled = true;
        }

            transferAmount.addEventListener('input', function() {
            const amount = parseFloat(this.value) || 0;
            const remaining = initialBalance - amount;

            // ચેક્સ અને એરર હેન્ડલિંગ
            if (amount > initialBalance) {
                amountError.style.display = 'block';
                errorText.textContent = 'Amount exceeds available balance';
                submitBtn.disabled = true;
                this.classList.add('is-invalid');
            } else if (amount <= 0) {
                amountError.style.display = 'block';
                errorText.textContent = 'Amount must be greater than 0';
                submitBtn.disabled = true;
                this.classList.add('is-invalid');
            } else {
                amountError.style.display = 'none';
                submitBtn.disabled = false;
                this.classList.remove('is-invalid');
            }

            // રિમેઇનિંગ બેલેન્સ અપડેટ
            remainingBalance.value = remaining.toFixed(2);
            });

            // Form submission
            document.getElementById('transferForm').addEventListener('submit', function(e) {
                e.preventDefault();
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

                fetch("{{ route('transfer.execute') }}", {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: new FormData(this)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            successText.textContent = data.message || 'Transfer successful';
                            successMessage.classList.remove('d-none');

                            // Update balance display
                            document.querySelector('input[readonly]').value = data.new_balance.toFixed(
                                2);
                            transferAmount.value = '';
                            remainingBalance.value = data.new_balance.toFixed(2);
                        } else {
                            throw new Error(data.message || 'Transfer failed');
                        }
                    })
                    .catch(error => {
                        amountError.style.display = 'block';
                        errorText.textContent = error.message;
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML =
                            '<i class="fas fa-exchange-alt me-2"></i> Process Transfer';
                    });
            });
        });
    </script>
@endsection