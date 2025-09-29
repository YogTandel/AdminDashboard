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
                                    name="player" placeholder="Enter Player" value="{{ old('player') }}" required>
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



                            <label>Distributor</label>
                            <div class="input-group mb-3">
                                <select id="distributor" class="form-control @error('distributor') is-invalid @enderror"
                                    name="distributor" required>
                                    <option value="">-- Select Distributor --</option>


                                    @if ($authUser->role == 'distributor')
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
                                    @else{
                                        @foreach ($distributors as $distributor)
                                            <option value="{{ $distributor->_id }}"
                                                data-name="{{ $distributor->player }}">
                                                {{ $distributor->player }}
                                            </option>
                                        @endforeach
                                        }
                                    @endif
                                </select>
                                @error('distributor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Agent Dropdown -->
                            <label>Agent</label>
                            <div class="input-group mb-3">
                                <select id="agent_id" name="agent_id"
                                    class="form-control @error('agent_id') is-invalid @enderror" required>

                                    <option value="">-- Select Agent --</option>
                                    {{-- @foreach ($agents as $agent)
                                        <option value="{{ $agent->_id }}" data-name="{{ $agent->player }}">
                                            {{ $agent->player }}</option>
                                    @endforeach --}}
                                </select>
                                @error('agent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Hidden field for agent name -->
                            <input type="hidden" name="agent" id="agent_name">

                            <label>Status</label>
                            <div class="input-group mb-3">
                                <select class="form-control @error('status') is-invalid @enderror" name="status"
                                    required>
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                                @error('status')
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var authU = '{{ $authUser->role }}';
    var authI = '{{ $authUser->_id }}';

    /* alert(authU);
    alert(authI); */
    $('#distributor').on('change', function() {
        var distributorId = $(this).val();

        if (distributorId) {
            $.ajax({
                url: '/get-agents/' + distributorId,
                type: 'GET',
                success: function(data) {
                    $('#agent_id').empty().append('<option value="">-- Select Agent --</option>');
                    if (authU !== 'agent') {
                        $.each(data, function(key, agent) {
                            $('#agent_id').append(
                                '<option value="' + agent._id + '" data-name="' + agent
                                .player + '">' + agent.player + '</option>'
                            );
                        });
                    } else if (authU == 'agent') {
                        $.each(data, function(key, agent) {
                            if (authI == agent._id) {
                                $('#agent_id').append(
                                    '<option value="' + agent._id +
                                    '" data-name="' +
                                    agent
                                    .player + '">' + agent.player + '</option>'
                                );
                            }
                        });
                    }
                }
            });
        } else {
            $('#agent_id').empty().append('<option value="">-- Select Agent --</option>');
        }
    });

    document.getElementById('agent_id').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        document.getElementById('agent_name').value = selected.getAttribute('data-name');
    });
</script>
