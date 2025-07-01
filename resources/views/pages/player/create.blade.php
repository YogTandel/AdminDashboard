<div class="modal fade" id="exampleModalAddplayer" tabindex="-1" role="dialog" aria-labelledby="exampleModalAddplayer"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h3 class="font-weight-bolder text-primary text-gradient">Add New Player</h3>
                        <p class="mb-0">Enter player name and password to register</p>
                    </div>
                    <div class="card-body pb-3">
                        <form action="{{ route('player.add') }}" method="POST">
                            @csrf

                            <label>Player</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('player') is-invalid @enderror"
                                    name="player" placeholder="Player" value="{{ old('player') }}" required>
                                @error('player')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <label>Password</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="Password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <input type="hidden" name="role" value="player">

                            <label>Balance</label>
                            <div class="input-group mb-3">
                                <input type="number" step="0.01" class="form-control @error('balance') is-invalid @enderror"
                                    name="balance" placeholder="Balance" value="{{ old('balance') }}" required>
                                @error('balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- <label>Distributor</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('distributor') is-invalid @enderror"
                                    name="distributor" placeholder="Distributor" value="{{ old('distributor') }}" required>
                                @error('distributor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> -->

                           <label>Distributor</label>
                            <div class="input-group mb-3">
                                <select class="form-control @error('distributor') is-invalid @enderror" name="distributor" required>
                                    <option value="">Select Distributor</option>
                                    @foreach ($distributors as $distributor)
                                        <option value="{{ $distributor->id }}" {{ old('distributor') == $distributor->id ? 'selected' : '' }}>
                                            {{ $distributor->player }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('distributor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <label>Agent</label>
                            <div class="input-group mb-3">
                                <select name="agent" class="form-control @error('agent') is-invalid @enderror" required>
                                    <option value="">Select Agent</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}" {{ old('agent') == $agent->id ? 'selected' : '' }}>
                                            {{ $agent->player }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('agent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <label>Login Status</label>
                                <div class="input-group mb-3">
                                    <select class="form-control @error('login_status') is-invalid @enderror" name="login_status" required>
                                        <option value="True" {{ old('login_status', 'False') === 'True' ? 'selected' : '' }}>True</option>
                                        <option value="False" {{ old('login_status', 'False') === 'False' ? 'selected' : '' }}>False</option>
                                    </select>
                                    @error('login_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            <label>Status</label>
                            <div class="input-group mb-3">
                                <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <label>Winamount</label>
                                <div class="input-group mb-3">
                                    <input type="number" step="1" class="form-control @error('winamount') is-invalid @enderror"
                                        name="winamount" placeholder="Winamount" value="{{ old('winamount') }}" required>
                                    @error('winamount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                            {{-- Hidden default gameHistory to prevent DB issues --}}
                            <input type="hidden" name="gameHistory[]" value="">

                            <input type="hidden" name="original_password" id="original_password">

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-primary btn-lg w-100 mt-4 mb-0">
                                    Save Player
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
