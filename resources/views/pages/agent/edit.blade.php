<div class="modal fade" id="editModal{{ $agent->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel{{ $agent->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h3 class="font-weight-bolder text-primary text-gradient">Edit Agent</h3>
                    </div>
                    <div class="card-body pb-3">
                        <form action="{{ route('agent.update', $agent->id) }}" method="POST" role="form text-left">
                            @csrf
                            @method('PUT')

                            <!-- Add this hidden field to preserve per_page -->
                            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

                            <!-- PLAYER -->
                            <label class="text-left d-block text-start">AGENT NAME</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="player"
                                    value="{{ old('player', $agent->player) }}" required>
                            </div>

                            <!-- PASSWORD -->
                            <label class="text-left d-block text-start">PASSWORD</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="password"
                                    placeholder="Leave blank to keep current">
                            </div>

                            <input type="hidden" name="role" value="agent">

                            <!-- DISTRIBUTOR -->
                            {{-- <label class="text-left d-block text-start">DISTRIBUTOR</label>
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
                            </div> --}}

                            <input type="hidden" name="endpoint" value="{{ $agent->endpoint }}">

                            <!-- STATUS -->
                            <label class="text-left d-block text-start">STATUS</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="status" required>
                                    <option value="Active" {{ $agent->status == 'Active' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="Inactive" {{ $agent->status == 'Inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                            <input type="hidden" name="original_password">

                            <div class="text-center">
                                <button type="submit"
                                    class="btn bg-gradient-warning btn-lg btn-rounded w-100 mt-4 mb-0">
                                    Update Agent
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
