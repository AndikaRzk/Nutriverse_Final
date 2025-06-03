@extends('layouts.layout')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-success text-white text-center py-4 rounded-top-4">
                    <h2 class="mb-1 fw-bold">Order Summary</h2>
                    <p class="mb-0 fs-5 opacity-75">Order #{{ $orders->order_number }}</p>
                </div>
                <div class="card-body p-4 p-lg-5">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                            {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row mb-4 pb-2 border-bottom">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <p class="text-muted mb-1 small">Customer Name</p>
                            <h5 class="fw-bold text-dark">{{ $orders->customer->name }}</h5>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <p class="text-muted mb-1 small">Payment Status</p>
                            @if($orders->payment_status === 'paid')
                                <span class="badge bg-success-light text-success-dark fs-6 px-3 py-2 rounded-pill">Paid</span>
                            @else
                                <span class="badge bg-warning-light text-warning-dark fs-6 px-3 py-2 rounded-pill">Pending</span>
                            @endif
                        </div>
                    </div>

                    <div class="row text-center mb-4 pb-2 border-bottom">
                        <div class="col-3">
                            <p class="text-muted mb-1 small">Subtotal</p>
                            <h6 class="fw-bold text-dark">Rp{{ number_format($orders->subtotal_amount, 2) }}</h6>
                        </div>
                        <div class="col-3">
                            <p class="text-muted mb-1 small">Tax</p>
                            <h6 class="fw-bold text-dark">Rp{{ number_format($orders->tax_amount, 2) }}</h6>
                        </div>
                        <div class="col-3">
                            <p class="text-muted mb-1 small">Shipping</p>
                            <h6 class="fw-bold text-dark">Rp{{ number_format($orders->shipping_cost, 2) }}</h6>
                        </div>
                        <div class="col-3">
                            <p class="text-muted mb-1 small">Total Amount</p>
                            <h4 class="fw-bold text-success">Rp{{ number_format($orders->total_amount, 2) }}</h4>
                        </div>
                    </div>

                    <div class="row align-items-center mb-4">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <p class="text-muted mb-1 small">Courier</p>
                            <h5 class="fw-bold text-dark">{{ $orders->courier ? $orders->courier->name : 'N/A' }}</h5>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            @if($orders->payment_status !== 'paid')
                                <button id="pay-button" class="btn btn-success btn-lg px-4 py-2 rounded-pill shadow-sm">Payment Now</button>
                            @else
                                <span class="text-success fw-bold fs-5 d-block py-2">Payment Done! <i class="bi bi-check-circle-fill ms-2"></i></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light text-center text-muted py-3 border-top-0 rounded-bottom-4">
                    <small>Thank you for choosing our supplements!</small>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById("pay-button")?.addEventListener("click", function () {
        snap.pay("{{ $snapToken }}", {
            onSuccess: function (result) {
                alert("Payment successful! Updating status...");

                fetch('{{ route("transactions.notification") }}', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        order_id: "{{ $orders->order_number }}",
                        transaction_status: "settlement",
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    console.log("Webhook response:", data);
                    if (data.status === "success") {
                        alert("Payment updated! Redirecting...");
                        window.location.reload();
                    } else {
                        alert("Failed to update payment status.");
                    }
                })
                .catch((error) => {
                    console.error("Error calling webhook:", error);
                    alert("Error updating payment status.");
                });
            },

            onPending: function (result) {
                alert("Payment is pending. Please complete your payment.");
                console.log(result);
            },

            onError: function (result) {
                alert("Payment failed. Please try again.");
                console.log(result);
            },

            onClose: function () {
                alert("You closed the payment window without completing the payment.");
            },
        });
    });
</script> --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById("pay-button")?.addEventListener("click", function () {
        snap.pay("{{ $snapToken }}", {
            onSuccess: function (result) {
                alert("Payment successful! Updating status...");

                fetch('{{ route("transactions.notification") }}', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        order_id: "{{ $orders->order_number }}",
                        transaction_status: "settlement",
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    console.log("Webhook response:", data);
                    if (data.status === "success") {
                        alert("Payment updated! Redirecting...");
                        window.location.href = "{{ route('supplements.index') }}"; // ✅ redirect ke dashboard
                    } else {
                        alert("Failed to update payment status.");
                    }
                })
                .catch((error) => {
                    console.error("Error calling webhook:", error);
                    alert("Error updating payment status.");
                });
            },

            onPending: function (result) {
                alert("Payment is pending. Please complete your payment.");
                console.log(result);
            },

            onError: function (result) {
                alert("Payment failed. Please try again.");
                console.log(result);
            },

            onClose: function () {
                alert("You closed the payment window without completing the payment.");
            },
        });
    });
</script>


<style>
    .bg-success { background-color: #28a745 !important; }
    .bg-success-light { background-color: #e6ffe6 !important; }
    .text-success-dark { color: #1e7e34 !important; }
    .text-success { color: #28a745 !important; }
    .bg-warning-light { background-color: #fffacd !important; }
    .text-warning-dark { color: #8a6d3b !important; }

    .card { border-radius: 1.5rem !important; }
    .card-header, .card-footer { border: none !important; }
    .badge { font-weight: 600; }
    .btn-success {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
        transition: all 0.3s ease;
    }
    .btn-success:hover {
        background-color: #218838 !important;
        border-color: #1e7e34 !important;
        transform: translateY(-2px);
    }
    .bi-check-circle-fill { vertical-align: middle; }
</style>
@endsection
