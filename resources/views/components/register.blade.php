@extends('layouts.layout')

@section('content')
<div class="container my-5"> {{-- Increased vertical margin for more top/bottom space --}}
    <div class="row justify-content-center">
        <div class="col-md-7"> {{-- Slightly wider column for a more spacious layout --}}
            <div class="card register-card animate__animated animate__fadeInUp" style="
                border-radius: 1.5rem; /* Even more rounded corners for a softer, premium look */
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1); /* Deeper, more diffused shadow */
                overflow: hidden; /* Ensures header border-radius is respected */
            ">
                <div class="card-header text-center register-header" style="
                    background-color: var(--primary-color);
                    color: white;
                    padding: 2rem 1.5rem; /* More generous padding for header */
                    font-size: 1.8rem; /* Larger, more impactful header text */
                    font-weight: 700; /* Bolder header font weight */
                    letter-spacing: 0.03em;
                    border-bottom: none; /* Remove default card-header border */
                    ">
                    <i class="ri-user-add-line me-3 align-middle" style="font-size: 2.2rem;"></i>Join Now
                </div>
                <div class="card-body p-5"> {{-- Increased padding inside card body --}}
                    <form action="{{ route('register') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4"> {{-- Increased bottom margin for form groups --}}
                            <label for="name" class="form-label fw-bold text-muted mb-2">
                                <i class="ri-account-circle-line me-2 align-middle" style="color: var(--icon-color);"></i>Full Name
                            </label>
                            <input type="text" class="form-control register-input form-control-lg" id="name" name="name" required value="{{ old('name') }}" placeholder="Enter your full name">
                            @error('name')
                            <div class="text-danger fw-semibold mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="gender" class="form-label fw-bold text-muted mb-2">
                                 <i class="ri-gender-line me-2 align-middle" style="color: var(--icon-color);"></i>Gender
                            </label>
                            <select class="form-select register-input form-control-lg" id="gender" name="gender" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                            <div class="text-danger fw-semibold mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="dob" class="form-label fw-bold text-muted mb-2">
                                 <i class="ri-calendar-line me-2 align-middle" style="color: var(--icon-color);"></i>Date of Birth
                            </label>
                            <input type="date" class="form-control register-input form-control-lg" id="dob" name="dob" required value="{{ old('dob') }}">
                            @error('dob')
                            <div class="text-danger fw-semibold mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold text-muted mb-2">
                                 <i class="ri-mail-line me-2 align-middle" style="color: var(--icon-color);"></i>Email
                            </label>
                            <input type="email" class="form-control register-input form-control-lg" id="email" name="email" required value="{{ old('email') }}" placeholder="Enter your email address">
                            @error('email')
                            <div class="text-danger fw-semibold mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="phone" class="form-label fw-bold text-muted mb-2">
                                 <i class="ri-phone-line me-2 align-middle" style="color: var(--icon-color);"></i>Phone Number
                            </label>
                            <input type="text" class="form-control register-input form-control-lg" id="phone" name="phone" required value="{{ old('phone') }}" placeholder="Enter your phone number">
                            @error('phone')
                            <div class="text-danger fw-semibold mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="address" class="form-label fw-bold text-muted mb-2">
                                 <i class="ri-home-4-line me-2 align-middle" style="color: var(--icon-color);"></i>Address (Optional)
                            </label>
                            <input type="text" class="form-control register-input form-control-lg" id="address" name="address" value="{{ old('address') }}" placeholder="Enter your address">
                            @error('address')
                            <div class="text-danger fw-semibold mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold text-muted mb-2">
                                 <i class="ri-lock-password-line me-2 align-middle" style="color: var(--icon-color);"></i>Password
                            </label>
                            <input type="password" class="form-control register-input form-control-lg" id="password" name="password" required placeholder="Create your password">
                            @error('password')
                            <div class="text-danger fw-semibold mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-5"> {{-- Increased bottom margin for the last input group --}}
                            <label for="password_confirmation" class="form-label fw-bold text-muted mb-2">
                                 <i class="ri-check-double-line me-2 align-middle" style="color: var(--icon-color);"></i>Confirm Password
                            </label>
                            <input type="password" class="form-control register-input form-control-lg" id="password_confirmation" name="password_confirmation" required placeholder="Confirm your password">
                        </div>
                        <button type="submit" class="btn w-100 register-button animate__animated animate__pulse animate__infinite" style="
                            padding: 1rem 1.5rem; /* More generous padding for button */
                            font-size: 1.35rem; /* Larger button text */
                            font-weight: 700; /* Bolder button text */
                            letter-spacing: 0.04em;
                            border-radius: 0.8rem; /* Consistent rounding */
                            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); /* More prominent shadow */
                            background-color: var(--primary-color);
                            border: none;
                            color: white;
                            transition: all 0.3s ease;
                        ">
                            Register Now <i class="ri-arrow-right-line ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-color: #28a745; /* A classic, slightly darker green for primary actions */
        --primary-color-hover: #218838; /* Darker shade for hover */
        --icon-color: #388E3C; /* A rich, slightly darker green for icons */
        --input-border-color: #e0e0e0; /* Very light grey for input borders */
        --input-focus-shadow: rgba(40, 167, 69, 0.25); /* Green shadow for focus */
        --text-muted-color: #6c757d;
    }

    body {
        background-color: #f8f9fa; /* A very light background to make the card stand out */
    }

    .register-card {
        border: none; /* Remove default card border */
    }

    .register-input {
        border: 1px solid var(--input-border-color);
        border-radius: 0.8rem;
        padding: 0.9rem 1.25rem; /* Slightly more padding than default Bootstrap */
        transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05); /* Subtle initial shadow for inputs */
    }

    .register-input::placeholder {
        color: #adb5bd; /* Lighter placeholder text */
        font-style: italic;
    }

    .register-input:focus {
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 0.25rem var(--input-focus-shadow) !important;
        transform: translateY(-2px); /* Subtle lift on focus */
    }

    .form-label {
        color: var(--text-muted-color) !important; /* Ensure label color adheres to variable */
        font-size: 0.95rem; /* Slightly larger label font size */
    }

    .register-button {
        background-color: var(--primary-color) !important;
        box-shadow: 0 8px 20px var(--primary-color-hover); /* Initial shadow for button */
    }

    .register-button:hover {
        background-color: var(--primary-color-hover) !important;
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2); /* Enhanced shadow on hover */
        transform: translateY(-3px) scale(1.01); /* Gentle lift and slight scale on hover */
    }

    /* Animate.css (ensure it's linked in your layout) */
    .animate__animated.animate__fadeInUp {
        animation-duration: 0.7s;
    }
    .animate__animated.animate__pulse.animate__infinite {
        animation-duration: 2s;
    }
</style>
@endsection