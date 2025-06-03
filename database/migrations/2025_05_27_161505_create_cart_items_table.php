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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap item di keranjang
            // Foreign Key ke tabel carts, menandakan keranjang mana item ini berada
            $table->foreignId('cart_id')
                ->constrained('carts')
                ->onDelete('cascade'); // Jika keranjang dihapus, itemnya juga dihapus
            // Foreign Key ke tabel supplements, menandakan suplemen apa yang ada
            $table->foreignId('supplement_id')
                ->constrained('supplements')
                ->onDelete('cascade'); // Jika suplemen dihapus, itemnya juga dihapus dari keranjang
            $table->integer('quantity'); // Jumlah suplemen dalam keranjang
            $table->timestamps(); // `created_at` dan `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
