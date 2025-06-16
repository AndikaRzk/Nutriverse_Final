@extends('layouts.layout')

@section('content')

<style>
    /* Global Styles & Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Open+Sans:wght@400;600&display=swap');

body {
    font-family: 'Open Sans', sans-serif;
    background-color: #f0f2f5;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Main Container - Wider Layout (Adjusted) */
.container-ultra-wide {
    max-width: 1200px; /* Reduced from 1600px */
    margin: 30px auto; /* Slightly less margin */
    padding: 25px; /* Reduced from 30px */
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* Slightly lighter shadow */
    border-radius: 20px; /* Slightly less rounded */
    background-color: #ffffff;
}

/* Header Section (Adjusted) */
.header-section {
    text-align: center;
    margin-bottom: 40px; /* Reduced from 60px */
}

.header-section h2 {
    font-family: 'Montserrat', sans-serif;
    font-size: 3rem; /* Reduced from 4rem */
    font-weight: 800;
    color: #28a745;
    text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.1); /* Lighter text shadow */
    margin-bottom: 15px; /* Reduced from 20px */
    letter-spacing: -0.5px; /* Slightly less tight */
}

.header-section p {
    font-size: 1.1rem; /* Reduced from 1.35rem */
    color: #6c757d;
    line-height: 1.6; /* Slightly reduced line height */
}

/* Session Messages (Adjusted) */
.alert-custom {
    padding: 15px 20px; /* Reduced from 18px 25px */
    border-radius: 10px; /* Slightly less rounded */
    margin-bottom: 20px; /* Reduced from 30px */
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-weight: 600;
    animation-duration: 0.6s;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05); /* Lighter shadow */
}

.alert-success-custom {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger-custom {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.close-btn-custom {
    background: none;
    border: none;
    font-size: 1.3rem; /* Reduced from 1.6rem */
    cursor: pointer;
    color: inherit;
    opacity: 0.7;
    transition: opacity 0.2s ease;
}

.close-btn-custom:hover {
    opacity: 1;
}

/* Empty Cart State (Adjusted) */
.empty-cart-message {
    background-color: #e6ffed;
    border-radius: 15px; /* Reduced from 20px */
    padding: 50px 30px; /* Reduced from 70px 40px */
    text-align: center;
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.1); /* Lighter shadow */
}

.empty-cart-message h4 {
    font-family: 'Montserrat', sans-serif;
    font-size: 2.2rem; /* Reduced from 3rem */
    font-weight: 700;
    color: #28a745;
    margin-bottom: 20px; /* Reduced from 25px */
}

.empty-cart-message p {
    font-size: 1.1rem; /* Reduced from 1.25rem */
    color: #388e3c;
    margin-bottom: 15px; /* Reduced from 20px */
}

.empty-cart-message hr {
    border-top: 2px solid #5cb85c; /* Reduced from 3px */
    width: 80px; /* Reduced from 100px */
    margin: 30px auto; /* Reduced from 40px */
}

.empty-cart-button {
    display: inline-block;
    background-color: #28a745;
    color: white;
    padding: 15px 30px; /* Reduced from 20px 45px */
    border-radius: 40px; /* Slightly less rounded */
    text-decoration: none;
    font-size: 1.1rem; /* Reduced from 1.3rem */
    font-weight: 600;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 8px 15px rgba(40, 167, 69, 0.25); /* Lighter shadow */
}

.empty-cart-button:hover {
    background-color: #218838;
    transform: translateY(-5px); /* Reduced lift */
    box-shadow: 0 10px 20px rgba(40, 167, 69, 0.35); /* Lighter shadow */
}

/* Cart Items & Checkout Section Layout (Adjusted) */
.flex-row-responsive {
    display: flex;
    flex-wrap: wrap;
    gap: 30px; /* Reduced from 50px */
    justify-content: space-between;
}

.col-left {
    flex: 3;
    min-width: 65%; /* Adjusted percentage */
}

.col-right {
    flex: 1;
    min-width: 30%; /* Adjusted percentage */
}

@media (max-width: 1400px) {
    .col-left {
        min-width: 60%;
    }
    .col-right {
        min-width: 35%;
    }
}

@media (max-width: 992px) {
    .col-left, .col-right {
        min-width: 100%;
        flex: none;
    }
    .flex-row-responsive {
        gap: 20px; /* Reduced gap */
    }
}

.card-custom {
    background-color: #ffffff;
    padding: 25px; /* Reduced from 35px */
    border-radius: 15px; /* Reduced from 20px */
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05); /* Lighter shadow */
    animation-duration: 0.9s;
}

