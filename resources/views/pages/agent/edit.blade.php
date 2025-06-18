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

                            <!-- PLAYER -->
                            <label>PLAYER</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="player"
                                    value="{{ old('player', $agent->player) }}">
                            </div>

                            <!-- PASSWORD -->
                            <label>PASSWORD</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="password"
                                    placeholder="Leave blank to keep current">
                            </div>

                            <input type="hidden" name="role" value="agent">

                            <!-- BALANCE -->
                            <label>BALANCE</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="balance"
                                    value="{{ old('balance', $agent->balance) }}">
                            </div>

                            <!-- DISTRIBUTOR -->
                            <label>DISTRIBUTOR</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="distributor"
                                    value="{{ old('distributor', $agent->distributor) }}">
                            </div>

                            <!-- AGENT -->
                            <label>AGENT</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="agent"
                                    value="{{ old('agent', $agent->agent) }}">
                            </div>

                            <label>ENDPOINT</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="endpoint"
                                    value="{{ old('endpoint', $agent->endpoint) }}">
                            </div>

                            <!-- STATUS -->
                            <label>STATUS</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="status">
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
