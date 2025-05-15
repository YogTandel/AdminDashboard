<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-body p-0">
            <div class="card card-plain">
                <div class="card-header pb-0 text-left">
                    <h3 class="font-weight-bolder text-primary text-gradient">Add New Distributor</h3>
                    <p class="mb-0">Enter Distributor name and password to register</p>
                </div>
                <div class="card-body pb-3">
                    <form action="{{ route('distributor.add') }}" role="form text-left" method="POST">
                        @csrf
                        <label>Player</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Player" aria-label="player"
                                name="player" aria-describedby="player-addon">
                        </div>

                        <label>Password</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="password" aria-label="password"
                                name="password" aria-describedby="password-addon">
                        </div>

                        <input type="hidden" name="role" value="distributor">

                        <label>Balance</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Balance" aria-label="balance"
                                name="balance" aria-describedby="balance-addon">
                        </div>

                        <label>Endpoint</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" placeholder="endpoint" aria-label="endpoint"
                                name="endpoint" aria-describedby="endpoint-addon">
                        </div>

                        <label>STATUS</label>
                        <div class="input-group mb-3">
                            <select class="form-control" name="status">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                        <input type="hidden" name="original_password" id="original_password">

                        <div class="text-center">
                            <button type="submit"
                                class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Save
                                Distributor
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
