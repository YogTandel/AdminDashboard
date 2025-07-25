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
                                    placeholder="Enter Agent" aria-label="player" name="player"
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

                            <label>Distributor</label>
                            <div class="input-group mb-3">
                                <select id="distributor_id" name="distributor_id"
                                    class="form-control @error('distributor_id') is-invalid @enderror" required>
                                    <option value="">-- Select Distributor --</option>
                                    @if ($authUser->role == '')
                                        @foreach ($distributors as $distributor)
                                            <option value="{{ $distributor->_id }}"
                                                data-name="{{ $distributor->player }}">
                                                {{ $distributor->player }}
                                            </option>
                                        @endforeach
                                    @elseif($authUser->role == 'distributor')
                                        {
                                        <option value="{{ $authUser->_id }}" data-name="{{ $authUser->player }}">
                                            {{ $authUser->player }}
                                        </option>
                                        }
                                    @elseif($authUser->role == 'agent')
                                        {
                                        <option value="{{ $authUser->distributor_id }}"
                                            data-name="{{ $authUser->distributor }}">
                                            {{ $authUser->distributor }}
                                        </option>
                                        }
                                    @endif
                                </select>
                                @error('distributor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <input type="hidden" name="distributor" id="distributor" value="{{ old('distributor') }}">
                            @error('distributor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <input type="hidden" name="endpoint" value="0">

                            <label>STATUS</label>
                            <div class="input-group mb-3">
                                <select class="form-control @error('status') is-invalid @enderror" name="status"
                                    required>
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
    document.getElementById('distributor_id').addEventListener('change', function() {
        const name = this.options[this.selectedIndex].getAttribute('data-name');
        document.getElementById('distributor').value = name ?? '';
    });
</script>
