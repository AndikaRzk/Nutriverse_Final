@extends('layouts.layout')

@section('content')
<style>
    /* Specific Body Styles for this page */
    .order-history-body { /* New class for body specific to this page */
        background-color: #f8fbfd; /* Very light, cool background for a fresh feel */
        font-family: 'Poppins', sans-serif; /* A popular, modern sans-serif font */
        color: #333;
        line-height: 1.6;
    }

    /* Container Styling */
    .order-history-container { /* New class for the container */
        padding: 50px 30px; /* More vertical padding */
        max-width: 1200px; /* **Increased width for a wider layout** */
        margin: 50px auto; /* Centered with generous top/bottom margin */
        background-color: #ffffff;
        border-radius: 20px; /* Even more rounded corners for a softer, modern look */
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08); /* Smoother, more diffused shadow */
        border: 1px solid #e0e7ee; /* Subtle, light border */
    }

    /* Main Heading Styling */
    .order-history-title { /* New class for the page title */
        color: #2e8b57; /* Slightly softer, more natural green */
        font-size: 3.2rem; /* Significantly larger and more impactful title */
        font-weight: 800; /* Extra bold */
        text-align: center;
        margin-bottom: 60px; /* More space below the main heading */
        letter-spacing: -1px; /* Tighter letter spacing for a premium feel */
        position: relative;
        padding-bottom: 20px; /* Space for the decorative line */
    }

    .order-history-title::after {
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

    /* Search Form Styling */
    .order-search-form .input-group { /* New class for search form */
        display: flex;
        justify-content: center; /* Center the search input */
        margin-bottom: 40px; /* Space below the search bar */
    }

    .order-search-form .form-control-custom { /* New class for form control */
        border-radius: 10px 0 0 10px; /* Rounded left side */
        border: 1px solid #ced4da;
        padding: 12px 20px;
        font-size: 1rem;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
        max-width: 400px; /* Limit search input width */
    }

    .order-search-form .form-control-custom:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
        outline: none;
    }

    .order-search-form .btn-search-custom { /* New class for search button */
        background-color: #4CAF50;
        color: white;
        border: 1px solid #4CAF50;
        border-radius: 0 10px 10px 0; /* Rounded right side */
        padding: 12px 25px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease, border-color 0.3s ease;
        box-shadow: 0 4px 10px rgba(76, 175, 80, 0.2);
    }

    .order-search-form .btn-search-custom:hover {
        background-color: #388e3c;
        border-color: #388e3c;
        box-shadow: 0 6px 15px rgba(76, 175, 80, 0.3);
    }

    /* Order Card Styling */
    .single-order-card { /* New class for the order card */
        background: #ffffff;
        border: 1px solid #e0e7ee; /* Soft border */
        border-radius: 18px; /* Consistent rounded corners */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.07); /* Elegant shadow */
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        height: 100%; /* Ensure cards in a row have equal height */
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Push button to bottom */
    }

    .single-order-card:hover {
        transform: translateY(-8px); /* Lift on hover */
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12); /* More pronounced shadow */
    }

    .order-card-body-content { /* New class for card body */
        padding: 25px; /* Ample padding inside card */
    }

    .order-card-title-heading { /* New class for card title */
        color: #2e7d32; /* Dark green for order number */
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 15px;
        letter-spacing: -0.5px;
    }

    .order-card-paragraph { /* New class for paragraphs within card */
        margin-bottom: 8px;
        font-size: 1rem;
        color: #5d6d7e;
    }

    .order-card-strong { /* New class for strong tags within card */
        color: #444; /* Darker for labels */
        font-weight: 600;
    }

    /* Status Badges */
    .status-badge-custom { /* New base class for status badges */
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px; /* Pill shape */
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: white; /* Default text color for badges */
    }

    .status-badge-success { background-color: #28a745 !important; } /* Delivered */
    .status-badge-danger { background-color: #dc3545 !important; } /* Cancelled/Failed */
    .status-badge-warning { background-color: #ffc107 !important; color: #333 !important; } /* Pending/Processing (needs dark text) */
    .status-badge-info { background-color: #17a2b8 !important; } /* Shipped/Processing (if you want another color) */
    .status-badge-secondary { background-color: #6c757d !important; } /* Fallback/Other status */


    /* Action Buttons (inside card) */
    .order-card-actions { /* New class for button area */
        padding: 20px 25px 25px 25px; /* Padding for button area */
        border-top: 1px solid #f0f0f0; /* Separator line */
    }

    .btn-action-custom { /* New base class for action buttons */
        display: block; /* Full width button */
        width: 100%;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 1.05rem;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .btn-action-warning-custom {
        background-color: #ffc107;
        color: #333; /* Dark text for warning buttons */
        border: 1px solid #ffc107;
    }
    .btn-action-warning-custom:hover {
        background-color: #e0a800;
        border-color: #e0a800;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(255,193,7,0.3);
    }

    .btn-action-danger-custom {
        background-color: #dc3545;
        color: white;
        border: 1px solid #dc3545;
    }
    .btn-action-danger-custom:hover {
        background-color: #c82333;
        border-color: #bd2130;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(220,53,69,0.3);
    }

    .btn-action-outline-primary-custom {
        background-color: transparent;
        color: #007bff;
        border: 2px solid #007bff;
    }
    .btn-action-outline-primary-custom:hover {
        background-color: #007bff;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,123,255,0.2);
    }


    /* No Orders Message */
    .no-orders-message-box { /* New class for no orders message box */
        text-align: center;
        padding: 60px 20px;
        background-color: #f0f4f8;
        border-radius: 15px;
        margin-top: 50px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.07);
        border: 1px solid #dee7f0;
    }

    .no-orders-message-box img {
        width: 120px; /* Slightly larger icon */
        opacity: 0.7;
        margin-bottom: 25px;
    }

    .no-orders-message-box h5 {
        color: #4CAF50; /* Green highlight for the main message */
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .no-orders-message-box p {
        color: #7f8c8d;
        font-size: 1.1rem;
        max-width: 500px;
        margin: 0 auto 30px auto; /* Center paragraph */
    }

    .btn-start-shopping-custom { /* New class for start shopping button */
        display: inline-block;
        padding: 14px 30px;
        background-color: #28a745; /* Green button */
        color: white;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1rem;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 6px 15px rgba(40, 167, 69, 0.25);
    }

    .btn-start-shopping-custom:hover {
        background-color: #218838;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.35);
    }

    /* Pagination Styling */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 50px;
    }

    .pagination-container .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: .25rem;
    }

    .pagination-container .page-item {
        margin: 0 5px;
    }

    .pagination-container .page-item .page-link {
        position: relative;
        display: block;
        padding: .75rem 1rem;
        line-height: 1.25;
        color: #28a745; /* Green text for links */
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 8px; /* Rounded pagination buttons */
        transition: all 0.3s ease;
        text-decoration: none;
        font-weight: 600;
    }

    .pagination-container .page-item .page-link:hover {
        z-index: 2;
        color: #fff;
        background-color: #28a745; /* Green background on hover */
        border-color: #28a745;
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2);
        transform: translateY(-2px);
    }

    .pagination-container .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #28a745; /* Active green background */
        border-color: #28a745;
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
    }

    .pagination-container .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #e9ecef;
        border-color: #dee2e6;
        opacity: 0.7;
    }

    /* Responsive Adjustments */
    @media (min-width: 992px) { /* For large devices and up */
        .col-lg-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }
    }
    @media (min-width: 768px) and (max-width: 991.98px) { /* For medium devices */
        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }
