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
                            @php
                                $recipientName = '';
                                if (auth()->user()->role === 'player') {
                                    $recipient = \App\Models\User::find(auth()->user()->agent_id);
                                    $recipientName = $recipient->player ?? 'N/A';
                                    echo "Transferring to agent: {$recipientName}";
                                } elseif (auth()->user()->role === 'agent') {
                                    $recipient = \App\Models\User::find(auth()->user()->distributor_id);
                                    $recipientName = $recipient->player ?? 'N/A';
                                    echo "Transferring to distributor: {$recipientName}";
                                } elseif (auth()->user()->role === 'distributor') {
                                    $recipient = \App\Models\User::where('role', 'admin')
                                        ->where('status', 'Active')
                                        ->first();
                                    $recipientName = $recipient->player ?? 'N/A';
                                    echo "Transferring to admin: {$recipientName}";
                                }
                            @endphp
                        </p>
                    </div>
                    <div class="card-body pt-4">
                        @php
                            $balance = auth()->user()->role === 'player' ? auth()->user()->balance : auth()->user()->endpoint;
                            $canTransfer = false;
                            $recipientId = null;

                            if (auth()->user()->role === 'player') {
                                $recipient = \App\Models\User::find(auth()->user()->agent_id);
                                if ($recipient && in_array($recipient->role, ['agent', 'distributor', 'admin']) && $recipient->status === 'Active') {
                                    $canTransfer = true;
                                    $recipientId = $recipient->id;
                                }
                            } elseif (auth()->user()->role === 'agent') {
                                $recipient = \App\Models\User::find(auth()->user()->distributor_id);
                                if ($recipient && in_array($recipient->role, ['distributor', 'admin']) && $recipient->status === 'Active') {
                                    $canTransfer = true;
                                    $recipientId = $recipient->id;
                                }
                            } elseif (auth()->user()->role === 'distributor') {
                                $recipient = \App\Models\User::where('role', 'admin')
                                    ->where('status', 'Active')
                                    ->first();
                                if ($recipient) {
                                    $canTransfer = true;
                                    $recipientId = $recipient->id;
                                }
                            }
                        @endphp

                        @if (!$canTransfer)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                @if (auth()->user()->role === 'player')
                                    No valid agent/distributor/admin assigned
                                @elseif(auth()->user()->role === 'agent')
                                    No valid distributor/admin assigned
                                @elseif(auth()->user()->role === 'distributor')
                                    No active admin available
                                @endif
                            </div>
                        @else
                            <form id="transferForm" method="POST" action="{{ route('transfer.execute') }}">
                                @csrf
                                <input type="hidden" name="transfer_by" value="{{ auth()->id() }}">
                                <input type="hidden" name="transfer_to" value="{{ $recipientId }}">
                                <input type="hidden" name="type" value="subtract">

                                <div class="mb-4">
                                    <label class="form-label">Your Balance</label>
                                    <input type="text" class="form-control" id="currentBalance"
                                        value="{{ number_format($balance, 2) }}" readonly>
                                </div>

                                <div class="mb-4">
                                    <label for="transferAmount" class="form-label">Amount to Transfer</label>
                                    <input type="number" class="form-control" name="amount" id="transferAmount"
                                        min="100" step="100" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Remaining Balance</label>
                                    <input type="text" class="form-control" id="remainingBalance"
                                        value="{{ number_format($balance, 2) }}" readonly>
                                </div>

                                <div class="text-danger mb-4" id="amountError" style="display:none">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <span id="errorText"></span>
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
                let currentBalanceValue = parseFloat("{{ $balance }}");
                const transferAmount = document.getElementById('transferAmount');
                const remainingBalance = document.getElementById('remainingBalance');
                const amountError = document.getElementById('amountError');
                const submitBtn = document.getElementById('submitBtn');
                const errorText = document.getElementById('errorText');

                function updateBalanceDisplay() {
                    const amount = parseFloat(transferAmount.value) || 0;
                    const remaining = currentBalanceValue - amount;

                    if (amount > currentBalanceValue) {
                        amountError.style.display = 'block';
                        errorText.textContent = 'Amount exceeds available balance';
                        submitBtn.disabled = true;
                        transferAmount.classList.add('is-invalid');
                    } else if (amount < 100) {
                        amountError.style.display = 'block';
                        errorText.textContent = 'Minimum transfer amount is ₹100';
                        submitBtn.disabled = true;
                        transferAmount.classList.add('is-invalid');
                    } else {
                        amountError.style.display = 'none';
                        submitBtn.disabled = false;
                        transferAmount.classList.remove('is-invalid');
                    }

                    remainingBalance.value = remaining.toFixed(2);
                }

                if (currentBalanceValue <= 0) {
                    submitBtn.disabled = true;
                    amountError.style.display = 'block';
                    errorText.textContent = 'You have zero balance. Transfer not allowed.';
                    transferAmount.disabled = true;
                }

                transferAmount.addEventListener('input', updateBalanceDisplay);

                document.getElementById('transferForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Processing...';

                    fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: new FormData(this)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            throw new Error(data.message || 'Transfer failed');
                        }
                    })
                    .catch(error => {
                        amountError.style.display = 'block';
                        errorText.textContent = error.message;
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