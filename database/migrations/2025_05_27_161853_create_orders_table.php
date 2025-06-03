<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap pesanan

            // Foreign Key ke tabel customers
            $table->foreignId('customer_id')
                ->constrained('customers')
                ->onDelete('cascade'); // Jika customer dihapus, ordernya juga dihapus

            $table->string('order_number')->unique(); // Nomor pesanan unik (penting untuk referensi dan Midtrans)

            // Informasi Harga (Detail Finansial)
            $table->decimal('subtotal_amount', 10, 2); // Total harga suplemen sebelum pajak & biaya kurir
            $table->decimal('tax_amount', 10, 2)->default(0); // Jumlah pajak (11%) yang dikenakan pada pesanan
            $table->decimal('shipping_cost', 10, 2)->default(0); // Biaya pengiriman yang dibebankan kepada pelanggan
            $table->decimal('courier_commission_amount', 10, 2)->default(0); // Komisi yang akan diterima kurir (10% dari subtotal_amount)
            $table->decimal('total_amount', 10, 2); // Total harga akhir yang harus dibayar pelanggan (subtotal + pajak + shipping_cost)

            // Status Pembayaran (untuk integrasi Midtrans)
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending'); // Status pembayaran dari Midtrans
            $table->string('payment_gateway_ref')->nullable(); // ID referensi dari Midtrans (untuk verifikasi transaksi)

            // Informasi Pengiriman (bisa dipilih dari alamat pelanggan atau input baru)
            $table->string('delivery_address'); // Alamat pengiriman aktual untuk pesanan ini
            $table->string('delivery_phone'); // Nomor telepon pengiriman aktual

            $table->text('notes')->nullable(); // Catatan tambahan dari pelanggan untuk pesanan

            // Status Pesanan Keseluruhan (untuk melacak progress order)
            $table->enum('order_status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');

            // Foreign Key ke tabel couriers (Kurir yang ditugaskan untuk pesanan ini)
            $table->foreignId('courier_id')
                ->nullable() // Bisa null jika kurir belum ditugaskan
                ->constrained('couriers')
                ->onDelete('set null'); // Jika kurir dihapus, ordernya tetap ada tapi courier_id jadi null

            $table->timestamps(); // `created_at` dan `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
