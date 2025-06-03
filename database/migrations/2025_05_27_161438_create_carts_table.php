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
        Schema::create('carts', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap keranjang
            // Foreign Key ke tabel customers, menandakan pemilik keranjang
            $table->foreignId('customer_id')
                ->constrained('customers')
                ->onDelete('cascade'); // Jika pelanggan dihapus, keranjangnya juga dihapus
            $table->timestamps(); // `created_at` dan `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
