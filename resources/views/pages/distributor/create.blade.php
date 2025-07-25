<div class="modal fade" id="exampleModalAddAgent" tabindex="-1" role="dialog" aria-labelledby="exampleModalAddAgent"
    aria-hidden="true">
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
                            <label>Distributor Name</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Enter Distributor" aria-label="player"
                                    name="player" aria-describedby="player-addon" required>
                            </div>

                            <label>Password</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="password" aria-label="password"
                                    name="password" aria-describedby="password-addon" required>
                            </div>

                            <input type="hidden" name="role" value="distributor">
                            
                            <input type="hidden" name="endpoint" value="0">

                            <label>STATUS</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="status" required>
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
</div>