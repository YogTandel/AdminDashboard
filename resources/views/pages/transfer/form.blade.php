@extends('layouts.layout')

@section('page-name', 'Transfer')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">Transfer Funds</h6>
                        <p class="text-sm mb-0">
                            @php
                                $user = auth()->user();
                                $recipientName = 'N/A';
                                $canTransfer = false;
                                $recipientId = null;
                                $recipientIsAdmin = false;

                                if ($user->role === 'player') {
                                    $recipient = $user->agent;
                                    if ($recipient && $recipient->status === 'Active') {
                                        $canTransfer = true;
                                        $recipientId = $recipient->id;
                                        $recipientName = $recipient->player ?? 'N/A';
                                        echo "Transferring to agent: {$recipientName}";
                                    }
                                } elseif ($user->role === 'agent') {
                                    $recipient = $user->distributor;
                                    if ($recipient && $recipient->status === 'Active') {
                                        $canTransfer = true;
                                        $recipientId = $recipient->id;
                                        $recipientName = $recipient->player ?? 'N/A';
                                        echo "Transferring to distributor: {$recipientName}";
                                    } else {
                                        echo "Transferring to distributor: N/A";
                                    }
                                } elseif ($user->role === 'distributor') {
                                    $recipient = \App\Models\Admin::where('status', 'Active')->first();
                                    if ($recipient) {
                                        $canTransfer = true;
                                        $recipientId = $recipient->id;
                                        $recipientIsAdmin = true;
                                        $recipientName = $recipient->name ?? ($recipient->username ?? 'N/A');
                                        echo "Transferring to admin: {$recipientName}";
                                    }
                                }
                            @endphp
                        </p>
                    </div>
                    <div class="card-body pt-4">
                        @php
                            $balance = $user->role === 'player' ? $user->balance : $user->endpoint;
                        @endphp

                        @if (!$canTransfer)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                @if ($user->role === 'player')
                                    No valid agent assigned or agent is inactive
                                @elseif($user->role === 'agent')
                                    @if (!$user->distributor_id)
                                        No distributor assigned to your account
                                    @elseif(!$recipient)
                                        Your assigned distributor not found
                                    @else
                                        Your assigned distributor is inactive
                                    @endif
                                @elseif($user->role === 'distributor')
                                    No active admin available
                                @endif
                            </div>
                        @else
                            <form id="transferForm" method="POST" action="{{ route('transfer.execute') }}">
                                @csrf
                                <input type="hidden" name="transfer_by" value="{{ $user->id }}">
                                <input type="hidden" name="transfer_to" value="{{ $recipientId }}">
                                @if ($recipientIsAdmin)
                                    <input type="hidden" name="is_admin_recipient" value="1">
                                @endif
                                <input type="hidden" name="type" value="subtract">

                                <div class="mb-4">
                                    <label class="form-label">Your Balance</label>
                                    <input type="text" class="form-control" id="currentBalance"
                                        value="{{ number_format($balance, 2) }}" readonly>
                                </div>

                                <div class="mb-4">
                                    <label for="transferAmount" class="form-label">Amount to Transfer</label>
                                    <input type="number" class="form-control" name="amount" id="transferAmount"
                                        min="0.01" step="0.01" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Remaining Balance</label>
                                    <input type="text" class="form-control" id="remainingBalance"
                                        value="{{ number_format($balance, 2) }}" readonly>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn bg-gradient-primary w-100" id="submitBtn">
                                        <i class="fas fa-exchange-alt me-2"></i> Transfer Funds
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer />

    @if ($canTransfer)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const transferAmount = document.getElementById('transferAmount');
                const currentBalanceField = document.getElementById('currentBalance');
                const remainingBalance = document.getElementById('remainingBalance');
                const submitBtn = document.getElementById('submitBtn');
                const form = document.getElementById('transferForm');
                const currentBalanceValue = parseFloat(currentBalanceField.value.replace(/,/g, ''));

                function updateBalanceDisplay() {
                    const amount = parseFloat(transferAmount.value) || 0;
                    const remaining = currentBalanceValue - amount;
                    remainingBalance.value = remaining.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

                    if (amount > currentBalanceValue || amount <= 0) {
                        submitBtn.disabled = true;
                    } else {
                        submitBtn.disabled = false;
                    }
                }

                transferAmount.addEventListener('input', updateBalanceDisplay);

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

                    // Remove any existing alerts
                    const existingAlert = document.querySelector('.transfer-alert');
                    if (existingAlert) {
                        existingAlert.remove();
                    }

                    fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: new FormData(form)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Create success message element
                                const alertDiv = document.createElement('div');
                                alertDiv.className = 'alert alert-success alert-dismissible fade show transfer-alert mt-3';
                                alertDiv.setAttribute('role', 'alert');
                                alertDiv.innerHTML = `
                                    <i class="fas fa-check-circle me-2"></i> ${data.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                `;
                                
                                // Insert the alert after the form
                                form.insertAdjacentElement('afterend', alertDiv);
                                
                                // Reset form
                                transferAmount.value = '';
                                remainingBalance.value = currentBalanceField.value;
                                
                                // Auto-dismiss after 5 seconds
                                setTimeout(() => {
                                    const bsAlert = new bootstrap.Alert(alertDiv);
                                    bsAlert.close();
                                }, 5000);

                            } else {
                                // Show error message
                                const errorDiv = document.createElement('div');
                                errorDiv.className = 'alert alert-danger alert-dismissible fade show transfer-alert mt-3';
                                errorDiv.setAttribute('role', 'alert');
                                errorDiv.innerHTML = `
                                    <i class="fas fa-exclamation-circle me-2"></i> ${data.message || 'Transfer failed'}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                `;
                                form.insertAdjacentElement('afterend', errorDiv);
                            }
                        })
                        .catch(error => {
                            // Show error message
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'alert alert-danger alert-dismissible fade show transfer-alert mt-3';
                            errorDiv.setAttribute('role', 'alert');
                            errorDiv.innerHTML = `
                                <i class="fas fa-exclamation-circle me-2"></i> An error occurred. Please try again.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            `;
                            form.insertAdjacentElement('afterend', errorDiv);
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="fas fa-exchange-alt me-2"></i> Transfer Funds';
                        });
                });
            });
        </script>
    @endif
@endsection