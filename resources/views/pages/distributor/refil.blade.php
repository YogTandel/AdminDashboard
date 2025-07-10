<div class="modal fade" id="refillModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="refillModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('refill.balance', ['type' => $type, 'id' => $item->id]) }}" method="POST">
    @csrf
    <div class="modal-body">
        <label>Amount</label>
        <input type="number" name="amount" class="form-control" required min="1">
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Refill</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>

    </div>
</div>
