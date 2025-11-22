<!--suppress JSUnresolvedReference -->
<div class="modal fade" id="exampleModalAddAgent" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalAddAgent" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-4 pt-0 pb-4">
                <div class="text-center mb-4">
                    <h4 class="font-weight-bolder text-primary text-gradient mb-1">Add New Distributor</h4>
                    <p class="text-sm text-muted mb-0">Enter distributor details to register</p>
                </div>

                <form action="{{ route('distributor.add') }}" method="POST" id="addDistributorForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-uppercase text-xs font-weight-bolder text-muted">Distributor
                            Name</label>
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control" placeholder="Enter name"
                                   name="player" required autocomplete="off">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-uppercase text-xs font-weight-bolder text-muted">Password</label>
                        <div class="input-group input-group-outline">
                            <input type="password" class="form-control" placeholder="Enter password"
                                   name="password" id="modal_password" required autocomplete="off">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-uppercase text-xs font-weight-bolder text-muted">Status</label>
                        <div class="input-group input-group-outline">
                            <select class="form-control" name="status" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Hidden fields -->
                    <input type="hidden" name="role" value="distributor">
                    <input type="hidden" name="endpoint" value="0">
                    <input type="hidden" name="original_password" id="original_password">

                    <div class="row mt-4">
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-secondary w-100 mb-0" data-bs-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn bg-gradient-primary w-100 mb-0">
                                <i class="fas fa-save me-2"></i>Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Copy password to original_password hidden field before submit
    document.getElementById('addDistributorForm')?.addEventListener('submit', function () {
        document.getElementById('original_password').value = document.getElementById('modal_password').value;
    });
</script>
