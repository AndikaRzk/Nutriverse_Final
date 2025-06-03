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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap item dalam pesanan
            // Foreign Key ke tabel orders, menandakan pesanan mana item ini berada
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade'); // Jika pesanan dihapus, itemnya juga dihapus
            // Foreign Key ke tabel supplements, menandakan suplemen apa yang dibeli
            $table->foreignId('supplement_id')
                  ->constrained('supplements')
                  ->onDelete('cascade'); // Jika suplemen dihapus, itemnya di order tetap terhubung jika tidak ada constraint 'restrict'
            $table->integer('quantity'); // Jumlah suplemen yang dibeli
            $table->decimal('price_at_purchase', 10, 2); // Harga suplemen saat pembelian (penting untuk riwayat jika harga berubah)
            $table->timestamps(); // `created_at` dan `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
