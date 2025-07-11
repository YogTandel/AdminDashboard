@php
    $distributor = Auth::user();
    $distributorBalance = number_format($distributor->endpoint ?? 0, 2);
@endphp

<div class="modal fade" id="refillModal1{{ $user->id }}" tabindex="-1" role="dialog"
    aria-labelledby="refillModalLabel1{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h3 class="font-weight-bolder text-primary text-gradient">
                            Transfer Balance to {{ $user->player ?? $user->name }}
                        </h3>
                    </div>
                    <div class="card-body pb-3">
                        <form id="refillForm{{ $user->id }}" method="POST"
                            action="{{ route('user.transfer.to.agent') }}">
                            @csrf

                            <input type="hidden" name="transfer_to" value="{{ $user->id }}">

                            <label>Distributor Balance</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" value="{{ $distributorBalance }}" readonly>
                            </div>

                            <label>Amount to Transfer</label>
                            <div class="input-group mb-3">
                                <input type="number" name="amount" step="0.01" min="0.01"
                                    class="form-control" required>
                            </div>

                            <div class="alert mt-2 d-none" id="refillAlert{{ $user->id }}"></div>

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-success btn-lg btn-rounded w-100 mt-4 mb-0"
                                    id="submitBtn{{ $user->id }}">
                                    <i class="fas fa-exchange-alt me-1"></i> Transfer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
