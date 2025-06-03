@extends('layouts.layout')

{{-- No @push('styles') here, as styles are moved inline --}}

@section('content')
<style>
    /* General Body Styles */
    body {
        background-color: #f8fbfd; /* Very light, cool background for a fresh feel */
        font-family: 'Poppins', sans-serif; /* A popular, modern sans-serif font */
        color: #333;
        line-height: 1.6;
    }

    /* Container Styling */
    .container.mt-4 {
        padding: 50px 30px; /* More vertical padding */
        max-width: 950px; /* Even wider container for a more spacious layout */
        margin: 50px auto; /* Centered with generous top/bottom margin */
        background-color: #ffffff;
        border-radius: 20px; /* Even more rounded corners for a softer, modern look */
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08); /* Smoother, more diffused shadow */
        border: 1px solid #e0e7ee; /* Subtle, light border */
    }

    /* Main Heading Styling */
    .page-title {
        color: #2e8b57; /* Slightly softer, more natural green */
        font-size: 3.2rem; /* Significantly larger and more impactful title */
        font-weight: 800; /* Extra bold */
        text-align: center;
        margin-bottom: 60px; /* More space below the main heading */
        letter-spacing: -1px; /* Tighter letter spacing for a premium feel */
        position: relative;
        padding-bottom: 20px; /* Space for the decorative line */
    }

    .page-title::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        width: 100px; /* Longer, more prominent underline */
        height: 5px;
        background: linear-gradient(to right, #4CAF50, #28a745); /* Gradient green underline */
        border-radius: 3px;
    }

    /* Delivery Card Styling */
    .delivery-card {
        background: #ffffff;
        border-left: 10px solid #4CAF50; /* Thicker, more impactful green border */
        padding: 35px; /* More padding */
        margin-bottom: 30px; /* More space between cards */
        border-radius: 18px; /* Slightly softer rounded corners */
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); /* Enhanced, elegant shadow */
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out, border-color 0.3s ease; /* Smooth hover effects */
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Distribute space */
        align-items: flex-start; /* Align items to the start */
        border: 1px solid #f0f0f0; /* Very subtle outer border */
    }

    .delivery-card:hover {
        transform: translateY(-10px); /* More noticeable lift on hover */
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.15); /* More pronounced shadow */
        border-color: #28a745; /* Border color subtly changes on hover */
    }

    .delivery-card h3 {
        margin: 0 0 15px 0; /* More space below the heading */
        color: #2e7d32; /* Darker green for headings */
        font-size: 2.1rem; /* Larger, more readable heading font */
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .delivery-card p {
        margin: 8px 0; /* More vertical space for paragraphs */
        color: #5d6d7e; /* Softer, slightly bluish-gray for text */
        font-size: 1.1rem; /* Slightly larger text */
    }

    .delivery-card p strong {
        color: #3cb371; /* A fresh, appealing green for status */
        font-weight: 700;
    }

    /* View Details Button Styling (with a gradient) */
    .btn-view {
        align-self: flex-start;
        margin-top: 25px; /* More space above the button */
        padding: 14px 30px; /* Generous padding */
        background-image: linear-gradient(to right, #4CAF50 0%, #28a745 100%); /* Green gradient */
        color: white;
        text-decoration: none;
        border: none;
        border-radius: 10px; /* Softer rounded corners */
        font-size: 1.15rem; /* Larger font */
        font-weight: 600;
        letter-spacing: 0.8px; /* More letter spacing */
        cursor: pointer;
        transition: all 0.3s ease; /* Smooth transition for all properties */
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3); /* Stronger, more vibrant shadow */
        text-transform: uppercase; /* Uppercase text for a bold look */
    }

    .btn-view:hover {
        background-position: right center; /* Shifts gradient on hover */
        transform: translateY(-4px); /* More noticeable lift */
        box-shadow: 0 12px 25px rgba(40, 167, 69, 0.45); /* Enhanced shadow on hover */
    }

    .btn-view:active {
        transform: translateY(0); /* Press effect */
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2);
    }

    /* Message for no deliveries */
    .no-deliveries-message {
        text-align: center;
        color: #7f8c8d; /* Softer gray */
        font-size: 1.4rem; /* Larger text */
        padding: 50px; /* More padding */
        background-color: #f0f4f8; /* Matches body background slightly */
        border-radius: 15px; /* Consistent rounded corners */
        margin-top: 50px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.07); /* Nicer shadow */
        border: 1px solid #dee7f0; /* Subtle border */
    }

    .no-deliveries-message p {
        margin: 15px 0; /* More spacing */
    }

    .no-deliveries-message p:first-child {
        font-weight: 600;
        color: #388e3c; /* Highlight the main message */
        font-size: 1.5rem;
    }
</style>

<div class="container mt-4">
    <h1 class="page-title">Your Delivery Summary</h1>

    @forelse ($deliveries as $delivery)
        <div class="delivery-card">
            <h3>Order #: {{ $delivery->order->order_number }}</h3>
            <p>Status: <strong>{{ ucfirst($delivery->delivery_status) }}</strong></p>
            <p>Address: {{ $delivery->order->delivery_address }}</p>
            <a class="btn-view" href="{{ route('courier.deliveries.show', $delivery->id) }}">View Details</a>
        </div>
    @empty
        <div class="no-deliveries-message">
            <p>No deliveries found at this time.</p>
            <p>Check back later or contact support if you believe this is an error.</p>
        </div>
    @endforelse
</div>
@endsection