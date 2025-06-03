@extends('layouts.layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-lg border-0 rounded-4">
                {{-- Card Header with Green Gradient --}}
                <div class="card-header bg-success text-white text-center py-4 rounded-top-4">
                    <h2 class="mb-0 fw-bold">Edit Customer Details</h2>
                </div>
                <div class="card-body p-4 p-md-5">
                    @if(session('success'))
                        {{-- Success Alert with Animation --}}
                        <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                        @csrf

                        {{-- Name Field --}}
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">Name</label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name', $customer->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Gender Field --}}
                        <div class="mb-4">
                            <label for="gender" class="form-label fw-semibold">Gender</label>
                            <select name="gender" id="gender" class="form-select form-select-lg @error('gender') is-invalid @enderror" required>
                                <option value="" disabled {{ old('gender', $customer->gender) == '' ? 'selected' : '' }}>Select Gender</option>
                                <option value="Male" {{ old('gender', $customer->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $customer->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                {{-- <option value="Other" {{ old('gender', $customer->gender) == 'Other' ? 'selected' : '' }}>Other</option> --}}
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Date of Birth Field --}}

                        <div class="mb-4">
                            <label for="dob" class="form-label fw-semibold">Date of Birth</label>
                            <input type="date" name="dob" id="dob" class="form-control form-control-lg @error('dob') is-invalid @enderror" value="{{ old('dob', $customer->dob) }}" required>
                            @error('dob')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Email Field --}}
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email', $customer->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Password Field with Toggle --}}
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Password <small class="text-muted">(leave blank to keep current)</small></label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control form-control-lg @error('password') is-invalid @enderror">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i> {{-- Bootstrap Eye Icon --}}
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Phone Field --}}
                        <div class="mb-4">
                            <label for="phone" class="form-label fw-semibold">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control form-control-lg @error('phone') is-invalid @enderror" value="{{ old('phone', $customer->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Address Field --}}
                        <div class="mb-5">
                            <label for="address" class="form-label fw-semibold">Address</label>
                            <textarea name="address" id="address" class="form-control form-control-lg @error('address') is-invalid @enderror" rows="4" required>{{ old('address', $customer->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror {{-- Corrected: @endror -> @enderror --}}
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg fw-bold animate__animated animate__pulse animate__infinite">Update Customer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

---

@push('styles')
{{-- Animate.css for animations --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
{{-- Bootstrap Icons for eye icon --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    body {
        background-color: #e8f5e9; /* Light green background */
    }
    .card {
        border-radius: 1rem !important; /* More rounded corners for the card */
        overflow: hidden; /* Ensures rounded corners apply to children */
    }
    .card-header {
        background: linear-gradient(135deg, #4CAF50 0%, #388E3C 100%); /* Green gradient for header */
    }
    .form-control-lg, .form-select-lg, .input-group-text {
        padding: 0.75rem 1rem; /* Larger padding for input fields */
        border-radius: 0.5rem; /* Slightly more rounded inputs */
        border: 1px solid #ced4da; /* Default border */
        transition: all 0.3s ease-in-out;
    }
    .form-control-lg:focus, .form-select-lg:focus {
        border-color: #66bb6a; /* Green focus border */
        box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25); /* Green focus shadow */
    }
    .form-label {
        color: #495057; /* Darker label color */
        margin-bottom: 0.5rem;
    }
    .btn-success {
        background: linear-gradient(90deg, #4CAF50 0%, #2E7D32 100%); /* Green gradient for the button */
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
        transition: all 0.3s ease-in-out;
    }
    .btn-success:hover {
        transform: translateY(-2px); /* Subtle lift on hover */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .alert-success {
        border-radius: 0.5rem;
        font-weight: 500;
        background-color: #e6ffed; /* Softer green for alert */
        border-color: #b2e6c7;
        color: #1a5e37;
    }
    .animate__fadeIn {
        animation-duration: 0.5s;
    }
    .animate__pulse {
        animation-duration: 2s;
    }
    .input-group .btn-outline-secondary {
        border-top-right-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        border-left: none; /* Remove left border for a cleaner look */
        color: #6c757d;
        border-color: #ced4da;
    }
    .input-group .btn-outline-secondary:hover {
        background-color: #f8f9fa;
        color: #495057;
    }
</style>
@endpush

---

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function (e) {
                // Toggle the type attribute between 'password' and 'text'
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle the eye icon to reflect visibility
                this.querySelector('i').classList.toggle('bi-eye');
                this.querySelector('i').classList.toggle('bi-eye-slash');
            });
        }
    });
</script>
@endpush