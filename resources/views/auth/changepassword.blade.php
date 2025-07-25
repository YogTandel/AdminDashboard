<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="alert alert-success text-white" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error Message --}}
                @if ($errors->any())
                    <div class="alert alert-danger text-white" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('change.password') }}" method="POST">
                    @csrf

                    <div class="form-group mb-4 position-relative">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password"
                            required>
                        <i class="fas fa-eye toggle-password-icon mt-3" data-target="current_password"></i>
                    </div>

                    <div class="form-group mb-4 position-relative">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <i class="fas fa-eye toggle-password-icon mt-3" data-target="new_password"></i>
                    </div>

                    <div class="form-group mb-4 position-relative">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="new_password_confirmation"
                            name="new_password_confirmation" required>
                        <i class="fas fa-eye toggle-password-icon mt-3" data-target="new_password_confirmation"></i>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-primary w-100 my-3">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control {
        padding-right: 2.5rem;
    }

    .toggle-password-icon {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
    }

    .toggle-password-icon:hover {
        color: #344767;
    }

    .modal-content {
        border-radius: 1rem;
    }

    .btn.bg-gradient-primary {
        background: linear-gradient(310deg, #2152ff, #21d4fd);
    }
</style>

<script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password-icon').forEach(function(icon) {
        icon.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });
</script>
