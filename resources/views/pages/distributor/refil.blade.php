<div class="modal fade" id="refillModal{{ $distributor->id }}" tabindex="-1" role="dialog"
    aria-labelledby="refillModalLabel{{ $distributor->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h3 class="font-weight-bolder text-primary text-gradient">
                            Transfer Balance to {{ $distributor->player ?? $distributor->name }}
                        </h3>
                    </div>
                    <div class="card-body pb-3">
                        <form id="refillForm{{ $distributor->id }}" method="POST"
                            action="{{ route('admin.transfer.to.distributor') }}">
                            @csrf


                            <input type="hidden" name="transfer_to" value="{{ $distributor->id }}">

                            @php
                                $admin = Auth::guard('admin')->user();
                                $adminBalance = number_format($admin->endpoint ?? 0, 2);
                            @endphp
                            <label>Admin Balance</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" value="{{ $adminBalance }}" readonly>
                            </div>


                            <label>Amount to Transfer</label>
                            <div class="input-group mb-3">
                                <input type="number" name="amount" step="0.01" min="0.01" class="form-control"
                                    required>
                            </div>


                            <div class="alert mt-2 d-none" id="refillAlert{{ $distributor->id }}"></div>

                            <div class="text-center">
                                <button type="submit"
                                    class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0"
                                    id="submitBtn{{ $distributor->id }}">
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.open-refill-modal').forEach(el => {
            el.addEventListener('click', function() {
                document.getElementById('transferToInput').value = this.dataset.id;
                document.getElementById('refillModalTitle').textContent = "Transfer to " + this
                    .dataset.name;
            });
        });
    });
</script>
