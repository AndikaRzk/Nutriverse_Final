@extends('layouts.layout')

@section('content')
    <div class="container my-5 py-5"> {{-- Increased vertical padding for more breathing room --}}
        <div class="row justify-content-center">
            <div class="col-md-5"> {{-- Slightly wider column for a more elegant layout --}}
                <div class="card login-card animate__animated animate__fadeInUp" style="
                    border-radius: 1.5rem; /* Softer, more modern rounded corners */
                    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15); /* Deeper, more elegant shadow */
                    overflow: hidden; /* Ensures header border-radius is respected */
                    border: none; /* Remove default card border */
                ">
                    <div class="card-header text-center login-header" style="
                        background-color: var(--primary-color);
                        color: white;
                        padding: 2.5rem 1.5rem; /* More generous padding for header */
                        font-size: 2rem; /* Larger, more impactful header text */
                        font-weight: 700; /* Bolder header font weight */
                        letter-spacing: 0.04em;
                        border-bottom: none; /* Remove default card-header border */
                    ">
                        <i class="ri-login-box-line me-3 align-middle" style="font-size: 2.5rem;"></i>Welcome Back!
                    </div>
                    <div class="card-body p-5"> {{-- Increased padding inside card body for spaciousness --}}
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-floating mb-4 login-input-group"> {{-- Added custom class for group --}}
                                <input type="email" class="form-control login-input @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}"
                                       placeholder="Email Address" required autofocus style="border-radius: 0.8rem;">
                                <label for="email">
                                    <i class="ri-mail-line me-2"></i>Email Address
                                </label>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-floating mb-5 login-input-group password-field"> {{-- Increased bottom margin, added custom class --}}
                                <input type="password" class="form-control login-input @error('password') is-invalid @enderror"
                                       id="password" name="password" placeholder="Password" required style="border-radius: 0.8rem;">
                                <label for="password">
                                    <i class="ri-lock-line me-2"></i>Password
                                </label>
                                <button type="button" class="btn password-toggle" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted-color); font-size: 1.2rem;">
                                    <i class="ri-eye-line"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary py-3 main-button animate__animated animate__pulse animate__infinite" style="
                                    border-radius: 0.8rem;
                                    font-weight: 700;
                                    font-size: 1.25rem;
                                    letter-spacing: 0.03em;
                                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                                    background-color: var(--primary-color);
                                    border: none;
                                    transition: all 0.3s ease;
                                ">
                                    <span>Sign In</span>
                                    <i class="ri-arrow-right-line ms-2"></i>
                                </button>
                            </div>

                            <div class="d-grid mb-5"> {{-- Added more space below --}}
                                <a href="{{ route('filament.admin.auth.login') }}" class="btn btn-outline-secondary py-3 admin-button" style="
                                    border-radius: 0.8rem;
                                    font-weight: 600;
                                    font-size: 1.1rem;
                                    letter-spacing: 0.02em;
                                    border-color: var(--secondary-color);
                                    color: var(--secondary-color);
                                    transition: all 0.3s ease;
                                ">
                                    <i class="ri-shield-line me-2"></i>
                                    <span>Login as Admin</span>
                                </a>
                            </div>
                        </form>

                        <div class="text-center mt-4"> {{-- Added more space above --}}
                            <small class="text-muted">Don't have an account? <a href="{{ route('show.register') }}" class="text-decoration-none" style="color: var(--primary-color); font-weight: 600;">Register here</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-color: #28a745; /* A vibrant green for primary actions */
            --primary-color-hover: #218838; /* Darker green for hover */
            --secondary-color: #6c757d; /* Muted grey for secondary actions/borders */
            --input-border-color: #dee2e6; /* Light grey for input borders */
            --input-focus-shadow: rgba(40, 167, 69, 0.25); /* Green shadow for focus */
            --text-muted-color: #6c757d;
        }

        body {
            background-color: #f8f9fa; /* A very light background for contrast */
        }

        .login-card {
            background-color: white; /* Ensure card background is white */
            border: none; /* Remove default border */
        }

        .login-header {
            background-color: var(--primary-color);
            color: white;
            border-top-left-radius: 1.5rem; /* Match card radius */
            border-top-right-radius: 1.5rem; /* Match card radius */
        }

        .form-floating > .form-control:focus,
        .form-floating > .form-select:focus {
            box-shadow: 0 0 0 0.25rem var(--input-focus-shadow) !important;
            border-color: var(--primary-color) !important;
        }

        .form-floating > .form-control,
        .form-floating > .form-select {
            border: 1px solid var(--input-border-color);
            border-radius: 0.8rem;
            transition: all 0.3s ease;
            height: calc(3.5rem + 2px); /* Adjust height for form-floating labels */
            line-height: 1.25;
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }

        .form-floating > label {
            padding-top: 0.8rem;
            padding-bottom: 0.8rem;
            font-size: 1rem;
            color: var(--text-muted-color);
            transition: all 0.3s ease;
        }

        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label,
        .form-floating > .form-select ~ label {
            opacity: .7;
            transform: scale(.85) translateY(-.5rem) translateX(0.15rem);
        }

        .main-button {
            background-color: var(--primary-color) !important;
        }

        .main-button:hover {
            background-color: var(--primary-color-hover) !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2) !important;
            transform: translateY(-3px) scale(1.01);
        }

        .admin-button:hover {
            background-color: var(--secondary-color);
            color: white !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .password-field {
            position: relative;
        }

        .password-toggle {
            cursor: pointer;
            z-index: 100;
        }

        /* Animate.css (ensure it's linked in your layout) */
        .animate__animated.animate__fadeInUp {
            animation-duration: 0.7s;
        }
        .animate__animated.animate__pulse.animate__infinite {
            animation-duration: 2s;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordToggle = document.querySelector('.password-toggle');
            const passwordInput = document.getElementById('password');

            if (passwordToggle && passwordInput) {
                passwordToggle.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle the icon
                    this.querySelector('i').classList.toggle('ri-eye-line');
                    this.querySelector('i').classList.toggle('ri-eye-off-line');
                });
            }
        });
    </script>
@endsection