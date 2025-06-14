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

    /* Main Container - Wider Layout */
    .container-ultra-wide {
        max-width: 1600px; /* Even wider, pushing the limits for large screens */
        margin: 40px auto;
        padding: 30px; /* Slightly more internal padding */
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1); /* Deeper, softer shadow */
        border-radius: 25px; /* More pronounced rounded corners */
        background-color: #ffffff;
    }

    /* Header Section */
    .header-section {
        text-align: center;
        margin-bottom: 60px; /* More space below header */
    }

    .header-section h2 {
        font-family: 'Montserrat', sans-serif;
        font-size: 4rem; /* Even larger, more dominant heading */
        font-weight: 800;
        color: #28a745;
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.15); /* Stronger text shadow */
        margin-bottom: 20px;
        letter-spacing: -1px; /* Tighter letter spacing for impact */
    }

    .header-section p {
        font-size: 1.35rem; /* Larger lead paragraph */
        color: #6c757d;
        line-height: 1.7;
    }

    /* Session Messages */
    .alert-custom {
        padding: 18px 25px; /* More generous padding */
        border-radius: 12px;
        margin-bottom: 30px; /* More space below alerts */
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 600;
        animation-duration: 0.6s;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); /* Subtle shadow for alerts */
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
        font-size: 1.6rem; /* Slightly larger close button */
        cursor: pointer;
        color: inherit;
        opacity: 0.7;
        transition: opacity 0.2s ease;
    }

    .close-btn-custom:hover {
        opacity: 1;
    }

    /* Empty Cart State */
    .empty-cart-message {
        background-color: #e6ffed;
        border-radius: 20px; /* More rounded */
        padding: 70px 40px; /* More padding */
        text-align: center;
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.15); /* Stronger greenish shadow */
    }

    .empty-cart-message h4 {
        font-family: 'Montserrat', sans-serif;
        font-size: 3rem; /* Larger empty cart heading */
        font-weight: 700;
        color: #28a745;
        margin-bottom: 25px;
    }

    .empty-cart-message p {
        font-size: 1.25rem;
        color: #388e3c;
        margin-bottom: 20px;
    }

    .empty-cart-message hr {
        border-top: 3px solid #5cb85c; /* Thicker line */
        width: 100px; /* Wider line */
        margin: 40px auto;
    }

    .empty-cart-button {
        display: inline-block;
        background-color: #28a745;
        color: white;
        padding: 20px 45px; /* Larger button */
        border-radius: 50px;
        text-decoration: none;
        font-size: 1.3rem; /* Larger font */
        font-weight: 600;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 10px 20px rgba(40, 167, 69, 0.35); /* Stronger shadow */
    }

    .empty-cart-button:hover {
        background-color: #218838;
        transform: translateY(-7px); /* More pronounced lift */
        box-shadow: 0 15px 30px rgba(40, 167, 69, 0.45);
    }

    /* Cart Items & Checkout Section Layout */
    .flex-row-responsive {
        display: flex;
        flex-wrap: wrap;
        gap: 50px; /* Increased space between main columns */
        justify-content: space-between; /* Distribute space more evenly */
    }

    .col-left {
        flex: 3; /* Cart items take even more space */
        min-width: 68%; /* Ensure it's not too small */
    }

    .col-right {
        flex: 1; /* Checkout takes less space */
        min-width: 28%; /* Ensure it's not too small */
    }

    @media (max-width: 1400px) { /* Adjust for smaller large screens */
        .col-left {
            min-width: 60%; /* Slightly reduce left column on smaller large screens */
        }
        .col-right {
            min-width: 35%; /* Slightly increase right column */
        }
    }

    @media (max-width: 992px) { /* Tablet and smaller */
        .col-left, .col-right {
            min-width: 100%;
            flex: none; /* Disable flex growth on smaller screens */
        }
        .flex-row-responsive {
            gap: 30px; /* Reduce gap on smaller screens */
        }
    }

    .card-custom {
        background-color: #ffffff;
        padding: 35px; /* More padding inside cards */
        border-radius: 20px; /* More rounded */
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07); /* Stronger, more elegant shadow */
        animation-duration: 0.9s;
    }

    .card-custom h3 {
        font-family: 'Montserrat', sans-serif;
        font-size: 2rem; /* Larger heading for card */
        color: #343a40;
        padding-bottom: 20px; /* More space below heading */
        border-bottom: 2px solid #e9ecef; /* Thicker border */
        margin-bottom: 30px;
    }

    .table-responsive-custom {
        overflow-x: auto;
        margin-bottom: 30px; /* More space below table */
    }

    .product-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px; /* Add vertical spacing between rows */
        margin-bottom: 25px;
    }

    .product-table thead {
        background-color: #e9f5ee;
        color: #28a745;
        font-weight: 700;
        font-size: 1.1rem; /* Slightly larger header font */
    }

    .product-table th {
        padding: 18px 25px; /* More padding in table headers */
        text-align: left;
        border-bottom: 3px solid #28a745; /* Even stronger border */
    }

    .product-table tbody tr {
        background-color: #ffffff; /* Explicitly set row background */
        border-bottom: 1px solid #e0e0e0; /* Subtle row separation */
        border-radius: 10px; /* Rounded corners for table rows */
        transition: all 0.3s ease-in-out;
    }

    .product-table tbody tr:last-child {
        border-bottom: none;
    }

    .product-table tbody tr:hover {
        background-color: #f0fff4; /* Lighter, more noticeable hover effect */
        transform: translateY(-3px); /* Subtle lift on hover */
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); /* Shadow on hover */
    }

    .product-table td {
        padding: 18px 25px; /* More padding in table cells */
        vertical-align: middle;
        white-space: nowrap; /* Prevent text wrapping in cells if possible */
    }

    .product-image {
        width: 120px; /* Larger image size */
        height: 120px;
        object-fit: contain; /* Use 'contain' to show full image without cropping */
        background-color: #f8f8f8; /* Light background for images */
        border-radius: 12px; /* Nicely rounded corners */
        border: 2px solid #a8e6cf; /* Lighter, softer green border */
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out, border-color 0.3s ease;
    }

    .product-image:hover {
        transform: scale(1.03); /* Slight zoom on hover */
        border-color: #28a745; /* Darker green border on hover */
    }

    .product-name {
        font-weight: 700;
        color: #333;
        font-size: 1.1rem;
    }

    .product-price {
        color: #007bff;
        font-weight: 600;
        font-size: 1.05rem;
    }

    .subtotal-price {
        font-weight: 800;
        color: #ff5722;
        font-size: 1.1rem;
    }

    /* Quantity Input Group */
    .quantity-control {
        display: flex;
        align-items: center;
        width: 140px; /* Slightly wider control */
        margin: 0 auto;
        border: 2px solid #cceeff; /* Lighter blue border */
        border-radius: 30px; /* More rounded */
        overflow: hidden;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
    }

    .quantity-button {
        background-color: #e0f2f7; /* Light blue background */
        border: none;
        padding: 10px 15px; /* More padding */
        cursor: pointer;
        font-size: 1.2rem; /* Larger font */
        color: #007bff; /* Blue color for buttons */
        transition: background-color 0.2s ease, color 0.2s ease, transform 0.1s ease;
    }

    .quantity-button:hover {
        background-color: #cceeff;
        color: #0056b3;
        transform: scale(1.05); /* Slight scale on hover */
    }

    .quantity-button:active {
        transform: scale(0.95); /* Click feedback */
    }

    .quantity-input {
        flex-grow: 1;
        width: 60px; /* Adjust width inside flex */
        text-align: center;
        border: none;
        font-size: 1.1rem; /* Larger input font */
        font-weight: 600;
        color: #495057;
        padding: 10px 0;
        background-color: #ffffff; /* White background for input */
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
        padding: 12px 20px; /* Larger padding */
        border-radius: 35px; /* More rounded */
        cursor: pointer;
        font-size: 1rem; /* Slightly larger font */
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.25); /* Stronger shadow */
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px; /* Space between icon and text */
    }

    .remove-button:hover {
        background-color: #c82333;
        transform: translateY(-3px); /* More pronounced lift */
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.35);
    }

    /* Total and Update Cart */
    .total-section {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        background-color: #e0ffe6;
        padding: 30px 40px; /* More padding */
        border-radius: 45px; /* Even more rounded */
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.2); /* Stronger shadow */
        margin-top: 50px; /* More space from table */
    }

    .total-section h4 {
        font-family: 'Montserrat', sans-serif;
        font-size: 2.2rem; /* Larger total text */
        color: #333;
        margin-bottom: 0;
    }

    .total-section .total-amount {
        font-size: 3.5rem; /* Very large total amount */
        font-weight: 800;
        color: #28a745;
        margin-left: 25px;
    }

    .update-cart-button {
        background-color: #28a745;
        color: white;
        padding: 20px 45px; /* Larger button */
        border: none;
        border-radius: 50px;
        font-size: 1.3rem; /* Larger font */
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 10px 20px rgba(40, 167, 69, 0.35);
        display: flex; /* Flex to center icon and text */
        align-items: center;
        gap: 10px; /* Space between icon and text */
    }

    .update-cart-button:hover {
        background-color: #218838;
        transform: translateY(-7px);
        box-shadow: 0 15px 30px rgba(40, 167, 69, 0.45);
    }

    /* Checkout Section */
    .form-label-custom {
        font-weight: 700;
        color: #28a745;
        margin-bottom: 10px; /* More space below label */
        display: block;
        font-size: 1.05rem;
    }

    .form-input-custom {
        width: 100%;
        padding: 16px 22px; /* More padding */
        border: 2px solid #90ee90; /* Lighter green border */
        border-radius: 12px; /* More rounded */
        font-size: 1.05rem; /* Slightly larger font */
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
        box-shadow: 0 0 0 5px rgba(40, 167, 69, 0.3); /* Stronger custom focus ring */
    }

    .error-message {
        color: #dc3545;
        font-size: 0.9rem;
        margin-top: 6px;
        font-weight: 500;
    }

    .checkout-button {
        background-color: #28a745;
        color: white;
        padding: 22px 30px; /* Larger button */
        border: none;
        border-radius: 50px;
        width: 100%;
        font-size: 1.4rem; /* Larger font */
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 12px 25px rgba(40, 167, 69, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px; /* Space between icon and text */
    }

    .checkout-button:hover {
        background-color: #218838;
        transform: translateY(-7px);
        box-shadow: 0 18px 35px rgba(40, 167, 69, 0.5);
    }

    /* Spacing utilities (updated for consistency) */
    .mb-15 { margin-bottom: 15px; }
    .mb-25 { margin-bottom: 25px; }
    .mb-30 { margin-bottom: 30px; }
    .mb-40 { margin-bottom: 40px; }
    .mb-50 { margin-bottom: 50px; }
    .mt-40 { margin-top: 40px; }
    .mt-50 { margin-top: 50px; }
    .p-10 { padding: 10px; }
    .px-20 { padding-left: 20px; padding-right: 20px; }
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