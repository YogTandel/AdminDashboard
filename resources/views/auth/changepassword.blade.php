@extends('auth.layout')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg">
                    <div class="card-header text-center pb-0">
                        <h4 class="font-weight-bolder">Change Password</h4>
                        <p class="mb-0">Update your account password here.</p>
                    </div>
                    <div class="card-body px-4">
                        <form action="" method="POST">
                            @csrf

                            <div class="form-group mb-4 position-relative">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password"
                                    required>
                                <i class="fas fa-eye toggle-password-icon" data-target="current_password"></i>
                                @error('current_password')
                                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-4 position-relative">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                                <i class="fas fa-eye toggle-password-icon" data-target="new_password"></i>
                                @error('new_password')
                                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-4 position-relative">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="new_password_confirmation"
                                    name="new_password_confirmation" required>
                                <i class="fas fa-eye toggle-password-icon" data-target="new_password_confirmation"></i>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-primary w-100 my-3">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Improved input style */
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

        .card {
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
@endsection
