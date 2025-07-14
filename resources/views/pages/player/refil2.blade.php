@php
    $agent = Auth::user(); // logged-in agent
    $agentBalance = number_format($agent->endpoint ?? 0, 2);
@endphp

<div class="modal fade" id="transferModal{{ $user->id }}" tabindex="-1" role="dialog"
    aria-labelledby="transferModalLabel{{ $user->id }}" aria-hidden="true">
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
                        <form id="transferForm{{ $user->id }}" method="POST"
                            action="{{ route('agent.transfer.to.player') }}">
                            @csrf

                            <input type="hidden" name="transfer_to" value="{{ $user->id }}">

                            <label>Agent Endpoint</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" value="{{ $agentBalance }}" readonly>
                            </div>

                            <label>Amount to Transfer</label>
                            <div class="input-group mb-3">
                                <input type="number" name="amount" step="0.01" min="0.01" class="form-control" required>
                            </div>

                            <div class="alert mt-2 d-none" id="transferAlert{{ $user->id }}"></div>

                            <form id="transferForm{{ $user->id }}" method="POST"
                                action="{{ route('agent.transfer.to.player') }}">
                                @csrf
                                <button type="submit" id="submitBtn{{ $user->id }}"
                                    class="btn bg-gradient-success btn-lg btn-rounded w-100 mt-4 mb-0">
                                    <i class="fas fa-exchange-alt me-1"></i> Transfer
                                </button>
                            </form>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>