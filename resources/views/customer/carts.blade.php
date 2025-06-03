@extends('layouts.layout')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4 display-4 fw-bold text-success">Your Shopping Cart</h2>
    <p class="text-center text-muted mb-5 lead">Please review your order before proceeding to payment.</p>

    {{-- Session messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{-- End Session messages --}}

    @if($cartItems->isEmpty())
        <div class="alert alert-success text-center py-5 shadow-lg rounded-3 animate__animated animate__fadeIn">
            <h4 class="alert-heading display-5 fw-bold text-success">Your Cart is Still Empty!</h4>
            <p class="lead text-success">It seems you haven't added any items to your cart yet.</p>
            <hr class="my-4 border-success">
            <p class="mb-0 fs-5 text-success">Start browsing our products and fill your cart now.</p>
            <a href="{{ url('/supplements') }}" class="btn btn-success btn-lg mt-4 animate__animated animate__pulse animate__infinite">
                Start Shopping Now <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    @else
        <div class="row gx-5">
            <div class="col-lg-8">
                <form action="{{ route('cart.updateQuantity') }}" method="POST" class="bg-white p-4 shadow-lg rounded-3 mb-4 animate__animated animate__fadeInUp">
                    @csrf
                    <h3 class="mb-4 text-secondary border-bottom pb-3">Cart Item Details</h3>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-success">
                                <tr>
                                    <th scope="col" class="text-center">Image</th>
                                    <th scope="col">Supplement Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Price</th>
                                    <th scope="col" class="text-center">Quantity</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($cartItems as $item)
                                    @php
                                        $subtotal = $item->supplement->price * $item->quantity;
                                        $total += $subtotal;
                                    @endphp
                                    <tr class="animate__animated animate__fadeIn">
                                        <td class="text-center">
                                            @if($item->supplement->image)
                                                <img src="{{ asset('storage/' . $item->supplement->image) }}" alt="{{ $item->supplement->name }}" class="img-fluid rounded-3 shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" alt="No Image" class="img-fluid rounded-3 shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                                            @endif
                                        </td>
                                        <td class="fw-bold text-success">{{ $item->supplement->name }}</td>
                                        <td>{{ $item->supplement->category }}</td>
                                        <td>Rp{{ number_format($item->supplement->price, 0, ',', '.') }}</td>
                                        <td>
                                            <div class="input-group input-group-sm quantity-control mx-auto" style="width: 120px;">
                                                <input type="number" name="quantities[{{ $item->supplement_id }}]" value="{{ $item->quantity }}" min="0" class="form-control text-center quantity-input border-success">
                                            </div>
                                        </td>
                                        <td class="fw-bold text-primary">Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('cart.remove') }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this item from the cart?')" class="d-inline-block">
                                                @csrf
                                                <input type="hidden" name="supplement_id" value="{{ $item->supplement_id }}">
                                                <button type="submit" class="btn btn-sm btn-danger rounded-pill shadow-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove Item">
                                                    <i class="bi bi-trash"></i> Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-5 p-3 bg-light rounded-3 shadow-sm">
                        <h4 class="mb-3 mb-md-0">Total: <span class="text-success display-6 fw-bold">Rp{{ number_format($total, 0, ',', '.') }}</span></h4>
                        <button type="submit" class="btn btn-success btn-lg px-5 py-3 rounded-pill shadow">
                            <i class="bi bi-arrow-clockwise me-2"></i> Update Cart
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-lg-4">
                <div class="bg-white p-4 shadow-lg rounded-3 animate__animated animate__fadeInRight">
                    <h3 class="mb-4 text-secondary border-bottom pb-3">Proceed to Checkout</h3>
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="delivery_address" class="form-label fw-bold text-success">Delivery Address</label>
                            <textarea class="form-control border-success" id="delivery_address" name="delivery_address" rows="4" required maxlength="255" placeholder="Enter your full address">{{ old('delivery_address') }}</textarea>
                            @error('delivery_address')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="delivery_phone" class="form-label fw-bold text-success">Phone Number</label>
                            <input type="tel" class="form-control border-success" id="delivery_phone" name="delivery_phone" required maxlength="20" placeholder="Example: 081234567890" value="{{ old('delivery_phone') }}">
                            @error('delivery_phone')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label fw-bold text-success">Additional Notes (Optional)</label>
                            <textarea class="form-control border-success" id="notes" name="notes" rows="3" maxlength="500" placeholder="Example: Please leave it with the neighbor if no one is home."></textarea>
                            @error('notes')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100 btn-lg rounded-pill shadow-lg mt-3">
                            <i class="bi bi-bag-check me-2"></i> Place Order & Proceed to Payment
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
            const decrementButton = control.querySelector('.decrement');
            const incrementButton = control.querySelector('.increment');
            const quantityInput = control.querySelector('.quantity-input');

            incrementButton?.addEventListener('click', function () {
                quantityInput.stepUp();
            });

            decrementButton?.addEventListener('click', function () {
                if (quantityInput.value > 0) {
                    quantityInput.stepDown();
                }
            });

            quantityInput.addEventListener('change', function() {
                if (parseInt(quantityInput.value) < 0) {
                    quantityInput.value = 0;
                }
            });
        });

        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection
