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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap pengiriman
            // Foreign Key ke tabel orders (satu pesanan hanya punya satu proses pengiriman)
            $table->foreignId('order_id')
                  ->unique() // Memastikan hanya ada satu entri pengiriman per pesanan
                  ->constrained('orders')
                  ->onDelete('cascade'); // Jika pesanan dihapus, detail pengirimannya juga dihapus
            // Foreign Key ke tabel couriers, menandakan kurir yang menangani pengiriman ini
            $table->foreignId('courier_id')
                  ->constrained('couriers')
                  ->onDelete('cascade'); // Jika kurir dihapus, pengiriman yang ditanganinya juga dihapus (sesuaikan jika ingin 'set null')
            $table->enum('delivery_status', ['assigned', 'picking_up', 'on_the_way', 'delivered', 'failed'])->default('assigned'); // Status pengiriman (untuk kurir dan pelanggan)
            $table->timestamp('pickup_at')->nullable(); // Waktu kurir mengambil barang dari lokasi
            $table->timestamp('delivered_at')->nullable(); // Waktu barang berhasil sampai ke pelanggan
            $table->text('delivery_notes')->nullable(); // Catatan tambahan dari kurir terkait pengiriman
            $table->string('proof_of_delivery_image')->nullable(); // Path atau URL foto bukti pengiriman oleh kurir
            $table->timestamps(); // `created_at` dan `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
