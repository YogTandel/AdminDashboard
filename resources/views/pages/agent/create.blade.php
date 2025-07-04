<div class="modal fade" id="exampleModalAddAgent" tabindex="-1" role="dialog" aria-labelledby="exampleModalAddAgent"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h3 class="font-weight-bolder text-primary text-gradient">Add New Agent</h3>
                        <p class="mb-0">Enter Agent name and password to register</p>
                    </div>
                    <div class="card-body pb-3">
                        <form action="{{ route('agent.add') }}" method="POST" role="form text-left">
                            @csrf

                            <label>AGENT NAME</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('player') is-invalid @enderror"
                                    placeholder="Enter Player" aria-label="player" name="player"
                                    aria-describedby="player" value="{{ old('player') }}" required>
                                @error('player')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <label>PASSWORD</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    placeholder="password" aria-label="password" name="password"
                                    aria-describedby="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <input type="hidden" name="role" value="agent">

                            <label>BALANCE</label>
                            <div class="input-group mb-3">
                                <input
                                    type="number"
                                    step="0.01" 
                                    class="form-control @error('balance') is-invalid @enderror"
                                    placeholder="Balance"
                                    aria-label="balance"
                                    name="balance"
                                    aria-describedby="balance"
                                    value="{{ old('balance', isset($user) ? (float) $user->balance : '') }}"required
                                >
                                @error('balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <label>Distributor</label>
                            <div class="input-group mb-3">
                                <select id="distributor_id" name="distributor_id" class="form-control @error('distributor_id') is-invalid @enderror" required>
                                    <option value="">-- Select Distributor --</option>
                                    @foreach ($distributors as $distributor)
                                        <option value="{{ $distributor->_id }}" data-name="{{ $distributor->player }}">
                                            {{ $distributor->player }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('distributor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Hidden input for distributor name --}}
                            <input type="hidden" name="distributor" id="distributor" value="{{ old('distributor') }}">
                            @error('distributor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror



                            <label>AGENT</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('agent') is-invalid @enderror"
                                    placeholder="Agent" aria-label="agent" name="agent" aria-describedby="agent"
                                    value="{{ old('agent') }}" required>
                                @error('agent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <label>ENDPOINT</label>
                                <div class="input-group mb-3">
                                    <input type="number" step="0.01" class="form-control @error('endpoint') is-invalid @enderror"
                                        placeholder="Endpoint" aria-label="endpoint" name="endpoint" aria-describedby="endpoint"
                                        value="{{ old('endpoint') }}" required>
                                    @error('endpoint')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                            <label>STATUS</label>
                            <div class="input-group mb-3">
                                <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <input type="hidden" name="original_password" id="original_password">

                            <div class="text-center">
                                <button type="submit"
                                    class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Add
                                    Agent</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('distributor_id').addEventListener('change', function () {
        const name = this.options[this.selectedIndex].getAttribute('data-name');
        document.getElementById('distributor').value = name ?? '';
    });
</script>