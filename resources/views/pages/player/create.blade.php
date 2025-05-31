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

                            <label>Player</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="player" placeholder="Player" required>
                            </div>

                            <label>Password</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="password" placeholder="Password"
                                    required>
                            </div>

                            <input type="hidden" name="role" value="player">

                            <label>Balance</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="balance" placeholder="Balance"
                                    required>
                            </div>

                            <label>Distributor</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('distributor') is-invalid @enderror"
                                    placeholder="Distributor" aria-label="distributor" name="distributor"
                                    aria-describedby="distributor" value="{{ old('distributor') }}">
                                @error('distributor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label>Login Status</label>
                                <div class="input-group mb-3">
                                    <select class="form-control" name="login_status" required>
                                        <option value="True">True</option>
                                        <option value="False">False</option>
                                    </select>
                                </div>


                            <label>Agent</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('agent') is-invalid @enderror"
                                    placeholder="Agent" aria-label="agent" name="agent" aria-describedby="agent"
                                    value="{{ old('agent') }}">
                                @error('agent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <label>Status</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="status" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                            <label>Winamount</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="winamount" placeholder="Winamount"
                                    required>
                            </div>

                            <input type="hidden" name="original_password" id="original_password">

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-primary btn-lg w-100 mt-4 mb-0">Save
                                    Player</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
