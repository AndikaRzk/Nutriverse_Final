@extends('layouts.layout') {{-- Ganti dengan layout sesuai projectmu --}}

@section('content')
<div class="container py-5">
    {{-- Hero Section for Search --}}
    <div class="row justify-content-center mb-5 mt-5">
        <div class="col-md-8">
            <div class="text-center mb-4">
                <h1 class="display-4 fw-bold text-nutriverse-dark">Discover Your Supplements</h1>
                <p class="lead text-muted">Find the perfect supplements to boost your health and wellness.</p>
            </div>
            <form action="{{ route('supplements.index') }}" method="GET" class="shadow-sm rounded-pill p-1 bg-white">
                <div class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0 rounded-pill ps-4" placeholder="Search supplements by name, category, or description...">
                    <button class="btn btn-primary rounded-pill pe-4" type="submit">
                        <i class="bi bi-search me-2"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <hr class="my-5">

    {{-- Product Grid --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse($supplements as $supplement)
            <div class="col">
                <div class="card h-100 shadow-hover border-0 rounded-3 overflow-hidden animate__animated animate__fadeInUp">
                    @if($supplement->image)
                        <img src="{{ asset('storage/' . $supplement->image) }}" class="card-img-top product-image" alt="{{ $supplement->name }}">
                    @else
                        <div class="product-image bg-light text-muted d-flex align-items-center justify-content-center fs-5 rounded-top">
                            No Image Available
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="card-title fw-bold text-dark mb-2">{{ $supplement->name }}</h5>
                        <p class="card-text text-primary mb-1 text-uppercase small"><strong>Category:</strong> {{ $supplement->category }}</p>
                        <p class="card-text text-secondary mb-3 description-clamp">{{ Str::limit($supplement->description ?? 'No description available.', 120) }}</p>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fs-5 fw-bold text-success">Rp{{ number_format($supplement->price, 2, ',', '.') }}</span>
                            <span class="badge {{ $supplement->stock <= 5 ? 'bg-warning text-dark' : 'bg-info' }}">{{ $supplement->stock }} in stock</span>
                        </div>

                        @if($supplement->expired_at)
                            @php
                                $expiryDate = \Carbon\Carbon::parse($supplement->expired_at);
                                $isExpired = $expiryDate->isPast();
                                $daysUntilExpiry = now()->diffInDays($expiryDate, false);
                            @endphp
                            <p class="card-text small {{ $isExpired ? 'text-danger fw-bold' : ($daysUntilExpiry <= 30 ? 'text-warning' : 'text-muted') }}">
                                <i class="bi bi-calendar-x me-1"></i> Expires on: {{ $expiryDate->format('d M Y') }}
                                @if($isExpired)
                                    (Expired!)
                                @elseif($daysUntilExpiry <= 30)
                                    ({{ $daysUntilExpiry }} days left!)
                                @endif
                            </p>
                        @endif

                        <div class="mt-auto pt-3">
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="supplement_id" value="{{ $supplement->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill animate__animated animate__pulse" {{ $supplement->stock <= 0 || (isset($isExpired) && $isExpired) ? 'disabled' : '' }}>
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
                <div class="alert alert-info text-center" role="alert">
                    <h4 class="alert-heading">No Supplements Found!</h4>
                    <p>It seems there are no supplements matching your search or criteria. Try a different search term or check back later.</p>
                    <i class="bi bi-emoji-frown fs-1"></i>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-5">
        {{ $supplements->withQueryString()->links('pagination::bootstrap-5') }} {{-- Using Bootstrap 5 pagination style --}}
    </div>
</div>

{{-- Custom CSS for enhancements --}}
@push('styles')
<style>
    body {
        background-color: #f8f9fa; /* Light gray background */
    }
    .shadow-hover {
        transition: all 0.3s ease-in-out;
    }
    .shadow-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
    }
    .product-image {
        height: 200px; /* Slightly taller images */
        object-fit: cover;
        width: 100%;
        border-bottom: 1px solid #eee; /* Subtle separator */
    }
    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Distribute content evenly */
    }
    .card-title {
        color: #343a40; /* Darker title for better contrast */
    }
    .text-primary {
        color: #007bff !important; /* Ensure Bootstrap primary color */
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    /* Improve search bar appearance */
    .input-group .form-control {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }
    .input-group .btn {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }
    /* Text clamp for description */
    .description-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Limit to 3 lines */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    /* Animations using Animate.css */
    .animate__animated {
        animation-duration: 0.7s; /* Slightly faster animation */
    }
    .animate__fadeInUp {
        animation-delay: var(--delay); /* Use CSS variable for staggered animation */
    }
    .product-grid > .col {
        animation-fill-mode: both;
    }
</style>
@endpush

{{-- Push Animate.css to the head (if not already included in layout) --}}
@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush

{{-- Push JavaScript for staggered animations (optional, but nice touch) --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productCards = document.querySelectorAll('.animate__fadeInUp');
        productCards.forEach((card, index) => {
            card.style.setProperty('--delay', `${index * 0.1}s`); // Stagger delay
        });
    });
</script>
@endpush
@endsection