</style>

<div class="order-history-container">
    <h1 class="order-history-title">Your Order History</h1>

    <form method="GET" action="{{ route('orders.index') }}" class="order-search-form">
        <div class="input-group">
            <input type="text" name="search" class="form-control-custom" placeholder="Search by Order Number..." value="{{ request('search') }}">
            <button class="btn-search-custom" type="submit">Search</button>
        </div>
    </form>

    @if($orders->count())
        <div class="row">
            @foreach($orders as $order)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="single-order-card">
                        <div class="order-card-body-content">
                            <h5 class="order-card-title-heading">Order #{{ $order->order_number }}</h5>
                            <p class="order-card-paragraph mb-1">
                                <span class="order-card-strong">Status:</span>
                                <span class="status-badge-custom {{
                                    $order->order_status === 'delivered' ? 'status-badge-success' :
                                    ($order->order_status === 'cancelled' ? 'status-badge-danger' :
                                    ($order->order_status === 'pending' || $order->order_status === 'failed' ? 'status-badge-warning' : 'status-badge-info')) }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </p>
                            <p class="order-card-paragraph mb-1"><span class="order-card-strong">Total:</span> Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            <p class="order-card-paragraph mb-1"><span class="order-card-strong">Date:</span> {{ $order->created_at->format('d M Y') }}</p>
                        </div>

                        <div class="order-card-actions">
                            @if($order->payment_status === 'pending' && $order->order_status !== 'cancelled')
                                <a href="{{ route('payment.confirm', $order->id) }}" class="btn-action-custom btn-action-warning-custom">
                                    Continue Payment
                                </a>
                            @elseif($order->payment_status === 'failed' && $order->order_status !== 'cancelled')
                                <a href="{{ route('payment.confirm', $order->id) }}" class="btn-action-custom btn-action-warning-custom">
                                    Retry Payment
                                </a>
                            @else
                                <a href="{{ route('orders.detail', $order->id) }}" class="btn-action-custom btn-action-outline-primary-custom">
                                    View Details
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination-container">
            {{ $orders->links() }}
        </div>
    @else
        <div class="no-orders-message-box">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No Orders">
            <h5>You haven’t placed any orders yet.</h5>
            <p>When you do, they’ll show up here for you to track and review.</p>
            <a href="{{ route('supplements.index') }}" class="btn-start-shopping-custom">
                Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection