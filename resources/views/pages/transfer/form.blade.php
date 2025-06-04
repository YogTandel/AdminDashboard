@extends('layouts.layout')

@section('page-name', 'Transfer')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
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
                        <form id="transferForm" role="form">
                            <!-- Agent Balance -->
                            <div class="mb-4">
                                <label class="form-label">Agent Balance</label>
                                <input type="text" class="form-control" id="agentBalance"
                                    value="{{ number_format($selectedAgent['balance'], 2) }}" readonly>
                            </div>

                            <!-- Amount to Transfer -->
                            <div class="mb-4">
                                <label for="transferAmount" class="form-label">Amount to Transfer</label>
                                <input type="number" class="form-control" id="transferAmount" min="0.01" step="0.01"
                                    max="{{ $selectedAgent['balance'] }}">
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const agentBalance = parseFloat({{ $selectedAgent['balance'] }});
            const transferAmount = document.getElementById('transferAmount');
            const remainingBalance = document.getElementById('remainingBalance');
            const amountError = document.getElementById('amountError');
            const submitBtn = document.getElementById('submitBtn');

            // Initialize remaining balance
            remainingBalance.value = agentBalance.toFixed(2);

            // Calculate remaining balance on amount change
            transferAmount.addEventListener('input', function() {
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

            // Form submission
            document.getElementById('transferForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const amount = parseFloat(transferAmount.value);
                if (amount > agentBalance) {
                    alert('Transfer amount cannot exceed available balance');
                    return;
                }

                // Here you would typically make an AJAX call or form submission
                alert(
                    `Transfer of $${amount.toFixed(2)} would be processed. Remaining balance: ${(agentBalance - amount).toFixed(2)}`
                );
            });
        });
    </script>
@endsection
