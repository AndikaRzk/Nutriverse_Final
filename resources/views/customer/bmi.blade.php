@extends('layouts.layout') {{-- Pastikan ini mengarah ke file layout utama Anda --}}

@section('content')
{{-- External Font Imports (Google Fonts) and Bootstrap Icons --}}
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

{{-- Custom CSS for this page --}}
<style>
    /* Global Styles & Color Palette */
    :root {
        --primary-green: #4CAF50; /* A fresh, vibrant green */
        --dark-green: #2E7D32; /* Deeper green for headings */
        --light-green: #E8F5E9; /* Very light green for backgrounds */
        --accent-green: #66BB6A; /* Slightly lighter accent green */
        --text-dark: #212121; /* Richer dark text */
        --text-muted: #757575; /* Soft gray for secondary text */
        --shadow-light: rgba(0, 0, 0, 0.08);
        --shadow-medium: rgba(0, 0, 0, 0.15);
        --border-light: #ECEFF1;

        /* Specific Alert/Badge Colors */
        --info-bg: #E3F2FD; /* Light blue */
        --info-text: #1976D2; /* Dark blue */
        --warning-bg: #FFF3E0; /* Light orange */
        --warning-text: #FF9800; /* Dark orange */
        --danger-bg: #FFEBEE; /* Light red */
        --danger-text: #D32F2F; /* Dark red */
        --success-bg: #E8F5E9; /* Light green (same as light-green) */
        --success-text: #388E3C; /* Dark green */
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--light-green);
        color: var(--text-dark);
        line-height: 1.6;
        scroll-behavior: smooth;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Montserrat', sans-serif;
        color: var(--dark-green);
        font-weight: 700;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }

    .text-shadow-sm {
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
    }

    .text-shadow-lg {
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);
    }

    /* Card Styling */
    .card {
        border-radius: 1.5rem !important;
        overflow: hidden;
        box-shadow: 0 15px 45px var(--shadow-light);
        transition: transform 0.3s ease-out, box-shadow 0.3s ease-out;
        border: none;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 55px var(--shadow-medium);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
        color: white;
        border-bottom: none;
        padding: 2.5rem 1.75rem;
        position: relative;
    }

    .card-header h2, .card-header h3 {
        color: white;
    }

    .card-body {
        padding: 2.5rem;
    }

    /* Button Styling */
    .btn-green-modern {
        background: linear-gradient(90deg, var(--primary-green) 0%, var(--dark-green) 100%);
        border: none;
        border-radius: 0.8rem;
        padding: 1.2rem 2.5rem;
        font-size: 1.2rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease-out;
        box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3);
    }

    .btn-green-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(76, 175, 80, 0.45);
        filter: brightness(1.05);
    }

    .btn-green-modern:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-outline-green-modern {
        border: 2px solid var(--primary-green);
        color: var(--primary-green);
        background-color: transparent;
        border-radius: 0.8rem;
        padding: 1.2rem 2.5rem;
        font-size: 1.2rem;
        font-weight: 600;
        transition: all 0.3s ease-out;
    }

    .btn-outline-green-modern:hover {
        background-color: var(--primary-green);
        color: white;
        box-shadow: 0 5px 15px rgba(76, 175, 80, 0.2);
    }

    /* Form Elements */
    .form-label {
        font-weight: 600;
        color: var(--dark-green);
        font-size: 1.1rem;
        margin-bottom: 0.75rem;
    }

    .form-control-lg {
        border-radius: 0.8rem;
        border: 1px solid var(--border-light);
        padding: 1rem 1.25rem;
        font-size: 1.1rem;
        transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .form-control-lg:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
    }

    /* Alert Styling */
    .alert {
        border-left: 6px solid;
        border-radius: 0.8rem;
        padding: 1.5rem 2rem;
        font-size: 1.1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .alert-info-green {
        background-color: var(--info-bg);
        border-color: var(--info-text);
        color: var(--info-text);
    }

    .alert-warning-light {
        background-color: var(--warning-bg);
        border-color: var(--warning-text);
        color: var(--warning-text);
    }

    .alert-danger-light {
        background-color: var(--danger-bg);
        border-color: var(--danger-text);
        color: var(--danger-text);
    }

    .alert-success-light {
        background-color: var(--success-bg);
        border-color: var(--success-text);
        color: var(--success-text);
    }

    .alert-heading {
        color: inherit;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    /* Badge Styling */
    .badge {
        font-weight: 700;
        padding: 0.6em 1.1em;
        border-radius: 1.5rem;
        text-transform: uppercase;
        font-size: 0.9em;
        letter-spacing: 0.05em;
    }

    .bg-info-badge { background-color: var(--info-text) !important; color: white !important; }
    .bg-warning-badge { background-color: var(--warning-text) !important; color: white !important; }
    .bg-success-badge { background-color: var(--success-text) !important; color: white !important; }
    .bg-danger-badge { background-color: var(--danger-text) !important; color: white !important; }
    .bg-accent-badge { background-color: var(--accent-green) !important; color: white !important; }

    /* Modal Styling */
    .modal-content {
        border-radius: 1.8rem !important;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
    }
    .modal-header {
        border-bottom: none;
        padding: 1.75rem 2rem 1.25rem;
    }
    .modal-title {
        font-weight: 700;
        font-size: 1.8rem;
    }
    .btn-close-white {
        filter: invert(1) brightness(1.8);
        transition: transform 0.3s ease-out;
        font-size: 1.2rem;
    }
    .btn-close-white:hover {
        transform: rotate(90deg);
    }

    /* Custom Line Break */
    .hr-divider {
        border: none;
        border-top: 2px dashed var(--border-light);
        margin: 4rem auto;
        width: 70%;
        opacity: 0.7;
    }

    /* Food & Supplement Cards */
    .food-card-hover, .supplement-card-hover {
        border-radius: 1rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: transform 0.3s ease-out, box-shadow 0.3s ease-out;
    }

    .food-card-hover:hover, .supplement-card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 35px rgba(0,0,0,0.1);
    }

    .food-card-hover .card-body p, .supplement-card-hover .card-body p {
        font-size: 0.95rem;
        color: var(--text-muted);
    }

    .food-card-hover .card-title, .supplement-card-hover .card-title {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 1.15rem;
    }

    .food-icon-color {
        font-size: 1.1rem;
        vertical-align: middle;
        margin-right: 0.4rem;
    }
    .text-red-icon { color: #E53935; } /* Calories */
    .text-blue-icon { color: #1E88E5; } /* Portion Size */
    .text-brown-icon { color: #6D4C41; } /* Protein */
    .text-orange-icon { color: #FB8C00; } /* Carbs */
    .text-yellow-icon { color: #FFD600; } /* Fat */

    .supplement-image-placeholder {
        height: 200px;
        background-color: var(--light-green);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        border-top-left-radius: calc(1.5rem - 1px);
        border-top-right-radius: calc(1.5rem - 1px);
    }
    .supplement-card-hover img {
        height: 200px;
        object-fit: cover;
        width: 100%;
        border-top-left-radius: calc(1.5rem - 1px);
        border-top-right-radius: calc(1.5rem - 1px);
    }

    /* Animations */
    .animate__animated {
        animation-duration: 0.8s;
        animation-fill-mode: both;
    }
    .animate__pulse.animate__infinite {
        animation-duration: 2.5s;
        animation-iteration-count: infinite;
    }

</style>

<div class="container py-5">
    {{-- Main BMI Checker Section --}}
    <div class="row justify-content-center mb-5">
        <div class="col-md-9 col-lg-8">
            <div class="card shadow-lg rounded-4 animate__animated animate__fadeInDown">
                <div class="card-header bg-gradient-green-modern text-white text-center py-4 rounded-top-4">
                    <h2 class="mb-2 fw-bold fs-2 text-shadow-lg">Wellness Navigator</h2>
                    <p class="mb-0 text-white-75 fs-5">Your integrated health and nutrition guide</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <h3 class="mb-4 text-center text-primary-green fw-bold fs-3">BMI Calculator</h3>

                    {{-- Trigger Button for BMI Modal --}}
                    <div class="d-grid gap-2 mb-4">
                        <button type="button" class="btn btn-green-modern btn-lg fw-bold animate__animated animate__pulse animate__infinite" data-bs-toggle="modal" data-bs-target="#bmiModal">
                            <i class="bi bi-calculator me-2"></i> Calculate Your BMI
                        </button>
                    </div>

                    {{-- Displaying BMI Result outside the modal (if available) --}}
                    @if(session('bmi_result') && session('bmi_category'))
                        <div class="alert alert-info-green rounded-3 shadow-sm text-center animate__animated animate__fadeInUp" role="alert">
                            <h5 class="alert-heading text-info-text fw-bold fs-4">Your BMI Result</h5>
                            <p class="mb-1 fs-3">
                                <strong>BMI:</strong>
                                <span class="badge bg-info-badge fs-4">
                                    {{ session('bmi_result') }}
                                </span>
                            </p>
                            <p class="mb-0 fs-3">
                                <strong>Category:</strong>
                                @php
                                    $category = session('bmi_category');
                                    $badgeClass = '';
                                    switch ($category) {
                                        case 'Underweight': $badgeClass = 'bg-warning-badge'; break;
                                        case 'Normal weight': $badgeClass = 'bg-success-badge'; break;
                                        case 'Overweight': $badgeClass = 'bg-warning-badge'; break;
                                        case 'Obese': $badgeClass = 'bg-danger-badge'; break;
                                        default: $badgeClass = 'bg-info-badge'; break;
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }} fs-4">
                                    {{ $category }}
                                </span>
                            </p>
                            <hr class="my-3 opacity-25">
                            <p class="mb-0 text-muted fs-6">Based on your last calculation.</p>
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

                    <div class="modal-header bg-gradient-green-modern text-white rounded-top-4">
                        <h5 class="modal-title fw-bold text-shadow-sm fs-4" id="bmiModalLabel">Enter Your Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        {{-- Validation Errors (if any) --}}
                        @if ($errors->any())
                            <div class="alert alert-danger-light rounded-3 mb-4 animate__animated animate__shakeX">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="height" class="form-label">Height (cm)</label>
                            <input type="number" step="0.1" class="form-control form-control-lg @error('height') is-invalid @enderror" id="height" name="height" value="{{ old('height') }}" placeholder="e.g., 175.5" required>
                            @error('height')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" step="0.1" class="form-control form-control-lg @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight') }}" placeholder="e.g., 70.2" required>
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- BMI Result inside Modal (if applicable, after re-submission) --}}
                        @if(session('bmi_result') && session('bmi_category') && $errors->isEmpty())
                            <div class="alert alert-info-green mt-4 rounded-3 shadow-sm text-center animate__animated animate__fadeIn">
                                <h6 class="alert-heading text-info-text fw-bold fs-5">Your Latest BMI</h6>
                                <p class="mb-1 fs-4">
                                    <strong>BMI:</strong>
                                    <span class="badge bg-info-badge">
                                        {{ session('bmi_result') }}
                                    </span>
                                </p>
                                <p class="mb-0 fs-4">
                                    <strong>Category:</strong>
                                    @php
                                        $category = session('bmi_category');
                                        $badgeClass = '';
                                        switch ($category) {
                                            case 'Underweight': $badgeClass = 'bg-warning-badge'; break;
                                            case 'Normal weight': $badgeClass = 'bg-success-badge'; break;
                                            case 'Overweight': $badgeClass = 'bg-warning-badge'; break;
                                            case 'Obese': $badgeClass = 'bg-danger-badge'; break;
                                            default: $badgeClass = 'bg-info-badge'; break;
                                        }
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ $category }}
                                    </span>
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer d-flex justify-content-between p-4">
                        <button type="button" class="btn btn-outline-green-modern btn-lg" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-green-modern btn-lg fw-bold">Calculate BMI</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <hr class="hr-divider">

    {{-- Food Recommendation Section --}}
    <div class="row justify-content-center mt-5">
        <div class="col-md-9 col-lg-8">
            <div class="card shadow-lg rounded-4 animate__animated animate__fadeInUp">
                <div class="card-header bg-gradient-green-modern text-white text-center py-4 rounded-top-4">
                    <h3 class="mb-2 fw-bold fs-3 text-shadow-lg">Daily Meal Planner</h3>
                    <p class="mb-0 text-white-75 fs-5">Tailored meals for your daily calorie needs</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('recommend.foods') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="daily_calories" class="form-label">Your Desired Daily Calories (kcal)</label>
                            <input type="number" class="form-control form-control-lg @error('daily_calories') is-invalid @enderror" name="daily_calories" value="{{ old('daily_calories', session('daily_calories')) }}" placeholder="e.g., 2000" required>
                            @error('daily_calories')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-green-modern btn-lg fw-bold">
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
        <h4 class="mb-4 text-center fw-bold text-dark-green fs-3">
            <i class="bi bi-egg-fill me-2" style="color: var(--primary-green);"></i> Personalized Food Recommendations for
            <span class="text-primary-green">{{ session('daily_calories') }} kcal</span>
        </h4>

        @foreach (session('recommended_foods') as $mealTime => $categories)
            <div class="card mb-4 shadow-sm rounded-3">
                <div class="card-header bg-gradient-green-modern text-white text-capitalize rounded-top-3 py-3">
                    <h5 class="mb-0 fw-bold text-shadow-sm fs-4">{{ $mealTime }}</h5>
                </div>
                <div class="card-body p-4">
                    @foreach ($categories as $category => $foods)
                        <div class="mb-4">
                            <h6 class="text-capitalize mb-3">
                                <span class="badge bg-accent-badge py-2 px-3 fs-5">
                                    <i class="bi bi-tag-fill me-1"></i> {{ $category }}
                                </span>
                            </h6>

                            @if(count($foods) > 0)
                                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                    @foreach ($foods as $food)
                                        <div class="col">
                                            <div class="card h-100 border food-card-hover">
                                                <div class="card-body d-flex flex-column">
                                                    <h6 class="card-title mb-2">{{ $food->name }}</h6>
                                                    <hr class="my-2 opacity-50">
                                                    <p class="card-text mb-1"><i class="bi bi-fire food-icon-color text-red-icon"></i> Calories: <strong>{{ $food->calories }} kcal</strong></p>
                                                    <p class="card-text mb-1"><i class="bi bi-box-seam food-icon-color text-blue-icon"></i> Portion Size: <strong>{{ $food->portion_size_grams }} grams</strong></p>
                                                    <p class="card-text mb-1"><i class="bi bi-egg-fried food-icon-color text-brown-icon"></i> Protein: <strong>{{ $food->protein_g }}g</strong></p>
                                                    <p class="card-text mb-1"><i class="bi bi-rice-bowl-fill food-icon-color text-orange-icon"></i> Carbs: <strong>{{ $food->carbs_g }}g</strong></p>
                                                    <p class="card-text"><i class="bi bi-oil-can-fill food-icon-color text-yellow-icon"></i> Fat: <strong>{{ $food->fat_g }}g</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted fst-italic fs-6">No food available in this category.</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    @endif

    <hr class="hr-divider">

    {{-- Recommended Supplements Section --}}
    @if(session('supplements') && session('supplements')->count())
    <div class="mt-5 animate__animated animate__fadeInUp">
        <h3 class="mb-4 text-center fw-bold text-dark-green fs-3">
            <i class="bi bi-capsule-pill me-2" style="color: var(--primary-green);"></i> Top Supplements for
            <span class="text-primary-green">{{ session('bmi_category') }}</span>
        </h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach(session('supplements')->take(3) as $supplement)
                <div class="col">
                    <div class="card h-100 shadow-sm rounded-3 supplement-card-hover">
                        {{-- Supplement Image Section --}}
                        @if($supplement->image)
                            <img src="{{ asset('storage/' . $supplement->image) }}" class="card-img-top" alt="{{ $supplement->name }}">
                        @else
                            <div class="supplement-image-placeholder">
                                <i class="bi bi-image-fill me-2"></i> No Image
                            </div>
                        @endif

                        {{-- Card Body (Supplement Details) --}}
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title mb-2">{{ $supplement->name }}</h5>
                            <p class="card-text mb-1"><i class="bi bi-tag me-1" style="color: var(--primary-green);"></i> <strong>Category:</strong> {{ $supplement->category }}</p>
                            <p class="card-text fs-6 mb-3">{{ Str::limit($supplement->description ?? 'No description available.', 100) }}</p>

                            <p class="card-text mb-1 fw-bold fs-5" style="color: var(--dark-green);">Price: Rp{{ number_format($supplement->price, 2, ',', '.') }}</p>
                            <p class="card-text mb-1 text-muted fs-6">Stock: <span class="{{ $supplement->stock <= 5 ? 'text-danger-text fw-bold' : 'text-success-text fw-bold' }}">{{ $supplement->stock }}</span></p>

                            {{-- Expiration Date Information --}}
                            @if($supplement->expired_at)
                                @php
                                    $expiryDate = \Carbon\Carbon::parse($supplement->expired_at);
                                    $isExpired = $expiryDate->isPast();
                                    $daysUntilExpiry = now()->diffInDays($expiryDate, false);
                                @endphp
                                <p class="card-text fs-6 mb-2 {{ $isExpired ? 'text-danger-text fw-bold' : ($daysUntilExpiry <= 30 ? 'text-warning-text' : 'text-muted') }}">
                                    <i class="bi bi-calendar-x me-1"></i> Expires on: {{ $expiryDate->format('d M Y') }}
                                    @if($isExpired)
                                        (Expired!)
                                    @elseif($daysUntilExpiry <= 30)
                                        ({{ $daysUntilExpiry }} days left!)
                                    @endif
                                </p>
                            @endif

                            {{-- Add to Cart Button --}}
                            <div class="mt-auto pt-3">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="supplement_id" value="{{ $supplement->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-green-modern w-100 fw-bold" {{ $supplement->stock <= 0 || (isset($isExpired) && $isExpired) ? 'disabled' : '' }}>
                                        @if ($supplement->stock <= 0)
                                            <i class="bi bi-x-circle me-2"></i> Out of Stock
                                        @elseif (isset($isExpired) && $isExpired)
                                            <i class="bi bi-archive me-2"></i> Product Expired
                                        @else
                                            <i class="bi bi-cart-plus-fill me-2"></i> Add to Cart
                                        @endif
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

{{-- Inline JavaScript for this page --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var bmiModalElement = document.getElementById('bmiModal');
        var bmiModal = new bootstrap.Modal(bmiModalElement);

        // Show modal if there are validation errors or a BMI result from a previous submission
        @if($errors->any() || (session('bmi_result') && $errors->isEmpty()))
            bmiModal.show();
        @endif
    });
</script>
@endsection