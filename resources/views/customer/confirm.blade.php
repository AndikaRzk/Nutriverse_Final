@extends('layouts.layout')

@section('content')

<style>
    /* Google Fonts for a distinct modern feel */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800&display=swap');


/* Kontainer utama yang lebih kecil */
.receipt-container {
    max-width: 650px; /* Reduced from 850px, significantly smaller */
    width: 100%;
    margin: 25px auto; /* Reduced from 40px */
    padding: 0 15px; /* Reduced from 25px */
    box-sizing: border-box;
}

/* Kartu struk pesanan */
.receipt-card {
    background-color: #ffffff;
    border-radius: 20px; /* Reduced from 30px */
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15); /* Reduced shadow intensity */
    overflow: hidden;
    transition: all 0.4s ease-in-out;
    border: 1px solid rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(5px);
    display: flex;
    flex-direction: column;
}

.receipt-card:hover {
    transform: translateY(-5px) scale(1.002); /* Reduced hover effect */
    box-shadow: 0 30px 80px rgba(0, 0, 0, 0.2); /* Reduced hover shadow intensity */
}

/* Header kartu */
.receipt-header {
    background: linear-gradient(to right, #4CAF50, #66BB6A);
    color: white;
    text-align: center;
    padding: 35px 25px; /* Reduced from 50px 40px */
    position: relative;
    overflow: hidden;
    border-top-left-radius: 20px; /* Matches new card border-radius */
    border-top-right-radius: 20px; /* Matches new card border-radius */
}

.receipt-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
    transform: rotate(45deg);
    opacity: 0.8;
    animation: subtleShine 8s infinite ease-in-out;
}

.receipt-header h2 {
    font-family: 'Playfair Display', serif;
    font-size: 3.5rem; /* Reduced from 4.5rem */
    font-weight: 800;
    margin-bottom: 8px; /* Reduced from 10px */
    letter-spacing: -1.5px; /* Slightly less tight */
    text-shadow: 0 3px 6px rgba(0, 0, 0, 0.25); /* Reduced shadow intensity */
}

.receipt-header p {
    font-size: 1.4rem; /* Reduced from 1.8rem */
    opacity: 0.95;
    font-weight: 500;
    letter-spacing: 0.3px; /* Slightly less wide */
}

/* Body kartu */
.receipt-body {
    padding: 30px 40px; /* Reduced from 45px 60px */
    flex-grow: 1;
}

/* Gaya alert yang disempurnakan */
.alert-fancy {
    padding: 15px 20px; /* Reduced from 20px 30px */
    border-radius: 10px; /* Reduced from 15px */
    margin-bottom: 25px; /* Reduced from 35px */
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-weight: 500;
    font-size: 1.05rem; /* Reduced from 1.25rem */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07); /* Reduced shadow intensity */
    border: none;
    animation: slideInUp 0.5s ease-out;
}

.alert-success-fancy {
    background-color: #d4edda;
    color: #1a5e2a;
}

.alert-info-fancy {
    background-color: #d1ecf1;
    color: #0d5c63;
}

.alert-fancy .close-btn-fancy {
    background: none;
    border: none;
    font-size: 1.8rem; /* Reduced from 2.2rem */
    cursor: pointer;
    color: inherit;
    opacity: 0.7;
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.alert-fancy .close-btn-fancy:hover {
    opacity: 1;
    transform: rotate(90deg);
}

/* Bagian info umum */
.detail-section {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 30px; /* Reduced from 40px */
    padding-bottom: 20px; /* Reduced from 30px */
    border-bottom: 1px dashed #e0e0e0;
}

.detail-item {
    flex: 1;
    padding-right: 15px; /* Reduced from 20px */
}
.detail-item:last-child {
    padding-right: 0;
    text-align: right;
}

.detail-label {
    font-size: 1.05rem; /* Reduced from 1.2rem */
    color: #6c757d;
    margin-bottom: 8px; /* Reduced from 10px */
    font-weight: 400;
    letter-spacing: 0.3px; /* Slightly less wide */
}

.detail-value {
    font-size: 1.5rem; /* Reduced from 1.8rem */
    font-weight: 600;
    color: #212529;
}

/* Grid ringkasan biaya */
.summary-values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); /* Reduced minmax from 180px */
    gap: 25px; /* Reduced from 35px */
    text-align: center;
    margin-bottom: 40px; /* Reduced from 50px */
    padding-bottom: 30px; /* Reduced from 40px */
    border-bottom: 1px solid #e9ecef; /* Reduced from 2px */
}

