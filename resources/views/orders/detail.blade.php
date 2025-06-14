@extends('layouts.layout') {{-- Ensure your main layout is free from other CSS frameworks --}}

@section('content')

<style>
    /*
     * IMPORTANT: Styles outside .order-detail-page might still affect
     * global elements like body if your navbar is within the same body
     * and doesn't have its own more specific styles.
     * Ideally, global styles like font-family for body should be set in the main layout.
     */

    /* You can remove 'body' styles here if already set in the main layout */
    /* If no body styles in the main layout, this can be kept but
        it will only be effective if the navbar is outside 'body' or has more specific styles */
    body {
        background-color: #f0f2f5; /* Soft background */
        color: #333;
        line-height: 1.6;
        margin: 0;
        padding: 0;
    }

    /* Main Wrapper for Order Detail Page */
    .order-detail-page {
        font-family: 'Poppins', sans-serif; /* Poppins only for this page */
        /* You can also add background-color: #f0f2f5; here
            if you want to ensure the background is only in the content area */
    }

    /* Target all styles within .order-detail-page */
    .order-detail-page .container {
        max-width: 1200px; /* **Increased width significantly for a wider layout** */
        margin: 60px auto; /* Increased margin for more space around */
        padding: 40px; /* **Increased padding for more internal space** */
        background-color: #ffffff;
        border-radius: 15px; /* Slightly more rounded corners */
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1); /* Stronger, more diffused shadow */
        border: 1px solid #dbe2ea; /* Slightly more prominent border */
    }

    .order-detail-page .detail-card {
        background-color: #ffffff;
        border-radius: 15px; /* Consistent rounded corners */
        overflow: hidden;
        margin-bottom: 50px; /* More space between main card and buttons */
        border: 1px solid #e0e7ee;
        box-shadow: 0 8px 25px rgba(0,0,0,0.06); /* Subtle shadow for the card itself */
    }

    .order-detail-page .detail-card-header {
        background: linear-gradient(135deg, #4CAF50, #28a745);
        color: white;
        padding: 30px 40px; /* **Increased padding for a grander header** */
        font-size: 2.8rem; /* **Significantly larger header text** */
        font-weight: 800; /* Extra bold */
        text-align: center;
        letter-spacing: -1px; /* Tighter letter spacing for larger text */
    }

    .order-detail-page .detail-card-body {
        padding: 50px; /* **Increased padding inside card body** */
    }

    .order-detail-page .section-block {
        margin-bottom: 50px; /* **Increased margin-bottom to separate sections more** */
    }

    .order-detail-page .section-block:last-child {
        margin-bottom: 0; /* Remove margin-bottom from the last section */
    }

    .order-detail-page .section-heading {
        font-size: 2.2rem; /* **Larger section headings** */
        font-weight: 700; /* Bolder */
        color: #2e7d32;
        margin-bottom: 35px; /* More space below heading */
        padding-bottom: 15px; /* More padding for the underline effect */
        border-bottom: 2px solid #cfe0e9; /* Slightly darker separator */
        display: flex;
        align-items: center;
    }

    .order-detail-page .section-heading i {
        margin-right: 20px; /* More space for icons */
        color: #4CAF50;
        font-size: 2.5rem; /* **Larger icons for section headings** */
    }

    .order-detail-page .info-row {
        display: flex;
        justify-content: space-between;
        padding: 15px 0; /* **Increased vertical padding for info rows** */
        border-bottom: 1px dashed #e9ecef; /* Lighter dashed line */
        font-size: 1.25rem; /* **Significantly larger info text** */
    }

    .order-detail-page .info-row:last-of-type {
        border-bottom: none;
    }

    .order-detail-page .info-row strong {
        color: #444; /* Darker for labels */
        font-weight: 700; /* Bolder labels */
    }

    .order-detail-page .info-row span,
    .order-detail-page .info-row p {
        color: #555; /* Slightly darker for values */
        text-align: right;
    }

    .order-detail-page .status-badge {
        display: inline-block;
        padding: 10px 22px; /* **Larger padding for badges** */
        border-radius: 30px; /* More pill-like */
        font-size: 1.1rem; /* **Larger font size for badges** */
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: white; /* Default white for most badges */
        margin-left: 20px; /* More space from label */
    }

    .order-detail-page .badge-success { background-color: #28a745; }
    .order-detail-page .badge-danger { background-color: #dc3545; }
    .order-detail-page .badge-warning { background-color: #ffc107; color: #333; } /* Ensure dark text for warning */
    .order-detail-page .badge-info { background-color: #17a2b8; }
    .order-detail-page .badge-primary { background-color: #007bff; }
    .order-detail-page .badge-secondary { background-color: #6c757d; }

    /* Adjust text color for badges with dark backgrounds to ensure visibility */
    .order-detail-page .badge-success,
    .order-detail-page .badge-info,
    .order-detail-page .badge-primary,
    .order-detail-page .badge-danger,
    .order-detail-page .badge-secondary {
        color: white;
    }

    /* Special case for warning badge (yellow background), ensure dark text */
    .order-detail-page .badge-warning {
        color: #333;
    }

    .order-detail-page .items-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 15px; /* **Increased space between rows** */
        margin-top: 25px; /* More top margin */
    }

    .order-detail-page .items-table th,
    .order-detail-page .items-table td {
        padding: 22px; /* **Increased padding in table cells** */
        text-align: left;
        vertical-align: middle;
        border: none;
        font-size: 1.15rem; /* **Larger font size for table content** */
    }

    .order-detail-page .items-table th {
        background-color: #eaf7ed;
        color: #2e7d32;
        font-weight: 700;
        font-size: 1.05rem; /* Slightly larger for headers */
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    .order-detail-page .items-table th:first-child { border-top-left-radius: 10px; } /* Slightly more rounded corners */
    .order-detail-page .items-table th:last-child { border-top-right-radius: 10px; }

    .order-detail-page .items-table tbody tr {
        background-color: #ffffff;
        border: 1px solid #e0e7ee;
        border-radius: 10px; /* Consistent rounded corners */
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .order-detail-page .items-table tbody tr:hover {
        transform: translateY(-5px); /* More pronounced lift on hover */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08); /* Stronger shadow on hover */
    }

    .order-detail-page .items-table img {
        width: 70px; /* **Larger image size** */
        height: 70px; /* **Larger image size** */
        object-fit: cover;
        border-radius: 10px; /* Consistent rounded corners */
        margin-right: 20px;
        border: 1px solid #ddd;
    }

    .order-detail-page .items-table .item-name {
        font-weight: 600;
        color: #333;
    }

    .order-detail-page .items-table .text-right {
        text-align: right;
    }

    .order-detail-page .summary-table-wrapper {
        display: flex;
        justify-content: flex-end;
        margin-top: 40px; /* More top margin */
    }

    .order-detail-page .summary-table {
        width: 500px; /* **Wider summary table** */
        border-collapse: collapse;
    }

    .order-detail-page .summary-table td {
        padding: 15px 0; /* **Increased padding in summary table cells** */
        font-size: 1.25rem; /* **Larger font size for summary text** */
        color: #444;
    }

    .order-detail-page .summary-table .total-row {
        background-color: #eaf7ed;
        font-weight: 700;
        font-size: 1.6rem; /* **Even larger total amount** */
        color: #2e7d32;
        border-radius: 10px; /* Consistent rounded corners */
        padding: 20px 25px; /* **Increased padding for total row** */
    }

    .order-detail-page .summary-table .total-row td {
        padding: 20px 25px; /* Ensure padding applies to cells in total row */
    }

    .order-detail-page .alert {
        padding: 20px 25px; /* **Increased padding for alerts** */
        border-radius: 10px;
        margin-top: 30px; /* More top margin */
        font-size: 1.15rem; /* **Larger font size for alerts** */
        display: flex;
        align-items: center;
        text-align: center;
        justify-content: center;
    }

    .order-detail-page .alert i {
        margin-right: 15px; /* More space for icons */
        font-size: 1.4em; /* Larger icons in alerts */
    }

    .order-detail-page .alert-warning {
        background-color: #fff3cd;
        border: 1px solid #ffeeba;
        color: #856404;
    }

    .order-detail-page .alert-secondary {
        background-color: #e2e3e5;
        border: 1px solid #d6d8db;
        color: #383d41;
    }

    .order-detail-page .proof-image {
        max-width: 350px; /* **Larger proof image** */
        border-radius: 10px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        margin-top: 20px;
        border: 1px solid #ddd;
    }

    .order-detail-page .button-group {
        display: flex;
        justify-content: flex-end;
        gap: 20px; /* More space between buttons */
        margin-top: 60px; /* More top margin */
        padding-top: 40px; /* More padding above buttons */
        border-top: 1px solid #e9ecef; /* Lighter separator line */
    }

    .order-detail-page .btn {
        padding: 16px 32px; /* **Larger padding for buttons** */
        border-radius: 35px; /* More rounded buttons */
        font-size: 1.15rem; /* **Larger font size for buttons** */
        font-weight: 700; /* Bolder buttons */
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.1);
    }

    .order-detail-page .btn-outline {
        background-color: transparent;
        border: 2px solid #6c757d;
        color: #6c757d;
    }
    .order-detail-page .btn-outline:hover {
        background-color: #6c757d;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(108,117,125,0.3);
    }

    .order-detail-page .btn-primary {
        background-color: #4CAF50;
        color: white;
        border: 2px solid #4CAF50;
    }
    .order-detail-page .btn-primary:hover {
        background-color: #388e3c;
        border-color: #388e3c;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(76,175,80,0.4);
    }

    .order-detail-page .no-image-icon {
        font-size: 3.5rem; /* **Larger no image icon** */
        color: #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 70px; /* Match image size */
        height: 70px; /* Match image size */
        border: 1px dashed #eee;
        border-radius: 10px;
        margin-right: 20px;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .order-detail-page .container {
            max-width: 90%;
            padding: 30px;
            margin: 40px auto;
        }
        .order-detail-page .detail-card-header {
            font-size: 2.2rem;
            padding: 20px 30px;
        }
        .order-detail-page .detail-card-body {
            padding: 30px;
        }
        .order-detail-page .section-heading {
            font-size: 1.8rem;
            margin-bottom: 25px;
        }
        .order-detail-page .section-heading i {
            font-size: 2rem;
        }
        .order-detail-page .info-row {
            font-size: 1.1rem;
            padding: 10px 0;
        }
        .order-detail-page .status-badge {
            font-size: 0.95rem;
            padding: 8px 18px;
        }
        .order-detail-page .items-table th,
        .order-detail-page .items-table td {
            padding: 15px;
            font-size: 1rem;
        }
        .order-detail-page .items-table img,
        .order-detail-page .no-image-icon {
            width: 50px;
            height: 50px;
        }
        .order-detail-page .summary-table {
            width: 100%;
        }
        .order-detail-page .summary-table td {
            font-size: 1.1rem;
        }
        .order-detail-page .summary-table .total-row {
            font-size: 1.3rem;
            padding: 15px 20px;
        }
        .order-detail-page .alert {
            font-size: 1rem;
            padding: 15px 20px;
        }
        .order-detail-page .proof-image {
            max-width: 200px;
        }
        .order-detail-page .button-group {
            flex-direction: column;
            gap: 10px;
            margin-top: 30px;
            padding-top: 20px;
        }
        .order-detail-page .btn {
            padding: 12px 20px;
            font-size: 1rem;
            width: 100%;
        }
    }

    @media (max-width: 767px) {
        .order-detail-page .container {
            padding: 20px;
            margin: 20px auto;
        }
        .order-detail-page .detail-card-header {
            font-size: 1.8rem;
            padding: 15px 20px;
        }
        .order-detail-page .section-heading {
            font-size: 1.5rem;
        }
        .order-detail-page .section-heading i {
            font-size: 1.7rem;
        }
        .order-detail-page .info-row {
            flex-direction: column;
            align-items: flex-start;
            font-size: 1rem;
        }
        .order-detail-page .info-row span,
        .order-detail-page .info-row p {
            text-align: left;
            margin-top: 5px;
        }
        .order-detail-page .status-badge {
            margin-left: 0;
            margin-top: 8px;
            font-size: 0.85rem;
            padding: 6px 12px;
        }
        .order-detail-page .items-table th,
        .order-detail-page .items-table td {
            font-size: 0.9rem;
            padding: 10px;
        }
        .order-detail-page .items-table img,
        .order-detail-page .no-image-icon {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
        .order-detail-page .summary-table td {
            font-size: 1rem;
        }
        .order-detail-page .summary-table .total-row {
            font-size: 1.2rem;
        }
    }

    /* Ensure Font Awesome is loaded for icons */
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap');
</style>

<div class="order-detail-page"> {{-- Add unique wrapper here --}}
    <div class="container">
        <div class="detail-card">
            <div class="detail-card-header">
                Order Details <span style="color: #ffeb3b;">#{{ $order->order_number }}</span>
            </div>
            <div class="detail-card-body">

                {{-- --- Status and Payment Information --- --}}
                <div class="section-block">
                    <h4 class="section-heading"><i class="fas fa-money-check-alt"></i> Status & Payment</h4>
                    <div class="info-row">
                        <strong>Payment Status:</strong>
                        <span class="status-badge badge-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    <div class="info-row">
                        <strong>Order Status:</strong>
                        <span class="status-badge badge-{{ $order->order_status == 'delivered' ? 'success' :
                            ($order->order_status == 'cancelled' ? 'danger' :
                            ($order->order_status == 'shipped' ? 'info' :
                            ($order->order_status == 'processing' ? 'primary' : 'secondary'))) }}">
                            {{ ucfirst(str_replace('_', ' ', $order->order_status)) }}
                        </span>
                    </div>
                    <div class="info-row">
                        <strong>Order Date:</strong>
                        <span>{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="info-row">
                        <strong>Payment Reference:</strong>
                        <span>{{ $order->payment_gateway_ref ?? 'N/A' }}</span>
                    </div>
                    @if($order->payment_status !== 'paid' && $order->order_status !== 'cancelled')
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Your payment is still **{{ ucfirst($order->payment_status) }}**. Please complete it soon!
                        </div>
                    @endif
                </div>

                {{-- --- Customer Information --- --}}
                <div class="section-block">
                    <h4 class="section-heading"><i class="fas fa-user"></i> Customer Information</h4>
                    <div class="info-row">
                        <strong>Name:</strong>
                        <span>{{ $order->customer->name ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <strong>Email:</strong>
                        <span>{{ $order->customer->email ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <strong>Shipping Address:</strong>
                        <span>{{ $order->delivery_address }}</span>
                    </div>
                    <div class="info-row">
                        <strong>Shipping Phone:</strong>
                        <span>{{ $order->delivery_phone }}</span>
                    </div>
                    @if ($order->notes)
                        <div class="info-row">
                            <strong>Customer Notes:</strong>
                            <p style="text-align: right; color: #607d8b; font-style: italic; max-width: 60%;">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>

                {{-- --- Order Item List --- --}}
                <div class="section-block">
                    <h4 class="section-heading"><i class="fas fa-box"></i> Order Items</h4>
                    @if ($order->orderItems->count())
                        <table class="items-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Supplement Name</th>
                                    <th>Category</th>
                                    <th class="text-right">Unit Price</th>
                                    <th class="text-right">Quantity</th>
                                    <th class="text-right">Item Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div style="display: flex; align-items: center;">
                                                @if ($item->supplement && $item->supplement->image)
                                                    <img src="{{ asset('storage/' . $item->supplement->image) }}" alt="{{ $item->supplement->name }}">
                                                @else
                                                    <div class="no-image-icon"><i class="fas fa-image"></i></div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="item-name">{{ $item->supplement->name ?? 'Supplement Deleted' }}</td>
                                        <td>{{ $item->supplement->category ?? '-' }}</td>
                                        <td class="text-right">Rp{{ number_format($item->price_at_purchase, 0, ',', '.') }}</td>
                                        <td class="text-right">{{ $item->quantity }}</td>
                                        <td class="text-right" style="font-weight: 700;">Rp{{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-secondary">
                            <i class="fas fa-info-circle"></i> There are no items in this order.
                        </div>
                    @endif
                </div>

                {{-- --- Payment Summary --- --}}
                <div class="section-block">
                    <h4 class="section-heading"><i class="fas fa-receipt"></i> Payment Summary</h4>
                    <div class="summary-table-wrapper">
                        <table class="summary-table">
                            <tbody>
                                <tr>
                                    <td><strong>Subtotal:</strong></td>
                                    <td class="text-right">Rp{{ number_format($order->subtotal_amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tax (11%):</strong></td>
                                    <td class="text-right">Rp{{ number_format($order->tax_amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Shipping Cost:</strong></td>
                                    <td class="text-right">Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="total-row">
                                    <td><strong>TOTAL PAYABLE:</strong></td>
                                    <td class="text-right"><strong>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- --- Delivery Information --- --}}
                <div class="section-block">
                    <h4 class="section-heading"><i class="fas fa-truck"></i> Delivery Information</h4>
                    @if ($order->delivery)
                        <div class="info-row">
                            <strong>Delivery Status:</strong>
                            <span class="status-badge badge-{{ $order->delivery->delivery_status == 'delivered' ? 'success' :
                                ($order->delivery->delivery_status == 'failed' ? 'danger' :
                                ($order->delivery->delivery_status == 'on_the_way' || $order->delivery->delivery_status == 'picking_up' ? 'info' : 'secondary')) }}">
                                {{ ucfirst(str_replace('_', ' ', $order->delivery->delivery_status)) }}
                            </span>
                        </div>
                        <div class="info-row">
                            <strong>Assigned Courier:</strong>
                            <span>{{ $order->courier->name ?? 'Not yet assigned' }}</span>
                        </div>
                        <div class="info-row">
                            <strong>Pickup Time:</strong>
                            <span>{{ $order->delivery->pickup_at ? \Carbon\Carbon::parse($order->delivery->pickup_at)->format('d M Y H:i') : '-' }}</span>
                        </div>
                        <div class="info-row">
                            <strong>Delivered Time:</strong>
                            <span>{{ $order->delivery->delivered_at ? \Carbon\Carbon::parse($order->delivery->delivered_at)->format('d M Y H:i') : '-' }}</span>
                        </div>
                        @if ($order->delivery->proof_of_delivery_image)
                            <div class="info-row" style="flex-direction: column; align-items: flex-start;">
                                <strong>Proof of Delivery:</strong>
                                <img src="{{ asset('storage/' . $order->delivery->proof_of_delivery_image) }}" alt="Proof of Delivery" class="proof-image">
                            </div>
                        @endif
                        @if ($order->delivery->delivery_notes)
                            <div class="info-row">
                                <strong>Courier Notes:</strong>
                                <p style="text-align: right; color: #607d8b; font-style: italic; max-width: 60%;">{{ $order->delivery->delivery_notes }}</p>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-secondary">
                            <i class="fas fa-info-circle"></i> Delivery details are not yet available or no courier has been assigned.
                        </div>
                    @endif
                </div>

                {{-- --- Actions --- --}}
                <div class="button-group">
                    <a href="{{ route('orders.index') }}" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Back to Order List
                    </a>
                </div>

            </div> {{-- End detail-card-body --}}
        </div> {{-- End detail-card --}}
    </div> {{-- End container --}}
</div> {{-- End order-detail-page wrapper --}}

@endsection