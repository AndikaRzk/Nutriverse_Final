@extends('layouts.layout')

@section('content')

<style>
    /* Google Fonts for a distinct modern feel */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800&display=swap');


    /* Kontainer utama yang lebih besar dan mewah */
    .receipt-container {
        max-width: 850px; /* Lebar lebih lega */
        width: 100%;
        margin: 40px auto;
        padding: 0 25px;
        box-sizing: border-box;
    }

    /* Kartu struk pesanan */
    .receipt-card {
        background-color: #ffffff;
        border-radius: 30px; /* Sudut sangat membulat */
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.18); /* Bayangan dalam, kuat, tapi halus */
        overflow: hidden;
        transition: all 0.4s ease-in-out; /* Transisi untuk interaktivitas */
        border: 1px solid rgba(255, 255, 255, 0.6); /* Sedikit border putih untuk efek glossy */
        backdrop-filter: blur(5px); /* Efek blur pada background jika ada konten di belakang */
        /* --- PERBAIKAN DI SINI --- */
        display: flex;
        flex-direction: column;
        /* --- AKHIR PERBAIKAN --- */
    }

    .receipt-card:hover {
        transform: translateY(-8px) scale(1.005); /* Efek melayang dan sedikit membesar saat hover */
        box-shadow: 0 45px 100px rgba(0, 0, 0, 0.25); /* Bayangan lebih kuat saat hover */
    }

    /* Header kartu */
    .receipt-header {
        background: linear-gradient(to right, #4CAF50, #66BB6A); /* Gradien hijau yang mewah */
        color: white;
        text-align: center;
        padding: 50px 40px; /* Padding sangat lega */
        position: relative;
        overflow: hidden;
        border-top-left-radius: 30px;
        border-top-right-radius: 30px;
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
        animation: subtleShine 8s infinite ease-in-out; /* Animasi shine halus */
    }

    .receipt-header h2 {
        font-family: 'Playfair Display', serif; /* Font serif yang elegan untuk judul */
        font-size: 4.5rem; /* Ukuran sangat-sangat besar untuk judul */
        font-weight: 800;
        margin-bottom: 10px;
        letter-spacing: -2px; /* Lebih padat */
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Bayangan teks yang dalam */
    }

    .receipt-header p {
        font-size: 1.8rem; /* Ukuran nomor pesanan yang sangat besar */
        opacity: 0.95;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    /* Body kartu */
    .receipt-body {
        padding: 45px 60px; /* Padding sangat lega */
        /* --- PERBAIKAN DI SINI --- */
        flex-grow: 1; /* Biarkan body mengambil sisa ruang yang tersedia */
        /* --- AKHIR PERBAIKAN --- */
    }

    /* Gaya alert yang disempurnakan */
    .alert-fancy {
        padding: 20px 30px;
        border-radius: 15px;
        margin-bottom: 35px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 500;
        font-size: 1.25rem; /* Ukuran teks alert yang besar */
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        border: none; /* Hilangkan border bawaan */
        animation: slideInUp 0.5s ease-out; /* Animasi masuk */
    }

    .alert-success-fancy {
        background-color: #d4edda;
        color: #1a5e2a; /* Hijau lebih gelap */
    }

    .alert-info-fancy {
        background-color: #d1ecf1;
        color: #0d5c63; /* Biru toska lebih gelap */
    }

    .alert-fancy .close-btn-fancy {
        background: none;
        border: none;
        font-size: 2.2rem; /* Ukuran tombol close yang sangat besar */
        cursor: pointer;
        color: inherit;
        opacity: 0.7;
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .alert-fancy .close-btn-fancy:hover {
        opacity: 1;
        transform: rotate(90deg); /* Efek putar saat hover */
    }

    /* Bagian info umum */
    .detail-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 40px;
        padding-bottom: 30px;
        border-bottom: 1px dashed #e0e0e0; /* Garis putus-putus modern */
    }

    .detail-item {
        flex: 1;
        padding-right: 20px; /* Spasi antar item */
    }
    .detail-item:last-child {
        padding-right: 0;
        text-align: right;
    }

    .detail-label {
        font-size: 1.2rem; /* Ukuran label yang besar */
        color: #6c757d;
        margin-bottom: 10px;
        font-weight: 400;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 1.8rem; /* Ukuran nilai yang sangat besar */
        font-weight: 600;
        color: #212529;
    }

    /* Grid ringkasan biaya */
    .summary-values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); /* Lebih lebar */
        gap: 35px; /* Jarak antar kolom lebih besar */
        text-align: center;
        margin-bottom: 50px;
        padding-bottom: 40px;
        border-bottom: 2px solid #e9ecef; /* Garis pemisah lebih tebal */
    }

    .summary-cell {
        padding: 15px 0;
        background-color: #f8f9fa; /* Latar belakang lembut untuk setiap item */
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); /* Bayangan lembut */
    }

    .summary-cell-label {
        font-size: 1.15rem; /* Ukuran label ringkasan */
        color: #6c757d;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .summary-cell-value {
        font-size: 1.6rem; /* Ukuran nilai ringkasan yang besar */
        font-weight: 700;
        color: #34495e; /* Biru gelap yang elegan */
    }

    /* Total amount yang paling menonjol */
    .grand-total-section {
        grid-column: 1 / -1; /* Mengambil seluruh lebar grid */
        margin-top: 30px;
        padding: 25px 0;
        background-color: #f0fdf4; /* Latar belakang hijau sangat muda */
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.1);
        text-align: center;
    }

    .grand-total-label {
        font-size: 1.3rem;
        color: #28a745;
        font-weight: 600;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .grand-total-value {
        font-family: 'Playfair Display', serif; /* Font elegan untuk total */
        font-size: 5.5rem; /* Ukuran sangat-sangat-sangat besar untuk total */
        font-weight: 900;
        color: #1c743e; /* Hijau gelap yang kaya */
        letter-spacing: -3px;
        text-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); /* Bayangan teks yang menonjol */
        line-height: 1; /* Atur line height */
    }

    /* Badges untuk status pembayaran */
    .payment-status-badge {
        font-size: 1.3rem; /* Ukuran badge sangat besar */
        padding: 12px 25px;
        border-radius: 50px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .badge-paid-style {
        background-color: #d4edda;
        color: #1c743e; /* Hijau gelap */
    }

    .badge-pending-style {
        background-color: #ffeeba;
        color: #856404; /* Kuning gelap */
    }

    /* Bagian courier dan tombol pembayaran */
    .action-area {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 30px;
    }

    .courier-display .detail-label {
        margin-bottom: 8px;
    }

    .courier-display .detail-value {
        font-size: 1.8rem;
    }

    .payment-cta-button {
        background: linear-gradient(to right, #28a745, #3CB371); /* Gradien untuk tombol */
        color: white;
        padding: 20px 45px; /* Padding sangat besar untuk tombol */
        border: none;
        border-radius: 50px;
        font-size: 1.6rem; /* Ukuran teks tombol yang sangat besar */
        font-weight: 700;
        cursor: pointer;
        transition: all 0.4s ease;
        box-shadow: 0 12px 35px rgba(40, 167, 69, 0.5); /* Bayangan yang sangat kuat */
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .payment-cta-button:hover {
        transform: translateY(-6px); /* Efek melayang lebih dramatis */
        box-shadow: 0 18px 50px rgba(40, 167, 69, 0.6);
        background: linear-gradient(to right, #218838, #36a265); /* Gradien sedikit berubah */
    }

    .payment-done-msg {
        color: #1c743e; /* Hijau gelap */
        font-weight: 700;
        font-size: 1.7rem; /* Ukuran teks "Payment Done" yang sangat besar */
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 15px;
    }

    .payment-done-msg .bi-check-circle-fill {
        font-size: 2.5rem; /* Ukuran ikon cek yang sangat-sangat besar */
        color: #28a745;
    }

    /* Footer kartu */
    .receipt-footer {
        background-color: #f8f9fa;
        text-align: center;
        color: #6c757d;
        padding: 30px 40px;
        border-bottom-left-radius: 30px;
        border-bottom-right-radius: 30px;
        font-size: 1.1rem; /* Ukuran teks footer yang lebih besar */
        font-weight: 300;
    }

    /* Responsivitas yang sangat baik */
    @media (max-width: 992px) {
        .receipt-container {
            max-width: 700px;
        }
        .receipt-header h2 {
            font-size: 3.5rem;
        }
        .receipt-header p {
            font-size: 1.5rem;
        }
        .receipt-body {
            padding: 35px 40px;
        }
        .detail-value {
            font-size: 1.6rem;
        }
        .summary-cell-value {
            font-size: 1.4rem;
        }
        .grand-total-value {
            font-size: 4.5rem;
        }
        .payment-status-badge {
            font-size: 1.1rem;
        }
        .payment-cta-button {
            padding: 18px 35px;
            font-size: 1.4rem;
        }
        .payment-done-msg {
            font-size: 1.5rem;
        }
        .payment-done-msg .bi-check-circle-fill {
            font-size: 2.2rem;
        }
    }

    @media (max-width: 768px) {
        .receipt-container {
            margin: 20px auto;
            padding: 0 15px;
        }
        .receipt-card {
            border-radius: 20px;
        }
        .receipt-header {
            padding: 40px 25px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }
        .receipt-header h2 {
            font-size: 2.8rem;
            letter-spacing: -1px;
        }
        .receipt-header p {
            font-size: 1.3rem;
        }
        .receipt-body {
            padding: 30px 25px;
        }
        .alert-fancy {
            font-size: 1.1rem;
            padding: 15px 20px;
        }
        .alert-fancy .close-btn-fancy {
            font-size: 1.8rem;
        }
        .detail-section {
            flex-direction: column;
            gap: 25px;
        }
        .detail-item:last-child {
            text-align: left;
        }
        .detail-label {
            font-size: 1.05rem;
        }
        .detail-value {
            font-size: 1.5rem;
        }
        .summary-values-grid {
            grid-template-columns: 1fr 1fr; /* 2 kolom di HP */
            gap: 25px;
        }
        .summary-cell-label {
            font-size: 1rem;
        }
        .summary-cell-value {
            font-size: 1.3rem;
        }
        .grand-total-value {
            font-size: 3.8rem;
        }
        .action-area {
            flex-direction: column;
            align-items: center;
            gap: 25px;
        }
        .payment-cta-button {
            width: 100%;
            padding: 15px 25px;
            font-size: 1.25rem;
        }
        .payment-done-msg {
            font-size: 1.4rem;
            justify-content: center;
        }
        .payment-done-msg .bi-check-circle-fill {
            font-size: 2rem;
        }
        .receipt-footer {
            padding: 25px 25px;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            font-size: 0.95rem;
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