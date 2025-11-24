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
                    <h4 class="font-weight-bolder text-primary text-gradient mb-1">Add New Agent</h4>
                    <p class="text-sm text-muted mb-0">Enter agent details to register</p>
                </div>

                <form action="{{ route('agent.add') }}" method="POST" id="addAgentForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-uppercase text-xs font-weight-bolder text-muted">Agent
                            Name</label>
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control @error('player') is-invalid @enderror"
                                   placeholder="Enter agent name" name="player"
                                   value="{{ old('player') }}" required autocomplete="off">
                            @error('player')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-uppercase text-xs font-weight-bolder text-muted">Password</label>
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Enter password" name="password" id="agent_modal_password"
                                   required autocomplete="off">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label
                            class="form-label text-uppercase text-xs font-weight-bolder text-muted">Distributor</label>
                        <div class="input-group input-group-outline">
                            <select id="distributor_id" name="distributor_id"
                                    class="form-control @error('distributor_id') is-invalid @enderror" required>
                                <option value="">-- Select Distributor --</option>
                                @if ($authUser->role === 'distributor')
                                    <option value="{{ $authUser->_id }}" data-name="{{ $authUser->player }}">
                                        {{ $authUser->player }}
                                    </option>
                                @elseif($authUser->role === 'agent')
                                    <option value="{{ $authUser->distributor_id }}"
                                            data-name="{{ $authUser->distributor }}">
                                        {{ $authUser->distributor }}
                                    </option>
                                @else
                                    @foreach ($distributors as $distributor)
                                        <option value="{{ $distributor->_id }}" data-name="{{ $distributor->player }}">
                                            {{ $distributor->player }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('distributor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-uppercase text-xs font-weight-bolder text-muted">Status</label>
                        <div class="input-group input-group-outline">
                            <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                <option value="Active" {{ old('status') === 'Active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="Inactive" {{ old('status') === 'Inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Hidden fields -->
                    <input type="hidden" name="role" value="agent">
                    <input type="hidden" name="endpoint" value="0">
                    <input type="hidden" name="distributor" id="distributor" value="{{ old('distributor') }}">
                    <input type="hidden" name="original_password" id="agent_original_password">

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
    // Set distributor name when selection changes
    document.getElementById('distributor_id')?.addEventListener('change', function () {
        const name = this.options[this.selectedIndex].getAttribute('data-name');
        document.getElementById('distributor').value = name ?? '';
    });

    // Copy password to original_password hidden field before submit
    document.getElementById('addAgentForm')?.addEventListener('submit', function () {
        document.getElementById('agent_original_password').value = document.getElementById('agent_modal_password').value;
    });
</script>
