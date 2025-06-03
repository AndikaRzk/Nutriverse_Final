@extends('layouts.layout') {{-- Ensure this points to your actual layout file --}}

@section('content')
<div class="container py-5">
    {{-- Main BMI Checker Section --}}
    <div class="row justify-content-center mb-5">
        <div class="col-md-9 col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 animate__animated animate__fadeInDown">
                <div class="card-header bg-success text-white text-center py-4 rounded-top-4">
                    <h2 class="mb-0 fw-bold fs-3">Healthy Living Hub</h2>
                    <p class="mb-0 text-white-50">Your personal guide to BMI and nutrition</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <h3 class="mb-4 text-center text-success fw-bold">BMI Calculator</h3>

                    {{-- Trigger Button for BMI Modal --}}
                    <div class="d-grid gap-2 mb-4">
                        <button type="button" class="btn btn-success btn-lg fw-bold" data-bs-toggle="modal" data-bs-target="#bmiModal">
                            <i class="bi bi-calculator me-2"></i> Check Your BMI
                        </button>
                    </div>

                    {{-- Displaying BMI Result outside the modal (if available) --}}
                    @if(session('bmi_result') && session('bmi_category'))
                        <div class="alert alert-info border-0 rounded-3 shadow-sm text-center animate__animated animate__fadeInUp" role="alert">
                            <h5 class="alert-heading text-info fw-bold">Your BMI Result</h5>
                            <p class="mb-1 fs-4"><strong>BMI:</strong> <span class="badge bg-info-subtle text-info fs-5">{{ session('bmi_result') }}</span></p>
                            <p class="mb-0 fs-4"><strong>Category:</strong> <span class="badge bg-{{ session('bmi_category') == 'Underweight' ? 'warning' : (session('bmi_category') == 'Normal weight' ? 'success' : (session('bmi_category') == 'Overweight' ? 'warning' : 'danger')) }} fs-5">{{ session('bmi_category') }}</span></p>
                            <hr>
                            <p class="mb-0 text-muted small">Based on your last calculation.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for BMI Input Form --}}
    <div class="modal fade" id="bmiModal" tabindex="-1" aria-labelledby="bmiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-lg border-0">
                <form action="{{ route('bmi.store') }}" method="POST">
                    @csrf

                    <div class="modal-header bg-success text-white rounded-top-4">
                        <h5 class="modal-title fw-bold" id="bmiModalLabel">BMI Input Form</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        {{-- Validation Errors (if any) --}}
                        @if ($errors->any())
                            <div class="alert alert-danger rounded-3 mb-4 animate__animated animate__shakeX">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="height" class="form-label fw-semibold">Height (cm)</label>
                            <input type="number" step="0.1" class="form-control form-control-lg @error('height') is-invalid @enderror" id="height" name="height" value="{{ old('height') }}" required>
                            @error('height')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="weight" class="form-label fw-semibold">Weight (kg)</label>
                            <input type="number" step="0.1" class="form-control form-control-lg @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight') }}" required>
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- BMI Result inside Modal (if applicable, after re-submission) --}}
                        @if(session('bmi_result') && session('bmi_category') && $errors->isEmpty())
                            <div class="alert alert-info mt-4 border-0 rounded-3 shadow-sm text-center">
                                <h6 class="alert-heading text-info fw-bold">Your Latest BMI</h6>
                                <p class="mb-1 fs-5"><strong>BMI:</strong> <span class="badge bg-info-subtle text-info">{{ session('bmi_result') }}</span></p>
                                <p class="mb-0 fs-5"><strong>Category:</strong> <span class="badge bg-{{ session('bmi_category') == 'Underweight' ? 'warning' : (session('bmi_category') == 'Normal weight' ? 'success' : (session('bmi_category') == 'Overweight' ? 'warning' : 'danger')) }}">{{ session('bmi_category') }}</span></p>
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success fw-bold">Calculate BMI</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    ---

    {{-- Food Recommendation Section --}}
    <div class="row justify-content-center mt-5">
        <div class="col-md-9 col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 animate__animated animate__fadeInUp">
                <div class="card-header bg-success text-white text-center py-4 rounded-top-4">
                    <h3 class="mb-0 fw-bold fs-4">Get Food Recommendations</h3>
                    <p class="mb-0 text-white-50">Tailored meals for your daily calorie needs</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('recommend.foods') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="daily_calories" class="form-label fw-semibold">Your Desired Daily Calories (kcal)</label>
                            <input type="number" class="form-control form-control-lg @error('daily_calories') is-invalid @enderror" name="daily_calories" value="{{ old('daily_calories', session('daily_calories')) }}" required>
                            @error('daily_calories')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg fw-bold">
                                <i class="bi bi-lightning-charge me-2"></i> Get Recommendations
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(session('recommended_foods'))
    <div class="mt-5 animate__animated animate__fadeInUp">
        <h4 class="mb-4 text-center fw-bold text-success">🍽️ Food Recommendations for <span class="text-success">{{ session('daily_calories') }} kcal</span></h4>

        @foreach (session('recommended_foods') as $mealTime => $categories)
            <div class="card mb-4 shadow-sm border-0 rounded-3">
                <div class="card-header bg-success text-white text-capitalize rounded-top-3"> {{-- Changed from bg-primary to bg-success --}}
                    <h5 class="mb-0 fw-bold">{{ $mealTime }}</h5>
                </div>
                <div class="card-body p-4">
                    @foreach ($categories as $category => $foods)
                        <div class="mb-4">
                            <h6 class="text-capitalize mb-3">
                                <span class="badge bg-green-accent text-dark rounded-pill py-2 px-3 fs-6"><i class="bi bi-tag-fill me-1"></i> {{ $category }}</span> {{-- Changed from bg-info to bg-green-accent --}}
                            </h6>

                            @if(count($foods) > 0)
                                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4"> {{-- Responsive grid for food cards --}}
                                    @foreach ($foods as $food)
                                        <div class="col">
                                            <div class="card h-100 border border-light shadow-sm rounded-3 food-card-hover">
                                                <div class="card-body d-flex flex-column">
                                                    <h6 class="card-title mb-2 fw-bold text-dark">{{ $food->name }}</h6>
                                                    <hr class="my-2">
                                                    <p class="card-text mb-1 text-muted small"><i class="bi bi-fire me-1"></i> Calories: <strong class="text-dark">{{ $food->calories }} kcal</strong></p>
                                                    <p class="card-text mb-1 text-muted small"><i class="bi bi-box-seam me-1"></i> Portion Size: <strong class="text-dark">{{ $food->portion_size_grams }} grams</strong></p>
                                                    <p class="card-text mb-1 text-muted small"><i class="bi bi-egg-fried me-1"></i> Protein: <strong class="text-dark">{{ $food->protein_g }}g</strong></p>
                                                    <p class="card-text mb-1 text-muted small"><i class="bi bi-rice-bowl-fill me-1"></i> Carbs: <strong class="text-dark">{{ $food->carbs_g }}g</strong></p>
                                                    <p class="card-text small text-muted"><i class="bi bi-oil-can-fill me-1"></i> Fat: <strong class="text-dark">{{ $food->fat_g }}g</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted fst-italic">No food available in this category.</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    @endif

    ---

    {{-- Recommended Supplements Section --}}
    @if(session('supplements') && session('supplements')->count())
    <div class="mt-5 animate__animated animate__fadeInUp">
        <h3 class="mb-4 text-center fw-bold text-success">💊 Recommended Supplements for <span class="text-success">{{ session('bmi_category') }}</span></h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4"> {{-- Responsive grid for supplement cards --}}
            @foreach(session('supplements')->take(3) as $supplement)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 rounded-3 supplement-card-hover">
                        {{-- Supplement Image Section --}}
                        @if($supplement->image)
                            <img src="{{ asset('storage/' . $supplement->image) }}" class="card-img-top rounded-top-3" alt="{{ $supplement->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light-green text-success d-flex align-items-center justify-content-center fw-bold fs-5" style="height: 200px; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem;">
                                <i class="bi bi-image-fill me-2"></i> No Image
                            </div>
                        @endif

                        {{-- Card Body (Supplement Details) --}}
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-bold text-dark mb-2">{{ $supplement->name }}</h5>
                            <p class="card-text text-muted small mb-1"><i class="bi bi-tag me-1"></i> <strong>Category:</strong> {{ $supplement->category }}</p>
                            <p class="card-text text-sm mb-3">{{ Str::limit($supplement->description ?? 'No description available.', 100) }}</p>

                            <p class="card-text mb-1 fw-bold text-success">Price: Rp{{ number_format($supplement->price, 2, ',', '.') }}</p>
                            <p class="card-text mb-1 text-muted small">Stock: {{ $supplement->stock }}</p>

                            {{-- Expiration Date Information --}}
                            @if($supplement->expired_at)
                                <p class="card-text text-danger mb-2 small"><i class="bi bi-exclamation-triangle-fill me-1"></i> Expires on: {{ \Carbon\Carbon::parse($supplement->expired_at)->format('d M Y') }}</small></p>
                            @endif

                            {{-- Add to Cart Button --}}
                            <div class="mt-auto pt-3">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="supplement_id" value="{{ $supplement->id }}">
                                    <input type="hidden" name="quantity" value="1"> {{-- Default quantity 1 --}}
                                    <button type="submit" class="btn btn-success w-100 fw-bold animate__animated animate__pulse animate__infinite" {{ $supplement->stock <= 0 ? 'disabled' : '' }}>
                                        <i class="bi bi-cart-plus-fill me-2"></i> {{ $supplement->stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@endsection

---

@push('styles')
{{-- Animate.css for subtle animations --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
{{-- Bootstrap Icons for various icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* General Body Background */
    body {
        background-color: #f5fcf5; /* Very light green, almost white */
        font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; /* Modern font stack */
    }

    /* Card Styling */
    .card {
        border-radius: 1rem !important; /* Consistent rounded corners */
        overflow: hidden; /* Ensures content respects rounded corners */
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; /* Smooth hover effects */
    }
    .card-header {
        background: linear-gradient(135deg, #4CAF50 0%, #388E3C 100%); /* Deep green gradient */
        color: white;
        border-bottom: none; /* Remove default border */
    }
    .card-body {
        padding: 2.5rem; /* More generous padding */
    }

    /* Input and Select Styling */
    .form-control-lg, .form-select-lg {
        border-radius: 0.5rem;
        border: 1px solid #c8e6c9; /* Light green border */
        padding: 0.75rem 1.25rem; /* Larger and more spacious */
        box-shadow: inset 0 1px 2px rgba(0,0,0,.075); /* Subtle inner shadow */
    }
    .form-control-lg:focus, .form-select-lg:focus {
        border-color: #66bb6a; /* Vibrant green on focus */
        box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25); /* Green glow */
    }
    .form-label {
        font-weight: 600; /* Bolder labels */
        color: #388e3c; /* Dark green labels */
        margin-bottom: 0.6rem;
    }

    /* Button Styling */
    .btn-success {
        background: linear-gradient(90deg, #4CAF50 0%, #2E7D32 100%); /* Strong green gradient */
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 10px rgba(76, 175, 80, 0.3); /* Subtle shadow for depth */
    }
    .btn-success:hover {
        transform: translateY(-2px); /* Lift effect on hover */
        box-shadow: 0 6px 15px rgba(76, 175, 80, 0.4); /* Enhanced shadow on hover */
    }
    /* Removed .btn-primary specific to food recommendation header, now using .btn-success */
    .btn-outline-secondary { /* Password toggle button */
        border-color: #c8e6c9;
        color: #388e3c;
    }
    .btn-outline-secondary:hover {
        background-color: #e8f5e9;
        color: #2e7d32;
        border-color: #a5d6a7;
    }

    /* Alert Styling */
    .alert-success {
        background-color: #e6ffed; /* Very light green background for success */
        border-color: #b2e6c7; /* Matching border */
        color: #1a5e37; /* Dark green text */
        border-radius: 0.5rem;
    }
    .alert-danger {
        background-color: #ffebee; /* Light red background for errors */
        border-color: #ef9a9a;
        color: #c62828;
        border-radius: 0.5rem;
    }
    .alert-info {
        background-color: #e3f2fd; /* Light blue for info alerts */
        border-color: #90caf9;
        color: #1565c0;
        border-radius: 0.5rem;
    }
    .alert .badge {
        vertical-align: middle; /* Align badge text */
    }

    /* Modal Specific Styling */
    .modal-content {
        border-radius: 1rem !important; /* Rounded modal content */
    }
    .modal-header {
        border-bottom: none;
    }
    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%); /* White close button for dark backgrounds */
    }

    /* Badge Styling */
    .badge {
        font-weight: 600;
        padding: 0.5em 0.8em;
    }
    .bg-info-subtle { /* Custom color for info badges */
        background-color: #b3e5fc !important;
        color: #0277bd !important;
    }
    /* New custom green badge for categories */
    .bg-green-accent {
        background-color: #a5d6a7 !important; /* A soft, visible green */
        color: #388e3c !important; /* Darker green text */
    }


    /* Food & Supplement Cards */
    .food-card-hover:hover, .supplement-card-hover:hover {
        transform: translateY(-5px); /* Lift effect on hover */
        box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important; /* More pronounced shadow */
    }
    .food-card-hover .card-body p.small, .supplement-card-hover .card-body p.small {
        color: #5a5a5a !important; /* Slightly darker text for better readability on hover */
    }
    .food-card-hover .card-body strong, .supplement-card-hover .card-body strong {
        color: #212529 !important;
    }

    /* Image placeholder for supplements */
    .card-img-top.bg-light-green {
        background-color: #dcedc8 !important; /* Very light green for placeholder */
    }
</style>
@endpush

---

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Automatically open BMI modal if there are validation errors or a BMI result
        var bmiModalElement = document.getElementById('bmiModal');
        var bmiModal = new bootstrap.Modal(bmiModalElement);

        @if($errors->any() || session('bmi_result'))
            bmiModal.show();
        @endif

        // Optional: Close modal and reset form if opened/closed multiple times (depends on your desired UX)
        bmiModalElement.addEventListener('hidden.bs.modal', function (event) {
            // You might want to reset the form here if you don't want old input to persist on subsequent openings
            // This example retains old input, which is often preferred for user experience.
        });
    });
</script>
@endpush