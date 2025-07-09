<!-- Refill Modal -->
<div class="modal fade" id="refillModal{{ $distributor->id }}" tabindex="-1" aria-labelledby="refillModalLabel{{ $distributor->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('distributor.refillBalance') }}">
            @csrf
            <input type="hidden" name="distributor_id" value="{{ $distributor->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="refillModalLabel{{ $distributor->id }}">
                        Refill Balance – {{ $distributor->player }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" name="amount" class="form-control" required min="1">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Refill</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