.summary-cell {
    padding: 12px 0; /* Reduced from 15px */
    background-color: #f8f9fa;
    border-radius: 10px; /* Reduced from 12px */
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.04); /* Reduced shadow intensity */
}

.summary-cell-label {
    font-size: 1rem; /* Reduced from 1.15rem */
    color: #6c757d;
    margin-bottom: 6px; /* Reduced from 8px */
    font-weight: 500;
}

.summary-cell-value {
    font-size: 1.35rem; /* Reduced from 1.6rem */
    font-weight: 700;
    color: #34495e;
}

/* Total amount yang paling menonjol */
.grand-total-section {
    grid-column: 1 / -1;
    margin-top: 25px; /* Reduced from 30px */
    padding: 20px 0; /* Reduced from 25px */
    background-color: #f0fdf4;
    border-radius: 12px; /* Reduced from 15px */
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.08); /* Reduced shadow intensity */
    text-align: center;
}

.grand-total-label {
    font-size: 1.15rem; /* Reduced from 1.3rem */
    color: #28a745;
    font-weight: 600;
    margin-bottom: 12px; /* Reduced from 15px */
    text-transform: uppercase;
    letter-spacing: 0.8px; /* Slightly less wide */
}

.grand-total-value {
    font-family: 'Playfair Display', serif;
    font-size: 4.5rem; /* Reduced from 5.5rem */
    font-weight: 900;
    color: #1c743e;
    letter-spacing: -2px; /* Slightly less tight */
    text-shadow: 0 4px 10px rgba(0, 0, 0, 0.18); /* Reduced shadow intensity */
    line-height: 1;
}

/* Badges untuk status pembayaran */
.payment-status-badge {
    font-size: 1.1rem; /* Reduced from 1.3rem */
    padding: 10px 20px; /* Reduced from 12px 25px */
    border-radius: 40px; /* Reduced from 50px */
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px; /* Reduced from 10px */
    text-transform: uppercase;
    letter-spacing: 0.3px; /* Slightly less wide */
    box-shadow: 0 4px 12px rgba(0,0,0,0.08); /* Reduced shadow intensity */
}

.badge-paid-style {
    background-color: #d4edda;
    color: #1c743e;
}

.badge-pending-style {
    background-color: #ffeeba;
    color: #856404;
}

/* Bagian courier dan tombol pembayaran */
.action-area {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px; /* Reduced from 30px */
}

.courier-display .detail-label {
    margin-bottom: 6px; /* Reduced from 8px */
}

.courier-display .detail-value {
    font-size: 1.5rem; /* Reduced from 1.8rem */
}

