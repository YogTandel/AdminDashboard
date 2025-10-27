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
                                    // Get the distributor linked to this agent (from distributor_id)
                                    if (isset($user->distributor_id)) {
                                        $recipient = \App\Models\User::where('_id', $user->distributor_id)
                                            ->where('status', 'Active')
                                            ->first();

                                        if ($recipient) {
                                            $canTransfer = true;
                                            $recipientId = $recipient->_id; // Use _id since it's MongoDB
                                            $recipientName = $recipient->player ?? 'N/A';
                                            echo "Transferring to distributor: {$recipientName}";
                                        } else {
                                            echo 'Transferring to distributor: N/A';
                                        }
                                    } else {
                                        echo 'No distributor assigned to this agent.';
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
                            $hasZeroBalance = $balance <= 0;
                        @endphp

                        @if (!$canTransfer)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                @if ($user->role === 'player')
                                    No valid agent assigned or agent is inactive
                                @elseif($user->role === 'agent')
                                    No distributor assigned or inactive
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
                                    @if ($hasZeroBalance)
                                        <div class="alert alert-warning mt-2 mb-0 p-2">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            You have zero balance. Transfer not allowed.
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label for="transferAmount" class="form-label">Amount to Transfer</label>
                                    <input type="number" class="form-control" name="amount" id="transferAmount"
                                        min="0.01" step="0.01" required {{ $hasZeroBalance ? 'disabled' : '' }}>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Remaining Balance</label>
                                    <input type="text" class="form-control" id="remainingBalance"
                                        value="{{ number_format($balance, 2) }}" readonly>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn bg-gradient-primary w-100" id="submitBtn"
                                        {{ $hasZeroBalance ? 'disabled' : '' }}>
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
                    submitBtn.disabled = amount <= 0 || amount > currentBalanceValue;
                }

                if (currentBalanceValue <= 0) {
                    transferAmount.disabled = true;
                    submitBtn.disabled = true;
                }

                transferAmount.addEventListener('input', updateBalanceDisplay);

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

                    const existingAlert = document.querySelector('.transfer-alert');
                    if (existingAlert) existingAlert.remove();

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
                            const alertDiv = document.createElement('div');
                            alertDiv.className =
                                `alert alert-${data.success ? 'success' : 'danger'} alert-dismissible fade show transfer-alert mt-3`;
                            alertDiv.setAttribute('role', 'alert');
                            alertDiv.innerHTML = `
                                <i class="fas ${data.success ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i> ${data.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            `;
                            form.insertAdjacentElement('afterend', alertDiv);

                            if (data.success) {
                                transferAmount.value = '';
                                remainingBalance.value = currentBalanceField.value;

                                setTimeout(() => {
                                    const bsAlert = new bootstrap.Alert(alertDiv);
                                    bsAlert.close();
                                }, 5000);
                            }
                        })
                        .catch(error => {
                            const errorDiv = document.createElement('div');
                            errorDiv.className =
                                'alert alert-danger alert-dismissible fade show transfer-alert mt-3';
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
