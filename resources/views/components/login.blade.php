@extends('layouts.layout')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-lg p-4">
                    <h2 class="text-center mb-4">Login</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <!-- Email Field -->
                        <div class="form-floating mb-4">
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}"
                                   placeholder="Email Address" required autofocus>
                            <label for="email">
                                <i class="bi bi-envelope me-2"></i>Email Address
                            </label>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-floating mb-4 password-field">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" placeholder="Password" required>
                            <label for="password">
                                <i class="bi bi-lock me-2"></i>Password
                            </label>
                            <button type="button" class="btn password-toggle">
                                <i class="bi bi-eye"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Login Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary py-3 main-button">
                                <span>Sign In</span>
                                <i class="bi bi-arrow-right-circle ms-2"></i>
                            </button>
                        </div>

                        <!-- Admin Login Button -->
                        <div class="d-grid mb-4">
                            <a href="{{ route('filament.admin.auth.login') }}" class="btn btn-outline-danger py-2 admin-button">
                                <i class="bi bi-shield-lock me-2"></i>
                                <span>Login as Admin</span>
                            </a>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <small>Don't have an account? <a href="{{ route('show.register') }}">Register here</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