.payment-cta-button {
    background: linear-gradient(to right, #28a745, #3CB371);
    color: white;
    padding: 16px 35px; /* Reduced from 20px 45px */
    border: none;
    border-radius: 40px; /* Reduced from 50px */
    font-size: 1.3rem; /* Reduced from 1.6rem */
    font-weight: 700;
    cursor: pointer;
    transition: all 0.4s ease;
    box-shadow: 0 10px 30px rgba(40, 167, 69, 0.45); /* Reduced shadow intensity */
    text-transform: uppercase;
    letter-spacing: 0.8px; /* Slightly less wide */
}

.payment-cta-button:hover {
    transform: translateY(-5px); /* Reduced hover effect */
    box-shadow: 0 15px 40px rgba(40, 167, 69, 0.55); /* Reduced hover shadow intensity */
    background: linear-gradient(to right, #218838, #36a265);
}

.payment-done-msg {
    color: #1c743e;
    font-weight: 700;
    font-size: 1.4rem; /* Reduced from 1.7rem */
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px; /* Reduced from 15px */
}

.payment-done-msg .bi-check-circle-fill {
    font-size: 2rem; /* Reduced from 2.5rem */
    color: #28a745;
}

/* Footer kartu */
.receipt-footer {
    background-color: #f8f9fa;
    text-align: center;
    color: #6c757d;
    padding: 20px 30px; /* Reduced from 30px 40px */
    border-bottom-left-radius: 20px; /* Matches new card border-radius */
    border-bottom-right-radius: 20px; /* Matches new card border-radius */
    font-size: 0.95rem; /* Reduced from 1.1rem */
    font-weight: 300;
}

/* Responsivitas yang sangat baik */
@media (max-width: 992px) {
    .receipt-container {
        max-width: 550px; /* Further reduced */
    }
    .receipt-header h2 {
        font-size: 3rem; /* Reduced from 3.5rem */
    }
    .receipt-header p {
        font-size: 1.3rem; /* Reduced from 1.5rem */
    }
    .receipt-body {
        padding: 25px 30px; /* Reduced from 35px 40px */
    }
    .detail-value {
        font-size: 1.4rem; /* Reduced from 1.6rem */
    }
    .summary-cell-value {
        font-size: 1.2rem; /* Reduced from 1.4rem */
    }
    .grand-total-value {
        font-size: 3.8rem; /* Reduced from 4.5rem */
    }
    .payment-status-badge {
        font-size: 0.95rem; /* Reduced from 1.1rem */
    }
    .payment-cta-button {
        padding: 14px 30px; /* Reduced from 18px 35px */
        font-size: 1.2rem; /* Reduced from 1.4rem */
    }
    .payment-done-msg {
        font-size: 1.2rem; /* Reduced from 1.5rem */
    }
    .payment-done-msg .bi-check-circle-fill {
        font-size: 1.6rem; /* Reduced from 2.2rem */
    }
}

@media (max-width: 768px) {
    .receipt-container {
        margin: 15px auto;
        padding: 0 10px;
    }
    .receipt-card {
        border-radius: 15px;
    }
    .receipt-header {
        padding: 25px 18px; /* Reduced from 40px 25px */
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .receipt-header h2 {
        font-size: 2.2rem; /* Reduced from 2.8rem */
        letter-spacing: -0.8px;
    }
    .receipt-header p {
        font-size: 1rem; /* Reduced from 1.3rem */
    }
    .receipt-body {
        padding: 20px 18px; /* Reduced from 30px 25px */
    }
    .alert-fancy {
        font-size: 0.95rem; /* Reduced from 1.1rem */
        padding: 10px 15px; /* Reduced from 15px 20px */
    }
    .alert-fancy .close-btn-fancy {
        font-size: 1.5rem; /* Reduced from 1.8rem */
    }
    .detail-section {
        flex-direction: column;
        gap: 18px; /* Reduced from 25px */
    }
    .detail-item:last-child {
        text-align: left;
    }
    .detail-label {
        font-size: 0.9rem; /* Reduced from 1.05rem */
    }
    .detail-value {
        font-size: 1.2rem; /* Reduced from 1.5rem */
    }
    .summary-values-grid {
        grid-template-columns: 1fr; /* Remains 1 column on mobile */
        gap: 18px; /* Reduced from 25px */
    }
    .summary-cell-label {
        font-size: 0.85rem; /* Reduced from 1rem */
    }
    .summary-cell-value {
        font-size: 1.05rem; /* Reduced from 1.3rem */
    }
    .grand-total-value {
        font-size: 2.8rem; /* Reduced from 3.8rem */
    }
    .action-area {
        flex-direction: column;
        align-items: center;
        gap: 18px; /* Reduced from 25px */
    }
    .payment-cta-button {
        width: 100%;
        padding: 10px 20px; /* Reduced from 15px 25px */
        font-size: 1rem; /* Reduced from 1.25rem */
    }
    .payment-done-msg {
        font-size: 1.1rem; /* Reduced from 1.4rem */
        justify-content: center;
    }
    .payment-done-msg .bi-check-circle-fill {
        font-size: 1.5rem; /* Reduced from 2rem */
    }
    .receipt-footer {
        padding: 18px; /* Reduced from 25px */
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        font-size: 0.8rem; /* Reduced from 0.95rem */
    }
}

@keyframes subtleShine {
    0% { transform: rotate(45deg) translateX(-50%); opacity: 0.8; }
    50% { transform: rotate(45deg) translateX(50%); opacity: 0.6; }
    100% { transform: rotate(45deg) translateX(-50%); opacity: 0.8; }
}

@keyframes slideInUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>

<div class="receipt-container">
    <div class="receipt-card">
        <div class="receipt-header">
            <h2>Order Summary</h2>
            <p>Order #{{ $orders->order_number }}</p>
        </div>
        <div class="receipt-body">
            @if(session('success'))
                <div class="alert-fancy alert-success-fancy">
                    <span>{{ session('success') }}</span>
                    <button type="button" class="close-btn-fancy" aria-label="Close">&times;</button>
                </div>
            @endif
            @if(session('info'))
                <div class="alert-fancy alert-info-fancy">
                    <span>{{ session('info') }}</span>
                    <button type="button" class="close-btn-fancy" aria-label="Close">&times;</button>
                </div>
            @endif

            <div class="detail-section">
                <div class="detail-item">
                    <p class="detail-label">Customer Name</p>
                    <h5 class="detail-value">{{ $orders->customer->name }}</h5>
                </div>
                <div class="detail-item">
                    <p class="detail-label">Payment Status</p>
                    @if($orders->payment_status === 'paid')
                        <span class="payment-status-badge badge-paid-style">Paid</span>
                    @else
                        <span class="payment-status-badge badge-pending-style">Pending</span>
                    @endif
                </div>
            </div>

            <div class="summary-values-grid">
                <div class="summary-cell">
                    <p class="summary-cell-label">Subtotal</p>
                    <h6 class="summary-cell-value">Rp{{ number_format($orders->subtotal_amount, 0, ',', '.') }}</h6>
                </div>
                <div class="summary-cell">
                    <p class="summary-cell-label">Tax</p>
                    <h6 class="summary-cell-value">Rp{{ number_format($orders->tax_amount, 0, ',', '.') }}</h6>
                </div>
                <div class="summary-cell">
                    <p class="summary-cell-label">Shipping</p>
                    <h6 class="summary-cell-value">Rp{{ number_format($orders->shipping_cost, 0, ',', '.') }}</h6>
                </div>
                <div class="grand-total-section">
                    <p class="grand-total-label">Total Amount</p>
                    <h4 class="grand-total-value">Rp{{ number_format($orders->total_amount, 0, ',', '.') }}</h4>
                </div>
            </div>

            <div class="action-area">
                <div class="courier-display">
                    <p class="detail-label">Courier</p>
                    <h5 class="detail-value">{{ $orders->courier ? $orders->courier->name : 'N/A' }}</h5>
                </div>
                <div class="payment-action-area">
                    @if($orders->payment_status !== 'paid')
                        <button id="pay-button" class="payment-cta-button">Pay Now</button>
                    @else
                        <span class="payment-done-msg">Payment Done! <i class="bi bi-check-circle-fill"></i></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="receipt-footer">
            <small>Thank you for choosing our supplements!</small>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logika untuk menutup alert messages
        document.querySelectorAll('.alert-fancy .close-btn-fancy').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.alert-fancy').style.display = 'none';
            });
        });

        const payButton = document.getElementById("pay-button");
        if (payButton) {
            payButton.addEventListener("click", function () {
                snap.pay("{{ $snapToken }}", {
                    onSuccess: function (result) {
                        alert("Pembayaran berhasil! Memperbarui status pesanan...");

                        fetch('{{ route("transactions.notification") }}', {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                            body: JSON.stringify({
                                order_id: "{{ $orders->order_number }}",
                                transaction_status: "settlement", // Asumsi 'settlement' berarti lunas
                            }),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            console.log("Respon Webhook:", data);
                            if (data.status === "success") {
                                alert("Status pembayaran berhasil diperbarui! Mengarahkan Anda kembali...");
                                window.location.href = "{{ route('supplements.index') }}"; // Redirect ke dashboard atau halaman utama
                            } else {
                                alert("Gagal memperbarui status pembayaran. Mohon periksa log server atau hubungi dukungan.");
                            }
                        })
                        .catch((error) => {
                            console.error("Error memanggil webhook:", error);
                            alert("Terjadi kesalahan saat memperbarui status pembayaran. Mohon coba lagi.");
                        });
                    },

                    onPending: function (result) {
                        alert("Pembayaran tertunda. Mohon selesaikan pembayaran Anda.");
                        console.log(result);
                    },

                    onError: function (result) {
                        alert("Pembayaran gagal. Mohon coba lagi.");
                        console.log(result);
                    },

                    onClose: function () {
                        alert("Anda menutup jendela pembayaran tanpa menyelesaikan pembayaran.");
                    },
                });
            });
        }
    });
</script>
@endsection