.card-custom h3 {
    font-family: 'Montserrat', sans-serif;
    font-size: 1.6rem; /* Reduced from 2rem */
    color: #343a40;
    padding-bottom: 15px; /* Reduced from 20px */
    border-bottom: 1px solid #e9ecef; /* Reduced from 2px */
    margin-bottom: 20px; /* Reduced from 30px */
}

.table-responsive-custom {
    overflow-x: auto;
    margin-bottom: 20px; /* Reduced from 30px */
}

.product-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px; /* Reduced vertical spacing */
    margin-bottom: 20px; /* Reduced from 25px */
}

.product-table thead {
    background-color: #e9f5ee;
    color: #28a745;
    font-weight: 700;
    font-size: 1rem; /* Reduced from 1.1rem */
}

.product-table th {
    padding: 15px 20px; /* Reduced from 18px 25px */
    text-align: left;
    border-bottom: 2px solid #28a745; /* Reduced from 3px */
}

.product-table tbody tr {
    background-color: #ffffff;
    border-bottom: 1px solid #e0e0e0;
    border-radius: 8px; /* Slightly less rounded */
    transition: all 0.3s ease-in-out;
}

.product-table tbody tr:last-child {
    border-bottom: none;
}

.product-table tbody tr:hover {
    background-color: #f0fff4;
    transform: translateY(-2px); /* Reduced lift */
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03); /* Lighter shadow */
}

.product-table td {
    padding: 15px 20px; /* Reduced from 18px 25px */
    vertical-align: middle;
    white-space: nowrap;
}

.product-image {
    width: 90px; /* Reduced from 120px */
    height: 90px; /* Reduced from 120px */
    object-fit: contain;
    background-color: #f8f8f8;
    border-radius: 8px; /* Reduced from 12px */
    border: 1px solid #a8e6cf; /* Reduced from 2px */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08); /* Lighter shadow */
    transition: transform 0.3s ease-in-out, border-color 0.3s ease;
}

.product-image:hover {
    transform: scale(1.02); /* Reduced zoom */
    border-color: #28a745;
}

.product-name {
    font-weight: 700;
    color: #333;
    font-size: 1rem; /* Reduced from 1.1rem */
}

.product-price {
    color: #007bff;
    font-weight: 600;
    font-size: 1rem; /* Reduced from 1.05rem */
}

.subtotal-price {
    font-weight: 800;
    color: #ff5722;
    font-size: 1rem; /* Reduced from 1.1rem */
}

/* Quantity Input Group (Adjusted) */
.quantity-control {
    display: flex;
    align-items: center;
    width: 120px; /* Reduced from 140px */
    margin: 0 auto;
    border: 1px solid #cceeff; /* Reduced from 2px */
    border-radius: 25px; /* Slightly less rounded */
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06); /* Lighter shadow */
}

.quantity-button {
    background-color: #e0f2f7;
    border: none;
    padding: 8px 12px; /* Reduced from 10px 15px */
    cursor: pointer;
    font-size: 1.1rem; /* Reduced from 1.2rem */
    color: #007bff;
    transition: background-color 0.2s ease, color 0.2s ease, transform 0.1s ease;
}

.quantity-button:hover {
    background-color: #cceeff;
    color: #0056b3;
    transform: scale(1.03); /* Reduced scale */
}

