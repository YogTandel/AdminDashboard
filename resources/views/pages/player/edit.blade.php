<div class="modal fade" id="editModal{{ $player->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel{{ $player->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h3 class="font-weight-bolder text-primary text-gradient">Edit Player</h3>
                    </div>
                    <div class="card-body pb-3">
                        <form action="{{ route('player.update', $player->id) }}" method="POST" role="form text-left">
                            @csrf
                            @method('PUT')

                            <!-- PLAYER -->
                            <label>PLAYER</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="player"
                                    value="{{ old('player', $player->player) }}">
                            </div>

                            <!-- PASSWORD -->
                            <label>PASSWORD</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="password"
                                    placeholder="Leave blank to keep current">
                            </div>

                            <input type="hidden" name="role" value="player">

                            <!-- BALANCE -->
                            <label>BALANCE</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="balance"
                                    value="{{ old('balance', $player->balance) }}">
                            </div>

                            <!-- DISTRIBUTOR -->
                            <label>DISTRIBUTOR</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="distributor"
                                    value="{{ old('distributor', $player->distributor) }}">
                            </div>

                            <!-- AGENT -->
                            <label>AGENT</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="agent"
                                    value="{{ old('agent', $player->agent) }}">
                            </div>

                            <!-- STATUS -->
                            <label>STATUS</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="status">
                                    <option value="Active" {{ $player->status == 'Active' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="Inactive" {{ $player->status == 'Inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                            <!-- Winamount -->
                            <label>WINAMOUNT</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="winamount"
                                    value="{{ old('winamount', $player->winamount) }}">
                            </div>

                            <input type="hidden" name="original_password">

                            <div class="text-center">
                                <button type="submit"
                                    class="btn bg-gradient-warning btn-lg btn-rounded w-100 mt-4 mb-0">
                                    Update Player
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
