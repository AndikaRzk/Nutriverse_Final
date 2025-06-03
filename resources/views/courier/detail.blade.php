@extends('layouts.layout')

{{-- Removed @push('styles') and @endpush as per request --}}

@section('content')
<style>
    /* General Body & Container Styles */
    body {
        background-color: #eef5f9; /* Soft, light blue-gray background */
        font-family: 'Inter', sans-serif; /* Modern, clean font (you might need to link Google Fonts for this) */
        color: #333;
    }

    .container.mt-4 {
        padding: 40px; /* Generous padding around the content */
        max-width: 900px; /* Slightly wider container for better form layout */
        margin: 40px auto; /* Center the container with vertical margin */
        background-color: #ffffff;
        border-radius: 15px; /* Softer rounded corners for the main container */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* More pronounced, modern shadow */
    }

    /* Page Title Styling */
    .page-title {
        color: #2E7D32; /* Deep green for the main title */
        font-size: 2.5rem; /* Larger, more impactful title */
        font-weight: 700; /* Bold title */
        text-align: center;
        margin-bottom: 40px;
        position: relative; /* For the underline effect */
        padding-bottom: 15px;
    }

    .page-title::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        width: 80px; /* Short underline */
        height: 4px;
        background-color: #4CAF50; /* Vibrant green underline */
        border-radius: 2px;
    }

    /* Information Section */
    .info-card {
        background-color: #f8fcf9; /* Very light green background for info */
        border: 1px solid #d4edda; /* Subtle green border */
        border-radius: 12px;
        padding: 25px 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); /* Soft shadow for info card */
    }

    .info-card p {
        margin-bottom: 12px; /* More spacing between info lines */
        font-size: 1.1rem;
        line-height: 1.6;
        color: #555;
    }

    .info-card p:last-child {
        margin-bottom: 0; /* No margin after last paragraph */
    }

    .info-card strong {
        color: #2e7d32; /* Strong green for labels in info */
        font-weight: 600;
        min-width: 120px; /* Ensure labels align somewhat */
        display: inline-block; /* Allow min-width to work */
    }

    /* Form Group Styling */
    .form-group {
        margin-bottom: 25px; /* More space between form groups */
    }

    label {
        display: block; /* Label on its own line */
        margin-bottom: 8px; /* Space between label and input */
        font-weight: 600; /* Bolder labels */
        color: #388e3c; /* Green labels for form fields */
        font-size: 1.05rem;
    }

    input[type="text"],
    input[type="datetime-local"],
    input[type="file"],
    textarea,
    select {
        width: calc(100% - 24px); /* Account for padding */
        padding: 12px; /* More padding for larger inputs */
        border-radius: 8px; /* Softer input corners */
        border: 1px solid #dcdcdc; /* Lighter border */
        font-size: 1rem;
        color: #333;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.05); /* Subtle inner shadow */
    }

    input:focus,
    select:focus,
    textarea:focus {
        border-color: #4CAF50; /* Green border on focus */
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2); /* Soft green glow on focus */
        outline: none; /* Remove default outline */
    }

    textarea {
        resize: vertical; /* Allow vertical resizing */
        min-height: 80px; /* Minimum height for textarea */
    }

    /* File input specific styling (note: file inputs are hard to style consistently across browsers) */
    input[type="file"] {
        background-color: #f0f4f8; /* Different background for file input */
        padding: 10px; /* Slightly less padding */
    }

    /* Submit Button Styling */
    .btn-submit {
        display: block; /* Make button full width by default */
        width: auto; /* Auto width to fit content + padding */
        min-width: 180px; /* Minimum width for the button */
        margin: 30px auto 0 auto; /* Center button horizontally, space above */
        background-color: #28a745; /* Bootstrap-like success green */
        color: white;
        padding: 14px 30px; /* Generous padding for a clear button */
        border: none;
        border-radius: 10px; /* More rounded corners */
        cursor: pointer;
        font-size: 1.15rem; /* Larger font size */
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        box-shadow: 0 6px 15px rgba(40, 167, 69, 0.25); /* Stronger button shadow */
    }

    .btn-submit:hover {
        background-color: #218838; /* Darker green on hover */
        transform: translateY(-3px); /* Lift button on hover */
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.35); /* More pronounced shadow */
    }

    .btn-submit:active {
        transform: translateY(0); /* Press effect */
        box-shadow: 0 2px 5px rgba(40, 167, 69, 0.2);
    }

    /* Optional: Error message styling (if you add validation errors) */
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.9em;
        margin-top: 5px;
    }
</style>

<div class="container mt-4">
    <h2 class="page-title">Delivery Details - Order #{{ $delivery->order->order_number }}</h2>

    <div class="info-card mb-4">
        <p><strong>Shipping Address:</strong> {{ $delivery->order->delivery_address }}</p>
        <p><strong>Phone Number:</strong> {{ $delivery->order->delivery_phone }}</p>
        <p><strong>Current Status:</strong> {{ ucfirst($delivery->delivery_status) }}</p>
        <p><strong>Customer Notes:</strong> {{ $delivery->order->notes ?? '-' }}</p>
    </div>

    <form method="POST" action="{{ route('courier.deliveries.update', $delivery->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="delivery_status">Delivery Status</label>
            <select name="delivery_status" id="delivery_status" required>
                @foreach (['assigned', 'picking_up', 'on_the_way', 'delivered', 'failed'] as $status)
                    <option value="{{ $status }}" {{ $delivery->delivery_status === $status ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $status)) }} {{-- Improve readability: "on the way" instead of "on_the_way" --}}
                    </option>
                @endforeach
            </select>
            {{-- Example of Laravel validation error display --}}
            @error('delivery_status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="pickup_at">Pickup Time</label>
            <input type="datetime-local" name="pickup_at" id="pickup_at" value="{{ $delivery->pickup_at ? date('Y-m-d\TH:i', strtotime($delivery->pickup_at)) : '' }}">
            @error('pickup_at')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="delivered_at">Delivered Time</label>
            <input type="datetime-local" name="delivered_at" id="delivered_at" value="{{ $delivery->delivered_at ? date('Y-m-d\TH:i', strtotime($delivery->delivered_at)) : '' }}">
            @error('delivered_at')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="delivery_notes">Courier Notes</label>
            <textarea name="delivery_notes" id="delivery_notes" rows="4">{{ $delivery->delivery_notes }}</textarea>
            @error('delivery_notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="proof_of_delivery_image">Proof of Delivery (Image)</label>
            <input type="file" name="proof_of_delivery_image" id="proof_of_delivery_image" accept="image/*"> {{-- Accept only image files --}}
            @error('proof_of_delivery_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            {{-- Display existing image if available --}}
            @if ($delivery->proof_of_delivery_image)
                <div style="margin-top: 15px;">
                    <p style="font-size: 0.9em; color: #666;">Current Image:</p>
                    <img src="{{ asset('storage/' . $delivery->proof_of_delivery_image) }}" alt="Proof of Delivery" style="max-width: 200px; height: auto; border-radius: 8px; border: 1px solid #eee; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                </div>
            @endif
        </div>

        <button class="btn-submit" type="submit">Update Delivery</button>
    </form>
</div>
@endsection