.quantity-button:active {
    transform: scale(0.97); /* Reduced click feedback */
}

.quantity-input {
    flex-grow: 1;
    width: 50px; /* Reduced from 60px */
    text-align: center;
    border: none;
    font-size: 1rem; /* Reduced from 1.1rem */
    font-weight: 600;
    color: #495057;
    padding: 8px 0; /* Reduced from 10px */
    background-color: #ffffff;
    -moz-appearance: textfield;
}

.quantity-input::-webkit-outer-spin-button,
.quantity-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.remove-button {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 10px 18px; /* Reduced from 12px 20px */
    border-radius: 30px; /* Slightly less rounded */
    cursor: pointer;
    font-size: 0.95rem; /* Reduced from 1rem */
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(220, 53, 69, 0.15); /* Lighter shadow */
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px; /* Reduced gap */
}

.remove-button:hover {
    background-color: #c82333;
    transform: translateY(-2px); /* Reduced lift */
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.25); /* Lighter shadow */
}

/* Total and Update Cart (Adjusted) */
.total-section {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    background-color: #e0ffe6;
    padding: 25px 30px; /* Reduced from 30px 40px */
    border-radius: 35px; /* Slightly less rounded */
    box-shadow: 0 8px 20px rgba(40, 167, 69, 0.15); /* Lighter shadow */
    margin-top: 30px; /* Reduced from 50px */
}

.total-section h4 {
    font-family: 'Montserrat', sans-serif;
    font-size: 1.8rem; /* Reduced from 2.2rem */
    color: #333;
    margin-bottom: 0;
}

.total-section .total-amount {
    font-size: 2.8rem; /* Reduced from 3.5rem */
    font-weight: 800;
    color: #28a745;
    margin-left: 20px; /* Reduced from 25px */
}

.update-cart-button {
    background-color: #28a745;
    color: white;
    padding: 15px 30px; /* Reduced from 20px 45px */
    border: none;
    border-radius: 40px; /* Slightly less rounded */
    font-size: 1.1rem; /* Reduced from 1.3rem */
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 8px 15px rgba(40, 167, 69, 0.25); /* Lighter shadow */
    display: flex;
    align-items: center;
    gap: 8px; /* Reduced gap */
}

.update-cart-button:hover {
    background-color: #218838;
    transform: translateY(-5px); /* Reduced lift */
    box-shadow: 0 10px 20px rgba(40, 167, 69, 0.35); /* Lighter shadow */
}

/* Checkout Section (Adjusted) */
.form-label-custom {
    font-weight: 700;
    color: #28a745;
    margin-bottom: 8px; /* Reduced from 10px */
    display: block;
    font-size: 1rem; /* Reduced from 1.05rem */
}

.form-input-custom {
    width: 100%;
    padding: 12px 18px; /* Reduced from 16px 22px */
    border: 1px solid #90ee90; /* Reduced from 2px */
    border-radius: 10px; /* Reduced from 12px */
    font-size: 1rem; /* Reduced from 1.05rem */
    color: #343a40;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    box-sizing: border-box;
}

.form-input-custom::placeholder {
    color: #a0a0a0;
}

.form-input-custom:focus {
    outline: none;
    border-color: #28a745;
    box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.2); /* Lighter custom focus ring */
}

.error-message {
    color: #dc3545;
    font-size: 0.85rem; /* Slightly reduced */
    margin-top: 5px; /* Slightly reduced */
    font-weight: 500;
}

.checkout-button {
    background-color: #28a745;
    color: white;
    padding: 18px 25px; /* Reduced from 22px 30px */
    border: none;
    border-radius: 40px; /* Slightly less rounded */
    width: 100%;
    font-size: 1.2rem; /* Reduced from 1.4rem */
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 10px 20px rgba(40, 167, 69, 0.3); /* Lighter shadow */
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px; /* Reduced gap */
}

.checkout-button:hover {
    background-color: #218838;
    transform: translateY(-5px); /* Reduced lift */
    box-shadow: 0 12px 25px rgba(40, 167, 69, 0.4); /* Lighter shadow */
}

/* Spacing utilities (updated for consistency) */
.mb-15 { margin-bottom: 12px; } /* Adjusted */
.mb-25 { margin-bottom: 20px; } /* Adjusted */
.mb-30 { margin-bottom: 25px; } /* Adjusted */
.mb-40 { margin-bottom: 30px; } /* Adjusted */
.mb-50 { margin-bottom: 40px; } /* Adjusted */
.mt-40 { margin-top: 30px; } /* Adjusted */
.mt-50 { margin-top: 40px; } /* Adjusted */
.p-10 { padding: 8px; } /* Adjusted */
.px-20 { padding-left: 15px; padding-right: 15px; } /* Adjusted */
</style>

<div class="container-ultra-wide">
    <div class="header-section">
        <h2 class="animate__animated animate__fadeInDown">Your Shopping Cart</h2>
        <p class="animate__animated animate__fadeInUp">Please review your order before proceeding to payment.</p>
    </div>

    {{-- Session messages --}}
    @if(session('success'))
        <div class="alert-custom alert-success-custom animate__animated animate__bounceIn">
            <span>{{ session('success') }}</span>
            <button type="button" class="close-btn-custom" aria-label="Close">&times;</button>
        </div>
    @elseif(session('error'))
        <div class="alert-custom alert-danger-custom animate__animated animate__shakeX">
            <span>{{ session('error') }}</span>
            <button type="button" class="close-btn-custom" aria-label="Close">&times;</button>
        </div>
    @endif
    {{-- End Session messages --}}

    @if($cartItems->isEmpty())
        <div class="empty-cart-message animate__animated animate__fadeIn">
            <h4 class="animate__animated animate__bounce">Your Cart is Still Empty!</h4>
            <p>It seems you haven't added any items to your cart yet.</p>
            <hr>
            <p class="mb-40">Start Browse our products and fill your cart now.</p>
            <a href="{{ url('/supplements') }}" class="empty-cart-button animate__animated animate__pulse animate__infinite">
                Start Shopping Now <i class="bi bi-arrow-right" style="margin-left: 10px;"></i>
            </a>
        </div>
    @else
        <div class="flex-row-responsive">
            <div class="col-left">
                <form action="{{ route('cart.updateQuantity') }}" method="POST" class="card-custom animate__animated animate__fadeInLeft">
                    @csrf
                    <h3>Cart Item Details</h3>
                    <div class="table-responsive-custom">
                        <table class="product-table">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Image</th>
                                    <th>Supplement Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th style="text-align: center;">Quantity</th>
                                    <th>Subtotal</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($cartItems as $item)
                                    @php
                                        $subtotal = $item->supplement->price * $item->quantity;
                                        $total += $subtotal;
                                    @endphp
                                    <tr class="animate__animated animate__fadeInUp">
                                        <td style="text-align: center;">
                                            @if($item->supplement->image)
                                                <img src="{{ asset('storage/' . $item->supplement->image) }}" alt="{{ $item->supplement->name }}" class="product-image">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" alt="No Image" class="product-image">
                                            @endif
                                        </td>
                                        <td class="product-name">{{ $item->supplement->name }}</td>
                                        <td>{{ $item->supplement->category }}</td>
                                        <td class="product-price">Rp{{ number_format($item->supplement->price, 0, ',', '.') }}</td>
                                        <td>
                                            <div class="quantity-control">
                                                <button type="button" class="quantity-button decrement-btn" data-supplement-id="{{ $item->supplement_id }}">-</button>
                                                <input type="number" name="quantities[{{ $item->supplement_id }}]" value="{{ $item->quantity }}" min="0" class="quantity-input" data-supplement-id="{{ $item->supplement_id }}">
                                                <button type="button" class="quantity-button increment-btn" data-supplement-id="{{ $item->supplement_id }}">+</button>
                                            </div>
                                        </td>
                                        <td class="subtotal-price">Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                                        <td style="text-align: center;">
                                            <form action="{{ route('cart.remove') }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this item from the cart?')" style="display: inline-block;">
                                                @csrf
                                                <input type="hidden" name="supplement_id" value="{{ $item->supplement_id }}">
                                                <button type="submit" class="remove-button animate__animated animate__headShake animate__delay-1s">
                                                    <i class="bi bi-trash"></i> Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="total-section">
                        <h4>Total: <span class="total-amount">Rp{{ number_format($total, 0, ',', '.') }}</span></h4>
                        <button type="submit" class="update-cart-button animate__animated animate__pulse animate__infinite">
                            <i class="bi bi-arrow-clockwise"></i> Update Cart
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-right">
                <div class="card-custom animate__animated animate__fadeInRight">
                    <h3>Proceed to Checkout</h3>
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <div class="mb-25">
                            <label for="delivery_address" class="form-label-custom">Delivery Address <span style="color: #dc3545;">*</span></label>
                            <textarea class="form-input-custom" id="delivery_address" name="delivery_address" rows="4" required maxlength="255" placeholder="Enter your full address including street, city, postal code, and province">{{ old('delivery_address') }}</textarea>
                            @error('delivery_address')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-25">
                            <label for="delivery_phone" class="form-label-custom">Phone Number <span style="color: #dc3545;">*</span></label>
                            <input type="tel" class="form-input-custom" id="delivery_phone" name="delivery_phone" required maxlength="20" placeholder="Example: 081234567890" value="{{ old('delivery_phone') }}">
                            @error('delivery_phone')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-40">
                            <label for="notes" class="form-label-custom">Additional Notes (Optional)</label>
                            <textarea class="form-input-custom" id="notes" name="notes" rows="3" maxlength="500" placeholder="Example: Please leave it with the neighbor if no one is home or any specific delivery instructions."></textarea>
                            @error('notes')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="checkout-button animate__animated animate__heartBeat animate__infinite">
                            <i class="bi bi-bag-check"></i> Place Order & Proceed to Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity control for individual inputs
        document.querySelectorAll('.quantity-control').forEach(control => {
            const decrementButton = control.querySelector('.decrement-btn');
            const incrementButton = control.querySelector('.increment-btn');
            const quantityInput = control.querySelector('.quantity-input');

            incrementButton.addEventListener('click', function () {
                let currentValue = parseInt(quantityInput.value);
                if (isNaN(currentValue)) currentValue = 0; // Handle non-numeric input
                quantityInput.value = currentValue + 1;
            });

            decrementButton.addEventListener('click', function () {
                let currentValue = parseInt(quantityInput.value);
                if (isNaN(currentValue)) currentValue = 0; // Handle non-numeric input
                if (currentValue > 0) {
                    quantityInput.value = currentValue - 1;
                }
            });

            quantityInput.addEventListener('change', function() {
                // Ensure quantity is never negative or non-numeric
                if (parseInt(quantityInput.value) < 0 || isNaN(parseInt(quantityInput.value))) {
                    quantityInput.value = 0;
                }
            });
        });

        // Manual alert close functionality
        document.querySelectorAll('.close-btn-custom').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.alert-custom').style.display = 'none';
            });
        });

        // Add custom focus style for form inputs
        document.querySelectorAll('.form-input-custom').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.borderColor = '#28a745'; /* Green border on focus */
                this.style.boxShadow = '0 0 0 5px rgba(40, 167, 69, 0.3)'; /* Stronger custom focus ring */
            });
            input.addEventListener('blur', function() {
                this.style.borderColor = '#90ee90'; /* Default lighter green border */
                this.style.boxShadow = 'none'; /* Remove shadow on blur */
            });
        });
    });
</script>
@endsection