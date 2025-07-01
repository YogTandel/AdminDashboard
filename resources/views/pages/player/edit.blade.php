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
                            <label>Player</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('player') is-invalid @enderror"
                                    name="player" value="{{ old('player', $player->player) }}" required>
                                @error('player')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- PASSWORD -->
                            <label>Password</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="Leave blank to keep current">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <input type="hidden" name="role" value="player">

                            <!-- BALANCE -->
                            <label>Balance</label>
                            <div class="input-group mb-3">
                                <input type="number" step="0.01" class="form-control @error('balance') is-invalid @enderror"
                                    name="balance" value="{{ old('balance', (float) $player->balance) }}" required>
                                @error('balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- DISTRIBUTOR -->
                            <label>Distributor</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('distributor') is-invalid @enderror"
                                    name="distributor" value="{{ old('distributor', $player->distributor) }}" required>
                                @error('distributor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- AGENT -->
                            <label>Agent</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('agent') is-invalid @enderror"
                                    name="agent" value="{{ old('agent', $player->agent) }}" required>
                                @error('agent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- STATUS -->
                            <label>Status</label>
                            <div class="input-group mb-3">
                                <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                    <option value="Active" {{ $player->status == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ $player->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- WINAMOUNT -->
                            <label>Win Amount</label>
                                <div class="input-group mb-3">
                                    <input type="number" step="1" class="form-control @error('winamount') is-invalid @enderror"
                                        name="winamount" value="{{ old('winamount', (int) $player->winamount) }}" required>
                                    @error('winamount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>



                            <input type="hidden" name="original_password">

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-warning btn-lg btn-rounded w-100 mt-4 mb-0">
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
