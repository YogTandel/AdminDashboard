<div class="modal fade" id="Editmodal{{ $distributor->id }}" tabindex="-1" role="dialog"
    aria-labelledby="EditmodalLabel{{ $distributor->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h3 class="font-weight-bolder text-primary text-gradient">Edit Distributor</h3>
                    </div>
                    <div class="card-body pb-3">
                        <form action="{{ route('distributor.update', $distributor->id) }}" method="POST"
                            role="form text-left">
                            @csrf
                            @method('PUT')

                            <!-- PLAYER -->
                            <label>Distributor Name</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="player"
                                    value="{{ old('player', $distributor->player) }}" required>
                            </div>

                            <!-- PASSWORD -->
                            <label>PASSWORD</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="password"
                                    placeholder="Leave blank to keep current" required>
                            </div>

                            <input type="hidden" name="role" value="distributor">



                            <!-- Endpoint -->
                            <!-- <label>Endpoint</label>
                                <div class="input-group mb-3">
                                    <input type="number" step="0.01" class="form-control" name="endpoint"
                                        value="{{ old('endpoint', (float) $distributor->endpoint) }}" required>
                                </div> -->


                            <!-- STATUS -->
                            <label>STATUS</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="status" required>
                                    <option value="Active" {{ $distributor->status == 'Active' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="Inactive" {{ $distributor->status == 'Inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                            <input type="hidden" name="original_password">

                            <div class="text-center">
                                <button type="submit"
                                    class="btn bg-gradient-warning btn-lg btn-rounded w-100 mt-4 mb-0">
                                    Update Distributor
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>