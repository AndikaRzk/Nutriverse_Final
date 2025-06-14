@extends('layouts.layout') {{-- Ganti dengan layout sesuai projectmu --}}

@section('content')
{{-- Directly link Animate.css and Bootstrap Icons if not in layout --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

{{-- Custom styles directly within the section for demonstration --}}
<style>
    :root {
        --nutriverse-dark: #2c3e50; /* Darker tone for headings */
        --nutriverse-primary: #3498db; /* A vibrant blue */
        --nutriverse-secondary: #7f8c8d; /* Muted gray for secondary text */
        --nutriverse-success: #27ae60; /* Green for prices/success */
        --nutriverse-warning: #f39c12; /* Orange for warnings */
        --nutriverse-info: #1abc9c; /* Teal for info */
        --nutriverse-danger: #e74c3c; /* Red for expired/danger */
        --nutriverse-light: #ecf0f1; /* Light background */
    }

    body {
        background-color: var(--nutriverse-light);
        font-family: 'Poppins', sans-serif; /* Modern, clean font */
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #e0f2f7 0%, #c9e6ed 100%);
        padding: 6rem 0;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-top: 2rem;
    }

    .hero-section h1 {
        color: var(--nutriverse-dark);
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .hero-section .lead {
        color: var(--nutriverse-secondary);
        font-size: 1.15rem;
    }

    .search-form-container {
        background-color: #fff;
        border-radius: 50px;
        padding: 8px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .search-form-container:focus-within {
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .search-form-container .form-control {
        border: none;
        box-shadow: none;
        padding: 1rem 1.5rem;
        font-size: 1.05rem;
        border-radius: 50px 0 0 50px; /* Rounded only on left */
    }

    .search-form-container .form-control::placeholder {
        color: #b0c4de;
    }

    .search-form-container .btn-primary {
        background-color: var(--nutriverse-primary);
        border-color: var(--nutriverse-primary);
        border-radius: 50px; /* Fully rounded button */
        padding: 0.8rem 2rem;
        font-size: 1.05rem;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .search-form-container .btn-primary:hover {
        background-color: #2980b9;
        border-color: #2980b9;
        transform: translateY(-1px);
    }

    /* Product Grid */
    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    }

    .product-image {
        height: 220px; /* Slightly taller images for better visual */
        object-fit: cover;
        width: 100%;
        border-bottom: 1px solid #f0f0f0;
    }

    .product-image-placeholder {
        height: 220px;
        background-color: #f5f5f5;
        color: #bbb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .card-body {
        padding: 1.8rem;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        color: var(--nutriverse-dark);
        font-weight: 600;
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }

    .card-text.category {
        color: var(--nutriverse-primary);
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
    }

    .card-text.description-clamp {
        color: var(--nutriverse-secondary);
        font-size: 0.95rem;
        line-height: 1.5;
        -webkit-line-clamp: 3; /* Limit to 3 lines */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 1.25rem;
    }

    .price-stock-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .price-stock-info .price {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--nutriverse-success);
    }

    .badge {
        padding: 0.6em 0.9em;
        font-size: 0.85em;
        border-radius: 50px;
        font-weight: 600;
    }

    .badge.bg-warning-custom { /* Custom class for warning with better contrast */
        background-color: #fef0cd;
        color: #d17a00;
    }

    .badge.bg-info-custom { /* Custom class for info with better contrast */
        background-color: #d4f2ee;
        color: #16a085;
    }

    .expiry-info {
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    .expiry-info.text-danger {
        color: var(--nutriverse-danger) !important;
        font-weight: 600;
    }

    .expiry-info.text-warning {
        color: var(--nutriverse-warning) !important;
        font-weight: 600;
    }

    .btn-add-to-cart {
        background-color: var(--nutriverse-primary);
        border-color: var(--nutriverse-primary);
        padding: 0.9rem 1.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-add-to-cart:hover {
        background-color: #2980b9;
        border-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
    }

    .btn-add-to-cart:disabled {
        background-color: #cccccc;
        border-color: #cccccc;
        cursor: not-allowed;
        opacity: 0.7;
        transform: none;
        box-shadow: none;
    }

    /* No Supplements Found */
    .alert-info-custom {
        background-color: #eaf6fa;
        border-color: #d0e7f0;
        color: #3498db;
        border-radius: 10px;
        padding: 2.5rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .alert-info-custom .alert-heading {
        color: var(--nutriverse-dark);
        font-weight: 700;
    }

    .alert-info-custom p {
        color: var(--nutriverse-secondary);
    }

    .alert-info-custom .bi {
        font-size: 4rem;
        color: #aed6f1;
        margin-top: 1rem;
    }

    /* Animations */
    .animate__fadeInUp {
        animation-duration: 0.6s;
        animation-fill-mode: both;
    }

    /* For staggering effect */
    .product-grid-container .col {
        animation-fill-mode: both;
    }

    /* Poppins Font Import - Add this to your main layout's <head> or directly here */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

</style>

<div class="container py-5">
    {{-- Hero Section for Search --}}
    <div class="row justify-content-center mb-5 hero-section">
        <div class="col-md-9 text-center">
            <div class="mb-5">
                <h1 class="display-4 fw-bold">Discover Your <span class="text-nutriverse-primary">Perfect Supplements</span></h1>
                <p class="lead text-nutriverse-secondary">Explore a wide range of high-quality supplements tailored to boost your health and wellness journey.</p>
            </div>
            <form action="{{ route('supplements.index') }}" method="GET">
                <div class="input-group search-form-container">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search supplements by name, category, or description...">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search me-2"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <hr class="my-5 opacity-25">

    {{-- Product Grid --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 product-grid-container">
        @forelse($supplements as $supplement)
            <div class="col">
                <div class="card h-100 animate__animated animate__fadeInUp" style="--animate-delay: {{ $loop->index * 0.08 }}s;">
                    @if($supplement->image)
                        <img src="{{ asset('storage/' . $supplement->image) }}" class="card-img-top product-image" alt="{{ $supplement->name }}">
                    @else
                        <div class="product-image-placeholder">
                            <i class="bi bi-image fs-1"></i> No Image
                        </div>
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $supplement->name }}</h5>
                        <p class="card-text category"><strong>Category:</strong> {{ $supplement->category }}</p>
                        <p class="card-text description-clamp">{{ Str::limit($supplement->description ?? 'No description available.', 120) }}</p>

                        <div class="price-stock-info">
                            <span class="price">Rp{{ number_format($supplement->price, 2, ',', '.') }}</span>
                            <span class="badge {{ $supplement->stock <= 5 ? 'bg-warning-custom' : 'bg-info-custom' }}">
                                {{ $supplement->stock }} in stock
                            </span>
                        </div>

                        @if($supplement->expired_at)
                            @php
                                $expiryDate = \Carbon\Carbon::parse($supplement->expired_at);
                                $isExpired = $expiryDate->isPast();
                                $daysUntilExpiry = now()->diffInDays($expiryDate, false);
                            @endphp
                            <p class="card-text expiry-info {{ $isExpired ? 'text-danger fw-bold' : ($daysUntilExpiry <= 30 ? 'text-warning' : 'text-muted') }}">
                                <i class="bi bi-calendar-x me-1"></i> Expires on: {{ $expiryDate->format('d M Y') }}
                                @if($isExpired)
                                    <span class="fw-bold">(Expired!)</span>
                                @elseif($daysUntilExpiry <= 30)
                                    <span class="fw-bold">({{ $daysUntilExpiry }} days left!)</span>
                                @endif
                            </p>
                        @endif

                        <div class="mt-auto pt-3">
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="supplement_id" value="{{ $supplement->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary w-100 btn-add-to-cart" {{ $supplement->stock <= 0 || (isset($isExpired) && $isExpired) ? 'disabled' : '' }}>
                                    @if ($supplement->stock <= 0)
                                        <i class="bi bi-x-circle me-2"></i> Out of Stock
                                    @elseif (isset($isExpired) && $isExpired)
                                        <i class="bi bi-archive me-2"></i> Product Expired
                                    @else
                                        <i class="bi bi-cart-plus me-2"></i> Add to Cart
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info-custom text-center" role="alert">
                    <h4 class="alert-heading">No Supplements Found!</h4>
                    <p>It seems there are no supplements matching your search or criteria. Try a different search term or check back later.</p>
                    <i class="bi bi-emoji-frown"></i>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-5">
        {{ $supplements->withQueryString()->links('pagination::bootstrap-5') }} {{-- Using Bootstrap 5 pagination style --}}
    </div>
</div>

{{-- JavaScript for staggered animations (can be placed directly here) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productCards = document.querySelectorAll('.product-grid-container .col .card');
        productCards.forEach((card, index) => {
            card.style.setProperty('--animate-delay', `${index * 0.08}s`); // Stagger delay
        });
    });
</script>
@endsection