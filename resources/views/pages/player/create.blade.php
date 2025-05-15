<div class="modal fade" id="exampleModalAddAgent" tabindex="-1" role="dialog" aria-labelledby="exampleModalAddAgent"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h3 class="font-weight-bolder text-primary text-gradient">Add New player</h3>
                        <p class="mb-0">Enter player name and password to register</p>
                    </div>
                    <div class="card-body pb-3">
                    <form action="{{ route('player.add') }}" method="POST">
                            @csrf

                            <label>Player Name</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="player" placeholder="Player Name" required>
                            </div>

                            <label>Password</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="password" placeholder="Password" required>
                            </div>

                            <label>Role</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="role" value="player" placeholder="Role" required>
                            </div>

                            <label>Balance</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="balance" placeholder="Balance" required>
                            </div>

                            <label>Status</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="status" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                            <label>Endpoint</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="endpoint" placeholder="Endpoint" required>
                            </div>

                            <input type="hidden" name="distributor" value="amish"> 
                            <input type="hidden" name="agent" value="zee">             
                            <input type="hidden" name="winamount" value="500">                     


                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-primary btn-lg w-100 mt-4 mb-0">Save Player</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
